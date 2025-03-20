@extends('layouts._partials.layout')
@section('title','Show Radiography')
@section('subtitle')
    {{ __('DICOM') }}
@endsection
@section('content')
<div class="flex justify-end"><a href="{{ route('dashboard') }}" class="botton1">Inicio</a></div>
<h1 class="txt-title2">ARCHIVO DICOM CON METADATOS</h1>
<div class="mx-auto mb-4 px-8">
    <p class="text-[17px] p-5">Aquí puedes subir archivos en formato <b>DICOM</b> para su procesamiento y análisis. 
        Nuestro sistema extraerá y mostrará los metadatos relevantes, facilitando la gestión de imágenes radiológicas.</p>
        <form action="{{ route('process.dicom') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
        @csrf
        <div class="flex justify-center">
            <input type="file" name="file" required class="border border-cyan-300 rounded-md p-5">
        </div>
        <div class="flex justify-center p-4">
            <button type="submit" class="botton2">Subir Archivo</button>
        </div>
    </form>
</div>
@endsection
