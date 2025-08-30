<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ConnectionController extends Controller
{
    public function index(){
        try {
            $response = Http::withBasicAuth('orthanc', 'orthanc')
                ->get('http://localhost:8042/studies');
            $studies = $response->json();
        } catch (\Exception $e) {
            $studies = null;
        }
        return view('connection.index', compact('studies'));
    }
    public function show($id){
        try {
            $response = Http::withBasicAuth('orthanc', 'orthanc')
                ->get("http://localhost:8042/studies/$id");

            $study = $response->json();
            $dicom = Http::withBasicAuth('orthanc', 'orthanc')
                ->get("http://localhost:8042/studies/$id/archive");

            //Almacenado temporalmente
            $path = storage_path("app/public/$id.zip");
            file_put_contents($path, $dicom->body());
        } catch (\Exception $e) {
            return back()->with('error', 'No se pudo obtener el estudio.');
        }
        return view('connection.show', compact('study', 'id'));
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
}
