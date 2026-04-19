<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PresupuestoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('presupuestos')->insert(
            [
                [
                    'boda_id' => 1 ,
                    'tipo_producto_id' => 1,
                    // 'nombre' => 'Decoración',
                    // 'descripcion' => 'Decoración de salón y ceremonia',
                    'monto_total' => 2000.00,
                    // 'estado' => false,
                    'fecha_creacion' => Carbon::now(),
                ],
                [
                    'boda_id' => 1,
                    // 'nombre' => 'Banquete',
                    // 'descripcion' => 'Comida y bebida para los invitados',
                    'tipo_producto_id' => 2,
                    'monto_total' => 5000.00,
                    // 'estado' => false,
                    'fecha_creacion' => Carbon::now(),
                ],
                [
                    'boda_id' => 2,
                    // 'nombre' => 'Fotografía',
                    // 'descripcion' => 'Fotógrafo profesional para toda la boda',
                    'tipo_producto_id' => 1,
                    'monto_total' => 1500.00,
                    // 'estado' => false,
                    'fecha_creacion' => Carbon::now(),
                ],
            ]
        );
    }
}
