<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tarea extends Model
{
    protected $table = 'tareas';

    protected $fillable = [
        'boda_id',
        'titulo',
        'descripcion',
        'fecha_limite',
        'completada',
    ];

    protected $casts = [
        'completada'  => 'boolean',
        'fecha_limite' => 'date',
    ];

    public function boda()
    {
        return $this->belongsTo(Boda::class);
    }
}
