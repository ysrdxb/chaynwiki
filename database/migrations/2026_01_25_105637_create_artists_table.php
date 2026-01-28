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
        Schema::create('artists', function (Blueprint $table) {
            $table->id();
            $table->foreignId('article_id')->constrained()->cascadeOnDelete();
            $table->string('name'); // Redundant but useful for quick lookup
            $table->string('spotify_id')->nullable()->index();
            $table->string('website')->nullable();
            $table->json('social_links')->nullable(); // instagram, twitter, etc
            $table->date('active_from')->nullable();
            $table->date('active_to')->nullable();
            $table->string('origin_location')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('artists');
    }
};
