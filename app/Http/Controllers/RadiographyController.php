<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

use App\Http\Requests\RadiographyRequest;
use App\Services\ImageFilterService;
use App\Models\Radiography;

use Barryvdh\DomPDF\Facade\Pdf;
use Imagick;

class RadiographyController extends Controller
{
    protected $imageFilterService;

    public function __construct(ImageFilterService $imageFilterService)
    {
        $this->imageFilterService = $imageFilterService;
    }
    public function index():View{
        $radiographies = Radiography::get();
        return view('radiography.index', compact('radiographies'));
    }
    public function new():View{
        return view('radiography.newradiography');
    }
    public function create():View{
        return view('radiography.create');
    }
    public function show(Radiography $radiography):View{
        return view('radiography.show', compact('radiography'));
    }
    public function tool(Radiography $radiography):View{
        return view('radiography.tool', compact('radiography'));
    }
    public function measurements(Radiography $radiography):View{
        return view('radiography.measurements', compact('radiography'));
    }
    public function store(RadiographyRequest $request):RedirectResponse{
        $dicomFile = $request->file('radiography_file');
        $dicomFileName = time() . '.' . $dicomFile->getClientOriginalExtension();
        $dicomFilePath = $dicomFile->storeAs('public/radiographies', $dicomFileName);

        $dicomPath = storage_path('app/public/radiographies/' . $dicomFileName);
        $imagick = new Imagick();
        $imagick->readImage($dicomPath);
        $imagick->setImageFormat('jpg');
        $imagick->setImageCompressionQuality(95);
        $jpgFileName = time() . '.jpg';
        $jpgFilePath = storage_path('app/public/radiographies/' . $jpgFileName);
        $imagick->writeImage($jpgFilePath);
        $imagick->destroy();

        $radiography=new Radiography;
        $radiography->name_patient=$request->name_patient;
        $radiography->ci_patient=$request->ci_patient;
        $radiography->radiography_id=$request->radiography_id;
        $radiography->radiography_date=$request->radiography_date;
        $radiography->radiography_type=$request->radiography_type;
        $radiography->radiography_uri=$jpgFileName;
        $radiography->radiography_dicom_uri=$dicomFileName;
        $radiography->radiography_doctor=$request->radiography_doctor;
        $radiography->radiography_charge=$request->radiography_charge;
        $radiography->save();

        return redirect()->route('radiography.index')->with('success','Radiografia creada');
    }
    public function report(Radiography $radiography):View{
        return view('radiography.report', compact('radiography'));
    }
    public function datareport(Request $request){
        session()->flash('findings', $request->input('findings'));
        session()->flash('diagnosis', $request->input('diagnosis'));
        session()->flash('recommendations', $request->input('recommendations'));
        session()->flash('conclusions', $request->input('conclusions'));
        return redirect()->route('radiography.pdfreport');
    }
    public function pdfreport(Radiography $radiography){
        $patient = $radiography->patient;
        $data=[
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
            'findings' => request('findings'),
            'diagnosis' => request('diagnosis'),
            'recommendations' => request('recommendations'),
            'conclusions' => request('conclusions'),
        ];
        $pdf = Pdf::loadView('radiography.pdfreport', ['data'=>$data]);
        return $pdf->download($radiography->name_patient. "_" . $radiography->ci_patient . "_" .$radiography->radiography_id . '_reporte.pdf');
    }
    public function search(Request $request) {
        $search = $request->input('search');
        $radiographies = Radiography::where('name_patient', 'LIKE', '%' . $search . '%')
                ->orWhere('radiography_id', 'LIKE', '%' . $search . '%')
                ->orWhere('ci_patient', 'LIKE', '%' . $search . '%')->get();
        return view('radiography.search', compact('radiographies'));
    }
}
