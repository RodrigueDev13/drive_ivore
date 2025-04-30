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
            // Vérifier si la colonne listing_type existe déjà
            if (!Schema::hasColumn('vehicles', 'listing_type')) {
                // Ajouter la colonne listing_type avec les valeurs possibles : 'vente', 'location', 'vente_location'
                $table->enum('listing_type', ['vente', 'location', 'vente_location'])->default('vente')->after('price');
            }
            
            // Ajouter la colonne rental_price si elle n'existe pas déjà
            if (!Schema::hasColumn('vehicles', 'rental_price')) {
                $table->decimal('rental_price', 12, 2)->nullable()->after('price');
            }
            
            // Ajouter la colonne rental_period si elle n'existe pas déjà
            if (!Schema::hasColumn('vehicles', 'rental_period')) {
                $table->enum('rental_period', ['jour', 'semaine', 'mois'])->nullable()->after('rental_price');
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
            if (Schema::hasColumn('vehicles', 'listing_type')) {
                $table->dropColumn('listing_type');
            }
            
            if (Schema::hasColumn('vehicles', 'rental_price')) {
                $table->dropColumn('rental_price');
            }
            
            if (Schema::hasColumn('vehicles', 'rental_period')) {
                $table->dropColumn('rental_period');
            }
        });
    }
};
