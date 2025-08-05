<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;
    protected $guarded=[];
    public function assignedDoctor(){
        return $this->belongsTo(User::class, 'assigned_doctor');
    }
    public function assignedRadiologist(){
        return $this->belongsTo(User::class, 'assigned_radiologist');
    }
    public function patient(){
        return $this->belongsTo(Patient::class, 'patient_id');
    }
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
