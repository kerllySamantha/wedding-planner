<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ItemPresupuesto extends Model
{
    public function presupuesto()
    {
        return $this->belongsTo(Presupuesto::class);
    }

    public function categoria()
    {
        return $this->belongsTo(Categoria::class);
    }

    public function producto()
    {
        return $this->belongsTo(Producto::class);
    }
}
