<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            BrandSeeder::class,
            VehicleTypeSeeder::class,
            // Ajoutez d'autres seeders ici si nécessaire
        ]);
    }
}
