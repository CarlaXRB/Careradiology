@extends('layouts._partials.layout') 
@section('title', 'Información del estudio')
@section('subtitle')
    {{ __('Información del estudio') }}
@endsection
@section('content')

<div class="flex justify-end">
    <a href="{{ route('conexion.equipo') }}" class="botton1">Atrás</a>
</div>
<h1 class="txt-title2">INFORMACIÓN DEL ESTUDIO</h1>
    @if($imageUrl)
        <div class="flex justify-center p-5">
            <img src="{{ asset($imageUrl) }}" alt="Imagen DICOM procesada" style="max-width: 100%; max-height: 500px;">
        </div>
    @endif
    <div class="grid grid-cols-2 gap-4 text-gray-900 dark:text-white">
        <h3 class="txt2">ID del paciente:</h3><p>{{ $study['PatientMainDicomTags']['PatientID'] ?? 'N/A' }}</p>
        <h3 class="txt2">Nombre del paciente:</h3><p>{{ $study['PatientMainDicomTags']['PatientName'] ?? 'N/A' }}</p>
        <h3 class="txt2">Fecha del estudio:</h3><p>{{ $study['MainDicomTags']['StudyDate'] ?? 'N/A' }}</p>
        <h3 class="txt2">Modalidad:</h3><p>{{ $study['MainDicomTags']['Modality'] ?? 'N/A' }}</p>
        <h3 class="txt2">Descripción:</h3><p>{{ $study['MainDicomTags']['StudyDescription'] ?? 'N/A' }}</p>
        <h3 class="txt2">ID del estudio:</h3><p>{{ $id }}</p>
    </div>
    <div class="flex justify-center mt-5 mb-5"><a href="{{ url('storage/'.$id.'.zip') }}" class="botton3"> Descargar estudio (.zip)</a></div>

    <div class="flex justify-start mt-8 ml-12 mb-3"><h1 class="txt3">Para guardar el estudio del paciente, selecciona su registro:</h1></div>
    <form method="POST" action="{{ route('dicom.saveradiography') }}">
        @csrf
        <div class="flex items-center mb-4">
            <label class="txt1">Paciente:</label>
            <select name="patient_id" class="form-select border-gray-300 dark:border-gray-400 text-black dark:text-black rounded-lg p-2 mt-2 w-full focus:outline-none focus:ring-2 focus:ring-cyan-500 mr-10">
                <option value="">-- Selecciona un paciente --</option>
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
        <div class="flex justify-center"><button type="submit" class="botton2">Guardar</button></div>
    </form>

<div class="mt-5">
    <div class="flex"><h3 class="txt2 mb-2 ml-8">Archivos DICOM encontrados:</h3></div>
    @if(isset($dicomList) && $dicomList->count() > 0)
        <ul class="list-disc pl-6 text-sm space-y-1">
            @foreach($dicomList as $dicom)
                <div class="ml-8 mb-3"><li>
                    <span class="font-mono">{{ $dicom['name'] }}</span>
                    <!-- <span class="opacity-70">({{ $dicom['relative'] }})</span> -->
                </li></div>
            @endforeach
        </ul>
    @else
        <div class="mt-4 p-4 rounded-lg bg-red-500/10 text-red-400">
            No se encontraron archivos DICOM dentro del ZIP extraído.
        </div>
    @endif

    <h3 class="txt-title2" >Metadatos completos:</h3>
    <pre class="bg-gray-800 text-white p-2 rounded-lg whitespace-pre-wrap break-words text-sm">
        {{ json_encode($dicomData['dicom_info'], JSON_PRETTY_PRINT) }}
    </pre>
</div>
@endsection
