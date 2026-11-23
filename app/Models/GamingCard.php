<?php

namespace App\Models;

use Database\Factories\GamingCardFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

#[Fillable([
    'game_type',
    'nickname',
    'player_id',
    'server_id',
    'rank',
    'favorite_weapon',
    'favorite_hero',
    'kd_ratio',
    'win_rate',
    'template',
    'color_scheme',
    'is_public',
])]
class GamingCard extends Model
{
    /** @use HasFactory<GamingCardFactory> */
    use HasFactory;

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'is_public' => 'boolean',
        ];
    }

    /**
     * Boot the model.
     */
    protected static function booted(): void
    {
        static::creating(function (GamingCard $card): void {
            if (empty($card->share_slug)) {
                $card->share_slug = Str::random(10);
            }
        });
    }

    /**
     * Get the user that owns the gaming card.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the route key name for route model binding.
     */
    public function getRouteKeyName(): string
    {
        return 'id';
    }

    /**
     * Check if the card is a PUBG card.
     */
    public function isPubg(): bool
    {
        return $this->game_type === 'pubg';
    }

    /**
     * Check if the card is an MLBB card.
     */
    public function isMlbb(): bool
    {
        return $this->game_type === 'mlbb';
    }
}
