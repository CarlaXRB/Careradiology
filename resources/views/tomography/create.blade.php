@extends('layouts._partials.layout')
@section('title','Create Tomography')
@section('subtitle')
    {{ __('Crear Tomografia') }}
@endsection
@section('content')
<div class="flex justify-end"><a href="{{ route('tomography.index') }}" class="botton1">Tomografias</a></div>
    <form method="POST" action="{{ route('tomography.store') }}" enctype="multipart/form-data">
        @csrf
        <div class="text-gray-900 dark:text-white">
        <div class="flex items-center mb-4"><label class="txt1">Nombre del paciente:</label><input type="text" name="name_patient" value="{{ old('name_patient')}}" class="border-gray-300 dark:border-gray-600 rounded-lg p-2 w-full text-black dark:text-black focus:outline-none focus:ring-2 focus:ring-cyan-500 mr-10"/></div>
        @error('name_patient') <p class="error">{{ $message }}</p> @enderror
        <div class="flex items-center mb-4"><label class="txt1">Carnet de identidad:</label><input type="text" name="ci_patient" value="{{ old('ci_patient')}}" class="border-gray-300 dark:border-gray-600 rounded-lg p-2 w-full text-black dark:text-black focus:outline-none focus:ring-2 focus:ring-cyan-500 mr-10"/></div>
        @error('ci_patient') <p class="error">{{ $message }}</p> @enderror
        <div class="flex items-center mb-4"><label class="txt1">ID Tomografia:</label><input type="text" name="tomography_id" value="{{ old('tomography_id')}}" class="border-gray-300 dark:border-gray-600 rounded-lg p-2 w-full text-black dark:text-black focus:outline-none focus:ring-2 focus:ring-cyan-500 mr-10"/></div>
        @error('tomography') <p class="error">{{ $message }}</p> @enderror
        <div class="flex items-center mb-4"><label class="txt1">Fecha del estudio:</label><input type="date" name="tomography_date" value="{{ old('tomography_date')}}" class="border-gray-300 dark:border-gray-600 rounded-lg p-2 w-full text-black dark:text-black focus:outline-none focus:ring-2 focus:ring-cyan-500 mr-10"/></div>
        @error('tomography_date') <p class="error">{{ $message }}</p> @enderror
        <div class="flex items-center mb-4"><label class="txt1">Tipo de Tomografia:</label><input type="text" name="tomography_type" value="{{ old('tomography_type')}}" class="border-gray-300 dark:border-gray-600 rounded-lg p-2 w-full text-black dark:text-black focus:outline-none focus:ring-2 focus:ring-cyan-500 mr-10"/></div>
        @error('tomography_type') <p class="error">{{ $message }}</p> @enderror
        <div class="flex items-center mb-4"><label class="txt1">Subir archivo:</label><input type="file" name="tomography_file" value="{{ old('tomography_file')}}" class="border-gray-300 dark:border-gray-600 rounded-lg p-2 w-full text-black dark:text-black focus:outline-none focus:ring-2 focus:ring-cyan-500 mr-10"/></div>
        @error('tomography_file') <p class="error">{{ $message }}</p> @enderror
        <div class="flex items-center mb-4"><label class="txt1">Doctor:</label><input type="text" name="tomography_doctor" value="{{ old('tomography_doctor')}}" class="border-gray-300 dark:border-gray-600 rounded-lg p-2 w-full text-black dark:text-black focus:outline-none focus:ring-2 focus:ring-cyan-500 mr-10"/></div>
        @error('tomography_doctor') <p class="error">{{ $message }}</p> @enderror
        <div class="flex items-center mb-4"><label class="txt1">Radiologo:</label><input type="text" name="tomography_charge" value="{{ old('tomography_charge')}}" class="border-gray-300 dark:border-gray-600 rounded-lg p-2 w-full text-black dark:text-black focus:outline-none focus:ring-2 focus:ring-cyan-500 mr-10"/></div>
        @error('tomography_charge') <p class="error">{{ $message }}</p> @enderror
        <div class="flex justify-center mb-4"><input type="submit" value="Subir" class="botton2"/></div>
        </div>
    </form>
@endsection