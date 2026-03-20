<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notificacion extends Model
{
    protected $fillable = [
        'user_id',
        'mensaje',
        'titulo',
        'tipo',
        'referencia_id',
        'referencia_type',
        'leido'
    ];

    protected $casts = ['leido' => 'boolean'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function referencia()
    {
        return $this->morphTo();
    }
}
