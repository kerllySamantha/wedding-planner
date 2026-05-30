<?php

namespace Database\Seeders;

use App\Models\Boda;
use App\Models\TipoProducto;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PresupuestoSeeder extends Seeder
{
    public function run(): void
    {
        $tipoFoto      = TipoProducto::where('nombre', 'Fotografía tradicional')->first();
        $tipoCobFoto   = TipoProducto::where('nombre', 'Cobertura completa de boda')->first();
        $tipoVideo     = TipoProducto::where('nombre', 'Video cinematográfico')->first();
        $tipoBanquete  = TipoProducto::where('nombre', 'Banquete completo')->first();
        $tipoCatering  = TipoProducto::where('nombre', 'Catering informal')->first();

        $javier = User::where('email', 'javier@example.com')->first();
        $laura  = User::where('email', 'laura@example.com')->first();
        $maria  = User::where('email', 'maria@example.com')->first();
        $sonia  = User::where('email', 'sonia@example.com')->first();
        $carmen = User::where('email', 'carmen@example.com')->first();

        $bodaJavier = $javier ? Boda::where('usuario_id', $javier->id)->first() : null;
        $bodaLaura  = $laura  ? Boda::where('usuario_id', $laura->id)->first()  : null;
        $bodaMaria  = $maria  ? Boda::where('usuario_id', $maria->id)->first()  : null;
        $bodaSonia  = $sonia  ? Boda::where('usuario_id', $sonia->id)->first()  : null;
        $bodaCarmen = $carmen ? Boda::where('usuario_id', $carmen->id)->first() : null;

        $now = Carbon::now();

        // ── JAVIER: boda completada 2024-09-15 ──────────────────────────────────
        if ($bodaJavier) {
            $p1 = DB::table('presupuestos')->insertGetId([
                'boda_id'          => $bodaJavier->id,
                'tipo_producto_id' => $tipoFoto?->id,
                'monto_total'      => 3200.00,
                'monto_pagado'     => 3200.00,
                'estado'           => 'aceptado_usuario',
                'fecha_creacion'   => '2024-02-05',
                'created_at'       => $now,
                'updated_at'       => $now,
            ]);
            DB::table('item_presupuestos')->insert([
                [
                    'presupuesto_id'           => $p1,
                    'tipo_producto_id'          => $tipoFoto?->id,
                    'nombre_tipo_personalizado' => null,
                    'es_personalizado'          => false,
                    'monto_estimado'            => 2000.00,
                    'monto_pagado'              => 2000.00,
                    'notas'                     => 'Reportaje fotográfico completo. Álbum digital y físico incluido.',
                    'created_at'                => $now,
                    'updated_at'                => $now,
                ],
                [
                    'presupuesto_id'           => $p1,
                    'tipo_producto_id'          => $tipoVideo?->id,
                    'nombre_tipo_personalizado' => null,
                    'es_personalizado'          => false,
                    'monto_estimado'            => 1200.00,
                    'monto_pagado'              => 1200.00,
                    'notas'                     => 'Video cinematográfico con edición highlight de 5 minutos.',
                    'created_at'                => $now,
                    'updated_at'                => $now,
                ],
            ]);

            $p2 = DB::table('presupuestos')->insertGetId([
                'boda_id'          => $bodaJavier->id,
                'tipo_producto_id' => $tipoBanquete?->id,
                'monto_total'      => 8500.00,
                'monto_pagado'     => 8500.00,
                'estado'           => 'aceptado_usuario',
                'fecha_creacion'   => '2024-02-10',
                'created_at'       => $now,
                'updated_at'       => $now,
            ]);
            DB::table('item_presupuestos')->insert([
                [
                    'presupuesto_id'           => $p2,
                    'tipo_producto_id'          => $tipoBanquete?->id,
                    'nombre_tipo_personalizado' => null,
                    'es_personalizado'          => false,
                    'monto_estimado'            => 6500.00,
                    'monto_pagado'              => 6500.00,
                    'notas'                     => 'Banquete completo para 120 invitados. Menú degustación 5 platos.',
                    'created_at'                => $now,
                    'updated_at'                => $now,
                ],
                [
                    'presupuesto_id'           => $p2,
                    'tipo_producto_id'          => $tipoCatering?->id,
                    'nombre_tipo_personalizado' => null,
                    'es_personalizado'          => false,
                    'monto_estimado'            => 2000.00,
                    'monto_pagado'              => 2000.00,
                    'notas'                     => 'Aperitivo hora cocktail: finger foods y bebidas de bienvenida.',
                    'created_at'                => $now,
                    'updated_at'                => $now,
                ],
            ]);
        }

        // ── MARÍA: boda completada 2025-03-15 ───────────────────────────────────
        if ($bodaMaria) {
            $p3 = DB::table('presupuestos')->insertGetId([
                'boda_id'          => $bodaMaria->id,
                'tipo_producto_id' => $tipoFoto?->id,
                'monto_total'      => 2800.00,
                'monto_pagado'     => 2800.00,
                'estado'           => 'aceptado_usuario',
                'fecha_creacion'   => '2024-11-10',
                'created_at'       => $now,
                'updated_at'       => $now,
            ]);
            DB::table('item_presupuestos')->insert([
                [
                    'presupuesto_id'           => $p3,
                    'tipo_producto_id'          => $tipoFoto?->id,
                    'nombre_tipo_personalizado' => null,
                    'es_personalizado'          => false,
                    'monto_estimado'            => 2800.00,
                    'monto_pagado'              => 2800.00,
                    'notas'                     => 'Reportaje fotográfico completo. Álbum digital y físico incluido.',
                    'created_at'                => $now,
                    'updated_at'                => $now,
                ],
            ]);

            $p4 = DB::table('presupuestos')->insertGetId([
                'boda_id'          => $bodaMaria->id,
                'tipo_producto_id' => $tipoBanquete?->id,
                'monto_total'      => 7200.00,
                'monto_pagado'     => 7200.00,
                'estado'           => 'aceptado_usuario',
                'fecha_creacion'   => '2024-11-20',
                'created_at'       => $now,
                'updated_at'       => $now,
            ]);
            DB::table('item_presupuestos')->insert([
                [
                    'presupuesto_id'           => $p4,
                    'tipo_producto_id'          => $tipoBanquete?->id,
                    'nombre_tipo_personalizado' => null,
                    'es_personalizado'          => false,
                    'monto_estimado'            => 5500.00,
                    'monto_pagado'              => 5500.00,
                    'notas'                     => 'Banquete completo para 90 invitados. Menú degustación 4 platos.',
                    'created_at'                => $now,
                    'updated_at'                => $now,
                ],
                [
                    'presupuesto_id'           => $p4,
                    'tipo_producto_id'          => $tipoCatering?->id,
                    'nombre_tipo_personalizado' => null,
                    'es_personalizado'          => false,
                    'monto_estimado'            => 1700.00,
                    'monto_pagado'              => 1700.00,
                    'notas'                     => 'Aperitivo cocktail de bienvenida: finger foods y bebidas.',
                    'created_at'                => $now,
                    'updated_at'                => $now,
                ],
            ]);
        }

        // ── LAURA: boda terminada hace ~3 días, presupuestos pagados ────────────
        if ($bodaLaura) {
            $p5 = DB::table('presupuestos')->insertGetId([
                'boda_id'          => $bodaLaura->id,
                'tipo_producto_id' => $tipoFoto?->id,
                'monto_total'      => 2400.00,
                'monto_pagado'     => 2400.00,
                'estado'           => 'aceptado_usuario',
                'fecha_creacion'   => Carbon::now()->subMonths(6)->toDateString(),
                'created_at'       => $now,
                'updated_at'       => $now,
            ]);
            DB::table('item_presupuestos')->insert([
                [
                    'presupuesto_id'           => $p5,
                    'tipo_producto_id'          => $tipoFoto?->id,
                    'nombre_tipo_personalizado' => null,
                    'es_personalizado'          => false,
                    'monto_estimado'            => 2400.00,
                    'monto_pagado'              => 2400.00,
                    'notas'                     => 'Reportaje fotográfico completo 10 horas. Totalmente pagado.',
                    'created_at'                => $now,
                    'updated_at'                => $now,
                ],
            ]);

            $p6 = DB::table('presupuestos')->insertGetId([
                'boda_id'          => $bodaLaura->id,
                'tipo_producto_id' => $tipoBanquete?->id,
                'monto_total'      => 5800.00,
                'monto_pagado'     => 5800.00,
                'estado'           => 'aceptado_usuario',
                'fecha_creacion'   => Carbon::now()->subMonths(5)->toDateString(),
                'created_at'       => $now,
                'updated_at'       => $now,
            ]);
            DB::table('item_presupuestos')->insert([
                [
                    'presupuesto_id'           => $p6,
                    'tipo_producto_id'          => $tipoBanquete?->id,
                    'nombre_tipo_personalizado' => null,
                    'es_personalizado'          => false,
                    'monto_estimado'            => 4400.00,
                    'monto_pagado'              => 4400.00,
                    'notas'                     => 'Banquete 75 invitados. Menú 3 platos + postre.',
                    'created_at'                => $now,
                    'updated_at'                => $now,
                ],
                [
                    'presupuesto_id'           => $p6,
                    'tipo_producto_id'          => $tipoCatering?->id,
                    'nombre_tipo_personalizado' => null,
                    'es_personalizado'          => false,
                    'monto_estimado'            => 1400.00,
                    'monto_pagado'              => 1400.00,
                    'notas'                     => 'Aperitivo cocktail de bienvenida.',
                    'created_at'                => $now,
                    'updated_at'                => $now,
                ],
            ]);
        }

        // ── SONIA: boda completada 2025-09-20 ────────────────────────────────────
        if ($bodaSonia) {
            $p7 = DB::table('presupuestos')->insertGetId([
                'boda_id'          => $bodaSonia->id,
                'tipo_producto_id' => $tipoFoto?->id,
                'monto_total'      => 2600.00,
                'monto_pagado'     => 2600.00,
                'estado'           => 'aceptado_usuario',
                'fecha_creacion'   => '2025-03-10',
                'created_at'       => $now,
                'updated_at'       => $now,
            ]);
            DB::table('item_presupuestos')->insert([
                [
                    'presupuesto_id'           => $p7,
                    'tipo_producto_id'          => $tipoFoto?->id,
                    'nombre_tipo_personalizado' => null,
                    'es_personalizado'          => false,
                    'monto_estimado'            => 2600.00,
                    'monto_pagado'              => 2600.00,
                    'notas'                     => 'Reportaje fotográfico completo 10 horas. Álbum digital y físico.',
                    'created_at'                => $now,
                    'updated_at'                => $now,
                ],
            ]);

            $p8 = DB::table('presupuestos')->insertGetId([
                'boda_id'          => $bodaSonia->id,
                'tipo_producto_id' => $tipoBanquete?->id,
                'monto_total'      => 7000.00,
                'monto_pagado'     => 7000.00,
                'estado'           => 'aceptado_usuario',
                'fecha_creacion'   => '2025-03-20',
                'created_at'       => $now,
                'updated_at'       => $now,
            ]);
            DB::table('item_presupuestos')->insert([
                [
                    'presupuesto_id'           => $p8,
                    'tipo_producto_id'          => $tipoBanquete?->id,
                    'nombre_tipo_personalizado' => null,
                    'es_personalizado'          => false,
                    'monto_estimado'            => 5500.00,
                    'monto_pagado'              => 5500.00,
                    'notas'                     => 'Banquete 100 invitados. Menú degustación 5 platos.',
                    'created_at'                => $now,
                    'updated_at'                => $now,
                ],
                [
                    'presupuesto_id'           => $p8,
                    'tipo_producto_id'          => $tipoCatering?->id,
                    'nombre_tipo_personalizado' => null,
                    'es_personalizado'          => false,
                    'monto_estimado'            => 1500.00,
                    'monto_pagado'              => 1500.00,
                    'notas'                     => 'Cocktail de bienvenida 1 hora.',
                    'created_at'                => $now,
                    'updated_at'                => $now,
                ],
            ]);
        }

        // ── CARMEN: boda completada 2025-04-10 ───────────────────────────────────
        if ($bodaCarmen) {
            $p6 = DB::table('presupuestos')->insertGetId([
                'boda_id'          => $bodaCarmen->id,
                'tipo_producto_id' => $tipoCobFoto?->id,
                'monto_total'      => 3100.00,
                'monto_pagado'     => 3100.00,
                'estado'           => 'aceptado_usuario',
                'fecha_creacion'   => '2024-12-05',
                'created_at'       => $now,
                'updated_at'       => $now,
            ]);
            DB::table('item_presupuestos')->insert([
                [
                    'presupuesto_id'           => $p6,
                    'tipo_producto_id'          => $tipoCobFoto?->id,
                    'nombre_tipo_personalizado' => null,
                    'es_personalizado'          => false,
                    'monto_estimado'            => 3100.00,
                    'monto_pagado'              => 3100.00,
                    'notas'                     => 'Cobertura completa 10 horas. Álbum digital y físico premium. Galería online privada 1 año.',
                    'created_at'                => $now,
                    'updated_at'                => $now,
                ],
            ]);

            $p7 = DB::table('presupuestos')->insertGetId([
                'boda_id'          => $bodaCarmen->id,
                'tipo_producto_id' => $tipoBanquete?->id,
                'monto_total'      => 6800.00,
                'monto_pagado'     => 6800.00,
                'estado'           => 'aceptado_usuario',
                'fecha_creacion'   => '2024-12-15',
                'created_at'       => $now,
                'updated_at'       => $now,
            ]);
            DB::table('item_presupuestos')->insert([
                [
                    'presupuesto_id'           => $p7,
                    'tipo_producto_id'          => $tipoBanquete?->id,
                    'nombre_tipo_personalizado' => null,
                    'es_personalizado'          => false,
                    'monto_estimado'            => 5200.00,
                    'monto_pagado'              => 5200.00,
                    'notas'                     => 'Banquete completo para 85 invitados. Menú degustación 4 platos + postre.',
                    'created_at'                => $now,
                    'updated_at'                => $now,
                ],
                [
                    'presupuesto_id'           => $p7,
                    'tipo_producto_id'          => $tipoCatering?->id,
                    'nombre_tipo_personalizado' => null,
                    'es_personalizado'          => false,
                    'monto_estimado'            => 1600.00,
                    'monto_pagado'              => 1600.00,
                    'notas'                     => 'Cocktail de bienvenida 1 hora en terraza con vistas al mar.',
                    'created_at'                => $now,
                    'updated_at'                => $now,
                ],
            ]);
        }

        $this->command->info('PresupuestoSeeder: presupuestos e ítems creados correctamente.');
    }
}
