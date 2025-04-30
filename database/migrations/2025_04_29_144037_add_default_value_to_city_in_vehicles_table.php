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
            // Modifier la colonne city pour avoir une valeur par défaut
            if (Schema::hasColumn('vehicles', 'city')) {
                $table->string('city')->default('Abidjan')->change();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('vehicles', function (Blueprint $table) {
            // Remettre la colonne city sans valeur par défaut
            if (Schema::hasColumn('vehicles', 'city')) {
                $table->string('city')->nullable()->change();
            }
        });
    }
};
