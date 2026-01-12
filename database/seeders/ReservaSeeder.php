<?php

namespace Database\Seeders;

use App\Models\Boda;
use App\Models\Empresa;
use App\Models\Reserva;
use App\Models\User;
use Carbon\Carbon;
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

        $estados = ['pendiente', 'confirmada', 'cancelada', 'bloqueada'];
        $origenes = ['usuario', 'proveedor'];

        foreach ($usuarios as $usuario) {

            $empresa = $empresas->random();
            $boda = $bodas->random();
            $start = Carbon::now('Europe/Madrid')
                ->addDays(rand(1, 60))
                ->setTime(rand(8, 17), 0);

            $end = (clone $start)->addHours(rand(1, 6));

            Reserva::create([
                'user_id'      => $usuario->id,
                'empresa_id'   => $empresa->id,
                'boda_id'      => $boda->id,
                'fecha_inicio'  => $start->format('Y-m-d H:i:s'),
                'fecha_fin'     => $end->format('Y-m-d H:i:s'),
                'estado'       => $estados[array_rand($estados)],
                'origen'       => $origenes[array_rand($origenes)],
                'notas'        => fake()->sentence(),

                // Opcional: si tienes tablas servicios o productos
                // 'servicio_id'  => rand(0, 1) ? rand(1, 5) : null,
                // 'producto_id'  => rand(0, 1) ? rand(1, 5) : null,
            ]);
        }

        // ─────────────────────────────────────────────
        // BLOQUEOS DE FECHAS (proveedor no disponible)
        // ─────────────────────────────────────────────

        foreach ($empresas as $empresa) {

            for ($i = 0; $i < 3; $i++) {

                $start = Carbon::now()->addDays(rand(1, 60))->setTime(0, 0);

                Reserva::create([
                    'user_id'      => null,
                    'empresa_id'   => $empresa->id,
                    'boda_id'      => null,
                    'fecha_inicio' => $start,
                    'fecha_fin'    => (clone $start)->addDay(),
                    'estado'       => 'bloqueada',
                    'origen'       => 'proveedor',
                    'notas'        => 'Bloqueo de disponibilidad del proveedor',
                    // 'servicio_id'  => null,
                    // 'producto_id'  => null,
                ]);
            }
        }
    }
}
