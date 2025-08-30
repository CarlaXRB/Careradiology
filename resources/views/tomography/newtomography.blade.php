@extends('layouts._partials.layout')

@section('title','Create Tomography')

@section('subtitle')
    {{ __('Tomografías') }}
@endsection

@section('content')
<div class="flex justify-end">
    <a href="{{ route('dashboard') }}" class="botton1">Inicio</a>
</div>

<h3 class="txt-title2">SELECCIONAR FORMATO</h3>
<div class="flex flex-wrap" style="margin-left: 65px;">
    <a href="{{ route('dicom.uploadTomography') }}" class="card1">
        <img class="img-fluid mx-auto" src="{{ asset('assets/images/ct1.png') }}" width="150" height="150" alt="DICOM">
        <h5 class="mt-3"> CARPETA DICOM</h5>
        <p>Selecciona una carpeta que contenga múltiples archivos DICOM con metadatos</p>
    </a>
    <a href="{{ route('tomography.createdcm') }}" class="card1">
        <img class="img-fluid mx-auto" src="{{ asset('assets/images/ct2.png') }}" width="150" height="150" alt=".dcm">
        <h5 class="mt-3">CARPETA .dcm</h5>
        <p>Selecciona una carpeta con archivos .dcm </p>
    </a>
    <a href="{{ route('tomography.create') }}" class="card1">
        <img class="img-fluid mx-auto" src="{{ asset('assets/images/ct3.png') }}" width="150" height="150" alt="JPEG, PNG">
        <h5 class="mt-3">ARCHIVO COMPRIMIDO</h5>
        <p>Sube un archivo ZIP que contenga imágenes médicas CT</p>
    </a>
    <a href="{{ route('tomography.index') }}" class="card1">
        <img class="img-fluid mx-auto" src="{{ asset('assets/images/info.png') }}" width="150" height="150" alt="ESTUDIOS">
        <h5 class="mt-3">ESTUDIOS</h5>
        <p>Listado de tomografías subidas</p>
    </a>
</div>
@auth
    @if(in_array(Auth::user()->role, ['admin', 'radiology'])) 
        <div class="flex justify-center" style="margin-bottom: 25px">
            <a href="{{ route('conexion.equipo') }}" class="botton2">Conexión al equipo</a>
        </div>
    @endif
@endauth
@endsection
