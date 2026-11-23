@extends('layouts.app')
@section('title', 'MyGamingCard - ' . __('Create Your Gaming Identity'))

@push('styles')
<style>
    .hero {
        display: flex; flex-direction: column; align-items: center;
        justify-content: center; text-align: center;
        min-height: calc(100vh - 5rem); padding: 2rem 0;
    }
    .hero-badge {
        display: inline-flex; align-items: center; gap: 0.5rem;
        padding: 0.4rem 1rem; border-radius: 20px;
        background: rgba(108, 92, 231, 0.1); border: 1px solid rgba(108, 92, 231, 0.3);
        font-size: 0.8rem; color: var(--purple-light); font-weight: 500;
        margin-bottom: 1.5rem;
    }
    .hero-title {
        font-family: 'Orbitron', monospace; font-size: clamp(2rem, 5vw, 3.5rem);
        font-weight: 800; line-height: 1.2; margin-bottom: 1rem;
        background: linear-gradient(135deg, #fff 0%, var(--purple-light) 50%, var(--blue-light) 100%);
        -webkit-background-clip: text; -webkit-text-fill-color: transparent;
        background-clip: text;
    }
    .hero-subtitle {
        font-size: clamp(1rem, 2vw, 1.2rem); color: var(--text-muted);
        max-width: 600px; margin-bottom: 2.5rem; line-height: 1.7;
    }
    .hero-actions { display: flex; gap: 1rem; flex-wrap: wrap; justify-content: center; }
    .hero-visual {
        margin-top: 4rem; display: flex; gap: 1.5rem; perspective: 1000px;
        flex-wrap: wrap; justify-content: center;
    }
    .demo-card {
        width: 300px; padding: 1.5rem; border-radius: var(--radius-lg);
        border: 1px solid var(--border);
        backdrop-filter: blur(10px);
        transition: transform 0.5s ease;
        position: relative; overflow: hidden;
    }
    .demo-card::before {
        content: ''; position: absolute; inset: 0;
        background: linear-gradient(135deg, rgba(108,92,231,0.1), rgba(9,132,227,0.1));
        z-index: 0;
    }
    .demo-card:hover { transform: translateY(-8px) rotateX(2deg); }
    .demo-card-pubg { background: linear-gradient(145deg, rgba(255,165,0,0.08), rgba(10,14,39,0.9)); }
    .demo-card-mlbb { background: linear-gradient(145deg, rgba(0,206,201,0.08), rgba(10,14,39,0.9)); }
    .demo-card-inner { position: relative; z-index: 1; }
    .demo-card-game {
        font-size: 0.65rem; text-transform: uppercase; letter-spacing: 2px;
        font-weight: 700; margin-bottom: 0.75rem;
    }
    .demo-card-pubg .demo-card-game { color: #ffa500; }
    .demo-card-mlbb .demo-card-game { color: var(--success); }
    .demo-card-name {
        font-family: 'Orbitron', monospace; font-size: 1.3rem;
        font-weight: 700; margin-bottom: 0.25rem;
    }
    .demo-card-id { font-size: 0.8rem; color: var(--text-muted); margin-bottom: 1rem; }
    .demo-card-stats { display: grid; grid-template-columns: 1fr 1fr; gap: 0.75rem; }
    .demo-stat-label { font-size: 0.65rem; color: var(--text-dim); text-transform: uppercase; letter-spacing: 1px; }
    .demo-stat-value { font-size: 0.9rem; font-weight: 600; }

    /* Features Section */
    .features { padding: 5rem 0; }
    .features-title {
        font-family: 'Orbitron', monospace; font-size: 1.75rem;
        font-weight: 700; text-align: center; margin-bottom: 3rem;
    }
    .features-grid {
        display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
        gap: 1.5rem;
    }
    .feature-card {
        padding: 2rem; border-radius: var(--radius-lg);
        background: var(--card-bg); border: 1px solid var(--border);
        transition: all var(--transition);
    }
    .feature-card:hover {
        border-color: rgba(108, 92, 231, 0.4);
        transform: translateY(-4px);
    }
    .feature-icon { font-size: 2rem; margin-bottom: 1rem; }
    .feature-name { font-weight: 600; font-size: 1.05rem; margin-bottom: 0.5rem; }
    .feature-desc { color: var(--text-muted); font-size: 0.9rem; line-height: 1.6; }

    /* Games Section */
    .games { padding: 3rem 0 5rem; text-align: center; }
    .games-title {
        font-family: 'Orbitron', monospace; font-size: 1.5rem;
        font-weight: 700; margin-bottom: 1rem;
    }
    .games-desc { color: var(--text-muted); margin-bottom: 2rem; }
    .games-grid { display: flex; gap: 1.5rem; justify-content: center; flex-wrap: wrap; }
    .game-badge {
        display: flex; align-items: center; gap: 0.75rem;
        padding: 1rem 2rem; border-radius: var(--radius);
        background: var(--card-bg); border: 1px solid var(--border);
        font-weight: 600; font-size: 1.1rem;
        transition: all var(--transition);
    }
    .game-badge:hover { border-color: rgba(108, 92, 231, 0.4); transform: scale(1.05); }
    .game-dot { width: 10px; height: 10px; border-radius: 50%; }
    .game-dot-pubg { background: #ffa500; }
    .game-dot-mlbb { background: var(--success); }
</style>
@endpush

@section('content')
    <!-- Hero -->
    <section class="hero fade-in">
        <div class="hero-badge">🎮 {{ __('For Gamers, By Gamers') }}</div>
        <h1 class="hero-title">{!! nl2br(e(__('Create Your Gaming Identity'))) !!}</h1>
        <p class="hero-subtitle">
            {{ __('Design stunning digital gaming cards for PUBG Mobile and Mobile Legends. Showcase your stats, rank, and style — all in one beautiful card.') }}
        </p>
        <div class="hero-actions">
            @auth
                <a href="{{ route('cards.create') }}" class="btn btn-primary btn-lg">{{ __('Create Your Card') }}</a>
                <a href="{{ route('dashboard') }}" class="btn btn-secondary btn-lg">{{ __('Dashboard') }}</a>
            @else
                <a href="{{ route('register') }}" class="btn btn-primary btn-lg">{{ __('Get Started Free') }}</a>
                <a href="{{ route('login') }}" class="btn btn-secondary btn-lg">{{ __('Sign In') }}</a>
            @endauth
        </div>

        <div class="hero-visual fade-in-delay">
            <div class="demo-card demo-card-pubg">
                <div class="demo-card-inner">
                    <div class="demo-card-game">PUBG Mobile</div>
                    <div class="demo-card-name">ShadowStrike</div>
                    <div class="demo-card-id">ID: 5847291036</div>
                    <div class="demo-card-stats">
                        <div><div class="demo-stat-label">Rank</div><div class="demo-stat-value">Conqueror</div></div>
                        <div><div class="demo-stat-label">K/D</div><div class="demo-stat-value">6.42</div></div>
                        <div><div class="demo-stat-label">Weapon</div><div class="demo-stat-value">M416</div></div>
                        <div><div class="demo-stat-label">Win Rate</div><div class="demo-stat-value">28.5%</div></div>
                    </div>
                </div>
            </div>
            <div class="demo-card demo-card-mlbb">
                <div class="demo-card-inner">
                    <div class="demo-card-game">Mobile Legends</div>
                    <div class="demo-card-name">LunarBlade</div>
                    <div class="demo-card-id">ID: 192837465 (8201)</div>
                    <div class="demo-card-stats">
                        <div><div class="demo-stat-label">Rank</div><div class="demo-stat-value">Mythical Glory</div></div>
                        <div><div class="demo-stat-label">Hero</div><div class="demo-stat-value">Lancelot</div></div>
                        <div><div class="demo-stat-label">Win Rate</div><div class="demo-stat-value">72.1%</div></div>
                        <div><div class="demo-stat-label">Matches</div><div class="demo-stat-value">3,247</div></div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Features -->
    <section class="features fade-in-delay-2">
        <h2 class="features-title">{{ __('Why MyGamingCard?') }}</h2>
        <div class="features-grid">
            <div class="feature-card">
                <div class="feature-icon">🎨</div>
                <div class="feature-name">{{ __('Premium Templates') }}</div>
                <div class="feature-desc">{{ __('Choose from multiple card templates and color schemes to match your gaming style.') }}</div>
            </div>
            <div class="feature-card">
                <div class="feature-icon">👁️</div>
                <div class="feature-name">{{ __('Live Preview') }}</div>
                <div class="feature-desc">{{ __('See changes instantly as you customize your card. What you see is what you get.') }}</div>
            </div>
            <div class="feature-card">
                <div class="feature-icon">📥</div>
                <div class="feature-name">{{ __('Download as PNG') }}</div>
                <div class="feature-desc">{{ __('Download as a high-quality PNG image to share on social media.') }}</div>
            </div>
            <div class="feature-card">
                <div class="feature-icon">🔗</div>
                <div class="feature-name">{{ __('Share with Link') }}</div>
                <div class="feature-desc">{{ __('Get a unique shareable link for your card. Control who sees it with privacy settings.') }}</div>
            </div>
            <div class="feature-card">
                <div class="feature-icon">🔒</div>
                <div class="feature-name">{{ __('Secure & Private') }}</div>
                <div class="feature-desc">{{ __('We never ask for your game account password. Your data stays safe with us.') }}</div>
            </div>
            <div class="feature-card">
                <div class="feature-icon">📱</div>
                <div class="feature-name">{{ __('Fully Responsive') }}</div>
                <div class="feature-desc">{{ __('Create and view your cards on any device — desktop, tablet, or mobile.') }}</div>
            </div>
        </div>
    </section>

    <!-- Supported Games -->
    <section class="games">
        <h2 class="games-title">{{ __('Supported Games') }}</h2>
        <p class="games-desc">{{ __('Create identity cards for your favorite mobile games.') }}</p>
        <div class="games-grid">
            <div class="game-badge">
                <span class="game-dot game-dot-pubg"></span>
                PUBG Mobile
            </div>
            <div class="game-badge">
                <span class="game-dot game-dot-mlbb"></span>
                Mobile Legends: Bang Bang
            </div>
        </div>
    </section>
@endsection
