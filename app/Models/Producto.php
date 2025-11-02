<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    use HasFactory;
    public function empresa()
    {
        return $this->belongsTo(Empresa::class);
    }

    public function tipoProducto()
    {
        return $this->belongsTo(TipoProducto::class, 'tipo_producto_id');
    }


    public function itemsPresupuesto()
    {
        return $this->hasMany(ItemPresupuesto::class);
    }
}
