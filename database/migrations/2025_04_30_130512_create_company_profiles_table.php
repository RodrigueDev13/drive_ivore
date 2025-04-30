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
        Schema::create('company_profiles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('company_name');
            $table->string('registration_number')->nullable(); // RCCM ou autre numéro d'immatriculation
            $table->string('tax_id')->nullable(); // Numéro fiscal
            $table->string('address');
            $table->string('city');
            $table->string('phone_number');
            $table->text('description')->nullable();
            $table->string('logo')->nullable(); // Chemin vers le logo
            $table->string('website')->nullable();
            $table->boolean('profile_completed')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('company_profiles');
    }
};
