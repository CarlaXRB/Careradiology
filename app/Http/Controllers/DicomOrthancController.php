<?php

namespace App\Http\Controllers;

use App\Services\OrthancService;
use Illuminate\Http\Request;

class DicomOrthancController extends Controller
{
    protected $orthancService;

    public function __construct(OrthancService $orthancService){
        $this->orthancService = $orthancService;
    }
    public function index(){
        $studies = $this->orthancService->getStudies();
        return view('dicomOrthanc.index', compact('studies'));
    }
    public function show($studyId){
        $study = $this->orthancService->getStudy($studyId);
        return view('dicomOrthanc.show', compact('study'));
    }
    public function getStudies(){
        return response()->json($this->orthancService->getStudies());
    }
    public function getInstances($studyId){
        return response()->json($this->orthancService->getInstances($studyId));
    }
    public function getInstanceFile($instanceId){
        return response($this->orthancService->getInstanceFile($instanceId))
                ->header('Content-Type', 'application/dicom');
    }
}
