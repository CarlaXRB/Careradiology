@extends('layouts._partials.layout')
@section('title','Edit Patient')
@section('subtitle')
    {{ __('Editar Paciente') }}
@endsection
@section('content')
<div class="flex justify-end"><a href="{{ route('patient.index')}}" class="botton1">Atrás</a></div>
    <form method="POST" action="{{ route('patient.update', $patient->id) }}">
    @method('PUT')
    @csrf
    <div class="text-gray-900 dark:text-white">
        <div class="flex items-center mb-4"><label class="txt1">Nombre del paciente:</label><input type="text" name="name_patient" value="{{ $patient->name_patient }}" class="border-gray-300 dark:border-gray-600 rounded-lg p-2 w-full text-black dark:text-black focus:outline-none focus:ring-2 focus:ring-cyan-500 mr-10"/></br></div> 
        @error('name_patient') <p class="error">{{ $message }}</p> @enderror
        <div class="flex items-center mb-4"><label class="txt1">Carnet de identidad:</label><input type="text" name="ci_patient" value="{{ $patient->ci_patient }}" class="border-gray-300 dark:border-gray-600 rounded-lg p-2 w-full text-black dark:text-black focus:outline-none focus:ring-2 focus:ring-cyan-500 mr-10"/></br></div>
        @error('ci_patient') <p class="error">{{ $message }}</p> @enderror
        <div class="flex items-center mb-4"><label class="txt1">Correo electronico:</label><input type="text" name="email" value="{{ $patient->email}}" class="border-gray-300 dark:border-gray-600 rounded-lg p-2 w-full text-black dark:text-black focus:outline-none focus:ring-2 focus:ring-cyan-500 mr-10"/></br></div>
        @error('email') <p class="error">{{ $message }}</p> @enderror
        <div class="flex items-center mb-4"><label class="txt1">Fecha de naciemiento:</label><input type="date" name="birth_date" value="{{ $patient->birth_date }}" class="border-gray-300 dark:border-gray-600 rounded-lg p-2 w-full text-black dark:text-black focus:outline-none focus:ring-2 focus:ring-cyan-500 mr-10"/></br></div>
        @error('birth_date') <p class="error">{{ $message }}</p> @enderror
        <div class="flex items-center mb-4">
        <label class="txt1">Género:</label>
            <select name="gender" class="form-select border-gray-300 dark:border-gray-600 text-black dark:text-black rounded-lg p-2 mt-2 w-full focus:outline-none focus:ring-2 focus:ring-cyan-500 mr-10">
            <option value="femenino">Femenino</option>
            <option value="masculino">Masculino</option>
            </select>
        </div>
        <div class="flex items-center mb-4"><label class="txt1">Contacto del paciente:</label><input type="text" name="patient_contact" value="{{ $patient->patient_contact }}" class="border-gray-300 dark:border-gray-600 rounded-lg p-2 w-full text-black dark:text-black focus:outline-none focus:ring-2 focus:ring-cyan-500 mr-10"/></br></div>
        @error('patient_contact') <p class="error">{{ $message }}</p> @enderror
        <div class="flex items-center mb-4"><label class="txt1">Contacto del familiar:</label><input type="text" name="family_contact" value="{{ $patient->family_contact }}" class="border-gray-300 dark:border-gray-600 rounded-lg p-2 w-full text-black dark:text-black focus:outline-none focus:ring-2 focus:ring-cyan-500 mr-10"/></br></div>
        @error('family_contact') <p class="error">{{ $message }}</p> @enderror
        <div class="flex justify-center mb-4"><input type="submit" value="Actualizar" class="botton3"/></div>
    </div>
    </form>
</div>
</body>
</html>
@endsection