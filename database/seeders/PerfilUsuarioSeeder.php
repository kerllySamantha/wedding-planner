<?php

namespace Database\Seeders;

use App\Models\PerfilUsuario;
use App\Models\Poblacion;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;


class PerfilUsuarioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */

    public function run(): void
    {
        $fechas = [
            'maria@example.com'  => '2025-03-15',  // boda ya celebrada
            'javier@example.com' => '2024-09-15',  // boda ya celebrada
        ];

        $usuarios = User::role('usuario')
            ->whereIn('email', array_keys($fechas))
            ->get();

        $poblaciones = Poblacion::all();

        foreach ($usuarios as $usuario) {
            PerfilUsuario::create([
                'usuario_id'   => $usuario->id,
                'telefono'     => '600' . rand(100000, 999999),
                'direccion'    => 'Calle de ejemplo ' . rand(1, 100),
                'poblacion_id' => $poblaciones->random()->id,
                'fecha_boda'   => $fechas[$usuario->email],
            ]);
        }
    }

}
