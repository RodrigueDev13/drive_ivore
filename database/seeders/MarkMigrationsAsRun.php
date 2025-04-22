<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MarkMigrationsAsRun extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Liste des migrations à marquer comme exécutées
        $migrations = [
            '2025_04_12_155349_create_conversations_table',
            '2025_04_12_155349_create_favorites_table'
            // Ajoutez d'autres migrations problématiques ici si nécessaire
        ];

        $batch = DB::table('migrations')->max('batch');

        foreach ($migrations as $migration) {
            // Vérifier si la migration existe déjà
            $exists = DB::table('migrations')
                ->where('migration', $migration)
                ->exists();

            if (!$exists) {
                DB::table('migrations')->insert([
                    'migration' => $migration,
                    'batch' => $batch,
                ]);

                $this->command->info("Migration {$migration} marquée comme exécutée.");
            } else {
                $this->command->info("Migration {$migration} déjà marquée comme exécutée.");
            }
        }
    }
}
