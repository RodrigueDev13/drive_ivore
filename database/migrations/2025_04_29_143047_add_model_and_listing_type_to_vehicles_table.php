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
            // Modifier la colonne model pour avoir une valeur par défaut
            if (Schema::hasColumn('vehicles', 'model')) {
                $table->string('model')->default('')->change();
            }
            
            // Ajouter la colonne listing_type
            if (!Schema::hasColumn('vehicles', 'listing_type')) {
                $table->enum('listing_type', ['sale', 'rent', 'both'])->default('sale')->after('is_featured');
            }
            
            // Ajouter la colonne rental_price pour les véhicules à louer
            if (!Schema::hasColumn('vehicles', 'rental_price')) {
                $table->decimal('rental_price', 12, 2)->nullable()->after('price');
            }
            
            // Ajouter la colonne rental_period pour spécifier la période de location (jour, semaine, mois)
            if (!Schema::hasColumn('vehicles', 'rental_period')) {
                $table->enum('rental_period', ['day', 'week', 'month'])->nullable()->after('rental_price');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('vehicles', function (Blueprint $table) {
            // Supprimer les colonnes ajoutées
            if (Schema::hasColumn('vehicles', 'rental_period')) {
                $table->dropColumn('rental_period');
            }
            
            if (Schema::hasColumn('vehicles', 'rental_price')) {
                $table->dropColumn('rental_price');
            }
            
            if (Schema::hasColumn('vehicles', 'listing_type')) {
                $table->dropColumn('listing_type');
            }
            
            // Remettre la colonne model sans valeur par défaut
            if (Schema::hasColumn('vehicles', 'model')) {
                $table->string('model')->nullable()->change();
            }
        });
    }
};
