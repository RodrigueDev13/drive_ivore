<?php

// Script pour définir un utilisateur comme administrateur

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

// Demander l'email de l'utilisateur à définir comme administrateur
echo "Entrez l'email de l'utilisateur à définir comme administrateur: ";
$email = trim(fgets(STDIN));

// Rechercher l'utilisateur
$user = \App\Models\User::where('email', $email)->first();

if (!$user) {
    echo "Aucun utilisateur trouvé avec cet email.\n";
    exit(1);
}

// Définir l'utilisateur comme administrateur
$user->is_admin = true;
$user->save();

echo "L'utilisateur {$user->name} ({$user->email}) est maintenant administrateur.\n";
