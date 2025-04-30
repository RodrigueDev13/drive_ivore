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
        Schema::table('vehicles', function (Blueprint $table) {
            if (!Schema::hasColumn('vehicles', 'location')) {
                $table->string('location')->nullable()->after('city');
            }
            
            if (!Schema::hasColumn('vehicles', 'color')) {
                $table->string('color')->nullable()->after('transmission');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('vehicles', function (Blueprint $table) {
            if (Schema::hasColumn('vehicles', 'location')) {
                $table->dropColumn('location');
            }
            
            if (Schema::hasColumn('vehicles', 'color')) {
                $table->dropColumn('color');
            }
        });
    }
};
