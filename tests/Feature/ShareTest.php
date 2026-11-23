<?php

namespace Tests\Feature;

use App\Models\GamingCard;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ShareTest extends TestCase
{
    use RefreshDatabase;

    public function test_public_card_is_accessible_via_share_link(): void
    {
        $card = GamingCard::factory()->pubg()->public()->create();

        $response = $this->get(route('card.share', $card->share_slug));

        $response->assertStatus(200);
        $response->assertSee($card->nickname);
        $response->assertSee('PUBG MOBILE');
        $response->assertSee($card->favorite_weapon);
    }

    public function test_private_card_returns_404_on_share_link(): void
    {
        $card = GamingCard::factory()->pubg()->create(['is_public' => false]);

        $response = $this->get(route('card.share', $card->share_slug));

        $response->assertStatus(404);
    }

    public function test_owner_can_toggle_card_visibility(): void
    {
        $user = User::factory()->create();
        $card = GamingCard::factory()->create([
            'user_id' => $user->id,
            'is_public' => false,
        ]);

        $response = $this->actingAs($user)->patch(route('cards.visibility', $card));

        $response->assertRedirect();
        $card->refresh();
        $this->assertTrue($card->is_public);

        // Toggle back to private
        $this->actingAs($user)->patch(route('cards.visibility', $card));
        $card->refresh();
        $this->assertFalse($card->is_public);
    }

    public function test_non_owner_cannot_toggle_card_visibility(): void
    {
        $user1 = User::factory()->create();
        $user2 = User::factory()->create();
        $card = GamingCard::factory()->create([
            'user_id' => $user1->id,
            'is_public' => false,
        ]);

        $response = $this->actingAs($user2)->patch(route('cards.visibility', $card));

        $response->assertStatus(403);
        $card->refresh();
        $this->assertFalse($card->is_public);
    }
}
