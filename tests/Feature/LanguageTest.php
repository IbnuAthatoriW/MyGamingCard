<?php

namespace Tests\Feature;

use Tests\TestCase;

class LanguageTest extends TestCase
{
    public function test_user_can_switch_language_to_indonesian(): void
    {
        $response = $this->get(route('lang.switch', 'id'));

        $response->assertRedirect();
        $response->assertSessionHas('locale', 'id');
    }

    public function test_user_can_switch_language_to_english(): void
    {
        $response = $this->get(route('lang.switch', 'en'));

        $response->assertRedirect();
        $response->assertSessionHas('locale', 'en');
    }

    public function test_invalid_language_is_ignored(): void
    {
        $response = $this->get(route('lang.switch', 'es'));

        $response->assertRedirect();
        $response->assertSessionMissing('locale');
    }

    public function test_page_renders_in_selected_language(): void
    {
        // Visit with session locale = 'id'
        $response = $this->withSession(['locale' => 'id'])->get(route('home'));

        $response->assertStatus(200);
        $response->assertSee('Ciptakan Identitas');
        $response->assertSee('Untuk Gamers, Oleh Gamers');

        // Visit with session locale = 'en'
        $response = $this->withSession(['locale' => 'en'])->get(route('home'));

        $response->assertStatus(200);
        $response->assertSee('Create Your Gaming Identity');
        $response->assertSee('For Gamers, By Gamers');
    }
}
