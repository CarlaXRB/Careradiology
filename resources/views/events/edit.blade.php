@extends('layouts._partials.layout')

@section('title','Editar Cita')

@section('subtitle')
    {{ __('Editar Cita') }}
@endsection

@section('content')
<div class="flex justify-end">
    <a href="{{ route('events.index')}}" class="botton1">Calendario</a>
</div>

<form method="POST" action="{{ route('events.update', $event->id) }}">
    @csrf
    @method('PUT')
    <div class="text-gray-900 dark:text-white">
        <h1 class="txt-title2">INGRESAR DATOS</h1>
        <div class="flex items-center mb-4">
            <label class="txt1">Paciente:</label>
            <select name="patient_id" class="form-select border-gray-300 dark:border-gray-400 text-black dark:text-black rounded-lg p-2 mt-2 w-full focus:outline-none focus:ring-2 focus:ring-cyan-500 mr-10">
                <option value="">{{ '-- Selecciona un paciente --' }}</option>
                @foreach($patients as $patient)
                    <option value="{{ $patient->id }}" class="text-black" 
                        {{ (old('patient_id', $event->patient_id) == $patient->id) ? 'selected' : '' }}>
                        {{ $patient->name_patient }} - CI: {{ $patient->ci_patient }}
                    </option>
                @endforeach
            </select>
        </div>
        @error('patient_id') <p class="error">{{ $message }}</p> @enderror
        <div class="flex items-center mb-4">
            <label class="txt1">Inicio:</label>
            <input type="datetime-local" name="start_date" value="{{ $event->start_date }}" class="border-gray-300 dark:border-gray-600 rounded-lg p-2 w-full text-black dark:text-black focus:outline-none focus:ring-2 focus:ring-cyan-500 mr-10"/>
        </div>
        @error('start_date') <p class="error">{{ $message }}</p> @enderror

        <div class="flex items-center mb-4">
            <label class="txt1" for="duration_minutes">Duración del estudio (minutos)</label>
            <input type="number" name="duration_minutes" id="duration_minutes" min="1" required value="{{ $event->duration_minutes }}" class="border-gray-300 dark:border-gray-600 rounded-lg p-2 w-full text-black dark:text-black focus:outline-none focus:ring-2 focus:ring-cyan-500 mr-10">
        </div>
        @error('duration_minutes') <p class="error">{{ $message }}</p> @enderror

        <div class="flex items-center mb-4">
            <label for="room" class="txt1">Sala</label>
            <select name="room" id="room" class="form-select border-gray-300 dark:border-gray-400 text-black dark:text-black rounded-lg p-2 mt-2 w-full focus:outline-none focus:ring-2 focus:ring-cyan-500 mr-10" required>
                <option value="{{ $event->room }}" class="text-black">{{ $event->room ?? '-- Selecciona una sala --' }}</option>
                <option value="Sala 1" class="text-black">Sala 1</option>
                <option value="Sala 2" class="text-black">Sala 2</option>
            </select>
        </div>
        @error('room') <p class="error">{{ $message }}</p> @enderror

        <div class="flex items-center mb-4">
            <label class="txt1">Estudio:</label>
            <input type="text" name="event" value="{{ $event->event }}" class="border-gray-300 dark:border-gray-600 rounded-lg p-2 w-full text-black dark:text-black focus:outline-none focus:ring-2 focus:ring-cyan-500 mr-10"/>
        </div>
        @error('event') <p class="error">{{ $message }}</p> @enderror

        <div class="flex items-center mb-4">
            <label class="txt1">Detalles:</label>
            <input type="text" name="details" value="{{ $event->details }}" class="border-gray-300 dark:border-gray-600 rounded-lg p-2 w-full text-black dark:text-black focus:outline-none focus:ring-2 focus:ring-cyan-500 mr-10"/>    
        </div>
        @error('details') <p class="error">{{ $message }}</p> @enderror

        <div class="flex items-center mb-4">
            <label class="txt1">Doctor:</label>
            <select name="assigned_doctor" class="form-select border-gray-300 dark:border-gray-400 text-black dark:text-black rounded-lg p-2 mt-2 w-full focus:outline-none focus:ring-2 focus:ring-cyan-500 mr-10">
                <option value="{{ $event->assigned_doctor }}">{{ $event->assignedDoctor->name ?? '-- Selecciona un doctor --' }}</option>
                @foreach($doctors as $doctor)
                    <option value="{{ $doctor->id }}" class="text-black" {{ old('assigned_doctor') == $doctor->id ? 'selected' : '' }}>{{ $doctor->name }}</option>
                @endforeach
            </select>
        </div>
        @error('assigned_doctor') <p class="error">{{ $message }}</p> @enderror

        <div class="flex items-center mb-4">
            <label class="txt1">Radiólogo:</label>
            <select name="assigned_radiologist" class="form-select border-gray-300 dark:border-gray-400 text-black dark:text-black rounded-lg p-2 mt-2 w-full focus:outline-none focus:ring-2 focus:ring-cyan-500 mr-10">
                <option value="{{ $event->assigned_radiologist }}">{{ $event->assignedRadiologist->name ?? '-- Selecciona un radiólogo --' }}</option>
                @foreach($radiologists as $radiology)
                    <option value="{{ $radiology->id }}" class="text-black" {{ old('assigned_radiologist') == $radiology->id ? 'selected' : '' }}>{{ $radiology->name }}</option>
                @endforeach
            </select>
        </div>
        @error('assigned_radiologist') <p class="error">{{ $message }}</p> @enderror

        <div class="flex justify-center mb-4">
            <input type="submit" value="Actualizar" class="botton3"/>
        </div>
    </div>
</form>
@endsection
