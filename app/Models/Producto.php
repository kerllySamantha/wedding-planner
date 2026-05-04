<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    protected $fillable = [
        'tipo_producto_id',
        'stock_paralelo',
        'precio_max',
        'precio_min',
        'nombre',
        'descripcion',
        'empresa_id'
    ];


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

    public function reservas()
    {
        return $this->hasMany(Reserva::class);
    }
}
