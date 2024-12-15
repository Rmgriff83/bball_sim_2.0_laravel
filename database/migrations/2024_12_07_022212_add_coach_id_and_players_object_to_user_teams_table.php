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
        Schema::table('user_teams', function (Blueprint $table) {
            //
            $table->integer('coach_id')->nullable();
            $table->string('players_object')->default('{}');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('user_teams', function (Blueprint $table) {
            //
            $table->dropColumn('coach_id');
            $table->dropColumn('players_object');
        });
    }
};
