<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DicomController extends Controller
{
    public function receive(Request $request)
    {
        $request->validate([
            'dicom_file' => 'required|file|mimes:dcm|max:2048',
        ]);

        $file = $request->file('dicom_file');
    
        $filePath = storage_path('app/dicom/' . $file->getClientOriginalName());
        $file->move(storage_path('app/dicom'), $file->getClientOriginalName());
    
        Log::info('Imagen DICOM recibida', ['file_path' => $filePath]);
    
        return redirect()->route('dicom')->with('message', 'Imagen DICOM recibida con éxito.');
        return redirect()->route('dicom')->with('message', 'Imagen DICOM "' . $file->getClientOriginalName() . '" recibida con éxito.');
    }    
}
