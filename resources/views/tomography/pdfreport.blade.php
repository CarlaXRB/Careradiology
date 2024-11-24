<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Informe Tomografía Computarizada</title>
    <style>
        .page-break {
            page-break-after: always;
        }
    </style>
</head>
<body>
    <h1>Informe Tomografía Computarizada </h1>
    <h2>Información del Paciente: </h2>
    <p><b>Nombre:</b>  {{ $data['name_patient'] }}</p>
    <p><b>ID:</b>  {{ $data['ci_patient'] }}</p>
    <p><b>Fecha de nacimiento:</b>  {{ $data['birth_date'] }}</p>
    <p><b>Género:</b>  {{ $data['gender'] }}</p>
    <p><b>Código de asegurado:</b>  {{ $data['insurance_code'] }}</p>
    <p><b>Contacto del patiente:</b>  {{ $data['patient_contact'] }}</p>
    <p><b>Contacto de familiar:</b>  {{ $data['family_contact'] }}</p>

    <h2>Información de la tomografía</h2>
    <p><b>ID de la tomografía:</b>  {{ $data['tomography_id'] }}</p>
    <p><b>Fecha del estudio:</b>  {{ $data['tomography_date'] }}</p>
    <p><b>Tipo de estudio:</b>  {{ $data['tomography_type'] }}</p>
    <p><b>Doctor:</b>  {{ $data['tomography_doctor'] }}</p>
    <p><b>Radiologo:</b>  {{ $data['tomography_charge'] }}</p>

    <h2>Observaciones</h2>
    <p><b>Hallazgos:</b>  {{ $data['findings'] }}</p>
    <p><b>Diagnóstico:</b>  {{ $data['diagnosis'] }}</p>
    <p><b>Recomendaciones:</b>  {{ $data['recommendations'] }}</p>
    <p><b>Conclusiones:</b> {{ $data['conclusions'] }}</p>
</body>
</html>
