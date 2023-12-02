<?php

namespace Database\Seeders;

use App\Models\Place;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PlaceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Place::create([
            'name' => 'AD-46',
            'code_name' => 'Academico departamento',
            'latitude' => 11,
            'altitude' => 13,
            'radius' => 5,
            'image_name' => ''
        ]);
    }
}
