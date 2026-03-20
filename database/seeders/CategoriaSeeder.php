<?php

namespace Database\Seeders;

use App\Models\Categoria;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;


class CategoriaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $baseUrl = "http://weddingplaner.local/storage/imagenes/iconos/";
        $baseUrl_local = "http://127.0.0.1:8000/storage/imagenes/iconos/";

        $categorias = [
            ['nombre' => 'Belleza y cuidado personal', 'icono' => $baseUrl . 'imagen_2.png'],
            ['nombre' => 'Bebidas y coctelería', 'icono' => $baseUrl . 'imagen_1.png'],
            ['nombre' => 'Catering y banquete', 'icono' => $baseUrl . 'imagen_3.png'],
            ['nombre' => 'Ceremonias y protocolos', 'icono' => $baseUrl . 'imagen_4.png'],
            ['nombre' => 'Decoración y flores', 'icono' => $baseUrl . 'imagen_5.png'],
            ['nombre' => 'Fotografía y video', 'icono' => $baseUrl . 'imagen_6.png'],
            ['nombre' => 'Invitaciones y papelería', 'icono' => $baseUrl . 'imagen_7.png'],
            ['nombre' => 'Joyería y accesorios', 'icono' => $baseUrl . 'imagen_8.png'],
            ['nombre' => 'Lugares y espacios ', 'icono' => $baseUrl . 'imagen_9.png'],
            ['nombre' => 'Mobiliario y ambientación', 'icono' => $baseUrl . 'imagen_10.png'],
            ['nombre' => 'Moda nupcial', 'icono' => $baseUrl . 'imagen_11.png'],
            ['nombre' => 'Música y entretenimiento', 'icono' => $baseUrl . 'imagen_12.png'],
            ['nombre' => 'Organización y coordinación', 'icono' => $baseUrl . 'imagen_13.png'],
            ['nombre' => 'Pastelería y postres', 'icono' => $baseUrl . 'imagen_14.png'],
            ['nombre' => 'Seguridad y logística', 'icono' => $baseUrl . 'imagen_15.png'],
            ['nombre' => 'Souvenirs y detalles', 'icono' => $baseUrl . 'imagen_16.png'],
            ['nombre' => 'Tecnología y efectos especiales', 'icono' => $baseUrl . 'imagen_17.png'],
            ['nombre' => 'Transporte y movilidad', 'icono' => $baseUrl . 'imagen_18.png'],
            ['nombre' => 'Viaje de novios', 'icono' => $baseUrl . 'imagen_19.png'],
        ];


        foreach ($categorias as $categoria) {
            Categoria::create([
                'nombre' => $categoria['nombre'],
                'slug' => Str::slug($categoria['nombre']),
                'icono' => $categoria['icono']
            ]);
        }
    }
}
