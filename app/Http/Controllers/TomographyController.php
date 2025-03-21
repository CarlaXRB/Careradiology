<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;

use App\Http\Requests\TomographyRequest;
use App\Models\Tomography;
use Barryvdh\DomPDF\Facade\Pdf;

use Imagick;
use ZipArchive;

class TomographyController extends Controller
{
    public function index():View{
        $tomographies = tomography::get();
        return view('tomography.index', compact('tomographies'));
    }
    public function new():View{
        return view('tomography.newtomography');
    }
    public function create():View{
        return view('tomography.create');
    }
    public function tool(Tomography $tomography):View{
        return view('tomography.tool', compact('tomography'));
    }
    public function measurements(Tomography $tomography):View{
        return view('tomography.measurements', compact('tomography'));
    }
    public function store(TomographyRequest $request): RedirectResponse{
        if ($request->hasFile('tomography_file') && $request->file('tomography_file')->getClientOriginalExtension() == 'zip') {
            $zipFile = $request->file('tomography_file');
            $zipFileName = time() . '.' . $zipFile->getClientOriginalExtension();
            $zipFilePath = $zipFile->storeAs('public/tomographies/zips', $zipFileName);
            $zip = new ZipArchive;
            $zipPath = storage_path('app/public/tomographies/zips/' . $zipFileName);
            $extractPath = storage_path('app/public/tomographies/images/' . pathinfo($zipFileName, PATHINFO_FILENAME));
    
            if ($zip->open($zipPath) === true) {
                $zip->extractTo($extractPath);
                $zip->close();
                $imageDicomUri = 'tomographies/images/' . pathinfo($zipFileName, PATHINFO_FILENAME);
            } else {
                return redirect()->route('tomography.create')->with('error', 'No se pudo abrir el archivo ZIP.');
            }
            $imageUri = 'new';
        } else {
            $dicomFile = $request->file('tomography_file');
            $dicomFileName = time() . '.' . $dicomFile->getClientOriginalExtension();
            $dicomFilePath = $dicomFile->storeAs('public/tomographies', $dicomFileName);
            $imageUri = 'tomographies/' . $dicomFileName;
            $imageDicomUri = $imageUri;
        }
        $tomography = new Tomography();
        $tomography->name_patient = $request->name_patient;
        $tomography->ci_patient = $request->ci_patient;
        $tomography->tomography_id = $request->tomography_id;
        $tomography->tomography_date = $request->tomography_date;
        $tomography->tomography_type = $request->tomography_type;
        $tomography->tomography_dicom_uri = $imageDicomUri;
        $tomography->tomography_uri = $imageUri;
        $tomography->tomography_doctor = $request->tomography_doctor;
        $tomography->tomography_charge = $request->tomography_charge;
        $tomography->save();
    
        return redirect()->route('tomography.convert', ['id' => $tomography->id]);
    }
    public function convert($id){
        $tomography = Tomography::find($id);
        if (!$tomography) {
            return response()->json(['error' => 'Tomografía no encontrada.'], 404);
        }
        $tomography_dicom_uri = $tomography->tomography_dicom_uri;
        $dicomFolderPath = storage_path('app/public/' . $tomography_dicom_uri);

        if (!is_dir($dicomFolderPath)) {
            return response()->json([
            'error' => 'La carpeta especificada no existe.',
            'constructed_path' => $dicomFolderPath,
            'file_exists_check' => file_exists($dicomFolderPath) ? 'file_exists: true' : 'file_exists: false',
        ], 404);
        }

        $jpgFolderPath = storage_path('app/public/tomographies/converted_images/' . $id);

        if (!is_dir($jpgFolderPath)) {
            if (!mkdir($jpgFolderPath, 0777, true)) {
            return response()->json([
                'error' => 'No se pudo crear la carpeta de destino.',
                'constructed_path' => $jpgFolderPath,
            ], 500);
            }
        }

        if (!is_dir($jpgFolderPath)) {
            return response()->json([
            'error' => 'La carpeta de destino no se pudo crear.',
            'constructed_path' => $jpgFolderPath,
        ], 500);
        }

        $tomography->tomography_uri = 'tomographies/converted_images/' . $id;
        $tomography->save();

        $dicomFiles = glob($dicomFolderPath . DIRECTORY_SEPARATOR . '*.dcm');
        if (empty($dicomFiles)) {
            return response()->json(['error' => 'No se encontraron archivos DICOM en la carpeta.'], 404);
        }

        $convertedFiles = [];

        foreach ($dicomFiles as $dicomFilePath) {
            try {
                $imagick = new \Imagick();
                $imagick->readImage($dicomFilePath);
                $imagick->setImageFormat('jpg');

                $jpgFileName = pathinfo($dicomFilePath, PATHINFO_FILENAME) . '.jpg';
                $jpgFilePath = $jpgFolderPath . DIRECTORY_SEPARATOR . $jpgFileName;

                $imagick->writeImage($jpgFilePath);
                $imagick->destroy();

                $convertedFiles[] = $jpgFileName;
            } catch (\Exception $e) {
                return response()->json([
                    'error' => "Error al procesar el archivo {$dicomFilePath}: " . $e->getMessage(),
                ], 500);
            }
        }

        return redirect()->route('tomography.index')->with('success', 'Tomografía creada');
    }
    public function show($id){
        $tomography = Tomography::findOrFail($id);
        $imagePath = storage_path('app/public/tomographies/converted_images/' . $id);

        if (!file_exists($imagePath)) {
            abort(404, 'El directorio de imágenes no existe.');
        }

        $files = scandir($imagePath);
        $images = array_filter($files, function ($file) use ($imagePath) {
            return preg_match('/\.(jpg|jpeg|png)$/i', $file) && is_file($imagePath . '/' . $file);
        });
        sort($images);
        $imageUrls = array_map(function ($image) use ($id) {
            return asset('storage/tomographies/converted_images/' . $id . '/' . $image);
        }, $images);

        return view('tomography.mostrar', [
            'tomography' => $tomography,
            'images' => $imageUrls,
        ]);
    }
    public function showSelectedImage($tomographyId, $image){
        $tomography = Tomography::findOrFail($tomographyId);
        $imagePath = storage_path("app/public/tomographies/converted_images/{$tomographyId}/{$image}");
        if (!file_exists($imagePath)) {
            abort(404, 'Imagen no encontrada');
        }
        return view('tomography.show_image', compact('tomographyId', 'image', 'tomography'));
    }
    public function report(Tomography $tomography):View{
        return view('tomography.report', compact('tomography'));
    }
    public function datareport(Request $request){
        session()->flash('findings', $request->input('findings'));
        session()->flash('diagnosis', $request->input('diagnosis'));
        session()->flash('recommendations', $request->input('recommendations'));
        session()->flash('conclusions', $request->input('conclusions'));
        return redirect()->route('tomography.pdfreport');
    }
    public function pdfreport(Tomography $tomography){
        $patient = $tomography->patient;
        $data=[
            'name_patient' => $patient->name_patient ?? $tomography->name_patient ?? 'No registrado',
            'ci_patient' => $patient->ci_patient ?? $tomography->ci_patient ?? 'No registrado',
            'birth_date' => $patient->birth_date ?? 'No disponible',
            'gender' => $patient->gender ?? 'No disponible',
            'insurance_code' => $patient->insurance_code ?? 'No disponible',
            'patient_contact' => $patient->patient_contact ?? 'No disponible',
            'family_contact' => $patient->family_contact ?? 'No disponible',
            'tomography_id' => $tomography->tomography_id,
            'tomography_date' => $tomography->tomography_date,
            'tomography_type' => $tomography->tomography_type,
            'tomography_doctor' => $tomography->tomography_doctor,
            'tomography_charge' => $tomography->tomography_charge,
            'findings' => request('findings'),
            'diagnosis' => request('diagnosis'),
            'recommendations' => request('recommendations'),
            'conclusions' => request('conclusions'),
        ];
        $pdf = Pdf::loadView('tomography.pdfreport', ['data'=>$data]);
        return $pdf->download($tomography->name_patient. "_" . $tomography->ci_patient . "_" .$tomography->tomography_id . '_reporte.pdf');
    }    
    public function superposicion($id){
        $tomography = Tomography::findOrFail($id);
        $folderPath = storage_path('app/public/tomographies/converted_images/' . $tomography->id);

        $images = [];
        if (is_dir($folderPath)) {
            $files = scandir($folderPath);
            foreach ($files as $file) {
                if (preg_match('/image-\d+\.jpg$/', $file)) {
                    $images[] = asset('storage/tomographies/converted_images/' . $tomography->id . '/' . $file);
                }
            }
        }
        return view('tomography.superposicion', compact('tomography', 'images'));
    }
    public function search(Request $request) {
        $search = $request->input('search');
        $tomographies = Tomography::where('name_patient', 'LIKE', '%' . $search . '%')
                ->orWhere('radiography_id', 'LIKE', '%' . $search . '%')
                ->orWhere('ci_patient', 'LIKE', '%' . $search . '%')->get();
        return view('tomography.search', compact('tomographies'));
    }
}
