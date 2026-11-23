<?php

namespace Database\Factories;

use App\Models\GamingCard;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<GamingCard>
 */
class GamingCardFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $gameType = $this->faker->randomElement(['pubg', 'mlbb']);

        return [
            'user_id' => User::factory(),
            'game_type' => $gameType,
            'nickname' => $this->faker->userName(),
            'player_id' => (string) $this->faker->randomNumber(9),
            'server_id' => $gameType === 'mlbb' ? (string) $this->faker->randomNumber(4) : null,
            'rank' => $this->faker->randomElement(['Bronze', 'Silver', 'Gold', 'Platinum', 'Diamond', 'Mythic']),
            'favorite_weapon' => $gameType === 'pubg' ? $this->faker->randomElement(['M416', 'AKM', 'AWM', 'M762']) : null,
            'favorite_hero' => $gameType === 'mlbb' ? $this->faker->randomElement(['Lancelot', 'Fanny', 'Chou', 'Ling']) : null,
            'kd_ratio' => $gameType === 'pubg' ? number_format($this->faker->randomFloat(2, 1, 10), 2) : null,
            'win_rate' => number_format($this->faker->randomFloat(1, 20, 90), 1).'%',
            'template' => 'default',
            'color_scheme' => $this->faker->randomElement(['blue', 'purple', 'red', 'green', 'gold']),
            'is_public' => $this->faker->boolean(),
            'share_slug' => Str::random(10),
        ];
    }

    /**
     * Indicate the card is for PUBG.
     */
    public function pubg(): static
    {
        return $this->state(fn (array $attributes): array => [
            'game_type' => 'pubg',
            'server_id' => null,
            'favorite_hero' => null,
            'favorite_weapon' => $this->faker->randomElement(['M416', 'AKM', 'AWM', 'M762']),
            'kd_ratio' => number_format($this->faker->randomFloat(2, 1, 10), 2),
        ]);
    }

    /**
     * Indicate the card is for MLBB.
     */
    public function mlbb(): static
    {
        return $this->state(fn (array $attributes): array => [
            'game_type' => 'mlbb',
            'server_id' => (string) $this->faker->randomNumber(4),
            'favorite_weapon' => null,
            'kd_ratio' => null,
            'favorite_hero' => $this->faker->randomElement(['Lancelot', 'Fanny', 'Chou', 'Ling']),
        ]);
    }

    /**
     * Indicate the card is public.
     */
    public function public(): static
    {
        return $this->state(fn (array $attributes): array => [
            'is_public' => true,
        ]);
    }
}
