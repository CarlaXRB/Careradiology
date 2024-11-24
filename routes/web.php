<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\RadiographyController;
use App\Http\Controllers\TomographyController;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\SuscribeController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\ToolController;
use App\Http\Controllers\DicomController;

Route::get('/', function () {return view('welcome');});

Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified'])->group(function () {
    Route::get('/dashboard', function () { return view('dashboard');})->name('dashboard'); 
    Route::resource('/patient',PatientController::class);
    Route::post('/search',[PatientController::class, 'search'])->name('patient.search');

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

    Route::get('/tomography',[TomographyController::class,'index'])->name('tomography.index');
    Route::get('/tomography/create',[TomographyController::class,'create'])->name('tomography.create');
    Route::post('/tomography/store',[TomographyController::class,'store'])->name('tomography.store');
    Route::get('/tomography/show/{tomography}',[TomographyController::class,'show'])->name('tomography.show');
    Route::get('/tomography/tool/{tomography}',[TomographyController::class,'tool'])->name('tomography.tool');
    Route::get('/tomography/measurements/{tomography}',[TomographyController::class,'measurements'])->name('tomography.measurements');
    Route::get('/tomography/report/{tomography}',[TomographyController::class,'report'])->name('tomography.report');
    Route::post('/tomography/{tomography}/pdfreport', [TomographyController::class, 'pdfreport'])->name('tomography.pdfreport');

    Route::get('/tool',[ToolController::class,'index'])->name('tool.index');
    Route::post('/tool/store/{radiography_id}/{id}', [ToolController::class, 'store'])->name('tool.store');
    Route::delete('/tool/{tool}/radiography/{id}', [ToolController::class, 'destroy'])->name('tool.destroy');
    Route::get('/tool/show/{tool}',[ToolController::class,'show'])->name('tool.show'); 
    Route::delete('/tool/destroy/{tool}', [ToolController::class, 'destroy'])->name('tool.destroy');
    Route::post('/save-image', [ToolController::class, 'saveImage'])->name('tool.image');

});

Route::get('/mailme', [SuscribeController::class, 'mailMe'])->name('mailMe');

Route::get('/dicom', function () {return view('dicom');})->name('dicom');









