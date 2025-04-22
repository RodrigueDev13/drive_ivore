<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Brand;
use Illuminate\Support\Facades\File;

class BrandSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Assurez-vous que le dossier existe
        $directory = public_path('images/brands');
        if (!File::exists($directory)) {
            File::makeDirectory($directory, 0755, true);
        }

        $brands = [
            [
                'name' => 'Mercedes',
                'icon' => 'images/brands/mercedes.png'
            ],
            [
                'name' => 'Peugeot',
                'icon' => 'images/brands/peugeot.png'
            ],
            [
                'name' => 'Toyota',
                'icon' => 'images/brands/toyota.png'
            ],
            [
                'name' => 'BMW',
                'icon' => 'images/brands/bmw.png'
            ],
            [
                'name' => 'Renault',
                'icon' => 'images/brands/renault.png'
            ],
            [
                'name' => 'Audi',
                'icon' => 'images/brands/audi.png'
            ],
            [
                'name' => 'Hyundai',
                'icon' => 'images/brands/hyundai.png'
            ],
            [
                'name' => 'Ford',
                'icon' => 'images/brands/ford.png'
            ]
        ];

        foreach ($brands as $brand) {
            // Vérifier si la marque existe déjà
            $existingBrand = Brand::where('name', $brand['name'])->first();

            if (!$existingBrand) {
                Brand::create($brand);
            }
        }

        $this->command->info('Marques de véhicules créées avec succès!');
    }
}
