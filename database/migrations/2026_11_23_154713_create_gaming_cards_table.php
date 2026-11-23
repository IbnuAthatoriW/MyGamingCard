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
        Schema::create('gaming_cards', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('game_type'); // 'pubg' or 'mlbb'
            $table->string('nickname');
            $table->string('player_id');
            $table->string('server_id')->nullable(); // MLBB only
            $table->string('rank');
            $table->string('favorite_weapon')->nullable(); // PUBG only
            $table->string('favorite_hero')->nullable(); // MLBB only
            $table->string('kd_ratio')->nullable(); // PUBG only
            $table->string('win_rate')->nullable();
            $table->string('template')->default('default');
            $table->string('color_scheme')->default('blue');
            $table->boolean('is_public')->default(false);
            $table->string('share_slug')->unique();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('gaming_cards');
    }
};
