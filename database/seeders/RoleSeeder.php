<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = [
            ['name' => 'admin'],
            ['name' => 'business'],
            ['name' => 'customer'],
            ['name' => 'staff'],
        ];

        foreach ($roles as $role) {
            Role::firstOrCreate($role);
        }
    }
}

