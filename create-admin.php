<?php

// Script pour créer un utilisateur administrateur

// Charger l'environnement Laravel
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;

// Vérifier si la colonne is_admin existe dans la table users
if (!Schema::hasColumn('users', 'is_admin')) {
    // Ajouter la colonne is_admin à la table users
    Schema::table('users', function ($table) {
        $table->boolean('is_admin')->default(false);
    });
    echo "Colonne is_admin ajoutée à la table users.\n";
}

// Vérifier si l'utilisateur existe déjà
$user = User::where('email', 'admin@admin.com')->first();

if ($user) {
    // Mettre à jour l'utilisateur existant
    $user->is_admin = true;
    $user->save();
    echo "L'utilisateur admin@admin.com a été défini comme administrateur.\n";
} else {
    // Créer un nouvel utilisateur administrateur
    $user = new User();
    $user->name = 'Administrateur';
    $user->email = 'admin@admin.com';
    $user->password = Hash::make('password123');
    $user->is_admin = true;
    $user->save();
    echo "Un nouvel utilisateur administrateur a été créé avec l'email admin@admin.com et le mot de passe 'password123'.\n";
}

echo "Vous pouvez maintenant vous connecter avec l'email admin@admin.com et accéder au tableau de bord administrateur.\n";
