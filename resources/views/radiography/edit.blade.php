@extends('layouts._partials.layout')
@section('title','Edit Radiography')
@section('subtitle')
    {{ __('Editar Radiografia') }}
@endsection
@section('content')
<div class="flex justify-end"><a href="{{ route('dashboard') }}" class="botton1">Inicio</a></div>
    <form method="POST" action="{{ route('radiography.update', $radiography->id) }}">
        @method('PUT')
        @csrf
        <div class="text-gray-900 dark:text-white">
        <div class="flex items-center mb-4"><label class="txt1">Nombre del paciente:</label>
            <select name="patient_id" class="form-select border-gray-300 dark:border-gray-400 text-black dark:text-black rounded-lg p-2 mt-2 w-full focus:outline-none focus:ring-2 focus:ring-cyan-500 mr-10">
                <option value="{{ $radiography->patient->id }}">{{ $radiography->name_patient }} - CI: {{ $radiography->ci_patient }}</option>
                @foreach($patients as $patient)
                    <option value="{{ $patient->id }}" class="text-black" {{ old('patient_id') == $patient->id ? 'selected' : '' }}>
                        {{ $patient->name_patient }} - CI: {{ $patient->ci_patient }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="flex justify-end">
            <p>¿Paciente no registrado?</p>
            <div class="ml-5 mb-5 mr-8"><a href="{{ route('patient.create')}}" class="botton3">Registrar Paciente</a></div>
        </div>
        <div class="flex items-center mb-4"><label class="txt1">ID Radiografia:</label><input type="text" name="radiography_id" value="{{ $radiography->radiography_id }}" class="border-gray-300 dark:border-gray-600 rounded-lg p-2 w-full text-black dark:text-black focus:outline-none focus:ring-2 focus:ring-cyan-500 mr-10"/></div>
        @error('radiography') <p class="error">{{ $message }}</p> @enderror
        <div class="flex items-center mb-4"><label class="txt1">Fecha del estudio:</label><input type="date" name="radiography_date" value="{{ $radiography->radiography_date }}"class="border-gray-300 dark:border-gray-600 rounded-lg p-2 w-full text-black dark:text-black focus:outline-none focus:ring-2 focus:ring-cyan-500 mr-10"/></div>
        @error('radiography_date') <p class="error">{{ $message }}</p> @enderror
        <div class="flex items-center mb-4"><label class="txt1">Tipo de radiografia:</label><input type="text" name="radiography_type" value="{{ $radiography->radiography_type }}" class="border-gray-300 dark:border-gray-600 rounded-lg p-2 w-full text-black dark:text-black focus:outline-none focus:ring-2 focus:ring-cyan-500 mr-10"/></div>
        @error('radiography_type') <p class="error">{{ $message }}</p> @enderror
        <div class="flex items-center mb-4"><label class="txt1">Doctor:</label><input type="text" name="radiography_doctor" value="{{ $radiography->radiography_doctor }}" class="border-gray-300 dark:border-gray-600 rounded-lg p-2 w-full text-black dark:text-black focus:outline-none focus:ring-2 focus:ring-cyan-500 mr-10"/></div>
        @error('radiography_doctor') <p class="error">{{ $message }}</p> @enderror
        <div class="flex items-center mb-4"><label class="txt1">Radiologo:</label><input type="text" name="radiography_charge" value="{{ $radiography->radiography_charge }}" class="border-gray-300 dark:border-gray-600 rounded-lg p-2 w-full text-black dark:text-black focus:outline-none focus:ring-2 focus:ring-cyan-500 mr-10"/></div>
        @error('radiography_charge') <p class="error">{{ $message }}</p> @enderror
        <div class="flex justify-center mb-4"><input type="submit" value="Actualizar" class="botton3"/></div>
        </div>
    </form>
@endsection