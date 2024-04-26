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
        Schema::create('music_instrument', function (Blueprint $table) {
            $table->id();
	        $table->foreignId('music_id')->constrained('musics', 'id')->onDelete('cascade');
	        $table->foreignId('instrument_id')->constrained('instruments', 'id')->onDelete('cascade');
	        $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('music_instrument');
    }
};
