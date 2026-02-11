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
        Schema::table('user_crates', function (Blueprint $table) {
            $table->string('slug')->unique()->after('name')->nullable();
            $table->boolean('is_public')->default(false)->after('description');
            $table->unsignedBigInteger('views_count')->default(0)->after('color_accent');
        });

        Schema::create('followers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->morphs('followable'); // Allows following crates, users, etc.
            $table->timestamps();
            
            $table->unique(['user_id', 'followable_id', 'followable_type']);
        });

        Schema::create('crate_collaborators', function (Blueprint $table) {
            $table->id();
            $table->foreignId('crate_id')->constrained('user_crates')->cascadeOnDelete();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('role')->default('contributor'); // contributor, editor
            $table->timestamps();

            $table->unique(['crate_id', 'user_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('crate_collaborators');
        Schema::dropIfExists('followers');
        Schema::table('user_crates', function (Blueprint $table) {
            $table->dropColumn(['slug', 'is_public', 'views_count']);
        });
    }
};
