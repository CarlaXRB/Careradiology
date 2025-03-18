
<!-- <!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Subir DICOM</title>
</head>
<body>
    <h2>Subir Archivo DICOM</h2>
    <form action="{{ route('process.dicom') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <input type="file" name="file" required>
        <button type="submit">Subir Archivo</button>
    </form>

    <h2>Seleccionar Carpeta</h2>
    <input type="file" id="folderInput" webkitdirectory directory multiple>
    <button onclick="uploadFolder()">Subir Carpeta</button>

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
            .then(data => alert(data.message))
            .catch(error => console.error(error));
        }
    </script>
</body>
</html> -->
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Subir DICOM</title>
</head>
<body>
    <h2>Subir Archivo DICOM</h2>
    <form action="{{ route('process.dicom') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <input type="file" name="file" required>
        <button type="submit">Subir Archivo</button>
    </form>

    <h2>Seleccionar Carpeta</h2>
    <input type="file" id="folderInput" webkitdirectory directory multiple>
    <button onclick="uploadFolder()">Subir Carpeta</button>

    <div id="message" style="display: none; margin-top: 20px;">
        <p id="successMessage"></p>
        <a href="#" id="viewImagesBtn"><button>Ver Imágenes Procesadas</button></a>
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
                // Mostrar el mensaje de éxito
                document.getElementById("successMessage").innerText = data.message;
                document.getElementById("message").style.display = "block";
                
                // Configurar el botón para ver las imágenes
                document.getElementById("viewImagesBtn").href = data.folderUrl;
            })
            .catch(error => console.error(error));
        }
    </script>
</body>
</html>
