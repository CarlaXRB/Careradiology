@extends('layouts._partials.layout')

@section('title','Show Radiography')

@section('subtitle')
    {{ __('DICOM') }}
@endsection

@section('content')
<div class="flex justify-end"><a href="{{ route('dashboard') }}" class="botton1">Inicio</a></div>

<h1 class="txt-title2">CARPETA DICOM CON METADATOS</h1>

<div class="mx-auto mb-3 px-8">
    <p class="text-[17px] p-5">
    Sube una carpeta con múltiples archivos en formato <b>DICOM</b> para su análisis y procesamiento.  
    El sistema recopilará y mostrará los metadatos esenciales, optimizando la gestión de imágenes radiológicas.
    </p>

    <div class="p-5">
        <div class="flex justify-center mb-4">
            <input type="file" id="folderInput" webkitdirectory directory multiple class="border border-cyan-300 rounded-md p-5">
        </div>

        <div class="flex justify-center">
            <button onclick="uploadFolder()" class="botton2 mt-2">
                Subir Carpeta
            </button>
        </div>
    </div>

    <div id="message" class="hidden text-center">
        <p id="successMessage" class="text-green-500 font-semibold mb-3"></p>
        <a href="#" id="viewImagesBtn"><button class="botton3 mb-2">Ver Imágenes Procesadas</button></a>
    </div>

    <script>
        function uploadFolder() {
            let files = document.getElementById("folderInput").files;
            let formData = new FormData();
            for (let file of files) {
                formData.append("files[]", file);
            }

            fetch("{{ route('process.folder') }}", {
                method: "POST",
                body: formData,
                headers: { "X-CSRF-TOKEN": "{{ csrf_token() }}" }
            })
            .then(response => response.json())
            .then(data => {
                document.getElementById("successMessage").innerText = data.message;
                document.getElementById("message").classList.remove("hidden");
                document.getElementById("viewImagesBtn").href = data.folderUrl;
            })
            .catch(error => console.error(error));
        }
    </script>
</div>
@endsection
