<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ItemPresupuesto extends Model
{

    protected $fillable = [
        'presupuesto_id',
        // 'categoria_id',
        // 'tipo_producto_id',
        'nombre_tipo_personalizado',
        'precio_unitario',
        'cantidad',
        'total_item',
        'es_personalizado',
        'notas',
    ];

    public function presupuesto()
    {
        return $this->belongsTo(Presupuesto::class);
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
