@extends('layouts._partials.layout')
@section('title','Create Cita')
@section('subtitle')
    {{ __('Crear Cita') }}
@endsection
@section('content')
<div class="flex justify-end"><a href="{{ route('events.index')}}" class="botton1">Calendario</a></div>
<form method="POST" action="{{ route('events.store') }}">
    @csrf
    <div class="text-gray-900 dark:text-white">
    <h1 class="txt-title2">INGRESAR DATOS</h1>

    <div class="flex items-center mb-4"><label class="txt1">Inicio:</label><input type="datetime-local" name="start_date" value="{{ old('start_date') }}" class="border-gray-300 dark:border-gray-600 rounded-lg p-2 w-full text-black dark:text-black focus:outline-none focus:ring-2 focus:ring-cyan-500 mr-10"/>
    @error('start_date') <p class="error">{{ $message }}</p> @enderror</div>
    <div class="flex items-center mb-4"><label class="txt1">Fin:</label><input type="datetime-local" name="end_date" value="{{ old('end_date') }}" class="border-gray-300 dark:border-gray-600 rounded-lg p-2 w-full text-black dark:text-black focus:outline-none focus:ring-2 focus:ring-cyan-500 mr-10"/>
    @error('end_date') <p class="error">{{ $message }}</p> @enderror</div>

    <div class="flex items-center mb-4"><label class="txt1">Paciente:</label><select name="patient_id" class="form-select border-gray-300 dark:border-gray-400 text-black dark:text-black rounded-lg p-2 mt-2 w-full focus:outline-none focus:ring-2 focus:ring-cyan-500 mr-10">
    <option value="">-- Selecciona un paciente --</option>
        @foreach($patients as $patient)
            <option value="{{ $patient->id }}" class="text-black" {{ old('patient_id') == $patient->id ? 'selected' : '' }}>{{ $patient->name_patient }} - CI: {{ $patient->ci_patient }}</option>
        @endforeach </select>
    @error('patient_id') <p class="error">{{ $message }}</p> @enderror</div>

    <div class="flex items-center mb-4"><label class="txt1">Estudio:</label><input type="text" name="event" value="{{ old('event') }}" class="border-gray-300 dark:border-gray-600 rounded-lg p-2 w-full text-black dark:text-black focus:outline-none focus:ring-2 focus:ring-cyan-500 mr-10"/>
    @error('event') <p class="error">{{ $message }}</p> @enderror</div>

    <div class="flex items-center mb-4"><label class="txt1">Detalles:</label><input type="text" name="details" value="{{ old('details') }}" class="border-gray-300 dark:border-gray-600 rounded-lg p-2 w-full text-black dark:text-black focus:outline-none focus:ring-2 focus:ring-cyan-500 mr-10"/>    
    @error('details') <p class="error">{{ $message }}</p> @enderror</div>

    <div class="flex items-center mb-4"><label class="txt1">Doctor:</label><select name="assigned_doctor" class="form-select border-gray-300 dark:border-gray-400 text-black dark:text-black rounded-lg p-2 mt-2 w-full focus:outline-none focus:ring-2 focus:ring-cyan-500 mr-10">
    <option value="">-- Selecciona un doctor --</option>
        @foreach($doctors as $doctor)
            <option value="{{ $doctor->id }}" class="text-black" {{ old('assigned_doctor') == $doctor->id ? 'selected' : '' }}>{{ $doctor->name }}</option>
        @endforeach</select>
    @error('assigned_doctor') <p class="error">{{ $message }}</p> @enderror</div>

    <div class="flex items-center mb-4"><label class="txt1">Radiólogo:</label><select name="assigned_radiologist" class="form-select border-gray-300 dark:border-gray-400 text-black dark:text-black rounded-lg p-2 mt-2 w-full focus:outline-none focus:ring-2 focus:ring-cyan-500 mr-10">
    <option value="">-- Selecciona un radiólogo --</option>
        @foreach($radiologists as $radiology)
            <option value="{{ $radiology->id }}" class="text-black" {{ old('assigned_radiologist') == $radiology->id ? 'selected' : '' }}>{{ $radiology->name }}</option>
        @endforeach</select>
    @error('assigned_radiologist') <p class="error">{{ $message }}</p> @enderror</div>

    </div>
        <div class="flex justify-center mb-4">
            <input type="submit" value="Crear" class="botton3"/>
        </div>
    </div>
</form>
@endsection
