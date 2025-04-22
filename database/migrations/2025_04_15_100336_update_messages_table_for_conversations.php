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
            // Ajouter conversation_id
            if (!Schema::hasColumn('messages', 'conversation_id')) {
                $table->unsignedBigInteger('conversation_id')->after('id')->nullable();
                $table->foreign('conversation_id')->references('id')->on('conversations')->onDelete('cascade');
            }

            // Renommer sender_id en user_id
            if (Schema::hasColumn('messages', 'sender_id') && !Schema::hasColumn('messages', 'user_id')) {
                $table->renameColumn('sender_id', 'user_id');
            }

            // Supprimer recipient_id et vehicle_id (car ils sont maintenant dans la table conversations)
            if (Schema::hasColumn('messages', 'recipient_id')) {
                $table->dropForeign(['recipient_id']);
                $table->dropColumn('recipient_id');
            }

            if (Schema::hasColumn('messages', 'vehicle_id')) {
                $table->dropForeign(['vehicle_id']);
                $table->dropColumn('vehicle_id');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('messages', function (Blueprint $table) {
            // Restaurer les colonnes supprimées
            if (!Schema::hasColumn('messages', 'recipient_id')) {
                $table->unsignedBigInteger('recipient_id')->after('user_id')->nullable();
                $table->foreign('recipient_id')->references('id')->on('users')->onDelete('cascade');
            }

            if (!Schema::hasColumn('messages', 'vehicle_id')) {
                $table->unsignedBigInteger('vehicle_id')->after('recipient_id')->nullable();
                $table->foreign('vehicle_id')->references('id')->on('vehicles')->onDelete('set null');
            }

            // Renommer user_id en sender_id
            if (Schema::hasColumn('messages', 'user_id') && !Schema::hasColumn('messages', 'sender_id')) {
                $table->renameColumn('user_id', 'sender_id');
            }

            // Supprimer conversation_id
            if (Schema::hasColumn('messages', 'conversation_id')) {
                $table->dropForeign(['conversation_id']);
                $table->dropColumn('conversation_id');
            }
        });
    }
};
