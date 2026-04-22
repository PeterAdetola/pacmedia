<x-admin-layout title="Dashboard">

    @push('page-css')
        <style>
            /* ═══════════════════════════════════════════════════
               PAC DASHBOARD — Design System v3
               Brand: Peridot (#b5cc18) · Metal (#6b7280) · Ink (#111827)
            ═══════════════════════════════════════════════════ */

            /* ── Keyframes ─────────────────────────────────── */
            @keyframes pac-pulse {
                0%, 100% { opacity: 1; transform: scale(1); }
                50%       { opacity: 0.5; transform: scale(0.85); }
            }
            @keyframes pac-rise {
                from { opacity: 0; transform: translateY(10px); }
                to   { opacity: 1; transform: translateY(0); }
            }
            @keyframes pac-bar-in {
                from { width: 0 !important; }
            }
            @keyframes pac-spark-in {
                from { transform: scaleY(0); opacity: 0; }
                to   { transform: scaleY(1); opacity: 1; }
            }

            /* ── Layout animation ───────────────────────────── */
            .pac-dash-row { animation: pac-rise 0.4s ease both; }
            .pac-dash-row:nth-child(1) { animation-delay: 0.05s; }
            .pac-dash-row:nth-child(2) { animation-delay: 0.12s; }
            .pac-dash-row:nth-child(3) { animation-delay: 0.20s; }

            /* ══════════════════════════════════════════════════
               WELCOME BANNER
            ══════════════════════════════════════════════════ */
            .pac-welcome {
                background: linear-gradient(135deg, #0d1117 0%, #111827 45%, #1a2332 100%);
                border-radius: 0.875rem;
                padding: 2rem 2.25rem;
                position: relative;
                overflow: hidden;
                border: 1px solid rgba(255,255,255,0.04);
            }
            /* Peridot glow orbs */
            .pac-welcome::before {
                content: '';
                position: absolute;
                top: -60px; right: -60px;
                width: 240px; height: 240px;
                border-radius: 50%;
                background: radial-gradient(circle, rgba(181,204,24,0.14) 0%, transparent 65%);
                pointer-events: none;
            }
            .pac-welcome::after {
                content: '';
                position: absolute;
                bottom: -80px; right: 100px;
                width: 180px; height: 180px;
                border-radius: 50%;
                background: radial-gradient(circle, rgba(181,204,24,0.06) 0%, transparent 65%);
                pointer-events: none;
            }
            /* Subtle grid texture */
            .pac-welcome-grid {
                position: absolute;
                inset: 0;
                background-image:
                    linear-gradient(rgba(255,255,255,0.015) 1px, transparent 1px),
                    linear-gradient(90deg, rgba(255,255,255,0.015) 1px, transparent 1px);
                background-size: 32px 32px;
                pointer-events: none;
            }
            .pac-welcome-inner { position: relative; z-index: 1; }

            .pac-welcome-badge {
                display: inline-flex;
                align-items: center;
                gap: 7px;
                background: rgba(181,204,24,0.12);
                border: 1px solid rgba(181,204,24,0.28);
                border-radius: 100px;
                padding: 4px 13px 4px 8px;
                font-size: 0.7rem;
                font-weight: 600;
                color: #b5cc18;
                letter-spacing: 0.04em;
                text-transform: uppercase;
                margin-bottom: 1rem;
            }
            .pac-pulse-dot {
                width: 7px; height: 7px;
                border-radius: 50%;
                background: #b5cc18;
                animation: pac-pulse 2.2s ease-in-out infinite;
                flex-shrink: 0;
            }

            .pac-welcome h4 {
                font-size: 1.45rem;
                font-weight: 700;
                color: #fff;
                line-height: 1.25;
                margin-bottom: 0.5rem;
            }
            .pac-welcome p {
                font-size: 0.84rem;
                color: rgba(255,255,255,0.48);
                line-height: 1.65;
                margin-bottom: 0;
            }
            .pac-welcome-meta {
                font-size: 0.73rem;
                color: rgba(255,255,255,0.3);
                letter-spacing: 0.03em;
                margin-top: 0.875rem;
                display: flex;
                align-items: center;
                gap: 0.5rem;
            }
            .pac-welcome-meta-sep {
                width: 3px; height: 3px;
                border-radius: 50%;
                background: rgba(255,255,255,0.2);
            }

            /* CTA buttons */
            .pac-cta-primary {
                display: inline-flex;
                align-items: center;
                gap: 6px;
                background: #b5cc18;
                color: #111827;
                font-size: 0.82rem;
                font-weight: 700;
                padding: 0.5rem 1.25rem;
                border-radius: 0.4rem;
                text-decoration: none;
                transition: background 0.15s, transform 0.15s, box-shadow 0.15s;
                letter-spacing: -0.01em;
            }
            .pac-cta-primary:hover {
                background: #96aa12;
                color: #111827;
                transform: translateY(-1px);
                box-shadow: 0 4px 14px rgba(181,204,24,0.35);
            }
            .pac-cta-ghost {
                display: inline-flex;
                align-items: center;
                gap: 6px;
                background: rgba(255,255,255,0.07);
                border: 1px solid rgba(255,255,255,0.1);
                color: rgba(255,255,255,0.72);
                font-size: 0.82rem;
                font-weight: 500;
                padding: 0.5rem 1.1rem;
                border-radius: 0.4rem;
                text-decoration: none;
                transition: background 0.15s, border-color 0.15s;
            }
            .pac-cta-ghost:hover {
                background: rgba(255,255,255,0.12);
                border-color: rgba(255,255,255,0.18);
                color: #fff;
            }

            /* Date block (top-right of banner) */
            .pac-welcome-date {
                text-align: right;
                flex-shrink: 0;
            }
            .pac-welcome-date .day-name {
                font-size: 0.7rem;
                color: rgba(255,255,255,0.35);
                text-transform: uppercase;
                letter-spacing: 0.1em;
                line-height: 1;
            }
            .pac-welcome-date .day-num {
                font-size: 2.75rem;
                font-weight: 800;
                color: rgba(255,255,255,0.08);
                line-height: 1;
                letter-spacing: -0.04em;
            }
            .pac-welcome-date .month-year {
                font-size: 0.73rem;
                color: rgba(255,255,255,0.35);
                letter-spacing: 0.05em;
                text-transform: uppercase;
            }

            /* ══════════════════════════════════════════════════
               STAT CARDS
            ══════════════════════════════════════════════════ */
            .pac-stat {
                border-radius: 0.75rem;
                border: 1px solid var(--bs-border-color);
                background: var(--bs-paper-bg, #fff);
                padding: 1.375rem 1.5rem 1.125rem;
                position: relative;
                overflow: hidden;
                transition: transform 0.2s ease, box-shadow 0.2s ease, border-color 0.2s ease;
                cursor: pointer;
                text-decoration: none;
                display: block;
                color: inherit;
            }
            .pac-stat:hover {
                transform: translateY(-3px);
                box-shadow: 0 8px 28px rgba(0,0,0,0.09);
                border-color: rgba(181,204,24,0.35);
                color: inherit;
            }
            .pac-stat::before {
                content: '';
                position: absolute;
                top: 0; left: 0; right: 0;
                height: 3px;
                background: transparent;
                transition: background 0.2s ease;
                border-radius: 0.75rem 0.75rem 0 0;
            }
            .pac-stat:hover::before { background: var(--pac-peridot); }
            .pac-stat.accent-metal:hover::before { background: #6b7280; }
            .pac-stat.accent-ink:hover::before   { background: #111827; }
            .pac-stat.accent-red:hover::before   { background: #ef4444; }

            .pac-stat-top {
                display: flex;
                align-items: flex-start;
                justify-content: space-between;
                margin-bottom: 0.875rem;
            }
            .pac-stat-icon {
                width: 44px; height: 44px;
                border-radius: 10px;
                display: flex;
                align-items: center;
                justify-content: center;
                font-size: 1.2rem;
                flex-shrink: 0;
            }
            .pac-stat-num {
                font-size: 1.65rem;
                font-weight: 800;
                color: var(--pac-ink, #111827);
                line-height: 1;
                letter-spacing: -0.03em;
                margin-bottom: 0.25rem;
            }
            .pac-stat-label {
                font-size: 0.77rem;
                color: var(--bs-body-secondary, #6b7280);
                font-weight: 500;
            }
            .pac-stat-delta {
                font-size: 0.7rem;
                font-weight: 700;
                padding: 3px 8px;
                border-radius: 100px;
            }
            .pac-delta-up   { background: rgba(34,197,94,0.1);  color: #15803d; }
            .pac-delta-down { background: rgba(239,68,68,0.1);  color: #b91c1c; }
            .pac-delta-neu  { background: rgba(107,114,128,0.1); color: #6b7280; }

            /* Sparkline */
            .pac-sparkline {
                display: flex;
                align-items: flex-end;
                gap: 2.5px;
                height: 36px;
                margin-top: 0.875rem;
                transform-origin: bottom;
            }
            .pac-spark {
                flex: 1;
                border-radius: 2px 2px 0 0;
                min-height: 3px;
                animation: pac-spark-in 0.4s ease both;
            }

            /* ══════════════════════════════════════════════════
               CARD SHARED
            ══════════════════════════════════════════════════ */
            .pac-card-header {
                display: flex;
                align-items: center;
                justify-content: space-between;
                padding: 1.25rem 1.5rem 1rem;
                border-bottom: 1px solid var(--bs-border-color, #e5e7eb);
            }
            .pac-card-eyebrow {
                width: 22px; height: 3px;
                border-radius: 2px;
                background: var(--pac-peridot, #b5cc18);
                margin-bottom: 0.3rem;
            }
            .pac-card-title {
                font-size: 0.9rem;
                font-weight: 700;
                color: var(--pac-ink, #111827);
                line-height: 1.2;
                margin: 0;
            }
            .pac-card-sub {
                font-size: 0.72rem;
                color: var(--bs-body-secondary, #6b7280);
                margin: 1px 0 0;
            }
            .pac-view-all {
                font-size: 0.73rem;
                font-weight: 600;
                color: var(--pac-peridot-dim, #96aa12);
                border: 1px solid rgba(181,204,24,0.35);
                border-radius: 0.35rem;
                padding: 0.25rem 0.7rem;
                text-decoration: none;
                white-space: nowrap;
                transition: background 0.15s, border-color 0.15s;
            }
            .pac-view-all:hover {
                background: rgba(181,204,24,0.07);
                border-color: rgba(181,204,24,0.55);
                color: var(--pac-peridot-dim);
            }

            /* ══════════════════════════════════════════════════
               INVOICE TABLE
            ══════════════════════════════════════════════════ */
            .pac-table-head {
                display: grid;
                grid-template-columns: 90px 1fr 110px 95px 70px;
                gap: 0.5rem;
                padding: 0.65rem 1.5rem;
                background: #f9fafb;
                border-bottom: 1px solid var(--bs-border-color, #e5e7eb);
                font-size: 0.68rem;
                font-weight: 700;
                text-transform: uppercase;
                letter-spacing: 0.07em;
                color: var(--bs-body-secondary, #9ca3af);
            }
            .pac-table-row {
                display: grid;
                grid-template-columns: 90px 1fr 110px 95px 70px;
                gap: 0.5rem;
                padding: 0.875rem 1.5rem;
                border-bottom: 1px solid #f3f4f6;
                align-items: center;
                font-size: 0.82rem;
                transition: background 0.12s;
            }
            .pac-table-row:last-child { border-bottom: none; }
            .pac-table-row:hover { background: #fafafa; }

            .pac-inv-num  { font-weight: 700; color: var(--pac-peridot-dim); font-size: 0.78rem; }
            .pac-inv-client { font-weight: 600; color: var(--pac-ink); white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
            .pac-inv-amount { font-weight: 700; color: var(--pac-ink); font-size: 0.85rem; }
            .pac-inv-due { color: var(--bs-body-secondary); font-size: 0.75rem; }

            /* Badge variants */
            .pac-badge {
                font-size: 0.67rem;
                font-weight: 700;
                padding: 3px 9px;
                border-radius: 100px;
                white-space: nowrap;
                letter-spacing: 0.02em;
            }
            .pac-badge-draft   { background: #f1f5f9; color: #64748b; }
            .pac-badge-sent    { background: rgba(59,130,246,0.1); color: #1d4ed8; }
            .pac-badge-paid    { background: rgba(34,197,94,0.1);  color: #15803d; }
            .pac-badge-overdue { background: rgba(239,68,68,0.1);  color: #b91c1c; }
            .pac-badge-partial { background: rgba(245,158,11,0.1); color: #b45309; }

            /* ══════════════════════════════════════════════════
               EMPTY STATE
            ══════════════════════════════════════════════════ */
            .pac-empty {
                display: flex;
                flex-direction: column;
                align-items: center;
                justify-content: center;
                padding: 3rem 1.5rem;
                text-align: center;
            }
            .pac-empty-ring {
                width: 56px; height: 56px;
                border-radius: 50%;
                border: 2px dashed rgba(181,204,24,0.3);
                display: flex;
                align-items: center;
                justify-content: center;
                margin-bottom: 1rem;
                background: rgba(181,204,24,0.05);
            }
            .pac-empty-ring i { font-size: 1.4rem; color: rgba(181,204,24,0.5); }
            .pac-empty p  { font-size: 0.82rem; color: #9ca3af; margin: 0 0 0.4rem; }
            .pac-empty a  { font-size: 0.8rem; color: var(--pac-peridot-dim); font-weight: 600; text-decoration: none; }
            .pac-empty a:hover { text-decoration: underline; }

            /* ══════════════════════════════════════════════════
               CLIENT LIST ROWS
            ══════════════════════════════════════════════════ */
            .pac-client-row {
                display: flex;
                align-items: center;
                gap: 0.875rem;
                padding: 0.75rem 0;
                border-bottom: 1px solid #f3f4f6;
            }
            .pac-client-row:last-child { border-bottom: none; padding-bottom: 0; }
            .pac-client-avatar {
                width: 38px; height: 38px;
                border-radius: 50%;
                background: rgba(181,204,24,0.12);
                display: flex;
                align-items: center;
                justify-content: center;
                font-size: 0.8rem;
                font-weight: 700;
                color: var(--pac-peridot-dim);
                flex-shrink: 0;
                letter-spacing: 0;
            }
            .pac-client-name  { font-size: 0.83rem; font-weight: 600; color: var(--pac-ink); margin: 0; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
            .pac-client-email { font-size: 0.72rem; color: #9ca3af; margin: 0; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
            .pac-client-link  { font-size: 0.7rem; color: var(--pac-peridot-dim); text-decoration: none; white-space: nowrap; }
            .pac-client-link:hover { text-decoration: underline; }

            /* ══════════════════════════════════════════════════
               QUICK ACTIONS GRID
            ══════════════════════════════════════════════════ */
            .pac-qa-grid {
                display: grid;
                grid-template-columns: 1fr 1fr;
                gap: 0.625rem;
            }
            .pac-qa-btn {
                display: flex;
                align-items: center;
                gap: 0.75rem;
                padding: 0.875rem;
                border-radius: 0.5rem;
                background: #f8f9fa;
                border: 1px solid #eef0f2;
                text-decoration: none;
                transition: all 0.15s ease;
                color: inherit;
            }
            .pac-qa-btn:hover {
                background: #fff;
                border-color: rgba(181,204,24,0.4);
                transform: translateY(-1px);
                box-shadow: 0 3px 10px rgba(0,0,0,0.05);
                color: inherit;
            }
            .pac-qa-icon {
                width: 34px; height: 34px;
                border-radius: 8px;
                display: flex;
                align-items: center;
                justify-content: center;
                font-size: 0.95rem;
                flex-shrink: 0;
            }
            .pac-qa-label { font-size: 0.79rem; font-weight: 700; color: var(--pac-ink); line-height: 1.2; margin: 0; }
            .pac-qa-sub   { font-size: 0.68rem; color: #9ca3af; margin: 0; }

            /* ══════════════════════════════════════════════════
               ACTIVITY FEED
            ══════════════════════════════════════════════════ */
            .pac-feed {
                list-style: none;
                padding: 0; margin: 0;
                position: relative;
            }
            .pac-feed::before {
                content: '';
                position: absolute;
                left: 17px;
                top: 14px; bottom: 14px;
                width: 1px;
                background: linear-gradient(to bottom, rgba(181,204,24,0.3), rgba(181,204,24,0.05));
            }
            .pac-feed-item {
                display: flex;
                gap: 0.875rem;
                padding: 0.875rem 0;
                position: relative;
            }
            .pac-feed-item:last-child { padding-bottom: 0; }
            .pac-feed-dot {
                width: 34px; height: 34px;
                border-radius: 50%;
                display: flex;
                align-items: center;
                justify-content: center;
                font-size: 0.85rem;
                flex-shrink: 0;
                position: relative;
                z-index: 1;
            }
            .pac-feed-dot.peridot { background: rgba(181,204,24,0.12); color: var(--pac-peridot-dim); }
            .pac-feed-dot.metal   { background: rgba(107,114,128,0.1); color: #4b5563; }
            .pac-feed-dot.danger  { background: rgba(239,68,68,0.1);   color: #b91c1c; }
            .pac-feed-dot.info    { background: rgba(59,130,246,0.1);   color: #1d4ed8; }
            .pac-feed-body { flex: 1; min-width: 0; padding-top: 3px; }
            .pac-feed-text { font-size: 0.81rem; color: var(--pac-ink); line-height: 1.45; margin: 0 0 2px; }
            .pac-feed-text strong { font-weight: 600; }
            .pac-feed-time { font-size: 0.69rem; color: #9ca3af; }

            /* ══════════════════════════════════════════════════
               PROJECT PIPELINE
            ══════════════════════════════════════════════════ */
            .pac-donut-wrap {
                position: relative;
                width: 86px; height: 86px;
                flex-shrink: 0;
            }
            .pac-donut-center {
                position: absolute;
                inset: 0;
                display: flex;
                flex-direction: column;
                align-items: center;
                justify-content: center;
            }
            .pac-donut-num  { font-size: 1.25rem; font-weight: 800; color: var(--pac-ink); line-height: 1; }
            .pac-donut-sub  { font-size: 0.6rem;  color: #9ca3af; text-transform: uppercase; letter-spacing: 0.04em; }

            .pac-pipe-row { margin-bottom: 0.875rem; }
            .pac-pipe-row:last-child { margin-bottom: 0; }
            .pac-pipe-meta {
                display: flex;
                justify-content: space-between;
                align-items: center;
                margin-bottom: 5px;
            }
            .pac-pipe-name {
                font-size: 0.78rem;
                font-weight: 500;
                color: var(--pac-ink);
                display: flex;
                align-items: center;
                gap: 6px;
            }
            .pac-pipe-dot {
                width: 7px; height: 7px;
                border-radius: 2px;
                flex-shrink: 0;
            }
            .pac-pipe-pct  { font-size: 0.73rem; color: #9ca3af; font-weight: 600; }
            .pac-bar-track {
                height: 5px;
                border-radius: 3px;
                background: #eef0f2;
                overflow: hidden;
            }
            .pac-bar-fill {
                height: 100%;
                border-radius: 3px;
                background: var(--pac-peridot);
                animation: pac-bar-in 0.8s ease both;
            }

            /* ══════════════════════════════════════════════════
               DARK MODE
            ══════════════════════════════════════════════════ */
            [data-bs-theme="dark"] .pac-stat {
                background: var(--bs-paper-bg);
                border-color: rgba(255,255,255,0.06);
            }
            [data-bs-theme="dark"] .pac-table-head { background: rgba(255,255,255,0.03); }
            [data-bs-theme="dark"] .pac-table-row:hover { background: rgba(255,255,255,0.02); }
            [data-bs-theme="dark"] .pac-qa-btn { background: rgba(255,255,255,0.04); border-color: rgba(255,255,255,0.06); }
            [data-bs-theme="dark"] .pac-qa-btn:hover { background: rgba(255,255,255,0.07); }
            [data-bs-theme="dark"] .pac-feed::before { background: linear-gradient(to bottom, rgba(181,204,24,0.2), transparent); }
            [data-bs-theme="dark"] .pac-bar-track { background: rgba(255,255,255,0.08); }
            [data-bs-theme="dark"] .pac-client-row  { border-color: rgba(255,255,255,0.06); }
            [data-bs-theme="dark"] .pac-table-head  { border-color: rgba(255,255,255,0.06); }
            [data-bs-theme="dark"] .pac-table-row   { border-color: rgba(255,255,255,0.04); }
        </style>
    @endpush

    {{-- ════════════════════════════════════════════════════════
         ROW 1 — WELCOME BANNER + 4 STAT CARDS
    ═════════════════════════════════════════════════════════ --}}
    <div class="row g-4 mb-4 pac-dash-row">

        {{-- Welcome Banner --}}
        <div class="col-12 col-xl-5">
            <div class="pac-welcome h-100">
                <div class="pac-welcome-grid"></div>
                <div class="pac-welcome-inner">

                    <div class="d-flex align-items-start justify-content-between gap-3">
                        <div class="flex-grow-1 min-width-0">

                            {{-- Studio badge --}}
                            <div class="pac-welcome-badge">
                                <span class="pac-pulse-dot"></span>
                                Studio Active
                            </div>

                            {{-- Greeting --}}
                            <h4>
                                @if(now()->hour < 12)
                                    Good morning,
                                @elseif(now()->hour < 17)
                                    Good afternoon,
                                @else
                                    Good evening,
                                @endif
                                {{ auth()->user()->name ?? 'there' }} 👋
                            </h4>
                            <p>
                                Here's what's happening across The Pacmedia today.
                                Your studio dashboard is ready.
                            </p>

                            {{-- Meta --}}
                            <div class="pac-welcome-meta">
                                <span>{{ now()->format('l, F j Y') }}</span>
                                <span class="pac-welcome-meta-sep"></span>
                                <span>Lagos, NG</span>
                            </div>

                        </div>

                        {{-- Date display (desktop) --}}
                        <div class="pac-welcome-date d-none d-lg-block">
                            <div class="day-name">{{ now()->format('D') }}</div>
                            <div class="day-num">{{ now()->format('d') }}</div>
                            <div class="month-year">{{ now()->format('M Y') }}</div>
                        </div>
                    </div>

                    {{-- CTA row --}}
                    <div class="d-flex flex-wrap gap-2 mt-3">
                        <a href="{{ route('admin.invoices.create') }}" class="pac-cta-primary">
                            <i class="ri ri-add-line" style="font-size:0.85rem;"></i>
                            New Invoice
                        </a>
                        <a href="{{ route('admin.clients.create') }}" class="pac-cta-ghost">
                            <i class="ri ri-user-add-line" style="font-size:0.85rem;"></i>
                            Add Client
                        </a>
                        <a href="{{ route('admin.projects.index') }}" class="pac-cta-ghost">
                            <i class="ri ri-layout-column-line" style="font-size:0.85rem;"></i>
                            Projects
                        </a>
                    </div>

                </div>
            </div>
        </div>

        {{-- Stat: Outstanding Invoices --}}
        <div class="col-6 col-xl">
            <a href="{{ route('admin.invoices.index') }}" class="pac-stat h-100">
                <div class="pac-stat-top">
                    <div class="pac-stat-icon" style="background: rgba(181,204,24,0.12);">
                        <i class="ri ri-file-list-3-line" style="color: var(--pac-peridot-dim);"></i>
                    </div>
                    <span class="pac-stat-delta pac-delta-neu">—</span>
                </div>
                <div class="pac-stat-num">—</div>
                <div class="pac-stat-label">Outstanding Invoices</div>
                <div class="pac-sparkline">
                    @php $sparkH1 = [30,50,35,65,45,60,75,55,70,85,65,100]; @endphp
                    @foreach($sparkH1 as $i => $h)
                        <div class="pac-spark"
                             style="height:{{$h}}%; background:{{ $loop->last ? '#b5cc18' : 'rgba(181,204,24,0.2)' }}; animation-delay:{{ $i * 0.03 }}s;"></div>
                    @endforeach
                </div>
            </a>
        </div>

        {{-- Stat: Active Clients --}}
        <div class="col-6 col-xl">
            <a href="{{ route('admin.clients.index') }}" class="pac-stat accent-metal h-100">
                <div class="pac-stat-top">
                    <div class="pac-stat-icon" style="background: rgba(107,114,128,0.1);">
                        <i class="ri ri-group-line" style="color: #374151;"></i>
                    </div>
                    <span class="pac-stat-delta pac-delta-neu">—</span>
                </div>
                <div class="pac-stat-num">—</div>
                <div class="pac-stat-label">Active Clients</div>
                <div class="pac-sparkline">
                    @php $sparkH2 = [20,40,30,55,45,50,65,55,75,60,80,70]; @endphp
                    @foreach($sparkH2 as $i => $h)
                        <div class="pac-spark"
                             style="height:{{$h}}%; background:{{ $loop->last ? '#6b7280' : 'rgba(107,114,128,0.18)' }}; animation-delay:{{ $i * 0.03 }}s;"></div>
                    @endforeach
                </div>
            </a>
        </div>

        {{-- Stat: Projects In Progress --}}
        <div class="col-6 col-xl">
            <a href="{{ route('admin.projects.index') }}" class="pac-stat accent-ink h-100">
                <div class="pac-stat-top">
                    <div class="pac-stat-icon" style="background: rgba(17,24,39,0.08);">
                        <i class="ri ri-layout-column-line" style="color: #374151;"></i>
                    </div>
                    <span class="pac-stat-delta pac-delta-neu">—</span>
                </div>
                <div class="pac-stat-num">—</div>
                <div class="pac-stat-label">Projects In Progress</div>
                <div class="pac-sparkline">
                    @php $sparkH3 = [55,40,65,50,75,55,60,72,62,80,68,88]; @endphp
                    @foreach($sparkH3 as $i => $h)
                        <div class="pac-spark"
                             style="height:{{$h}}%; background:{{ $loop->last ? '#111827' : 'rgba(17,24,39,0.12)' }}; animation-delay:{{ $i * 0.03 }}s;"></div>
                    @endforeach
                </div>
            </a>
        </div>

        {{-- Stat: Unread Messages --}}
        <div class="col-6 col-xl">
            <a href="{{ route('admin.inbox.index') }}" class="pac-stat accent-red h-100">
                <div class="pac-stat-top">
                    <div class="pac-stat-icon" style="background: rgba(239,68,68,0.1);">
                        <i class="ri ri-message-3-line" style="color: #b91c1c;"></i>
                    </div>
                    <span class="pac-stat-delta pac-delta-neu">—</span>
                </div>
                <div class="pac-stat-num">—</div>
                <div class="pac-stat-label">Unread Messages</div>
                <div class="pac-sparkline">
                    @php $sparkH4 = [80,55,85,40,70,35,60,45,55,35,50,25]; @endphp
                    @foreach($sparkH4 as $i => $h)
                        <div class="pac-spark"
                             style="height:{{$h}}%; background:{{ $loop->last ? 'rgba(239,68,68,0.75)' : 'rgba(239,68,68,0.14)' }}; animation-delay:{{ $i * 0.03 }}s;"></div>
                    @endforeach
                </div>
            </a>
        </div>

    </div>
    {{-- / ROW 1 --}}


    {{-- ════════════════════════════════════════════════════════
         ROW 2 — RECENT INVOICES (7) + CLIENTS & QUICK ACTIONS (5)
    ═════════════════════════════════════════════════════════ --}}
    <div class="row g-4 mb-4 pac-dash-row">

        {{-- Recent Invoices --}}
        <div class="col-12 col-xl-7">
            <div class="card h-100" style="border-radius: 0.75rem; overflow: hidden;">
                <div class="pac-card-header">
                    <div>
                        <div class="pac-card-eyebrow"></div>
                        <p class="pac-card-title">Recent Invoices</p>
                        <p class="pac-card-sub">Latest billing activity</p>
                    </div>
                    <a href="{{ route('admin.invoices.index') }}" class="pac-view-all">View All</a>
                </div>

                {{--
                    ── WIRING GUIDE ────────────────────────────────────────────
                    Controller: DashboardController@index
                    Pass: $recentInvoices = Invoice::with('client')
                                              ->latest()->limit(6)->get()

                    Replace the pac-empty block below with:

                    @forelse($recentInvoices as $inv)
                        <div class="pac-table-row">
                            <span class="pac-inv-num">#{{ $inv->number }}</span>
                            <span class="pac-inv-client">{{ $inv->client->name }}</span>
                            <span class="pac-inv-amount">₦{{ number_format($inv->amount, 2) }}</span>
                            <span class="pac-inv-due">{{ $inv->due_date?->format('d M Y') ?? '—' }}</span>
                            <div class="text-end">
                                <span class="pac-badge pac-badge-{{ $inv->status }}">
                                    {{ ucfirst($inv->status) }}
                                </span>
                            </div>
                        </div>
                    @empty
                        [empty state below]
                    @endforelse
                    ── / WIRING GUIDE ──────────────────────────────────────────
                --}}

                {{-- Table column headers (always visible) --}}
                <div class="pac-table-head">
                    <span>#</span>
                    <span>Client</span>
                    <span>Amount</span>
                    <span>Due</span>
                    <span class="text-end">Status</span>
                </div>

                {{-- Empty state (remove once data is wired) --}}
                <div class="pac-empty">
                    <div class="pac-empty-ring">
                        <i class="ri ri-file-list-3-line"></i>
                    </div>
                    <p>No invoices yet.</p>
                    <a href="{{ route('admin.invoices.create') }}">Create your first invoice →</a>
                </div>

            </div>
        </div>

        {{-- Right column: Recent Clients + Quick Actions --}}
        <div class="col-12 col-xl-5 d-flex flex-column gap-4">

            {{-- Recent Clients --}}
            <div class="card" style="border-radius: 0.75rem;">
                <div class="pac-card-header">
                    <div>
                        <div class="pac-card-eyebrow"></div>
                        <p class="pac-card-title">Recent Clients</p>
                        <p class="pac-card-sub">Newly onboarded</p>
                    </div>
                    <a href="{{ route('admin.clients.index') }}" class="pac-view-all">View All</a>
                </div>
                <div class="card-body py-2 px-4">
                    {{--
                        ── WIRING GUIDE ──────────────────────────────────────
                        Pass: $recentClients = Client::latest()->limit(4)->get()

                        Replace pac-empty with:
                        @forelse($recentClients as $client)
                        <div class="pac-client-row">
                            <div class="pac-client-avatar">
                                {{ strtoupper(substr($client->name, 0, 2)) }}
                            </div>
                            <div class="flex-grow-1 min-width-0">
                                <p class="pac-client-name">{{ $client->name }}</p>
                                <p class="pac-client-email">{{ $client->email }}</p>
                            </div>
                            <a href="{{ route('admin.clients.show', $client) }}"
                               class="pac-client-link">View →</a>
                        </div>
                        @empty ... @endforelse
                        ── / WIRING GUIDE ────────────────────────────────────
                    --}}
                    <div class="pac-empty" style="padding: 1.75rem 0;">
                        <div class="pac-empty-ring">
                            <i class="ri ri-group-line"></i>
                        </div>
                        <p>No clients yet.</p>
                        <a href="{{ route('admin.clients.create') }}">Add your first client →</a>
                    </div>
                </div>
            </div>

            {{-- Quick Actions --}}
            <div class="card" style="border-radius: 0.75rem;">
                <div class="pac-card-header">
                    <div>
                        <div class="pac-card-eyebrow"></div>
                        <p class="pac-card-title">Quick Actions</p>
                        <p class="pac-card-sub">Jump straight in</p>
                    </div>
                </div>
                <div class="card-body pt-0 pb-3 px-4">
                    <div class="pac-qa-grid mt-3">
                        <a href="{{ route('admin.invoices.create') }}" class="pac-qa-btn">
                            <div class="pac-qa-icon" style="background: rgba(181,204,24,0.12);">
                                <i class="ri ri-file-add-line" style="color: var(--pac-peridot-dim);"></i>
                            </div>
                            <div>
                                <p class="pac-qa-label">New Invoice</p>
                                <p class="pac-qa-sub">Bill a client</p>
                            </div>
                        </a>
                        <a href="{{ route('admin.clients.create') }}" class="pac-qa-btn">
                            <div class="pac-qa-icon" style="background: rgba(107,114,128,0.1);">
                                <i class="ri ri-user-add-line" style="color: #374151;"></i>
                            </div>
                            <div>
                                <p class="pac-qa-label">Add Client</p>
                                <p class="pac-qa-sub">New relationship</p>
                            </div>
                        </a>
                        <a href="{{ route('admin.projects.index') }}" class="pac-qa-btn">
                            <div class="pac-qa-icon" style="background: rgba(17,24,39,0.07);">
                                <i class="ri ri-layout-column-line" style="color: #374151;"></i>
                            </div>
                            <div>
                                <p class="pac-qa-label">Projects</p>
                                <p class="pac-qa-sub">Kanban board</p>
                            </div>
                        </a>
                        <a href="{{ route('admin.letters.index') }}" class="pac-qa-btn">
                            <div class="pac-qa-icon" style="background: rgba(181,204,24,0.1);">
                                <i class="ri ri-quill-pen-line" style="color: var(--pac-peridot-dim);"></i>
                            </div>
                            <div>
                                <p class="pac-qa-label">New Letter</p>
                                <p class="pac-qa-sub">Draft & send</p>
                            </div>
                        </a>
                        <a href="{{ route('admin.inbox.index') }}" class="pac-qa-btn">
                            <div class="pac-qa-icon" style="background: rgba(59,130,246,0.08);">
                                <i class="ri ri-inbox-line" style="color: #1d4ed8;"></i>
                            </div>
                            <div>
                                <p class="pac-qa-label">Inbox</p>
                                <p class="pac-qa-sub">Check messages</p>
                            </div>
                        </a>
                        <a href="{{ route('admin.chat.index') }}" class="pac-qa-btn">
                            <div class="pac-qa-icon" style="background: rgba(239,68,68,0.08);">
                                <i class="ri ri-message-3-line" style="color: #b91c1c;"></i>
                            </div>
                            <div>
                                <p class="pac-qa-label">Chat</p>
                                <p class="pac-qa-sub">Team messages</p>
                            </div>
                        </a>
                    </div>
                </div>
            </div>

        </div>

    </div>
    {{-- / ROW 2 --}}


    {{-- ════════════════════════════════════════════════════════
         ROW 3 — ACTIVITY FEED (4) + PROJECT PIPELINE (4) + AUDIT LINK (4)
    ═════════════════════════════════════════════════════════ --}}
    <div class="row g-4 pac-dash-row">

        {{-- Activity Feed --}}
        <div class="col-12 col-xl-5">
            <div class="card h-100" style="border-radius: 0.75rem;">
                <div class="pac-card-header">
                    <div>
                        <div class="pac-card-eyebrow"></div>
                        <p class="pac-card-title">Recent Activity</p>
                        <p class="pac-card-sub">Audit trail — latest actions</p>
                    </div>
                </div>
                <div class="card-body px-4 py-3">
                    {{--
                        ── WIRING GUIDE ──────────────────────────────────────
                        Pass: $recentLogs = ActivityLog::latest()->limit(6)->get()

                        Replace ul content with:
                        @forelse($recentLogs as $log)
                        <li class="pac-feed-item">
                            <div class="pac-feed-dot peridot">
                                <i class="ri ri-{{ $log->icon ?? 'information-line' }}"></i>
                            </div>
                            <div class="pac-feed-body">
                                <p class="pac-feed-text">{!! $log->description !!}</p>
                                <span class="pac-feed-time">{{ $log->created_at->diffForHumans() }}</span>
                            </div>
                        </li>
                        @empty ... @endforelse
                        ── / WIRING GUIDE ────────────────────────────────────
                    --}}
                    <ul class="pac-feed">
                        <li class="pac-feed-item">
                            <div class="pac-feed-dot peridot">
                                <i class="ri ri-information-line"></i>
                            </div>
                            <div class="pac-feed-body">
                                <p class="pac-feed-text">No recent activity recorded.</p>
                                <span class="pac-feed-time">Activity will appear here as you use the system.</span>
                            </div>
                        </li>
                    </ul>
                </div>
                <div class="card-footer py-2 px-4" style="background: transparent; border-top: 1px solid var(--bs-border-color);">
                    <a href="{{ route('admin.logs.index') }}"
                       style="font-size: 0.77rem; color: var(--pac-peridot-dim); text-decoration: none; font-weight: 600;">
                        View full audit log <i class="ri ri-arrow-right-line"></i>
                    </a>
                </div>
            </div>
        </div>

        {{-- Project Pipeline --}}
        <div class="col-12 col-xl-4">
            <div class="card h-100" style="border-radius: 0.75rem;">
                <div class="pac-card-header">
                    <div>
                        <div class="pac-card-eyebrow"></div>
                        <p class="pac-card-title">Project Pipeline</p>
                        <p class="pac-card-sub">Status breakdown</p>
                    </div>
                    <a href="{{ route('admin.projects.index') }}" class="pac-view-all">Open Board</a>
                </div>
                <div class="card-body px-4 py-3">

                    {{-- Donut + summary --}}
                    <div class="d-flex align-items-center gap-3 mb-4">
                        <div class="pac-donut-wrap">
                            <svg viewBox="0 0 86 86" width="86" height="86">
                                <circle cx="43" cy="43" r="36"
                                        fill="none" stroke="#eef0f2" stroke-width="10"/>
                                <circle cx="43" cy="43" r="36"
                                        fill="none" stroke="#b5cc18" stroke-width="10"
                                        stroke-dasharray="0 226.2"
                                        stroke-linecap="round"
                                        transform="rotate(-90 43 43)"
                                        id="pac-donut-arc"/>
                            </svg>
                            <div class="pac-donut-center">
                                <span class="pac-donut-num" id="pac-donut-label">0</span>
                                <span class="pac-donut-sub">total</span>
                            </div>
                        </div>
                        <div>
                            <p style="font-size: 0.78rem; color: var(--bs-body-secondary); margin: 0 0 0.5rem; line-height: 1.5;">
                                Track active, on-hold, and completed work across your studio.
                            </p>
                            <a href="{{ route('admin.projects.index') }}" class="pac-view-all" style="display: inline-block;">
                                Go to Projects
                            </a>
                        </div>
                    </div>

                    {{--
                        ── WIRING GUIDE ──────────────────────────────────────
                        Pass: $projectStats from DashboardController:
                        $projectStats = [
                            'total'       => Project::count(),
                            'in_progress' => Project::where('status','in_progress')->count(),
                            'on_hold'     => Project::where('status','on_hold')->count(),
                            'completed'   => Project::where('status','completed')->count(),
                            'backlog'     => Project::where('status','backlog')->count(),
                        ];
                        Then swap the static % values below for calculated ones.
                        ── / WIRING GUIDE ────────────────────────────────────
                    --}}

                    {{-- Status bars --}}
                    <div class="pac-pipe-row">
                        <div class="pac-pipe-meta">
                            <span class="pac-pipe-name">
                                <span class="pac-pipe-dot" style="background: #b5cc18;"></span>
                                In Progress
                            </span>
                            <span class="pac-pipe-pct">—</span>
                        </div>
                        <div class="pac-bar-track">
                            <div class="pac-bar-fill" style="width: 0%;"></div>
                        </div>
                    </div>
                    <div class="pac-pipe-row">
                        <div class="pac-pipe-meta">
                            <span class="pac-pipe-name">
                                <span class="pac-pipe-dot" style="background: #6b7280;"></span>
                                On Hold
                            </span>
                            <span class="pac-pipe-pct">—</span>
                        </div>
                        <div class="pac-bar-track">
                            <div class="pac-bar-fill" style="width: 0%; background: #6b7280;"></div>
                        </div>
                    </div>
                    <div class="pac-pipe-row">
                        <div class="pac-pipe-meta">
                            <span class="pac-pipe-name">
                                <span class="pac-pipe-dot" style="background: #111827;"></span>
                                Completed
                            </span>
                            <span class="pac-pipe-pct">—</span>
                        </div>
                        <div class="pac-bar-track">
                            <div class="pac-bar-fill" style="width: 0%; background: #111827;"></div>
                        </div>
                    </div>
                    <div class="pac-pipe-row">
                        <div class="pac-pipe-meta">
                            <span class="pac-pipe-name">
                                <span class="pac-pipe-dot" style="background: #d1d5db; border: 1px solid #e5e7eb;"></span>
                                Backlog
                            </span>
                            <span class="pac-pipe-pct">—</span>
                        </div>
                        <div class="pac-bar-track">
                            <div class="pac-bar-fill" style="width: 0%; background: #d1d5db;"></div>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        {{-- Letters + Logs quick links --}}
        <div class="col-12 col-xl-3 d-flex flex-column gap-4">

            {{-- Letters card --}}
            <div class="card" style="border-radius: 0.75rem;">
                <div class="pac-card-header">
                    <div>
                        <div class="pac-card-eyebrow"></div>
                        <p class="pac-card-title">Letters</p>
                        <p class="pac-card-sub">Correspondence</p>
                    </div>
                    <a href="{{ route('admin.letters.index') }}" class="pac-view-all">View All</a>
                </div>
                <div class="card-body px-4 py-3">
                    <div class="pac-empty" style="padding: 1.25rem 0;">
                        <div class="pac-empty-ring">
                            <i class="ri ri-quill-pen-line"></i>
                        </div>
                        <p>No letters yet.</p>
                        <a href="{{ route('admin.letters.index') }}">Draft your first →</a>
                    </div>
                </div>
            </div>

            {{-- Settings shortcut --}}
            <div class="card flex-grow-1" style="border-radius: 0.75rem;">
                <div class="card-body d-flex flex-column justify-content-center align-items-center text-center px-3 py-4">
                    <div style="width: 44px; height: 44px; border-radius: 10px; background: rgba(17,24,39,0.07); display: flex; align-items: center; justify-content: center; margin-bottom: 0.75rem;">
                        <i class="ri ri-settings-4-line" style="font-size: 1.15rem; color: #374151;"></i>
                    </div>
                    <p style="font-size: 0.8rem; font-weight: 600; color: var(--pac-ink); margin: 0 0 0.25rem;">Settings</p>
                    <p style="font-size: 0.72rem; color: #9ca3af; margin: 0 0 0.875rem;">Preferences & config</p>
                    <a href="{{ route('admin.settings.index') }}"
                       style="font-size: 0.75rem; font-weight: 600; color: var(--pac-peridot-dim); text-decoration: none; border: 1px solid rgba(181,204,24,0.35); border-radius: 0.35rem; padding: 0.25rem 0.75rem;">
                        Open Settings
                    </a>
                </div>
            </div>

        </div>

    </div>
    {{-- / ROW 3 --}}


    @push('page-js')
        <script>
            /**
             * PAC DASHBOARD — Init
             * ─────────────────────────────────────────────────
             * Donut arc animation.
             * Wire $projectStats from DashboardController.
             * Replace JS variable `total` with: {{ $projectStats['total'] ?? 0 }}
            */
            (function () {
                var total = 0; // ← replace: {{ $projectStats['total'] ?? 0 }}
                var arc   = document.getElementById('pac-donut-arc');
                var label = document.getElementById('pac-donut-label');

                if (arc && label) {
                    var circumference = 2 * Math.PI * 36; // r=36
                    var maxProjects   = 20; // scale denominator — adjust to your expected max
                    var pct = total > 0 ? Math.min(total / maxProjects, 1) : 0;

                    // Animate the arc
                    var current = 0;
                    var target  = pct * circumference;
                    var step    = target / 40;

                    function tick() {
                        current += step;
                        if (current >= target) current = target;
                        arc.setAttribute(
                            'stroke-dasharray',
                            current.toFixed(2) + ' ' + circumference.toFixed(2)
                        );
                        if (current < target) requestAnimationFrame(tick);
                    }

                    if (target > 0) setTimeout(function () { requestAnimationFrame(tick); }, 300);

                    label.textContent = total;
                }
            })();
        </script>
    @endpush

</x-admin-layout>
