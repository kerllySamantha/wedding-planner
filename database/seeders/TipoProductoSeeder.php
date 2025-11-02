<?php

namespace Database\Seeders;

use App\Models\Categoria;
use App\Models\TipoProducto;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class TipoProductoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tipos = [
            1 => [
                'Fotografía tradicional',
                'Fotografía con drones',
                'Video cinematográfico',
                'Fotomatón',
                'Cobertura completa de boda',
            ],
            2 => [
                'Banquete completo',
                'Catering informal',
                'Buffet libre',
                'Servicio de meseros',
            ],
            3 => [
                'Pasteles de boda',
                'Cupcakes personalizados',
                'Mesa de postres',
            ],
            4 => [
                'DJ profesional',
                'Banda en vivo',
                'Grupo musical',
                'Animador o maestro de ceremonias',
                'Entretenimiento infantil',
            ],
            5 => [
                'Decoración floral',
                'Diseño de espacios',
                'Centros de mesa',
                'Arco de ceremonia',
            ],
            6 => [
                'Vestidos de novia',
                'Trajes de novio',
                'Zapatos de novia',
                'Accesorios y velos',
            ],
            7 => [
                'Maquillaje profesional',
                'Peluquería y peinado',
                'Tratamientos faciales',
                'Spa y bienestar',
            ],
            8 => [
                'Invitaciones físicas',
                'Invitaciones digitales',
                'Papelería personalizada',
            ],
            9 => [
                'Recuerdos personalizados',
                'Regalos para invitados',
                'Detalles eco-friendly',
            ],
            10 => [
                'Anillos de boda',
                'Collares y pulseras',
                'Joyería artesanal',
            ],
            11 => [
                'Wedding planner',
                'Coordinador de evento',
                'Asesoría integral de boda',
            ],
           12 => [
                'Autos clásicos',
                'Limosinas',
                'Transporte de invitados',
            ],
            13 => [
                'Salón de eventos',
                'Jardín o hacienda',
                'Playa o destino turístico',
                'Iglesia o capilla',
            ],
           14 => [
                'Agencia de viajes',
                'Bodas destino',
                'Paquetes todo incluido',
            ],
            15 => [
                'Barra libre',
                'Coctelería profesional',
                'Catas de vino o licores',
            ],
            16 => [
                'Renta de mobiliario',
                'Iluminación y sonido',
                'Carpas y toldos',
            ],
            // 'Ceremonias y protocolos' => [
            //     'Ceremonias simbólicas',
            //     'Oficiante o maestro de ceremonias',
            //     'Protocolo y etiqueta',
            // ],
            // 'Tecnología y efectos especiales' => [
            //     'Pantallas LED',
            //     'Fotografía 360°',
            //     'Efectos de humo o luces',
            // ],
        ];

        foreach ($tipos as $id => $tipo) {
            $categoria = Categoria::where('id', $id)->first();

            if ($categoria) {
                foreach ($tipo as $nombreTipo) {
                    TipoProducto::create([
                        'nombre' => $nombreTipo,
                        'categoria_id' => $categoria->id,
                    ]);
                }
            }
        }
    }
}
