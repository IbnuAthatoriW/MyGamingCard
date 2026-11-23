<?php

namespace App\Http\Controllers;

use App\Models\GamingCard;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\Response;

class ShareController extends Controller
{
    /**
     * Show a publicly shared gaming card.
     */
    public function show(string $slug): View|Response
    {
        $card = GamingCard::where('share_slug', $slug)->firstOrFail();

        if (! $card->is_public) {
            abort(404);
        }

        return view('cards.share', compact('card'));
    }
}
