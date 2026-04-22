<x-admin-layout title="Dashboard">

    @push('page-css')
        <style>
            /* ── Stat cards ───────────────────────────────────────── */
            .pac-stat-card {
                border-top: 3px solid transparent;
                transition: border-color 0.2s ease, box-shadow 0.2s ease;
                position: relative;
            }
            .pac-stat-card:hover {
                border-top-color: var(--pac-peridot);
                box-shadow: 0 4px 20px rgba(0,0,0,0.08) !important;
            }
            .pac-stat-card .stat-icon {
                width: 48px; height: 48px; border-radius: 12px;
                display: flex; align-items: center; justify-content: center;
                font-size: 1.35rem; flex-shrink: 0;
            }

            /* ── Welcome banner ───────────────────────────────────── */
            .pac-welcome-banner {
                background: linear-gradient(135deg, #111827 0%, #1f2937 60%, #374151 100%);
                border-radius: 0.75rem; position: relative; overflow: hidden;
            }
            .pac-welcome-banner::before {
                content: ''; position: absolute; top: -40px; right: -40px;
                width: 200px; height: 200px; border-radius: 50%;
                background: radial-gradient(circle, rgba(181,204,24,0.18) 0%, transparent 70%);
                pointer-events: none;
            }
            .pac-welcome-banner::after {
                content: ''; position: absolute; bottom: -60px; right: 80px;
                width: 140px; height: 140px; border-radius: 50%;
                background: radial-gradient(circle, rgba(181,204,24,0.08) 0%, transparent 70%);
                pointer-events: none;
            }
            .pac-peridot-pill {
                background: rgba(181,204,24,0.15); border: 1px solid rgba(181,204,24,0.3);
                color: var(--pac-peridot); font-size: 0.7rem; font-weight: 600;
                padding: 0.2rem 0.65rem; border-radius: 100px;
                display: inline-block; letter-spacing: 0.04em; text-transform: uppercase;
            }
            .pac-welcome-banner .quick-actions a {
                background: rgba(255,255,255,0.07); border: 1px solid rgba(255,255,255,0.12);
                color: rgba(255,255,255,0.85); border-radius: 0.5rem;
                padding: 0.5rem 1rem; font-size: 0.8rem; font-weight: 500;
                text-decoration: none; display: inline-flex; align-items: center; gap: 6px;
                transition: background 0.2s, border-color 0.2s;
            }
            .pac-welcome-banner .quick-actions a:hover {
                background: rgba(181,204,24,0.15); border-color: rgba(181,204,24,0.4);
                color: var(--pac-peridot);
            }
            .pac-welcome-banner .quick-actions a.primary-cta {
                background: var(--pac-peridot); border-color: var(--pac-peridot);
                color: #111827; font-weight: 700;
            }
            .pac-welcome-banner .quick-actions a.primary-cta:hover {
                background: var(--pac-peridot-dim); border-color: var(--pac-peridot-dim); color: #111827;
            }

            /* ── Activity timeline ────────────────────────────────── */
            .pac-timeline { list-style: none; padding: 0; margin: 0; position: relative; }
            .pac-timeline::before {
                content: ''; position: absolute; left: 15px; top: 8px; bottom: 8px;
                width: 1px; background: #e5e7eb;
            }
            .pac-timeline-item { display: flex; gap: 14px; padding-bottom: 1.25rem; position: relative; }
            .pac-timeline-item:last-child { padding-bottom: 0; }
            .pac-timeline-dot {
                width: 30px; height: 30px; border-radius: 50%; flex-shrink: 0;
                display: flex; align-items: center; justify-content: center;
                font-size: 0.8rem; position: relative; z-index: 1;
            }
            .pac-timeline-dot.peridot { background: color-mix(in sRGB, var(--pac-peridot) 15%, white); color: var(--pac-peridot-dim); }
            .pac-timeline-dot.ink     { background: color-mix(in sRGB, #111827 10%, white); color: #374151; }
            .pac-timeline-dot.danger  { background: #fef2f2; color: #ef4444; }
            .pac-timeline-dot.info    { background: #eff6ff; color: #3b82f6; }
            .pac-timeline-content { flex: 1; min-width: 0; padding-top: 3px; }
            .pac-timeline-title { font-size: 0.82rem; font-weight: 600; color: #111827; margin-bottom: 1px; }
            .pac-timeline-sub   { font-size: 0.75rem; color: #6b7280; margin: 0; }
            .pac-timeline-time  { font-size: 0.7rem; color: #9ca3af; flex-shrink: 0; padding-top: 5px; }

            /* ── Project progress rows ────────────────────────────── */
            .pac-project-row { display: flex; align-items: center; gap: 12px; padding: 0.75rem 0; border-bottom: 1px solid #f3f4f6; }
            .pac-project-row:last-child { border-bottom: none; padding-bottom: 0; }
            .pac-project-icon { width: 36px; height: 36px; border-radius: 8px; flex-shrink: 0; display: flex; align-items: center; justify-content: center; font-size: 1rem; }
            .pac-project-meta { flex: 1; min-width: 0; }
            .pac-project-name   { font-size: 0.82rem; font-weight: 600; color: #111827; margin: 0; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
            .pac-project-client { font-size: 0.72rem; color: #9ca3af; margin: 0; }
            .pac-mini-progress  { width: 80px; flex-shrink: 0; }
            .pac-mini-progress-bar  { height: 4px; border-radius: 100px; background: #f3f4f6; overflow: hidden; }
            .pac-mini-progress-fill { height: 100%; border-radius: 100px; background: var(--pac-peridot); }
            .pac-mini-progress-label { font-size: 0.68rem; color: #9ca3af; margin-top: 2px; text-align: right; }

            /* ── Empty states ─────────────────────────────────────── */
            .pac-empty-state { padding: 3rem 1.5rem; text-align: center; }
            .pac-empty-state i { font-size: 2.5rem; opacity: 0.15; display: block; margin-bottom: 0.75rem; }
            .pac-empty-state p { font-size: 0.875rem; color: #9ca3af; margin: 0; }
            .pac-empty-state a { color: var(--pac-peridot-dim); text-decoration: none; }
            .pac-empty-state a:hover { text-decoration: underline; }

            /* ── View-all button ──────────────────────────────────── */
            .pac-view-all-btn {
                font-size: 0.75rem; color: var(--pac-peridot-dim);
                border: 1px solid rgba(181,204,24,0.4); border-radius: 0.375rem;
                padding: 0.28rem 0.7rem; text-decoration: none;
                transition: background 0.15s; white-space: nowrap;
            }
            .pac-view-all-btn:hover {
                background: color-mix(in sRGB, var(--pac-peridot) 10%, white);
                color: var(--pac-peridot-dim);
            }

            /* ── Quick nav cards ──────────────────────────────────── */
            .pac-quick-link {
                display: flex; align-items: center; gap: 12px; padding: 0.75rem;
                border-radius: 0.5rem; border: 1px solid #f0f0f0;
                text-decoration: none; transition: border-color 0.15s, background 0.15s;
            }
            .pac-quick-link:hover {
                border-color: rgba(181,204,24,0.35);
                background: color-mix(in sRGB, var(--pac-peridot) 5%, white);
            }
            .pac-quick-link-icon { width: 36px; height: 36px; border-radius: 8px; flex-shrink: 0; display: flex; align-items: center; justify-content: center; }
            .pac-quick-link-label { font-size: 0.8rem; font-weight: 600; color: #111827; margin: 0; }
            .pac-quick-link-sub   { font-size: 0.7rem; color: #9ca3af; margin: 0; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
        </style>
    @endpush

    {{-- ─── WELCOME BANNER ─────────────────────────────────────────── --}}
    <div class="pac-welcome-banner p-4 mb-4">
        <div class="d-flex flex-wrap align-items-start justify-content-between gap-3">
            <div>
                <span class="pac-peridot-pill mb-2">The Pacmedia Studio</span>
                <h4 class="text-white fw-bold mb-1 mt-2">
                    @if(now()->hour < 12)
                        Good morning
                    @elseif(now()->hour < 17)
                        Good afternoon
                    @else
                        Good evening
                    @endif
                    , {{ auth()->user()->name ?? 'there' }} 👋
                </h4>
                <p class="mb-3" style="color: rgba(255,255,255,0.55); font-size: 0.85rem;">
                    Here's what's happening across your studio today.
                </p>
                <div class="quick-actions d-flex flex-wrap gap-2">
                    <a href="{{ route('admin.invoices.create') }}" class="primary-cta">
                        <i class="ri ri-add-line"></i> New Invoice
                    </a>
                    <a href="{{ route('admin.clients.create') }}">
                        <i class="ri ri-user-add-line"></i> Add Client
                    </a>
                    <a href="{{ route('admin.projects.index') }}">
                        <i class="ri ri-layout-column-line"></i> Projects
                    </a>
                    <a href="{{ route('admin.inbox.index') }}">
                        <i class="ri ri-inbox-line"></i> Inbox
                    </a>
                </div>
            </div>
            <div class="text-end d-none d-md-block"
                 style="color: rgba(255,255,255,0.4); font-size: 0.75rem; letter-spacing: 0.04em; text-transform: uppercase; line-height: 1.6;">
                {{ now()->format('l') }}<br>
                <span style="font-size: 1.35rem; font-weight: 700; color: rgba(255,255,255,0.7); letter-spacing: 0; text-transform: none;">
                    {{ now()->format('d M Y') }}
                </span>
            </div>
        </div>
    </div>
    {{-- ─── / WELCOME BANNER ────────────────────────────────────────── --}}

    {{-- ─── STAT CARDS ─────────────────────────────────────────────── --}}
    <div class="row g-4 mb-4">

        <div class="col-sm-6 col-xl-3">
            <div class="card pac-stat-card h-100">
                <div class="card-body d-flex align-items-center gap-3">
                    <div class="stat-icon" style="background: color-mix(in sRGB, var(--pac-peridot) 12%, white);">
                        <i class="ri ri-file-list-3-line" style="color: var(--pac-peridot-dim);"></i>
                    </div>
                    <div class="flex-grow-1 min-width-0">
                        <small class="text-body-secondary d-block mb-1">Outstanding Invoices</small>
                        <h5 class="mb-0 fw-bold">—</h5>
                    </div>
                </div>
                <a href="{{ route('admin.invoices.index') }}" class="stretched-link"></a>
            </div>
        </div>

        <div class="col-sm-6 col-xl-3">
            <div class="card pac-stat-card h-100">
                <div class="card-body d-flex align-items-center gap-3">
                    <div class="stat-icon" style="background: color-mix(in sRGB, #6b7280 12%, white);">
                        <i class="ri ri-group-line" style="color: #374151;"></i>
                    </div>
                    <div class="flex-grow-1 min-width-0">
                        <small class="text-body-secondary d-block mb-1">Active Clients</small>
                        <h5 class="mb-0 fw-bold">—</h5>
                    </div>
                </div>
                <a href="{{ route('admin.clients.index') }}" class="stretched-link"></a>
            </div>
        </div>

        <div class="col-sm-6 col-xl-3">
            <div class="card pac-stat-card h-100">
                <div class="card-body d-flex align-items-center gap-3">
                    <div class="stat-icon" style="background: color-mix(in sRGB, #111827 8%, white);">
                        <i class="ri ri-layout-column-line" style="color: #1f2937;"></i>
                    </div>
                    <div class="flex-grow-1 min-width-0">
                        <small class="text-body-secondary d-block mb-1">Projects In Progress</small>
                        <h5 class="mb-0 fw-bold">—</h5>
                    </div>
                </div>
                <a href="{{ route('admin.projects.index') }}" class="stretched-link"></a>
            </div>
        </div>

        <div class="col-sm-6 col-xl-3">
            <div class="card pac-stat-card h-100">
                <div class="card-body d-flex align-items-center gap-3">
                    <div class="stat-icon bg-label-danger">
                        <i class="ri ri-message-3-line"></i>
                    </div>
                    <div class="flex-grow-1 min-width-0">
                        <small class="text-body-secondary d-block mb-1">Unread Messages</small>
                        <h5 class="mb-0 fw-bold">—</h5>
                    </div>
                </div>
                <a href="{{ route('admin.inbox.index') }}" class="stretched-link"></a>
            </div>
        </div>

    </div>
    {{-- ─── / STAT CARDS ────────────────────────────────────────────── --}}

    {{-- ─── MAIN ROW: invoices (7) + clients & projects (5) ──────────── --}}
    <div class="row g-4">

        {{-- Recent Invoices --}}
        <div class="col-xl-7">
            <div class="card h-100">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <div>
                        <h5 class="mb-0">Recent Invoices</h5>
                        <small class="text-body-secondary">Latest billing activity</small>
                    </div>
                    <a href="{{ route('admin.invoices.index') }}" class="pac-view-all-btn">View All</a>
                </div>
                <div class="card-body p-0">
                    {{--
                        Wire up: pass $recentInvoices from DashboardController.
                        Loop structure: @forelse($recentInvoices as $invoice) inside a
                        .table-responsive > table.table.table-hover.table-borderless
                        Columns: Client avatar+name | Invoice # | Amount | Due Date | Status badge | View link
                        @empty: show the empty state div below.
                    --}}
                    <div class="pac-empty-state">
                        <i class="ri ri-file-list-3-line"></i>
                        <p>
                            No invoices yet.<br>
                            <a href="{{ route('admin.invoices.create') }}">Create your first invoice →</a>
                        </p>
                    </div>
                </div>
            </div>
        </div>

        {{-- Right column --}}
        <div class="col-xl-5">
            <div class="row g-4">

                {{-- Recent Clients --}}
                <div class="col-12">
                    <div class="card">
                        <div class="card-header d-flex align-items-center justify-content-between">
                            <div>
                                <h5 class="mb-0">Recent Clients</h5>
                                <small class="text-body-secondary">Newly onboarded</small>
                            </div>
                            <a href="{{ route('admin.clients.index') }}" class="pac-view-all-btn">View All</a>
                        </div>
                        <div class="card-body">
                            {{--
                                Wire up: pass $recentClients from DashboardController.
                                Loop structure: @forelse($recentClients as $client)
                                Each row: avatar initials | name + email | Active badge
                            --}}
                            <div class="pac-empty-state" style="padding: 2rem 1rem;">
                                <i class="ri ri-group-line"></i>
                                <p>
                                    No clients yet.<br>
                                    <a href="{{ route('admin.clients.create') }}">Add your first client →</a>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Active Projects --}}
                <div class="col-12">
                    <div class="card">
                        <div class="card-header d-flex align-items-center justify-content-between">
                            <div>
                                <h5 class="mb-0">Active Projects</h5>
                                <small class="text-body-secondary">Completion overview</small>
                            </div>
                            <a href="{{ route('admin.projects.index') }}" class="pac-view-all-btn">View All</a>
                        </div>
                        <div class="card-body py-2">
                            {{--
                                Wire up: pass $activeProjects from DashboardController.
                                Loop structure: @forelse($activeProjects as $project)
                                Each row: .pac-project-row with icon | name + client | .pac-mini-progress bar
                            --}}
                            <div class="pac-empty-state" style="padding: 2rem 1rem;">
                                <i class="ri ri-layout-column-line"></i>
                                <p>
                                    No projects running yet.<br>
                                    <a href="{{ route('admin.projects.index') }}">Go to projects →</a>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>

    </div>
    {{-- ─── / MAIN ROW ──────────────────────────────────────────────── --}}

    {{-- ─── LOWER ROW: activity timeline (7) + quick nav (5) ─────────── --}}
    <div class="row g-4 mt-0">

        {{-- Activity Timeline --}}
        <div class="col-xl-7">
            <div class="card">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <div>
                        <h5 class="mb-0">Recent Activity</h5>
                        <small class="text-body-secondary">Audit trail — latest actions</small>
                    </div>
                </div>
                <div class="card-body">
                    {{--
                        Wire up: pass $recentLogs from DashboardController (query ActivityLog).
                        Loop structure: @forelse($recentLogs as $log)
                        Each item: .pac-timeline-item with .pac-timeline-dot.{type_class}
                                   | .pac-timeline-content (title + sub) | .pac-timeline-time
                    --}}
                    <ul class="pac-timeline">
                        <li class="pac-timeline-item">
                            <div class="pac-timeline-dot peridot">
                                <i class="ri ri-information-line"></i>
                            </div>
                            <div class="pac-timeline-content">
                                <p class="pac-timeline-title">No recent activity recorded</p>
                                <p class="pac-timeline-sub">Activity will appear here as you use the system.</p>
                            </div>
                            <span class="pac-timeline-time">now</span>
                        </li>
                    </ul>
                </div>
                @if(Route::has('admin.logs.index'))
                    <div class="card-footer text-center py-2">
                        <a href="{{ route('admin.logs.index') }}"
                           style="font-size: 0.78rem; color: var(--pac-peridot-dim); text-decoration: none;">
                            View full audit log <i class="ri ri-arrow-right-line"></i>
                        </a>
                    </div>
                @endif
            </div>
        </div>

        {{-- Quick Navigation --}}
        <div class="col-xl-5">
            <div class="card h-100">
                <div class="card-header">
                    <h5 class="mb-0">Quick Navigation</h5>
                    <small class="text-body-secondary">Jump to any section</small>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        @php
                            $navLinks = [
                                ['route' => 'admin.invoices.index', 'icon' => 'ri-file-list-3-line',  'label' => 'Invoices', 'sub' => 'Billing & payments',   'color' => 'var(--pac-peridot-dim)', 'bg' => 'color-mix(in sRGB, var(--pac-peridot) 12%, white)'],
                                ['route' => 'admin.clients.index',  'icon' => 'ri-group-line',         'label' => 'Clients',  'sub' => 'Manage client base',   'color' => '#374151',                'bg' => 'color-mix(in sRGB, #6b7280 10%, white)'],
                                ['route' => 'admin.projects.index', 'icon' => 'ri-layout-column-line', 'label' => 'Projects', 'sub' => 'Track project work',   'color' => '#111827',                'bg' => 'color-mix(in sRGB, #111827 8%, white)'],
                                ['route' => 'admin.letters.index',  'icon' => 'ri-mail-send-line',     'label' => 'Letters',  'sub' => 'Correspondence',       'color' => '#374151',                'bg' => 'color-mix(in sRGB, #6b7280 10%, white)'],
                                ['route' => 'admin.inbox.index',    'icon' => 'ri-inbox-line',         'label' => 'Inbox',    'sub' => 'Messages & replies',   'color' => '#dc2626',                'bg' => '#fef2f2'],
                                ['route' => 'admin.settings.index', 'icon' => 'ri-settings-4-line',    'label' => 'Settings', 'sub' => 'Preferences & config', 'color' => '#6b7280',                'bg' => '#f9fafb'],
                            ];
                        @endphp
                        @foreach($navLinks as $link)
                            <div class="col-6">
                                <a href="{{ route($link['route']) }}" class="pac-quick-link">
                                    <div class="pac-quick-link-icon" style="background: {{ $link['bg'] }};">
                                        <i class="ri {{ $link['icon'] }}" style="color: {{ $link['color'] }};"></i>
                                    </div>
                                    <div class="min-width-0">
                                        <p class="pac-quick-link-label">{{ $link['label'] }}</p>
                                        <p class="pac-quick-link-sub">{{ $link['sub'] }}</p>
                                    </div>
                                </a>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

    </div>
    {{-- ─── / LOWER ROW ─────────────────────────────────────────────── --}}

</x-admin-layout>
