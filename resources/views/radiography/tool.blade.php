@extends('layouts._partials.layout')
@section('title', 'Show Radiography')
@section('subtitle')
    {{ __('Herramientas') }}
@endsection
@section('content')
<div class="flex justify-end">
    <a href="{{ route('radiography.show', $radiography->id)}}" class="botton1">Atrás</a>
</div>
<h1 class="txt-title2">Herramientas</h1>
<div class="relative flex justify-center space-x-2">
    <div class="group relative">
        <button id="zoomIn" class="btnimg"><img src="{{ asset('assets/images/zoom.png') }}" width="50" height="50"></button>
        <div class="hidden group-hover:block absolute left-0 mt-2 bg-gray-500 bg-opacity-50 text-center rounded-md px-2 py-1"><span class="text-sm text-gray-100">Acercar</span></div>
    </div>
    <div class="group relative">
        <button id="zoomOut" class="btnimg"><img src="{{ asset('assets/images/unzoom.png') }}" width="50" height="50"></button>
        <div class="hidden group-hover:block absolute left-0 mt-2 bg-gray-500 bg-opacity-50 text-center rounded-md px-2 py-1"><span class="text-sm text-gray-100">Alejar</span></div>
    </div>
    <div class="group relative">
        <button id="magnifier" class="btnimg"><img src="{{ asset('assets/images/lupa.png') }}" width="50" height="50"></button>
        <div class="hidden group-hover:block absolute left-0 mt-2 bg-gray-500 bg-opacity-50 text-center rounded-md px-2 py-1"><span class="text-sm text-gray-100">Ampliar</span></div>
    </div>
    <div class="group relative">
        <button id="invertColors" class="btnimg"><img src="{{ asset('assets/images/negative.png') }}" width="50" height="50"></button>
        <div class="hidden group-hover:block absolute left-0 mt-2 bg-gray-500 bg-opacity-50 text-center rounded-md px-2 py-1"><span class="text-sm text-gray-100">Negativo</span></div>
    </div>
    <div class="group relative">
        <button id="increaseSharpness" class="btnimg"><img src="{{ asset('assets/images/filter1.png') }}" width="50" height="50"></button>
        <div class="hidden group-hover:block absolute left-0 mt-2 bg-gray-500 bg-opacity-50 text-center rounded-md px-2 py-1"><span class="text-xs text-gray-100">Más_Contraste</span></div>
    </div>
    <div class="group relative">
        <button id="decreaseSharpness" class="btnimg"><img src="{{ asset('assets/images/filter2.png') }}" width="50" height="50"></button>
        <div class="hidden group-hover:block absolute left-0 mt-2 bg-gray-500 bg-opacity-50 text-center rounded-md px-2 py-1"><span class="text-xs text-gray-100">Menos_Contraste</span></div>
    </div>
    <div class="group relative">
        <button id="overlayButton" class="btnimg"><img src="{{ asset('assets/images/sup.png') }}" width="50" height="50"></button>
        <div class="hidden group-hover:block absolute left-0 mt-2 bg-gray-500 bg-opacity-50 text-center rounded-md px-2 py-1"><span class="text-xs text-gray-100">Superposición</span></div>
    </div>
    <form id="saveImageForm" action="{{ route('tool.store',['radiography_id' => $radiography->radiography_id, 'id' => $radiography->id]) }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="group relative">
            <button id="save" class="btnimg" type="submit"><img src="{{ asset('assets/images/save.png') }}" width="50" height="50"></button>
            <div class="hidden group-hover:block absolute left-0 mt-2 bg-gray-500 bg-opacity-50 text-center rounded-md px-2 py-1"><span class="text-sm text-gray-100">Guardar</span></div>
        </div>
    </form>
    <div class="group relative">
        <button id="downloadImage" class="btnimg"><img src="{{ asset('assets/images/download.png') }}" width="50" height="50"></button>
        <div class="hidden group-hover:block absolute left-0 mt-2 bg-gray-500 bg-opacity-50 text-center rounded-md px-2 py-1"><span class="text-xs text-gray-100">Decargar</span></div>
    </div>
    <div class="group relative">
        <button id="draw" class="btnimg" onclick="window.location.href='{{ route('radiography.measurements', $radiography->id) }}'"><img src="{{ asset('assets/images/draw.png') }}" width="50" height="50"></button>
        <div class="hidden group-hover:block absolute left-0 mt-2 bg-gray-500 bg-opacity-50 text-center rounded-md px-2 py-1"><span class="text-sm text-gray-100">Mediciones</span></div>
    </div>
    <div class="group relative">
        <button id="report" class="btnimg" onclick="window.location.href='{{ route('radiography.report', $radiography->id) }}'"><img src="{{ asset('assets/images/report.png') }}" width="50" height="50"></button>
        <div class="hidden group-hover:block absolute left-0 mt-2 bg-gray-500 bg-opacity-50 text-center rounded-md px-2 py-1"><span class="text-sm text-gray-100">Reporte</span></div>
    </div>
</div>

<div class="relative flex justify-center mt-[50px] mb-[30px]">
    <div class="overflow-auto border border-gray-400" style="width: 1100px; height: 700px; position: relative;">
        <img id="radiographyImage" 
             src="{{ asset('storage/radiographies/'.$radiography->radiography_uri) }}" 
             style="width: 100%; height: 100%; object-fit: contain; transition: transform 0.2s; position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%);" />
        <div id="magnifierLens" style="display: none; position: absolute; border: 1px solid #000; border-radius: 50%; pointer-events: none;"></div> <!-- Lente de la lupa -->
    </div>
</div>
<div>
    <h1 class="txt-title2">CONTINUA EDITANDO</h1>
    <div class="flex justify-end"><a href="javascript:void(0);" class="botton3" id="updateButton">Actualizar</a></div>
    <div class="grid grid-cols-4 gap-4 border-b border-cyan-500">
        <h3 class="txt-head">Vista previa</h3>  
        <h3 class="txt-head">Fecha de creación</h3>
        <h3 class="txt-head">ID del estudio</h3>
    </div>
    @foreach($radiography->tools as $tool)
    <div class="grid grid-cols-4 border-b border-gray-600 gap-4 mb-3 text-white pl-6 pl-10">
    <img src="{{ asset('storage/tools/'.$tool->tool_uri)}}" width="128" />
        <a href="{{ route('tool.show', $tool->id) }}"> {{ $tool->tool_date }} </a>
        <a href="{{ route('tool.show', $tool->id) }}"> {{ $tool->tool_id }} </a>  
    <form method="POST" action="{{ route('tool.destroy', $tool->id) }}">
        @csrf
        @method('Delete')
        <div class="flex justify-end"><input type="submit" value="Eliminar" class="botton2"/></div>
    </form>
    </div>
    @endforeach
</div>
<script>
    let zoomLevel = 1;
    let initialPosition = { left: '50%', top: '50%' };
    let isDragging = false;
    let startX, startY, initialMouseX, initialMouseY;
    let isNegative = false;
    let sharpnessLevel = 1;
    let isMagnifierActive = false;

    const img = document.getElementById('radiographyImage');
    const magnifierLens = document.getElementById('magnifierLens');
    const zoomInButton = document.getElementById('zoomIn');
    const zoomOutButton = document.getElementById('zoomOut');
    const invertColorsButton = document.getElementById('invertColors');
    const increaseSharpnessButton = document.getElementById('increaseSharpness');
    const decreaseSharpnessButton = document.getElementById('decreaseSharpness');
    const magnifierButton = document.getElementById('magnifier');

    img.style.left = initialPosition.left;
    img.style.top = initialPosition.top;

    // Arrastre
    img.addEventListener('mousedown', (event) => {
        if (zoomLevel > 1) {
            isDragging = true;
            startX = img.offsetLeft;
            startY = img.offsetTop;
            initialMouseX = event.clientX;
            initialMouseY = event.clientY;
            event.preventDefault();
        }
    });

    document.addEventListener('mousemove', (event) => {
        if (isDragging) {
            const dx = event.clientX - initialMouseX;
            const dy = event.clientY - initialMouseY;
            img.style.left = `${startX + dx}px`;
            img.style.top = `${startY + dy}px`;
        }

        if (isMagnifierActive) {
            const rect = img.getBoundingClientRect();
            const lensSize = 100; 
            const offset = 20; 
            const x = event.clientX - rect.left - lensSize / 2 + offset; 
            const y = event.clientY - rect.top - lensSize / 2 + offset;

            magnifierLens.style.width = `${lensSize}px`;
            magnifierLens.style.height = `${lensSize}px`;
            magnifierLens.style.left = `${x}px`;
            magnifierLens.style.top = `${y}px`;
            magnifierLens.style.display = 'block';

            // lupa
            magnifierLens.style.backgroundImage = `url(${img.src})`;
            magnifierLens.style.backgroundSize = `${img.width * 2}px ${img.height * 2}px`; 
            magnifierLens.style.backgroundPosition = `-${(x - offset) * 2}px -${(y - offset) * 2}px`; 
        }
    });

    document.addEventListener('mouseup', () => {
        isDragging = false;
        magnifierLens.style.display = 'none';
    });

    zoomInButton.addEventListener('click', () => {
        zoomLevel += 0.1; 
        img.style.transform = `translate(-50%, -50%) scale(${zoomLevel})`; 
    });

    zoomOutButton.addEventListener('click', () => {
        if (zoomLevel > 1) { 
            zoomLevel -= 0.1; 
            img.style.transform = `translate(-50%, -50%) scale(${zoomLevel})`; 
        }

        if (zoomLevel <= 1) {
            zoomLevel = 1; 
            img.style.transform = `translate(-50%, -50%) scale(${zoomLevel})`; 
            img.style.left = initialPosition.left; 
            img.style.top = initialPosition.top;
        }
    });

    //Negativo
    invertColorsButton.addEventListener('click', () => {
        isNegative = !isNegative; 
        img.style.filter = isNegative ? 'invert(1)' : 'none'; 
    });

    // Aumentar Contraste
    increaseSharpnessButton.addEventListener('click', () => {
        sharpnessLevel += 0.1; 
        img.style.filter = `contrast(${sharpnessLevel}) ${isNegative ? 'invert(1)' : ''}`; 
    });

    // Disminuir Contraste
    decreaseSharpnessButton.addEventListener('click', () => {
        if (sharpnessLevel > 1) { 
            sharpnessLevel -= 0.1; 
            img.style.filter = `contrast(${sharpnessLevel}) ${isNegative ? 'invert(1)' : ''}`;
        }
    });

    //lupa
    magnifierButton.addEventListener('click', () => {
        isMagnifierActive = !isMagnifierActive;
        if (!isMagnifierActive) {
            magnifierLens.style.display = 'none';
        }
    });
    //Descargar Imagen
    const downloadImageButton = document.getElementById('downloadImage');

    downloadImageButton.addEventListener('click', () => {
        const canvas = document.createElement('canvas');
        canvas.width = img.naturalWidth;
        canvas.height = img.naturalHeight;
        const ctx = canvas.getContext('2d');

        ctx.filter = img.style.filter;
        ctx.drawImage(img, 0, 0);

        const link = document.createElement('a');
        link.download = `radiography_{{ $radiography->id }}_${new Date().toISOString().slice(0, 10)}.png`;
        link.href = canvas.toDataURL();
        link.click();
    });

document.querySelector('form').addEventListener('submit', function(event) {
    event.preventDefault();
    const dataURL = canvas.toDataURL({
        format: 'png',
        quality: 1.0,
    });
    document.getElementById('canvasData').value = dataURL;
    console.log(dataURL);
});

document.getElementById('save').onclick = function(event) {
    event.preventDefault();
    const canvas = document.createElement('canvas');
    canvas.width = img.naturalWidth;
    canvas.height = img.naturalHeight;
    const ctx = canvas.getContext('2d');
    ctx.filter = img.style.filter;
    ctx.drawImage(img, 0, 0);

    const dataURL = canvas.toDataURL('image/png');

    fetch("{{ route('tool.store', ['radiography_id' => $radiography->radiography_id, 'id' => $radiography->id]) }}", {
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
            alert("Imagen guardada exitosamente");
        } else {
            alert("Error al guardar la imagen");
        }
    })
    .catch(error => {
        console.error("Error al guardar la imagen:", error);
    });
};
//Actualizar
document.getElementById('updateButton').addEventListener('click', function () {
    location.reload();
});
</script>
@endsection