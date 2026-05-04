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
        $usuarios = User::role('usuario')->get();
        $poblaciones = Poblacion::all();

        foreach ($usuarios as $usuario) {
            PerfilUsuario::create([
                'usuario_id' => $usuario->id,
                'telefono' => '600' . rand(100000, 999999),
                'direccion' => 'Calle de ejemplo ' . rand(1, 100),
                'poblacion_id' => $poblaciones->random()->id,
                // 'novios' => fake()->randomElement(['novia', 'novio']),
                'fecha_boda' => fake()->dateTimeBetween('+1 month', '+2 years')->format('Y-m-d'),
            ]);
        }
    }

}
