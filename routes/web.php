<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\RadiographyController;
use App\Http\Controllers\TomographyController;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\SuscribeController;
use App\Http\Controllers\ToolController;
use App\Http\Controllers\AdminUserController;
use App\Http\Controllers\DicomController;
use App\Http\Controllers\DicomOrthancController;

Route::get('/', function () {return view('welcome');});

Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified'])->group(function () {
    Route::get('/dashboard', function () { return view('dashboard');})->name('dashboard'); 
    Route::resource('/patient',PatientController::class);
    Route::post('/search',[PatientController::class, 'search'])->name('patient.search');

    Route::get('admin/users/create', [AdminUserController::class, 'create'])->name('admin.create');
    Route::post('admin/users/new', [AdminUserController::class, 'store'])->name('admin.store');
    Route::get('admin/users/list', [AdminUserController::class, 'index'])->name('admin.users');
    Route::delete('/admin/destroy/{user}', [AdminUserController::class, 'destroy'])->name('admin.destroy');

    Route::get('/new-radiography',[RadiographyController::class,'new'])->name('radiography.new');
    Route::get('/radiography',[RadiographyController::class,'index'])->name('radiography.index');
    Route::get('/radiography/create',[RadiographyController::class,'create'])->name('radiography.create');
    Route::post('/radiography/store',[RadiographyController::class,'store'])->name('radiography.store');
    Route::get('/radiography/show/{radiography}',[RadiographyController::class,'show'])->name('radiography.show');
    Route::get('/radiography/tool/{radiography}',[RadiographyController::class,'tool'])->name('radiography.tool');
    Route::get('/radiography/measurements/{radiography}',[RadiographyController::class,'measurements'])->name('radiography.measurements');
    Route::get('/radiography/report/{radiography}',[RadiographyController::class,'report'])->name('radiography.report');
    Route::post('/radiography/{radiography}/pdfreport', [RadiographyController::class, 'pdfreport'])->name('radiography.pdfreport');
    Route::post('/radiography/{radiography}/apply-filters', [RadiographyController::class, 'applyFilters'])->name('radiography.applyFilters');
    Route::post('/radiography/search',[RadiographyController::class, 'search'])->name('radiography.search');

    Route::get('/new-tomography',[TomographyController::class,'new'])->name('tomography.new');
    Route::get('/tomography',[TomographyController::class,'index'])->name('tomography.index');
    Route::get('/tomography/create',[TomographyController::class,'create'])->name('tomography.create');
    Route::post('/tomography/store',[TomographyController::class,'store'])->name('tomography.store');
    Route::get('/tomography/tool/{tomography}',[TomographyController::class,'tool'])->name('tomography.tool');
    Route::get('/tomography/measurements/{tomography}',[TomographyController::class,'measurements'])->name('tomography.measurements');
    Route::get('/tomography/report/{tomography}',[TomographyController::class,'report'])->name('tomography.report');
    Route::post('/tomography/{tomography}/pdfreport', [TomographyController::class, 'pdfreport'])->name('tomography.pdfreport');
    Route::get('/tomography/convert/{id}', [TomographyController::class, 'convert'])->name('tomography.convert');
    Route::get('/tomography/show/{id}', [TomographyController::class, 'show'])->name('tomography.show');
    Route::get('tomography/image/{tomographyId}/{image}', [TomographyController::class, 'showSelectedImage'])->name('tomography.image');
    Route::get('/tomography/superposicion/{id}', [TomographyController::class, 'superposicion'])->name('tomography.superposicion');
    Route::post('/tomography/search',[TomographyController::class, 'search'])->name('tomography.search');

    Route::get('/tool',[ToolController::class,'index'])->name('tool.index');
    Route::post('/tool/new/tool/{tomography_id}/{ci_patient}/{id}', [ToolController::class, 'new'])->name('tool.new');
    Route::post('/tool/store/tool/{radiography_id}/{tomography_id}/{ci_patient}/{id}', [ToolController::class, 'storeTool'])->name('tool.store');
    Route::post('/tool/store/tomography/{tomography_id}/{ci_patient}/{id}', [ToolController::class, 'storeTomography'])->name('tool.storeTomography');
    Route::get('/tool/show/{tool}',[ToolController::class,'show'])->name('tool.show'); 
    Route::get('/tool/ver/{tool}', [ToolController::class, 'ver'])->name('tool.ver');
    Route::get('/tool/search/{id}', [ToolController::class, 'search'])->name('tool.search');
    Route::delete('/tool/destroy/{tool}', [ToolController::class, 'destroy'])->name('tool.destroy');
    Route::post('/save-image', [ToolController::class, 'saveImage'])->name('tool.image');
    Route::get('/tool/measurements/{id}',[ToolController::class,'measurements'])->name('tool.measurements');
    Route::get('/tool/report/{tool}',[ToolController::class,'report'])->name('tool.report');
    Route::post('/tool/{tool}/pdfreport', [ToolController::class, 'pdfreport'])->name('tool.pdfreport');
  
    Route::get('/dicom/upload', [DicomController::class, 'uploadForm'])->name('dicom.upload');
    Route::post('/dicom/process', [DicomController::class, 'processDicom'])->name('process.dicom');
    Route::post('/dicom/process-folder', [DicomController::class, 'processFolder'])->name('process.folder');
    Route::get('/dicom/show-images/{folderName}', [DicomController::class, 'showFolderImages'])->name('dicom.showFolderImages');
    Route::get('/dicom-form', [DicomController::class, 'showForm'])->name('dicom.data');
    Route::post('/dicom-upload', [DicomController::class, 'uploadDicom'])->name('dicom.updata');
    Route::get('/dicom-records', [DicomController::class, 'showRecords'])->name('dicom.viewdata');

    Route::get('/view-dicom/studies', [DicomOrthancController::class, 'index'])->name('orthanc.index');
    Route::get('/view-dicom/study/{studyId}', [DicomOrthancController::class, 'show'])->name('orthanc.show');

    Route::get('/dicomo/studies', [DicomOrthancController::class, 'getStudies']);
    Route::get('/dicomo/studies/{studyId}/instances', [DicomOrthancController::class, 'getInstances']);
    Route::get('/dicomo/instances/{instanceId}/file', [DicomOrthancController::class, 'getInstanceFile']);

});

Route::get('/mailme', [SuscribeController::class, 'mailMe'])->name('mailMe');

Route::get('/dicom', function () {return view('dicom');})->name('dicom');