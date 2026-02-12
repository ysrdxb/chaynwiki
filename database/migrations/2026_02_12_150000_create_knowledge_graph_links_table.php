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
        Schema::create('knowledge_graph_links', function (Blueprint $table) {
            $table->id();
            $table->foreignId('source_id')->constrained('articles')->cascadeOnDelete();
            $table->foreignId('target_id')->constrained('articles')->cascadeOnDelete();
            $table->float('weight')->default(1.0);
            $table->string('type')->nullable(); // e.g., 'genre', 'collaboration'
            $table->timestamps();

            // Unique constraint to prevent duplicate links
            $table->unique(['source_id', 'target_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('knowledge_graph_links');
    }
};
