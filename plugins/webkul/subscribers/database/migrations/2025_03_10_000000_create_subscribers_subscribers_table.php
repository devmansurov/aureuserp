<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('subscribers', function (Blueprint $table) {
            $table->id();
            $table->string('gender')->nullable();
            $table->date('birthdate')->nullable();
            $table->boolean('is_land_near_yard')->default(false);
            $table->boolean('is_land_rented')->default(false);
            $table->boolean('has_barn')->default(false);
            $table->boolean('has_pasture')->default(false);
            $table->boolean('has_dehkan_farm')->default(false);
            $table->boolean('is_test_team')->default(false);
            $table->decimal('land_total', 12, 2)->nullable();
            $table->unsignedBigInteger('excel_row_id')->nullable();
            $table->boolean('is_location_verified')->default(false);
            $table->boolean('is_rejected')->default(false);
            $table->string('status')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('subscribers');
    }
};
