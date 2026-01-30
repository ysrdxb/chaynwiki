<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('artist_collaborations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('artist1_id')->constrained('articles')->onDelete('cascade');
            $table->foreignId('artist2_id')->constrained('articles')->onDelete('cascade');
            $table->string('collaboration_type')->default('featured'); // featured, remix, producer, etc.
            $table->string('work_title')->nullable();
            $table->year('year')->nullable();
            $table->integer('strength')->default(50); // 1-100
            $table->timestamps();

            $table->index(['artist1_id', 'artist2_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('artist_collaborations');
    }
};
