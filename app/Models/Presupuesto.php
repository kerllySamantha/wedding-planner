<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Presupuesto extends Model
{
  protected $table = 'presupuestos';

  protected $fillable = [
    'boda_id',
    'tipo_producto_id',
    'monto_total',
    'monto_pagado',
    'estado',
    'fecha_creacion'
  ];


  public function boda()
  {
    return $this->belongsTo(Boda::class);
  }

  public function itemsPresupuesto()
  {
    return $this->hasMany(ItemPresupuesto::class, 'presupuesto_id');
  }

  public function tipoProducto()
  {
    return $this->belongsTo(TipoProducto::class);
  }
}
