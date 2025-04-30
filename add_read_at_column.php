<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

try {
    // Vérifier si la colonne existe déjà
    if (!\Schema::hasColumn('messages', 'read_at')) {
        // Ajouter la colonne read_at
        \DB::statement('ALTER TABLE messages ADD COLUMN read_at TIMESTAMP NULL');
        echo "La colonne read_at a été ajoutée avec succès à la table messages.\n";
    } else {
        echo "La colonne read_at existe déjà dans la table messages.\n";
    }
} catch (\Exception $e) {
    echo "Erreur: " . $e->getMessage() . "\n";
}
