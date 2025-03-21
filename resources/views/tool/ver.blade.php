@extends('layouts._partials.layout')
@section('title', 'Show Tool')
@section('subtitle')
    {{ __('Herramientas') }}
@endsection
@section('content')
<div class="flex justify-end">
    <a href="{{ route('tool.show', $tool->id)}}" class="botton1">Atrás</a>
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
        <button id="edgesButton" class="btnimg"><img src="{{ asset('assets/images/edge.png') }}" width="50" height="50"></button>
        <div class="hidden group-hover:block absolute left-0 mt-2 bg-gray-500 bg-opacity-50 text-center rounded-md px-2 py-1"><span class="text-xs text-gray-100">Bordes</span></div>
    </div>
    <form action="{{ route('tool.new', ['tomography_id' => $tool->tool_tomography_id, 'ci_patient' => $tool->ci_patient, 'id' => $tool->id]) }}" method="POST" enctype="multipart/form-data">
    @csrf
        <div class="group relative">
            <button id="save" class="btnimg" type="submit"><img src="{{ asset('assets/images/save.png') }}" width="50" height="50"></button>
            <div class="hidden group-hover:block absolute left-0 mt-2 bg-gray-500 bg-opacity-50 text-center rounded-md px-2 py-1"><span class="text-sm text-gray-100">Guardar</span></div>
        </div>
    </form>
    <div class="group relative">
        <button id="downloadImage" class="btnimg"><img src="{{ asset('assets/images/download.png') }}" width="50" height="50"></button>
        <div class="hidden group-hover:block absolute left-0 mt-2 bg-gray-500 bg-opacity-50 text-center rounded-md px-2 py-1"><span class="text-xs text-gray-100">Descargar</span></div>
    </div>
    <div class="group relative">
        <button id="draw" class="btnimg" onclick="window.location.href='{{ route('tool.measurements', $tool->id) }}'"><img src="{{ asset('assets/images/draw.png') }}" width="50" height="50"></button>
        <div class="hidden group-hover:block absolute left-0 mt-2 bg-gray-500 bg-opacity-50 text-center rounded-md px-2 py-1"><span class="text-sm text-gray-100">Mediciones</span></div>
    </div>
</div>

<div class="relative flex justify-center mt-[50px] mb-[30px]">
    <div class="overflow-auto" style="width: 1100px; height: 700px; position: relative;">
        <img id="toolImage" 
             src="{{ asset('storage/tools/'.$tool->tool_uri) }}" 
             style="width: auto; height: auto; position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%);" />
        <div id="magnifierLens" style="display: none; position: absolute; border: 1px solid #000; border-radius: 50%; pointer-events: none;"></div> <!-- Lente de la lupa -->
    </div>
</div>

<div>
    <h1 class="txt-title2">HERRAMIENTAS APLICADAS</h1>
    <div class="flex justify-end"><a href="javascript:void(0);" class="botton3" id="updateButton">Actualizar</a></div>
    <div class="grid grid-cols-4 gap-4 border-b border-cyan-500">
        <h3 class="txt-head">Vista previa</h3>  
        <h3 class="txt-head">Fecha de creación</h3>
        <h3 class="txt-head">ID del estudio</h3>
    </div>
    @foreach($tools as $tool)
    <div class="grid grid-cols-4 border-b border-gray-600 gap-4 mb-3 text-white pl-6 pl-10">
    <img src="{{ asset('storage/tools/'.$tool->tool_uri)}}" width="128" />
        <a href="{{ route('tool.show', $tool->id) }}"> {{ $tool->tool_date }} </a>
        <a href="{{ route('tool.show', $tool->id) }}"> {{ $tool->tool_tomography_id }} </a>  
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
    let isEdgeDetectionActive = false;

    const img = document.getElementById('toolImage');
    const magnifierLens = document.getElementById('magnifierLens');
    const zoomInButton = document.getElementById('zoomIn');
    const zoomOutButton = document.getElementById('zoomOut');
    const invertColorsButton = document.getElementById('invertColors');
    const increaseSharpnessButton = document.getElementById('increaseSharpness');
    const decreaseSharpnessButton = document.getElementById('decreaseSharpness');
    const magnifierButton = document.getElementById('magnifier');
    const edgesButton = document.getElementById('edgesButton');

    img.style.left = initialPosition.left;
    img.style.top = initialPosition.top;
    // Máscaras de Sobel
    const sobelX = [
        [-1, 0, 1],
        [-2, 0, 2],
        [-1, 0, 1]
    ];

    const sobelY = [
        [-1, -2, -1],
        [0, 0, 0],
        [1, 2, 1]
    ];

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
        if (sharpnessLevel > 0.5) { 
            sharpnessLevel -= 0.1; 
            img.style.filter = `contrast(${sharpnessLevel}) ${isNegative ? 'invert(1)' : ''}`;
        }
    });

    //Detectar bordes
    function applyEdgeDetection() {
    const canvas = document.createElement('canvas');
    canvas.width = img.naturalWidth; 
    canvas.height = img.naturalHeight;
    const ctx = canvas.getContext('2d');

    ctx.drawImage(img, 0, 0, canvas.width, canvas.height);

    const imgData = ctx.getImageData(0, 0, canvas.width, canvas.height);
    const { width, height } = canvas;
    const data = imgData.data;

    const outputData = new Uint8ClampedArray(data.length);

    for (let y = 1; y < height - 1; y++) {
        for (let x = 1; x < width - 1; x++) {
            let pixelX = 0;
            let pixelY = 0;

            for (let ky = -1; ky <= 1; ky++) {
                for (let kx = -1; kx <= 1; kx++) {
                    const pixelIndex = ((y + ky) * width + (x + kx)) * 4;
                    pixelX += data[pixelIndex] * sobelX[ky + 1][kx + 1];
                    pixelY += data[pixelIndex] * sobelY[ky + 1][kx + 1];
                }
            }

            const magnitude = Math.sqrt(pixelX * pixelX + pixelY * pixelY);
            const color = Math.min(255, magnitude);

            const outputIndex = (y * width + x) * 4;
            outputData[outputIndex] = color;
            outputData[outputIndex + 1] = color;
            outputData[outputIndex + 2] = color;
            outputData[outputIndex + 3] = 255;
        }
    }
    ctx.putImageData(new ImageData(outputData, width, height), 0, 0);

    const edgeImage = canvas.toDataURL();
    img.src = edgeImage;
}
    edgesButton.addEventListener('click', () => {
        isEdgeDetectionActive = !isEdgeDetectionActive;
        if (isEdgeDetectionActive) {
            applyEdgeDetection();
        } else {
            img.src = img.src; 
        }
    });
    // Lupa
    magnifierButton.addEventListener('click', () => {
        isMagnifierActive = !isMagnifierActive; 
        magnifierLens.style.display = isMagnifierActive ? 'block' : 'none';
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
        const ci_patient = "{{ $tool->ci_patient }}";  
        const tomography_id = "{{ $tool->tool_tomography_id }}"; 
        link.download = `filtros_${tomography_id}_${ci_patient}_${new Date().toISOString().slice(0, 10)}.png`;
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

    canvas.toBlob(function(blob) {
        const formData = new FormData();
        formData.append('image', blob, 'imagen.png');

        fetch("{{ route('tool.new', ['tomography_id' => $tool->tool_tomography_id, 'ci_patient' => $tool->ci_patient,'id' => $tool->id]) }}", {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert("Imagen guardada exitosamente");
                location.reload();
            } else {
                alert("Error al guardar la imagen");
            }
        })
        .catch(error => {
            console.error("Error al guardar la imagen:", error);
        });
    }, 'image/png');
};

    //Actualizar
    document.getElementById('updateButton').addEventListener('click', function () {
        location.reload();
    });
</script>
@endsection
