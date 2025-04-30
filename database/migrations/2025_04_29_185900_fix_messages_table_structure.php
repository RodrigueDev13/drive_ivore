<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Vérifier si la table messages existe
        if (Schema::hasTable('messages')) {
            // Vérifier les contraintes de clé étrangère existantes
            $foreignKeys = $this->getForeignKeys('messages');
            
            Schema::table('messages', function (Blueprint $table) use ($foreignKeys) {
                // Ajouter conversation_id s'il n'existe pas
                if (!Schema::hasColumn('messages', 'conversation_id')) {
                    $table->unsignedBigInteger('conversation_id')->nullable()->after('id');
                    // Ajouter la clé étrangère seulement si la table conversations existe
                    if (Schema::hasTable('conversations')) {
                        $table->foreign('conversation_id')->references('id')->on('conversations')->onDelete('cascade');
                    }
                }
                
                // Vérifier si user_id existe, sinon le créer (peut-être à partir de sender_id)
                if (!Schema::hasColumn('messages', 'user_id')) {
                    if (Schema::hasColumn('messages', 'sender_id')) {
                        // Renommer sender_id en user_id
                        // Supprimer d'abord la clé étrangère si elle existe
                        if (in_array('messages_sender_id_foreign', $foreignKeys)) {
                            $table->dropForeign(['sender_id']);
                        }
                        $table->renameColumn('sender_id', 'user_id');
                        // Ajouter la clé étrangère pour user_id
                        $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
                    } else {
                        // Créer user_id s'il n'existe pas du tout
                        $table->unsignedBigInteger('user_id')->after('conversation_id');
                        $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
                    }
                }
                
                // Gérer recipient_id - le supprimer s'il existe
                if (Schema::hasColumn('messages', 'recipient_id')) {
                    // Supprimer la clé étrangère si elle existe
                    if (in_array('messages_recipient_id_foreign', $foreignKeys)) {
                        $table->dropForeign(['recipient_id']);
                    }
                    $table->dropColumn('recipient_id');
                }
                
                // Gérer vehicle_id - le supprimer s'il existe car il est maintenant dans conversations
                if (Schema::hasColumn('messages', 'vehicle_id')) {
                    // Supprimer la clé étrangère si elle existe
                    if (in_array('messages_vehicle_id_foreign', $foreignKeys)) {
                        $table->dropForeign(['vehicle_id']);
                    }
                    $table->dropColumn('vehicle_id');
                }
                
                // Ajouter read_at s'il n'existe pas
                if (!Schema::hasColumn('messages', 'read_at')) {
                    $table->timestamp('read_at')->nullable()->after('content');
                }
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Cette migration est une correction, donc nous ne faisons rien dans down()
    }
    
    /**
     * Récupérer les clés étrangères d'une table
     */
    private function getForeignKeys($tableName)
    {
        $foreignKeys = [];
        
        try {
            // Récupérer les clés étrangères de la table
            $constraints = DB::select("
                SELECT CONSTRAINT_NAME
                FROM information_schema.TABLE_CONSTRAINTS
                WHERE CONSTRAINT_TYPE = 'FOREIGN KEY'
                AND TABLE_NAME = '{$tableName}'
                AND TABLE_SCHEMA = DATABASE()
            ");
            
            foreach ($constraints as $constraint) {
                $foreignKeys[] = $constraint->CONSTRAINT_NAME;
            }
        } catch (\Exception $e) {
            // En cas d'erreur, retourner un tableau vide
        }
        
        return $foreignKeys;
    }
};
