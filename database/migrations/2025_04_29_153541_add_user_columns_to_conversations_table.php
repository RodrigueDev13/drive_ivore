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
            // Vérifier si les colonnes n'existent pas déjà
            if (!Schema::hasColumn('conversations', 'user_one_id')) {
                $table->unsignedBigInteger('user_one_id')->nullable();
                $table->foreign('user_one_id')->references('id')->on('users')->onDelete('cascade');
            }
            
            if (!Schema::hasColumn('conversations', 'user_two_id')) {
                $table->unsignedBigInteger('user_two_id')->nullable();
                $table->foreign('user_two_id')->references('id')->on('users')->onDelete('cascade');
            }
            
            if (!Schema::hasColumn('conversations', 'vehicle_id')) {
                $table->unsignedBigInteger('vehicle_id')->nullable();
                $table->foreign('vehicle_id')->references('id')->on('vehicles')->onDelete('set null');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('conversations', function (Blueprint $table) {
            if (Schema::hasColumn('conversations', 'vehicle_id')) {
                $table->dropForeign(['vehicle_id']);
                $table->dropColumn('vehicle_id');
            }
            
            if (Schema::hasColumn('conversations', 'user_two_id')) {
                $table->dropForeign(['user_two_id']);
                $table->dropColumn('user_two_id');
            }
            
            if (Schema::hasColumn('conversations', 'user_one_id')) {
                $table->dropForeign(['user_one_id']);
                $table->dropColumn('user_one_id');
            }
        });
    }
};
