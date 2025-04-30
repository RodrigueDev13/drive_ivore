<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Étape 1: Ajouter la colonne sender_id
        Schema::table('messages', function (Blueprint $table) {
            if (!Schema::hasColumn('messages', 'sender_id')) {
                $table->unsignedBigInteger('sender_id')->nullable()->after('user_id');
                $table->foreign('sender_id')->references('id')->on('users')->onDelete('cascade');
            }
        });

        // Étape 2: Copier les valeurs de user_id vers sender_id
        DB::statement('UPDATE messages SET sender_id = user_id WHERE sender_id IS NULL');

        // Étape 3: Ajouter recipient_id et vehicle_id
        Schema::table('messages', function (Blueprint $table) {
            if (!Schema::hasColumn('messages', 'recipient_id')) {
                $table->unsignedBigInteger('recipient_id')->nullable()->after('sender_id');
                $table->foreign('recipient_id')->references('id')->on('users')->onDelete('cascade');
            }
            
            if (!Schema::hasColumn('messages', 'vehicle_id')) {
                $table->unsignedBigInteger('vehicle_id')->nullable()->after('recipient_id');
                $table->foreign('vehicle_id')->references('id')->on('vehicles')->onDelete('set null');
            }
            
            if (!Schema::hasColumn('messages', 'read_at')) {
                $table->timestamp('read_at')->nullable()->after('body');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('messages', function (Blueprint $table) {
            if (Schema::hasColumn('messages', 'read_at')) {
                $table->dropColumn('read_at');
            }
            
            if (Schema::hasColumn('messages', 'vehicle_id')) {
                $table->dropForeign(['vehicle_id']);
                $table->dropColumn('vehicle_id');
            }
            
            if (Schema::hasColumn('messages', 'recipient_id')) {
                $table->dropForeign(['recipient_id']);
                $table->dropColumn('recipient_id');
            }
            
            if (Schema::hasColumn('messages', 'sender_id')) {
                $table->dropForeign(['sender_id']);
                $table->dropColumn('sender_id');
            }
        });
    }
};
