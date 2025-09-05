<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use RecursiveIteratorIterator;
use RecursiveDirectoryIterator;
use App\Models\Dicom;
use App\Models\Patient;
use ZipArchive;

class ConnectionController extends Controller
{
    public function index(){
        try {
            $response = Http::withBasicAuth('orthanc', 'orthanc')
                ->get('http://localhost:8042/studies');
            
            //$studies = $response->json();
            $studiesIds = $response->json();
            $studies = [];

            foreach ($studiesIds as $id) {
            $studyResponse = Http::withBasicAuth('orthanc', 'orthanc')
                ->get("http://localhost:8042/studies/{$id}");

            if ($studyResponse->successful()) {
                $study = $studyResponse->json();

                $studies[] = [
                    'id'          => $id,
                    'date'        => $study['MainDicomTags']['StudyDate'] ?? 'N/A',
                    'patient'     => $study['PatientMainDicomTags']['PatientName'] ?? 'N/A',
                    'institution' => $study['MainDicomTags']['InstitutionName'] ?? 'N/A',
                    'description' => $study['MainDicomTags']['StudyDescription'] ?? 'N/A',
                ];
            }
        }
        } catch (\Exception $e) {
            $studies = null;
        }
        return view('connection.index', compact('studies'));
    }
    public function verify($id){ 
        try { 
            $study = Http::withBasicAuth('orthanc', 'orthanc') 
                ->get("http://localhost:8042/studies/$id") ->json();
            $zipResponse = Http::withBasicAuth('orthanc', 'orthanc') 
                ->get("http://localhost:8042/studies/$id/archive");

            if (!$zipResponse->successful()) {
                return back()->with('error', 'No se pudo descargar el ZIP del estudio.');
            }

            $zipPath = storage_path("app/public/$id.zip");
            file_put_contents($zipPath, $zipResponse->body());

            $extractPath = storage_path("app/public/dicoms/$id");

            if (File::exists($extractPath)) {
                File::deleteDirectory($extractPath);
            }

            File::makeDirectory($extractPath, 0775, true, true);

            $zip = new \ZipArchive;
            if ($zip->open($zipPath) === true){
                $zip->extractTo($extractPath);
                $zip->close();
            } else {
                return back()->with('error', 'No se pudo extraer el ZIP.');
            }

            $dicomFiles = $this->findAllDicoms($extractPath); 
            $dicomList = collect($dicomFiles)->map(function ($path) { 
                return [ 'name' => basename($path), 
                'relative' => Str::after($path, storage_path('app/public') . DIRECTORY_SEPARATOR), ]; 
            }); 

            if ($dicomList->count() === 1) {
                return $this->sendRadiography($id);    
            } elseif ($dicomList->count() > 1) {
                return $this->sendTomography($id);
            } else {
                return back()->with('error', 'No se encontraron archivos DICOM en el estudio.');
            }
        } catch (\Exception $e) {
            return back()->with('error', 'Ocurrió un error: ' . $e->getMessage());
        }
    }

    public function sendRadiography($id){

        $extractPath = storage_path("app/public/dicoms");

        $dicomFiles = $this->findAllDicoms($extractPath);
        if (empty($dicomFiles)) {
            return back()->with('error', 'No se encontraron archivos DICOM.');
        }

        $dicomFile = $dicomFiles[0]; 
        $fileName = pathinfo($dicomFile, PATHINFO_FILENAME);

        $dataScript = 'C:\Users\Gustavo\Desktop\CareRadiologyProject\careradiology\data.py';
        $dataCommand = "python \"$dataScript\" " . escapeshellarg($dicomFile);
        $output = shell_exec($dataCommand);
        $dicomData = json_decode($output, true);

        $radiographyId = $dicomData['sop_instance_uid'] 
            ?? $dicomData['study_instance_uid'] 
            ?? uniqid('rad_');

        $newBaseName = $radiographyId;
        $newDicomPath = $extractPath . DIRECTORY_SEPARATOR . $newBaseName;
        rename($dicomFile, $newDicomPath);

        $processScript = 'C:\Users\Gustavo\Desktop\CareRadiologyProject\careradiology\procesar_archivo.py';
        $processCommand = "python \"$processScript\" \"" . $newDicomPath . "\"";
        shell_exec($processCommand);

        $pngPath = $extractPath . DIRECTORY_SEPARATOR . $radiographyId . ".png";
        $imageUrl = Storage::url("dicoms/" . basename($pngPath));

        session([
            'dicom_data' => $dicomData,
            'image_url' => $imageUrl,
            'file_name' => $newBaseName,
        ]);

        $patients = Patient::all();
        return view('dicom.show', [
            'imageUrl' => $imageUrl,
            'dicomData' => $dicomData,
            'patients' => $patients,
        ]);
    }

    public function sendTomography($id){
        $basePath = "C:\\Users\\Gustavo\\Desktop\\CareRadiologyProject\\careradiology\\public\\storage\\dicoms";
        $folderPath = $basePath . DIRECTORY_SEPARATOR . $id;

        if (!is_dir($folderPath)) {
            mkdir($folderPath, 0777, true);
        }
        $dicomFolderPath = null;

        $iterator = new \RecursiveIteratorIterator(
            new \RecursiveDirectoryIterator($folderPath),
            \RecursiveIteratorIterator::SELF_FIRST
        );

        foreach ($iterator as $file) {
            if ($file->isDir()) {
                $filesInDir = glob($file->getRealPath() . DIRECTORY_SEPARATOR . '*.dcm');
                if (!empty($filesInDir)) {
                    $dicomFolderPath = $file->getRealPath();
                    break;
                }
            }
        }

        if (!$dicomFolderPath) {
            return back()->with('error', 'No se encontró la carpeta que contiene los archivos DICOM.');
        }

        $dicomFiles = $this->findAllDicoms($dicomFolderPath);

        if (empty($dicomFiles)) {
            return back()->with('error', 'No se encontraron archivos DICOM en la carpeta encontrada.');
        }

        $folderName = "dicom_" . time();
        $folderPath = storage_path("app/public/dicoms/$folderName");

        File::makeDirectory($folderPath, 0755, true);
        session(['tomography_folder_path' => $folderPath]);
        session(['tomography_folder_name' => $folderName]);

        $dicomFiles = $this->findAllDicoms($dicomFolderPath);
        $firstFilePath = null;

        foreach ($dicomFiles as $index => $filePath) {
            $fileName = pathinfo($filePath, PATHINFO_BASENAME);
            $destination = $folderPath . DIRECTORY_SEPARATOR . $fileName;
            rename($filePath, $destination);

            if ($index === 0) {
                $firstFilePath = $destination;
            }
        }
        $pythonScript = 'C:\Users\Gustavo\Desktop\CareRadiologyProject\careradiology\procesar_carpeta.py';
        $command = "python \"$pythonScript\" \"$folderPath\"";
        shell_exec($command);

        $folderUrl = Storage::url("dicoms/$folderName");

        $dicomData = null;
        if ($firstFilePath) {
            $dataScript = 'C:\Users\Gustavo\Desktop\CareRadiologyProject\careradiology\data.py';
            $dataCommand = "python \"$dataScript\" " . escapeshellarg($firstFilePath);
            $output = shell_exec($dataCommand);
            $dicomData = json_decode($output, true);
        }

        Dicom::create([
            'file_name' => $folderName,
            'image_url' => $folderUrl,
            'patient_name' => $dicomData['patient_name'] ?? 'Desconocido',
            'patient_id' => $dicomData['patient_id'] ?? 'Desconocido',
            'modality' => $dicomData['modality'] ?? 'N/A',
            'study_date' => $dicomData['study_date'] ?? 'N/A',
            'rows' => $dicomData['rows'] ?? 0,
            'columns' => $dicomData['columns'] ?? 0,
            'metadata' => isset($dicomData['dicom_info']) ? json_encode($dicomData['dicom_info']) : null
        ]);
        
            $patients = Patient::all();

        return view('dicom.confirmFolder', [
            'dicomRecord' => $dicomData,
            'folderName' => $folderName,
            'patients' => $patients
        ]);
    }

    public function downloadStudy($id){
        try {
            $zipResponse = Http::withBasicAuth('orthanc', 'orthanc')
                ->get("http://localhost:8042/studies/$id/archive");

            if (!$zipResponse->successful()) {
                return back()->with('error', 'No se pudo descargar el ZIP del estudio.');
            }

            $zipPath = storage_path("app/public/dicoms/$id.zip");
            file_put_contents($zipPath, $zipResponse->body());

            return response()->download($zipPath, $id . '.zip')->deleteFileAfterSend(true);

        } catch (\Exception $e) {
            return back()->with('error', 'Ocurrió un error al descargar el estudio: ' . $e->getMessage());
        }
    }
    
    public function check(){
        try {
            $response = Http::withBasicAuth('orthanc', 'orthanc')
                ->timeout(5)
                ->get('http://localhost:8042/system');

            if ($response->successful()) {
                return response()->json(['status' => 'connected']);
            } else {
                return response()->json(['status' => 'disconnected']);
            }
        } catch (\Exception $e) {
            return response()->json(['status' => 'disconnected']);
        }
    }

    private function findAllDicoms(string $root): array{
        $found = [];
        $iterator = new \RecursiveIteratorIterator(
            new \RecursiveDirectoryIterator($root, \FilesystemIterator::SKIP_DOTS)
        );
        foreach ($iterator as $fileInfo) {
            if (!$fileInfo->isFile()) continue;

            $path = $fileInfo->getPathname();
            $ext  = strtolower($fileInfo->getExtension());

            if ($ext === 'dcm' || $this->looksLikeDicom($path)) {
                $found[] = $path;
            }
        }
        return $found;
    }

    private function looksLikeDicom(string $path): bool{
        $h = @fopen($path, 'rb');
        
        if ($h === false) return false;
        $bytes = fread($h, 132);
        fclose($h);

        if ($bytes === false || strlen($bytes) < 132) return false;
        return substr($bytes, 128, 4) === "DICM";
    }
}
