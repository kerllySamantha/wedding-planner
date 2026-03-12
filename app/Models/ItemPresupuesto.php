<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ItemPresupuesto extends Model
{

    protected $fillable = [
        'presupuesto_id',
        'tipo_producto_id',
        'nombre_tipo_personalizado',
        'monto_estimado',
        'monto_pagado',
        'es_personalizado',
        'notas',
    ];

    protected $casts = [
        'monto_estimado' => 'decimal:2',
        'monto_pagado' => 'decimal:2',
    ];

    public function presupuesto()
    {
        return $this->belongsTo(Presupuesto::class);
    }

    public function tipoProducto()
    {
        return $this->belongsTo(TipoProducto::class);
    }

    // public function categoria()
    // {
    //     return $this->belongsTo(Categoria::class);
    // }

    // public function tipoProducto()
    // {
    //     return $this->belongsTo(TipoProducto::class);
    // }

    
}
