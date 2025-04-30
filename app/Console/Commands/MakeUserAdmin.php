<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;

class MakeUserAdmin extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'user:make-admin {email : L\'email de l\'utilisateur à définir comme administrateur}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Définir un utilisateur comme administrateur';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $email = $this->argument('email');
        
        // Rechercher l'utilisateur
        $user = User::where('email', $email)->first();
        
        if (!$user) {
            $this->error("Aucun utilisateur trouvé avec l'email: {$email}");
            return 1;
        }
        
        // Définir l'utilisateur comme administrateur
        $user->is_admin = true;
        $user->save();
        
        $this->info("L'utilisateur {$user->name} ({$user->email}) est maintenant administrateur.");
        
        return 0;
    }
}
