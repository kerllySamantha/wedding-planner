<?php

namespace Database\Seeders;

use App\Models\Boda;
use App\Models\Empresa;
use App\Models\TipoProducto;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PedirPresupuestoSeeder extends Seeder
{
    public function run(): void
    {
        $javier = User::where('email', 'javier@example.com')->first();
        $maria  = User::where('email', 'maria@example.com')->first();
        $laura  = User::where('email', 'laura@example.com')->first();
        $sonia  = User::where('email', 'sonia@example.com')->first();
        $carmen = User::where('email', 'carmen@example.com')->first();

        $bodaJavier = $javier ? Boda::where('usuario_id', $javier->id)->first() : null;
        $bodaMaria  = $maria  ? Boda::where('usuario_id', $maria->id)->first()  : null;
        $bodaLaura  = $laura  ? Boda::where('usuario_id', $laura->id)->first()  : null;
        $bodaSonia  = $sonia  ? Boda::where('usuario_id', $sonia->id)->first()  : null;
        $bodaCarmen = $carmen ? Boda::where('usuario_id', $carmen->id)->first() : null;

        $catering   = Empresa::where('nombre_empresa', 'Catering La Alhambra')->first();
        $fotografia = Empresa::where('nombre_empresa', 'Fotografía Segovia')->first();

        $productoCatering = $catering?->productos()->first();
        $productoFoto     = $fotografia?->productos()->first();

        $tipoFoto     = TipoProducto::where('nombre', 'Fotografía tradicional')->first();
        $tipoCobFoto  = TipoProducto::where('nombre', 'Cobertura completa de boda')->first();
        $tipoBanquete = TipoProducto::where('nombre', 'Banquete completo')->first();

        // ── JAVIER: boda completada 2024-09-15 ──────────────────────────────────
        if ($bodaJavier && $fotografia) {
            DB::table('pedir_presupuestos')->insert([
                'empresa_id'                    => $fotografia->id,
                'user_id'                       => $javier->id,
                'boda_id'                       => $bodaJavier->id,
                'tipo_producto_id'              => $tipoFoto?->id,
                'producto_id'                   => $productoFoto?->id,
                'reserva_id'                    => null,
                'nombre'                        => 'Javier Martínez',
                'telefono'                      => '600222333',
                'email'                         => 'javier@example.com',
                'mensaje'                       => 'Necesitamos reportaje fotográfico y video para nuestra boda del 15 de septiembre. Somos 120 invitados.',
                'invitados'                     => 120,
                'presupuesto'                   => 3500,
                'fecha'                         => '2024-09-15',
                'estado'                        => 'aceptado_usuario',
                'importe_ofertado'              => 3200.00,
                'comentario_empresa'            => 'Incluye reportaje completo, álbum digital, álbum físico premium y video cinematográfico highlight de 5 min.',
                'modalidad'                     => 'servicio',
                'fecha_inicio'                  => '2024-09-15 11:00:00',
                'fecha_fin'                     => '2024-09-15 21:00:00',
                'fecha_respuesta'               => Carbon::create(2024, 2, 15),
                'producto_personalizado_nombre' => null,
                'es_producto_personalizado'     => false,
                'created_at'                    => Carbon::create(2024, 2, 5),
                'updated_at'                    => Carbon::create(2024, 2, 15),
            ]);
        }

        if ($bodaJavier && $catering) {
            DB::table('pedir_presupuestos')->insert([
                'empresa_id'                    => $catering->id,
                'user_id'                       => $javier->id,
                'boda_id'                       => $bodaJavier->id,
                'tipo_producto_id'              => $tipoBanquete?->id,
                'producto_id'                   => $productoCatering?->id,
                'reserva_id'                    => null,
                'nombre'                        => 'Javier Martínez',
                'telefono'                      => '600222333',
                'email'                         => 'javier@example.com',
                'mensaje'                       => 'Boda para 120 personas el 15 de septiembre. Menú degustación y aperitivo de bienvenida con bebidas.',
                'invitados'                     => 120,
                'presupuesto'                   => 9000,
                'fecha'                         => '2024-09-15',
                'estado'                        => 'aceptado_usuario',
                'importe_ofertado'              => 8500.00,
                'comentario_empresa'            => 'Menú degustación 5 platos para 120 personas. Incluye hora cocktail, barra libre durante el banquete y tarta nupcial.',
                'modalidad'                     => 'servicio',
                'fecha_inicio'                  => '2024-09-15 13:00:00',
                'fecha_fin'                     => '2024-09-15 23:00:00',
                'fecha_respuesta'               => Carbon::create(2024, 2, 20),
                'producto_personalizado_nombre' => null,
                'es_producto_personalizado'     => false,
                'created_at'                    => Carbon::create(2024, 2, 10),
                'updated_at'                    => Carbon::create(2024, 2, 20),
            ]);
        }

        // ── MARÍA: boda completada 2025-03-15 ───────────────────────────────────
        if ($bodaMaria && $fotografia) {
            $pedirFotoId = DB::table('pedir_presupuestos')->insertGetId([
                'empresa_id'                    => $fotografia->id,
                'user_id'                       => $maria->id,
                'boda_id'                       => $bodaMaria->id,
                'tipo_producto_id'              => $tipoFoto?->id,
                'producto_id'                   => $productoFoto?->id,
                'reserva_id'                    => null,
                'nombre'                        => 'María López',
                'telefono'                      => '600333444',
                'email'                         => 'maria@example.com',
                'mensaje'                       => 'Boda el 15 de marzo 2025 en Sevilla. Buscamos reportaje fotográfico para unos 90 invitados.',
                'invitados'                     => 90,
                'presupuesto'                   => 3000,
                'fecha'                         => '2025-03-15',
                'estado'                        => 'aceptado_usuario',
                'importe_ofertado'              => 2800.00,
                'comentario_empresa'            => 'Reportaje fotográfico completo 10 horas. Álbum digital y físico premium incluido.',
                'modalidad'                     => 'servicio',
                'fecha_inicio'                  => '2025-03-15 11:00:00',
                'fecha_fin'                     => '2025-03-15 21:00:00',
                'fecha_respuesta'               => Carbon::create(2024, 11, 20),
                'producto_personalizado_nombre' => null,
                'es_producto_personalizado'     => false,
                'created_at'                    => Carbon::create(2024, 11, 10),
                'updated_at'                    => Carbon::create(2024, 11, 20),
            ]);

            $reservaFotoId = DB::table('reservas')->insertGetId([
                'user_id'              => $maria->id,
                'empresa_id'           => $fotografia->id,
                'producto_id'          => $productoFoto?->id,
                'boda_id'              => $bodaMaria->id,
                'pedir_presupuesto_id' => $pedirFotoId,
                'fecha_inicio'         => '2025-03-15 11:00:00',
                'fecha_fin'            => '2025-03-15 21:00:00',
                'tipo_reserva'         => 'servicio',
                'estado'               => 'confirmada',
                'origen'               => 'usuario',
                'all_day'              => false,
                'notas'                => 'Reportaje fotográfico completo de boda — 10 horas.',
                'created_at'           => Carbon::create(2024, 11, 20),
                'updated_at'           => Carbon::create(2024, 11, 20),
            ]);

            DB::table('pedir_presupuestos')
                ->where('id', $pedirFotoId)
                ->update(['reserva_id' => $reservaFotoId]);
        }

        if ($bodaMaria && $catering) {
            $pedirCateringId = DB::table('pedir_presupuestos')->insertGetId([
                'empresa_id'                    => $catering->id,
                'user_id'                       => $maria->id,
                'boda_id'                       => $bodaMaria->id,
                'tipo_producto_id'              => $tipoBanquete?->id,
                'producto_id'                   => $productoCatering?->id,
                'reserva_id'                    => null,
                'nombre'                        => 'María López',
                'telefono'                      => '600333444',
                'email'                         => 'maria@example.com',
                'mensaje'                       => 'Boda el 15 de marzo 2025 en Sevilla. Necesitamos catering para 90 invitados con menú de 4 platos.',
                'invitados'                     => 90,
                'presupuesto'                   => 8000,
                'fecha'                         => '2025-03-15',
                'estado'                        => 'aceptado_usuario',
                'importe_ofertado'              => 7200.00,
                'comentario_empresa'            => 'Menú 4 platos + postre para 90 personas. Aperitivo cocktail 1 hora y barra libre durante el banquete.',
                'modalidad'                     => 'servicio',
                'fecha_inicio'                  => '2025-03-15 14:00:00',
                'fecha_fin'                     => '2025-03-15 23:30:00',
                'fecha_respuesta'               => Carbon::create(2024, 11, 25),
                'producto_personalizado_nombre' => null,
                'es_producto_personalizado'     => false,
                'created_at'                    => Carbon::create(2024, 11, 15),
                'updated_at'                    => Carbon::create(2024, 11, 25),
            ]);

            $reservaCateringId = DB::table('reservas')->insertGetId([
                'user_id'              => $maria->id,
                'empresa_id'           => $catering->id,
                'producto_id'          => $productoCatering?->id,
                'boda_id'              => $bodaMaria->id,
                'pedir_presupuesto_id' => $pedirCateringId,
                'fecha_inicio'         => '2025-03-15 14:00:00',
                'fecha_fin'            => '2025-03-15 23:30:00',
                'tipo_reserva'         => 'servicio',
                'estado'               => 'confirmada',
                'origen'               => 'usuario',
                'all_day'              => false,
                'notas'                => 'Catering completo para 90 invitados — banquete + cocktail.',
                'created_at'           => Carbon::create(2024, 11, 25),
                'updated_at'           => Carbon::create(2024, 11, 25),
            ]);

            DB::table('pedir_presupuestos')
                ->where('id', $pedirCateringId)
                ->update(['reserva_id' => $reservaCateringId]);
        }

        // ── LAURA: boda terminada hace ~3 días, sin reseñas ni fotos todavía ──────
        $fechaBodaLaura = Carbon::now()->subDays(3);

        if ($bodaLaura && $fotografia) {
            $pedirLauraFotoId = DB::table('pedir_presupuestos')->insertGetId([
                'empresa_id'                    => $fotografia->id,
                'user_id'                       => $laura->id,
                'boda_id'                       => $bodaLaura->id,
                'tipo_producto_id'              => $tipoFoto?->id,
                'producto_id'                   => $productoFoto?->id,
                'reserva_id'                    => null,
                'nombre'                        => 'Laura García',
                'telefono'                      => '600111222',
                'email'                         => 'laura@example.com',
                'mensaje'                       => 'Boda en Segovia el ' . $fechaBodaLaura->format('d/m/Y') . '. Queremos reportaje fotográfico para unos 75 invitados.',
                'invitados'                     => 75,
                'presupuesto'                   => 2800,
                'fecha'                         => $fechaBodaLaura->toDateString(),
                'estado'                        => 'aceptado_usuario',
                'importe_ofertado'              => 2400.00,
                'comentario_empresa'            => 'Reportaje fotográfico completo 10 horas. Álbum digital incluido.',
                'modalidad'                     => 'servicio',
                'fecha_inicio'                  => $fechaBodaLaura->copy()->setTime(11, 0)->toDateTimeString(),
                'fecha_fin'                     => $fechaBodaLaura->copy()->setTime(21, 0)->toDateTimeString(),
                'fecha_respuesta'               => Carbon::now()->subMonths(6)->addDays(10),
                'producto_personalizado_nombre' => null,
                'es_producto_personalizado'     => false,
                'created_at'                    => Carbon::now()->subMonths(6),
                'updated_at'                    => Carbon::now()->subMonths(6)->addDays(10),
            ]);

            $reservaLauraFotoId = DB::table('reservas')->insertGetId([
                'user_id'              => $laura->id,
                'empresa_id'           => $fotografia->id,
                'producto_id'          => $productoFoto?->id,
                'boda_id'              => $bodaLaura->id,
                'pedir_presupuesto_id' => $pedirLauraFotoId,
                'fecha_inicio'         => $fechaBodaLaura->copy()->setTime(11, 0)->toDateTimeString(),
                'fecha_fin'            => $fechaBodaLaura->copy()->setTime(21, 0)->toDateTimeString(),
                'tipo_reserva'         => 'servicio',
                'estado'               => 'confirmada',
                'origen'               => 'usuario',
                'all_day'              => false,
                'notas'                => 'Reportaje fotográfico boda Laura & Marcos.',
                'created_at'           => Carbon::now()->subMonths(6)->addDays(10),
                'updated_at'           => Carbon::now()->subMonths(6)->addDays(10),
            ]);

            DB::table('pedir_presupuestos')
                ->where('id', $pedirLauraFotoId)
                ->update(['reserva_id' => $reservaLauraFotoId]);
        }

        if ($bodaLaura && $catering) {
            $pedirLauraCateringId = DB::table('pedir_presupuestos')->insertGetId([
                'empresa_id'                    => $catering->id,
                'user_id'                       => $laura->id,
                'boda_id'                       => $bodaLaura->id,
                'tipo_producto_id'              => $tipoBanquete?->id,
                'producto_id'                   => $productoCatering?->id,
                'reserva_id'                    => null,
                'nombre'                        => 'Laura García',
                'telefono'                      => '600111222',
                'email'                         => 'laura@example.com',
                'mensaje'                       => 'Boda en Segovia. Catering para 75 personas, menú 3 platos.',
                'invitados'                     => 75,
                'presupuesto'                   => 6500,
                'fecha'                         => $fechaBodaLaura->toDateString(),
                'estado'                        => 'aceptado_usuario',
                'importe_ofertado'              => 5800.00,
                'comentario_empresa'            => 'Menú 3 platos + postre para 75 personas. Aperitivo de bienvenida y barra libre.',
                'modalidad'                     => 'servicio',
                'fecha_inicio'                  => $fechaBodaLaura->copy()->setTime(14, 0)->toDateTimeString(),
                'fecha_fin'                     => $fechaBodaLaura->copy()->setTime(23, 0)->toDateTimeString(),
                'fecha_respuesta'               => Carbon::now()->subMonths(5)->addDays(5),
                'producto_personalizado_nombre' => null,
                'es_producto_personalizado'     => false,
                'created_at'                    => Carbon::now()->subMonths(5),
                'updated_at'                    => Carbon::now()->subMonths(5)->addDays(5),
            ]);

            $reservaLauraCateringId = DB::table('reservas')->insertGetId([
                'user_id'              => $laura->id,
                'empresa_id'           => $catering->id,
                'producto_id'          => $productoCatering?->id,
                'boda_id'              => $bodaLaura->id,
                'pedir_presupuesto_id' => $pedirLauraCateringId,
                'fecha_inicio'         => $fechaBodaLaura->copy()->setTime(14, 0)->toDateTimeString(),
                'fecha_fin'            => $fechaBodaLaura->copy()->setTime(23, 0)->toDateTimeString(),
                'tipo_reserva'         => 'servicio',
                'estado'               => 'confirmada',
                'origen'               => 'usuario',
                'all_day'              => false,
                'notas'                => 'Catering completo boda Laura & Marcos — 75 pax.',
                'created_at'           => Carbon::now()->subMonths(5)->addDays(5),
                'updated_at'           => Carbon::now()->subMonths(5)->addDays(5),
            ]);

            DB::table('pedir_presupuestos')
                ->where('id', $pedirLauraCateringId)
                ->update(['reserva_id' => $reservaLauraCateringId]);
        }

        // ── SONIA: boda completada 2025-09-20 ────────────────────────────────────
        if ($bodaSonia && $fotografia) {
            $pedirSoniaFotoId = DB::table('pedir_presupuestos')->insertGetId([
                'empresa_id'                    => $fotografia->id,
                'user_id'                       => $sonia->id,
                'boda_id'                       => $bodaSonia->id,
                'tipo_producto_id'              => $tipoFoto?->id,
                'producto_id'                   => $productoFoto?->id,
                'reserva_id'                    => null,
                'nombre'                        => 'Sonia Valdés',
                'telefono'                      => '616219052',
                'email'                         => 'sonia@example.com',
                'mensaje'                       => 'Boda el 20 de septiembre 2025 en Alicante. Buscamos reportaje fotográfico para unos 100 invitados.',
                'invitados'                     => 100,
                'presupuesto'                   => 3000,
                'fecha'                         => '2025-09-20',
                'estado'                        => 'aceptado_usuario',
                'importe_ofertado'              => 2600.00,
                'comentario_empresa'            => 'Reportaje fotográfico completo 10 horas. Álbum digital y físico premium.',
                'modalidad'                     => 'servicio',
                'fecha_inicio'                  => '2025-09-20 11:00:00',
                'fecha_fin'                     => '2025-09-20 21:00:00',
                'fecha_respuesta'               => Carbon::create(2025, 3, 20),
                'producto_personalizado_nombre' => null,
                'es_producto_personalizado'     => false,
                'created_at'                    => Carbon::create(2025, 3, 10),
                'updated_at'                    => Carbon::create(2025, 3, 20),
            ]);

            $reservaSoniaFotoId = DB::table('reservas')->insertGetId([
                'user_id'              => $sonia->id,
                'empresa_id'           => $fotografia->id,
                'producto_id'          => $productoFoto?->id,
                'boda_id'              => $bodaSonia->id,
                'pedir_presupuesto_id' => $pedirSoniaFotoId,
                'fecha_inicio'         => '2025-09-20 11:00:00',
                'fecha_fin'            => '2025-09-20 21:00:00',
                'tipo_reserva'         => 'servicio',
                'estado'               => 'confirmada',
                'origen'               => 'usuario',
                'all_day'              => false,
                'notas'                => 'Reportaje fotográfico completo boda Sonia & Marcos.',
                'created_at'           => Carbon::create(2025, 3, 20),
                'updated_at'           => Carbon::create(2025, 3, 20),
            ]);

            DB::table('pedir_presupuestos')
                ->where('id', $pedirSoniaFotoId)
                ->update(['reserva_id' => $reservaSoniaFotoId]);
        }

        if ($bodaSonia && $catering) {
            $pedirSoniaCateringId = DB::table('pedir_presupuestos')->insertGetId([
                'empresa_id'                    => $catering->id,
                'user_id'                       => $sonia->id,
                'boda_id'                       => $bodaSonia->id,
                'tipo_producto_id'              => $tipoBanquete?->id,
                'producto_id'                   => $productoCatering?->id,
                'reserva_id'                    => null,
                'nombre'                        => 'Sonia Valdés',
                'telefono'                      => '616219052',
                'email'                         => 'sonia@example.com',
                'mensaje'                       => 'Boda el 20 de septiembre 2025 en Alicante. Catering para 100 personas, menú de 4 platos con aperitivo.',
                'invitados'                     => 100,
                'presupuesto'                   => 8000,
                'fecha'                         => '2025-09-20',
                'estado'                        => 'aceptado_usuario',
                'importe_ofertado'              => 7000.00,
                'comentario_empresa'            => 'Menú 4 platos + postre para 100 personas. Cocktail de bienvenida y barra libre durante el banquete.',
                'modalidad'                     => 'servicio',
                'fecha_inicio'                  => '2025-09-20 14:00:00',
                'fecha_fin'                     => '2025-09-20 23:30:00',
                'fecha_respuesta'               => Carbon::create(2025, 3, 25),
                'producto_personalizado_nombre' => null,
                'es_producto_personalizado'     => false,
                'created_at'                    => Carbon::create(2025, 3, 15),
                'updated_at'                    => Carbon::create(2025, 3, 25),
            ]);

            $reservaSoniaCateringId = DB::table('reservas')->insertGetId([
                'user_id'              => $sonia->id,
                'empresa_id'           => $catering->id,
                'producto_id'          => $productoCatering?->id,
                'boda_id'              => $bodaSonia->id,
                'pedir_presupuesto_id' => $pedirSoniaCateringId,
                'fecha_inicio'         => '2025-09-20 14:00:00',
                'fecha_fin'            => '2025-09-20 23:30:00',
                'tipo_reserva'         => 'servicio',
                'estado'               => 'confirmada',
                'origen'               => 'usuario',
                'all_day'              => false,
                'notas'                => 'Catering completo boda Sonia & Marcos — cocktail + banquete 100 pax.',
                'created_at'           => Carbon::create(2025, 3, 25),
                'updated_at'           => Carbon::create(2025, 3, 25),
            ]);

            DB::table('pedir_presupuestos')
                ->where('id', $pedirSoniaCateringId)
                ->update(['reserva_id' => $reservaSoniaCateringId]);
        }

        // ── CARMEN: boda completada 2025-04-10, ambas solicitudes aceptadas ──────
        if ($bodaCarmen && $fotografia) {
            $pedirCarmenFotoId = DB::table('pedir_presupuestos')->insertGetId([
                'empresa_id'                    => $fotografia->id,
                'user_id'                       => $carmen->id,
                'boda_id'                       => $bodaCarmen->id,
                'tipo_producto_id'              => $tipoCobFoto?->id,
                'producto_id'                   => $productoFoto?->id,
                'reserva_id'                    => null,
                'nombre'                        => 'Carmen LLorca',
                'telefono'                      => '622074029',
                'email'                         => 'carmen@example.com',
                'mensaje'                       => 'Boda el 10 de abril 2025 en Águilas, Murcia. Ceremonia en la playa para 85 invitados.',
                'invitados'                     => 85,
                'presupuesto'                   => 3500,
                'fecha'                         => '2025-04-10',
                'estado'                        => 'aceptado_usuario',
                'importe_ofertado'              => 3100.00,
                'comentario_empresa'            => 'Cobertura completa 10 horas. Álbum digital, álbum físico premium y galería online privada.',
                'modalidad'                     => 'servicio',
                'fecha_inicio'                  => '2025-04-10 11:00:00',
                'fecha_fin'                     => '2025-04-10 21:00:00',
                'fecha_respuesta'               => Carbon::create(2024, 12, 15),
                'producto_personalizado_nombre' => null,
                'es_producto_personalizado'     => false,
                'created_at'                    => Carbon::create(2024, 12, 5),
                'updated_at'                    => Carbon::create(2024, 12, 15),
            ]);

            $reservaCarmenFotoId = DB::table('reservas')->insertGetId([
                'user_id'              => $carmen->id,
                'empresa_id'           => $fotografia->id,
                'producto_id'          => $productoFoto?->id,
                'boda_id'              => $bodaCarmen->id,
                'pedir_presupuesto_id' => $pedirCarmenFotoId,
                'fecha_inicio'         => '2025-04-10 11:00:00',
                'fecha_fin'            => '2025-04-10 21:00:00',
                'tipo_reserva'         => 'servicio',
                'estado'               => 'confirmada',
                'origen'               => 'usuario',
                'all_day'              => false,
                'notas'                => 'Cobertura fotográfica completa boda Carmen & Rafael.',
                'created_at'           => Carbon::create(2024, 12, 15),
                'updated_at'           => Carbon::create(2024, 12, 15),
            ]);

            DB::table('pedir_presupuestos')
                ->where('id', $pedirCarmenFotoId)
                ->update(['reserva_id' => $reservaCarmenFotoId]);
        }

        if ($bodaCarmen && $catering) {
            $pedirCarmenCateringId = DB::table('pedir_presupuestos')->insertGetId([
                'empresa_id'                    => $catering->id,
                'user_id'                       => $carmen->id,
                'boda_id'                       => $bodaCarmen->id,
                'tipo_producto_id'              => $tipoBanquete?->id,
                'producto_id'                   => $productoCatering?->id,
                'reserva_id'                    => null,
                'nombre'                        => 'Carmen LLorca',
                'telefono'                      => '622074029',
                'email'                         => 'carmen@example.com',
                'mensaje'                       => 'Boda en Águilas el 10 de abril. Necesitamos catering para 85 personas con menú especial y cocktail en terraza.',
                'invitados'                     => 85,
                'presupuesto'                   => 7500,
                'fecha'                         => '2025-04-10',
                'estado'                        => 'aceptado_usuario',
                'importe_ofertado'              => 6800.00,
                'comentario_empresa'            => 'Menú 4 platos + postre para 85 personas. Cocktail de bienvenida en terraza con vistas al mar y barra libre.',
                'modalidad'                     => 'servicio',
                'fecha_inicio'                  => '2025-04-10 14:00:00',
                'fecha_fin'                     => '2025-04-10 23:30:00',
                'fecha_respuesta'               => Carbon::create(2024, 12, 20),
                'producto_personalizado_nombre' => null,
                'es_producto_personalizado'     => false,
                'created_at'                    => Carbon::create(2024, 12, 10),
                'updated_at'                    => Carbon::create(2024, 12, 20),
            ]);

            $reservaCarmenCateringId = DB::table('reservas')->insertGetId([
                'user_id'              => $carmen->id,
                'empresa_id'           => $catering->id,
                'producto_id'          => $productoCatering?->id,
                'boda_id'              => $bodaCarmen->id,
                'pedir_presupuesto_id' => $pedirCarmenCateringId,
                'fecha_inicio'         => '2025-04-10 14:00:00',
                'fecha_fin'            => '2025-04-10 23:30:00',
                'tipo_reserva'         => 'servicio',
                'estado'               => 'confirmada',
                'origen'               => 'usuario',
                'all_day'              => false,
                'notas'                => 'Catering completo boda Carmen & Rafael — cocktail + banquete 85 pax.',
                'created_at'           => Carbon::create(2024, 12, 20),
                'updated_at'           => Carbon::create(2024, 12, 20),
            ]);

            DB::table('pedir_presupuestos')
                ->where('id', $pedirCarmenCateringId)
                ->update(['reserva_id' => $reservaCarmenCateringId]);
        }

        $this->command->info('PedirPresupuestoSeeder: solicitudes de presupuesto creadas.');
    }
}
