@extends('layouts._partials.layout')
@section('title','Create Radiography')
@section('subtitle')
    {{ __('Radiografías') }}
@endsection
@section('content')
<div class="flex justify-end">
    <a href="{{ route('dashboard') }}" class="botton1">Inicio</a>
</div>

<h3 class="txt-title2">SELECCIONAR FORMATO</h3>
<div class="flex flex-wrap" style="margin-left: 65px;">
    <a href="{{ route('dicom.uploadRadiography') }}" class="card1">
        <img class="img-fluid mx-auto" src="{{ asset('assets/images/radiography1.png') }}" width="150" height="150" alt="DICOM">
        <h5 class="mt-3">DICOM</h5>
        <p>Formato estándar para imágenes médicas. Contiene información del paciente y del equipo</p>
    </a>
    <a href="{{ route('radiography.create') }}" class="card1">
        <img class="img-fluid mx-auto" src="{{ asset('assets/images/radiography2.png') }}" width="150" height="150" alt=".dcm">
        <h5 class="mt-3">.DCM</h5>
        <p>Formato DICOM de imagen sin metadatos adicionales. Se usa para visualización simple</p>
    </a>
    <a href="{{ route('radiography.create') }}" class="card1">
        <img class="img-fluid mx-auto" src="{{ asset('assets/images/radiography3.png') }}" width="150" height="150" alt="JPEG, PNG">
        <h5 class="mt-3">.JPEG / .PNG</h5>
        <p>Formatos de imagen comunes sin información médica integrada</p>
    </a>
    <a href="{{ route('radiography.index') }}" class="card1">
        <img class="img-fluid mx-auto" src="{{ asset('assets/images/info.png') }}" width="150" height="150" alt="ESTUDIOS">
        <h5 class="mt-3">ESTUDIOS</h5>
        <p>Listado de radiografías subidas</p>
    </a>
</div>

<div class="flex justify-center" style="margin-bottom: 25px">
    <a href="{{ route('orthanc.index') }}" class="botton2">Conexión al equipo</a>
</div>
@endsection
