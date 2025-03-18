
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Imagen procesada</title>
</head>
<body>
    <h1>Imagen procesada</h1>
    <img src="{{ asset($imageUrl) }}" alt="Imagen DICOM procesada" style="max-width: 100%; max-height: 500px;">
    
    <h2>Información del Paciente</h2>
    <p><strong>Paciente:</strong> {{ $dicomData['patient_name'] }}</p>
    <p><strong>ID del Paciente:</strong> {{ $dicomData['patient_id'] }}</p>
    <p><strong>Modalidad:</strong> {{ $dicomData['modality'] }}</p>
    <p><strong>Fecha del Estudio:</strong> {{ $dicomData['study_date'] }}</p>
    <p><strong>Tamaño de la imagen:</strong> {{ $dicomData['rows'] }}x{{ $dicomData['columns'] }}</p>

    <h3>Metadatos completos:</h3>
    <pre>{{ json_encode($dicomData['dicom_info'], JSON_PRETTY_PRINT) }}</pre>
</body>
</html>
