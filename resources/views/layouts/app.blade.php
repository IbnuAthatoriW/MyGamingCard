<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'MyGamingCard - Create Your Gaming Identity')</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=Orbitron:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <style>
        /* ===== RESET & BASE ===== */
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        :root {
            --navy: #0a0e27;
            --navy-light: #111640;
            --navy-mid: #161b4a;
            --purple: #6c5ce7;
            --purple-light: #a29bfe;
            --blue: #0984e3;
            --blue-light: #74b9ff;
            --accent: #6c5ce7;
            --text: #e8e8f0;
            --text-muted: #9898b8;
            --text-dim: #6868a0;
            --success: #00cec9;
            --danger: #ff6b6b;
            --warning: #feca57;
            --card-bg: rgba(22, 27, 74, 0.6);
            --border: rgba(108, 92, 231, 0.2);
            --radius: 12px;
            --radius-sm: 8px;
            --radius-lg: 16px;
            --shadow: 0 4px 24px rgba(0, 0, 0, 0.3);
            --transition: 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        html { scroll-behavior: smooth; }
        body {
            font-family: 'Inter', -apple-system, sans-serif;
            background: var(--navy);
            color: var(--text);
            min-height: 100vh;
            line-height: 1.6;
            overflow-x: hidden;
        }
        a { color: var(--purple-light); text-decoration: none; transition: color var(--transition); }
        a:hover { color: var(--blue-light); }

        /* ===== BACKGROUND ===== */
        .bg-grid {
            position: fixed; inset: 0; z-index: 0; pointer-events: none;
            background-image:
                linear-gradient(rgba(108,92,231,0.03) 1px, transparent 1px),
                linear-gradient(90deg, rgba(108,92,231,0.03) 1px, transparent 1px);
            background-size: 60px 60px;
        }
        .bg-glow {
            position: fixed; z-index: 0; pointer-events: none;
            width: 600px; height: 600px; border-radius: 50%;
            filter: blur(150px); opacity: 0.15;
        }
        .bg-glow-1 { top: -200px; right: -200px; background: var(--purple); }
        .bg-glow-2 { bottom: -200px; left: -200px; background: var(--blue); }

        /* ===== NAVBAR ===== */
        .navbar {
            position: fixed; top: 0; left: 0; right: 0; z-index: 100;
            padding: 1rem 2rem;
            background: rgba(10, 14, 39, 0.85);
            backdrop-filter: blur(20px);
            border-bottom: 1px solid var(--border);
            display: flex; align-items: center; justify-content: space-between;
        }
        .navbar-brand {
            font-family: 'Orbitron', monospace;
            font-size: 1.3rem; font-weight: 700;
            background: linear-gradient(135deg, var(--purple-light), var(--blue-light));
            -webkit-background-clip: text; -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        .navbar-links { display: flex; align-items: center; gap: 1.5rem; }
        .navbar-links a {
            color: var(--text-muted); font-size: 0.9rem; font-weight: 500;
            transition: color var(--transition);
        }
        .navbar-links a:hover { color: var(--text); }
        .navbar-user { display: flex; align-items: center; gap: 0.75rem; }

        /* ===== BUTTONS ===== */
        .btn {
            display: inline-flex; align-items: center; gap: 0.5rem;
            padding: 0.65rem 1.5rem; border-radius: var(--radius-sm);
            font-size: 0.875rem; font-weight: 600; cursor: pointer;
            border: none; transition: all var(--transition);
            text-decoration: none; line-height: 1.4;
        }
        .btn-primary {
            background: linear-gradient(135deg, var(--purple), var(--blue));
            color: #fff; box-shadow: 0 4px 15px rgba(108, 92, 231, 0.3);
        }
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 25px rgba(108, 92, 231, 0.5);
            color: #fff;
        }
        .btn-secondary {
            background: var(--card-bg); color: var(--text);
            border: 1px solid var(--border);
        }
        .btn-secondary:hover { background: var(--navy-mid); color: var(--text); }
        .btn-danger { background: rgba(255,107,107,0.15); color: var(--danger); border: 1px solid rgba(255,107,107,0.3); }
        .btn-danger:hover { background: rgba(255,107,107,0.25); color: var(--danger); }
        .btn-sm { padding: 0.45rem 1rem; font-size: 0.8rem; }
        .btn-lg { padding: 0.85rem 2rem; font-size: 1rem; }
        .btn-ghost { background: transparent; color: var(--text-muted); border: 1px solid transparent; }
        .btn-ghost:hover { color: var(--text); border-color: var(--border); }
        .btn-success { background: rgba(0,206,201,0.15); color: var(--success); border: 1px solid rgba(0,206,201,0.3); }
        .btn-success:hover { background: rgba(0,206,201,0.25); color: var(--success); }

        /* ===== FORMS ===== */
        .form-group { margin-bottom: 1.25rem; }
        .form-label {
            display: block; margin-bottom: 0.4rem;
            font-size: 0.85rem; font-weight: 500; color: var(--text-muted);
        }
        .form-input {
            width: 100%; padding: 0.7rem 1rem;
            background: rgba(10, 14, 39, 0.6);
            border: 1px solid var(--border);
            border-radius: var(--radius-sm);
            color: var(--text); font-size: 0.9rem;
            transition: all var(--transition);
            font-family: inherit;
        }
        .form-input:focus {
            outline: none;
            border-color: var(--purple);
            box-shadow: 0 0 0 3px rgba(108, 92, 231, 0.15);
        }
        .form-input::placeholder { color: var(--text-dim); }
        select.form-input {
            appearance: none;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 12 12'%3E%3Cpath fill='%239898b8' d='M6 8L1 3h10z'/%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 1rem center;
            padding-right: 2.5rem;
        }
        .form-error {
            color: var(--danger); font-size: 0.8rem; margin-top: 0.25rem;
        }
        .form-check {
            display: flex; align-items: center; gap: 0.5rem; cursor: pointer;
        }
        .form-check input[type="checkbox"] {
            width: 18px; height: 18px; accent-color: var(--purple);
            cursor: pointer;
        }

        /* ===== CARDS ===== */
        .card {
            background: var(--card-bg);
            border: 1px solid var(--border);
            border-radius: var(--radius-lg);
            backdrop-filter: blur(10px);
            overflow: hidden;
        }
        .card-body { padding: 1.5rem; }
        .card-header {
            padding: 1.25rem 1.5rem;
            border-bottom: 1px solid var(--border);
        }

        /* ===== ALERTS ===== */
        .alert {
            padding: 0.85rem 1.25rem; border-radius: var(--radius-sm);
            margin-bottom: 1.25rem; font-size: 0.9rem; display: flex;
            align-items: center; gap: 0.5rem;
            animation: slideDown 0.3s ease;
        }
        .alert-success {
            background: rgba(0,206,201,0.1); color: var(--success);
            border: 1px solid rgba(0,206,201,0.2);
        }
        .alert-danger {
            background: rgba(255,107,107,0.1); color: var(--danger);
            border: 1px solid rgba(255,107,107,0.2);
        }

        /* ===== BADGE ===== */
        .badge {
            display: inline-flex; align-items: center;
            padding: 0.2rem 0.6rem; border-radius: 20px;
            font-size: 0.7rem; font-weight: 600; text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        .badge-pubg { background: rgba(255,165,0,0.15); color: #ffa500; }
        .badge-mlbb { background: rgba(0,206,201,0.15); color: var(--success); }
        .badge-public { background: rgba(0,206,201,0.15); color: var(--success); }
        .badge-private { background: rgba(152,152,184,0.15); color: var(--text-muted); }

        /* ===== LAYOUT ===== */
        .container { max-width: 1200px; margin: 0 auto; padding: 0 1.5rem; }
        .page-content { position: relative; z-index: 1; padding-top: 5rem; min-height: 100vh; }
        .page-header { margin-bottom: 2rem; }
        .page-title {
            font-family: 'Orbitron', monospace; font-size: 1.75rem;
            font-weight: 700; margin-bottom: 0.25rem;
        }
        .page-subtitle { color: var(--text-muted); font-size: 0.95rem; }

        /* ===== RESPONSIVE ===== */
        .mobile-menu-btn { display: none; background: none; border: none; color: var(--text); cursor: pointer; font-size: 1.5rem; }
        @media (max-width: 768px) {
            .navbar { padding: 0.75rem 1rem; }
            .navbar-links { display: none; position: absolute; top: 100%; left: 0; right: 0; background: rgba(10,14,39,0.95); backdrop-filter: blur(20px); flex-direction: column; padding: 1rem; gap: 0.5rem; border-bottom: 1px solid var(--border); }
            .navbar-links.active { display: flex; }
            .navbar-links a { padding: 0.5rem 0; }
            .mobile-menu-btn { display: block; }
            .container { padding: 0 1rem; }
            .page-title { font-size: 1.3rem; }
        }

        /* ===== ANIMATIONS ===== */
        @keyframes fadeIn { from { opacity: 0; transform: translateY(10px); } to { opacity: 1; transform: translateY(0); } }
        @keyframes slideDown { from { opacity: 0; transform: translateY(-10px); } to { opacity: 1; transform: translateY(0); } }
        .fade-in { animation: fadeIn 0.5s ease forwards; }
        .fade-in-delay { animation: fadeIn 0.5s ease 0.15s forwards; opacity: 0; }
        .fade-in-delay-2 { animation: fadeIn 0.5s ease 0.3s forwards; opacity: 0; }

        /* ===== LANGUAGE SWITCHER ===== */
        .lang-switcher {
            display: inline-flex; align-items: center; gap: 0.2rem;
            padding: 0.25rem 0.6rem; border-radius: 20px;
            background: rgba(10, 14, 39, 0.8);
            border: 1px solid var(--border);
            font-size: 0.75rem; font-weight: 700;
        }
        .lang-btn {
            color: var(--text-dim); text-decoration: none;
            padding: 0.15rem 0.45rem; border-radius: 12px;
            transition: all var(--transition);
        }
        .lang-btn:hover { color: var(--text); }
        .lang-btn.active {
            color: #fff; background: linear-gradient(135deg, var(--purple), var(--blue));
            box-shadow: 0 2px 8px rgba(108, 92, 231, 0.4);
        }
        .lang-divider { color: var(--text-dim); font-size: 0.7rem; }

        /* ===== FOOTER ===== */
        .footer {
            position: relative; z-index: 1;
            padding: 2rem 0; margin-top: 4rem;
            border-top: 1px solid var(--border);
            text-align: center; color: var(--text-dim); font-size: 0.85rem;
        }
    </style>
    @stack('styles')
</head>
<body>
    <div class="bg-grid"></div>
    <div class="bg-glow bg-glow-1"></div>
    <div class="bg-glow bg-glow-2"></div>

    <!-- Navbar -->
    <nav class="navbar">
        <a href="{{ route('home') }}" class="navbar-brand">⚡ MyGamingCard</a>
        <div style="display: flex; align-items: center; gap: 1rem;">
            <div class="lang-switcher">
                <a href="{{ route('lang.switch', 'id') }}" class="lang-btn {{ app()->getLocale() === 'id' ? 'active' : '' }}" title="Bahasa Indonesia">ID</a>
                <span class="lang-divider">|</span>
                <a href="{{ route('lang.switch', 'en') }}" class="lang-btn {{ app()->getLocale() === 'en' ? 'active' : '' }}" title="English">EN</a>
            </div>
            <button class="mobile-menu-btn" onclick="document.querySelector('.navbar-links').classList.toggle('active')" aria-label="Toggle menu">☰</button>
        </div>
        <div class="navbar-links">
            @auth
                <a href="{{ route('dashboard') }}">{{ __('Dashboard') }}</a>
                <a href="{{ route('cards.create') }}">{{ __('Create Card') }}</a>
                <a href="{{ route('profile') }}">{{ __('Profile') }}</a>
                <div class="navbar-user">
                    <span style="color: var(--text-muted); font-size: 0.85rem;">{{ Auth::user()->name }}</span>
                    <form method="POST" action="{{ route('logout') }}" style="display:inline;">
                        @csrf
                        <button type="submit" class="btn btn-ghost btn-sm">{{ __('Logout') }}</button>
                    </form>
                </div>
            @else
                <a href="{{ route('login') }}">{{ __('Login') }}</a>
                <a href="{{ route('register') }}" class="btn btn-primary btn-sm">{{ __('Get Started') }}</a>
            @endauth
        </div>
    </nav>

    <!-- Main Content -->
    <main class="page-content">
        <div class="container">
            @if(session('success'))
                <div class="alert alert-success">✓ {{ session('success') }}</div>
            @endif
            @if(session('error'))
                <div class="alert alert-danger">✕ {{ session('error') }}</div>
            @endif
            @yield('content')
        </div>
    </main>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <p>© {{ date('Y') }} MyGamingCard. Create Your Gaming Identity.</p>
        </div>
    </footer>

    <script>
        // Close mobile menu on link click
        document.querySelectorAll('.navbar-links a').forEach(link => {
            link.addEventListener('click', () => {
                document.querySelector('.navbar-links').classList.remove('active');
            });
        });
    </script>
    @stack('scripts')
</body>
</html>
