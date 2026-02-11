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
        Schema::table('users', function (Blueprint $table) {
            if (!Schema::hasColumn('users', 'spotify_id')) {
                $table->string('spotify_id')->nullable()->after('email');
                $table->text('spotify_token')->nullable()->after('spotify_id');
                $table->text('spotify_refresh_token')->nullable()->after('spotify_token');
                $table->timestamp('spotify_token_expires_at')->nullable()->after('spotify_refresh_token');
                $table->json('spotify_now_playing')->nullable()->after('spotify_token_expires_at');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'spotify_id',
                'spotify_token',
                'spotify_refresh_token',
                'spotify_token_expires_at',
                'spotify_now_playing',
            ]);
        });
    }
};
