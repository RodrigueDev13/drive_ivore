<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('vehicles', function (Blueprint $table) {
            // Ajouter la colonne color si elle n'existe pas déjà
            if (!Schema::hasColumn('vehicles', 'color')) {
                $table->string('color')->nullable();
            }
            
            // Ajouter la colonne location si elle n'existe pas déjà
            if (!Schema::hasColumn('vehicles', 'location')) {
                $table->string('location')->nullable();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('vehicles', function (Blueprint $table) {
            // Supprimer les colonnes si elles existent
            if (Schema::hasColumn('vehicles', 'color')) {
                $table->dropColumn('color');
            }
            
            if (Schema::hasColumn('vehicles', 'location')) {
                $table->dropColumn('location');
            }
        });
    }
};
