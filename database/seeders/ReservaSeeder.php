<?php

namespace Database\Seeders;

use App\Models\Boda;
use App\Models\Empresa;
use App\Models\Reserva;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ReservaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $usuarios = User::role('usuario')->get();
        $empresas = Empresa::all();
        $bodas = Boda::all();

        if ($usuarios->isEmpty() || $empresas->isEmpty()) {
            return;
        }

        $estados = ['confirmada', 'pendiente', 'cancelada'];

        foreach ($usuarios as $index => $usuario) {
            $empresa = $empresas->random();
            $boda = $bodas->random();

            Reserva::create([
                'user_id' => $usuario->id,
                'empresa_id' => $empresa->id,
                'boda_id' => $boda->id,
                'fecha' => now()->addDays(rand(1, 60)), 
                'estado' => $estados[array_rand($estados)],
            ]);
        }
    }
}
