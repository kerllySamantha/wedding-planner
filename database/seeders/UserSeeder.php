<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $usuarios = [
            ['name' => 'Pedro Admin', 'email' => 'admin@example.com', 'password' => bcrypt('password'), 'role' => 'admin'],
            ['name' => 'María López', 'email' => 'maria@example.com', 'password' => bcrypt('password'), 'role' => 'usuario'],
            ['name' => 'Javier Martínez', 'email' => 'javier@example.com', 'password' => bcrypt('password'), 'role' => 'usuario'],
            ['name' => 'Lucía Fernández', 'email' => 'lucia@example.com', 'password' => bcrypt('password'), 'role' => 'empresa'],
            ['name' => 'Carlos García', 'email' => 'carlos@example.com', 'password' => bcrypt('password'), 'role' => 'empresa'],
            ['name' => 'Invitado Prueba', 'email' => 'invitado@example.com', 'password' => bcrypt('password'), 'role' => 'invitado'],
            [
                'name' => 'Jose Fernández',
                'email' => 'jose@example.com',
                'password' => bcrypt('password'),
                'role' => 'empresa',
            ],
            [
                'name' => 'Luis García',
                'email' => 'luis@example.com',
                'password' => bcrypt('password'),
                'role' => 'empresa',
            ],
            [
                'name' => 'Ana Martínez',
                'email' => 'ana@example.com',
                'password' => bcrypt('password'),
                'role' => 'empresa',
            ],
            [
                'name' => 'Nuria López',
                'email' => 'nuria@example.com',
                'password' => bcrypt('password'),
                'role' => 'empresa',
            ],
            [
                'name' => 'Ester Sánchez',
                'email' => 'ester@example.com',
                'password' => bcrypt('password'),
                'role' => 'empresa',
            ],
            [
                'name' => 'Angela Ruiz',
                'email' => 'angela@example.com',
                'password' => bcrypt('password'),
                'role' => 'empresa',
            ],
        ];

        foreach ($usuarios as $data) {
            $user = User::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => $data['password'],
            ]);

            $user->assignRole($data['role']);
        }
    }
}
