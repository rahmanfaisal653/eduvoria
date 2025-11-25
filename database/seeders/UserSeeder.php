<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\UserAdmin;
use Illuminate\Support\Facades\Hash;
use Faker\Factory as Faker;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create();

        // --- User Admin ---
        UserAdmin::create([
            'username' => 'aku',
            'email' => '123@gmail.com',
            'password' => Hash::make('password'),
            'status' => 'active',
        ]);

        UserAdmin::create([
            'username' => 'Budi',
            'email' => 'budi@gmail.com',
            'password' => Hash::make('password'),
            'status' => 'active',
        ]);

        UserAdmin::create([
            'username' => 'Citra',
            'email' => 'citra@gmail.com',
            'password' => Hash::make('password'),
            'status' => 'active',
        ]);
    }
}
