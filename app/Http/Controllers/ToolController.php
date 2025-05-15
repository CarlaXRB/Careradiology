<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

use App\Http\Requests\ToolRequest;
use App\Models\Tool;

use Barryvdh\DomPDF\Facade\Pdf;
use Imagick;

class ToolController extends Controller
{
    public function index():View{
        $tools = Tool::get();
        return view('tool.index', compact('tools'));
    }
    public function new(Request $request, $tomography_id, $ci_patient, $id)
    {
        $tool = new Tool();
        $tool->tool_tomography_id = $tomography_id; 
        $tool->ci_patient = $ci_patient;
        $tool->tool_date = now();
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = uniqid() . '.' . $image->getClientOriginalExtension();
            $imagePath = public_path('storage/tools/' . $imageName);
            $image->move(public_path('storage/tools'), $imageName);
            $tool->tool_uri = $imageName;
        }
        $tool->save();
        return response()->json(['success' => true]);
    }
     
    public function storeTool(Request $request, $radiography_id, $tomography_id, $ci_patient, $id) {
        $tool = new Tool();
        if($radiography_id>0){
            $tool->tool_radiography_id = $radiography_id;
        }else{
            $tool->tool_tomography_id = $tomography_id;
        }
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
        $tools = Tool::where('tool_tomography_id',$tool->tool_tomography_id)->get();
        return view('tool.ver', compact('tool', 'tools'));
    }
    public function destroy(Tool $tool){   
        $radiography = $tool->radiography;
        $tool->delete();
        return redirect()->route('dashboard')->with('success', 'Tool deleted successfully');
    }
    public function measurements($id):View{
        $tool = Tool::findOrFail($id); 
        $tool_uri = $tool->tool_uri; 
        return view('tool.measurements', compact('tool','tool_uri'));
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
    $tomography = $tool->tomography;
    $isRadiography = isset($tool->tool_radiography_id) && $tool->tool_radiography_id > 0;
    $isTomography = isset($tool->tool_tomography_id) && $tool->tool_tomography_id > 0;

    $data = [
        'name_patient' => $patient->name_patient ?? $radiography->name_patient ?? $tomography->name_patient ?? 'No registrado',
        'ci_patient' => $patient->ci_patient ?? $radiography->ci_patient ?? $tomography->ci_patient ?? 'No registrado',
        'birth_date' => $patient->birth_date ?? 'No disponible',
        'gender' => $patient->gender ?? 'No disponible',
        'insurance_code' => $patient->insurance_code ?? 'No disponible',
        'patient_contact' => $patient->patient_contact ?? 'No disponible',
        'family_contact' => $patient->family_contact ?? 'No disponible',
        'findings' => request('findings'),
        'diagnosis' => request('diagnosis'),
        'recommendations' => request('recommendations'),
        'conclusions' => request('conclusions'),
    ];

    if ($isRadiography) {
        $data += [
            'radiography_id' => $radiography->radiography_id ?? 'No disponible',
            'radiography_date' => $radiography->radiography_date ?? 'No disponible',
            'radiography_type' => $radiography->radiography_type ?? 'No disponible',
            'radiography_doctor' => $radiography->radiography_doctor ?? 'No disponible',
            'radiography_charge' => $radiography->radiography_charge ?? 'No disponible',
        ];
        $imagePath = storage_path('app/public/tools/' . $tool->tool_uri);
        $pdf = Pdf::loadView('tool.pdfreport', ['data' => $data, 'imagePath' => $imagePath]);
    } elseif ($isTomography) {
        $data += [
            'tomography_id' => $tomography->tomography_id ?? 'No disponible',
            'tomography_date' => $tomography->tomography_date ?? 'No disponible',
            'tomography_type' => $tomography->tomography_type ?? 'No disponible',
            'tomography_doctor' => $tomography->tomography_doctor ?? 'No disponible',
            'tomography_charge' => $tomography->tomography_charge ?? 'No disponible',
        ];
        $imagePath = storage_path('app/public/tools/' . $tool->tool_uri);
        //$pdf = Pdf::loadView('radiography.pdfreport', ['data' => $data, 'imagePath' => $imagePath]);
        $pdf = Pdf::loadView('tool.pdfreporttomo', ['data' => $data, 'imagePath' => $imagePath]);
    } else {
        return back()->with('error', 'No hay datos de radiografía ni de tomografía disponibles.');
    }
    return $pdf->download($tool->patient->name_patient . "_" . $tool->patient->ci_patient . "_" .$tool->tool_radiography_id .$tool->tool_tomography_id . '_reporte.pdf');
    }
    public function search($id){
        $tool = Tool::find($id);
        if (!$tool) {
            return redirect()->back()->with('error', 'Herramienta no encontrada.');
        }
        $searchId = $tool->tool_tomography_id != 0 ? $tool->tool_tomography_id : $tool->tool_radiography_id;
        $tools = Tool::where('tool_tomography_id', $searchId)
                     ->orWhere('tool_radiography_id', $searchId)
                     ->get();
        return view('tool.search', compact('tools', 'id'));
    }
}
