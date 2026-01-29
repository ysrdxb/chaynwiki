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
        Schema::table('genres', function (Blueprint $table) {
            $table->string('slug')->nullable()->unique()->after('name');
            $table->text('description')->nullable()->after('slug');
            $table->string('color')->default('#3B82F6')->after('description');
            $table->integer('era_start')->nullable()->after('color');
            $table->integer('era_end')->nullable()->after('era_start');
            $table->integer('popularity_score')->default(0)->after('era_end');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('genres', function (Blueprint $table) {
            $table->dropColumn(['slug', 'description', 'color', 'era_start', 'era_end', 'popularity_score']);
        });
    }
};
