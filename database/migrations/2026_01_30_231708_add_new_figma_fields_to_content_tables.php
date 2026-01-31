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
        Schema::table('songs', function (Blueprint $table) {
            $table->string('studio_recorded')->nullable()->after('songwriter');
            $table->text('behind_the_song')->nullable()->after('studio_recorded');
            $table->text('achievements')->nullable()->after('behind_the_song');
            $table->text('lyrics_snippet')->nullable()->after('achievements');
        });

        Schema::table('artists', function (Blueprint $table) {
            $table->string('active_years_string')->nullable()->after('origin_location');
            $table->json('top_songs_meta')->nullable()->after('active_years_string');
            $table->text('breakthrough_moment')->nullable()->after('top_songs_meta');
            $table->text('live_performances')->nullable()->after('breakthrough_moment');
        });

        Schema::table('genres', function (Blueprint $table) {
            $table->string('origin_country')->nullable()->after('origin_date');
            $table->string('appearance_year')->nullable()->after('origin_country');
            $table->text('popular_artists')->nullable()->after('appearance_year');
            $table->text('early_history')->nullable()->after('popular_artists');
            $table->text('cultural_impact')->nullable()->after('early_history');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('songs', function (Blueprint $table) {
            $table->dropColumn(['studio_recorded', 'behind_the_song', 'achievements', 'lyrics_snippet']);
        });

        Schema::table('artists', function (Blueprint $table) {
            $table->dropColumn(['active_years_string', 'top_songs_meta', 'breakthrough_moment', 'live_performances']);
        });

        Schema::table('genres', function (Blueprint $table) {
            $table->dropColumn(['origin_country', 'appearance_year', 'popular_artists', 'early_history', 'cultural_impact']);
        });
    }
};
