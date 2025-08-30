@extends('layouts._partials.layout')

@section('title','Cita Information')
@section('subtitle')
    {{ __('Información de la Cita') }}
@endsection
@section('content')

@auth @if(auth()->user()->role === 'user')
    <div class="flex justify-end"><a href="{{ route('dashboard') }}" class="botton1">Inicio</a></div>
@endif @endauth

@auth
    @if(auth()->user()->role !== 'user')
    <div class="flex justify-end">
        <a href="{{ route('events.index')}}" class="botton1">Calendario</a>
    </div>
    @endif
@endauth

<div class="mt-10 mb-5"><h1 class="txt-title2">INFORMACIÓN DE LA CITA</h1></div>

<div class="grid grid-cols-2 text-gray-900 dark:text-white">
    <div class="mb-3"><h3 class="txt2">Paciente:</h3></div><p>{{ $event->patient->name_patient ?? 'Sin información' }}</p><p> </p>
    @if($event->patient)
    @auth @if(auth()->user()->role !== 'user') <a href="{{ route('patient.show', $event->patient->id ) }}" class="text-green-500 mb-3">Ver paciente</a> @endif @endauth
    @else
        <p class="text-red-500 mb-3">Paciente no registrado en la base de datos.</p>
    @endif
</div>

<div class="grid grid-cols-2 gap-4 text-gray-900 dark:text-white">
    <h3 class="txt2">Evento:</h3><p>{{ $event->event }}</p>
    <h3 class="txt2">Inicio:</h3><p>{{ \Carbon\Carbon::parse($event->start_date)->format('d-m-Y H:i') }}</p>
    <h3 class="txt2">Fin:</h3><p>{{ \Carbon\Carbon::parse($event->end_date)->format('d-m-Y H:i') }}</p>
    <h3 class="txt2">Duración:</h3><p>{{ $event->duration_minutes }} minutos</p>
    <h3 class="txt2">Sala:</h3><p>{{ $event->room }}</p>
    <h3 class="txt2">Doctor:</h3><p>{{ $event->assignedDoctor->name ?? 'No asignado' }}</p>
    <h3 class="txt2">Radiólogo:</h3><p>{{ $event->assignedRadiologist->name ?? 'No asignado' }}</p>
    <h3 class="txt2">Detalles:</h3><p>{{ $event->details ?? 'No hay detalles' }}</p>
    <h3 class="txt2">Creado por:</h3><p class="mb-8">{{ $event->creator->name ?? 'Sin información' }}</p>
</div>
@auth
    @if(Auth::user()->role === 'admin')  
    <div>
        <div class="flex justify-center mb-4"><a href="{{ route('events.edit', $event->id ) }}" class="botton3"> Editar</a></div>
    </div>
    <div>       
        <form method="POST" action="{{ route('events.destroy', $event->id) }}" onsubmit="return confirm('¿Estás seguro de que deseas eliminar esta cita?');">
            @csrf
            @method('Delete')
            <div class="flex justify-end mb-8 mr-8"><input type="submit" value="Eliminar" class="bottonDelete"/></div>
        </form>
    </div>
    @endif
@endauth
@endsection
