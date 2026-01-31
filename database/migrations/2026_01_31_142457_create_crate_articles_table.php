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
        Schema::create('crate_articles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('crate_id')->constrained('user_crates')->cascadeOnDelete();
            $table->foreignId('article_id')->constrained()->cascadeOnDelete();
            $table->text('notes')->nullable(); // Contribution notes for this specific crate item
            $table->timestamps();
            
            $table->unique(['crate_id', 'article_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('crate_articles');
    }
};
