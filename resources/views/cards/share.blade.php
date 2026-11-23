<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $card->nickname }} - MyGamingCard</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=Orbitron:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        body {
            font-family: 'Inter', sans-serif;
            background: #0a0e27;
            color: #e8e8f0;
            min-height: 100vh;
            display: flex; flex-direction: column;
            align-items: center; justify-content: center;
            padding: 2rem;
        }
        .bg-grid {
            position: fixed; inset: 0; z-index: 0; pointer-events: none;
            background-image:
                linear-gradient(rgba(108,92,231,0.03) 1px, transparent 1px),
                linear-gradient(90deg, rgba(108,92,231,0.03) 1px, transparent 1px);
            background-size: 60px 60px;
        }
        .share-container { position: relative; z-index: 1; text-align: center; }
        .share-header {
            margin-bottom: 2rem;
        }
        .share-brand {
            font-family: 'Orbitron', monospace; font-size: 1rem;
            background: linear-gradient(135deg, #a29bfe, #74b9ff);
            -webkit-background-clip: text; -webkit-text-fill-color: transparent;
            background-clip: text; margin-bottom: 0.5rem;
        }
        .share-player {
            font-size: 0.9rem; color: #9898b8;
        }
        .share-actions {
            margin-top: 1.5rem; display: flex; gap: 0.75rem;
            justify-content: center; flex-wrap: wrap;
        }
        .share-btn {
            display: inline-flex; align-items: center; gap: 0.5rem;
            padding: 0.6rem 1.25rem; border-radius: 8px;
            font-size: 0.85rem; font-weight: 600; cursor: pointer;
            border: none; transition: all 0.3s ease; text-decoration: none;
        }
        .btn-dl {
            background: linear-gradient(135deg, #6c5ce7, #0984e3);
            color: #fff;
        }
        .btn-dl:hover { transform: translateY(-2px); box-shadow: 0 4px 15px rgba(108,92,231,0.4); }
        .btn-home {
            background: rgba(22,27,74,0.6); color: #9898b8;
            border: 1px solid rgba(108,92,231,0.2);
        }
        .btn-home:hover { color: #e8e8f0; }
        .footer-text {
            margin-top: 3rem; font-size: 0.8rem; color: #6868a0;
        }
    </style>
    @include('cards.partials.card-styles')
</head>
<body>
    <div class="bg-grid"></div>
    <div class="share-container">
        <div class="share-header">
            <div class="share-brand">⚡ MyGamingCard</div>
            <div class="share-player">{{ $card->nickname }}'s Gaming Card</div>
        </div>

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
            'cardId' => 'shared-card'
        ])

        <div class="share-actions">
            <button class="share-btn btn-dl" onclick="downloadCard()">📥 Download PNG</button>
            <a href="{{ route('home') }}" class="share-btn btn-home">Create Your Own Card</a>
        </div>

        <div class="footer-text">
            Created with MyGamingCard — Create Your Gaming Identity
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
    <script>
    function downloadCard() {
        const card = document.getElementById('shared-card');
        html2canvas(card, { backgroundColor: null, scale: 2, useCORS: true, logging: false })
            .then(canvas => {
                const link = document.createElement('a');
                link.download = '{{ $card->nickname }}-gaming-card.png';
                link.href = canvas.toDataURL('image/png');
                link.click();
            })
            .catch(() => alert('Failed to generate image.'));
    }
    </script>
</body>
</html>
