@extends('layouts._partials.layout')

@section('title','Cita Information')
@section('subtitle')
    {{ __('Información de la Cita') }}
@endsection

@section('content')
<div class="flex justify-end">
    <a href="{{ route('events.index')}}" class="botton1">Calendario</a>
</div>

<h1 class="txt-title2 mb-10">INFORMACIÓN DE LA CITA</h1>

<div class="grid grid-cols-2 text-gray-900 dark:text-white">
    <h3 class="txt2">Paciente:</h3><p>{{ $event->patient->name_patient }}</p>
    <p> </p><a href="{{ route('patient.show', $event->patient->id ) }}" class="text-green-500 mb-4">Ver paciente</a>
</div>
<div class="grid grid-cols-2 gap-4 text-gray-900 dark:text-white">
    <h3 class="txt2">Evento:</h3><p>{{ $event->event }}</p>
    <h3 class="txt2">Inicio:</h3><p>{{ \Carbon\Carbon::parse($event->start_date)->format('d-m-Y H:i') }}</p>
    <h3 class="txt2">Fin:</h3><p>{{ \Carbon\Carbon::parse($event->end_date)->format('d-m-Y H:i') }}</p>
    <h3 class="txt2">Doctor:</h3><p>{{ $event->assignedDoctor->name ?? 'No asignado' }}</p>
    <h3 class="txt2">Radiólogo:</h3><p>{{ $event->assignedRadiologist->name ?? 'No asignado' }}</p>
    <h3 class="txt2">Detalles:</h3><p class="mb-8">{{ $event->details ?? 'No hay detalles' }}</p>
</div>
@endsection
