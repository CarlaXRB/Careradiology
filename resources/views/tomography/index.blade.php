@extends('layouts._partials.layout')
@section('title','Tomographies')
@section('subtitle')
    {{ __('Tomografias') }}
@endsection
@section('content')
<div class="flex justify-end"><a href="{{route('tomography.create')}}" class="botton1">Crear Tomografia</a></div>
    <div class="grid grid-cols-6 gap-4 border-b border-cyan-500">
        <h3 class="txt-head">Vista previa</h3>  
        <h3 class="txt-head">Nombre del paciente</h3>  
        <h3 class="txt-head">Carnet de Identidad</h3>
        <h3 class="txt-head">Fecha de Tomografia</h3>
        <h3 class="txt-head">ID Tomografia</h3>
        <h3 class="txt-head">Tipo de Tomografia</h3>
    </div>  
    <ul>
        @forelse($tomographies as $tomography)
        <div class="grid grid-cols-6 border-b border-gray-600 gap-4 mb-3 text-white pl-6 pl-10">
        <img src="{{ asset('storage/tomographies/'.$tomography->tomography_uri)}}" width="128" />
        <a href="{{ route('tomography.show', $tomography->id) }}"> {{ $tomography->name_patient }} </a>
        <a href="{{ route('tomography.show', $tomography->id) }}"> {{ $tomography->ci_patient }} </a>
        <a href="{{ route('tomography.show', $tomography->id) }}"> {{ $tomography->tomography_date }} </a>        
        <a href="{{ route('tomography.show', $tomography->id) }}"> {{ $tomography->tomography_id }} </a>
        <a href="{{ route('tomography.show', $tomography->id) }}"> {{ $tomography->tomography_type }} </a>      
        </div>
        @empty
        <h2 class="text-white ml-5">No data</h2>
        @endforelse
    </ul>
@endsection