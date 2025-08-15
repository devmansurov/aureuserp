<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class
{
    public function up(): void
    {
        Schema::create('locales', function (Blueprint $table) {
            $table->id();
            $table->string('code', 5)->unique();
            $table->string('name');
            $table->string('native_name')->nullable();
            $table->string('flag')->nullable();
            $table->boolean('active')->default(true);
            $table->timestamps();
        });

        DB::table('locales')->insert([
            ['code' => 'en', 'name' => 'English', 'native_name' => 'English', 'flag' => '🇬🇧'],
            ['code' => 'ru', 'name' => 'Russian', 'native_name' => 'Русский', 'flag' => '🇷🇺'],
            ['code' => 'tg', 'name' => 'Tajik', 'native_name' => 'Тоҷикӣ', 'flag' => '🇹🇯'],
        ]);
    }

    public function down(): void
    {
        Schema::dropIfExists('locales');
    }
};
