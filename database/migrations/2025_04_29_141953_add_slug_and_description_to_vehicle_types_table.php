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
        Schema::table('vehicle_types', function (Blueprint $table) {
            if (!Schema::hasColumn('vehicle_types', 'slug')) {
                $table->string('slug')->unique()->after('name');
            }
            
            if (!Schema::hasColumn('vehicle_types', 'description')) {
                $table->text('description')->nullable()->after('slug');
            }
            
            if (!Schema::hasColumn('vehicle_types', 'icon')) {
                $table->string('icon')->nullable()->after('description');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('vehicle_types', function (Blueprint $table) {
            if (Schema::hasColumn('vehicle_types', 'icon')) {
                $table->dropColumn('icon');
            }
            
            if (Schema::hasColumn('vehicle_types', 'description')) {
                $table->dropColumn('description');
            }
            
            if (Schema::hasColumn('vehicle_types', 'slug')) {
                $table->dropColumn('slug');
            }
        });
    }
};
