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
        Schema::create('article_relationships', function (Blueprint $table) {
            $table->id();
            $table->foreignId('source_id')->constrained('articles')->cascadeOnDelete();
            $table->foreignId('target_id')->constrained('articles')->cascadeOnDelete();
            $table->string('type'); // influences, sampled_by, member_of, fusion_of, similar_to, etc.
            $table->integer('strength')->default(50); // 1-100
            $table->json('metadata')->nullable(); // For extra info like 'peak_year', 'instrument', etc.
            $table->timestamps();

            $table->unique(['source_id', 'target_id', 'type'], 'art_rel_unique');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('article_relationships');
    }
};
