<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('search_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->string('query');
            $table->string('category')->nullable(); // all, song, artist, genre
            $table->integer('results_count')->default(0);
            $table->string('clicked_article_id')->nullable(); // which result they clicked
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->timestamps();

            $table->index(['query', 'created_at']);
            $table->index('created_at');
        });

        // Article analysis cache (AI-generated insights)
        Schema::create('article_analyses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('article_id')->constrained()->cascadeOnDelete();
            $table->json('themes')->nullable();
            $table->string('mood')->nullable();
            $table->integer('mood_score')->nullable();
            $table->json('literary_devices')->nullable();
            $table->string('rhyme_scheme')->nullable();
            $table->text('summary')->nullable();
            $table->integer('quality_score')->nullable(); // 1-100
            $table->integer('readability_score')->nullable();
            $table->json('suggested_tags')->nullable();
            $table->json('related_articles')->nullable();
            $table->timestamp('analyzed_at')->nullable();
            $table->timestamps();

            $table->unique('article_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('article_analyses');
        Schema::dropIfExists('search_logs');
    }
};
