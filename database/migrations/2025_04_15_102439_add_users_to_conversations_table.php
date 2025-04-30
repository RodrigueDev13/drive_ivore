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
            // Vérifier si les colonnes existent déjà avant de les ajouter
            if (!Schema::hasColumn('conversations', 'recipient_id')) {
                $table->unsignedBigInteger('recipient_id');
            }
            
            if (!Schema::hasColumn('conversations', 'user_one_id')) {
                $table->unsignedBigInteger('user_one_id')->after('id');
            }
            
            if (!Schema::hasColumn('conversations', 'user_two_id')) {
                $table->unsignedBigInteger('user_two_id')->after(Schema::hasColumn('conversations', 'user_one_id') ? 'user_one_id' : 'id');
            }
            
            if (!Schema::hasColumn('conversations', 'last_message_at')) {
                $table->timestamp('last_message_at')->nullable()->after(Schema::hasColumn('conversations', 'user_two_id') ? 'user_two_id' : 'id');
            }
        });
    }

    public function down(): void
    {
        Schema::table('conversations', function (Blueprint $table) {
            // Vérifier si les colonnes existent avant de les supprimer
            $columns = [];
            
            if (Schema::hasColumn('conversations', 'recipient_id')) {
                $columns[] = 'recipient_id';
            }
            
            if (Schema::hasColumn('conversations', 'user_one_id')) {
                $columns[] = 'user_one_id';
            }
            
            if (Schema::hasColumn('conversations', 'user_two_id')) {
                $columns[] = 'user_two_id';
            }
            
            if (Schema::hasColumn('conversations', 'last_message_at')) {
                $columns[] = 'last_message_at';
            }
            
            if (!empty($columns)) {
                $table->dropColumn($columns);
            }
        });
    }

};
