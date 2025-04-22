<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class InsertMigrationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Vérifier si la migration existe déjà
        $exists = DB::table('migrations')
            ->where('migration', '2025_04_12_155349_create_conversations_table')
            ->exists();

        if (!$exists) {
            DB::table('migrations')->insert([
                'migration' => '2025_04_12_155349_create_conversations_table',
                'batch' => DB::table('migrations')->max('batch'),
            ]);
        }
    }
}
