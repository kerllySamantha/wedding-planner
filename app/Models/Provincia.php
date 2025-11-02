<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Provincia extends Model
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }

    protected $table = 'provincias';

    public function poblaciones() {
        return $this->hasMany(Poblacion::class, 'id_provincia', 'id' );
    }
}