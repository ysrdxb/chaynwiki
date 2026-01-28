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
        Schema::create('articles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->string('category')->index(); // song, artist, genre, playlist, term
            $table->string('title');
            $table->string('slug')->unique();
            $table->longText('content')->nullable();
            $table->text('excerpt')->nullable();
            $table->string('featured_image')->nullable();
            
            // Metrics
            $table->unsignedBigInteger('view_count')->default(0)->index();
            $table->decimal('trending_score', 10, 2)->default(0)->index();
            $table->unsignedTinyInteger('seo_score')->default(0);
            
            // Status
            $table->string('status')->default('draft')->index(); // draft, published, review, archived
            $table->timestamp('published_at')->nullable();
            
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('articles');
    }
};
