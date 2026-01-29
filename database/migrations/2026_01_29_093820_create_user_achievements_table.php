<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Achievements definition table
        Schema::create('achievements', function (Blueprint $table) {
            $table->id();
            $table->string('slug')->unique();
            $table->string('name');
            $table->text('description');
            $table->string('icon')->nullable(); // emoji or icon class
            $table->string('category'); // contributor, editor, expert, community
            $table->string('tier')->default('bronze'); // bronze, silver, gold, platinum
            $table->integer('points')->default(10);
            $table->json('requirements')->nullable(); // conditions to earn
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        // User earned achievements
        Schema::create('user_achievements', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('achievement_id')->constrained()->cascadeOnDelete();
            $table->integer('progress')->default(0); // for progressive achievements
            $table->timestamp('earned_at')->nullable();
            $table->timestamps();

            $table->unique(['user_id', 'achievement_id']);
            $table->index('earned_at');
        });

        // User contribution streaks
        Schema::create('user_streaks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('type')->default('daily'); // daily, weekly
            $table->integer('current_streak')->default(0);
            $table->integer('longest_streak')->default(0);
            $table->date('last_activity_date')->nullable();
            $table->timestamps();

            $table->unique(['user_id', 'type']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('user_streaks');
        Schema::dropIfExists('user_achievements');
        Schema::dropIfExists('achievements');
    }
};
