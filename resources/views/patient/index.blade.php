@extends('layouts._partials.layout')
@section('title','Patient')
@section('subtitle')
    {{ __('Pacientes') }}
@endsection
@section('content')
<div class="grid grid-cols-2" >
    <div><form method="POST" action="{{ route('patient.search') }}">
        @csrf
        <input type="text" placeholder="Buscar" name="search" style="color: #333; font-size: 16px;  padding: 10px 15px; border-radius: 20px; margin-top: 5px; margin-left: 5px;"/>
        <input class="botton4" type="submit" value="Buscar"/>
    </form></div>
    <div class="flex justify-end"><a href="{{route('patient.create')}}" class="botton1">Crear Paciente</a> </div>
</div>
<h1 class="txt-title1">PACIENTES</h1>
<div class="grid grid-cols-4 gap-4 border-b border-cyan-500 mb-3">
    <h3 class="txt-head">Carnet de Identidad</h3>
    <h3 class="txt-head">Nombre del paciente</h3>
    <h3 class="txt-head">Contacto</h3>
</div>
<ul>
    @forelse($patients as $patient)
    <div class="flex justify-center grid grid-cols-4 border-b border-gray-600 gap-4 mb-3 text-white pl-6">
        <div class="ml-8"><a href="{{ route('patient.show', $patient->id) }}"> {{ $patient->ci_patient }} </a></div>
        <div class="ml-8"><a href="{{ route('patient.show', $patient->id) }}"> {{ $patient->name_patient }} </a></div>
        <div class="ml-8"><a href="{{ route('patient.show', $patient->id) }}"> {{ $patient->patient_contact }} </a></div>
        <div class="flex justify-center mb-4"><a href="{{ route('patient.edit', $patient->id ) }}" class="botton3"> Editar</a>
        @auth
            @if(Auth::user()->role === 'admin')  
            <form method="POST" action="{{ route('patient.destroy', $patient->id) }}" onsubmit="return confirm('¿Estás seguro de que deseas eliminar este paciente?');">
                @csrf
                @method('Delete')
                <div class="flex justify-end"><input type="submit" value="Eliminar" class="botton2"/></div>
            </form>
            @endif
        @endauth
        </div>
    </div>
    @empty
    <p>No data</p>
    @endforelse
    {{ $patients->links()}}
</ul>
@endsection