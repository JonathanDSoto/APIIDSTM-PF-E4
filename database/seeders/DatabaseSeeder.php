<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Initiative;
use App\Models\Place;
use Illuminate\Database\Seeder;
use PharIo\Manifest\License;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        $this->call([
            RoleSeeder::class,
            UserSeeder::class,
            PlaceSeeder::class,
            DepartamentSeeder::class,
            Initiative::class,
            License::class,
            Place::class,
            ReportSeeder::class,
            SubjectSeeder::class
        ]);
    }
}
