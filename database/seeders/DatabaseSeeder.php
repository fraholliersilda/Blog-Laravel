<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Role::updateOrCreate(
            ['name' => 'admin'],
            ['name' => 'admin']
        );

        Role::updateOrCreate(
            ['name' => 'user'],
            ['name' => 'user']
        );
    }
}
