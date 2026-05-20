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
            6 => ['Fotografía tradicional', 'Fotografía con drones', 'Video cinematográfico', 'Fotomatón', 'Cobertura completa de boda'],
            3 => ['Banquete completo', 'Catering informal', 'Buffet libre', 'Servicio de meseros'],
            14 => ['Pasteles de boda', 'Cupcakes personalizados', 'Mesa de postres'],
            12 => ['DJ profesional', 'Banda en vivo', 'Grupo musical', 'Animador o maestro de ceremonias', 'Entretenimiento infantil'],
            5 => ['Decoración floral', 'Diseño de espacios', 'Centros de mesa', 'Arco de ceremonia'],
            11 => ['Vestidos de novia', 'Trajes de novio', 'Zapatos de novia', 'Accesorios y velos'],
            1 => ['Maquillaje profesional', 'Peluquería y peinado', 'Tratamientos faciales', 'Spa y bienestar'],
            7 => ['Invitaciones físicas', 'Invitaciones digitales', 'Papelería personalizada'],
            16 => ['Recuerdos personalizados', 'Regalos para invitados', 'Detalles eco-friendly'],
            8 => ['Anillos de boda', 'Collares y pulseras', 'Joyería artesanal'],
            13 => ['Wedding planner', 'Coordinador de evento', 'Asesoría integral de boda'],
            18 => ['Autos clásicos', 'Limosinas', 'Transporte de invitados'],
            9 => ['Salón de eventos', 'Jardín o hacienda', 'Playa o destino turístico', 'Iglesia o capilla'],
            19 => ['Agencia de viajes', 'Bodas destino', 'Paquetes todo incluido'],
            2 => ['Barra libre', 'Coctelería profesional', 'Catas de vino o licores'],
            10 => ['Renta de mobiliario', 'Iluminación y sonido', 'Carpas y toldos'],
        ];

        // Clasificamos qué IDs de categorías se consideran servicios
        // (Fotografía, Catering, Música, Belleza, Wedding Planner, Transporte, Lugares, Bebidas)
        $esServicio = [6, 3, 12, 1, 13, 18, 9, 2, 19];

        foreach ($tipos as $idCategoria => $nombres) {
            $modalidad = in_array($idCategoria, $esServicio) ? 'servicio' : 'producto';

            foreach ($nombres as $nombre) {
                TipoProducto::create([
                    'categoria_id' => $idCategoria,
                    'nombre'       => $nombre,
                    'modalidad'         => $modalidad, // O 'modalidad', según el nombre que elijas
                ]);
            }
        }
    }
}
