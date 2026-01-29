<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasColumn('articles', 'views')) {
            Schema::table('articles', function (Blueprint $table) {
                $table->dropColumn('views');
            });
        }
    }

    public function down(): void
    {
        Schema::table('articles', function (Blueprint $table) {
            $table->unsignedBigInteger('views')->default(0)->after('status');
        });
    }
};
