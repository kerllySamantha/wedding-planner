<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NotaBoda extends Model
{
    protected $table = 'notas_boda';

    protected $fillable = [
        'boda_id',
        'titulo',
        'contenido',
        'categoria',
    ];

    public function boda()
    {
        return $this->belongsTo(Boda::class);
    }
}
