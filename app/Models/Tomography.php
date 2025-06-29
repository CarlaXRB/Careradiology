<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Model;

class Tomography extends Model
{
    use HasFactory;
    protected $guarded=[];
    public function patient():BelongsTo{
        return $this->belongsTo(Patient::class, 'ci_patient', 'ci_patient');
    }
    public function tools():HasMany{
        return $this->hasMany(Tool::class, 'tomography_id', 'tool_tomography_id');
    }
    public function reports():HasMany{
        return $this->hasMany(Report::class, 'report_id', 'tomography_id');
    }
    public function dicoms():HasMany{
        return $this->hasMany(Tool::class, 'patient_id', 'ci_patient');
    }
}
