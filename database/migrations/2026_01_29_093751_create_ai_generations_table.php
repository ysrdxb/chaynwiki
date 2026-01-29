<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ai_generations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->string('type'); // article, summary, analysis, search, chat
            $table->string('model')->default('llama3');
            $table->text('prompt');
            $table->longText('response')->nullable();
            $table->string('status')->default('pending'); // pending, completed, failed
            $table->integer('tokens_used')->nullable();
            $table->float('generation_time')->nullable(); // seconds
            $table->json('metadata')->nullable(); // extra context
            $table->timestamps();

            $table->index(['user_id', 'type']);
            $table->index(['status', 'created_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ai_generations');
    }
};
