<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tarea extends Model
{
    public function boda()
    {
        $this->belongsTo(Boda::class);
    }
}
