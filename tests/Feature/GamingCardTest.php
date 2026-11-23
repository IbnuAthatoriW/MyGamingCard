<?php

namespace Tests\Feature;

use App\Models\GamingCard;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class GamingCardTest extends TestCase
{
    use RefreshDatabase;

    public function test_landing_page_is_accessible(): void
    {
        $response = $this->get(route('home'));

        $response->assertStatus(200);
        $response->assertSee('Create Your');
        $response->assertSee('Gaming Identity');
        $response->assertSee('PUBG Mobile');
        $response->assertSee('Mobile Legends');
    }

    public function test_guest_cannot_access_dashboard(): void
    {
        $response = $this->get(route('dashboard'));

        $response->assertRedirect(route('login'));
    }

    public function test_authenticated_user_can_access_dashboard(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get(route('dashboard'));

        $response->assertStatus(200);
        $response->assertSee('Dashboard');
    }

    public function test_user_can_create_pubg_card(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post(route('cards.store'), [
            'game_type' => 'pubg',
            'nickname' => 'SniperKing',
            'player_id' => '5123456789',
            'rank' => 'Ace',
            'favorite_weapon' => 'AWM',
            'kd_ratio' => '4.85',
            'win_rate' => '32.5%',
            'template' => 'futuristic',
            'color_scheme' => 'purple',
            'is_public' => '1',
        ]);

        $response->assertRedirect(route('dashboard'));

        $this->assertDatabaseHas('gaming_cards', [
            'user_id' => $user->id,
            'game_type' => 'pubg',
            'nickname' => 'SniperKing',
            'player_id' => '5123456789',
            'favorite_weapon' => 'AWM',
            'is_public' => true,
        ]);
    }

    public function test_user_can_create_mlbb_card(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post(route('cards.store'), [
            'game_type' => 'mlbb',
            'nickname' => 'MythicCarry',
            'player_id' => '987654321',
            'server_id' => '8201',
            'rank' => 'Mythic',
            'favorite_hero' => 'Lancelot',
            'win_rate' => '68.4%',
            'template' => 'minimal',
            'color_scheme' => 'gold',
            'is_public' => '0',
        ]);

        $response->assertRedirect(route('dashboard'));

        $this->assertDatabaseHas('gaming_cards', [
            'user_id' => $user->id,
            'game_type' => 'mlbb',
            'nickname' => 'MythicCarry',
            'player_id' => '987654321',
            'server_id' => '8201',
            'favorite_hero' => 'Lancelot',
            'is_public' => false,
        ]);
    }

    public function test_user_can_view_own_card(): void
    {
        $user = User::factory()->create();
        $card = GamingCard::factory()->pubg()->create(['user_id' => $user->id]);

        $response = $this->actingAs($user)->get(route('cards.show', $card));

        $response->assertStatus(200);
        $response->assertSee($card->nickname);
        $response->assertSee($card->favorite_weapon);
    }

    public function test_user_cannot_view_another_users_card_via_cards_route(): void
    {
        $user1 = User::factory()->create();
        $user2 = User::factory()->create();
        $card = GamingCard::factory()->create(['user_id' => $user1->id]);

        $response = $this->actingAs($user2)->get(route('cards.show', $card));

        $response->assertStatus(403);
    }

    public function test_user_can_update_own_card(): void
    {
        $user = User::factory()->create();
        $card = GamingCard::factory()->pubg()->create(['user_id' => $user->id]);

        $response = $this->actingAs($user)->put(route('cards.update', $card), [
            'nickname' => 'UpdatedNick',
            'player_id' => '999888777',
            'rank' => 'Conqueror',
            'favorite_weapon' => 'M416',
            'kd_ratio' => '6.00',
            'win_rate' => '40.0%',
            'template' => 'default',
            'color_scheme' => 'red',
            'is_public' => '1',
        ]);

        $response->assertRedirect(route('cards.show', $card));

        $card->refresh();
        $this->assertSame('UpdatedNick', $card->nickname);
        $this->assertSame('Conqueror', $card->rank);
        $this->assertTrue($card->is_public);
    }

    public function test_user_cannot_update_another_users_card(): void
    {
        $user1 = User::factory()->create();
        $user2 = User::factory()->create();
        $card = GamingCard::factory()->pubg()->create(['user_id' => $user1->id]);

        $response = $this->actingAs($user2)->put(route('cards.update', $card), [
            'nickname' => 'HackedNick',
            'player_id' => '000000',
            'rank' => 'Bronze',
            'favorite_weapon' => 'Pan',
            'template' => 'default',
            'color_scheme' => 'blue',
        ]);

        $response->assertStatus(403);
    }

    public function test_user_can_delete_own_card(): void
    {
        $user = User::factory()->create();
        $card = GamingCard::factory()->create(['user_id' => $user->id]);

        $response = $this->actingAs($user)->delete(route('cards.destroy', $card));

        $response->assertRedirect(route('dashboard'));
        $this->assertModelMissing($card);
    }

    public function test_user_cannot_delete_another_users_card(): void
    {
        $user1 = User::factory()->create();
        $user2 = User::factory()->create();
        $card = GamingCard::factory()->create(['user_id' => $user1->id]);

        $response = $this->actingAs($user2)->delete(route('cards.destroy', $card));

        $response->assertStatus(403);
        $this->assertModelExists($card);
    }

    public function test_live_preview_endpoint_returns_json(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->postJson(route('cards.preview'), [
            'game_type' => 'pubg',
            'nickname' => 'LiveGamer',
            'player_id' => '123456789',
            'rank' => 'Crown',
            'favorite_weapon' => 'AKM',
            'template' => 'futuristic',
            'color_scheme' => 'green',
        ]);

        $response->assertStatus(200);
        $response->assertJsonPath('success', true);
        $response->assertJsonPath('data.nickname', 'LiveGamer');
    }
}
