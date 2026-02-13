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
        Schema::create('annotations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('article_id')->constrained()->cascadeOnDelete();
            
            // Text selection data
            $table->text('highlighted_text'); // The actual text being annotated
            $table->integer('range_start')->nullable(); // Character offset inside the container
            $table->integer('range_end')->nullable();
            $table->string('context_type')->default('lyrics'); // 'lyrics', 'bio', etc.
            
            // The annotation content
            $table->longText('content');
            
            // Meta
            $table->integer('votes')->default(0);
            $table->boolean('is_verified')->default(false);
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('annotations');
    }
};
