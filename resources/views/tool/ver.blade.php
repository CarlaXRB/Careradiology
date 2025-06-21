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
        <button id="increaseBrightness" class="btnimg"><img src="{{ asset('assets/images/filter3.png') }}" width="50" height="50"></button>
        <div class="hidden group-hover:block absolute left-0 mt-2 bg-gray-500 bg-opacity-50 text-center rounded-md px-2 py-1"><span class="text-xs text-gray-100">Más_Brillo</span></div>
    </div>
    <div class="group relative">
        <button id="decreaseBrightness" class="btnimg"><img src="{{ asset('assets/images/filter4.png') }}" width="50" height="50"></button>
        <div class="hidden group-hover:block absolute left-0 mt-2 bg-gray-500 bg-opacity-50 text-center rounded-md px-2 py-1"><span class="text-xs text-gray-100">Menos_Brillo</span></div>
    </div>
    <div class="group relative">
        <button id="increaseContrast" class="btnimg"><img src="{{ asset('assets/images/filter1.png') }}" width="50" height="50"></button>
        <div class="hidden group-hover:block absolute left-0 mt-2 bg-gray-500 bg-opacity-50 text-center rounded-md px-2 py-1"><span class="text-xs text-gray-100">Más_Contraste</span></div>
    </div>
    <div class="group relative">
        <button id="decreaseContrast" class="btnimg"><img src="{{ asset('assets/images/filter2.png') }}" width="50" height="50"></button>
        <div class="hidden group-hover:block absolute left-0 mt-2 bg-gray-500 bg-opacity-50 text-center rounded-md px-2 py-1"><span class="text-xs text-gray-100">Menos_Contraste</span></div>
    </div>
    <div class="group relative">
        <button id="edgesButton" class="btnimg"><img src="{{ asset('assets/images/edge.png') }}" width="50" height="50"></button>
        <div class="hidden group-hover:block absolute left-0 mt-2 bg-gray-500 bg-opacity-50 text-center rounded-md px-2 py-1"><span class="text-xs text-gray-100">Marcar_Bordes</span></div>
    </div>
    <form id="saveImageForm" action="{{ route('tool.new', ['tomography_id' => $tool->tool_tomography_id, 'ci_patient' => $tool->ci_patient, 'id' => $tool->id]) }}" method="POST" enctype="multipart/form-data">
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
document.addEventListener('DOMContentLoaded', () => {
    const img = document.getElementById('toolImage');
    const container = img.parentElement;
    const magnifierLens = document.getElementById('magnifierLens');

    let zoom = 1;
    let brightness = 0;  
    let contrast = 1;   
    let isNegative = false;
    let edgesApplied = false;

    function updateFilters() {
        let filters = [];
        filters.push(`brightness(${1 + brightness})`);
        filters.push(`contrast(${contrast})`);
        if (isNegative) filters.push('invert(1)');
        img.style.filter = filters.join(' ');
    }

    updateFilters();
    img.style.transform = 'translate(-50%, -50%) scale(1)';

    document.getElementById('zoomIn').addEventListener('click', () => {
        zoom += 0.1;
        img.style.transform = `translate(-50%, -50%) scale(${zoom})`;
    });
    document.getElementById('zoomOut').addEventListener('click', () => {
        if (zoom > 0.5) {
            zoom -= 0.1;
            img.style.transform = `translate(-50%, -50%) scale(${zoom})`;
        }
    });
    document.getElementById('increaseBrightness').addEventListener('click', () => {
        brightness = Math.min(brightness + 0.1, 1);
        updateFilters();
    });
    document.getElementById('decreaseBrightness').addEventListener('click', () => {
        brightness = Math.max(brightness - 0.1, -1);
        updateFilters();
    });
    document.getElementById('increaseContrast').addEventListener('click', () => {
        contrast = Math.min(contrast + 0.1, 3);
        updateFilters();
    });
    document.getElementById('decreaseContrast').addEventListener('click', () => {
        contrast = Math.max(contrast - 0.1, 0);
        updateFilters();
    });
    document.getElementById('invertColors').addEventListener('click', () => {
        isNegative = !isNegative;
        updateFilters();
    });
    // Detección de bordes (aplica efecto sobel al canvas temporal)
    document.getElementById('edgesButton').addEventListener('click', () => {
        if (edgesApplied) {
            // Quitar bordes, restaurar original
            img.src = '{{ asset('storage/tools/'.$tool->tool_uri) }}';
            edgesApplied = false;
            updateFilters();
            return;
        }
        // Crear canvas temporal
        let canvas = document.createElement('canvas');
        let ctx = canvas.getContext('2d');
        canvas.width = img.naturalWidth;
        canvas.height = img.naturalHeight;
        ctx.drawImage(img, 0, 0, canvas.width, canvas.height);
        // Obtener datos
        let imageData = ctx.getImageData(0, 0, canvas.width, canvas.height);
        let data = imageData.data;
        // Filtro sobel
        const width = canvas.width;
        const height = canvas.height;
        // Crear buffer para resultado
        let output = new Uint8ClampedArray(data.length);
        // Kernels sobel
        const kernelX = [
            -1, 0, 1,
            -2, 0, 2,
            -1, 0, 1
        ];
        const kernelY = [
            -1, -2, -1,
             0,  0,  0,
             1,  2,  1
        ];
        function getPixel(x, y, c) {
            if (x < 0) x = 0;
            if (x >= width) x = width - 1;
            if (y < 0) y = 0;
            if (y >= height) y = height - 1;
            return data[(y * width + x) * 4 + c];
        }
        for (let y = 0; y < height; y++) {
            for (let x = 0; x < width; x++) {
                let gx = 0, gy = 0;
                for (let ky = -1; ky <= 1; ky++) {
                    for (let kx = -1; kx <= 1; kx++) {
                        let px = x + kx;
                        let py = y + ky;
                        let val = getPixel(px, py, 0);
                        let idx = (ky + 1) * 3 + (kx + 1);
                        gx += kernelX[idx] * val;
                        gy += kernelY[idx] * val;
                    }
                }
                let mag = Math.sqrt(gx * gx + gy * gy);
                mag = Math.min(255, mag);

                let i = (y * width + x) * 4;
                output[i] = output[i+1] = output[i+2] = mag;
                output[i+3] = 255;
            }
        }
        for (let i = 0; i < data.length; i++) {
            data[i] = output[i];
        }
        ctx.putImageData(imageData, 0, 0);
        img.src = canvas.toDataURL();
        edgesApplied = true;
        updateFilters();
    });
    // Lupa (magnifier)
    document.getElementById('magnifier').addEventListener('click', () => {
        if (magnifierLens.style.display === 'block') {
            magnifierLens.style.display = 'none';
            container.removeEventListener('mousemove', magnifyMove);
        } else {
            magnifierLens.style.display = 'block';
            magnifierLens.style.width = '150px';
            magnifierLens.style.height = '150px';
            magnifierLens.style.backgroundImage = `url(${img.src})`;
            magnifierLens.style.backgroundRepeat = 'no-repeat';
            magnifierLens.style.backgroundSize = `${img.width * 2}px ${img.height * 2}px`;
            container.addEventListener('mousemove', magnifyMove);
        }
    });

    function magnifyMove(e) {
        const pos = container.getBoundingClientRect();
        let x = e.clientX - pos.left;
        let y = e.clientY - pos.top;

        const lensWidth = magnifierLens.offsetWidth / 2;
        const lensHeight = magnifierLens.offsetHeight / 2;

        // Limitar movimiento dentro del contenedor
        if (x < lensWidth) x = lensWidth;
        if (x > container.offsetWidth - lensWidth) x = container.offsetWidth - lensWidth;
        if (y < lensHeight) y = lensHeight;
        if (y > container.offsetHeight - lensHeight) y = container.offsetHeight - lensHeight;

        magnifierLens.style.left = (x - lensWidth) + 'px';
        magnifierLens.style.top = (y - lensHeight) + 'px';

        const bgX = -x * 2 + lensWidth;
        const bgY = -y * 2 + lensHeight;
        magnifierLens.style.backgroundPosition = `${bgX}px ${bgY}px`;
    }
    // Descargar
    document.getElementById('downloadImage').addEventListener('click', () => {
        let canvas = document.createElement('canvas');
        let ctx = canvas.getContext('2d');
        canvas.width = img.naturalWidth;
        canvas.height = img.naturalHeight;

        let filters = [];
        filters.push(`brightness(${1 + brightness})`);
        filters.push(`contrast(${contrast})`);
        if (isNegative) filters.push('invert(1)');
        ctx.filter = filters.join(' ');

        let tempImg = new Image();
        tempImg.crossOrigin = "anonymous";
        tempImg.onload = () => {
            ctx.drawImage(tempImg, 0, 0, canvas.width, canvas.height);
            let link = document.createElement('a');
            link.download = 'tool.png';
            link.href = canvas.toDataURL();
            link.click();
        };
        tempImg.src = img.src;
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

    let isDragging = false;
    let startX, startY;
    let currentX = 0, currentY = 0;

    img.style.cursor = 'grab';

    container.addEventListener('mousedown', (e) => {
        e.preventDefault();
        isDragging = true;
        startX = e.clientX - currentX;
        startY = e.clientY - currentY;
        img.style.cursor = 'grabbing';
    });
    container.addEventListener('mouseup', () => {
        isDragging = false;
        img.style.cursor = 'grab';
    });
    container.addEventListener('mouseleave', () => {
        isDragging = false;
        img.style.cursor = 'grab';
    });
    container.addEventListener('mousemove', (e) => {
        if (!isDragging) return;
        e.preventDefault();
        currentX = e.clientX - startX;
        currentY = e.clientY - startY;
        img.style.left = `calc(50% + ${currentX}px)`;
        img.style.top = `calc(50% + ${currentY}px)`;
    });
});
//Actualizar
document.getElementById('updateButton').addEventListener('click', function () {
    location.reload();
});
</script>
@endsection
