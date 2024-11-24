<?php

return [
    // Nombre del AET para tu servidor
    'aet' => env('DICOM_AET', 'PACS_SERVER'),

    'host' => env('DICOM_HOST', '192.168.1.10'),

    'port' => env('DICOM_PORT', 104),

];
