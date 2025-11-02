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
        $categorias = [
            'Fotografía y video',
            'Catering y banquete',
            'Pastelería y postres',
            'Música y entretenimiento',
            'Decoración y flores',
            'Moda nupcial',
            'Belleza y cuidado personal',
            'Invitaciones y papelería',
            'Souvenirs y detalles',
            'Joyería y accesorios',
            'Organización y coordinación',
            'Transporte y movilidad',
            'Lugares y espacios para eventos',
            'Viajes y luna de miel',
            'Bebidas y coctelería',
            'Mobiliario y ambientación',
            'Ceremonias y protocolos',
            'Tecnología y efectos especiales',
            'Seguridad y logística',
        ];

        foreach ($categorias as $nombre) {
            Categoria::create([
                'nombre' => $nombre,
                'slug' => Str::slug($nombre),
            ]);
        }
    }
}
