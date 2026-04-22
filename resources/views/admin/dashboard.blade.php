<x-admin-layout title="Dashboard">

    @push('page-css')
        <link rel="stylesheet" href="{{ asset('admin/assets/vendor/libs/apex-charts/apex-charts.css') }}">
        <style>
            /* ── Animations ── */
            @keyframes pac-rise {
                from { opacity: 0; transform: translateY(8px); }
                to   { opacity: 1; transform: translateY(0); }
            }
            @keyframes pac-pulse {
                0%, 100% { opacity: 1; transform: scale(1); }
                50%       { opacity: 0.45; transform: scale(0.8); }
            }
            @keyframes pac-bar-in {
                from { width: 0 !important; }
            }

            .pac-row-1 { animation: pac-rise 0.35s ease both 0.05s; }
            .pac-row-2 { animation: pac-rise 0.35s ease both 0.13s; }
            .pac-row-3 { animation: pac-rise 0.35s ease both 0.21s; }

            /* ══════════════════════════════════════
               WELCOME BANNER
            ══════════════════════════════════════ */
            .pac-welcome {
                background: linear-gradient(140deg, #0d1117 0%, #111827 55%, #1a2435 100%);
                border-radius: 0.875rem;
                padding: 2rem 2rem 1.75rem;
                position: relative;
                overflow: hidden;
                border: 1px solid rgba(255,255,255,0.04);
                height: 100%;
            }
            .pac-welcome-grid {
                position: absolute; inset: 0;
                background-image:
                    linear-gradient(rgba(255,255,255,0.018) 1px, transparent 1px),
                    linear-gradient(90deg, rgba(255,255,255,0.018) 1px, transparent 1px);
                background-size: 28px 28px;
                pointer-events: none;
            }
            .pac-welcome-glow {
                position: absolute;
                top: -80px; right: -80px;
                width: 260px; height: 260px;
                border-radius: 50%;
                background: radial-gradient(circle, rgba(181,204,24,0.13) 0%, transparent 65%);
                pointer-events: none;
            }
            .pac-welcome-inner { position: relative; z-index: 1; display: flex; flex-direction: column; height: 100%; }

            .pac-badge {
                display: inline-flex;
                align-items: center;
                gap: 7px;
                background: rgba(181,204,24,0.11);
                border: 1px solid rgba(181,204,24,0.26);
                border-radius: 100px;
                padding: 4px 12px 4px 8px;
                font-size: 0.68rem;
                font-weight: 700;
                color: #b5cc18;
                letter-spacing: 0.05em;
                text-transform: uppercase;
                margin-bottom: 1.1rem;
                width: fit-content;
                align-self: flex-start;
            }
            .pac-pulse-dot {
                width: 6px; height: 6px;
                border-radius: 50%;
                background: #b5cc18;
                animation: pac-pulse 2s ease-in-out infinite;
            }
            .pac-welcome h4 {
                font-size: 1.5rem;
                font-weight: 800;
                color: #fff;
                line-height: 1.2;
                margin-bottom: 0.5rem;
                letter-spacing: -0.02em;
            }
            .pac-welcome-sub {
                font-size: 0.82rem;
                color: rgba(255,255,255,0.42);
                line-height: 1.6;
                margin-bottom: 0;
            }
            .pac-welcome-meta {
                font-size: 0.7rem;
                color: rgba(255,255,255,0.28);
                margin-top: 1rem;
                letter-spacing: 0.02em;
                display: flex;
                align-items: center;
                gap: 0.5rem;
            }
            .pac-meta-sep {
                width: 3px; height: 3px;
                border-radius: 50%;
                background: rgba(255,255,255,0.2);
            }
            .pac-cta-row { margin-top: auto; padding-top: 1.5rem; display: flex; gap: 0.5rem; flex-wrap: wrap; }
            .pac-cta-primary {
                display: inline-flex; align-items: center; gap: 6px;
                background: #b5cc18; color: #111827;
                font-size: 0.8rem; font-weight: 700;
                padding: 0.5rem 1.1rem;
                border-radius: 0.4rem;
                text-decoration: none;
                transition: background 0.15s, transform 0.15s, box-shadow 0.15s;
            }
            .pac-cta-primary:hover {
                background: #96aa12; color: #111827;
                transform: translateY(-1px);
                box-shadow: 0 4px 16px rgba(181,204,24,0.32);
            }
            .pac-cta-ghost {
                display: inline-flex; align-items: center; gap: 6px;
                background: rgba(255,255,255,0.07);
                border: 1px solid rgba(255,255,255,0.1);
                color: rgba(255,255,255,0.68);
                font-size: 0.8rem; font-weight: 500;
                padding: 0.5rem 1rem;
                border-radius: 0.4rem;
                text-decoration: none;
                transition: background 0.15s, border-color 0.15s, color 0.15s;
            }
            .pac-cta-ghost:hover {
                background: rgba(255,255,255,0.12);
                border-color: rgba(255,255,255,0.2);
                color: #fff;
            }

            /* ══════════════════════════════════════
               STAT CARDS (2x2 grid)
            ══════════════════════════════════════ */
            .pac-stat-grid {
                display: grid;
                grid-template-columns: 1fr 1fr;
                grid-template-rows: 1fr 1fr;
                gap: 1rem;
                height: 100%;
                min-height: 0;
            }
            /* Force cards to share the available height equally */
            .pac-stat {
                min-height: 0 !important;
            }
            .pac-stat {
                background: #fff;
                border: 1px solid #e5e7eb;
                border-radius: 0.75rem;
                padding: 1.25rem 1.375rem;
                display: flex;
                flex-direction: column;
                position: relative;
                overflow: hidden;
                text-decoration: none;
                color: inherit;
                transition: transform 0.18s ease, box-shadow 0.18s ease, border-color 0.18s ease;
            }
            .pac-stat:hover {
                transform: translateY(-2px);
                box-shadow: 0 6px 22px rgba(0,0,0,0.08);
                color: inherit;
            }
            .pac-stat.s-peridot:hover { border-color: rgba(181,204,24,0.4); }
            .pac-stat.s-metal:hover   { border-color: rgba(107,114,128,0.35); }
            .pac-stat.s-ink:hover     { border-color: rgba(17,24,39,0.25); }
            .pac-stat.s-red:hover     { border-color: rgba(239,68,68,0.3); }

            /* Top accent stripe on hover */
            .pac-stat::after {
                content: '';
                position: absolute;
                top: 0; left: 0; right: 0;
                height: 2px;
                border-radius: 0.75rem 0.75rem 0 0;
                opacity: 0;
                transition: opacity 0.18s;
            }
            .pac-stat:hover::after { opacity: 1; }
            .pac-stat.s-peridot::after { background: #b5cc18; }
            .pac-stat.s-metal::after   { background: #6b7280; }
            .pac-stat.s-ink::after     { background: #111827; }
            .pac-stat.s-red::after     { background: #ef4444; }

            .pac-stat-row {
                display: flex;
                align-items: flex-start;
                justify-content: space-between;
                margin-bottom: 0.875rem;
            }
            .pac-stat-icon {
                width: 40px; height: 40px;
                border-radius: 10px;
                display: flex; align-items: center; justify-content: center;
                font-size: 1.1rem;
                flex-shrink: 0;
            }
            .pac-stat-delta {
                font-size: 0.68rem;
                font-weight: 700;
                padding: 2px 8px;
                border-radius: 100px;
            }
            .d-up   { background: rgba(34,197,94,0.1);  color: #15803d; }
            .d-down { background: rgba(239,68,68,0.1);  color: #b91c1c; }
            .d-neu  { background: rgba(107,114,128,0.1); color: #6b7280; }

            .pac-stat-num {
                font-size: 1.85rem;
                font-weight: 800;
                color: #111827;
                line-height: 1;
                letter-spacing: -0.03em;
                margin-bottom: 0.2rem;
            }
            .pac-stat-label {
                font-size: 0.74rem;
                color: #9ca3af;
                font-weight: 500;
            }
            .pac-stat-trend {
                margin-top: auto;
                padding-top: 0.875rem;
                font-size: 0.72rem;
                color: #9ca3af;
                border-top: 1px solid #f3f4f6;
            }
            .pac-stat-trend strong { font-weight: 600; color: #374151; }

            /* Dark mode stat cards */
            [data-bs-theme="dark"] .pac-stat {
                background: var(--bs-paper-bg);
                border-color: rgba(255,255,255,0.07);
            }
            [data-bs-theme="dark"] .pac-stat-num { color: #f9fafb; }
            [data-bs-theme="dark"] .pac-stat-trend { border-color: rgba(255,255,255,0.06); }

            /* ══════════════════════════════════════
               CARD HEADER (no eyebrow bar)
            ══════════════════════════════════════ */
            .pac-card-hd {
                display: flex;
                align-items: center;
                justify-content: space-between;
                padding: 1.125rem 1.5rem 1rem;
                border-bottom: 1px solid var(--bs-border-color, #e5e7eb);
            }
            .pac-card-title {
                font-size: 0.9rem;
                font-weight: 700;
                color: #111827;
                margin: 0 0 1px;
                line-height: 1.2;
            }
            .pac-card-sub {
                font-size: 0.71rem;
                color: #9ca3af;
                margin: 0;
            }
            .pac-view-all {
                font-size: 0.72rem;
                font-weight: 600;
                color: #96aa12;
                border: 1px solid rgba(181,204,24,0.35);
                border-radius: 0.35rem;
                padding: 0.22rem 0.7rem;
                text-decoration: none;
                white-space: nowrap;
                transition: background 0.15s, border-color 0.15s;
            }
            .pac-view-all:hover {
                background: rgba(181,204,24,0.07);
                border-color: rgba(181,204,24,0.55);
                color: #96aa12;
            }

            /* ══════════════════════════════════════
               INVOICE TABLE
            ══════════════════════════════════════ */
            .pac-tbl-head {
                display: grid;
                grid-template-columns: 80px 1fr 110px 95px 80px;
                gap: 0.5rem;
                padding: 0.6rem 1.5rem;
                background: #f9fafb;
                border-bottom: 1px solid #e5e7eb;
                font-size: 0.66rem;
                font-weight: 700;
                text-transform: uppercase;
                letter-spacing: 0.08em;
                color: #9ca3af;
            }
            .pac-tbl-row {
                display: grid;
                grid-template-columns: 80px 1fr 110px 95px 80px;
                gap: 0.5rem;
                padding: 0.85rem 1.5rem;
                border-bottom: 1px solid #f3f4f6;
                align-items: center;
                font-size: 0.81rem;
                transition: background 0.1s;
            }
            .pac-tbl-row:last-child { border-bottom: none; }
            .pac-tbl-row:hover { background: #fafafa; }

            .t-num    { font-weight: 700; color: #96aa12; font-size: 0.77rem; }
            .t-client { font-weight: 600; color: #111827; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
            .t-amt    { font-weight: 700; color: #111827; }
            .t-due    { color: #9ca3af; font-size: 0.74rem; }

            .pac-pill {
                font-size: 0.65rem; font-weight: 700;
                padding: 3px 9px; border-radius: 100px;
                white-space: nowrap;
            }
            .p-draft   { background: #f1f5f9; color: #64748b; }
            .p-sent    { background: rgba(59,130,246,0.1); color: #1d4ed8; }
            .p-paid    { background: rgba(34,197,94,0.1);  color: #15803d; }
            .p-overdue { background: rgba(239,68,68,0.1);  color: #b91c1c; }
            .p-partial { background: rgba(245,158,11,0.1); color: #b45309; }

            /* ══════════════════════════════════════
               EMPTY STATE
            ══════════════════════════════════════ */
            .pac-empty {
                display: flex; flex-direction: column;
                align-items: center; justify-content: center;
                padding: 2.5rem 1.5rem; text-align: center;
            }
            .pac-empty-ring {
                width: 52px; height: 52px; border-radius: 50%;
                border: 2px dashed rgba(181,204,24,0.3);
                display: flex; align-items: center; justify-content: center;
                background: rgba(181,204,24,0.05);
                margin-bottom: 0.875rem;
            }
            .pac-empty-ring i { font-size: 1.3rem; color: rgba(181,204,24,0.5); }
            .pac-empty p { font-size: 0.8rem; color: #9ca3af; margin: 0 0 0.35rem; }
            .pac-empty a { font-size: 0.78rem; color: #96aa12; font-weight: 600; text-decoration: none; }
            .pac-empty a:hover { text-decoration: underline; }

            /* ══════════════════════════════════════
               CLIENT LIST
            ══════════════════════════════════════ */
            .pac-client {
                display: flex; align-items: center; gap: 0.75rem;
                padding: 0.7rem 0;
                border-bottom: 1px solid #f3f4f6;
            }
            .pac-client:last-child { border-bottom: none; padding-bottom: 0; }
            .pac-client-av {
                width: 36px; height: 36px; border-radius: 50%;
                background: rgba(181,204,24,0.12);
                display: flex; align-items: center; justify-content: center;
                font-size: 0.75rem; font-weight: 700; color: #96aa12;
                flex-shrink: 0;
            }
            .pac-client-name  { font-size: 0.81rem; font-weight: 600; color: #111827; margin: 0; }
            .pac-client-email { font-size: 0.7rem; color: #9ca3af; margin: 0; }
            .pac-client-link  { font-size: 0.69rem; color: #96aa12; text-decoration: none; white-space: nowrap; margin-left: auto; }
            .pac-client-link:hover { text-decoration: underline; }

            /* ══════════════════════════════════════
               QUICK ACTIONS
            ══════════════════════════════════════ */
            .pac-qa-grid {
                display: grid;
                grid-template-columns: 1fr 1fr;
                gap: 0.6rem;
            }
            .pac-qa {
                display: flex; align-items: center; gap: 0.7rem;
                padding: 0.8rem;
                border-radius: 0.5rem;
                background: #f8f9fa;
                border: 1px solid #eef0f2;
                text-decoration: none; color: inherit;
                transition: all 0.15s ease;
            }
            .pac-qa:hover {
                background: #fff;
                border-color: rgba(181,204,24,0.38);
                transform: translateY(-1px);
                box-shadow: 0 3px 10px rgba(0,0,0,0.05);
                color: inherit;
            }
            .pac-qa-ic {
                width: 32px; height: 32px; border-radius: 8px;
                display: flex; align-items: center; justify-content: center;
                font-size: 0.9rem; flex-shrink: 0;
            }
            .pac-qa-lbl { font-size: 0.77rem; font-weight: 700; color: #111827; margin: 0; line-height: 1.2; }
            .pac-qa-sub { font-size: 0.67rem; color: #9ca3af; margin: 0; }

            [data-bs-theme="dark"] .pac-qa { background: rgba(255,255,255,0.04); border-color: rgba(255,255,255,0.06); }
            [data-bs-theme="dark"] .pac-qa:hover { background: rgba(255,255,255,0.07); }

            /* ══════════════════════════════════════
               ACTIVITY FEED
            ══════════════════════════════════════ */
            .pac-feed { list-style: none; padding: 0; margin: 0; position: relative; }
            .pac-feed::before {
                content: '';
                position: absolute;
                left: 16px; top: 16px; bottom: 16px;
                width: 1px;
                background: linear-gradient(to bottom, rgba(181,204,24,0.3), transparent);
            }
            .pac-feed-item { display: flex; gap: 0.8rem; padding: 0.8rem 0; position: relative; }
            .pac-feed-item:last-child { padding-bottom: 0; }
            .pac-feed-dot {
                width: 32px; height: 32px; border-radius: 50%;
                display: flex; align-items: center; justify-content: center;
                font-size: 0.82rem; flex-shrink: 0; position: relative; z-index: 1;
            }
            .fd-peridot { background: rgba(181,204,24,0.12); color: #96aa12; }
            .fd-metal   { background: rgba(107,114,128,0.1); color: #4b5563; }
            .fd-red     { background: rgba(239,68,68,0.1);   color: #b91c1c; }
            .fd-blue    { background: rgba(59,130,246,0.1);  color: #1d4ed8; }
            .pac-feed-body { flex: 1; min-width: 0; padding-top: 2px; }
            .pac-feed-text { font-size: 0.8rem; color: #111827; margin: 0 0 2px; line-height: 1.4; }
            .pac-feed-text strong { font-weight: 600; }
            .pac-feed-time { font-size: 0.68rem; color: #9ca3af; }

            [data-bs-theme="dark"] .pac-feed-text { color: var(--bs-body-color); }

            /* ══════════════════════════════════════
               PROJECT PIPELINE
            ══════════════════════════════════════ */
            .pac-donut-wrap { position: relative; width: 80px; height: 80px; flex-shrink: 0; }
            .pac-donut-center {
                position: absolute; inset: 0;
                display: flex; flex-direction: column; align-items: center; justify-content: center;
            }
            .pac-donut-num { font-size: 1.2rem; font-weight: 800; color: #111827; line-height: 1; }
            .pac-donut-sub { font-size: 0.58rem; color: #9ca3af; text-transform: uppercase; letter-spacing: 0.05em; }

            .pac-pipe { margin-bottom: 0.8rem; }
            .pac-pipe:last-child { margin-bottom: 0; }
            .pac-pipe-meta { display: flex; justify-content: space-between; margin-bottom: 4px; }
            .pac-pipe-name {
                font-size: 0.76rem; font-weight: 500; color: #111827;
                display: flex; align-items: center; gap: 6px;
            }
            .pac-pipe-dot { width: 7px; height: 7px; border-radius: 2px; flex-shrink: 0; }
            .pac-pipe-pct { font-size: 0.72rem; color: #9ca3af; font-weight: 600; }
            .pac-bar-track { height: 5px; border-radius: 3px; background: #eef0f2; overflow: hidden; }
            .pac-bar-fill  { height: 100%; border-radius: 3px; animation: pac-bar-in 0.8s ease both; }

            [data-bs-theme="dark"] .pac-bar-track { background: rgba(255,255,255,0.08); }
            [data-bs-theme="dark"] .pac-donut-num { color: #f9fafb; }
            [data-bs-theme="dark"] .pac-pipe-name { color: var(--bs-body-color); }

            /* ── Radial chart wrapper ── */
            .pac-radial-wrap { width: 90px; height: 90px; flex-shrink: 0; }
            .pac-radial-wrap .apexcharts-canvas { overflow: visible !important; }

            /* ── Mobile tweaks ── */
            @media (max-width: 575.98px) {
                .pac-welcome { padding: 1.5rem; }
                .pac-welcome h4 { font-size: 1.2rem; }
                .pac-cta-row { gap: 0.4rem; }
                .pac-cta-primary,
                .pac-cta-ghost { font-size: 0.75rem; padding: 0.4rem 0.875rem; }
                .pac-qa-grid { grid-template-columns: 1fr 1fr; }
                .pac-tbl-head,
                .pac-tbl-row { grid-template-columns: 70px 1fr 90px 80px; }
                .pac-tbl-head span:nth-child(4),
                .pac-tbl-row > *:nth-child(4) { display: none; }
            }

            @media (max-width: 767.98px) {
                .pac-stat-grid { grid-template-columns: 1fr 1fr; }
            }
        </style>
    @endpush


    {{-- ══════════════════════════════════════════════════════
         ROW 1 — Welcome Banner (left) + 2×2 Stat Grid (right)
    ═══════════════════════════════════════════════════════ --}}
    <div class="row g-4 mb-4 pac-row-1 align-items-lg-stretch">

        {{-- Welcome Banner --}}
        <div class="col-12 col-lg-5">
            <div class="pac-welcome w-100">
                <div class="pac-welcome-grid"></div>
                <div class="pac-welcome-glow"></div>
                <div class="pac-welcome-inner">

                    <div class="pac-badge">
                        <span class="pac-pulse-dot"></span>
                        Studio Active
                    </div>

                    <h4>
                        @if(now()->hour < 12) Good morning,
                        @elseif(now()->hour < 17) Good afternoon,
                        @else Good evening,
                        @endif
                        {{ auth()->user()->name ?? 'there' }} 👋
                    </h4>

                    <p class="pac-welcome-sub">
                        Here's what's happening across The Pacmedia today.
                        Your studio dashboard is ready.
                    </p>

                    <div class="pac-welcome-meta">
                        <span>{{ now()->format('l, F j Y') }}</span>
                        <span class="pac-meta-sep"></span>
                        <span>Lagos, NG</span>
                    </div>

                    <div class="pac-cta-row">
                        <a href="{{ route('admin.invoices.create') }}" class="pac-cta-primary">
                            <i class="ri ri-add-line" style="font-size:0.82rem;"></i>
                            New Invoice
                        </a>
                        <a href="{{ route('admin.clients.create') }}" class="pac-cta-ghost">
                            <i class="ri ri-user-add-line" style="font-size:0.82rem;"></i>
                            Add Client
                        </a>
                        <a href="{{ route('admin.projects.index') }}" class="pac-cta-ghost">
                            <i class="ri ri-layout-column-line" style="font-size:0.82rem;"></i>
                            Projects
                        </a>
                    </div>

                </div>
            </div>
        </div>

        {{-- 2 Paired Metric Cards --}}
        <div class="col-12 col-lg-7">
            <div class="d-flex flex-column flex-sm-row gap-4 h-100">

                {{-- Card 1: Invoices + Clients --}}
                <div class="card flex-grow-1 mb-0" style="border-radius: 0.75rem; overflow: hidden;">
                    <div class="card-body pb-0">
                        <div class="d-flex align-items-center gap-3">
                            <div id="pac-chart-invoices" class="pac-radial-wrap flex-shrink-0"></div>
                            <div class="min-width-0">
                                <div class="d-flex align-items-center gap-2 flex-wrap">
                                    <h5 class="mb-0" style="font-size:1.5rem; font-weight:800; letter-spacing:-0.03em; color:#111827;">
                                        {{-- replace: {{ $stats['outstanding_invoices'] ?? 0 }} --}}
                                        0
                                    </h5>
                                    <div class="d-flex align-items-center" style="font-size:0.75rem; font-weight:700; color:#9ca3af;">
                                        <span>—%</span>
                                        <i class="ri ri-subtract-line" style="font-size:0.9rem;"></i>
                                    </div>
                                </div>
                                <p class="mb-0 mt-1" style="font-size:0.78rem; color:#9ca3af; font-weight:500;">Outstanding Invoices</p>
                                <p class="mb-0 mt-1" style="font-size:0.7rem; color:#d1d5db;">
                                    <strong style="color:#374151; font-weight:600;">₦0</strong> total pending
                                </p>
                            </div>
                        </div>
                    </div>

                    <hr style="margin: 1.25rem 1.5rem; border-color: #f3f4f6;">

                    <div class="card-body pt-0">
                        <div class="d-flex align-items-center gap-3">
                            <div id="pac-chart-clients" class="pac-radial-wrap flex-shrink-0"></div>
                            <div class="min-width-0">
                                <div class="d-flex align-items-center gap-2 flex-wrap">
                                    <h5 class="mb-0" style="font-size:1.5rem; font-weight:800; letter-spacing:-0.03em; color:#111827;">
                                        {{-- replace: {{ $stats['active_clients'] ?? 0 }} --}}
                                        0
                                    </h5>
                                    <div class="d-flex align-items-center" style="font-size:0.75rem; font-weight:700; color:#9ca3af;">
                                        <span>—%</span>
                                        <i class="ri ri-subtract-line" style="font-size:0.9rem;"></i>
                                    </div>
                                </div>
                                <p class="mb-0 mt-1" style="font-size:0.78rem; color:#9ca3af; font-weight:500;">Active Clients</p>
                                <p class="mb-0 mt-1" style="font-size:0.7rem; color:#d1d5db;">
                                    <strong style="color:#374151; font-weight:600;">0</strong> added this month
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Card 2: Projects + Messages --}}
                <div class="card flex-grow-1 mb-0" style="border-radius: 0.75rem; overflow: hidden;">
                    <div class="card-body pb-0">
                        <div class="d-flex align-items-center gap-3">
                            <div id="pac-chart-projects" class="pac-radial-wrap flex-shrink-0"></div>
                            <div class="min-width-0">
                                <div class="d-flex align-items-center gap-2 flex-wrap">
                                    <h5 class="mb-0" style="font-size:1.5rem; font-weight:800; letter-spacing:-0.03em; color:#111827;">
                                        {{-- replace: {{ $stats['projects_in_progress'] ?? 0 }} --}}
                                        0
                                    </h5>
                                    <div class="d-flex align-items-center" style="font-size:0.75rem; font-weight:700; color:#9ca3af;">
                                        <span>—%</span>
                                        <i class="ri ri-subtract-line" style="font-size:0.9rem;"></i>
                                    </div>
                                </div>
                                <p class="mb-0 mt-1" style="font-size:0.78rem; color:#9ca3af; font-weight:500;">Projects In Progress</p>
                                <p class="mb-0 mt-1" style="font-size:0.7rem; color:#d1d5db;">
                                    <strong style="color:#374151; font-weight:600;">0</strong> due this week
                                </p>
                            </div>
                        </div>
                    </div>

                    <hr style="margin: 1.25rem 1.5rem; border-color: #f3f4f6;">

                    <div class="card-body pt-0">
                        <div class="d-flex align-items-center gap-3">
                            <div id="pac-chart-messages" class="pac-radial-wrap flex-shrink-0"></div>
                            <div class="min-width-0">
                                <div class="d-flex align-items-center gap-2 flex-wrap">
                                    <h5 class="mb-0" style="font-size:1.5rem; font-weight:800; letter-spacing:-0.03em; color:#111827;">
                                        {{-- replace: {{ $stats['unread_messages'] ?? 0 }} --}}
                                        0
                                    </h5>
                                    <div class="d-flex align-items-center" style="font-size:0.75rem; font-weight:700; color:#9ca3af;">
                                        <span>—%</span>
                                        <i class="ri ri-subtract-line" style="font-size:0.9rem;"></i>
                                    </div>
                                </div>
                                <p class="mb-0 mt-1" style="font-size:0.78rem; color:#9ca3af; font-weight:500;">Unread Messages</p>
                                <p class="mb-0 mt-1" style="font-size:0.7rem; color:#d1d5db;">
                                    <strong style="color:#374151; font-weight:600;">0</strong> need a reply
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>

    </div>
    {{-- / ROW 1 --}}


    {{-- ══════════════════════════════════════════════════════
         ROW 2 — Recent Invoices + Right column
    ═══════════════════════════════════════════════════════ --}}
    <div class="row g-4 mb-4 pac-row-2">

        {{-- Recent Invoices --}}
        <div class="col-12 col-xl-7">
            <div class="card h-100" style="border-radius: 0.75rem; overflow: hidden;">
                <div class="pac-card-hd">
                    <div>
                        <p class="pac-card-title">Recent Invoices</p>
                        <p class="pac-card-sub">Latest billing activity</p>
                    </div>
                    <a href="{{ route('admin.invoices.index') }}" class="pac-view-all">View All</a>
                </div>

                {{-- Column headers --}}
                <div class="pac-tbl-head">
                    <span>#</span>
                    <span>Client</span>
                    <span>Amount</span>
                    <span>Due</span>
                    <span class="text-end">Status</span>
                </div>

                {{--
                    Wire up: replace pac-empty with @forelse($recentInvoices as $inv)
                    <div class="pac-tbl-row">
                        <span class="t-num">#{{ $inv->number }}</span>
                        <span class="t-client">{{ $inv->client->name }}</span>
                        <span class="t-amt">₦{{ number_format($inv->amount, 2) }}</span>
                        <span class="t-due">{{ $inv->due_date?->format('d M Y') ?? '—' }}</span>
                        <div class="text-end">
                            <span class="pac-pill p-{{ $inv->status }}">{{ ucfirst($inv->status) }}</span>
                        </div>
                    </div>
                    @empty ... @endforelse
                --}}
                <div class="pac-empty">
                    <div class="pac-empty-ring"><i class="ri ri-file-list-3-line"></i></div>
                    <p>No invoices yet.</p>
                    <a href="{{ route('admin.invoices.create') }}">Create your first invoice →</a>
                </div>
            </div>
        </div>

        {{-- Right: Clients + Quick Actions --}}
        <div class="col-12 col-xl-5 d-flex flex-column gap-4">

            {{-- Recent Clients --}}
            <div class="card" style="border-radius: 0.75rem;">
                <div class="pac-card-hd">
                    <div>
                        <p class="pac-card-title">Recent Clients</p>
                        <p class="pac-card-sub">Newly onboarded</p>
                    </div>
                    <a href="{{ route('admin.clients.index') }}" class="pac-view-all">View All</a>
                </div>
                <div class="card-body px-4 py-2">
                    {{--
                        Wire: @forelse($recentClients as $c)
                        <div class="pac-client">
                            <div class="pac-client-av">{{ strtoupper(substr($c->name,0,2)) }}</div>
                            <div class="flex-grow-1 min-width-0">
                                <p class="pac-client-name">{{ $c->name }}</p>
                                <p class="pac-client-email">{{ $c->email }}</p>
                            </div>
                            <a href="{{ route('admin.clients.show',$c) }}" class="pac-client-link">View →</a>
                        </div>
                        @empty ... @endforelse
                    --}}
                    <div class="pac-empty" style="padding: 1.5rem 0;">
                        <div class="pac-empty-ring"><i class="ri ri-group-line"></i></div>
                        <p>No clients yet.</p>
                        <a href="{{ route('admin.clients.create') }}">Add your first client →</a>
                    </div>
                </div>
            </div>

            {{-- Quick Actions --}}
            <div class="card" style="border-radius: 0.75rem;">
                <div class="pac-card-hd">
                    <div>
                        <p class="pac-card-title">Quick Actions</p>
                        <p class="pac-card-sub">Jump straight in</p>
                    </div>
                </div>
                <div class="card-body px-4 pt-3 pb-4">
                    <div class="pac-qa-grid">
                        <a href="{{ route('admin.invoices.create') }}" class="pac-qa">
                            <div class="pac-qa-ic" style="background: rgba(181,204,24,0.12);">
                                <i class="ri ri-file-add-line" style="color:#96aa12;"></i>
                            </div>
                            <div><p class="pac-qa-lbl">New Invoice</p><p class="pac-qa-sub">Bill a client</p></div>
                        </a>
                        <a href="{{ route('admin.clients.create') }}" class="pac-qa">
                            <div class="pac-qa-ic" style="background: rgba(107,114,128,0.1);">
                                <i class="ri ri-user-add-line" style="color:#374151;"></i>
                            </div>
                            <div><p class="pac-qa-lbl">Add Client</p><p class="pac-qa-sub">New relationship</p></div>
                        </a>
                        <a href="{{ route('admin.projects.index') }}" class="pac-qa">
                            <div class="pac-qa-ic" style="background: rgba(17,24,39,0.07);">
                                <i class="ri ri-layout-column-line" style="color:#374151;"></i>
                            </div>
                            <div><p class="pac-qa-lbl">Projects</p><p class="pac-qa-sub">Kanban board</p></div>
                        </a>
                        <a href="{{ route('admin.letters.index') }}" class="pac-qa">
                            <div class="pac-qa-ic" style="background: rgba(181,204,24,0.1);">
                                <i class="ri ri-quill-pen-line" style="color:#96aa12;"></i>
                            </div>
                            <div><p class="pac-qa-lbl">New Letter</p><p class="pac-qa-sub">Draft & send</p></div>
                        </a>
                        <a href="{{ route('admin.inbox.index') }}" class="pac-qa">
                            <div class="pac-qa-ic" style="background: rgba(59,130,246,0.08);">
                                <i class="ri ri-inbox-line" style="color:#1d4ed8;"></i>
                            </div>
                            <div><p class="pac-qa-lbl">Inbox</p><p class="pac-qa-sub">Check messages</p></div>
                        </a>
                        <a href="{{ route('admin.chat.index') }}" class="pac-qa">
                            <div class="pac-qa-ic" style="background: rgba(239,68,68,0.08);">
                                <i class="ri ri-message-3-line" style="color:#b91c1c;"></i>
                            </div>
                            <div><p class="pac-qa-lbl">Chat</p><p class="pac-qa-sub">Team messages</p></div>
                        </a>
                    </div>
                </div>
            </div>

        </div>
    </div>
    {{-- / ROW 2 --}}


    {{-- ══════════════════════════════════════════════════════
         ROW 3 — Activity Feed + Project Pipeline + Letters/Settings
    ═══════════════════════════════════════════════════════ --}}
    <div class="row g-4 pac-row-3">

        {{-- Activity Feed --}}
        <div class="col-12 col-xl-5">
            <div class="card h-100" style="border-radius: 0.75rem;">
                <div class="pac-card-hd">
                    <div>
                        <p class="pac-card-title">Recent Activity</p>
                        <p class="pac-card-sub">Audit trail — latest actions</p>
                    </div>
                </div>
                <div class="card-body px-4 py-3">
                    {{--
                        Wire: @foreach($recentLogs as $log)
                        <li class="pac-feed-item">
                            <div class="pac-feed-dot fd-peridot">
                                <i class="ri ri-{{ $log->icon ?? 'information-line' }}"></i>
                            </div>
                            <div class="pac-feed-body">
                                <p class="pac-feed-text">{!! $log->description !!}</p>
                                <span class="pac-feed-time">{{ $log->created_at->diffForHumans() }}</span>
                            </div>
                        </li>
                        @endforeach
                    --}}
                    <ul class="pac-feed">
                        <li class="pac-feed-item">
                            <div class="pac-feed-dot fd-peridot">
                                <i class="ri ri-information-line"></i>
                            </div>
                            <div class="pac-feed-body">
                                <p class="pac-feed-text">No activity recorded yet.</p>
                                <span class="pac-feed-time">Actions will appear here as you use the system.</span>
                            </div>
                        </li>
                    </ul>
                </div>
                <div class="card-footer py-2 px-4" style="background: transparent; border-top: 1px solid var(--bs-border-color);">
                    <a href="{{ route('admin.logs.index') }}"
                       style="font-size: 0.76rem; color: #96aa12; text-decoration: none; font-weight: 600;">
                        View full audit log <i class="ri ri-arrow-right-line"></i>
                    </a>
                </div>
            </div>
        </div>

        {{-- Project Pipeline --}}
        <div class="col-12 col-xl-4">
            <div class="card h-100" style="border-radius: 0.75rem;">
                <div class="pac-card-hd">
                    <div>
                        <p class="pac-card-title">Project Pipeline</p>
                        <p class="pac-card-sub">Status breakdown</p>
                    </div>
                    <a href="{{ route('admin.projects.index') }}" class="pac-view-all">Open Board</a>
                </div>
                <div class="card-body px-4 py-3">
                    <div class="d-flex align-items-center gap-3 mb-4">
                        <div class="pac-donut-wrap">
                            <svg viewBox="0 0 80 80" width="80" height="80">
                                <circle cx="40" cy="40" r="33" fill="none" stroke="#eef0f2" stroke-width="10"/>
                                <circle cx="40" cy="40" r="33" fill="none" stroke="#b5cc18" stroke-width="10"
                                        stroke-dasharray="0 207.3"
                                        stroke-linecap="round"
                                        transform="rotate(-90 40 40)"
                                        id="pac-donut-arc"/>
                            </svg>
                            <div class="pac-donut-center">
                                <span class="pac-donut-num" id="pac-donut-label">0</span>
                                <span class="pac-donut-sub">total</span>
                            </div>
                        </div>
                        <div>
                            <p style="font-size: 0.77rem; color: #9ca3af; margin: 0 0 0.5rem; line-height: 1.5;">
                                Track active, on-hold, and completed work across your studio.
                            </p>
                            <a href="{{ route('admin.projects.index') }}" class="pac-view-all" style="display: inline-block;">
                                Go to Projects
                            </a>
                        </div>
                    </div>

                    {{-- Status bars — replace 0% with real values from $projectStats --}}
                    <div class="pac-pipe">
                        <div class="pac-pipe-meta">
                            <span class="pac-pipe-name">
                                <span class="pac-pipe-dot" style="background:#b5cc18;"></span>
                                In Progress
                            </span>
                            <span class="pac-pipe-pct">0 projects</span>
                        </div>
                        <div class="pac-bar-track">
                            <div class="pac-bar-fill" style="width:0%; background:#b5cc18;"></div>
                        </div>
                    </div>
                    <div class="pac-pipe">
                        <div class="pac-pipe-meta">
                            <span class="pac-pipe-name">
                                <span class="pac-pipe-dot" style="background:#6b7280;"></span>
                                On Hold
                            </span>
                            <span class="pac-pipe-pct">0 projects</span>
                        </div>
                        <div class="pac-bar-track">
                            <div class="pac-bar-fill" style="width:0%; background:#6b7280;"></div>
                        </div>
                    </div>
                    <div class="pac-pipe">
                        <div class="pac-pipe-meta">
                            <span class="pac-pipe-name">
                                <span class="pac-pipe-dot" style="background:#111827;"></span>
                                Completed
                            </span>
                            <span class="pac-pipe-pct">0 projects</span>
                        </div>
                        <div class="pac-bar-track">
                            <div class="pac-bar-fill" style="width:0%; background:#111827;"></div>
                        </div>
                    </div>
                    <div class="pac-pipe">
                        <div class="pac-pipe-meta">
                            <span class="pac-pipe-name">
                                <span class="pac-pipe-dot" style="background:#d1d5db; border:1px solid #e5e7eb;"></span>
                                Backlog
                            </span>
                            <span class="pac-pipe-pct">0 projects</span>
                        </div>
                        <div class="pac-bar-track">
                            <div class="pac-bar-fill" style="width:0%; background:#d1d5db;"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Letters + Settings --}}
        <div class="col-12 col-xl-3 d-flex flex-column gap-4">

            <div class="card" style="border-radius: 0.75rem;">
                <div class="pac-card-hd">
                    <div>
                        <p class="pac-card-title">Letters</p>
                        <p class="pac-card-sub">Correspondence</p>
                    </div>
                    <a href="{{ route('admin.letters.index') }}" class="pac-view-all">View All</a>
                </div>
                <div class="card-body px-4 py-2">
                    <div class="pac-empty" style="padding: 1.25rem 0;">
                        <div class="pac-empty-ring"><i class="ri ri-quill-pen-line"></i></div>
                        <p>No letters yet.</p>
                        <a href="{{ route('admin.letters.index') }}">Draft your first →</a>
                    </div>
                </div>
            </div>

            <div class="card flex-grow-1" style="border-radius: 0.75rem;">
                <div class="card-body d-flex flex-column justify-content-center align-items-center text-center px-3 py-4">
                    <div style="width: 42px; height: 42px; border-radius: 10px; background: rgba(17,24,39,0.07); display: flex; align-items: center; justify-content: center; margin-bottom: 0.625rem;">
                        <i class="ri ri-settings-4-line" style="font-size: 1.1rem; color: #374151;"></i>
                    </div>
                    <p style="font-size: 0.79rem; font-weight: 600; color: #111827; margin: 0 0 0.2rem;">Settings</p>
                    <p style="font-size: 0.7rem; color: #9ca3af; margin: 0 0 0.875rem;">Preferences & config</p>
                    <a href="{{ route('admin.settings.index') }}" class="pac-view-all">Open Settings</a>
                </div>
            </div>

        </div>

    </div>
    {{-- / ROW 3 --}}


    @push('page-js')
        <script src="{{ asset('admin/assets/vendor/libs/apex-charts/apexcharts.js') }}"></script>
        <script>
            (function () {

                /* ── Radial bar factory ── */
                function pacRadial(elId, color, series, iconHtml) {
                    var el = document.getElementById(elId);
                    if (!el) return;

                    var chart = new ApexCharts(el, {
                        chart: {
                            type: 'radialBar',
                            height: 90,
                            width: 90,
                            sparkline: { enabled: true }
                        },
                        series: [series],
                        plotOptions: {
                            radialBar: {
                                hollow: {
                                    size: '55%',
                                    margin: 0
                                },
                                track: {
                                    background: '#f1f5f9',
                                    strokeWidth: '100%',
                                    margin: 0
                                },
                                dataLabels: {
                                    name: { show: false },
                                    value: { show: false }
                                }
                            }
                        },
                        fill: { colors: [color] },
                        stroke: { lineCap: 'round' },
                        states: {
                            hover:  { filter: { type: 'none' } },
                            active: { filter: { type: 'none' } }
                        },
                        tooltip: { enabled: false }
                    });

                    chart.render().then(function () {
                        /* Inject the icon into the hollow center after render */
                        var existing = el.querySelector('.pac-radial-icon');
                        if (existing) existing.remove();

                        var icon = document.createElement('div');
                        icon.className = 'pac-radial-icon';
                        icon.innerHTML = iconHtml;
                        icon.style.cssText = [
                            'position:absolute',
                            'top:50%',
                            'left:50%',
                            'transform:translate(-50%,-50%)',
                            'font-size:1rem',
                            'color:' + color,
                            'pointer-events:none',
                            'display:flex',
                            'align-items:center',
                            'justify-content:center',
                            'line-height:1'
                        ].join(';');

                        el.style.position = 'relative';
                        el.appendChild(icon);
                    });
                }

                /*
                 * Replace 0 with real percentage from controller when ready:
                 * e.g. {{ $stats['invoices_pct'] ?? 0 }}
                */
                pacRadial('pac-chart-invoices', '#b5cc18', 0,
                    '<i class="ri ri-file-list-3-line" style="font-size:1rem;"></i>');
                pacRadial('pac-chart-clients',  '#6b7280', 0,
                    '<i class="ri ri-group-line" style="font-size:1rem;"></i>');
                pacRadial('pac-chart-projects', '#374151', 0,
                    '<i class="ri ri-layout-column-line" style="font-size:1rem;"></i>');
                pacRadial('pac-chart-messages', '#ef4444', 0,
                    '<i class="ri ri-message-3-line" style="font-size:1rem;"></i>');

                /* ── Project Pipeline donut arc ── */
                var total = 0; // ← replace: {{ $projectStats['total'] ?? 0 }}
                var arc   = document.getElementById('pac-donut-arc');
                var label = document.getElementById('pac-donut-label');
                if (arc && label) {
                    var circumference = 2 * Math.PI * 33;
                    var target = total > 0 ? Math.min(total / 20, 1) * circumference : 0;
                    var curr = 0, step = target / 40;
                    function tick() {
                        curr += step;
                        if (curr >= target) curr = target;
                        arc.setAttribute('stroke-dasharray', curr.toFixed(2) + ' ' + circumference.toFixed(2));
                        if (curr < target) requestAnimationFrame(tick);
                    }
                    label.textContent = total;
                    if (target > 0) setTimeout(function () { requestAnimationFrame(tick); }, 300);
                }

            })();
        </script>
    @endpush

</x-admin-layout>
