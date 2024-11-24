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
    <h3 class="txt2">Fecha de nacimiento:</h3><p>{{ $patient->birth_date }} </p>
    <h3 class="txt2">Genero:</h3><p>{{ $patient->gender }} </p>
    <h3 class="txt2">Número de asegurado:</h3><p>{{ $patient->insurance_code }} </p>
    <h3 class="txt2">Contacto del paciente:</h3><p>{{ $patient->patient_contact }} </p>
    <h3 class="txt2">Contacto de familiar:</h3><p>{{ $patient->family_contact }} </p>
</div>
<div>
    <h1 class="txt-title2">ESTUDIOS DEL PACIENTE</h1>
    <div class="grid grid-cols-4 gap-4 border-b border-purple-500 mb-3">
        <h3 class="txt3">Fecha del estudio</h3>
        <h3 class="txt3">Tipo de estudio</h3>
        <h3 class="txt3">Radiologo</h3>
    </div>
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
</div>
</body>
</html>
@endsection