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
        Schema::table('article_analyses', function (Blueprint $table) {
            $table->json('ambient_signature')->nullable();
            $table->text('emotional_resonance')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('article_analyses', function (Blueprint $table) {
            $table->dropColumn(['ambient_signature', 'emotional_resonance']);
        });
    }
};
