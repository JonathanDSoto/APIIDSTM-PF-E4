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
        User::create([
            'name' => 'Emiliano ',
            'lastname' => 'Fernandez',
            'email' => 'emilianofh02@gmail.com',
            'password' => 'ejemploChido123',
            'image_name' => '',
            'role_id' => 1
        ]);

        User::create([
            'name' => 'Fabian',
            'lastname' => ':)',
            'email' => 'fabian@gmail.com',
            'password' => 'ejemploChido123',
            'image_name' => '',
            'role_id' => 2
        ]);
    }
}
