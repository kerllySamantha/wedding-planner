<?php

namespace Database\Seeders;

use App\Models\PerfilUsuario;
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

        foreach ($usuarios as $usuario) {
            PerfilUsuario::create([
                'usuario_id' => $usuario->id,
                'telefono' => '600' . rand(100000, 999999),
                'direccion' => 'Calle de ejemplo ' . rand(1, 100),
                // 'avatar' => null, // o ruta a imagen de prueba
                // 'notas' => 'Perfil de prueba para ' . $usuario->name,
            ]);
        }
    
    }
}
