<?php

namespace Database\Seeders;

use App\Models\Invitado;
use App\Models\Producto;
use App\Models\Servicio;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        $this->call([
            RoleSeeder::class,
            UserSeeder::class,
            // ServicioSeeder::class,
            CategoriaSeeder::class,
            PerfilUsuarioSeeder::class,
            ProvinciaSeeder::class,
            PoblacionSeeder::class,
            EmpresaSeeder::class,
            TipoProductoSeeder::class,
            ProductoSeeder::class,

            BodaSeeder::class,
            ReservaSeeder::class,
            PresupuestoSeeder::class,
            ReseniaSeeder::class,
            InvitadoSeeder::class,
            MensajeSeeder::class,



        ]);
    }
}
