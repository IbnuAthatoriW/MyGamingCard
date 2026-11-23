{{-- Shared card CSS styles --}}
<style>
    /* ===== GAMING CARD BASE ===== */
    .gc-card {
        width: 380px; max-width: 100%;
        border-radius: 16px; overflow: hidden;
        font-family: 'Inter', sans-serif;
        position: relative;
        box-shadow: 0 8px 32px rgba(0,0,0,0.4);
    }

    /* Branding */
    .gc-branding {
        font-family: 'Orbitron', monospace; font-size: 0.6rem;
        letter-spacing: 2px; color: rgba(255,255,255,0.3);
        text-align: center; padding-top: 0.75rem;
    }

    .gc-game-tag {
        font-size: 0.6rem; font-weight: 700; letter-spacing: 2px;
        text-transform: uppercase; color: var(--gc-game);
    }
    .gc-rank-tag {
        font-size: 0.7rem; font-weight: 600;
        padding: 0.15rem 0.6rem; border-radius: 10px;
        background: var(--gc-primary-bg); color: var(--gc-primary-light);
    }

    /* ===== DEFAULT TEMPLATE ===== */
    .gc-default {
        background: linear-gradient(160deg, #0d1137 0%, #0a0e27 60%, rgba(0,0,0,0.9) 100%);
    }
    .gc-default-header {
        padding: 1.25rem 1.5rem 0.75rem;
        border-bottom: 1px solid rgba(255,255,255,0.05);
    }
    .gc-game-label {
        font-size: 0.6rem; font-weight: 700; letter-spacing: 3px;
        text-transform: uppercase; color: var(--gc-game);
    }
    .gc-default-body { padding: 1.25rem 1.5rem; }
    .gc-default-name {
        font-family: 'Orbitron', monospace; font-size: 1.5rem;
        font-weight: 800; margin-bottom: 0.2rem;
        background: linear-gradient(135deg, #fff, var(--gc-primary-light));
        -webkit-background-clip: text; -webkit-text-fill-color: transparent;
        background-clip: text;
    }
    .gc-default-id {
        font-size: 0.8rem; color: rgba(255,255,255,0.5); margin-bottom: 1rem;
        font-family: monospace;
    }
    .gc-default-rank {
        display: inline-flex; align-items: center; gap: 0.5rem;
        margin-bottom: 1.25rem; padding: 0.4rem 1rem;
        background: var(--gc-primary-bg); border-radius: 8px;
        border: 1px solid rgba(255,255,255,0.05);
    }
    .gc-rank-label {
        font-size: 0.55rem; font-weight: 700; letter-spacing: 2px;
        color: rgba(255,255,255,0.4);
    }
    .gc-rank-value {
        font-size: 0.95rem; font-weight: 700; color: var(--gc-primary-light);
    }
    .gc-default-stats {
        display: grid; grid-template-columns: 1fr 1fr; gap: 0.75rem;
    }
    .gc-stat-item {
        padding: 0.6rem 0.75rem; border-radius: 8px;
        background: rgba(255,255,255,0.03);
        border: 1px solid rgba(255,255,255,0.04);
    }
    .gc-stat-label {
        font-size: 0.6rem; text-transform: uppercase; letter-spacing: 1px;
        color: rgba(255,255,255,0.35); margin-bottom: 0.2rem;
    }
    .gc-stat-value {
        font-size: 0.95rem; font-weight: 600; color: #fff;
    }
    .gc-default-footer {
        padding: 0.75rem 1.5rem 1rem;
        border-top: 1px solid rgba(255,255,255,0.03);
    }

    /* ===== MINIMAL TEMPLATE ===== */
    .gc-minimal {
        background: linear-gradient(180deg, #111640 0%, #0a0e27 100%);
        padding: 1.75rem;
    }
    .gc-minimal-header {
        display: flex; justify-content: space-between; align-items: center;
        margin-bottom: 1.5rem;
    }
    .gc-minimal-name {
        font-family: 'Orbitron', monospace; font-size: 1.75rem;
        font-weight: 800; margin-bottom: 0.25rem; color: #fff;
    }
    .gc-minimal-id {
        font-size: 0.8rem; color: rgba(255,255,255,0.4);
        font-family: monospace; margin-bottom: 1.5rem;
    }
    .gc-minimal-stats {
        display: flex; gap: 1.5rem; flex-wrap: wrap;
    }
    .gc-mini-stat span {
        display: block; font-size: 0.6rem; text-transform: uppercase;
        letter-spacing: 1.5px; color: rgba(255,255,255,0.35);
    }
    .gc-mini-stat strong {
        font-size: 1rem; color: var(--gc-primary-light); font-weight: 700;
    }

    /* ===== FUTURISTIC TEMPLATE ===== */
    .gc-futuristic {
        background: linear-gradient(160deg, #0a0e27, #0d1137);
        padding: 2rem 1.75rem;
        position: relative; overflow: hidden;
    }
    .gc-fut-corner {
        position: absolute; width: 20px; height: 20px;
        border-color: var(--gc-primary); border-style: solid;
    }
    .gc-fut-tl { top: 8px; left: 8px; border-width: 2px 0 0 2px; }
    .gc-fut-tr { top: 8px; right: 8px; border-width: 2px 2px 0 0; }
    .gc-fut-bl { bottom: 8px; left: 8px; border-width: 0 0 2px 2px; }
    .gc-fut-br { bottom: 8px; right: 8px; border-width: 0 2px 2px 0; }
    .gc-fut-scanline {
        position: absolute; top: 0; left: 0; right: 0; height: 100%;
        background: repeating-linear-gradient(
            0deg, transparent, transparent 2px,
            rgba(255,255,255,0.01) 2px, rgba(255,255,255,0.01) 4px
        );
        pointer-events: none;
    }
    .gc-fut-header {
        display: flex; justify-content: space-between; align-items: center;
        margin-bottom: 1.25rem; position: relative; z-index: 1;
    }
    .gc-fut-game {
        font-size: 0.6rem; font-weight: 700; letter-spacing: 3px;
        color: var(--gc-game);
    }
    .gc-fut-rank-badge {
        font-size: 0.75rem; font-weight: 700;
        padding: 0.2rem 0.75rem; border: 1px solid var(--gc-primary);
        color: var(--gc-primary-light); letter-spacing: 1px;
    }
    .gc-fut-name {
        font-family: 'Orbitron', monospace; font-size: 1.6rem;
        font-weight: 800; letter-spacing: 2px; color: #fff;
        margin-bottom: 0.3rem; position: relative; z-index: 1;
    }
    .gc-fut-id {
        font-family: monospace; font-size: 0.75rem;
        color: var(--gc-primary); letter-spacing: 2px;
        margin-bottom: 1rem; position: relative; z-index: 1;
    }
    .gc-fut-divider {
        height: 1px; margin: 0.5rem 0 1rem;
        background: linear-gradient(90deg, transparent, var(--gc-primary), transparent);
        position: relative; z-index: 1;
    }
    .gc-fut-stats {
        display: flex; gap: 1.5rem; flex-wrap: wrap;
        position: relative; z-index: 1;
    }
    .gc-fut-stat-val {
        font-size: 1.1rem; font-weight: 700; color: var(--gc-primary-light);
    }
    .gc-fut-stat-lbl {
        font-size: 0.55rem; letter-spacing: 2px;
        color: rgba(255,255,255,0.3); margin-top: 0.1rem;
    }
</style>
