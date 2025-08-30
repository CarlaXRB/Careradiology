@extends('layouts._partials.layout')
@section('title','Patient Information')
@section('subtitle')
    {{ __('Información del Paciente') }}
@endsection
@section('content')
<div class="flex justify-end"><a href="{{ route('patient.index')}}" class="botton1">Pacientes</a></div>
<h1 class="txt-title1">INFORMACIÓN DEL PACIENTE</h1>
<div class="grid grid-cols-2 gap-4 text-gray-900 dark:text-white">
    <h3 class="txt2">Nombre del paciente:</h3><p>{{ $patient->name_patient }} </p>
    <h3 class="txt2">Carnet de Identidad:</h3><p>{{ $patient->ci_patient }} </p>
    <h3 class="txt2">Correo Electronico:</h3><p>{{ $patient->email }} </p>
    <h3 class="txt2">Fecha de nacimiento:</h3><p>{{ $patient->birth_date }} </p>
    <h3 class="txt2">Genero:</h3><p>{{ $patient->gender }} </p>
    <h3 class="txt2">Contacto del paciente:</h3><p>{{ $patient->patient_contact }} </p>
    <h3 class="txt2">Contacto de familiar:</h3><p>{{ $patient->family_contact }} </p>
</div>
<div>
 <h1 class="txt-title2">CITAS DEL PACIENTE</h1>
    <div class="grid grid-cols-4 gap-4 border-b border-purple-500 mb-3">
        <h3 class="txt3">Fecha</h3>
        <h3 class="txt3">Tipo</h3>
        <h3 class="txt3">Radiologo</h3>
    </div>
    @if($patient->events->isEmpty())
        <p class="text-white pl-10">El paciente no tiene citas programadas</p>
    @else
    @foreach($patient->events as $event)
    <div class="grid grid-cols-8 border-b border-gray-600 gap-4 mb-3 text-white pl-10">
        <p>{{ $event->start_date }}<p>
        <p>Cita - {{ $event->details }}<p>
        <p>{{ $event->assignedRadiologist->name }}<p></br>
        <div class="flex justify-end mb-4"><a href="{{ route('events.show', $event->id ) }}" class="botton2">Detalles</a></div>
    </div>
    @endforeach
    @endif
    </div>

@auth
@if(Auth::user()->role !== 'recepcionist')  
    <div x-data="{ openReports: false }" class="mb-6">
        <div class="flex justify-center mb-4"><button @click="openReports = !openReports" class="justify-center botton3 mt-4 mb-2">Estudios y Reportes</button></div>
        <div x-show="openReports" x-transition>

        <h1 class="txt-title1">ESTUDIOS DEL PACIENTE</h1>
        <div class="grid grid-cols-4 gap-4 border-b border-cyan-500 mb-3">
            <h3 class="txt4">Fecha</h3>
            <h3 class="txt4">Tipo</h3>
            <h3 class="txt4">Radiologo</h3>
        </div>
        @if($patient->radiographies->isEmpty() && $patient->tomographies->isEmpty())
            <p class="text-white pl-10">El paciente no tiene estudios realizados</p>
        @else
        @foreach($patient->radiographies as $radiography)
        <div class="grid grid-cols-8 border-b border-gray-600 gap-4 mb-3 text-white pl-10">
            <p>{{ $radiography->radiography_date }}<p>
            <p>Radiografia - {{ $radiography->radiography_type }}<p>
            <p>{{ $radiography->radiography_charge }}<p></br>
            <div class="flex justify-end mb-4"><a href="{{ route('radiography.show', $radiography->id ) }}" class="botton2">Ver Estudio</a></div>
        </div>
        @endforeach
        @foreach($patient->tomographies as $tomography)
        <div class="grid grid-cols-8 border-b border-gray-600 gap-4 mb-3 text-white pl-10">
            <p>{{ $tomography->tomography_date }}<p>
            <p>Tomografia - {{ $tomography->tomography_type }}<p>
            <p>{{ $tomography->tomography_charge }}<p></br>
            <div class="flex justify-end mb-4"><a href="{{ route('tomography.show', $tomography->id ) }}" class="botton2">Ver Estudio</a></div>
        </div>
        @endforeach
        @endif
        <h1 class="txt-title2">REPORTES DEL PACIENTE</h1>
        <div class="grid grid-cols-4 gap-4 border-b border-purple-500 mb-3">
            <h3 class="txt3">Fecha</h3>
            <h3 class="txt3">Tipo</h3>
            <h3 class="txt3">Radiologo</h3>
        </div>
        @if($patient->reports->isEmpty())
            <p class="text-white pl-10">El paciente no tiene reportes guardados</p>
        @else
        @foreach($patient->reports as $report)
        <div class="grid grid-cols-8 border-b border-gray-600 gap-4 mb-3 text-white pl-10">
            <p>{{ $report->report_date }}<p>
            <p>Reporte - {{ $report->report_id }}<p>
            <p>{{ $report->created_by }}<p></br>
            <div class="flex justify-end mb-4"><a href="{{ route('report.view', $report->id ) }}" target="_blank" class="botton3">Ver Reporte</a></div>
        </div>
        @endforeach
        @endif
        </div>
    </div>
    @endif
@endauth
</body>
</html>
@endsection