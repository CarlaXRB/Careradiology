@extends('layouts._partials.layout')
@section('title','Show Herramientas')
@section('subtitle')
    {{ __('Herramientas Aplicadas') }}
<div class="flex justify-end">
    <a href="{{ route('dashboard')}}" class="botton1">Inicio</a>
</div>
<div>
    <h1 class="txt-title2">HERRAMIENTAS APLICADAS</h1>
    <div class="flex justify-end"><a href="javascript:void(0);" class="botton3" id="updateButton">Actualizar</a></div>
    <div class="grid grid-cols-4 gap-4 border-b border-cyan-500">
        <h3 class="txt-head">Vista previa</h3>  
        <h3 class="txt-head">Fecha de creación</h3>
        <h3 class="txt-head">ID del estudio</h3>
    </div>
    @foreach($tools as $tool)
    <div class="grid grid-cols-4 border-b border-gray-600 gap-4 mb-3 text-white pl-6 pl-10">
    <img src="{{ asset('storage/tools/'.$tool->tool_uri)}}" width="128" />
        <a href="{{ route('tool.show', $tool->id) }}"> {{ $tool->tool_date }} </a>
        <a href="{{ route('tool.show', $tool->id) }}"> {{ $tool->tool_tomography_id }} </a>  
    <form method="POST" action="{{ route('tool.destroy', $tool->id) }}">
        @csrf
        @method('Delete')
        <div class="flex justify-end"><input type="submit" value="Eliminar" class="botton2"/></div>
    </form>
    </div>
    @endforeach
</div>
@endsection
