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
        Schema::create('songs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('article_id')->constrained()->cascadeOnDelete();
            $table->string('title');
            
            // Relationships
            $table->foreignId('artist_id')->nullable()->constrained()->nullOnDelete(); // Primary artist
            $table->foreignId('genre_id')->nullable()->constrained()->nullOnDelete();
            
            // Metadata
            $table->string('album')->nullable();
            $table->date('release_date')->nullable();
            $table->integer('duration')->nullable(); // in seconds
            
            // External IDs
            $table->string('spotify_id')->nullable()->index();
            $table->string('youtube_id')->nullable();
            
            // Content
            $table->longText('lyrics')->nullable();
            $table->string('producer')->nullable();
            $table->string('songwriter')->nullable();
            $table->string('record_label')->nullable();
            
            // Live Data
            $table->unsignedBigInteger('stream_count')->default(0);
            $table->timestamp('last_stream_update')->nullable();
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('songs');
    }
};
