<?php

namespace Database\Seeders;

use App\Models\Boda;
use App\Models\Empresa;
use App\Models\Producto;
use App\Models\Reserva;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class ReservaSeeder extends Seeder
{
    public function run(): void
    {
        $usuarios = User::all();
        $empresas = Empresa::all();
        $bodas    = Boda::all();

        if ($usuarios->isEmpty() || $empresas->isEmpty() || $bodas->isEmpty()) {
            return;
        }

        $estados  = ['pendiente', 'confirmada', 'cancelada'];
        $origenes = ['usuario', 'proveedor'];

        // -----------------------------------
        // RESERVAS
        // -----------------------------------
        foreach ($usuarios as $usuario) {

            // Empresa
            $empresa = $usuario->hasRole('empresa')
                ? $usuario->empresa
                : $empresas->random();

            if (!$empresa) {
                continue;
            }

            // Producto opcional
            $producto = Producto::where('empresa_id', $empresa->id)
                ->with('tipoProducto')
                ->inRandomOrder()
                ->first();

            // Modalidad segura
            $modalidad = $producto?->tipoProducto?->modalidad ?? 'dia';

            $boda = $bodas->random();

            // Evitar solape mismo día
            $intentos = 0;
            do {
                $baseDay = Carbon::now('Europe/Madrid')
                    ->addDays(rand(1, 60))
                    ->startOfDay();

                $existe = Reserva::where('empresa_id', $empresa->id)
                    ->whereDate('fecha_inicio', $baseDay->toDateString())
                    ->exists();

                $intentos++;
            } while ($existe && $intentos < 10);

            if ($existe) {
                continue;
            }

            // Fechas blindadas por modalidad
            switch ($modalidad) {

                case 'servicio':
                    // ---- MISMO DÍA, CON HORAS ----
                    $start = $baseDay->copy()->setTime(rand(8, 16), 0);
                    $end   = $start->copy()->addHours(rand(1, 6));

                    // seguridad extra
                    if ($end->isSameDay($start) === false) {
                        $end = $start->copy()->endOfDay();
                    }
                    break;

                case 'producto':
                case 'dia':
                default:
                    // ---- POR DÍAS (MÍNIMO +1) ----
                    $dias  = rand(1, 4); // 1 o varios días
                    $start = $baseDay->copy()->startOfDay();
                    $end   = $start->copy()->addDays($dias);
                    break;
            }

            Reserva::create([
                'user_id'      => $usuario->hasRole('empresa') ? null : $usuario->id,
                'empresa_id'   => $empresa->id,
                'boda_id'      => $usuario->hasRole('empresa') ? null : $boda->id,
                'fecha_inicio' => $start,
                'fecha_fin'    => $end,
                'estado'       => $estados[array_rand($estados)],
                'origen'       => $usuario->hasRole('empresa')
                                    ? 'proveedor'
                                    : $origenes[array_rand($origenes)],
                'notas'        => fake()->sentence(),
                'producto_id'  => $producto?->id,
            ]);
        }

        // -----------------------------------
        // BLOQUEOS (SIEMPRE POR DÍA)
        // -----------------------------------
        foreach ($empresas as $empresa) {

            for ($i = 0; $i < 3; $i++) {

                $intentos = 0;
                do {
                    $start = Carbon::now('Europe/Madrid')
                        ->addDays(rand(1, 60))
                        ->startOfDay();

                    $existe = Reserva::where('empresa_id', $empresa->id)
                        ->whereDate('fecha_inicio', $start->toDateString())
                        ->exists();

                    $intentos++;
                } while ($existe && $intentos < 10);

                if ($existe) {
                    continue;
                }

                Reserva::create([
                    'user_id'      => null,
                    'empresa_id'   => $empresa->id,
                    'boda_id'      => null,
                    'fecha_inicio' => $start,
                    'fecha_fin'    => $start->copy()->addDay(),
                    'estado'       => 'bloqueada',
                    'origen'       => 'proveedor',
                    'notas'        => 'Bloqueo de disponibilidad',
                    'producto_id'  => null,
                ]);
            }
        }
    }
}
