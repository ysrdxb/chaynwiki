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
            $table->string('username')->unique()->after('name')->nullable();
        });
        
        // Populate existing users
        $users = \App\Models\User::all();
        foreach($users as $user) {
            $user->username = \Illuminate\Support\Str::slug($user->name) . '-' . $user->id;
            $user->save();
        }
        
        // Make it required after population (if we want strictness, but nullable is safer for now if migration runs on empty DB)
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('username');
        });
    }
};
