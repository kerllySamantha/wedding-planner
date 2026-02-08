<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reserva extends Model
{
    protected $fillable = [
        'user_id',
        'empresa_id',
        'boda_id',
        'fecha_inicio',
        'fecha_fin',
        'estado',
        'origen',
        'notas',
        'producto_id',
        // 'servicio_id',
        // 'producto_id'
    ];

    protected $table = 'reservas';

    protected $with = ['usuario', 'empresa', 'boda', 'producto'];


    public function usuario()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function empresa()
    {
        return $this->belongsTo(Empresa::class, 'empresa_id');
    }

    public function boda()
    {
        return $this->belongsTo(Boda::class, 'boda_id');
    }

    public function producto()
    {
        return $this->belongsTo(Producto::class);
    }
}
