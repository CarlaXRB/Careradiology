<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use App\Http\Requests\TomographyRequest;
use App\Models\Tomography;
use Imagick;
use Barryvdh\DomPDF\Facade\Pdf;

class TomographyController extends Controller
{
    public function index():View{
        $tomographies = tomography::get();
        return view('tomography.index', compact('tomographies'));
    }

    public function create():View{
        return view('tomography.create');
    }

    public function show(Tomography $tomography):View{
        return view('tomography.show', compact('tomography'));
    }

    public function tool(Tomography $tomography):View{
        return view('tomography.tool', compact('tomography'));
    }

    public function measurements(Tomography $tomography):View{
        return view('tomography.measurements', compact('tomography'));
    }

    public function store(TomographyRequest $request):RedirectResponse{
        $dicomFile = $request->file('tomography_file');
        $dicomFileName = time() . '.' . $dicomFile->getClientOriginalExtension();
        $dicomFilePath = $dicomFile->storeAs('public/tomographies', $dicomFileName);

        $dicomPath = storage_path('app/public/tomographies/' . $dicomFileName);
        $imagick = new Imagick();
        $imagick->readImage($dicomPath);
        $imagick->setImageFormat('jpg');

        $jpgFileName = time() . '.jpg';
        $jpgFilePath = storage_path('app/public/tomographies/' . $jpgFileName);
        $imagick->writeImage($jpgFilePath);
        $imagick->destroy();

        $tomography=new Tomography;
        $tomography->name_patient=$request->name_patient;
        $tomography->ci_patient=$request->ci_patient;
        $tomography->tomography_id=$request->tomography_id;
        $tomography->tomography_date=$request->tomography_date;
        $tomography->tomography_type=$request->tomography_type;
        $tomography->tomography_uri=$jpgFileName;
        $tomography->tomography_dicom_uri=$dicomFileName;
        $tomography->tomography_doctor=$request->tomography_doctor;
        $tomography->tomography_charge=$request->tomography_charge;
        $tomography->save();

        return redirect()->route('tomography.index')->with('success','Tomografia creada');
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
        return $pdf->download('tomography_report.pdf');
    }
}
