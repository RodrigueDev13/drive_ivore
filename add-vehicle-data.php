<?php

// Script pour ajouter des types et marques de véhicules dans la base de données

// Charger l'environnement Laravel
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Brand;
use App\Models\VehicleType;
use Illuminate\Support\Str;

// Liste des types de véhicules à ajouter
$vehicleTypes = [
    ['name' => 'Berline', 'description' => 'Voiture à coffre fermé avec 4 portes', 'icon' => 'icons/berline.svg'],
    ['name' => 'SUV', 'description' => 'Véhicule utilitaire sport', 'icon' => 'icons/suv.svg'],
    ['name' => 'Coupé', 'description' => 'Voiture à 2 portes et au toit bas', 'icon' => 'icons/coupe.svg'],
    ['name' => 'Cabriolet', 'description' => 'Voiture décapotable', 'icon' => 'icons/cabriolet.svg'],
    ['name' => 'Break', 'description' => 'Voiture familiale avec un grand coffre', 'icon' => 'icons/break.svg'],
    ['name' => 'Monospace', 'description' => 'Véhicule familial avec un espace intérieur modulable', 'icon' => 'icons/monospace.svg'],
    ['name' => 'Citadine', 'description' => 'Petite voiture adaptée à la ville', 'icon' => 'icons/citadine.svg'],
    ['name' => 'Crossover', 'description' => 'Croisement entre une berline et un SUV', 'icon' => 'icons/crossover.svg'],
    ['name' => 'Pick-up', 'description' => 'Véhicule avec une benne à l\'arrière', 'icon' => 'icons/pickup.svg'],
    ['name' => '4x4', 'description' => 'Véhicule tout-terrain', 'icon' => 'icons/4x4.svg'],
    ['name' => 'Utilitaire', 'description' => 'Véhicule destiné au transport de marchandises', 'icon' => 'icons/utilitaire.svg'],
    ['name' => 'Minibus', 'description' => 'Petit bus pour le transport de personnes', 'icon' => 'icons/minibus.svg'],
    ['name' => 'Limousine', 'description' => 'Voiture de luxe allongée', 'icon' => 'icons/limousine.svg'],
    ['name' => 'Roadster', 'description' => 'Voiture de sport décapotable', 'icon' => 'icons/roadster.svg'],
    ['name' => 'Supercar', 'description' => 'Voiture de sport haute performance', 'icon' => 'icons/supercar.svg'],
    ['name' => 'Compact', 'description' => 'Voiture compacte de taille moyenne', 'icon' => 'icons/compact.svg'],
    ['name' => 'Micro-citadine', 'description' => 'Très petite voiture pour la ville', 'icon' => 'icons/micro.svg'],
    ['name' => 'Grand SUV', 'description' => 'SUV de grande taille', 'icon' => 'icons/grand-suv.svg'],
    ['name' => 'SUV Compact', 'description' => 'SUV de petite taille', 'icon' => 'icons/suv-compact.svg'],
    ['name' => 'SUV Coupé', 'description' => 'SUV au design coupé', 'icon' => 'icons/suv-coupe.svg'],
    ['name' => 'Berline de luxe', 'description' => 'Berline haut de gamme', 'icon' => 'icons/berline-luxe.svg'],
    ['name' => 'Sportive', 'description' => 'Voiture à hautes performances', 'icon' => 'icons/sportive.svg'],
    ['name' => 'Tout-terrain', 'description' => 'Véhicule adapté aux terrains difficiles', 'icon' => 'icons/tout-terrain.svg'],
    ['name' => 'Van', 'description' => 'Véhicule spacieux pour le transport de personnes', 'icon' => 'icons/van.svg'],
    ['name' => 'Camionnette', 'description' => 'Petit utilitaire', 'icon' => 'icons/camionnette.svg'],
    ['name' => 'Fourgon', 'description' => 'Utilitaire de taille moyenne', 'icon' => 'icons/fourgon.svg'],
    ['name' => 'Camping-car', 'description' => 'Véhicule aménagé pour voyager', 'icon' => 'icons/camping-car.svg'],
    ['name' => 'Hybride', 'description' => 'Véhicule à motorisation hybride', 'icon' => 'icons/hybride.svg'],
    ['name' => 'Électrique', 'description' => 'Véhicule à motorisation électrique', 'icon' => 'icons/electrique.svg'],
    ['name' => 'Classique', 'description' => 'Véhicule de collection', 'icon' => 'icons/classique.svg'],
];

// Liste des marques de véhicules à ajouter
$brands = [
    ['name' => 'Toyota', 'description' => 'Constructeur automobile japonais', 'logo' => 'logos/toyota.svg'],
    ['name' => 'Volkswagen', 'description' => 'Constructeur automobile allemand', 'logo' => 'logos/volkswagen.svg'],
    ['name' => 'Ford', 'description' => 'Constructeur automobile américain', 'logo' => 'logos/ford.svg'],
    ['name' => 'Honda', 'description' => 'Constructeur automobile japonais', 'logo' => 'logos/honda.svg'],
    ['name' => 'Hyundai', 'description' => 'Constructeur automobile sud-coréen', 'logo' => 'logos/hyundai.svg'],
    ['name' => 'Nissan', 'description' => 'Constructeur automobile japonais', 'logo' => 'logos/nissan.svg'],
    ['name' => 'Chevrolet', 'description' => 'Constructeur automobile américain', 'logo' => 'logos/chevrolet.svg'],
    ['name' => 'Kia', 'description' => 'Constructeur automobile sud-coréen', 'logo' => 'logos/kia.svg'],
    ['name' => 'Mercedes-Benz', 'description' => 'Constructeur automobile allemand de luxe', 'logo' => 'logos/mercedes.svg'],
    ['name' => 'BMW', 'description' => 'Constructeur automobile allemand de luxe', 'logo' => 'logos/bmw.svg'],
    ['name' => 'Audi', 'description' => 'Constructeur automobile allemand de luxe', 'logo' => 'logos/audi.svg'],
    ['name' => 'Renault', 'description' => 'Constructeur automobile français', 'logo' => 'logos/renault.svg'],
    ['name' => 'Peugeot', 'description' => 'Constructeur automobile français', 'logo' => 'logos/peugeot.svg'],
    ['name' => 'Citroën', 'description' => 'Constructeur automobile français', 'logo' => 'logos/citroen.svg'],
    ['name' => 'Fiat', 'description' => 'Constructeur automobile italien', 'logo' => 'logos/fiat.svg'],
    ['name' => 'Jeep', 'description' => 'Constructeur américain de SUV et tout-terrain', 'logo' => 'logos/jeep.svg'],
    ['name' => 'Mazda', 'description' => 'Constructeur automobile japonais', 'logo' => 'logos/mazda.svg'],
    ['name' => 'Subaru', 'description' => 'Constructeur automobile japonais', 'logo' => 'logos/subaru.svg'],
    ['name' => 'Volvo', 'description' => 'Constructeur automobile suédois', 'logo' => 'logos/volvo.svg'],
    ['name' => 'Land Rover', 'description' => 'Constructeur britannique de SUV et tout-terrain', 'logo' => 'logos/land-rover.svg'],
    ['name' => 'Porsche', 'description' => 'Constructeur automobile allemand de voitures de sport', 'logo' => 'logos/porsche.svg'],
    ['name' => 'Ferrari', 'description' => 'Constructeur italien de voitures de sport', 'logo' => 'logos/ferrari.svg'],
    ['name' => 'Lamborghini', 'description' => 'Constructeur italien de voitures de sport', 'logo' => 'logos/lamborghini.svg'],
    ['name' => 'Bugatti', 'description' => 'Constructeur français de voitures de luxe', 'logo' => 'logos/bugatti.svg'],
    ['name' => 'Bentley', 'description' => 'Constructeur britannique de voitures de luxe', 'logo' => 'logos/bentley.svg'],
    ['name' => 'Rolls-Royce', 'description' => 'Constructeur britannique de voitures de luxe', 'logo' => 'logos/rolls-royce.svg'],
    ['name' => 'Maserati', 'description' => 'Constructeur italien de voitures de luxe', 'logo' => 'logos/maserati.svg'],
    ['name' => 'Tesla', 'description' => 'Constructeur américain de voitures électriques', 'logo' => 'logos/tesla.svg'],
    ['name' => 'Lexus', 'description' => 'Marque de luxe de Toyota', 'logo' => 'logos/lexus.svg'],
    ['name' => 'Jaguar', 'description' => 'Constructeur britannique de voitures de luxe', 'logo' => 'logos/jaguar.svg'],
];

// Compteurs pour suivre les ajouts
$typesAdded = 0;
$typesSkipped = 0;
$brandsAdded = 0;
$brandsSkipped = 0;

// Ajouter les types de véhicules
echo "Ajout des types de véhicules...\n";
foreach ($vehicleTypes as $typeData) {
    // Vérifier si le type existe déjà
    $exists = VehicleType::where('name', $typeData['name'])->exists();
    
    if (!$exists) {
        // Créer le slug à partir du nom
        $typeData['slug'] = Str::slug($typeData['name']);
        
        // Créer le type
        VehicleType::create($typeData);
        echo "Type ajouté: {$typeData['name']}\n";
        $typesAdded++;
    } else {
        echo "Type ignoré (existe déjà): {$typeData['name']}\n";
        $typesSkipped++;
    }
}

// Ajouter les marques de véhicules
echo "\nAjout des marques de véhicules...\n";
foreach ($brands as $brandData) {
    // Vérifier si la marque existe déjà
    $exists = Brand::where('name', $brandData['name'])->exists();
    
    if (!$exists) {
        // Créer le slug à partir du nom
        $brandData['slug'] = Str::slug($brandData['name']);
        
        // Créer la marque
        Brand::create($brandData);
        echo "Marque ajoutée: {$brandData['name']}\n";
        $brandsAdded++;
    } else {
        echo "Marque ignorée (existe déjà): {$brandData['name']}\n";
        $brandsSkipped++;
    }
}

// Afficher le résumé
echo "\n=== RÉSUMÉ ===\n";
echo "Types de véhicules: {$typesAdded} ajoutés, {$typesSkipped} ignorés (déjà existants)\n";
echo "Marques de véhicules: {$brandsAdded} ajoutées, {$brandsSkipped} ignorées (déjà existantes)\n";
echo "Terminé!\n";
