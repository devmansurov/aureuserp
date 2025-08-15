<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('subscriber_translations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('subscriber_id');
            $table->string('locale', 5);
            $table->string('full_name')->nullable();
            $table->string('company')->nullable();
            $table->string('position')->nullable();
            $table->string('source')->nullable();
            $table->text('notes')->nullable();
            $table->string('village')->nullable();
            $table->string('dehkan_farm_name')->nullable();
            $table->string('temp_district')->nullable();
            $table->string('temp_jamoat')->nullable();
            $table->timestamps();

            $table->unique(['subscriber_id', 'locale']);
            $table->foreign('subscriber_id')->references('id')->on('subscribers')->onDelete('cascade');
            $table->index('locale');
            $table->index('full_name');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('subscriber_translations');
    }
};
