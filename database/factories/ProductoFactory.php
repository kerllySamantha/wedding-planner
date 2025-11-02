<?php

namespace Database\Factories;

use App\Models\Empresa;
use App\Models\TipoProducto;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Producto>
 */
class ProductoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array

    {
        // $tipos = TipoProducto::all();

        // return [
        //     'empresa_id' => Empresa::query()->inRandomOrder()->value('id'),
        //     'tipo_producto_id' => $tipos->random()->id,
        //     'nombre' => $this->faker->company(),
        //     'descripcion' => $this->faker->text(100),
        //     'precio_min' => $this->faker->numberBetween(8000, 20000),
        //     'precio_max' => $this->faker->numberBetween(20001, 60000),



        // ];
        return [];

        
    }
}
