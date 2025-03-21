<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dicom extends Model
{
    use HasFactory;
    protected $fillable = ['file_name', 'image_url',
        'patient_name', 'patient_id', 'modality', 'study_date',
        'rows', 'columns', 'metadata'
    ];

    protected $casts = [
        'metadata' => 'array' // Convierte el JSON en un array de PHP automáticamente
    ];
}
