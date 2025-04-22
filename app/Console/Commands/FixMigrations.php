<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\File;

class FixMigrations extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'migrations:fix';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Identifie et corrige les migrations problématiques';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Recherche des migrations problématiques...');

        // Récupérer toutes les migrations exécutées
        $executedMigrations = DB::table('migrations')->pluck('migration')->toArray();

        // Récupérer tous les fichiers de migration
        $migrationFiles = File::glob(database_path('migrations/*.php'));

        $batch = DB::table('migrations')->max('batch');
        $problemFound = false;

        foreach ($migrationFiles as $file) {
            $filename = pathinfo($file, PATHINFO_FILENAME);

            // Si la migration n'a pas été exécutée
            if (!in_array($filename, $executedMigrations)) {
                // Analyser le contenu du fichier pour voir s'il crée une table
                $content = file_get_contents($file);

                if (preg_match('/Schema::create\([\'"]([^\'"]+)[\'"]/', $content, $matches)) {
                    $tableName = $matches[1];

                    // Vérifier si la table existe déjà
                    if (Schema::hasTable($tableName)) {
                        $this->warn("La migration {$filename} tente de créer la table {$tableName} qui existe déjà.");

                        if ($this->confirm("Voulez-vous marquer cette migration comme exécutée?", true)) {
                            DB::table('migrations')->insert([
                                'migration' => $filename,
                                'batch' => $batch,
                            ]);

                            $this->info("Migration {$filename} marquée comme exécutée.");
                            $problemFound = true;
                        }
                    }
                }
            }
        }

        if (!$problemFound) {
            $this->info('Aucune migration problématique trouvée.');
        } else {
            $this->info('Toutes les migrations problématiques ont été traitées.');
        }

        return Command::SUCCESS;
    }
}
