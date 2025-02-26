<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        User::create([
            'name' => 'Xhensila Malo',
            'email' => 'xhensilamalo@gmail.com',
            'password' => Hash::make('xhenixheni'),
            'role_id' => 2,
        ]);
    }
}
