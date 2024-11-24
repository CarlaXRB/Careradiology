@extends('layouts._partials.layout')
@section('title','Show Tool')
@section('subtitle')
    {{ __('Ver Herramienta') }}
@endsection
@section('content')
<form method="POST" action="{{ route('tool.destroy', $tool->id) }}">
    @csrf
    @method('Delete')
    <div class="flex justify-end"><input type="submit" value="Eliminar" class="botton2"/></div>
</form>
<div class="flex ml-10"><h1 class="txt-title2"></h1>Herramienta</div>
<div class="flex justify-center mt-[30px] mb-[30px]"><img src="{{ asset('storage/tools/'.$tool->tool_uri)}}" width="1000"/></div>
    <div class="flex justify-center mb-4">
    <div class="mt-2"><a href="{{ route('radiography.tool', $tool->id) }}" class="botton2">Seguir editando</a></div>
    </div>
</div>
@endsection