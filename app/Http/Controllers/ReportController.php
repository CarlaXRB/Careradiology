<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Radiography;
use App\Models\Tomography;
use App\Models\Report;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Auth;

class ReportController extends Controller
{
    public function pdfreport(Request $request){
        $radiography = Radiography::with('patient')->findOrFail($request->input('radiography_id'));
        $patient = $radiography->patient;

    $data = [
        'name_patient' => $patient->name_patient ?? $radiography->name_patient ?? 'No registrado',
        'ci_patient' => $patient->ci_patient ?? $radiography->ci_patient ?? 'No registrado',
        'birth_date' => $patient->birth_date ?? 'No disponible',
        'gender' => $patient->gender ?? 'No disponible',
        'insurance_code' => $patient->insurance_code ?? 'No disponible',
        'patient_contact' => $patient->patient_contact ?? 'No disponible',
        'family_contact' => $patient->family_contact ?? 'No disponible',
        'radiography_id' => $radiography->radiography_id,
        'radiography_date' => $radiography->radiography_date,
        'radiography_type' => $radiography->radiography_type,
        'radiography_doctor' => $radiography->radiography_doctor,
        'radiography_charge' => $radiography->radiography_charge,
        'findings' => $request->input('findings'),
        'diagnosis' => $request->input('diagnosis'),
        'recommendations' => $request->input('recommendations'),
        'conclusions' => $request->input('conclusions'),
    ];

        $report = new Report();
        $report->ci_patient = $data['ci_patient'];
        $report->study_id = $radiography->radiography_id;
        $report->study_date = now();
        $report->created_by = Auth::user()->email;
        $report->study_uri = '';
        $report->save();

        $downloadName = $data['name_patient'] . "_" . $data['ci_patient'] . "_" . $data['study_id'] . '_reporte.pdf';
        $downloadName = str_replace(' ', '_', $downloadName);

        $internalFileName = $report->id . '.pdf';
        $relativePath = 'reports/' . $internalFileName;
        $savePath = public_path('storage/' . $relativePath);

        $imagePath = storage_path('app/public/radiographies/' . $radiography->radiography_uri);
        $imageExists = file_exists($imagePath) && exif_imagetype($imagePath);

    $pdf = \PDF::loadView('report.pdfreport', [
        'data' => $data,
        'imagePath' => $imageExists ? $imagePath : null,
    ]);
        $pdf->save($savePath);
        $report->study_uri = $relativePath;
        $report->save();
        return response()->download($savePath, $downloadName);
    }
    public function show($id){
        $report = Report::findOrFail($id);
        $filePath = public_path('storage/' . $report->study_uri);
        if (!file_exists($filePath)) {
            abort(404, 'Archivo no encontrado.');
        }
        return response()->file($filePath, [
            'Content-Type' => 'application/pdf',
        ]);
    }
}
