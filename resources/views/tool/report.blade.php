@extends('layouts._partials.layout')
@section('title','Study Report')
@section('subtitle')
    {{ __('Reporte') }}
@endsection
@section('content')
<div class="flex justify-end">
    <a href="{{ route('tool.show', $tool->id) }}" class="botton1">Atrás</a>
</div>
<form method="POST" action="{{ route('tool.pdfreport', $tool->id) }}" enctype="multipart/form-data">
    @csrf
    <div class="text-gray-900 dark:text-white">
        <h1 class="txt-title2">Datos del Paciente:</h1>
        @if($tool->patient)
        <div class="grid grid-cols-2 gap-4 text-gray-900 dark:text-white">
            <h3 class="txt2">Nombre del paciente:</h3><p>{{ $tool->patient->name_patient }} </p>
            <h3 class="txt2">Carnet de Identidad:</h3><p>{{ $tool->patient->ci_patient }} </p>
            <h3 class="txt2">Fecha de nacimiento:</h3><p>{{ $tool->patient->birth_date }} </p>
            <h3 class="txt2">Genero:</h3><p>{{ $tool->patient->gender }} </p>
            <h3 class="txt2">Número de asegurado:</h3><p>{{ $tool->patient->insurance_code }} </p>
            <h3 class="txt2">Contacto del paciente:</h3><p>{{ $tool->patient->patient_contact }} </p>
            <h3 class="txt2">Contacto de familiar:</h3><p>{{ $tool->patient->family_contact }} </p>
        </div>
        @else
            @if($tool->radiography)
            <div class="grid grid-cols-2 gap-4 text-gray-900 dark:text-white">
                <h3 class="txt2">Nombre del paciente:</h3><p>{{ $tool->radiography->name_patient }} </p>
                <h3 class="txt2">Carnet de Identidad:</h3><p>{{ $tool->radiography->ci_patient }} </p>
            </div>
            <h1 class="flex justify-center text-red-500 mt-5 ml-10 mb-5">Paciente no registrado en la base de datos.</h1>
            @elseif($tool->tomography)
            <div class="grid grid-cols-2 gap-4 text-gray-900 dark:text-white">
                <h3 class="txt2">Nombre del paciente:</h3><p>{{ $tool->tomography->name_patient }} </p>
                <h3 class="txt2">Carnet de Identidad:</h3><p>{{ $tool->tomography->ci_patient }} </p>
            </div>
            <h1 class="flex justify-center text-red-500 mt-5 ml-10 mb-5">Paciente no registrado en la base de datos.</h1>
            @else
            <h1 class="flex justify-center text-red-500 mt-5 ml-10 mb-5">No se encontró información del paciente.</h1>
            @endif    
        @endif

        <h1 class="txt-title2">Datos del estudio:</h1>
        <div class="grid grid-cols-2 gap-4 text-gray-900 dark:text-white">
        @if(isset($tool->tool_radiography_id) && $tool->tool_radiography_id > 0 && $tool->radiography)
            <h3 class="txt2">ID Radiografia:</h3><p>{{ $tool->radiography->radiography_id }} </p>
            <h3 class="txt2">Fecha de la radiografia:</h3><p>{{ $tool->radiography->radiography_date }} </p>
            <h3 class="txt2">Tipo de radiografia:</h3><p>{{ $tool->radiography->radiography_type }} </p>
            <h3 class="txt2">Doctor que solicitó el estudio:</h3><p>{{ $tool->radiography->radiography_doctor }} </p>
            <h3 class="txt2">Radiólogo:</h3><p>{{ $tool->radiography->radiography_charge }} </p>
        @elseif($tool->tomography)
            <h3 class="txt2">ID Tomografia:</h3><p>{{ $tool->tomography->tomography_id }} </p>
            <h3 class="txt2">Fecha de la tomografía:</h3><p>{{ $tool->tomography->tomography_date }} </p>
            <h3 class="txt2">Tipo de tomografía:</h3><p>{{ $tool->tomography->tomography_type }} </p>
            <h3 class="txt2">Doctor que solicitó el estudio:</h3><p>{{ $tool->tomography->tomography_doctor }} </p>
            <h3 class="txt2">Radiólogo:</h3><p>{{ $tool->tomography->tomography_charge }} </p>
        @else
            <h3 class="txt2 col-span-2 text-red-500">No hay información del estudio disponible.</h3>
        @endif
        </div>

        <h1 class="txt-title2">Observaciones del estudio:</h1>

        <div class="flex justify-center mb-4">
            <button id="showImageBtn" type="button" class="botton3">Mostrar Imagen</button>
        </div>
        <div id="imageContainer" class="flex justify-center mb-4" style="display: none;">
            <img src="{{ asset('storage/tools/' . $tool->tool_uri) }}" alt="Radiografía" class="max-w-full h-auto">
        </div>
        <script>
            document.getElementById('showImageBtn').addEventListener('click', function() {
                var imageContainer = document.getElementById('imageContainer');
                imageContainer.style.display = imageContainer.style.display === 'none' ? 'flex' : 'none';
            });
        </script>

        <div class="flex items-center mb-4">
            <label class="txt1">Hallazgos:</label>
            <textarea name="findings" class="border-gray-300 dark:border-gray-600 rounded-lg p-2 w-full text-black dark:text-black focus:outline-none focus:ring-2 focus:ring-cyan-500 mr-10" rows="3">{{ session('findings') }}</textarea>
        </div>
        <div class="flex items-center mb-4">
            <label class="txt1">Impresión Diagnóstica:</label>
            <textarea name="diagnosis" class="border-gray-300 dark:border-gray-600 rounded-lg p-2 w-full text-black dark:text-black focus:outline-none focus:ring-2 focus:ring-cyan-500 mr-10" rows="3">{{ session('diagnosis') }}</textarea>
        </div>
        <div class="flex items-center mb-4">
            <label class="txt1">Recomendaciones:</label>
            <textarea name="recommendations" class="border-gray-300 dark:border-gray-600 rounded-lg p-2 w-full text-black dark:text-black focus:outline-none focus:ring-2 focus:ring-cyan-500 mr-10" rows="3">{{ session('recommendations') }}</textarea>
        </div>
        <div class="flex items-center mb-4">
            <label class="txt1">Conclusión:</label>
            <textarea name="conclusions" class="border-gray-300 dark:border-gray-600 rounded-lg p-2 w-full text-black dark:text-black focus:outline-none focus:ring-2 focus:ring-cyan-500 mr-10" rows="3">{{ session('conclusions') }}</textarea>
        </div>
        <div class="flex justify-center mb-4">
            <button type="submit" class="botton1">Descargar PDF</button>
        </div>
    </div>
</form>
@endsection
