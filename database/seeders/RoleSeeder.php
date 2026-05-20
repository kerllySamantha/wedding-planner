<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        // Crear roles
        $roles = ['invitado', 'admin', 'usuario', 'empresa'];

        foreach ($roles as $role) {
            Role::firstOrCreate(['name' => $role]);
        }

        // Crear permisos
        $permisos = [
            'gestionar usuarios',
            'gestionar empresas',
            'gestionar reseñas',
            'gestionar categorias',
        ];

        foreach ($permisos as $permiso) {
            Permission::firstOrCreate(['name' => $permiso]);
        }

        // Asignar permisos al admin
        $admin = Role::findByName('admin');

        $admin->givePermissionTo($permisos);
    }
}