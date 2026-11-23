{{-- Card template partial - renders the visual gaming card --}}
{{-- Usage: @include('cards.partials.card-template', ['data' => [...], 'cardId' => 'preview']) --}}

@php
    $gameType = $data['game_type'] ?? 'pubg';
    $nickname = $data['nickname'] ?? 'YourName';
    $playerId = $data['player_id'] ?? '000000000';
    $serverId = $data['server_id'] ?? '';
    $rank = $data['rank'] ?? 'Unranked';
    $favoriteWeapon = $data['favorite_weapon'] ?? '-';
    $favoriteHero = $data['favorite_hero'] ?? '-';
    $kdRatio = $data['kd_ratio'] ?? '';
    $winRate = $data['win_rate'] ?? '';
    $template = $data['template'] ?? 'default';
    $colorScheme = $data['color_scheme'] ?? 'blue';

    $colors = [
        'blue' => ['#0984e3', '#74b9ff', 'rgba(9,132,227,0.15)'],
        'purple' => ['#6c5ce7', '#a29bfe', 'rgba(108,92,231,0.15)'],
        'red' => ['#d63031', '#ff7675', 'rgba(214,48,49,0.15)'],
        'green' => ['#00b894', '#55efc4', 'rgba(0,184,148,0.15)'],
        'gold' => ['#d4a017', '#f9ca24', 'rgba(212,160,23,0.15)'],
    ];
    $c = $colors[$colorScheme] ?? $colors['blue'];

    $isPubg = $gameType === 'pubg';
    $gameLabel = $isPubg ? 'PUBG MOBILE' : 'MOBILE LEGENDS';
    $gameColor = $isPubg ? '#ffa500' : '#00cec9';
@endphp

<div class="gc-card gc-template-{{ $template }}" id="{{ $cardId ?? 'gaming-card' }}"
     style="--gc-primary: {{ $c[0] }}; --gc-primary-light: {{ $c[1] }}; --gc-primary-bg: {{ $c[2] }}; --gc-game: {{ $gameColor }};">

    @if($template === 'minimal')
        {{-- Minimal template --}}
        <div class="gc-minimal">
            <div class="gc-minimal-header">
                <span class="gc-game-tag">{{ $gameLabel }}</span>
                <span class="gc-rank-tag">{{ $rank }}</span>
            </div>
            <div class="gc-minimal-name">{{ $nickname }}</div>
            <div class="gc-minimal-id">
                ID: {{ $playerId }}@if(!$isPubg && $serverId) ({{ $serverId }})@endif
            </div>
            <div class="gc-minimal-stats">
                @if($isPubg)
                    <div class="gc-mini-stat"><span>Weapon</span><strong>{{ $favoriteWeapon }}</strong></div>
                    @if($kdRatio)<div class="gc-mini-stat"><span>K/D</span><strong>{{ $kdRatio }}</strong></div>@endif
                @else
                    <div class="gc-mini-stat"><span>Hero</span><strong>{{ $favoriteHero }}</strong></div>
                @endif
                @if($winRate)<div class="gc-mini-stat"><span>Win Rate</span><strong>{{ $winRate }}</strong></div>@endif
            </div>
            <div class="gc-branding">MyGamingCard</div>
        </div>

    @elseif($template === 'futuristic')
        {{-- Futuristic template --}}
        <div class="gc-futuristic">
            <div class="gc-fut-corner gc-fut-tl"></div>
            <div class="gc-fut-corner gc-fut-tr"></div>
            <div class="gc-fut-corner gc-fut-bl"></div>
            <div class="gc-fut-corner gc-fut-br"></div>
            <div class="gc-fut-scanline"></div>
            <div class="gc-fut-header">
                <div class="gc-fut-game">{{ $gameLabel }}</div>
                <div class="gc-fut-rank-badge">{{ $rank }}</div>
            </div>
            <div class="gc-fut-name">{{ $nickname }}</div>
            <div class="gc-fut-id">
                {{ $playerId }}@if(!$isPubg && $serverId) // {{ $serverId }}@endif
            </div>
            <div class="gc-fut-divider"></div>
            <div class="gc-fut-stats">
                @if($isPubg)
                    <div class="gc-fut-stat">
                        <div class="gc-fut-stat-val">{{ $favoriteWeapon }}</div>
                        <div class="gc-fut-stat-lbl">WEAPON</div>
                    </div>
                    @if($kdRatio)
                    <div class="gc-fut-stat">
                        <div class="gc-fut-stat-val">{{ $kdRatio }}</div>
                        <div class="gc-fut-stat-lbl">K/D RATIO</div>
                    </div>
                    @endif
                @else
                    <div class="gc-fut-stat">
                        <div class="gc-fut-stat-val">{{ $favoriteHero }}</div>
                        <div class="gc-fut-stat-lbl">HERO</div>
                    </div>
                @endif
                @if($winRate)
                <div class="gc-fut-stat">
                    <div class="gc-fut-stat-val">{{ $winRate }}</div>
                    <div class="gc-fut-stat-lbl">WIN RATE</div>
                </div>
                @endif
            </div>
            <div class="gc-branding">⚡ MyGamingCard</div>
        </div>

    @else
        {{-- Default template --}}
        <div class="gc-default">
            <div class="gc-default-header">
                <div class="gc-game-label">{{ $gameLabel }}</div>
            </div>
            <div class="gc-default-body">
                <div class="gc-default-name">{{ $nickname }}</div>
                <div class="gc-default-id">
                    ID: {{ $playerId }}@if(!$isPubg && $serverId) ({{ $serverId }})@endif
                </div>
                <div class="gc-default-rank">
                    <span class="gc-rank-label">RANK</span>
                    <span class="gc-rank-value">{{ $rank }}</span>
                </div>
                <div class="gc-default-stats">
                    @if($isPubg)
                        <div class="gc-stat-item">
                            <div class="gc-stat-label">Favorite Weapon</div>
                            <div class="gc-stat-value">{{ $favoriteWeapon }}</div>
                        </div>
                        @if($kdRatio)
                        <div class="gc-stat-item">
                            <div class="gc-stat-label">K/D Ratio</div>
                            <div class="gc-stat-value">{{ $kdRatio }}</div>
                        </div>
                        @endif
                    @else
                        <div class="gc-stat-item">
                            <div class="gc-stat-label">Favorite Hero</div>
                            <div class="gc-stat-value">{{ $favoriteHero }}</div>
                        </div>
                    @endif
                    @if($winRate)
                    <div class="gc-stat-item">
                        <div class="gc-stat-label">Win Rate</div>
                        <div class="gc-stat-value">{{ $winRate }}</div>
                    </div>
                    @endif
                </div>
            </div>
            <div class="gc-default-footer">
                <div class="gc-branding">⚡ MyGamingCard</div>
            </div>
        </div>
    @endif
</div>
