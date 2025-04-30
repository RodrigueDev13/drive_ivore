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
        Schema::table('messages', function (Blueprint $table) {
            // Vérifier si la colonne 'content' n'existe pas déjà
            if (!Schema::hasColumn('messages', 'content')) {
                // Vérifier si la colonne 'body' existe
                if (Schema::hasColumn('messages', 'body')) {
                    // Renommer la colonne 'body' en 'content'
                    $table->renameColumn('body', 'content');
                } else {
                    // Ajouter la colonne 'content' si 'body' n'existe pas
                    $table->text('content')->nullable()->after('vehicle_id');
                }
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('messages', function (Blueprint $table) {
            if (Schema::hasColumn('messages', 'content')) {
                // Si on a renommé 'body' en 'content', on le renomme à nouveau en 'body'
                if (!Schema::hasColumn('messages', 'body')) {
                    $table->renameColumn('content', 'body');
                } else {
                    // Sinon, on supprime simplement la colonne 'content'
                    $table->dropColumn('content');
                }
            }
        });
    }
};
