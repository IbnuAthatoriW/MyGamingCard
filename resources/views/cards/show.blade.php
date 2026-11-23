@extends('layouts.app')
@section('title', $card->nickname . ' - MyGamingCard')

@push('styles')
@include('cards.partials.card-styles')
<style>
    .show-layout { display: grid; grid-template-columns: 420px 1fr; gap: 2rem; align-items: start; }
    @media (max-width: 900px) { .show-layout { grid-template-columns: 1fr; } }
    .card-display { display: flex; flex-direction: column; align-items: center; gap: 1.5rem; }
    .card-actions-panel { display: flex; flex-direction: column; gap: 1rem; }
    .detail-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 0.75rem; }
    .detail-item {
        padding: 0.75rem; border-radius: var(--radius-sm);
        background: rgba(10,14,39,0.4); border: 1px solid rgba(255,255,255,0.03);
    }
    .detail-label { font-size: 0.65rem; text-transform: uppercase; letter-spacing: 1px; color: var(--text-dim); }
    .detail-value { font-size: 0.95rem; font-weight: 600; margin-top: 0.1rem; }
    .share-box {
        display: flex; gap: 0.5rem; align-items: center;
        background: rgba(10,14,39,0.6); border: 1px solid var(--border);
        border-radius: var(--radius-sm); padding: 0.5rem;
    }
    .share-url {
        flex: 1; padding: 0.5rem; background: none; border: none;
        color: var(--text); font-size: 0.8rem; font-family: monospace;
        outline: none;
    }
    .copy-btn { white-space: nowrap; }
</style>
@endpush

@section('content')
    <div class="page-header fade-in">
        <div style="display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:1rem;">
            <div>
                <h1 class="page-title">{{ $card->nickname }}</h1>
                <p class="page-subtitle">
                    <span class="badge badge-{{ $card->game_type }}">{{ strtoupper($card->game_type) }}</span>
                    <span class="badge badge-{{ $card->is_public ? 'public' : 'private' }}">
                        {{ $card->is_public ? __('Public') : __('Private') }}
                    </span>
                </p>
            </div>
            <div style="display:flex; gap:0.5rem;">
                <a href="{{ route('cards.edit', $card) }}" class="btn btn-secondary btn-sm">✏️ {{ __('Edit') }}</a>
                <a href="{{ route('dashboard') }}" class="btn btn-ghost btn-sm">← {{ __('Cancel') }}</a>
            </div>
        </div>
    </div>

    <div class="show-layout fade-in-delay">
        <!-- Card Display -->
        <div class="card-display">
            @include('cards.partials.card-template', [
                'data' => [
                    'game_type' => $card->game_type,
                    'nickname' => $card->nickname,
                    'player_id' => $card->player_id,
                    'server_id' => $card->server_id,
                    'rank' => $card->rank,
                    'favorite_weapon' => $card->favorite_weapon,
                    'favorite_hero' => $card->favorite_hero,
                    'kd_ratio' => $card->kd_ratio,
                    'win_rate' => $card->win_rate,
                    'template' => $card->template,
                    'color_scheme' => $card->color_scheme,
                ],
                'cardId' => 'display-card'
            ])
            <button class="btn btn-primary" onclick="downloadCard()" id="downloadBtn">
                📥 {{ __('Download as PNG') }}
            </button>
        </div>

        <!-- Details & Actions -->
        <div class="card-actions-panel">
            <!-- Card Details -->
            <div class="card">
                <div class="card-header">
                    <h3 style="font-size:1rem; font-weight:600;">{{ __('Card Details') }}</h3>
                </div>
                <div class="card-body">
                    <div class="detail-grid">
                        <div class="detail-item">
                            <div class="detail-label">{{ __('Nickname') }}</div>
                            <div class="detail-value">{{ $card->nickname }}</div>
                        </div>
                        <div class="detail-item">
                            <div class="detail-label">{{ __('Player ID') }}</div>
                            <div class="detail-value">{{ $card->player_id }}</div>
                        </div>
                        @if($card->isMlbb() && $card->server_id)
                        <div class="detail-item">
                            <div class="detail-label">{{ __('Server ID') }}</div>
                            <div class="detail-value">{{ $card->server_id }}</div>
                        </div>
                        @endif
                        <div class="detail-item">
                            <div class="detail-label">{{ __('Rank') }}</div>
                            <div class="detail-value">{{ $card->rank }}</div>
                        </div>
                        @if($card->isPubg() && $card->favorite_weapon)
                        <div class="detail-item">
                            <div class="detail-label">{{ __('Favorite Weapon') }}</div>
                            <div class="detail-value">{{ $card->favorite_weapon }}</div>
                        </div>
                        @endif
                        @if($card->isMlbb() && $card->favorite_hero)
                        <div class="detail-item">
                            <div class="detail-label">{{ __('Favorite Hero') }}</div>
                            <div class="detail-value">{{ $card->favorite_hero }}</div>
                        </div>
                        @endif
                        @if($card->kd_ratio)
                        <div class="detail-item">
                            <div class="detail-label">{{ __('K/D Ratio') }}</div>
                            <div class="detail-value">{{ $card->kd_ratio }}</div>
                        </div>
                        @endif
                        @if($card->win_rate)
                        <div class="detail-item">
                            <div class="detail-label">{{ __('Win Rate') }}</div>
                            <div class="detail-value">{{ $card->win_rate }}</div>
                        </div>
                        @endif
                        <div class="detail-item">
                            <div class="detail-label">{{ __('Template') }}</div>
                            <div class="detail-value" style="text-transform:capitalize;">{{ $card->template }}</div>
                        </div>
                        <div class="detail-item">
                            <div class="detail-label">{{ __('Color Scheme') }}</div>
                            <div class="detail-value" style="text-transform:capitalize;">{{ $card->color_scheme }}</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Share & Visibility -->
            <div class="card">
                <div class="card-header">
                    <h3 style="font-size:1rem; font-weight:600;">{{ __('Sharing') }}</h3>
                </div>
                <div class="card-body">
                    <!-- Toggle visibility -->
                    <form method="POST" action="{{ route('cards.visibility', $card) }}" style="margin-bottom:1rem;">
                        @csrf @method('PATCH')
                        <button type="submit" class="btn {{ $card->is_public ? 'btn-success' : 'btn-secondary' }} btn-sm" style="width:100%; justify-content:center;">
                            {{ $card->is_public ? '🌐 ' . __('Public') . ' — Click to toggle' : '🔒 ' . __('Private') . ' — Click to toggle' }}
                        </button>
                    </form>

                    @if($card->is_public)
                    <label class="form-label">{{ __('Share Link') }}</label>
                    <div class="share-box">
                        <input type="text" class="share-url" value="{{ route('card.share', $card->share_slug) }}" readonly id="shareUrl">
                        <button class="btn btn-primary btn-sm copy-btn" onclick="copyShareLink()">{{ __('Copy') }}</button>
                    </div>
                    @else
                    <p style="font-size:0.85rem; color:var(--text-dim);">
                        {{ __('Make your card public to get a shareable link.') }}
                    </p>
                    @endif
                </div>
            </div>

            <!-- Danger Zone -->
            <div class="card" style="border-color: rgba(255,107,107,0.2);">
                <div class="card-body">
                    <form method="POST" action="{{ route('cards.destroy', $card) }}" onsubmit="return confirm('{{ __('Delete This Card') }}?')">
                        @csrf @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm" style="width:100%; justify-content:center;">
                            🗑️ {{ __('Delete This Card') }}
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
<script>
function downloadCard() {
    const card = document.getElementById('display-card');
    const btn = document.getElementById('downloadBtn');
    btn.textContent = '⏳ Generating...';
    btn.disabled = true;

    html2canvas(card, {
        backgroundColor: null,
        scale: 2,
        useCORS: true,
        logging: false,
    }).then(canvas => {
        const link = document.createElement('a');
        link.download = '{{ $card->nickname }}-{{ $card->game_type }}-card.png';
        link.href = canvas.toDataURL('image/png');
        link.click();
        btn.textContent = '📥 {{ __("Download as PNG") }}';
        btn.disabled = false;
    }).catch(err => {
        console.error('Download error:', err);
        btn.textContent = '📥 {{ __("Download as PNG") }}';
        btn.disabled = false;
        alert('Failed to generate image. Please try again.');
    });
}

function copyShareLink() {
    const url = document.getElementById('shareUrl');
    url.select();
    navigator.clipboard.writeText(url.value).then(() => {
        const btn = document.querySelector('.copy-btn');
        btn.textContent = '{{ __("Copied!") }}';
        setTimeout(() => { btn.textContent = '{{ __("Copy") }}'; }, 2000);
    });
}
</script>
@endpush
