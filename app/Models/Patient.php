<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    use HasFactory;
    protected $guarded=[];

    public function radiographies():HasMany{
        return $this->hasMany(Radiography::class, 'ci_patient', 'ci_patient');
    }
    public function tomographies():HasMany{
        return $this->hasMany(Tomography::class, 'ci_patient', 'ci_patient');
    }
}
