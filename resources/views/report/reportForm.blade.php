@extends('layouts._partials.layout')
@section('title','Reporte')
@section('subtitle')
    {{ __('Reporte') }}
@endsection
@section('content')

<div class="flex justify-end">
    <a href="{{ route('dashboard') }}" class="botton1">Inicio</a>
</div>

<form method="POST" action="{{ route('report.pdfreport') }}" enctype="multipart/form-data">
    @csrf

    <div class="text-gray-900 dark:text-white">
        <h1 class="txt-title2">Datos del Paciente:</h1>

        @if($patient)
        <div class="grid grid-cols-2 gap-4 text-gray-900 dark:text-white">
            <h3 class="txt2">Nombre del paciente:</h3><p>{{ $patient->name_patient }} </p>
            <h3 class="txt2">Carnet de Identidad:</h3><p>{{ $patient->ci_patient }} </p>
            <h3 class="txt2">Fecha de nacimiento:</h3><p>{{ $patient->birth_date }} </p>
            <h3 class="txt2">Género:</h3><p>{{ $patient->gender }} </p>
            <h3 class="txt2">Contacto del paciente:</h3><p>{{ $patient->patient_contact }} </p>
            <h3 class="txt2">Contacto de familiar:</h3><p>{{ $patient->family_contact }} </p>
        </div>
        @else
        <div class="grid grid-cols-2 gap-4 text-gray-900 dark:text-white">
            <h3 class="txt2">Nombre del paciente:</h3><p>{{ $study->name_patient ?? 'N/A' }} </p>
            <h3 class="txt2">Carnet de Identidad:</h3><p>{{ $study->ci_patient ?? 'N/A' }} </p>
        </div>
        <h1 class="flex justify-center text-red-500 mt-5 ml-10 mb-5">Paciente no registrado en la base de datos.</h1>
        @endif

        <h1 class="txt-title2">Datos del Estudio:</h1>
        <div class="grid grid-cols-2 gap-4 text-gray-900 dark:text-white">
            @if($studyType === 'radiography')
                <h3 class="txt2">ID Radiografía:</h3><p>{{ $study->radiography_id }} </p>
                <h3 class="txt2">Fecha de la radiografía:</h3><p>{{ $study->radiography_date }} </p>
                <h3 class="txt2">Tipo de radiografía:</h3><p>{{ $study->radiography_type }} </p>
                <h3 class="txt2">Doctor que solicitó el estudio:</h3><p>{{ $study->radiography_doctor }} </p>
                <h3 class="txt2">Radiólogo:</h3><p>{{ $study->radiography_charge }} </p>
            @elseif($studyType === 'tomography')
                <h3 class="txt2">ID Tomografía:</h3><p>{{ $study->tomography_id }} </p>
                <h3 class="txt2">Fecha de la tomografía:</h3><p>{{ $study->tomography_date }} </p>
                <h3 class="txt2">Tipo de tomografía:</h3><p>{{ $study->tomography_type }} </p>
                <h3 class="txt2">Doctor que solicitó el estudio:</h3><p>{{ $study->tomography_doctor }} </p>
                <h3 class="txt2">Radiólogo:</h3><p>{{ $study->tomography_charge }} </p>
            @elseif($studyType === 'tool')
                <h3 class="txt2">ID del estudio:</h3><p>{{ $study->radiography->radiography_id ?? $study->tomography->tomography_id }} </p>
                <h3 class="txt2">Fecha del estudio:</h3><p>{{ $study->tool_date }} </p>
                <h3 class="txt2">Tipo:</h3><p> {{ $study->radiography->radiography_type ?? $study->tomography->tomography_type }}</p>
                <h3 class="txt2">Doctor que solicitó el estudio:</h3><p>{{ $study->radiography->radiography_doctor ?? $study->tomography->tomography_doctor }} </p>
                <h3 class="txt2">Radiólogo:</h3><p>{{ $study->radiography->radiography_charge ?? $study->tomography->tomography_charge }} </p>
            @endif
        </div>

        <h1 class="txt-title2">Observaciones del Estudio:</h1>

        <div class="flex justify-center mb-4">
            <button id="showImageBtn" type="button" class="botton3">Mostrar Imagen</button>
        </div>
        <div id="imageContainer" class="flex justify-center mb-4" style="display: none;">
@php
    $imageUri = '';
    if ($studyType === 'radiography') {
        $imageUri = $study->radiography_uri ?? '';
    } elseif ($studyType === 'tomography') {
        // Corregido aquí para usar $selectedImage
        $imageUri = $selectedImage ?? '';
    } elseif ($studyType === 'tool') {
        $imageUri = $study->tool_uri ?? '';
    }
@endphp

@if($imageUri)
    <img src="{{ $studyType === 'tomography' 
        ? asset('storage/tomographies/converted_images/' . $study->id . '/' . $imageUri)
        : asset('storage/' . ($studyType === 'radiography' ? 'radiographies/' : 'tools/') . $imageUri) }}" 
    alt="Imagen del estudio" class="max-w-full h-auto">
@else
    <p>No hay imagen disponible.</p>
@endif

        </div>

        <div class="flex items-center mb-4">
            <label class="txt1">Hallazgos:</label>
            <textarea name="findings" class="border-gray-300 dark:border-gray-600 rounded-lg p-2 w-full text-black dark:text-black focus:outline-none focus:ring-2 focus:ring-cyan-500 mr-10" rows="3">{{ old('findings') }}</textarea>
        </div>
        <div class="flex items-center mb-4">
            <label class="txt1">Impresión Diagnóstica:</label>
            <textarea name="diagnosis" class="border-gray-300 dark:border-gray-600 rounded-lg p-2 w-full text-black dark:text-black focus:outline-none focus:ring-2 focus:ring-cyan-500 mr-10" rows="3">{{ old('diagnosis') }}</textarea>
        </div>
        <div class="flex items-center mb-4">
            <label class="txt1">Recomendaciones:</label>
            <textarea name="recommendations" class="border-gray-300 dark:border-gray-600 rounded-lg p-2 w-full text-black dark:text-black focus:outline-none focus:ring-2 focus:ring-cyan-500 mr-10" rows="3">{{ old('recommendations') }}</textarea>
        </div>
        <div class="flex items-center mb-4">
            <label class="txt1">Conclusión:</label>
            <textarea name="conclusions" class="border-gray-300 dark:border-gray-600 rounded-lg p-2 w-full text-black dark:text-black focus:outline-none focus:ring-2 focus:ring-cyan-500 mr-10" rows="3">{{ old('conclusions') }}</textarea>
        </div>

        <input type="hidden" name="study_id" value="{{ $study->id }}">
        <input type="hidden" name="study_type" value="{{ $studyType }}">
        <input type="hidden" name="selected_image" id="selected_image_input" value="{{ $selectedImage }}"> {{-- input oculto para enviar la imagen seleccionada --}}
        
        <div class="flex justify-center mb-4">
            <button type="submit" class="botton1">Descargar PDF</button>
        </div>

    </div>
</form>

<script>
    document.getElementById('showImageBtn').addEventListener('click', function() {
        var imageContainer = document.getElementById('imageContainer');
        if (imageContainer.style.display === 'none') {
            imageContainer.style.display = 'flex';
        } else {
            imageContainer.style.display = 'none';
        }
    });

function changeImage(index) {
    if (index >= 0 && index < totalImages) {
        $(`#image-${currentIndex}`).hide();
        $(`#image-${index}`).fadeIn(100);
        $('#image-name').text(images[index]);
        $('#selected_image').val(images[index]);  // Aquí actualizas el valor del input oculto
        currentIndex = index;
    }
}
    // Aquí podrías implementar esta función si desde otra vista eliges imagen
</script>

@endsection
