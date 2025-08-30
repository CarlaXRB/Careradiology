@extends('layouts._partials.layout')
@section('title','Show Radiography')
@section('subtitle')
    {{ __('Ver Radiografia') }}
@endsection
@section('content')

@auth @if(auth()->user()->role === 'user')
    <div class="flex justify-end"><a href="{{ route('dashboard') }}" class="botton1">Inicio</a></div>
@endif @endauth

@auth @if(auth()->user()->role !== 'user')
    <div class="flex justify-end"><a href="{{ route('radiography.index')}}" class="botton1">Radiografias</a></div>
@endif @endauth
<div class="flex justify-center"><h1 class="txt-title2">INFORMACIÓN DEL ESTUDIO</h1></div>

<div class="grid grid-cols-2 text-gray-900 dark:text-white">
    <h3 class="txt2 mb-2">Paciente:</h3><p>{{ $radiography->name_patient}}</p><p> </p>
    @if($radiography->patient)
    @auth @if(auth()->user()->role !== 'user') <a href="{{ route('patient.show', $radiography->patient->id ) }}" class="text-green-500 mb-3">Ver paciente</a> @endif @endauth
    @else
        <p class="text-red-500 mb-3">Paciente no registrado en la base de datos.</p>
    @endif
</div>
<div class="grid grid-cols-2 gap-4">
    <h3 class="txt2">ID Radiografia:</h3><p>{{ $radiography->radiography_id}} </p>
    <h3 class="txt2">Fecha de la radiografia:</h3><p>{{ $radiography->radiography_date }} </p>
    <h3 class="txt2">Tipo de radiografia:</h3><p>{{ $radiography->radiography_type }} </p>
    <h3 class="txt2">Doctor que solicito el estudio:</h3><p>{{ $radiography->radiography_doctor }} </p>
    <h3 class="txt2">Radiologo:</h3><p>{{ $radiography->radiography_charge }} </p>
</div>

@auth
    @if(auth()->user()->role !== 'user')
        <div class="flex items-center space-y-4 ml-20">
            <div class="txt-title2">Generar reporte:</div>
            <div class="group relative ml-5">
                <button id="report" class="btnimg" onclick="window.location.href='{{ route('report.form', ['type'=>'radiography','id'=>$radiography->id, 'name'=>$radiography->name_patient,'ci'=>$radiography->ci_patient]) }}'"><img src="{{ asset('assets/images/report.png') }}" width="50" height="50"></button>
                <div class="hidden group-hover:block absolute left-0 mt-2 bg-gray-500 bg-opacity-50 text-center rounded-md px-2 py-1"><span class="text-sm text-gray-100">Reporte</span></div>
            </div>
        </div>
    @endif
@endauth

<div>
    <div class="flex justify-center mt-[30px] mb-[30px]"><img src="{{ asset('storage/radiographies/'.$radiography->radiography_uri)}}"/></div>
        <div class="flex justify-center mb-4">
            @auth @if(auth()->user()->role !== 'user') <div class="mt-2"><a href="{{ route('radiography.tool', $radiography->id) }}" class="botton2">Herramientas</a></div> @endif @endauth
        </div>
    </div>
      
<div class="flex justify-center p-5">
@auth
    @if(!in_array(Auth::user()->role, ['user', 'reception']))
        <a href="{{ route('radiography.edit', $radiography->id ) }}" class="botton3"> Editar</a>
    @endif
@endauth
@auth
    @if(Auth::user()->role === 'admin')  
        <form method="POST" action="{{ route('radiography.destroy', $radiography->id) }}" onsubmit="return confirm('¿Estás seguro de que deseas eliminar este estudio?');">
            @csrf
            @method('Delete')
            <input type="submit" value="Eliminar" class="bottonDelete"/>
        </form>
    @endif
@endauth
</div>
@endsection