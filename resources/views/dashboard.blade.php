@extends('layouts.app')
@section('title', __('Dashboard') . ' - MyGamingCard')

@push('styles')
<style>
    .dashboard-stats {
        display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 1rem; margin-bottom: 2rem;
    }
    .stat-card {
        padding: 1.25rem; border-radius: var(--radius);
        background: var(--card-bg); border: 1px solid var(--border);
        display: flex; align-items: center; gap: 1rem;
    }
    .stat-icon { font-size: 2rem; }
    .stat-value { font-size: 1.5rem; font-weight: 700; font-family: 'Orbitron', monospace; }
    .stat-label { font-size: 0.8rem; color: var(--text-muted); }
    .cards-header {
        display: flex; justify-content: space-between; align-items: center;
        margin-bottom: 1.5rem; flex-wrap: wrap; gap: 1rem;
    }
    .cards-grid {
        display: grid; grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
        gap: 1.5rem;
    }
    .gaming-card-item {
        border-radius: var(--radius-lg); overflow: hidden;
        border: 1px solid var(--border);
        transition: all var(--transition); position: relative;
    }
    .gaming-card-item:hover {
        border-color: rgba(108, 92, 231, 0.4);
        transform: translateY(-4px);
        box-shadow: 0 8px 30px rgba(0,0,0,0.3);
    }
    .gaming-card-item-pubg { background: linear-gradient(145deg, rgba(255,165,0,0.06), var(--navy-light)); }
    .gaming-card-item-mlbb { background: linear-gradient(145deg, rgba(0,206,201,0.06), var(--navy-light)); }
    .gaming-card-content { padding: 1.5rem; }
    .gaming-card-top { display: flex; justify-content: space-between; align-items: start; margin-bottom: 1rem; }
    .gaming-card-nickname {
        font-family: 'Orbitron', monospace; font-size: 1.15rem;
        font-weight: 700; margin-bottom: 0.15rem;
    }
    .gaming-card-pid { font-size: 0.8rem; color: var(--text-muted); }
    .gaming-card-info { display: grid; grid-template-columns: 1fr 1fr; gap: 0.5rem; margin-bottom: 1.25rem; }
    .gaming-card-info-label { font-size: 0.65rem; text-transform: uppercase; letter-spacing: 1px; color: var(--text-dim); }
    .gaming-card-info-value { font-size: 0.85rem; font-weight: 600; }
    .gaming-card-actions { display: flex; gap: 0.5rem; flex-wrap: wrap; }
    .empty-state {
        text-align: center; padding: 4rem 2rem;
        background: var(--card-bg); border: 1px dashed var(--border);
        border-radius: var(--radius-lg);
    }
    .empty-state-icon { font-size: 3rem; margin-bottom: 1rem; }
    .empty-state-title { font-size: 1.1rem; font-weight: 600; margin-bottom: 0.5rem; }
    .empty-state-desc { color: var(--text-muted); font-size: 0.9rem; margin-bottom: 1.5rem; }
</style>
@endpush

@section('content')
    <div class="page-header fade-in">
        <h1 class="page-title">{{ __('Dashboard') }}</h1>
        <p class="page-subtitle">{{ __('Manage your gaming identity cards') }}</p>
    </div>

    <!-- Stats -->
    <div class="dashboard-stats fade-in">
        <div class="stat-card">
            <div class="stat-icon">🃏</div>
            <div>
                <div class="stat-value">{{ $cards->count() }}</div>
                <div class="stat-label">{{ __('Total Cards') }}</div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon">🔫</div>
            <div>
                <div class="stat-value">{{ $cards->where('game_type', 'pubg')->count() }}</div>
                <div class="stat-label">{{ __('PUBG Cards') }}</div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon">⚔️</div>
            <div>
                <div class="stat-value">{{ $cards->where('game_type', 'mlbb')->count() }}</div>
                <div class="stat-label">{{ __('MLBB Cards') }}</div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon">🌐</div>
            <div>
                <div class="stat-value">{{ $cards->where('is_public', true)->count() }}</div>
                <div class="stat-label">{{ __('Public Cards') }}</div>
            </div>
        </div>
    </div>

    <!-- Cards -->
    <div class="cards-header fade-in-delay">
        <h2 style="font-size:1.2rem; font-weight:600;">{{ __('Your Cards') }}</h2>
        <div style="display:flex; gap:0.5rem;">
            <a href="{{ route('cards.create', ['game' => 'pubg']) }}" class="btn btn-primary btn-sm">+ PUBG Card</a>
            <a href="{{ route('cards.create', ['game' => 'mlbb']) }}" class="btn btn-primary btn-sm">+ MLBB Card</a>
        </div>
    </div>

    @if($cards->isEmpty())
        <div class="empty-state fade-in-delay">
            <div class="empty-state-icon">🎮</div>
            <div class="empty-state-title">{{ __('No cards yet') }}</div>
            <div class="empty-state-desc">{{ __('Create your first gaming identity card to get started.') }}</div>
            <a href="{{ route('cards.create') }}" class="btn btn-primary">{{ __('Create Your First Card') }}</a>
        </div>
    @else
        <div class="cards-grid fade-in-delay">
            @foreach($cards as $card)
                <div class="gaming-card-item gaming-card-item-{{ $card->game_type }}">
                    <div class="gaming-card-content">
                        <div class="gaming-card-top">
                            <div>
                                <div class="gaming-card-nickname">{{ $card->nickname }}</div>
                                <div class="gaming-card-pid">
                                    ID: {{ $card->player_id }}
                                    @if($card->isMlbb() && $card->server_id)
                                        ({{ $card->server_id }})
                                    @endif
                                </div>
                            </div>
                            <div style="display:flex; gap:0.4rem;">
                                <span class="badge badge-{{ $card->game_type }}">{{ strtoupper($card->game_type) }}</span>
                                <span class="badge badge-{{ $card->is_public ? 'public' : 'private' }}">
                                    {{ $card->is_public ? __('Public') : __('Private') }}
                                </span>
                            </div>
                        </div>
                        <div class="gaming-card-info">
                            <div>
                                <div class="gaming-card-info-label">{{ __('Rank') }}</div>
                                <div class="gaming-card-info-value">{{ $card->rank }}</div>
                            </div>
                            @if($card->isPubg())
                                <div>
                                    <div class="gaming-card-info-label">{{ __('Favorite Weapon') }}</div>
                                    <div class="gaming-card-info-value">{{ $card->favorite_weapon }}</div>
                                </div>
                                @if($card->kd_ratio)
                                <div>
                                    <div class="gaming-card-info-label">{{ __('K/D Ratio') }}</div>
                                    <div class="gaming-card-info-value">{{ $card->kd_ratio }}</div>
                                </div>
                                @endif
                            @else
                                <div>
                                    <div class="gaming-card-info-label">{{ __('Favorite Hero') }}</div>
                                    <div class="gaming-card-info-value">{{ $card->favorite_hero }}</div>
                                </div>
                            @endif
                            @if($card->win_rate)
                            <div>
                                <div class="gaming-card-info-label">{{ __('Win Rate') }}</div>
                                <div class="gaming-card-info-value">{{ $card->win_rate }}</div>
                            </div>
                            @endif
                        </div>
                        <div class="gaming-card-actions">
                            <a href="{{ route('cards.show', $card) }}" class="btn btn-secondary btn-sm">{{ __('View') }}</a>
                            <a href="{{ route('cards.edit', $card) }}" class="btn btn-secondary btn-sm">{{ __('Edit') }}</a>
                            <form method="POST" action="{{ route('cards.destroy', $card) }}" onsubmit="return confirm('{{ __('Delete This Card') }}?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">{{ __('Delete') }}</button>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
@endsection
