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
        Schema::table('songs', function (Blueprint $table) {
            $table->string('key')->nullable()->comment('Musical Key e.g. C Major');
            $table->integer('bpm')->nullable();
            
            // Audio Features (0-100 scale or 0.0-1.0, let's use tinyInteger 0-100 for simplicity and easy display)
            // Or float for precision? Spotify uses 0.0-1.0. Let's use float.
            $table->float('energy')->nullable();
            $table->float('danceability')->nullable();
            $table->float('valence')->nullable();
            
            // Extras if we want later
            $table->float('acousticness')->nullable();
            $table->float('instrumentalness')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('songs', function (Blueprint $table) {
            $table->dropColumn(['key', 'bpm', 'energy', 'danceability', 'valence', 'acousticness', 'instrumentalness']);
        });
    }
};
