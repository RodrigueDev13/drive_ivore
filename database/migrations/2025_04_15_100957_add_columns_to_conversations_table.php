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
        Schema::table('conversations', function (Blueprint $table) {
            // Vérifier et ajouter user_one_id si nécessaire
            if (!Schema::hasColumn('conversations', 'user_one_id')) {
                $table->unsignedBigInteger('user_one_id')->after('id');
                $table->foreign('user_one_id')->references('id')->on('users')->onDelete('cascade');
            }

            // Vérifier et ajouter user_two_id si nécessaire
            if (!Schema::hasColumn('conversations', 'user_two_id')) {
                $table->unsignedBigInteger('user_two_id')->after('user_one_id');
                $table->foreign('user_two_id')->references('id')->on('users')->onDelete('cascade');
            }

            // Vérifier et ajouter vehicle_id si nécessaire
            if (!Schema::hasColumn('conversations', 'vehicle_id')) {
                $table->unsignedBigInteger('vehicle_id')->nullable()->after('user_two_id');
                $table->foreign('vehicle_id')->references('id')->on('vehicles')->onDelete('set null');
            }

            // Vérifier et ajouter last_message_at si nécessaire
            if (!Schema::hasColumn('conversations', 'last_message_at')) {
                $table->timestamp('last_message_at')->nullable()->after('vehicle_id');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('conversations', function (Blueprint $table) {
            // Supprimer les clés étrangères d'abord
            if (Schema::hasColumn('conversations', 'user_one_id')) {
                $table->dropForeign(['user_one_id']);
                $table->dropColumn('user_one_id');
            }

            if (Schema::hasColumn('conversations', 'user_two_id')) {
                $table->dropForeign(['user_two_id']);
                $table->dropColumn('user_two_id');
            }

            if (Schema::hasColumn('conversations', 'vehicle_id')) {
                $table->dropForeign(['vehicle_id']);
                $table->dropColumn('vehicle_id');
            }

            if (Schema::hasColumn('conversations', 'last_message_at')) {
                $table->dropColumn('last_message_at');
            }
        });
    }
};
