@extends('layouts._partials.layout')
@section('title','Show Tomography')
@section('subtitle')
    {{ __('Visualizar Tomografía') }}
@endsection
@section('content')

<div class="flex justify-end"><a href="{{ route('tomography.index')}}" class="botton1">Volver a Tomografía</a></div>
<div class="flex ml-10"><h1 class="txt-title2">Paciente:</h1></div>
@if($tomography->patient)
    <h1 class="text-[22px] ml-12 mb-5">{{ $tomography->patient->name_patient }}</h1>
    <div class="ml-10 mt-4"><a href="{{ route('patient.show', $tomography->patient->id ) }}" class="botton3">Ver paciente</a></div>
@else
    <div class="text-[22px]"><h3 class="ml-10 mb-2">{{ $tomography->name_patient}} </h3></div>
    <h1 class="ml-10 mb-5">Paciente no registrado en la base de datos.</h1>
@endif

<div class="grid grid-cols-2 gap-4">
    <h3 class="txt2">ID Tomografía:</h3><p>{{ $tomography->tomography_id}} </p>
    <h3 class="txt2">Fecha de la tomografía:</h3><p>{{ $tomography->tomography_date }} </p>
    <h3 class="txt2">Tipo de tomografía:</h3><p>{{ $tomography->tomography_type }} </p>
    <h3 class="txt2">Doctor que solicitó el estudio:</h3><p>{{ $tomography->tomography_doctor }} </p>
    <h3 class="txt2">Radiólogo:</h3><p>{{ $tomography->tomography_charge }} </p>
</div>

<div class="relative flex justify-center mt-[50px] mb-[30px]">
    <div class="overflow-auto" style="width: 1100px; height: 700px; position: relative;">
        @if(!empty($images))
            @foreach($images as $key => $image)
                <img id="image-{{ $key }}" src="{{ asset('storage/tomographies/converted_images/' . $tomography->id . '/' . basename($image)) }}" 
                alt="Imagen {{ $key + 1 }}" 
                style="width: 100%; height: 100%; object-fit: contain; transition: transform 0.2s; position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); {{ $key === 0 ? '' : 'display: none;' }}">
            @endforeach
        @else
            <p>No hay imágenes disponibles.</p>
        @endif
    </div>
</div>
<div id="image-name" style="text-align: center; font-size: 14px; color: #808080;">{{ basename($images[0] ?? '') }}</div>

<div id="controls" class="relative flex justify-center mt-[30px] mb-[30px]">
    <button id="prev-btn" class="botton3">Anterior</button>
    <button id="next-btn" class="botton3">Siguiente</button>
    <button id="enable-scroll" class="botton2">Habilitar cambio con rueda</button>
</div>

<div class="relative flex justify-center mt-[20px] mb-[5px]"><p>Herramientas:</p></div>
<div class="relative flex justify-center mb-[50px]">
    <div class="group relative">
        <button id="overlayButton" class="btnimg"><img src="{{ asset('assets/images/sup.png') }}" width="50" height="50"></button>
        <div class="hidden group-hover:block absolute left-0 mt-2 bg-gray-500 bg-opacity-50 text-center rounded-md px-2 py-1"><span class="text-xs text-gray-100">Superposición</span></div>
    </div>
    <form id="saveImageForm" action="{{ route('tool.storeTomography', ['tomography_id' => $tomography->tomography_id, 'ci_patient' => $tomography->ci_patient, 'id' => $tomography->id]) }}" method="POST">
    @csrf
    <div class="group relative">
        <button id="save" class="btnimg" type="submit"><img src="{{ asset('assets/images/filter.png') }}" width="50" height="50"></button>
        <div class="hidden group-hover:block absolute left-0 mt-2 bg-gray-500 bg-opacity-50 text-center rounded-md px-2 py-1"><span class="text-sm text-gray-100">Filtros</span></div>
    </div>
    </form>
</div>

<script>
    document.getElementById('overlayButton').onclick = function() {
        window.location.href = "{{ route('tomography.superposicion', ['id' => $tomography->id]) }}"; // Redirige a la ruta de superposición
    };

    let currentIndex = 0; 
    const images = @json(array_map(fn($image) => basename($image), $images));
    const totalImages = images.length;

    console.log("Total de imágenes: ", totalImages); 
    let scrollEnabled = false;

    function changeImage(index) {
        if (index >= 0 && index < totalImages) {
            $(`#image-${currentIndex}`).hide();
            $(`#image-${index}`).fadeIn(100);
            $('#image-name').text(images[index]);
            currentIndex = index;
        }
    }

    $('#prev-btn').click(function() {
        if (currentIndex > 0) {
            changeImage(currentIndex - 1);
        }
    });
    $('#next-btn').click(function() {
        if (currentIndex < totalImages - 1) {
            changeImage(currentIndex + 1);
        }
    });
    $('#enable-scroll').click(function() {
        scrollEnabled = !scrollEnabled;
        $(this).text(scrollEnabled ? 'Deshabilitar cambio con rueda' : 'Habilitar cambio con rueda');
        if (scrollEnabled) {
            $('body').css('overflow', 'hidden');
        } else {
            $('body').css('overflow', 'auto');
        }
    });
    $(document).on('wheel', function(event) {
        if (scrollEnabled) {
            event.preventDefault();
            const delta = event.originalEvent.deltaY;

            if (delta > 0 && currentIndex < totalImages - 1) {
                changeImage(currentIndex + 1);
            } else if (delta < 0 && currentIndex > 0) {
                changeImage(currentIndex - 1);
            }
        }
    });

    document.getElementById('save').onclick = function(event) {
    event.preventDefault();
    const img = document.querySelector(`#image-${currentIndex}`);
    if (!img) {
        alert("No hay imagen visible para guardar.");
        return;
    }
    const canvas = document.createElement('canvas');
    canvas.width = img.naturalWidth;
    canvas.height = img.naturalHeight;
    const ctx = canvas.getContext('2d');
    ctx.filter = getComputedStyle(img).filter || 'none';
    ctx.drawImage(img, 0, 0);
    const dataURL = canvas.toDataURL('image/png');
    fetch("{{ route('tool.storeTomography', ['tomography_id' => $tomography->tomography_id, 'ci_patient' => $tomography->ci_patient, 'id' => $tomography->id]) }}", {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({ image: dataURL })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            window.location.href = `{{ route('tool.ver', ['tool' => ':tool_id']) }}`.replace(':tool_id', data.tool_id);
        } else {
            alert("Error al guardar la imagen.");
        }
    })
    .catch(error => {
        console.error("Error al guardar la imagen:", error);
    });
    };
</script>

@endsection
