@extends('layouts._partials.layout')
@section('title', 'Show Tool')
@section('subtitle')
    {{ __('Visualizador') }}
@endsection
@section('content')

<div class="flex justify-end"><a href="{{ route('radiography.index')}}" class="botton1">Volver a Radiografias</a></div>
<h1 class="txt-title2">ESTUDIO DEL PACIENTE</h1>
<div class="grid grid-cols-[1fr,120px]">
    <div class="relative flex justify-center mt-[20px] mb-[30px]">
        <div class="overflow-auto border border-gray-400" style="width: 1000px; height: 800px; position: relative;">
           <img id="radiographyImage" 
                src="{{ asset('storage/tools/'.$tool->tool_uri) }}" 
                style="max-width: 100%; height: 100%; object-fit: contain; transition: transform 0.2s; position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%);" />
       </div>
    </div>
    <div class="relative flex flex-col items-center space-y-10 mt-[30px]">
        <div class="group relative">
            <button id="report" class="btnimg" onclick="window.location.href='{{ route('tool.report', $tool->id) }}'"><img src="{{ asset('assets/images/report.png') }}" width="50" height="50"></button>
            <div class="hidden group-hover:block absolute left-0 mt-2 bg-gray-500 bg-opacity-50 text-center rounded-md px-2 py-1"><span class="text-sm text-gray-100">Reporte</span></div>
        </div>
        <div class="group relative">
            <button id="zoomIn" class="btnimg"><img src="{{ asset('assets/images/zoom.png') }}" width="50" height="50"></button>
            <div class="hidden group-hover:block absolute left-0 mt-2 bg-gray-500 bg-opacity-50 text-center rounded-md px-2 py-1"><span class="text-sm text-gray-100">Acercar</span></div>
        </div>
        <div class="group relative">
            <button id="zoomOut" class="btnimg"><img src="{{ asset('assets/images/unzoom.png') }}" width="50" height="50"></button>
            <div class="hidden group-hover:block absolute left-0 mt-2 bg-gray-500 bg-opacity-50 text-center rounded-md px-2 py-1"><span class="text-sm text-gray-100">Alejar</span></div>
        </div>
    </div>
</div>

<div class="flex justify-center mb-4">
    <div class="mt-2"><a href="{{ route('tool.measurements', $tool->id) }}" class="botton2">Continua editando</a></div>
</div>

<div class="flex ml-10"><h1 class="txt-title2">Datos del Paciente:</h1></div>
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
    <div class="grid grid-cols-2 gap-4 text-gray-900 dark:text-white">
        <h3 class="txt2">Nombre del paciente:</h3><p>{{ $tool->radiography->name_patient }} </p>
        <h3 class="txt2">Carnet de Identidad:</h3><p>{{ $tool->radiography->ci_patient }} </p>
    </div>
    <h1 class="ml-20 mt-8 mb-5">Paciente no registrado en la base de datos.</h1>
@endif
<div class="flex ml-10"><h1 class="txt-title2">Datos de la Radiografía:</h1></div>
<div class="grid grid-cols-2 gap-4 mb-10">
    <h3 class="txt2">ID Radiografia:</h3><p>{{ $tool->tool_radiography_id}} </p>
    <h3 class="txt2">Fecha de la radiografia:</h3><p>{{ $tool->radiography->radiography_date }} </p>
    <h3 class="txt2">Tipo de radiografia:</h3><p>{{ $tool->radiography->radiography_type }} </p>
    <h3 class="txt2">Doctor que solicito el estudio:</h3><p>{{ $tool->radiography->radiography_doctor }} </p>
    <h3 class="txt2">Radiologo:</h3><p>{{ $tool->radiography->radiography_charge }} </p>
</div>

<script>
    let zoomLevel = 1;
    let initialPosition = { left: '50%', top: '50%' };
    let isDragging = false;
    let startX, startY, initialMouseX, initialMouseY;
    let isNegative = false;
    let sharpnessLevel = 1;
    let isMagnifierActive = false;
    let isEdgeDetectionActive = false;

    const img = document.getElementById('radiographyImage');
    const magnifierLens = document.getElementById('magnifierLens');
    const zoomInButton = document.getElementById('zoomIn');
    const zoomOutButton = document.getElementById('zoomOut');

    // Arrastre
    img.addEventListener('mousedown', (event) => {
        if (zoomLevel > 1) {
            isDragging = true;
            startX = img.offsetLeft;
            startY = img.offsetTop;
            initialMouseX = event.clientX;
            initialMouseY = event.clientY;
            event.preventDefault();
        }
    });

    document.addEventListener('mousemove', (event) => {
        if (isDragging) {
            const dx = event.clientX - initialMouseX;
            const dy = event.clientY - initialMouseY;
            img.style.left = `${startX + dx}px`;
            img.style.top = `${startY + dy}px`;
        }

        if (isMagnifierActive) {
            const rect = img.getBoundingClientRect();
            const lensSize = 100; 
            const offset = 20; 
            const x = event.clientX - rect.left - lensSize / 2 + offset; 
            const y = event.clientY - rect.top - lensSize / 2 + offset;

            magnifierLens.style.width = `${lensSize}px`;
            magnifierLens.style.height = `${lensSize}px`;
            magnifierLens.style.left = `${x}px`;
            magnifierLens.style.top = `${y}px`;
            magnifierLens.style.display = 'block';

        }
    });

    document.addEventListener('mouseup', () => {
        isDragging = false;
        magnifierLens.style.display = 'none';
    });

    zoomInButton.addEventListener('click', () => {
        zoomLevel += 0.1; 
        img.style.transform = `translate(-50%, -50%) scale(${zoomLevel})`; 
    });

    zoomOutButton.addEventListener('click', () => {
        if (zoomLevel > 1) { 
            zoomLevel -= 0.1; 
            img.style.transform = `translate(-50%, -50%) scale(${zoomLevel})`; 
        }

        if (zoomLevel <= 1) {
            zoomLevel = 1; 
            img.style.transform = `translate(-50%, -50%) scale(${zoomLevel})`; 
            img.style.left = initialPosition.left; 
            img.style.top = initialPosition.top;
        }
    });
</script>
@endsection