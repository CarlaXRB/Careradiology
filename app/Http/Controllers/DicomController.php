<?php

namespace App\Http\Controllers;

use App\Models\Dicom;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;

class DicomController extends Controller
{
    public function uploadFormRadiography()
    {
        return view('dicom.uploadRadiography');
    }
    public function uploadFormTomography()
    {
        return view('dicom.uploadTomography');
    }

    public function processDicom(Request $request)
    {
        $request->validate([
            'file' => 'required|file'
        ]);

        $file = $request->file('file');
        $fileName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
        $filePath = $file->storeAs('public/dicoms', $fileName);

        // Ejecutar el script de procesamiento de imagen
        $pythonScript = 'C:\Users\Gustavo\Desktop\CareRadiologyProject\careradiology\procesar_archivo.py';
        $command = "python \"$pythonScript\" \"" . storage_path("app/public/dicoms/$fileName") . "\"";
        shell_exec($command);

        // Generar URL de la imagen
        $imageUrl = Storage::url("dicoms/{$fileName}.png");

        // Ejecutar el script para extraer datos del DICOM
        $dataScript = 'C:\Users\Gustavo\Desktop\CareRadiologyProject\careradiology\data.py';
        $dataCommand = "python \"$dataScript\" " . escapeshellarg(storage_path("app/public/dicoms/$fileName"));
        $output = shell_exec($dataCommand);
        $dicomData = json_decode($output, true);

        if (isset($dicomData['error'])) {
            return response()->json(['error' => $dicomData['error']], 400);
        }

        Dicom::create([
            'file_name' => $fileName,
            'image_url' => $imageUrl,
            'patient_name' => $dicomData['patient_name'],
            'patient_id' => $dicomData['patient_id'],
            'modality' => $dicomData['modality'],
            'study_date' => $dicomData['study_date'],
            'rows' => $dicomData['rows'],
            'columns' => $dicomData['columns'],
            'metadata' => json_encode($dicomData['dicom_info'])
        ]);

        return view('dicom.show', compact('imageUrl', 'dicomData'));
    }

    public function processFolder(Request $request)
    {
        $request->validate([
            'files' => 'required|array'
        ]);

        $folderName = "dicom_folder_" . time();
        $folderPath = storage_path("app/public/dicoms/$folderName");

        File::makeDirectory($folderPath, 0755, true);

        $firstFilePath = null;

        foreach ($request->file('files') as $index => $file) {
            $fileName = $file->getClientOriginalName();
            $file->move($folderPath, $fileName);

            // Guardamos la ruta del primer archivo para extraer los datos del paciente
            if ($index === 0) {
                $firstFilePath = $folderPath . DIRECTORY_SEPARATOR . $fileName;
            }
        }

        // Procesar la carpeta con el script de Python
        $pythonScript = 'C:\Users\Gustavo\Desktop\CareRadiologyProject\careradiology\procesar_carpeta.py';
        $command = "python \"$pythonScript\" \"$folderPath\"";
        shell_exec($command);

        $folderUrl = Storage::url("dicoms/$folderName");

        // Extraer información del primer archivo DICOM
        $dicomData = null;
        if ($firstFilePath) {
            $dataScript = 'C:\Users\Gustavo\Desktop\CareRadiologyProject\careradiology\data.py';
            $dataCommand = "python \"$dataScript\" " . escapeshellarg($firstFilePath);
            $output = shell_exec($dataCommand);
            $dicomData = json_decode($output, true);
        }

        // Guardar en la base de datos
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

        return response()->json([
            'message' => 'La carpeta se ha procesado correctamente.',
            'folderUrl' => route('dicom.showFolderImages', $folderName),
            'patient_name' => $dicomData['patient_name'] ?? 'Desconocido',
            'patient_id' => $dicomData['patient_id'] ?? 'Desconocido',
            'modality' => $dicomData['modality'] ?? 'N/A',
            'study_date' => $dicomData['study_date'] ?? 'N/A'
        ]);
    }

    public function showFolderImages($folderName)
    {
        $folderPath = storage_path("app/public/dicoms/$folderName");
    
        $images = [];
        foreach (File::files($folderPath) as $file) {
            if ($file->getExtension() === 'png') {
                $images[] = 'storage/dicoms/' . $folderName . '/' . $file->getFilename();  // Aquí concatenamos correctamente las rutas
            }
        }

        // Obtener los datos del paciente de la base de datos
        $dicomRecord = Dicom::where('file_name', $folderName)->first();

        return view('dicom.showFolderImages', compact('images', 'dicomRecord'));
    }

    public function showForm()
    {
        return view('dicom.data');
    }

    public function uploadDicom(Request $request)
    {
        // Validar que se haya subido un archivo
        $request->validate([
            'dicom_file' => 'required|file'  // No importa la extensión, solo verificamos que sea un archivo
        ]);

        // Guardar el archivo temporalmente
        $file = $request->file('dicom_file');
        $filePath = $file->getPathname();  // Obtén la ruta del archivo temporal

        // Comando para ejecutar el script de Python
        $command = "python C:\Users\Gustavo\Desktop\dicom\care\data.py " . escapeshellarg($filePath);
        
        // Ejecutar el comando y capturar la salida
        $output = shell_exec($command);
        
        // Decodificar los datos del DICOM desde la salida del script
        $dicomData = json_decode($output, true);

        // Verificar si hay un error en la salida
        if (isset($dicomData['error'])) {
            return response()->json(['error' => $dicomData['error']], 400);
        }

        $record = Dicom::create([
            'patient_name' => $dicomData['patient_name'],
            'patient_id' => $dicomData['patient_id'],
            'modality' => $dicomData['modality'],
            'study_date' => $dicomData['study_date'],
            'rows' => $dicomData['rows'],
            'columns' => $dicomData['columns'],
            'metadata' => $dicomData['dicom_info'] // Guardamos todos los metadatos en JSON
        ]);
        
        // Retornar la vista con los datos del DICOM
        return view('dicom.data', [
            'dicomInfo' => $dicomData['dicom_info'],
            'patientName' => $dicomData['patient_name'],
            'patientID' => $dicomData['patient_id'],
            'modality' => $dicomData['modality'],
            'studyDate' => $dicomData['study_date'],
            'rows' => $dicomData['rows'],
            'columns' => $dicomData['columns']
        ]);
    }

    public function showRecords()
    {
        $records = Dicom::latest()->get();
        return view('dicom.records', compact('records'));
    }
}
