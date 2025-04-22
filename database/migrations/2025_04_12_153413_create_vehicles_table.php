<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('vehicles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('brand_id')->constrained();
            $table->foreignId('vehicle_type_id')->constrained();
            $table->string('model');
            $table->integer('year');
            $table->integer('mileage');
            $table->integer('price');
            $table->text('description')->nullable();
            $table->string('city');
            $table->boolean('is_sold')->default(false);
            $table->boolean('is_featured')->default(false);
            $table->integer('views')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('vehicles');
    }
};
