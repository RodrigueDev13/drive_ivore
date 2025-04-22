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
            // Ajouter la colonne recipient_id si elle n'existe pas
            if (!Schema::hasColumn('messages', 'recipient_id')) {
                $table->unsignedBigInteger('recipient_id')->after('sender_id');
                $table->foreign('recipient_id')->references('id')->on('users')->onDelete('cascade');
            }

            // Ajouter la colonne vehicle_id si elle n'existe pas
            if (!Schema::hasColumn('messages', 'vehicle_id')) {
                $table->unsignedBigInteger('vehicle_id')->nullable()->after('recipient_id');
                $table->foreign('vehicle_id')->references('id')->on('vehicles')->onDelete('set null');
            }

            // Ajouter la colonne read_at si elle n'existe pas
            if (!Schema::hasColumn('messages', 'read_at')) {
                $table->timestamp('read_at')->nullable()->after('content');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('messages', function (Blueprint $table) {
            // Supprimer les clés étrangères d'abord
            if (Schema::hasColumn('messages', 'recipient_id')) {
                $table->dropForeign(['recipient_id']);
                $table->dropColumn('recipient_id');
            }

            if (Schema::hasColumn('messages', 'vehicle_id')) {
                $table->dropForeign(['vehicle_id']);
                $table->dropColumn('vehicle_id');
            }

            if (Schema::hasColumn('messages', 'read_at')) {
                $table->dropColumn('read_at');
            }
        });
    }
};
