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
        // Vérifier et mettre à jour la table favorites
        if (Schema::hasTable('favorites')) {
            Schema::table('favorites', function (Blueprint $table) {
                if (!Schema::hasColumn('favorites', 'user_id')) {
                    $table->unsignedBigInteger('user_id');
                    $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
                }

                if (!Schema::hasColumn('favorites', 'vehicle_id')) {
                    $table->unsignedBigInteger('vehicle_id');
                    $table->foreign('vehicle_id')->references('id')->on('vehicles')->onDelete('cascade');
                }

                // Ajouter d'autres colonnes si nécessaire
            });
        }

        // Vérifier et mettre à jour la table conversations
        if (Schema::hasTable('conversations')) {
            Schema::table('conversations', function (Blueprint $table) {
                if (!Schema::hasColumn('conversations', 'user_one_id')) {
                    $table->unsignedBigInteger('user_one_id');
                    $table->foreign('user_one_id')->references('id')->on('users')->onDelete('cascade');
                }

                if (!Schema::hasColumn('conversations', 'user_two_id')) {
                    $table->unsignedBigInteger('user_two_id');
                    $table->foreign('user_two_id')->references('id')->on('users')->onDelete('cascade');
                }

                if (!Schema::hasColumn('conversations', 'vehicle_id')) {
                    $table->unsignedBigInteger('vehicle_id')->nullable();
                    $table->foreign('vehicle_id')->references('id')->on('vehicles')->onDelete('set null');
                }

                if (!Schema::hasColumn('conversations', 'last_message_at')) {
                    $table->timestamp('last_message_at')->nullable();
                }
            });
        }

        // Ajouter d'autres tables si nécessaire
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Cette migration ne peut pas être annulée de manière sécurisée
    }
};
