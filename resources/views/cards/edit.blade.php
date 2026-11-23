@extends('layouts.app')
@section('title', 'Edit ' . $card->nickname . ' - MyGamingCard')

@push('styles')
@include('cards.partials.card-styles')
<style>
    .create-layout { display: grid; grid-template-columns: 1fr 420px; gap: 2rem; align-items: start; }
    @media (max-width: 900px) { .create-layout { grid-template-columns: 1fr; } }
    .preview-panel {
        position: sticky; top: 5.5rem;
        background: var(--card-bg); border: 1px solid var(--border);
        border-radius: var(--radius-lg); padding: 1.5rem;
    }
    .preview-label {
        font-size: 0.75rem; text-transform: uppercase; letter-spacing: 2px;
        color: var(--text-dim); margin-bottom: 1rem; font-weight: 600;
    }
    .template-options { display: flex; gap: 0.5rem; flex-wrap: wrap; }
    .template-option {
        padding: 0.5rem 1rem; border-radius: var(--radius-sm);
        border: 1px solid var(--border); background: rgba(10,14,39,0.6);
        color: var(--text-muted); font-size: 0.8rem; font-weight: 500;
        cursor: pointer; transition: all var(--transition);
    }
    .template-option:hover { border-color: rgba(108,92,231,0.4); }
    .template-option.active { border-color: var(--purple); color: var(--purple-light); background: rgba(108,92,231,0.1); }
    .color-options { display: flex; gap: 0.5rem; }
    .color-option {
        width: 32px; height: 32px; border-radius: 50%; cursor: pointer;
        border: 2px solid transparent; transition: all var(--transition);
    }
    .color-option:hover { transform: scale(1.15); }
    .color-option.active { border-color: #fff; box-shadow: 0 0 10px rgba(255,255,255,0.3); }
    .color-blue { background: #0984e3; }
    .color-purple { background: #6c5ce7; }
    .color-red { background: #d63031; }
    .color-green { background: #00b894; }
    .color-gold { background: #d4a017; }
    .form-row { display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; }
    @media (max-width: 600px) { .form-row { grid-template-columns: 1fr; } }
</style>
@endpush

@section('content')
    <div class="page-header fade-in">
        <div style="display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:1rem;">
            <div>
                <h1 class="page-title">Edit Card</h1>
                <p class="page-subtitle">Update your {{ $card->isPubg() ? 'PUBG Mobile' : 'Mobile Legends' }} card</p>
            </div>
            <a href="{{ route('cards.show', $card) }}" class="btn btn-ghost btn-sm">← Back to Card</a>
        </div>
    </div>

    <div class="create-layout fade-in-delay">
        <!-- Form -->
        <div class="card">
            <div class="card-body">
                <form method="POST" action="{{ route('cards.update', $card) }}" id="cardForm">
                    @csrf @method('PUT')
                    <input type="hidden" name="template" id="templateInput" value="{{ old('template', $card->template) }}">
                    <input type="hidden" name="color_scheme" id="colorInput" value="{{ old('color_scheme', $card->color_scheme) }}">

                    <div class="form-row">
                        <div class="form-group">
                            <label class="form-label">Nickname</label>
                            <input type="text" name="nickname" class="form-input preview-field" data-field="nickname" value="{{ old('nickname', $card->nickname) }}" required>
                            @error('nickname')<div class="form-error">{{ $message }}</div>@enderror
                        </div>
                        <div class="form-group">
                            <label class="form-label">Player ID</label>
                            <input type="text" name="player_id" class="form-input preview-field" data-field="player_id" value="{{ old('player_id', $card->player_id) }}" required>
                            @error('player_id')<div class="form-error">{{ $message }}</div>@enderror
                        </div>
                    </div>

                    @if($card->isMlbb())
                    <div class="form-group">
                        <label class="form-label">Server ID</label>
                        <input type="text" name="server_id" class="form-input preview-field" data-field="server_id" value="{{ old('server_id', $card->server_id) }}" required>
                        @error('server_id')<div class="form-error">{{ $message }}</div>@enderror
                    </div>
                    @endif

                    <div class="form-group">
                        <label class="form-label">Rank</label>
                        <select name="rank" class="form-input preview-field" data-field="rank" required>
                            @if($card->isPubg())
                                @foreach(['Bronze', 'Silver', 'Gold', 'Platinum', 'Diamond', 'Crown', 'Ace', 'Ace Master', 'Ace Dominator', 'Conqueror'] as $r)
                                    <option value="{{ $r }}" {{ old('rank', $card->rank) === $r ? 'selected' : '' }}>{{ $r }}</option>
                                @endforeach
                            @else
                                @foreach(['Warrior', 'Elite', 'Master', 'Grandmaster', 'Epic', 'Legend', 'Mythic', 'Mythical Honor', 'Mythical Glory', 'Immortal'] as $r)
                                    <option value="{{ $r }}" {{ old('rank', $card->rank) === $r ? 'selected' : '' }}>{{ $r }}</option>
                                @endforeach
                            @endif
                        </select>
                        @error('rank')<div class="form-error">{{ $message }}</div>@enderror
                    </div>

                    @if($card->isPubg())
                    <div class="form-group">
                        <label class="form-label">Favorite Weapon</label>
                        <select name="favorite_weapon" class="form-input preview-field" data-field="favorite_weapon" required>
                            @foreach(['M416', 'AKM', 'M762', 'SCAR-L', 'DP-28', 'AWM', 'Kar98k', 'Mini14', 'SKS', 'M24', 'Groza', 'UZI', 'Vector', 'UMP45', 'Pan'] as $w)
                                <option value="{{ $w }}" {{ old('favorite_weapon', $card->favorite_weapon) === $w ? 'selected' : '' }}>{{ $w }}</option>
                            @endforeach
                        </select>
                        @error('favorite_weapon')<div class="form-error">{{ $message }}</div>@enderror
                    </div>
                    <div class="form-group">
                        <label class="form-label">K/D Ratio <span style="color:var(--text-dim)">(optional)</span></label>
                        <input type="text" name="kd_ratio" class="form-input preview-field" data-field="kd_ratio" value="{{ old('kd_ratio', $card->kd_ratio) }}" placeholder="e.g. 3.50">
                        @error('kd_ratio')<div class="form-error">{{ $message }}</div>@enderror
                    </div>
                    @else
                    <div class="form-group">
                        <label class="form-label">Favorite Hero</label>
                        <select name="favorite_hero" class="form-input preview-field" data-field="favorite_hero" required>
                            @foreach(['Lancelot', 'Fanny', 'Chou', 'Ling', 'Gusion', 'Hayabusa', 'Benedetta', 'Paquito', 'Esmeralda', 'Kagura', 'Lunox', 'Pharsa', 'Wanwan', 'Beatrix', 'Brody', 'Claude', 'Granger', 'Lesley', 'Moskov', 'Roger', 'Alucard', 'Freya', 'Zilong', 'Aldous', 'Argus', 'Dyrroth', 'Sun', 'Yu Zhong', 'Tigreal', 'Franco', 'Khufra', 'Atlas', 'Hylos', 'Minotaur', 'Rafaela', 'Angela', 'Estes', 'Floryn', 'Mathilda', 'Carmilla', 'Diggie', 'Nana'] as $h)
                                <option value="{{ $h }}" {{ old('favorite_hero', $card->favorite_hero) === $h ? 'selected' : '' }}>{{ $h }}</option>
                            @endforeach
                        </select>
                        @error('favorite_hero')<div class="form-error">{{ $message }}</div>@enderror
                    </div>
                    @endif

                    <div class="form-group">
                        <label class="form-label">Win Rate <span style="color:var(--text-dim)">(optional)</span></label>
                        <input type="text" name="win_rate" class="form-input preview-field" data-field="win_rate" value="{{ old('win_rate', $card->win_rate) }}" placeholder="e.g. 65.2%">
                        @error('win_rate')<div class="form-error">{{ $message }}</div>@enderror
                    </div>

                    <!-- Template -->
                    <div class="form-group">
                        <label class="form-label">Template</label>
                        <div class="template-options">
                            @foreach(['default', 'minimal', 'futuristic'] as $t)
                            <button type="button" class="template-option {{ old('template', $card->template) === $t ? 'active' : '' }}" data-template="{{ $t }}">{{ ucfirst($t) }}</button>
                            @endforeach
                        </div>
                    </div>

                    <!-- Color -->
                    <div class="form-group">
                        <label class="form-label">Color Scheme</label>
                        <div class="color-options">
                            @foreach(['blue', 'purple', 'red', 'green', 'gold'] as $color)
                            <button type="button" class="color-option color-{{ $color }} {{ old('color_scheme', $card->color_scheme) === $color ? 'active' : '' }}" data-color="{{ $color }}" title="{{ ucfirst($color) }}"></button>
                            @endforeach
                        </div>
                    </div>

                    <!-- Visibility -->
                    <div class="form-group">
                        <label class="form-check">
                            <input type="checkbox" name="is_public" value="1" {{ old('is_public', $card->is_public) ? 'checked' : '' }}>
                            <span style="font-size:0.85rem;">Make this card public</span>
                        </label>
                    </div>

                    <div style="display:flex; gap:0.75rem;">
                        <button type="submit" class="btn btn-primary" style="flex:1; justify-content:center;">Save Changes</button>
                        <a href="{{ route('cards.show', $card) }}" class="btn btn-secondary">Cancel</a>
                    </div>
                </form>
            </div>
        </div>

        <!-- Preview -->
        <div class="preview-panel">
            <div class="preview-label">Live Preview</div>
            <div id="previewContainer">
                @include('cards.partials.card-template', [
                    'data' => [
                        'game_type' => $card->game_type,
                        'nickname' => old('nickname', $card->nickname),
                        'player_id' => old('player_id', $card->player_id),
                        'server_id' => old('server_id', $card->server_id),
                        'rank' => old('rank', $card->rank),
                        'favorite_weapon' => old('favorite_weapon', $card->favorite_weapon),
                        'favorite_hero' => old('favorite_hero', $card->favorite_hero),
                        'kd_ratio' => old('kd_ratio', $card->kd_ratio),
                        'win_rate' => old('win_rate', $card->win_rate),
                        'template' => old('template', $card->template),
                        'color_scheme' => old('color_scheme', $card->color_scheme),
                    ],
                    'cardId' => 'preview-card'
                ])
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const gameType = '{{ $card->game_type }}';
    const colorMap = {
        blue: ['#0984e3', '#74b9ff', 'rgba(9,132,227,0.15)'],
        purple: ['#6c5ce7', '#a29bfe', 'rgba(108,92,231,0.15)'],
        red: ['#d63031', '#ff7675', 'rgba(214,48,49,0.15)'],
        green: ['#00b894', '#55efc4', 'rgba(0,184,148,0.15)'],
        gold: ['#d4a017', '#f9ca24', 'rgba(212,160,23,0.15)'],
    };

    function getFormData() {
        const data = { game_type: gameType };
        document.querySelectorAll('.preview-field').forEach(field => {
            data[field.dataset.field] = field.value;
        });
        data.template = document.getElementById('templateInput').value;
        data.color_scheme = document.getElementById('colorInput').value;
        return data;
    }

    function updateCardDOM(data) {
        const card = document.getElementById('preview-card');
        if (!card) return;
        const template = data.template || 'default';
        const isPubg = data.game_type === 'pubg';
        const nickname = data.nickname || 'YourName';
        const playerId = data.player_id || '000000000';
        const serverId = data.server_id || '';
        const rank = data.rank || 'Unranked';
        const weapon = data.favorite_weapon || '-';
        const hero = data.favorite_hero || '-';
        const kd = data.kd_ratio || '';
        const wr = data.win_rate || '';
        const gameLabel = isPubg ? 'PUBG MOBILE' : 'MOBILE LEGENDS';
        const gameColor = isPubg ? '#ffa500' : '#00cec9';
        const c = colorMap[data.color_scheme] || colorMap.blue;

        card.style.setProperty('--gc-primary', c[0]);
        card.style.setProperty('--gc-primary-light', c[1]);
        card.style.setProperty('--gc-primary-bg', c[2]);
        card.style.setProperty('--gc-game', gameColor);
        card.className = 'gc-card gc-template-' + template;

        let statsHtml = '';
        if (template === 'default') {
            if (isPubg) {
                statsHtml += `<div class="gc-stat-item"><div class="gc-stat-label">Favorite Weapon</div><div class="gc-stat-value">${weapon}</div></div>`;
                if (kd) statsHtml += `<div class="gc-stat-item"><div class="gc-stat-label">K/D Ratio</div><div class="gc-stat-value">${kd}</div></div>`;
            } else {
                statsHtml += `<div class="gc-stat-item"><div class="gc-stat-label">Favorite Hero</div><div class="gc-stat-value">${hero}</div></div>`;
            }
            if (wr) statsHtml += `<div class="gc-stat-item"><div class="gc-stat-label">Win Rate</div><div class="gc-stat-value">${wr}</div></div>`;
            card.innerHTML = `<div class="gc-default"><div class="gc-default-header"><div class="gc-game-label">${gameLabel}</div></div><div class="gc-default-body"><div class="gc-default-name">${nickname}</div><div class="gc-default-id">ID: ${playerId}${!isPubg && serverId ? ' (' + serverId + ')' : ''}</div><div class="gc-default-rank"><span class="gc-rank-label">RANK</span><span class="gc-rank-value">${rank}</span></div><div class="gc-default-stats">${statsHtml}</div></div><div class="gc-default-footer"><div class="gc-branding">⚡ MyGamingCard</div></div></div>`;
        } else if (template === 'minimal') {
            if (isPubg) {
                statsHtml += `<div class="gc-mini-stat"><span>Weapon</span><strong>${weapon}</strong></div>`;
                if (kd) statsHtml += `<div class="gc-mini-stat"><span>K/D</span><strong>${kd}</strong></div>`;
            } else {
                statsHtml += `<div class="gc-mini-stat"><span>Hero</span><strong>${hero}</strong></div>`;
            }
            if (wr) statsHtml += `<div class="gc-mini-stat"><span>Win Rate</span><strong>${wr}</strong></div>`;
            card.innerHTML = `<div class="gc-minimal"><div class="gc-minimal-header"><span class="gc-game-tag">${gameLabel}</span><span class="gc-rank-tag">${rank}</span></div><div class="gc-minimal-name">${nickname}</div><div class="gc-minimal-id">ID: ${playerId}${!isPubg && serverId ? ' (' + serverId + ')' : ''}</div><div class="gc-minimal-stats">${statsHtml}</div><div class="gc-branding">MyGamingCard</div></div>`;
        } else {
            if (isPubg) {
                statsHtml += `<div class="gc-fut-stat"><div class="gc-fut-stat-val">${weapon}</div><div class="gc-fut-stat-lbl">WEAPON</div></div>`;
                if (kd) statsHtml += `<div class="gc-fut-stat"><div class="gc-fut-stat-val">${kd}</div><div class="gc-fut-stat-lbl">K/D RATIO</div></div>`;
            } else {
                statsHtml += `<div class="gc-fut-stat"><div class="gc-fut-stat-val">${hero}</div><div class="gc-fut-stat-lbl">HERO</div></div>`;
            }
            if (wr) statsHtml += `<div class="gc-fut-stat"><div class="gc-fut-stat-val">${wr}</div><div class="gc-fut-stat-lbl">WIN RATE</div></div>`;
            card.innerHTML = `<div class="gc-futuristic"><div class="gc-fut-corner gc-fut-tl"></div><div class="gc-fut-corner gc-fut-tr"></div><div class="gc-fut-corner gc-fut-bl"></div><div class="gc-fut-corner gc-fut-br"></div><div class="gc-fut-scanline"></div><div class="gc-fut-header"><div class="gc-fut-game">${gameLabel}</div><div class="gc-fut-rank-badge">${rank}</div></div><div class="gc-fut-name">${nickname}</div><div class="gc-fut-id">${playerId}${!isPubg && serverId ? ' // ' + serverId : ''}</div><div class="gc-fut-divider"></div><div class="gc-fut-stats">${statsHtml}</div><div class="gc-branding">⚡ MyGamingCard</div></div>`;
        }
    }

    document.querySelectorAll('.preview-field').forEach(field => {
        field.addEventListener('input', () => updateCardDOM(getFormData()));
        field.addEventListener('change', () => updateCardDOM(getFormData()));
    });
    document.querySelectorAll('.template-option').forEach(btn => {
        btn.addEventListener('click', function() {
            document.querySelectorAll('.template-option').forEach(b => b.classList.remove('active'));
            this.classList.add('active');
            document.getElementById('templateInput').value = this.dataset.template;
            updateCardDOM(getFormData());
        });
    });
    document.querySelectorAll('.color-option').forEach(btn => {
        btn.addEventListener('click', function() {
            document.querySelectorAll('.color-option').forEach(b => b.classList.remove('active'));
            this.classList.add('active');
            document.getElementById('colorInput').value = this.dataset.color;
            updateCardDOM(getFormData());
        });
    });
});
</script>
@endpush
