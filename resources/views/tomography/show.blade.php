@extends('layouts._partials.layout')
@section('title','Show Tomography')
@section('subtitle')
    {{ __('Ver Tomografia') }}
@endsection
@section('content')

<div class="flex justify-end"><a href="{{ route('tomography.index')}}" class="botton1">Volver a Tomografia</a></div>
<div class="flex justify-center"><h1 class="txt-title1">INFORMACIÓN DEL ESTUDIO</h1></div>
<div class="flex ml-10"><h1 class="txt-title2">Paciente:</h1></div>
@if($tomography->patient)
    <h1 class="text-[22px] ml-12 mb-5">{{ $tomography->patient->name_patient }}</h1>
    <div class="ml-10 mt-4"><a href="{{ route('patient.show', $tomography->patient->id ) }}" class="botton3">Ver paciente</a></div>
@else
<div class="text-[22px]"><h3 class="ml-10 mb-2">{{ $tomography->name_patient}} </h3></div>
    <h1 class="ml-10 mb-5">Paciente no registrado en la base de datos.</h1>
@endif
<div class="grid grid-cols-2 gap-4">
    <h3 class="txt2">ID Tomografia:</h3><p>{{ $tomography->tomography_id}} </p>
    <h3 class="txt2">Fecha de la tomografia:</h3><p>{{ $tomography->tomography_date }} </p>
    <h3 class="txt2">Tipo de tomografia:</h3><p>{{ $tomography->tomography_type }} </p>
    <h3 class="txt2">Doctor que solicito el estudio:</h3><p>{{ $tomography->tomography_doctor }} </p>
    <h3 class="txt2">Radiologo:</h3><p>{{ $tomography->tomography_charge }} </p>
</div>
<div class="flex justify-center mt-[30px] mb-[30px]"><img src="{{ asset('storage/tomographies/'.$tomography->tomography_uri)}}" width="1000"/></div>
    <div class="flex justify-center mb-4">
    <div class="mt-2"><a href="{{ route('tomography.tool', $tomography->id) }}" class="botton2">Herramientas</a></div>
    </div>
</div>
@endsection