@extends('layouts._partials.layout')
@section('title','Show Herramientas')
@section('subtitle')
    {{ __('Herramientas Aplicadas') }}
@endsection
@section('content')
<div class="flex justify-end">
    <a href="{{ route('dashboard')}}" class="botton1">Inicio</a>
</div>
<div>
    <h1 class="txt-title2">HERRAMIENTAS APLICADAS</h1>
    <div class="grid grid-cols-3 gap-4 border-b border-cyan-500">
        <h3 class="txt-head">Vista previa</h3>  
        <h3 class="txt-head">Fecha de creación</h3>
    </div>
    @foreach($tools as $tool)
    <div class="grid grid-cols-3 border-b border-gray-600 gap-4 mb-3 text-white pl-6 pl-10">
    <div class="flex justify-center"><img src="{{ asset('storage/tools/'.$tool->tool_uri)}}" width="128" /></div>
    <div class="flex justify-center"><a href="{{ route('tool.show', $tool->id) }}"> {{ $tool->tool_date }} </a></div>
    @auth
    @if(auth()->user()->role === 'admin')
    <form method="POST" action="{{ route('tool.destroy', $tool->id) }}">
        @csrf
        @method('Delete')
        <div class="flex justify-center"><input type="submit" value="Eliminar" class="botton2"/></div>
    </form>
    @endif
    @endauth
    </div>
    @endforeach
</div>
@endsection
