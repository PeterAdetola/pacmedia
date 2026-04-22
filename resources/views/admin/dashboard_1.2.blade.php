<x-admin-layout title="Dashboard">

    @push('page-css')
        <style>
            /* ── Pac Dashboard Enhancements ── */
            .pac-stat-card {
                border-left: 3px solid transparent;
                transition: border-color 0.2s, transform 0.2s, box-shadow 0.2s;
            }
            .pac-stat-card:hover {
                border-left-color: var(--pac-peridot);
                transform: translateY(-2px);
                box-shadow: 0 6px 24px rgba(0,0,0,0.07) !important;
            }
            .pac-stat-icon {
                width: 48px;
                height: 48px;
                border-radius: 12px;
                display: flex;
                align-items: center;
                justify-content: center;
                flex-shrink: 0;
            }
            .pac-stat-delta {
                font-size: 0.72rem;
                font-weight: 600;
                padding: 2px 7px;
                border-radius: 20px;
            }
            .pac-stat-delta.up   { background: rgba(34,197,94,0.12); color: #15803d; }
            .pac-stat-delta.down { background: rgba(239,68,68,0.12);  color: #b91c1c; }
            .pac-stat-delta.neu  { background: rgba(107,114,128,0.12); color: #4b5563; }

            /* ── Welcome banner ── */
            .pac-welcome {
                background: linear-gradient(135deg, #111827 60%, #1f2937 100%);
                border-radius: 0.75rem;
                padding: 1.75rem 2rem;
                color: #fff;
                position: relative;
                overflow: hidden;
            }
            .pac-welcome::before {
                content: '';
                position: absolute;
                top: -30px; right: -30px;
                width: 160px; height: 160px;
                border-radius: 50%;
                background: rgba(181,204,24,0.08);
            }
            .pac-welcome::after {
                content: '';
                position: absolute;
                bottom: -50px; right: 60px;
                width: 120px; height: 120px;
                border-radius: 50%;
                background: rgba(181,204,24,0.05);
            }
            .pac-welcome-badge {
                display: inline-flex;
                align-items: center;
                gap: 6px;
                background: rgba(181,204,24,0.15);
                border: 1px solid rgba(181,204,24,0.3);
                border-radius: 20px;
                padding: 3px 12px;
                font-size: 0.72rem;
                color: #b5cc18;
                margin-bottom: 0.75rem;
            }
            .pac-welcome-dot {
                width: 6px; height: 6px;
                border-radius: 50%;
                background: #b5cc18;
                animation: pac-pulse 2s ease-in-out infinite;
            }
            @keyframes pac-pulse {
                0%, 100% { opacity: 1; }
                50% { opacity: 0.4; }
            }
            .pac-welcome-cta {
                display: inline-flex;
                align-items: center;
                gap: 6px;
                background: #b5cc18;
                color: #111827;
                font-size: 0.82rem;
                font-weight: 600;
                padding: 0.45rem 1.1rem;
                border-radius: 0.375rem;
                text-decoration: none;
                margin-top: 1rem;
                transition: background 0.15s, transform 0.15s;
            }
            .pac-welcome-cta:hover { background: #96aa12; color: #111827; transform: translateY(-1px); }

            /* ── Section header ── */
            .pac-section-header {
                display: flex;
                align-items: center;
                justify-content: space-between;
                margin-bottom: 0;
            }
            .pac-section-title {
                font-size: 0.95rem;
                font-weight: 600;
                color: var(--pac-ink);
            }
            .pac-view-all {
                font-size: 0.78rem;
                color: var(--pac-peridot-dim);
                border: 1px solid var(--pac-peridot);
                border-radius: 0.375rem;
                padding: 0.28rem 0.75rem;
                text-decoration: none;
                transition: background 0.15s;
            }
            .pac-view-all:hover { background: rgba(181,204,24,0.08); color: var(--pac-peridot-dim); }

            /* ── Empty state ── */
            .pac-empty {
                display: flex;
                flex-direction: column;
                align-items: center;
                justify-content: center;
                padding: 2.5rem 1rem;
                text-align: center;
            }
            .pac-empty-icon {
                width: 52px; height: 52px;
                border-radius: 50%;
                background: rgba(181,204,24,0.1);
                display: flex;
                align-items: center;
                justify-content: center;
                margin-bottom: 0.875rem;
            }
            .pac-empty-icon i { font-size: 1.4rem; color: var(--pac-peridot-dim); }
            .pac-empty p { font-size: 0.82rem; color: var(--bs-body-secondary); margin-bottom: 0.5rem; }
            .pac-empty a { font-size: 0.82rem; color: var(--pac-peridot-dim); text-decoration: none; font-weight: 500; }
            .pac-empty a:hover { text-decoration: underline; }

            /* ── Quick actions ── */
            .pac-qa-grid {
                display: grid;
                grid-template-columns: 1fr 1fr;
                gap: 0.75rem;
            }
            .pac-qa-btn {
                display: flex;
                align-items: center;
                gap: 0.75rem;
                padding: 0.875rem 1rem;
                border-radius: 0.5rem;
                background: #f7f7f9;
                border: 1px solid #e5e7eb;
                text-decoration: none;
                transition: background 0.15s, border-color 0.15s, transform 0.15s;
                color: inherit;
            }
            .pac-qa-btn:hover {
                background: #fff;
                border-color: var(--pac-peridot);
                transform: translateY(-1px);
                color: inherit;
            }
            .pac-qa-icon {
                width: 36px; height: 36px;
                border-radius: 8px;
                display: flex;
                align-items: center;
                justify-content: center;
                flex-shrink: 0;
            }
            .pac-qa-label { font-size: 0.8rem; font-weight: 600; color: var(--pac-ink); line-height: 1.2; }
            .pac-qa-sub   { font-size: 0.7rem;  color: var(--bs-body-secondary); }

            /* ── Activity feed ── */
            .pac-feed-item {
                display: flex;
                gap: 0.875rem;
                padding: 0.875rem 0;
                border-bottom: 1px solid #f1f1f1;
            }
            .pac-feed-item:last-child { border-bottom: none; padding-bottom: 0; }
            .pac-feed-dot {
                width: 36px; height: 36px;
                border-radius: 50%;
                display: flex;
                align-items: center;
                justify-content: center;
                flex-shrink: 0;
                font-size: 0.9rem;
            }
            .pac-feed-body { flex: 1; min-width: 0; }
            .pac-feed-text { font-size: 0.82rem; color: var(--pac-ink); margin-bottom: 2px; line-height: 1.4; }
            .pac-feed-text strong { font-weight: 600; }
            .pac-feed-time { font-size: 0.7rem; color: var(--bs-body-secondary); }

            /* ── Progress bars ── */
            .pac-progress-row { margin-bottom: 1rem; }
            .pac-progress-row:last-child { margin-bottom: 0; }
            .pac-progress-meta {
                display: flex;
                justify-content: space-between;
                align-items: center;
                margin-bottom: 6px;
            }
            .pac-progress-name { font-size: 0.8rem; font-weight: 500; color: var(--pac-ink); }
            .pac-progress-pct  { font-size: 0.75rem; color: var(--bs-body-secondary); }
            .pac-bar-track {
                height: 6px;
                border-radius: 3px;
                background: #e5e7eb;
                overflow: hidden;
            }
            .pac-bar-fill {
                height: 100%;
                border-radius: 3px;
                background: var(--pac-peridot);
                transition: width 0.6s ease;
            }
            .pac-bar-fill.metal { background: #6b7280; }
            .pac-bar-fill.ink   { background: #111827; }

            /* ── Revenue mini chart placeholder ── */
            .pac-sparkline-wrap {
                height: 60px;
                display: flex;
                align-items: flex-end;
                gap: 3px;
                padding-top: 0.5rem;
            }
            .pac-spark-bar {
                flex: 1;
                border-radius: 2px 2px 0 0;
                background: rgba(181,204,24,0.25);
                transition: background 0.15s;
                min-height: 4px;
            }
            .pac-spark-bar.active { background: var(--pac-peridot); }
            .pac-spark-bar:hover  { background: var(--pac-peridot); cursor: default; }

            /* ── Status badges ── */
            .pac-badge {
                font-size: 0.68rem;
                font-weight: 600;
                padding: 2px 8px;
                border-radius: 20px;
                white-space: nowrap;
            }
            .pac-badge-draft    { background: #f1f5f9; color: #64748b; }
            .pac-badge-sent     { background: rgba(59,130,246,0.1); color: #1d4ed8; }
            .pac-badge-paid     { background: rgba(34,197,94,0.1); color: #15803d; }
            .pac-badge-overdue  { background: rgba(239,68,68,0.1);  color: #b91c1c; }

            /* ── Peridot divider ── */
            .pac-divider-peridot {
                height: 3px;
                border-radius: 2px;
                background: linear-gradient(90deg, var(--pac-peridot) 0%, transparent 100%);
                margin-bottom: 1rem;
            }
        </style>
    @endpush

    {{-- ════════════════════════════════════════════
         ROW 1 — Welcome banner + 4 stat cards
    ═══════════════════════════════════════════════ --}}
    <div class="row g-4 mb-4">

        {{-- Welcome banner --}}
        <div class="col-12 col-xl-4">
            <div class="pac-welcome h-100">
                <div class="pac-welcome-badge">
                    <span class="pac-welcome-dot"></span>
                    Studio Active
                </div>
                <h4 class="mb-1 fw-bold" style="color:#fff; font-size: 1.25rem;">
                    Welcome back, {{ auth()->user()->name ?? 'there' }} 👋
                </h4>
                <p style="font-size: 0.83rem; color: rgba(255,255,255,0.55); margin-bottom: 0; line-height: 1.6;">
                    Here's what's happening with The Pacmedia today.
                    Your dashboard is ready.
                </p>
                <div class="d-flex align-items-center gap-3 mt-3 flex-wrap" style="font-size: 0.75rem; color: rgba(255,255,255,0.4);">
                    <span>{{ now()->format('l, F j Y') }}</span>
                    <span style="width:3px;height:3px;border-radius:50%;background:rgba(255,255,255,0.3);"></span>
                    <span>Lagos, NG</span>
                </div>
                <div class="d-flex gap-2 flex-wrap">
                    <a href="{{ route('admin.invoices.create') }}" class="pac-welcome-cta">
                        <i class="ri ri-add-line" style="font-size:0.85rem;"></i>
                        New Invoice
                    </a>
                    <a href="{{ route('admin.clients.create') }}"
                       style="display:inline-flex;align-items:center;gap:6px;background:rgba(255,255,255,0.08);color:rgba(255,255,255,0.75);font-size:0.82rem;font-weight:600;padding:0.45rem 1.1rem;border-radius:0.375rem;text-decoration:none;margin-top:1rem;border:1px solid rgba(255,255,255,0.12);transition:background 0.15s;"
                       onmouseover="this.style.background='rgba(255,255,255,0.14)'"
                       onmouseout="this.style.background='rgba(255,255,255,0.08)'">
                        <i class="ri ri-user-add-line" style="font-size:0.85rem;"></i>
                        Add Client
                    </a>
                </div>
            </div>
        </div>

        {{-- Stat: Outstanding Invoices --}}
        <div class="col-6 col-xl-2">
            <div class="card h-100 pac-stat-card">
                <div class="card-body">
                    <div class="d-flex align-items-start justify-content-between mb-3">
                        <div class="pac-stat-icon" style="background: rgba(181,204,24,0.12);">
                            <i class="ri ri-file-list-3-line" style="font-size:1.25rem; color: var(--pac-peridot-dim);"></i>
                        </div>
                        <span class="pac-stat-delta neu">—</span>
                    </div>
                    <h4 class="fw-bold mb-1" style="color: var(--pac-ink); font-size: 1.5rem;">—</h4>
                    <p class="mb-0" style="font-size: 0.78rem; color: var(--bs-body-secondary); line-height: 1.3;">
                        Outstanding<br>Invoices
                    </p>
                    <div class="pac-sparkline-wrap mt-2">
                        @foreach([30,50,35,70,45,60,80,55,75,90,65,100] as $h)
                            <div class="pac-spark-bar {{ $loop->last ? 'active' : '' }}"
                                 style="height: {{ $h }}%;"></div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        {{-- Stat: Active Clients --}}
        <div class="col-6 col-xl-2">
            <div class="card h-100 pac-stat-card">
                <div class="card-body">
                    <div class="d-flex align-items-start justify-content-between mb-3">
                        <div class="pac-stat-icon" style="background: rgba(107,114,128,0.1);">
                            <i class="ri ri-group-line" style="font-size:1.25rem; color: #374151;"></i>
                        </div>
                        <span class="pac-stat-delta neu">—</span>
                    </div>
                    <h4 class="fw-bold mb-1" style="color: var(--pac-ink); font-size: 1.5rem;">—</h4>
                    <p class="mb-0" style="font-size: 0.78rem; color: var(--bs-body-secondary); line-height: 1.3;">
                        Active<br>Clients
                    </p>
                    <div class="pac-sparkline-wrap mt-2">
                        @foreach([20,40,30,60,50,45,70,60,80,65,85,75] as $h)
                            <div class="pac-spark-bar {{ $loop->last ? 'active' : '' }}"
                                 style="height: {{ $h }}%; background: {{ $loop->last ? '#6b7280' : 'rgba(107,114,128,0.2)' }};"></div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        {{-- Stat: Projects in Progress --}}
        <div class="col-6 col-xl-2">
            <div class="card h-100 pac-stat-card">
                <div class="card-body">
                    <div class="d-flex align-items-start justify-content-between mb-3">
                        <div class="pac-stat-icon" style="background: rgba(17,24,39,0.08);">
                            <i class="ri ri-layout-column-line" style="font-size:1.25rem; color: #374151;"></i>
                        </div>
                        <span class="pac-stat-delta neu">—</span>
                    </div>
                    <h4 class="fw-bold mb-1" style="color: var(--pac-ink); font-size: 1.5rem;">—</h4>
                    <p class="mb-0" style="font-size: 0.78rem; color: var(--bs-body-secondary); line-height: 1.3;">
                        Projects<br>In Progress
                    </p>
                    <div class="pac-sparkline-wrap mt-2">
                        @foreach([60,40,70,50,80,60,55,75,65,85,70,90] as $h)
                            <div class="pac-spark-bar {{ $loop->last ? 'active' : '' }}"
                                 style="height: {{ $h }}%; background: {{ $loop->last ? '#111827' : 'rgba(17,24,39,0.12)' }};"></div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        {{-- Stat: Unread Messages --}}
        <div class="col-6 col-xl-2">
            <div class="card h-100 pac-stat-card">
                <div class="card-body">
                    <div class="d-flex align-items-start justify-content-between mb-3">
                        <div class="pac-stat-icon" style="background: rgba(239,68,68,0.1);">
                            <i class="ri ri-message-3-line" style="font-size:1.25rem; color: #b91c1c;"></i>
                        </div>
                        <span class="pac-stat-delta neu">—</span>
                    </div>
                    <h4 class="fw-bold mb-1" style="color: var(--pac-ink); font-size: 1.5rem;">—</h4>
                    <p class="mb-0" style="font-size: 0.78rem; color: var(--bs-body-secondary); line-height: 1.3;">
                        Unread<br>Messages
                    </p>
                    <div class="pac-sparkline-wrap mt-2">
                        @foreach([80,50,90,40,70,30,60,45,55,35,50,20] as $h)
                            <div class="pac-spark-bar {{ $loop->last ? 'active' : '' }}"
                                 style="height: {{ $h }}%; background: {{ $loop->last ? 'rgba(239,68,68,0.7)' : 'rgba(239,68,68,0.15)' }};"></div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

    </div>

    {{-- ════════════════════════════════════════════
         ROW 2 — Recent Invoices + Quick Actions + Activity
    ═══════════════════════════════════════════════ --}}
    <div class="row g-4 mb-4">

        {{-- Recent Invoices (wider) --}}
        <div class="col-12 col-xl-7">
            <div class="card h-100">
                <div class="card-header pac-section-header">
                    <div>
                        <div class="pac-divider-peridot" style="width:28px; margin-bottom:0.4rem;"></div>
                        <span class="pac-section-title">Recent Invoices</span>
                    </div>
                    <a href="{{ route('admin.invoices.index') }}" class="pac-view-all">View All</a>
                </div>
                <div class="card-body p-0">
                    {{-- Table header --}}
                    <div class="px-4 py-2 border-bottom"
                         style="display:grid; grid-template-columns: 1fr 2fr 1.2fr 1fr; gap:0.5rem; font-size: 0.7rem; font-weight:600; text-transform:uppercase; letter-spacing:0.06em; color: var(--bs-body-secondary);">
                        <span>#</span>
                        <span>Client</span>
                        <span>Amount</span>
                        <span class="text-end">Status</span>
                    </div>

                    {{-- Empty state --}}
                    <div class="pac-empty">
                        <div class="pac-empty-icon">
                            <i class="ri ri-file-list-3-line"></i>
                        </div>
                        <p>No invoices yet.</p>
                        <a href="{{ route('admin.invoices.create') }}">
                            Create your first invoice →
                        </a>
                    </div>

                    {{--
                        When you have real data, replace the pac-empty block above with:

                        @forelse($invoices as $inv)
                        <div class="px-4 py-3 border-bottom"
                             style="display:grid; grid-template-columns: 1fr 2fr 1.2fr 1fr; gap:0.5rem; align-items:center; font-size:0.82rem;">
                            <span style="color:var(--pac-peridot-dim); font-weight:600;">#{{ $inv->number }}</span>
                            <span style="font-weight:500; color:var(--pac-ink); white-space:nowrap; overflow:hidden; text-overflow:ellipsis;">{{ $inv->client->name }}</span>
                            <span style="font-weight:600; color:var(--pac-ink);">₦{{ number_format($inv->amount) }}</span>
                            <div class="text-end">
                                <span class="pac-badge pac-badge-{{ $inv->status }}">{{ ucfirst($inv->status) }}</span>
                            </div>
                        </div>
                        @empty
                            <div class="pac-empty"> ... </div>
                        @endforelse
                    --}}
                </div>
            </div>
        </div>

        {{-- Right col: Quick Actions + Pipeline --}}
        <div class="col-12 col-xl-5 d-flex flex-column gap-4">

            {{-- Quick Actions --}}
            <div class="card">
                <div class="card-header">
                    <div class="pac-divider-peridot" style="width:28px; margin-bottom:0.4rem;"></div>
                    <span class="pac-section-title">Quick Actions</span>
                </div>
                <div class="card-body pt-2">
                    <div class="pac-qa-grid">
                        <a href="{{ route('admin.invoices.create') }}" class="pac-qa-btn">
                            <div class="pac-qa-icon" style="background: rgba(181,204,24,0.12);">
                                <i class="ri ri-file-add-line" style="font-size:1rem; color: var(--pac-peridot-dim);"></i>
                            </div>
                            <div>
                                <div class="pac-qa-label">New Invoice</div>
                                <div class="pac-qa-sub">Bill a client</div>
                            </div>
                        </a>
                        <a href="{{ route('admin.clients.create') }}" class="pac-qa-btn">
                            <div class="pac-qa-icon" style="background: rgba(107,114,128,0.1);">
                                <i class="ri ri-user-add-line" style="font-size:1rem; color: #374151;"></i>
                            </div>
                            <div>
                                <div class="pac-qa-label">Add Client</div>
                                <div class="pac-qa-sub">New relationship</div>
                            </div>
                        </a>
                        <a href="{{ route('admin.projects.index') }}" class="pac-qa-btn">
                            <div class="pac-qa-icon" style="background: rgba(17,24,39,0.06);">
                                <i class="ri ri-layout-column-line" style="font-size:1rem; color: #374151;"></i>
                            </div>
                            <div>
                                <div class="pac-qa-label">Projects</div>
                                <div class="pac-qa-sub">Kanban board</div>
                            </div>
                        </a>
                        <a href="{{ route('admin.letters.index') }}" class="pac-qa-btn">
                            <div class="pac-qa-icon" style="background: rgba(181,204,24,0.12);">
                                <i class="ri ri-quill-pen-line" style="font-size:1rem; color: var(--pac-peridot-dim);"></i>
                            </div>
                            <div>
                                <div class="pac-qa-label">New Letter</div>
                                <div class="pac-qa-sub">Draft & send</div>
                            </div>
                        </a>
                        <a href="{{ route('admin.inbox.index') }}" class="pac-qa-btn">
                            <div class="pac-qa-icon" style="background: rgba(59,130,246,0.08);">
                                <i class="ri ri-mail-line" style="font-size:1rem; color: #1d4ed8;"></i>
                            </div>
                            <div>
                                <div class="pac-qa-label">Inbox</div>
                                <div class="pac-qa-sub">Check messages</div>
                            </div>
                        </a>
                        <a href="{{ route('admin.chat.index') }}" class="pac-qa-btn">
                            <div class="pac-qa-icon" style="background: rgba(239,68,68,0.08);">
                                <i class="ri ri-message-3-line" style="font-size:1rem; color: #b91c1c;"></i>
                            </div>
                            <div>
                                <div class="pac-qa-label">Chat</div>
                                <div class="pac-qa-sub">Team messages</div>
                            </div>
                        </a>
                    </div>
                </div>
            </div>

        </div>

    </div>

    {{-- ════════════════════════════════════════════
         ROW 3 — Recent Clients + Activity Feed + Project Status
    ═══════════════════════════════════════════════ --}}
    <div class="row g-4">

        {{-- Recent Clients --}}
        <div class="col-12 col-xl-4">
            <div class="card h-100">
                <div class="card-header pac-section-header">
                    <div>
                        <div class="pac-divider-peridot" style="width:28px; margin-bottom:0.4rem;"></div>
                        <span class="pac-section-title">Recent Clients</span>
                    </div>
                    <a href="{{ route('admin.clients.index') }}" class="pac-view-all">View All</a>
                </div>
                <div class="card-body">
                    <div class="pac-empty">
                        <div class="pac-empty-icon">
                            <i class="ri ri-group-line"></i>
                        </div>
                        <p>No clients yet.</p>
                        <a href="{{ route('admin.clients.create') }}">Add your first client →</a>
                    </div>

                    {{--
                        When you have data:
                        @forelse($clients as $client)
                        <div class="d-flex align-items-center gap-3 py-2 border-bottom">
                            <div class="pac-stat-icon" style="width:38px;height:38px;border-radius:50%;background:rgba(181,204,24,0.12);font-size:0.85rem;font-weight:700;color:var(--pac-peridot-dim);">
                                {{ strtoupper(substr($client->name, 0, 2)) }}
                            </div>
                            <div class="flex-grow-1 min-w-0">
                                <div style="font-size:0.83rem;font-weight:600;color:var(--pac-ink);white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">{{ $client->name }}</div>
                                <div style="font-size:0.72rem;color:var(--bs-body-secondary);">{{ $client->email }}</div>
                            </div>
                            <a href="{{ route('admin.clients.show', $client) }}"
                               style="font-size:0.7rem;color:var(--pac-peridot-dim);white-space:nowrap;">View →</a>
                        </div>
                        @empty ... @endforelse
                    --}}
                </div>
            </div>
        </div>

        {{-- Activity Feed --}}
        <div class="col-12 col-xl-4">
            <div class="card h-100">
                <div class="card-header">
                    <div class="pac-divider-peridot" style="width:28px; margin-bottom:0.4rem;"></div>
                    <span class="pac-section-title">Recent Activity</span>
                </div>
                <div class="card-body">
                    {{-- Placeholder activity items — wire to real activity log later --}}
                    <div style="font-size:0.78rem; color: var(--bs-body-secondary); text-align:center; padding: 2rem 0;">
                        <div class="pac-empty-icon mx-auto">
                            <i class="ri ri-history-line"></i>
                        </div>
                        <p class="mt-2 mb-1">No recent activity.</p>
                        <a href="{{ route('admin.logs.index') }}" style="color:var(--pac-peridot-dim); text-decoration:none; font-weight:500;">
                            View activity log →
                        </a>
                    </div>

                    {{--
                        Wire to real data via:
                        @foreach($recentActivity as $event)
                        <div class="pac-feed-item">
                            <div class="pac-feed-dot" style="background: rgba(181,204,24,0.12);">
                                <i class="ri ri-{{ $event->icon }}" style="font-size:0.85rem;color:var(--pac-peridot-dim);"></i>
                            </div>
                            <div class="pac-feed-body">
                                <div class="pac-feed-text">{!! $event->description !!}</div>
                                <div class="pac-feed-time">{{ $event->created_at->diffForHumans() }}</div>
                            </div>
                        </div>
                        @endforeach
                    --}}
                </div>
            </div>
        </div>

        {{-- Project Pipeline (status breakdown) --}}
        <div class="col-12 col-xl-4">
            <div class="card h-100">
                <div class="card-header">
                    <div class="pac-divider-peridot" style="width:28px; margin-bottom:0.4rem;"></div>
                    <span class="pac-section-title">Project Pipeline</span>
                </div>
                <div class="card-body">
                    <div class="d-flex align-items-center gap-3 mb-4">
                        <div style="position:relative; width:80px; height:80px; flex-shrink:0;">
                            <svg viewBox="0 0 80 80" width="80" height="80">
                                <circle cx="40" cy="40" r="34" fill="none"
                                        stroke="#e5e7eb" stroke-width="10"/>
                                <circle cx="40" cy="40" r="34" fill="none"
                                        stroke="#b5cc18" stroke-width="10"
                                        stroke-dasharray="0 214"
                                        stroke-linecap="round"
                                        transform="rotate(-90 40 40)"
                                        id="pac-donut-arc"/>
                            </svg>
                            <div style="position:absolute;inset:0;display:flex;flex-direction:column;align-items:center;justify-content:center;">
                                <span style="font-size:1.1rem;font-weight:700;color:var(--pac-ink);" id="pac-donut-label">0</span>
                                <span style="font-size:0.6rem;color:var(--bs-body-secondary);">total</span>
                            </div>
                        </div>
                        <div style="flex:1;">
                            <div style="font-size:0.78rem; color: var(--bs-body-secondary); margin-bottom:4px;">
                                Track all active, on-hold, and completed work across your studio.
                            </div>
                            <a href="{{ route('admin.projects.index') }}"
                               class="pac-view-all" style="display:inline-block; margin-top:4px;">
                                Open Board
                            </a>
                        </div>
                    </div>

                    {{-- Progress breakdown --}}
                    <div class="pac-progress-row">
                        <div class="pac-progress-meta">
                            <span class="pac-progress-name">
                                <span style="display:inline-block;width:8px;height:8px;border-radius:2px;background:var(--pac-peridot);margin-right:6px;"></span>
                                In Progress
                            </span>
                            <span class="pac-progress-pct">—</span>
                        </div>
                        <div class="pac-bar-track"><div class="pac-bar-fill" style="width:0%;"></div></div>
                    </div>
                    <div class="pac-progress-row">
                        <div class="pac-progress-meta">
                            <span class="pac-progress-name">
                                <span style="display:inline-block;width:8px;height:8px;border-radius:2px;background:#6b7280;margin-right:6px;"></span>
                                On Hold
                            </span>
                            <span class="pac-progress-pct">—</span>
                        </div>
                        <div class="pac-bar-track"><div class="pac-bar-fill metal" style="width:0%;"></div></div>
                    </div>
                    <div class="pac-progress-row">
                        <div class="pac-progress-meta">
                            <span class="pac-progress-name">
                                <span style="display:inline-block;width:8px;height:8px;border-radius:2px;background:#111827;margin-right:6px;"></span>
                                Completed
                            </span>
                            <span class="pac-progress-pct">—</span>
                        </div>
                        <div class="pac-bar-track"><div class="pac-bar-fill ink" style="width:0%;"></div></div>
                    </div>
                    <div class="pac-progress-row">
                        <div class="pac-progress-meta">
                            <span class="pac-progress-name">
                                <span style="display:inline-block;width:8px;height:8px;border-radius:2px;background:#e5e7eb;border:1px solid #d1d5db;margin-right:6px;"></span>
                                Backlog
                            </span>
                            <span class="pac-progress-pct">—</span>
                        </div>
                        <div class="pac-bar-track"><div class="pac-bar-fill" style="width:0%;background:#d1d5db;"></div></div>
                    </div>

                    <div style="border-top:1px solid #f1f1f1; margin-top:1rem; padding-top:0.875rem; font-size:0.75rem; color: var(--bs-body-secondary); text-align:center;">
                        Connect your project data to animate these metrics.
                    </div>
                </div>
            </div>
        </div>

    </div>

    @push('page-js')
        <script>
            {{-- Animate the donut arc on load when project data is available --}}
                {{-- Wire $projectStats from your controller --}}
            (function() {
                var total = 0; {{-- replace with PHP: {{ $projectStats['total'] ?? 0 }} --}}
                var arc   = document.getElementById('pac-donut-arc');
                var label = document.getElementById('pac-donut-label');
                if (arc && label) {
                    var circumference = 2 * Math.PI * 34;
                    var pct = total > 0 ? Math.min(total / 20, 1) : 0;
                    arc.setAttribute('stroke-dasharray', (pct * circumference).toFixed(1) + ' ' + circumference);
                    label.textContent = total;
                }
            })();
        </script>
    @endpush

</x-admin-layout>
