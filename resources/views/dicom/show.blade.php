@extends('layouts._partials.layout')
@section('title','DICOM Radiography')
@section('subtitle')
    {{ __('DICOM') }}
@endsection
@section('content')
<div class="flex justify-end">
    <a href="{{ route('dashboard') }}" class="botton1">Inicio</a>
</div>
    <h1 class="txt-title2">INFORMACIÓN DEL ESTUDIO</h1>
    <div class="flex justify-center p-4">
        <img src="{{ asset($imageUrl) }}" alt="Imagen DICOM procesada" style="max-width: 100%; max-height: 500px;">
    </div>
    <h2 class="txt-title2">Información del Paciente</h2>
    <div class="grid grid-cols-2 gap-4">
        <h2 class="txt2">Paciente:</h2> <p> {{ $dicomData['patient_name'] }}</p>
        <h2 class="txt2">ID del Paciente:</h2> <p> {{ $dicomData['patient_id'] }}</p>
        <h2 class="txt2">Modalidad:</h2> <p> {{ $dicomData['modality'] }}</p>
        <h2 class="txt2">Fecha del Estudio:</h2> <p> {{ $dicomData['study_date'] }}</p>
        <h2 class="txt2">Tamaño de la imagen:</h2> <p> {{ $dicomData['rows'] }}x{{ $dicomData['columns'] }}</p>
    </div>
    <h3 class="txt-title2" >Metadatos completos:</h3>
    <pre class="bg-gray-800 text-white p-2 rounded-lg whitespace-pre-wrap break-words text-sm">
        {{ json_encode($dicomData['dicom_info'], JSON_PRETTY_PRINT) }}
    </pre>
@endsection
