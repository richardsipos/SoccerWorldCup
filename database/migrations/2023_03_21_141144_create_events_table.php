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
        Schema::create('events', function (Blueprint $table) {
            //$table->enum
            $table->id(); //->references('player_id')

            //foreign key to player
            $table->foreignId('player_id')->constrained();//->nullable();
            $table->foreignId('game_id')->constrained();//->nullable();

            $table->enum('type',['gól','öngól', 'sárga lap', 'piros lap']);
            $table->integer('minute');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('events');
    }
};
