@extends('layouts._partials.layout')
@section('title','Edit Tomography')
@section('subtitle')
    {{ __('Editar Tomografia') }}
@endsection
@section('content')
<div class="flex justify-end"><a href="{{ route('dashboard') }}" class="botton1">Inicio</a></div>
    <form method="POST" action="{{ route('tomography.update', $tomography->id) }}">
        @method('PUT')
        @csrf
        <div class="text-gray-900 dark:text-white">
        <div class="flex items-center mb-4"><label class="txt1">Nombre del paciente:</label>
            <select name="patient_id" class="form-select border-gray-300 dark:border-gray-400 text-black dark:text-black rounded-lg p-2 mt-2 w-full focus:outline-none focus:ring-2 focus:ring-cyan-500 mr-10">
                <option value="{{ $tomography->patient->id }}">{{ $tomography->name_patient }} - CI: {{ $tomography->ci_patient }}</option>
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
        <div class="flex items-center mb-4"><label class="txt1">ID Tomografia:</label><input type="text" name="tomography_id" value="{{ $tomography->tomography_id }}" class="border-gray-300 dark:border-gray-600 rounded-lg p-2 w-full text-black dark:text-black focus:outline-none focus:ring-2 focus:ring-cyan-500 mr-10"/></div>
        @error('tomography') <p class="error">{{ $message }}</p> @enderror
        <div class="flex items-center mb-4"><label class="txt1">Fecha del estudio:</label><input type="date" name="tomography_date" value="{{ $tomography->tomography_date }}"class="border-gray-300 dark:border-gray-600 rounded-lg p-2 w-full text-black dark:text-black focus:outline-none focus:ring-2 focus:ring-cyan-500 mr-10"/></div>
        @error('tomography_date') <p class="error">{{ $message }}</p> @enderror
        <div class="flex items-center mb-4"><label class="txt1">Tipo de tomografia:</label><input type="text" name="tomography_type" value="{{ $tomography->tomography_type }}" class="border-gray-300 dark:border-gray-600 rounded-lg p-2 w-full text-black dark:text-black focus:outline-none focus:ring-2 focus:ring-cyan-500 mr-10"/></div>
        @error('tomography_type') <p class="error">{{ $message }}</p> @enderror
        <div class="flex items-center mb-4"><label class="txt1">Doctor:</label><input type="text" name="tomography_doctor" value="{{ $tomography->tomography_doctor }}" class="border-gray-300 dark:border-gray-600 rounded-lg p-2 w-full text-black dark:text-black focus:outline-none focus:ring-2 focus:ring-cyan-500 mr-10"/></div>
        @error('tomography_doctor') <p class="error">{{ $message }}</p> @enderror
        <div class="flex items-center mb-4"><label class="txt1">Radiologo:</label><input type="text" name="tomography_charge" value="{{ $tomography->tomography_charge }}" class="border-gray-300 dark:border-gray-600 rounded-lg p-2 w-full text-black dark:text-black focus:outline-none focus:ring-2 focus:ring-cyan-500 mr-10"/></div>
        @error('tomography_charge') <p class="error">{{ $message }}</p> @enderror
        <div class="flex justify-center mb-4"><input type="submit" value="Actualizar" class="botton3"/></div>
        </div>
    </form>
@endsection