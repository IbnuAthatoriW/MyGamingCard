<?php

namespace Database\Seeders;

use App\Models\GamingCard;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $user = User::firstOrCreate(
            ['email' => 'gamer@mygamingcard.com'],
            [
                'name' => 'Pro Gamer',
                'password' => Hash::make('password123'),
            ]
        );

        // Sample PUBG Card
        GamingCard::firstOrCreate(
            ['user_id' => $user->id, 'nickname' => 'ShadowStrike'],
            [
                'game_type' => 'pubg',
                'player_id' => '5847291036',
                'rank' => 'Conqueror',
                'favorite_weapon' => 'M416',
                'kd_ratio' => '6.42',
                'win_rate' => '28.5%',
                'template' => 'futuristic',
                'color_scheme' => 'purple',
                'is_public' => true,
                'share_slug' => 'shadowstrike-pubg',
            ]
        );

        // Sample MLBB Card
        GamingCard::firstOrCreate(
            ['user_id' => $user->id, 'nickname' => 'LunarBlade'],
            [
                'game_type' => 'mlbb',
                'player_id' => '192837465',
                'server_id' => '8201',
                'rank' => 'Mythical Glory',
                'favorite_hero' => 'Lancelot',
                'win_rate' => '72.1%',
                'template' => 'minimal',
                'color_scheme' => 'blue',
                'is_public' => true,
                'share_slug' => 'lunarblade-mlbb',
            ]
        );
    }
}
