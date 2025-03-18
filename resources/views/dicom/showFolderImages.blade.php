
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Imágenes Procesadas</title>
</head>
<body>
    <h1>Imágenes Procesadas</h1>
    <div>
        @foreach ($images as $image)
            <img src="{{ asset($image) }}" alt="Imagen DICOM procesada" style="max-width: 100%; max-height: 500px; margin-bottom: 20px;">
        @endforeach
    </div>

    @if ($dicomRecord)
        <h2>Información del Paciente</h2>
        <p><strong>Nombre:</strong> {{ $dicomRecord->patient_name }}</p>
        <p><strong>ID del Paciente:</strong> {{ $dicomRecord->patient_id }}</p>
        <p><strong>Modalidad:</strong> {{ $dicomRecord->modality }}</p>
        <p><strong>Fecha del Estudio:</strong> {{ $dicomRecord->study_date }}</p>
        <p><strong>Tamaño de la Imagen:</strong> {{ $dicomRecord->rows }} x {{ $dicomRecord->columns }}</p>

        <h3>Metadatos completos:</h3>
        <pre>
            {{ json_encode(json_decode($dicomRecord->metadata), JSON_PRETTY_PRINT) }}
        </pre>
    @else
        <p>No se encontraron datos del paciente para esta carpeta.</p>
    @endif
</body>
</html>
