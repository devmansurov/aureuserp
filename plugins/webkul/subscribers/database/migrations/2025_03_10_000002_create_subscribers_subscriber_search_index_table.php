<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('subscriber_search_index', function (Blueprint $table) {
            $table->unsignedBigInteger('subscriber_id');
            $table->string('locale', 5);
            $table->string('full_name')->nullable();
            $table->string('company')->nullable();
            $table->string('position')->nullable();
            $table->string('village')->nullable();
            $table->string('status')->nullable();
            $table->string('gender')->nullable();
            $table->text('search_text')->nullable();

            $table->primary(['subscriber_id', 'locale']);
            $table->index('locale');
            $table->index('full_name');
            $table->index('company');
            $table->index('status');
            $table->foreign('subscriber_id')->references('id')->on('subscribers')->onDelete('cascade');
            $table->fullText('search_text');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('subscriber_search_index');
    }
};
