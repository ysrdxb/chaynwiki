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
        Schema::create('gears', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->enum('type', ['instrument', 'hardware', 'software', 'daw', 'accessory'])->default('hardware');
            $table->string('brand')->nullable(); // e.g. Roland, Fender, Steinberg
            $table->text('description')->nullable();
            $table->string('image')->nullable();
            $table->timestamps();
        });

        Schema::create('article_gear', function (Blueprint $table) {
            $table->id();
            $table->foreignId('article_id')->constrained()->onDelete('cascade');
            $table->foreignId('gear_id')->constrained()->onDelete('cascade');
            $table->string('usage_notes')->nullable(); // e.g. "Used for the bassline in the intro"
            $table->timestamps();

            $table->unique(['article_id', 'gear_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('article_gear');
        Schema::dropIfExists('gears');
    }
};
