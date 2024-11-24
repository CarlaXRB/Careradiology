<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Model;

class Tool extends Model
{
    use HasFactory;
    protected $guarded=[];

    public function radiography():BelongsTo{
        return $this->belongsTo(Radiography::class, 'tool_id', 'radiography_id');
    }
    public function tomography():BelongsTo{
        return $this->belongsTo(Tomography::class, 'tool_id', 'tomography_id');
    }
}
