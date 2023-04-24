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
        Schema::create('team_user', function (Blueprint $table) {
            // $table->unsignedInteger('hometeams_id');
            // $table->unsignedInteger('awayteams_id');
            $table->foreignId('user_id')->constrained();
            $table->foreignId('team_id')->constrained();
            $table->primary(['user_id','team_id']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('team_user');
    }
};
