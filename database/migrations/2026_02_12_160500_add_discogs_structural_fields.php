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
        // 1. Expand Articles with Hierarchy and Quality Metrics
        Schema::table('articles', function (Blueprint $table) {
            $table->boolean('is_master')->default(false)->after('category');
            $table->foreignId('master_id')->nullable()->after('is_master')->constrained('articles')->nullOnDelete();
            $table->unsignedTinyInteger('data_quality')->default(50)->after('status'); // 1-100 (Discogs style)
            $table->unsignedTinyInteger('trust_score')->default(0)->after('data_quality');
        });

        // 2. Knowledge Wantlist for community-driven AI requests
        Schema::create('knowledge_wantlist', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('title');
            $table->string('category'); // song, artist, genre, etc.
            $table->text('description')->nullable();
            $table->string('status')->default('pending'); // pending, fulfilled, rejected
            $table->integer('votes')->default(1);
            $table->json('metadata')->nullable(); // target BPM, specific era, etc.
            $table->timestamps();
            
            $table->index('status');
            $table->index('votes');
        });

        // 3. Wantlist Votes (Social)
        Schema::create('wantlist_votes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('wantlist_id')->constrained('knowledge_wantlist')->cascadeOnDelete();
            $table->timestamps();
            
            $table->unique(['user_id', 'wantlist_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('wantlist_votes');
        Schema::dropIfExists('knowledge_wantlist');
        Schema::table('articles', function (Blueprint $table) {
            $table->dropForeign(['master_id']);
            $table->dropColumn(['is_master', 'master_id', 'data_quality', 'trust_score']);
        });
    }
};
