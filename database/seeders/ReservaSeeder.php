<?php

namespace Database\Seeders;

use App\Models\Boda;
use App\Models\Empresa;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Database\Seeder;


class ReservaSeeder extends Seeder
{
    public function run(): void
    {
        $usuariosEmpresa = User::role('empresa')->get();
        $bodas = Boda::all();

        if ($usuariosEmpresa->isEmpty()) {
            $this->command->info('No hay usuarios con rol empresa.');
            return;
        }

        $reservas = [];
        $cantidad = 30;

        for ($i = 0; $i < $cantidad; $i++) {
            $tipo = collect(['producto', 'servicio', 'bloqueo'])->random();
            $estado = collect(['pendiente', 'confirmada', 'cancelada', 'bloqueada'])->random();
            $origen = collect(['usuario', 'proveedor'])->random();
            $bodaId = null;

            $fechaBase = Carbon::now()->addDays(rand(0, 90));
            $fechaInicio = null;
            $fechaFin = null;
            $productoId = null;
            $allDay = false;
            $user = null;
            $empresa = null;

            // Bloqueo: asignamos empresa aleatoria para cumplir FK
            if ($tipo === 'bloqueo') {
                $empresa = Empresa::inRandomOrder()->first();
                $duracionDias = rand(1, 3);
                $fechaInicio = $fechaBase->copy()->startOfDay();
                $fechaFin = $fechaInicio->copy()->addDays($duracionDias);
                $allDay = true;
            } else {
                // Producto o servicio: usuario -> empresa -> productos
                $user = $usuariosEmpresa->random();
                $empresa = $user->empresa;

                if (!$empresa)
                    continue; // saltar si no tiene empresa
                if (!$bodas->isEmpty()) {
                    $bodaId = $bodas->random()->id;
                }

                if ($tipo === 'servicio') {
                    $horaInicio = rand(8, 16);
                    $duracionHoras = rand(2, 6);
                    $fechaInicio = $fechaBase->copy()->setTime($horaInicio, 0, 0);
                    $fechaFin = $fechaInicio->copy()->addHours($duracionHoras);
                    $allDay = false;

                    $productosEmpresa = $empresa->productos()
                        ->whereHas('tipoProducto', function ($query) {
                            $query->where('modalidad', 'servicio');
                        })
                        ->get();

                    if ($productosEmpresa->isEmpty())
                        continue; // saltar si no hay productos
                    $productoId = $productosEmpresa->random()->id;
                }

                if ($tipo === 'producto') {
                    $duracionDias = rand(1, 4);
                    $fechaInicio = $fechaBase->copy()->startOfDay();
                    $fechaFin = $fechaInicio->copy()->addDays($duracionDias);
                    $allDay = true;

                    $productosEmpresa = $empresa->productos()
                        ->whereHas('tipoProducto', function ($query) {
                            $query->where('modalidad', 'producto');
                        })
                        ->get();

                    if ($productosEmpresa->isEmpty())
                        continue; // saltar si no hay productos
                    $productoId = $productosEmpresa->random()->id;
                }
            }

            $reservas[] = [
                'user_id' => $user?->id,
                'empresa_id' => $empresa->id,
                'producto_id' => $productoId,
                'boda_id' => $bodaId,
                'fecha_inicio' => $fechaInicio,
                'fecha_fin' => $fechaFin,
                'tipo_reserva' => $tipo,
                'estado' => $estado,
                'origen' => $origen,
                'all_day' => $allDay,
                'notas' => 'Reserva generada automáticamente #' . ($i + 1),
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        DB::table('reservas')->insert($reservas);
        $this->command->info("Se han creado " . count($reservas) . " reservas coherentes por empresa.");

    }
}
