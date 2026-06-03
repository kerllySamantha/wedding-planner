<?php

namespace Database\Seeders;

use App\Models\TareaPlantilla;
use Illuminate\Database\Seeder;

class TareaPlantillaSeeder extends Seeder
{
    public function run(): void
    {
        $tareas = [
            ['orden' => 1,  'titulo' => 'Fijar la fecha de la boda',         'descripcion' => 'Elegid la fecha definitiva y anotadla en todos vuestros calendarios.'],
            ['orden' => 2,  'titulo' => 'Establecer el presupuesto total',    'descripcion' => 'Definid un presupuesto global antes de contratar ningún servicio.'],
            ['orden' => 3,  'titulo' => 'Crear la lista de invitados',        'descripcion' => 'Haced una lista inicial de invitados para dimensionar el resto de decisiones.'],
            ['orden' => 4,  'titulo' => 'Reservar el lugar de la celebración','descripcion' => 'Visitad y reservad el espacio para la ceremonia y/o el banquete.'],
            ['orden' => 5,  'titulo' => 'Contratar catering o restaurante',   'descripcion' => 'Pedid presupuesto y acordad menú, bebidas y servicio.'],
            ['orden' => 6,  'titulo' => 'Contratar fotógrafo y videógrafo',   'descripcion' => 'Revisad portfolios y reservad con antelación, se agotan rápido.'],
            ['orden' => 7,  'titulo' => 'Elegir el vestido de novia',         'descripcion' => 'Visitad tiendas con tiempo suficiente para pruebas y ajustes.'],
            ['orden' => 8,  'titulo' => 'Elegir traje y complementos del novio', 'descripcion' => 'Compra o alquiler del traje y zapatos.'],
            ['orden' => 9,  'titulo' => 'Contratar música (DJ o banda)',      'descripcion' => 'Escuchad demos y acordad el repertorio para ceremonia y banquete.'],
            ['orden' => 10, 'titulo' => 'Diseñar y enviar invitaciones',      'descripcion' => 'Enviadlas con al menos 2 meses de antelación.'],
            ['orden' => 11, 'titulo' => 'Elegir el pastel de boda',           'descripcion' => 'Degustación y diseño del pastel nupcial.'],
            ['orden' => 12, 'titulo' => 'Preparar decoración floral',         'descripcion' => 'Ramo de novia, centros de mesa y decoración del espacio.'],
            ['orden' => 13, 'titulo' => 'Elegir anillos de boda',             'descripcion' => 'Buscad y encargad las alianzas con margen para grabaciones.'],
            ['orden' => 14, 'titulo' => 'Confirmar asistencia de invitados',  'descripcion' => 'Recoged confirmaciones y actualizad la lista definitiva.'],
            ['orden' => 15, 'titulo' => 'Organizar transporte y alojamiento', 'descripcion' => 'Coordinar traslados y habitaciones para invitados de fuera.'],
            ['orden' => 16, 'titulo' => 'Planificar la luna de miel',         'descripcion' => 'Reservad destino, vuelos y alojamiento.'],
            ['orden' => 17, 'titulo' => 'Ensayo de la ceremonia',             'descripcion' => 'Realizad un ensayo con el officiant y los testigos.'],
            ['orden' => 18, 'titulo' => 'Preparar detalles para invitados',   'descripcion' => 'Recordatorios, favores y detalles de mesa.'],
        ];

        foreach ($tareas as $t) {
            TareaPlantilla::firstOrCreate(['titulo' => $t['titulo']], $t);
        }
    }
}
