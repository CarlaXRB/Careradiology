@extends('layouts._partials.layout')
@section('title', 'Imágenes Procesadas DICOM')
@section('subtitle')
    {{ __('Visualización de Imágenes DICOM') }}
@endsection
@section('content')
@if ($dicomRecord)
    <div class="ml-10 mt-8">
        <h2 class="txt-title2 mb-2">Paciente:</h2>
        <div><h3>Nombre:</h3><p>{{ $dicomRecord->patient_name }}</p></div>
        <div><h3>ID: </h3><p>{{ $dicomRecord->patient_id }}</p></div>
        <div><h3>Modalidad:</h3><p>{{ $dicomRecord->modality }}</p></div>
        <div><h3>Fecha del Estudio:</h3><p>{{ $dicomRecord->study_date }}</p></div>
        <div><h3>Tamaño Imagen:</h3><p>{{ $dicomRecord->rows }} x {{ $dicomRecord->columns }}</p></div>
    </div>
    <div class="mt-10 grid grid-cols-1 md:grid-cols-2 gap-6 justify-items-center mb-5">
    @foreach ($images as $image)
        <div>
            <img src="{{ asset($image) }}" alt="Imagen DICOM procesada" class="max-w-full max-h-[500px] mb-2 rounded-md" />
        </div>
    @endforeach
    </div>
    <div class="ml-10 mt-8 mb-6">
        <div><h3 class="txt2">Metadatos completos:</h3></div>
        @php
            $metadata = json_decode($dicomRecord->metadata, true);
        @endphp
        @foreach ($metadata as $key => $value)
            <p>{{ ucfirst(str_replace('_', ' ', $key)) }}: {{ is_array($value) ? json_encode($value) : $value }}</p>
        @endforeach
    </div>
@else
    <p class="ml-10 text-lg">No se encontraron datos del paciente para esta carpeta.</p>
@endif
@endsection

