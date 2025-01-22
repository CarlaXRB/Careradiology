<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

use App\Http\Requests\ToolRequest;
use App\Models\Tool;

use Barryvdh\DomPDF\Facade\Pdf;

class ToolController extends Controller
{
    public function index():View{
        $tools = Tool::get();
        return view('tool.index', compact('tools'));
    }
    public function storeRadiography(Request $request, $radiography_id, $ci_patient, $id) {
        $tool = new Tool();
        $tool->tool_radiography_id = $radiography_id;
        $tool->ci_patient = $ci_patient;
        $tool->tool_date = now();

        if ($request->has('image')) {
            $imageData = $request->input('image');

            $image = str_replace('data:image/png;base64,', '', $imageData);
            $image = str_replace(' ', '+', $image);
            $imageName = uniqid() . '.png';
            $filePath = 'storage/tools/' . $imageName;
            $absolutePath = public_path($filePath);
            file_put_contents($absolutePath, base64_decode($image));
            $tool->tool_uri = $imageName;
        }
        $tool->save();
        return response()->json(['success' => true]);
    }
    public function storeTomography(Request $request, $tomography_id, $ci_patient, $id){
        try {
            $tool = new Tool();
            $tool->tool_tomography_id = $tomography_id;
            $tool->ci_patient = $ci_patient;
            $tool->tool_date = now();
    
            if ($request->has('image')) {
                $imageData = $request->input('image');
                $image = str_replace('data:image/png;base64,', '', $imageData);
                $image = str_replace(' ', '+', $image);
                $imageName = uniqid() . '.png';
                $filePath = public_path('storage/tools/' . $imageName);
    
                if (!file_put_contents($filePath, base64_decode($image))) {
                    return redirect()->back()->with('error', 'No se pudo guardar la imagen.');
                }
                $tool->tool_uri = $imageName;
            }
            $tool->save();
            return response()->json([
                'success' => true,
                'tool_id' => $tool->id,
            ]);
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error: ' . $e->getMessage());
        }
    }
    public function show(Tool $tool):View{
        return view('tool.show', compact('tool'));
    }
    public function ver(Tool $tool):View{
        return view('tool.ver', compact('tool'));
    }
    public function destroy(Tool $tool)
    {   
        $radiography = $tool->radiography;
        $tool->delete();
        return redirect()->route('radiography.tool', ['radiography' => $radiography->id])->with('success', 'Tool deleted successfully');
    }
    public function measurements(Tool $tool):View{
        $tools = Tool::where('tool_radiography_id',$tool->tool_radiography_id)->get();
        return view('tool.measurements', compact('tool','tools'));
    }
    public function report(Tool $tool):View{
        return view('tool.report', compact('tool'));
    }
    public function datareport(Request $request){
        session()->flash('findings', $request->input('findings'));
        session()->flash('diagnosis', $request->input('diagnosis'));
        session()->flash('recommendations', $request->input('recommendations'));
        session()->flash('conclusions', $request->input('conclusions'));
        return redirect()->route('radiography.pdfreport');
    }
    public function pdfreport(Tool $tool){
        $patient = $tool->patient;
        $radiography = $tool->radiography;
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
        $pdf = Pdf::loadView('tool.pdfreport', ['data'=>$data]);
        return $pdf->download('study_report.pdf');
    }
}
