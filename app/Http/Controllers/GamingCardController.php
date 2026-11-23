<?php

namespace App\Http\Controllers;

use App\Models\GamingCard;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class GamingCardController extends Controller
{
    /**
     * Show the form for creating a new gaming card.
     */
    public function create(Request $request): View
    {
        $gameType = $request->query('game', 'pubg');

        if (! in_array($gameType, ['pubg', 'mlbb'])) {
            $gameType = 'pubg';
        }

        return view('cards.create', compact('gameType'));
    }

    /**
     * Store a newly created gaming card.
     */
    public function store(Request $request): RedirectResponse
    {
        $rules = [
            'game_type' => ['required', 'in:pubg,mlbb'],
            'nickname' => ['required', 'string', 'max:50'],
            'player_id' => ['required', 'string', 'max:30'],
            'rank' => ['required', 'string', 'max:30'],
            'template' => ['required', 'string', 'in:default,minimal,futuristic'],
            'color_scheme' => ['required', 'string', 'in:blue,purple,red,green,gold'],
            'win_rate' => ['nullable', 'string', 'max:10'],
            'is_public' => ['nullable', 'boolean'],
        ];

        if ($request->input('game_type') === 'pubg') {
            $rules['favorite_weapon'] = ['required', 'string', 'max:30'];
            $rules['kd_ratio'] = ['nullable', 'string', 'max:10'];
        } else {
            $rules['server_id'] = ['required', 'string', 'max:10'];
            $rules['favorite_hero'] = ['required', 'string', 'max:30'];
        }

        $validated = $request->validate($rules);
        $validated['is_public'] = $request->boolean('is_public');

        $request->user()->gamingCards()->create($validated);

        return redirect()->route('dashboard')->with('success', 'Gaming card created successfully!');
    }

    /**
     * Show a gaming card.
     */
    public function show(Request $request, GamingCard $card): View
    {
        $this->authorizeCard($request, $card);

        return view('cards.show', compact('card'));
    }

    /**
     * Show the form for editing a gaming card.
     */
    public function edit(Request $request, GamingCard $card): View
    {
        $this->authorizeCard($request, $card);

        return view('cards.edit', compact('card'));
    }

    /**
     * Update a gaming card.
     */
    public function update(Request $request, GamingCard $card): RedirectResponse
    {
        $this->authorizeCard($request, $card);

        $rules = [
            'nickname' => ['required', 'string', 'max:50'],
            'player_id' => ['required', 'string', 'max:30'],
            'rank' => ['required', 'string', 'max:30'],
            'template' => ['required', 'string', 'in:default,minimal,futuristic'],
            'color_scheme' => ['required', 'string', 'in:blue,purple,red,green,gold'],
            'win_rate' => ['nullable', 'string', 'max:10'],
            'is_public' => ['nullable', 'boolean'],
        ];

        if ($card->isPubg()) {
            $rules['favorite_weapon'] = ['required', 'string', 'max:30'];
            $rules['kd_ratio'] = ['nullable', 'string', 'max:10'];
        } else {
            $rules['server_id'] = ['required', 'string', 'max:10'];
            $rules['favorite_hero'] = ['required', 'string', 'max:30'];
        }

        $validated = $request->validate($rules);
        $validated['is_public'] = $request->boolean('is_public');

        $card->update($validated);

        return redirect()->route('cards.show', $card)->with('success', 'Gaming card updated successfully!');
    }

    /**
     * Delete a gaming card.
     */
    public function destroy(Request $request, GamingCard $card): RedirectResponse
    {
        $this->authorizeCard($request, $card);

        $card->delete();

        return redirect()->route('dashboard')->with('success', 'Gaming card deleted successfully.');
    }

    /**
     * Return card data as JSON for live preview.
     */
    public function preview(Request $request): JsonResponse
    {
        $data = $request->validate([
            'game_type' => ['required', 'in:pubg,mlbb'],
            'nickname' => ['nullable', 'string', 'max:50'],
            'player_id' => ['nullable', 'string', 'max:30'],
            'server_id' => ['nullable', 'string', 'max:10'],
            'rank' => ['nullable', 'string', 'max:30'],
            'favorite_weapon' => ['nullable', 'string', 'max:30'],
            'favorite_hero' => ['nullable', 'string', 'max:30'],
            'kd_ratio' => ['nullable', 'string', 'max:10'],
            'win_rate' => ['nullable', 'string', 'max:10'],
            'template' => ['nullable', 'string', 'in:default,minimal,futuristic'],
            'color_scheme' => ['nullable', 'string', 'in:blue,purple,red,green,gold'],
        ]);

        return response()->json(['success' => true, 'data' => $data]);
    }

    /**
     * Toggle card visibility (public/private).
     */
    public function toggleVisibility(Request $request, GamingCard $card): RedirectResponse
    {
        $this->authorizeCard($request, $card);

        $card->update(['is_public' => ! $card->is_public]);

        $status = $card->is_public ? 'public' : 'private';

        return back()->with('success', "Card is now {$status}.");
    }

    /**
     * Ensure the authenticated user owns the card.
     */
    private function authorizeCard(Request $request, GamingCard $card): void
    {
        if ($card->user_id !== $request->user()->id) {
            abort(403, 'You do not own this card.');
        }
    }
}
