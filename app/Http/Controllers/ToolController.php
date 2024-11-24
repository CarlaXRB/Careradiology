<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use App\Http\Requests\ToolRequest;
use App\Models\Tool;

class ToolController extends Controller
{
    public function index():View{
        $tools = Tool::get();
        return view('tool.index', compact('tools'));
    }
    public function store(Request $request, $radiography_id, $id) {
        $tool = new Tool();
        $tool->tool_id = $radiography_id;
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
    
    public function show(Tool $tool):View{
        return view('tool.show', compact('tool'));
    }
    public function destroy(Tool $tool)
    {   
        $radiography = $tool->radiography;
        $tool->delete();
        return redirect()->route('radiography.tool', ['radiography' => $radiography->id])->with('success', 'Tool deleted successfully');
    }
}
