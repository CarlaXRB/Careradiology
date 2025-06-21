@extends('layouts._partials.layout')
@section('title','Create Radiography')
@section('subtitle')
    {{ __('Crear Radiografia') }}
@endsection
@section('content')
<div class="flex justify-end"><a href="{{ route('radiography.index') }}" class="botton1">Radiografías</a></div>
    <form method="POST" action="{{ route('radiography.store') }}" enctype="multipart/form-data">
        @csrf
        <div class="text-gray-900 dark:text-white">
        <div class="flex items-center mb-4"><label class="txt1">Nombre del paciente:</label><input type="text" name="name_patient" value="{{ old('name_patient')}}" class="border-gray-300 dark:border-gray-600 rounded-lg p-2 w-full text-black dark:text-black focus:outline-none focus:ring-2 focus:ring-cyan-500 mr-10"/></div>
        @error('name_patient') <p class="error">{{ $message }}</p> @enderror 
        <div class="flex items-center mb-4"><label class="txt1">Carnet de identidad:</label><input type="text" name="ci_patient" value="{{ old('ci_patient')}}" class="border-gray-300 dark:border-gray-600 rounded-lg p-2 w-full text-black dark:text-black focus:outline-none focus:ring-2 focus:ring-cyan-500 mr-10"/></div>
        @error('ci_patient') <p class="error">{{ $message }}</p> @enderror
        <div class="flex items-center mb-4"><label class="txt1">ID Radiografia:</label><input type="text" name="radiography_id" value="{{ old('radiography_id')}}" class="border-gray-300 dark:border-gray-600 rounded-lg p-2 w-full text-black dark:text-black focus:outline-none focus:ring-2 focus:ring-cyan-500 mr-10"/></div>
        @error('radiography') <p class="error">{{ $message }}</p> @enderror
        <div class="flex items-center mb-4"><label class="txt1">Fecha del estudio:</label><input type="date" name="radiography_date" value="{{ old('radiography_date')}}" class="border-gray-300 dark:border-gray-600 rounded-lg p-2 w-full text-black dark:text-black focus:outline-none focus:ring-2 focus:ring-cyan-500 mr-10"/></div>
        @error('radiography_date') <p class="error">{{ $message }}</p> @enderror
        <div class="flex items-center mb-4"><label class="txt1">Tipo de radiografia:</label><input type="text" name="radiography_type" value="{{ old('radiography_type')}}" class="border-gray-300 dark:border-gray-600 rounded-lg p-2 w-full text-black dark:text-black focus:outline-none focus:ring-2 focus:ring-cyan-500 mr-10"/></div>
        @error('radiography_type') <p class="error">{{ $message }}</p> @enderror
        <div class="flex items-center mb-4"><label class="txt1">Subir archivo:</label><input type="file" name="radiography_file"/></div>
        @error('radiography_file') <p class="error">{{ $message }}</p> @enderror
        <div class="flex items-center mb-4"><label class="txt1">Doctor:</label><input type="text" name="radiography_doctor" value="{{ old('radiography_doctor')}}" class="border-gray-300 dark:border-gray-600 rounded-lg p-2 w-full text-black dark:text-black focus:outline-none focus:ring-2 focus:ring-cyan-500 mr-10"/></div>
        @error('radiography_doctor') <p class="error">{{ $message }}</p> @enderror
        <div class="flex items-center mb-4"><label class="txt1">Radiologo:</label><input type="text" name="radiography_charge" value="{{ old('radiography_charge')}}" class="border-gray-300 dark:border-gray-600 rounded-lg p-2 w-full text-black dark:text-black focus:outline-none focus:ring-2 focus:ring-cyan-500 mr-10"/></div>
        @error('radiography_charge') <p class="error">{{ $message }}</p> @enderror
        <div class="flex justify-center mb-4"><input type="submit" value="Subir" class="botton3"/></div>
        </div>
    </form>
@endsection