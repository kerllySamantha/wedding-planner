<?php

namespace Database\Seeders;

use App\Models\Producto;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Producto::factory()->count(10)->create();

        $productos = [
            [
                'empresa_id' => 7,
                'tipo_producto_id' => 57,
                'nombre' => 'Carpa Elegante',
                'descripcion' => 'Carpa de lujo para bodas al aire libre, con decoración personalizada.',
                'precio_min' => 10000,
                'precio_max' => 40000,
            ],
            [
                'empresa_id' => 7,
                'tipo_producto_id' => 57,
                'nombre' => 'Carpa Premium',
                'descripcion' => 'Carpa premium con iluminación y mobiliario incluido.',
                'precio_min' => 15000,
                'precio_max' => 55000,
            ],
            [
                'empresa_id' => 1,
                'tipo_producto_id' => 8,
                'nombre' => 'Finger Foods / Bocadillos',
                'descripcion' => 'Mini sándwiches o sliders (de carne, pollo, vegetales, etc.)',
                'precio_min' => 1500,
                'precio_max' => 2500,
            ],
            [
                'empresa_id' => 1,
                'tipo_producto_id' => 8,
                'nombre' => 'Snacks temáticos',
                'descripcion' => 'Chips gourmet, frutos secos, palomitas de sabores, Mini pizzas o empanadas',
                'precio_min' => 1500,
                'precio_max' => 2500,
            ]
        ];

        foreach ($productos as $producto) {
            Producto::create($producto);
        }
    
      
    }
}
