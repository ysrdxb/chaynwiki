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
            $table->string('role')->default('user')->after('password'); // user, moderator, admin
            $table->integer('reputation_score')->default(0)->after('role');
            $table->string('avatar')->nullable()->after('reputation_score');
            $table->text('bio')->nullable()->after('avatar');
            $table->string('location')->nullable()->after('bio');
            $table->string('website')->nullable()->after('location');
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['role', 'reputation_score', 'avatar', 'bio', 'location', 'website']);
            $table->dropSoftDeletes();
        });
    }
};
