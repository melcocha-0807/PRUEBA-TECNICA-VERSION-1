<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class RolesAndUsersSeeder extends Seeder
{
    public function run()
    {
        // Crear roles
        $vendedor = Role::firstOrCreate(['name' => 'vendedor']);
        $auxiliar = Role::firstOrCreate(['name' => 'auxiliar de bodega']);

        // Crear usuario vendedor
        $user1 = User::firstOrCreate(
            ['email' => 'vendedor@demo.com'],
            [
                'name' => 'Vendedor Demo',
                'password' => Hash::make('password'),
            ]
        );
        $user1->assignRole($vendedor);

        // Crear usuario auxiliar de bodega
        $user2 = User::firstOrCreate(
            ['email' => 'auxiliar@demo.com'],
            [
                'name' => 'Auxiliar Demo',
                'password' => Hash::make('password'),
            ]
        );
        $user2->assignRole($auxiliar);
    }
}
