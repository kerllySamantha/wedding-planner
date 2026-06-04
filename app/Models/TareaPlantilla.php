<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TareaPlantilla extends Model
{
    protected $table = 'tareas_plantilla';

    protected $fillable = ['titulo', 'descripcion', 'orden'];
}
