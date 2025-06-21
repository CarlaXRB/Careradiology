@extends('layouts._partials.layout')
@section('title','Show Radiography')
@section('subtitle')
    {{ __('Ver Radiografia') }}
@endsection
@section('content')
<div class="flex justify-end"><a href="{{ route('radiography.index')}}" class="botton1">Radiografias</a></div>
<div class="flex justify-center"><h1 class="txt-title1">INFORMACIÓN DEL ESTUDIO</h1></div>
<div class="flex ml-10"><h1 class="txt-title2">Paciente:</h1></div>
@if($radiography->patient)
    <h1 class="text-[22px] ml-12 mb-5">{{ $radiography->patient->name_patient }}</h1>
    <div class="ml-10 mt-4"><a href="{{ route('patient.show', $radiography->patient->id ) }}" class="botton3">Ver paciente</a></div>
@else
    <div class="text-[22px]"><h3 class="ml-10 mb-2">{{ $radiography->name_patient}} </h3></div>
    <h1 class="ml-10 mb-5">Paciente no registrado en la base de datos.</h1>
@endif
<div class="grid grid-cols-2 gap-4">
    <h3 class="txt2">ID Radiografia:</h3><p>{{ $radiography->radiography_id}} </p>
    <h3 class="txt2">Fecha de la radiografia:</h3><p>{{ $radiography->radiography_date }} </p>
    <h3 class="txt2">Tipo de radiografia:</h3><p>{{ $radiography->radiography_type }} </p>
    <h3 class="txt2">Doctor que solicito el estudio:</h3><p>{{ $radiography->radiography_doctor }} </p>
    <h3 class="txt2">Radiologo:</h3><p>{{ $radiography->radiography_charge }} </p>
</div>

<div class="flex items-center space-y-4 ml-20">
    <div class="txt-title2">Imprimir reporte:</div>
    <div class="group relative ml-5">
        <button id="report" class="btnimg" onclick="window.location.href='{{ route('report.form', ['type'=>'radiography','id'=>$radiography->id]) }}'"><img src="{{ asset('assets/images/report.png') }}" width="50" height="50"></button>
        <div class="hidden group-hover:block absolute left-0 mt-2 bg-gray-500 bg-opacity-50 text-center rounded-md px-2 py-1"><span class="text-sm text-gray-100">Reporte</span></div>
    </div>
</div>

<div class="flex justify-center mt-[30px] mb-[30px]"><img src="{{ asset('storage/radiographies/'.$radiography->radiography_uri)}}"/></div>
    <div class="flex justify-center mb-4">
        <div class="mt-2"><a href="{{ route('radiography.tool', $radiography->id) }}" class="botton2">Herramientas</a></div>
    </div>
</div>
@endsection