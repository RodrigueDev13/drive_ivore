<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\VehicleType;
use Illuminate\Support\Facades\File;

class VehicleTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Assurez-vous que le dossier existe
        $directory = public_path('images/vehicle-types');
        if (!File::exists($directory)) {
            File::makeDirectory($directory, 0755, true);
        }

        $vehicleTypes = [
            [
                'name' => 'Pick-up',
                'icon' => 'images/vehicle-types/pickup.png'
            ],
            [
                'name' => 'Fourgon',
                'icon' => 'images/vehicle-types/van.png'
            ],
            [
                'name' => 'SUV',
                'icon' => 'images/vehicle-types/suv.png'
            ],
            [
                'name' => 'Cabriolet',
                'icon' => 'images/vehicle-types/cabriolet.png'
            ],
            [
                'name' => 'Berline',
                'icon' => 'images/vehicle-types/sedan.png'
            ],
            [
                'name' => 'Citadine',
                'icon' => 'images/vehicle-types/city-car.png'
            ]
        ];

        foreach ($vehicleTypes as $type) {
            // Vérifier si le type existe déjà
            $existingType = VehicleType::where('name', $type['name'])->first();

            if (!$existingType) {
                VehicleType::create($type);
            }
        }

        $this->command->info('Types de véhicules créés avec succès!');
    }
}
