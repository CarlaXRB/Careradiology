@extends('layouts._partials.layout')
@section('title', 'Imágenes Procesadas DICOM')
@section('subtitle')
    {{ __('DICOM con Metadatos') }}
@endsection
@section('content')
@if ($dicomRecord)
<div class="flex justify-end">
    <a href="{{ route('dashboard') }}" class="botton1">Inicio</a>
</div>
    <div class="container mt-12 mb-12">
        <div class="mb-8"><h1 class="txt-title2">IMAGENES DICOM</h1></div>
        <div style="display: flex; justify-content: center;">
            <img id="mainImage" src="{{ asset($images[0]) }}" class="rounded-md" style="width: 600px; height: auto;" alt="Imagen principal">

            <div id="thumbnailContainer" style="width: 180px; overflow-y: auto; max-height: 600px; padding: 10px; margin-left: 20px; margin-right: 20px;">
                @foreach ($images as $index => $image)
                    <div style="margin-bottom: 10px;">
                        <img src="{{ asset($image) }}" 
                             onclick="changeMainImage('{{ asset($image) }}', this)" 
                             style="width: 100%; cursor: pointer; border: 2px solid {{ $index == 0 ? 'cyan' : 'transparent' }}; border-radius: 5px;" 
                             class="thumbnail">
                        <div style="font-size: 12px; color: #808080; text-align: center;">
                            {{ basename($image) }}
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
    <h2 class="txt-title2">Información del Paciente</h2>
    <div class="grid grid-cols-2 gap-4">
        <h2 class="txt2">Paciente:</h2> <p> {{ $dicomRecord['patient_name'] }}</p>
        <h2 class="txt2">ID del Paciente:</h2> <p> {{ $dicomRecord['patient_id'] }}</p>
        <h2 class="txt2">Modalidad:</h2> <p> {{ $dicomRecord['modality'] }}</p>
        <h2 class="txt2">Fecha del Estudio:</h2> <p> {{ $dicomRecord['study_date'] }}</p>
        <!-- <h2 class="txt2">Tamaño de la imagen:</h2> <p> {{ $dicomRecord['rows'] }}x{{ $dicomRecord['columns'] }}</p> -->
    </div>
        <div class="flex justify-start mt-8 ml-12 mb-3"><h1 class="txt3">Para guardar el estudio del paciente, selecciona su registro:</h1></div>
    <form method="POST" action="{{ route('dicom.savetomography') }}">
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
            <div class="ml-5 mb-5 mr-8"><a href="{{ route('patient.create')}}" class="botton2">Registrar Paciente</a></div>
        </div>
        <div class="flex justify-center mt-5"><button type="submit" class="botton3">Guardar</button></div>
    </form>
    <div class="ml-10 mt-8 mb-6">
        <div class="flex mt-3 mb-3"><h3 class="txt2">Metadatos completos:</h3></div>
        @php
            $metadata = json_decode($dicomRecord->metadata, true);
        @endphp
        @foreach ($metadata as $key => $value)
            <p>{{ ucfirst(str_replace('_', ' ', $key)) }}: {{ is_array($value) ? json_encode($value) : $value }}</p>
        @endforeach
    </div>
@else
    <p class="ml-10 text-lg">No se encontraron datos del paciente para esta carpeta.</p>
@endif

<script>
    function changeMainImage(imageSrc, thumbElement) {
        const mainImage = document.getElementById('mainImage');
        mainImage.src = imageSrc;
        document.querySelectorAll('.thumbnail').forEach(img => {
            img.style.border = '2px solid transparent';
        });
        thumbElement.style.border = '2px solid cyan';
    }
</script>
@endsection

