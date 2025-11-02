<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Presupuesto extends Model
{
    public function boda()
    {
      return $this->belongsTo(Boda::class);
    }

    public function itemsPresupuesto(){
        return $this->hasMany(ItemPresupuesto::class);
    }
}
