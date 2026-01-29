<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Only create if doesn't exist
        if (!Schema::hasTable('genre_relationships')) {
            Schema::create('genre_relationships', function (Blueprint $table) {
                $table->id();
                $table->foreignId('source_genre_id')->constrained('genres')->cascadeOnDelete();
                $table->foreignId('target_genre_id')->constrained('genres')->cascadeOnDelete();
                $table->string('relationship_type'); // influences, derived_from, fusion_of, similar_to
                $table->integer('strength')->default(50);
                $table->text('description')->nullable();
                $table->timestamps();

                // Shorter index name
                $table->unique(['source_genre_id', 'target_genre_id', 'relationship_type'], 'genre_rel_unique');
            });
        }

        // Artist collaborations for network graph
        if (!Schema::hasTable('artist_collaborations')) {
            Schema::create('artist_collaborations', function (Blueprint $table) {
                $table->id();
                $table->foreignId('artist1_id')->constrained('articles')->cascadeOnDelete();
                $table->foreignId('artist2_id')->constrained('articles')->cascadeOnDelete();
                $table->string('collaboration_type');
                $table->string('work_title')->nullable();
                $table->integer('year')->nullable();
                $table->timestamps();

                $table->index(['artist1_id', 'artist2_id'], 'collab_artists_idx');
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('artist_collaborations');
        Schema::dropIfExists('genre_relationships');
    }
};
