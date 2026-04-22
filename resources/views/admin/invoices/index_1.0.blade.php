<x-admin-layout title="Invoices">

    @push('page-css')
        <style>
            /* ══════════════════════════════════════
               STAT SUMMARY BAR
            ══════════════════════════════════════ */
            .pac-inv-stats {
                display: grid;
                grid-template-columns: repeat(4, 1fr);
                gap: 0;
                border-radius: 0.875rem;
                overflow: hidden;
                border: 1px solid #e5e7eb;
                background: #fff;
                margin-bottom: 1.5rem;
            }
            .pac-inv-stat {
                padding: 1.25rem 1.5rem;
                position: relative;
                display: flex;
                align-items: center;
                justify-content: space-between;
                gap: 1rem;
            }
            .pac-inv-stat + .pac-inv-stat {
                border-left: 1px solid #e5e7eb;
            }
            .pac-inv-stat-label {
                font-size: 0.78rem;
                color: #9ca3af;
                font-weight: 500;
                margin-bottom: 0.2rem;
            }
            .pac-inv-stat-value {
                font-size: 1.5rem;
                font-weight: 800;
                color: #111827;
                letter-spacing: -0.03em;
                line-height: 1;
            }
            .pac-inv-stat-sub {
                font-size: 0.71rem;
                color: #d1d5db;
                margin-top: 0.2rem;
            }
            .pac-inv-stat-sub strong {
                color: #6b7280;
                font-weight: 600;
            }
            .pac-inv-stat-icon {
                width: 44px;
                height: 44px;
                border-radius: 10px;
                display: flex;
                align-items: center;
                justify-content: center;
                font-size: 1.1rem;
                flex-shrink: 0;
            }

            /* Dark mode */
            [data-bs-theme="dark"] .pac-inv-stats {
                background: var(--bs-paper-bg);
                border-color: rgba(255,255,255,0.07);
            }
            [data-bs-theme="dark"] .pac-inv-stat + .pac-inv-stat {
                border-color: rgba(255,255,255,0.07);
            }
            [data-bs-theme="dark"] .pac-inv-stat-value { color: #f9fafb; }

            @media (max-width: 767.98px) {
                .pac-inv-stats { grid-template-columns: 1fr 1fr; }
                .pac-inv-stat:nth-child(2) { border-left: 1px solid #e5e7eb; }
                .pac-inv-stat:nth-child(3) { border-left: none; border-top: 1px solid #e5e7eb; }
                .pac-inv-stat:nth-child(4) { border-left: 1px solid #e5e7eb; border-top: 1px solid #e5e7eb; }
            }
            @media (max-width: 479.98px) {
                .pac-inv-stats { grid-template-columns: 1fr; }
                .pac-inv-stat + .pac-inv-stat { border-left: none; border-top: 1px solid #e5e7eb; }
            }

            /* ══════════════════════════════════════
               FILTERS BAR
            ══════════════════════════════════════ */
            .pac-filters {
                display: flex;
                align-items: center;
                gap: 0.75rem;
                flex-wrap: wrap;
            }
            .pac-search-wrap {
                position: relative;
                flex: 1;
                min-width: 220px;
                max-width: 320px;
            }
            .pac-search-wrap i {
                position: absolute;
                left: 0.75rem;
                top: 50%;
                transform: translateY(-50%);
                color: #9ca3af;
                font-size: 1rem;
                pointer-events: none;
            }
            .pac-search-input {
                width: 100%;
                border: 1px solid #e5e7eb;
                border-radius: 0.5rem;
                padding: 0.47rem 0.875rem 0.47rem 2.25rem;
                font-size: 0.82rem;
                color: #111827;
                background: #fff;
                outline: none;
                transition: border-color 0.15s, box-shadow 0.15s;
            }
            .pac-search-input:focus {
                border-color: #b5cc18;
                box-shadow: 0 0 0 3px rgba(181,204,24,0.12);
            }
            .pac-search-input::placeholder { color: #9ca3af; }

            .pac-filter-select {
                border: 1px solid #e5e7eb;
                border-radius: 0.5rem;
                padding: 0.47rem 2rem 0.47rem 0.75rem;
                font-size: 0.82rem;
                color: #374151;
                background: #fff;
                outline: none;
                appearance: none;
                background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 24 24' fill='none' stroke='%239ca3af' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpolyline points='6 9 12 15 18 9'%3E%3C/polyline%3E%3C/svg%3E");
                background-repeat: no-repeat;
                background-position: right 0.6rem center;
                cursor: pointer;
                transition: border-color 0.15s;
            }
            .pac-filter-select:focus {
                border-color: #b5cc18;
                box-shadow: 0 0 0 3px rgba(181,204,24,0.12);
            }

            [data-bs-theme="dark"] .pac-search-input,
            [data-bs-theme="dark"] .pac-filter-select {
                background-color: var(--bs-paper-bg);
                border-color: rgba(255,255,255,0.1);
                color: var(--bs-body-color);
            }

            /* ══════════════════════════════════════
               STATUS FILTER TABS
            ══════════════════════════════════════ */
            .pac-status-tabs {
                display: flex;
                gap: 0;
                border-bottom: 1px solid #e5e7eb;
                margin-bottom: 0;
                overflow-x: auto;
                scrollbar-width: none;
            }
            .pac-status-tabs::-webkit-scrollbar { display: none; }
            .pac-status-tab {
                font-size: 0.78rem;
                font-weight: 600;
                color: #9ca3af;
                padding: 0.75rem 1.1rem;
                text-decoration: none;
                border-bottom: 2px solid transparent;
                white-space: nowrap;
                transition: color 0.15s, border-color 0.15s;
                display: flex;
                align-items: center;
                gap: 0.4rem;
            }
            .pac-status-tab:hover { color: #374151; }
            .pac-status-tab.active {
                color: #96aa12;
                border-bottom-color: #b5cc18;
            }
            .pac-tab-count {
                font-size: 0.65rem;
                font-weight: 700;
                padding: 1px 6px;
                border-radius: 100px;
                background: #f1f5f9;
                color: #64748b;
            }
            .pac-status-tab.active .pac-tab-count {
                background: rgba(181,204,24,0.12);
                color: #96aa12;
            }

            [data-bs-theme="dark"] .pac-status-tabs { border-color: rgba(255,255,255,0.08); }
            [data-bs-theme="dark"] .pac-status-tab:hover { color: var(--bs-body-color); }
            [data-bs-theme="dark"] .pac-tab-count { background: rgba(255,255,255,0.08); color: rgba(255,255,255,0.5); }

            /* ══════════════════════════════════════
               INVOICE TABLE
            ══════════════════════════════════════ */
            .pac-inv-table {
                width: 100%;
                border-collapse: collapse;
            }
            .pac-inv-table thead tr {
                background: #f9fafb;
                border-bottom: 1px solid #e5e7eb;
            }
            .pac-inv-table thead th {
                font-size: 0.67rem;
                font-weight: 700;
                text-transform: uppercase;
                letter-spacing: 0.08em;
                color: #9ca3af;
                padding: 0.65rem 1rem;
                white-space: nowrap;
            }
            .pac-inv-table tbody tr {
                border-bottom: 1px solid #f3f4f6;
                transition: background 0.1s;
            }
            .pac-inv-table tbody tr:last-child { border-bottom: none; }
            .pac-inv-table tbody tr:hover { background: #fafafa; }
            .pac-inv-table tbody td {
                padding: 0.9rem 1rem;
                font-size: 0.82rem;
                vertical-align: middle;
            }

            [data-bs-theme="dark"] .pac-inv-table thead tr { background: rgba(255,255,255,0.03); border-color: rgba(255,255,255,0.07); }
            [data-bs-theme="dark"] .pac-inv-table tbody tr { border-color: rgba(255,255,255,0.05); }
            [data-bs-theme="dark"] .pac-inv-table tbody tr:hover { background: rgba(255,255,255,0.03); }

            /* Cell types */
            .t-inv-num {
                font-size: 0.78rem;
                font-weight: 700;
                color: #96aa12;
                text-decoration: none;
            }
            .t-inv-num:hover { color: #b5cc18; text-decoration: underline; }
            .t-client-name { font-weight: 600; color: #111827; font-size: 0.83rem; }
            .t-client-company { font-size: 0.71rem; color: #9ca3af; margin-top: 1px; }
            .t-project { font-size: 0.78rem; color: #6b7280; max-width: 160px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
            .t-amount { font-size: 0.875rem; font-weight: 700; color: #111827; }
            .t-out { font-size: 0.72rem; color: #9ca3af; }
            .t-out.danger { color: #b91c1c; font-weight: 600; }
            .t-date { font-size: 0.78rem; color: #6b7280; }

            [data-bs-theme="dark"] .t-client-name { color: var(--bs-body-color); }
            [data-bs-theme="dark"] .t-amount { color: var(--bs-body-color); }

            /* Status pill */
            .pac-pill {
                font-size: 0.65rem;
                font-weight: 700;
                padding: 3px 9px;
                border-radius: 100px;
                white-space: nowrap;
                display: inline-block;
            }
            .p-draft   { background: #f1f5f9; color: #64748b; }
            .p-sent    { background: rgba(59,130,246,0.1);  color: #1d4ed8; }
            .p-partial { background: rgba(245,158,11,0.1);  color: #b45309; }
            .p-paid    { background: rgba(34,197,94,0.1);   color: #15803d; }
            .p-overdue { background: rgba(239,68,68,0.1);   color: #b91c1c; }

            /* Client avatar */
            .pac-av {
                width: 34px;
                height: 34px;
                border-radius: 50%;
                background: rgba(181,204,24,0.12);
                display: flex;
                align-items: center;
                justify-content: center;
                font-size: 0.7rem;
                font-weight: 700;
                color: #96aa12;
                flex-shrink: 0;
            }

            /* ══════════════════════════════════════
               ROW ACTIONS
            ══════════════════════════════════════ */
            .pac-row-actions {
                display: flex;
                align-items: center;
                gap: 0.2rem;
            }
            .pac-act-btn {
                width: 30px;
                height: 30px;
                border-radius: 6px;
                border: none;
                background: transparent;
                display: flex;
                align-items: center;
                justify-content: center;
                color: #9ca3af;
                font-size: 0.95rem;
                cursor: pointer;
                transition: background 0.12s, color 0.12s;
                text-decoration: none;
            }
            .pac-act-btn:hover { background: #f3f4f6; color: #374151; }
            .pac-act-btn.danger:hover { background: rgba(239,68,68,0.08); color: #b91c1c; }

            [data-bs-theme="dark"] .pac-act-btn:hover { background: rgba(255,255,255,0.08); color: var(--bs-body-color); }
            [data-bs-theme="dark"] .pac-act-btn.danger:hover { background: rgba(239,68,68,0.1); }

            /* Dropdown menu */
            .dropdown-menu { font-size: 0.82rem; border-radius: 0.5rem; border-color: #e5e7eb; box-shadow: 0 4px 16px rgba(0,0,0,0.08); min-width: 160px; }
            .dropdown-item { font-size: 0.82rem; padding: 0.45rem 1rem; }

            /* ══════════════════════════════════════
               EMPTY STATE
            ══════════════════════════════════════ */
            .pac-empty-state {
                display: flex;
                flex-direction: column;
                align-items: center;
                justify-content: center;
                padding: 4rem 2rem;
                text-align: center;
            }
            .pac-empty-ring {
                width: 64px;
                height: 64px;
                border-radius: 50%;
                border: 2px dashed rgba(181,204,24,0.3);
                display: flex;
                align-items: center;
                justify-content: center;
                background: rgba(181,204,24,0.04);
                margin-bottom: 1rem;
            }
            .pac-empty-ring i { font-size: 1.6rem; color: rgba(181,204,24,0.5); }
            .pac-empty-state h5 { font-size: 0.95rem; font-weight: 700; color: #111827; margin-bottom: 0.35rem; }
            .pac-empty-state p { font-size: 0.82rem; color: #9ca3af; margin-bottom: 1rem; }

            /* ══════════════════════════════════════
               PAGINATION
            ══════════════════════════════════════ */
            .pac-pagination {
                display: flex;
                align-items: center;
                justify-content: space-between;
                padding: 0.875rem 1.25rem;
                border-top: 1px solid #f3f4f6;
                font-size: 0.78rem;
                color: #9ca3af;
                gap: 1rem;
                flex-wrap: wrap;
            }
            .pac-pagination .pagination {
                margin: 0;
                gap: 0.2rem;
            }
            .pac-pagination .page-link {
                border-radius: 0.35rem;
                border-color: #e5e7eb;
                color: #374151;
                font-size: 0.78rem;
                padding: 0.3rem 0.6rem;
                min-width: 32px;
                text-align: center;
            }
            .pac-pagination .page-item.active .page-link {
                background: #b5cc18;
                border-color: #b5cc18;
                color: #111827;
                font-weight: 700;
            }
            .pac-pagination .page-link:hover:not(.disabled) {
                background: #f9fafb;
                border-color: #b5cc18;
                color: #96aa12;
            }
            .pac-pagination .page-item.disabled .page-link { opacity: 0.45; }

            /* ══════════════════════════════════════
               BULK SELECT
            ══════════════════════════════════════ */
            .pac-bulk-bar {
                display: none;
                align-items: center;
                gap: 0.75rem;
                padding: 0.625rem 1.25rem;
                background: rgba(181,204,24,0.06);
                border-top: 1px solid rgba(181,204,24,0.2);
                font-size: 0.8rem;
                color: #374151;
            }
            .pac-bulk-bar.active { display: flex; }
            .pac-bulk-bar span { font-weight: 600; color: #96aa12; }

            /* ══════════════════════════════════════
               RESPONSIVE
            ══════════════════════════════════════ */
            @media (max-width: 991.98px) {
                .pac-inv-table .col-project,
                .pac-inv-table .col-issued { display: none; }
            }
            @media (max-width: 767.98px) {
                .pac-inv-table .col-due { display: none; }
                .pac-inv-table thead th:first-child { display: none; }
                .pac-inv-table tbody td:first-child { display: none; }
            }
            @media (max-width: 575.98px) {
                .pac-filters { gap: 0.5rem; }
                .pac-search-wrap { max-width: 100%; }
            }
        </style>
    @endpush

    {{-- ── Page header slot ── --}}
    <x-slot name="actions">
        <a href="{{ route('admin.invoices.create') }}"
           class="btn btn-sm d-flex align-items-center gap-2"
           style="background:#111827; color:#fff; border-radius:0.4rem; font-size:0.82rem; font-weight:600;">
            <i class="ri ri-add-line"></i>
            <span class="d-none d-sm-inline">New Invoice</span>
        </a>
    </x-slot>

    {{-- ══════════════════════════════════════════════
         STAT SUMMARY BAR
    ═══════════════════════════════════════════════ --}}
    <div class="pac-inv-stats">

        {{-- Total invoices --}}
        <div class="pac-inv-stat">
            <div>
                <div class="pac-inv-stat-label">Total Invoices</div>
                <div class="pac-inv-stat-value">{{ $stats['total'] ?? 0 }}</div>
                <div class="pac-inv-stat-sub">
                    <strong>{{ $stats['this_month'] ?? 0 }}</strong> this month
                </div>
            </div>
            <div class="pac-inv-stat-icon" style="background: rgba(181,204,24,0.1);">
                <i class="ri ri-file-list-3-line" style="color:#96aa12;"></i>
            </div>
        </div>

        {{-- Total billed --}}
        <div class="pac-inv-stat">
            <div>
                <div class="pac-inv-stat-label">Total Billed</div>
                <div class="pac-inv-stat-value" style="font-size:1.2rem;">
                    ₦{{ number_format($stats['total_billed'] ?? 0, 0) }}
                </div>
                <div class="pac-inv-stat-sub">
                    <strong>{{ $stats['paid_count'] ?? 0 }}</strong> paid in full
                </div>
            </div>
            <div class="pac-inv-stat-icon" style="background: rgba(34,197,94,0.08);">
                <i class="ri ri-money-dollar-circle-line" style="color:#15803d;"></i>
            </div>
        </div>

        {{-- Outstanding --}}
        <div class="pac-inv-stat">
            <div>
                <div class="pac-inv-stat-label">Outstanding</div>
                <div class="pac-inv-stat-value" style="font-size:1.2rem; color:{{ ($stats['total_outstanding'] ?? 0) > 0 ? '#b91c1c' : '#111827' }};">
                    ₦{{ number_format($stats['total_outstanding'] ?? 0, 0) }}
                </div>
                <div class="pac-inv-stat-sub">
                    <strong>{{ $stats['overdue_count'] ?? 0 }}</strong> overdue
                </div>
            </div>
            <div class="pac-inv-stat-icon" style="background: rgba(239,68,68,0.08);">
                <i class="ri ri-error-warning-line" style="color:#b91c1c;"></i>
            </div>
        </div>

        {{-- Clients --}}
        <div class="pac-inv-stat">
            <div>
                <div class="pac-inv-stat-label">Active Clients</div>
                <div class="pac-inv-stat-value">{{ $stats['client_count'] ?? 0 }}</div>
                <div class="pac-inv-stat-sub">
                    <strong>{{ $stats['draft_count'] ?? 0 }}</strong> draft invoices
                </div>
            </div>
            <div class="pac-inv-stat-icon" style="background: rgba(107,114,128,0.1);">
                <i class="ri ri-group-line" style="color:#6b7280;"></i>
            </div>
        </div>

    </div>

    {{-- ══════════════════════════════════════════════
         MAIN CARD
    ═══════════════════════════════════════════════ --}}
    <div class="card" style="border-radius: 0.875rem; overflow: hidden;">

        {{-- ── Card top: filters ── --}}
        <div class="d-flex align-items-center justify-content-between px-4 pt-3 pb-3 gap-3 flex-wrap">
            <form method="GET" action="{{ route('admin.invoices.index') }}" class="pac-filters" id="filter-form">

                {{-- Search --}}
                <div class="pac-search-wrap">
                    <i class="ri ri-search-line"></i>
                    <input type="text"
                           name="search"
                           class="pac-search-input"
                           placeholder="Search invoice # or client…"
                           value="{{ request('search') }}"
                           autocomplete="off">
                </div>

                {{-- Client filter --}}
                @if(isset($clients) && $clients->count())
                    <select name="client_id" class="pac-filter-select" onchange="this.form.submit()">
                        <option value="">All Clients</option>
                        @foreach($clients as $c)
                            <option value="{{ $c->id }}" {{ request('client_id') == $c->id ? 'selected' : '' }}>
                                {{ $c->display_name }}
                            </option>
                        @endforeach
                    </select>
                @endif

                {{-- Date range --}}
                <select name="period" class="pac-filter-select" onchange="this.form.submit()">
                    <option value="">All Time</option>
                    <option value="today"      {{ request('period') === 'today'      ? 'selected' : '' }}>Today</option>
                    <option value="this_week"  {{ request('period') === 'this_week'  ? 'selected' : '' }}>This Week</option>
                    <option value="this_month" {{ request('period') === 'this_month' ? 'selected' : '' }}>This Month</option>
                    <option value="last_month" {{ request('period') === 'last_month' ? 'selected' : '' }}>Last Month</option>
                    <option value="this_year"  {{ request('period') === 'this_year'  ? 'selected' : '' }}>This Year</option>
                </select>

                @if(request()->hasAny(['search','client_id','period','status']))
                    <a href="{{ route('admin.invoices.index') }}"
                       style="font-size:0.78rem; color:#9ca3af; text-decoration:none; white-space:nowrap;"
                       title="Clear filters">
                        <i class="ri ri-close-circle-line"></i> Clear
                    </a>
                @endif

                {{-- Hidden status (set by tabs) --}}
                <input type="hidden" name="status" id="status-filter" value="{{ request('status') }}">
            </form>

            {{-- Per-page --}}
            <div class="d-flex align-items-center gap-2" style="font-size:0.78rem; color:#9ca3af; white-space:nowrap;">
                Show
                <select class="pac-filter-select" style="padding:0.3rem 1.5rem 0.3rem 0.5rem;"
                        onchange="window.location='{{ route('admin.invoices.index') }}?' + new URLSearchParams({...Object.fromEntries(new URLSearchParams(location.search)), per_page: this.value})">
                    @foreach([10, 25, 50, 100] as $pp)
                        <option value="{{ $pp }}" {{ request('per_page', 10) == $pp ? 'selected' : '' }}>{{ $pp }}</option>
                    @endforeach
                </select>
                entries
            </div>
        </div>

        {{-- ── Status tabs ── --}}
        <div class="pac-status-tabs px-4">
            @php
                $tabs = [
                    ''        => ['label' => 'All',     'count' => $stats['total'] ?? 0],
                    'draft'   => ['label' => 'Draft',   'count' => $stats['draft_count']   ?? 0],
                    'sent'    => ['label' => 'Sent',    'count' => $stats['sent_count']    ?? 0],
                    'partial' => ['label' => 'Partial', 'count' => $stats['partial_count'] ?? 0],
                    'paid'    => ['label' => 'Paid',    'count' => $stats['paid_count']    ?? 0],
                    'overdue' => ['label' => 'Overdue', 'count' => $stats['overdue_count'] ?? 0],
                ];
                $currentStatus = request('status', '');
            @endphp
            @foreach($tabs as $val => $tab)
                <a href="{{ route('admin.invoices.index', array_merge(request()->except(['status','page']), $val ? ['status' => $val] : [])) }}"
                   class="pac-status-tab {{ $currentStatus === $val ? 'active' : '' }}">
                    {{ $tab['label'] }}
                    @if($tab['count'] > 0)
                        <span class="pac-tab-count">{{ $tab['count'] }}</span>
                    @endif
                </a>
            @endforeach
        </div>

        {{-- ── Bulk action bar (shown when rows selected) ── --}}
        <div class="pac-bulk-bar" id="bulk-bar">
            <span id="bulk-count">0</span> selected
            <div style="height:14px; width:1px; background:#e5e7eb; margin:0 0.25rem;"></div>
            <form method="POST" action="{{ route('admin.invoices.index') }}" id="bulk-form">
                @csrf
                <input type="hidden" name="_bulk_action" id="bulk-action-input">
                <div id="bulk-ids-container"></div>
                <button type="button" onclick="bulkAction('mark_sent')"
                        class="pac-act-btn" style="font-size:0.78rem; width:auto; padding:0 0.6rem; gap:4px; display:inline-flex;">
                    <i class="ri ri-send-plane-line" style="font-size:0.85rem;"></i> Mark Sent
                </button>
                <button type="button" onclick="bulkAction('mark_paid')"
                        class="pac-act-btn" style="font-size:0.78rem; width:auto; padding:0 0.6rem; gap:4px; display:inline-flex;">
                    <i class="ri ri-check-double-line" style="font-size:0.85rem;"></i> Mark Paid
                </button>
            </form>
            <button type="button" onclick="clearSelection()"
                    class="pac-act-btn ms-auto" title="Clear selection">
                <i class="ri ri-close-line"></i>
            </button>
        </div>

        {{-- ── Invoice table ── --}}
        <div class="table-responsive">
            <table class="pac-inv-table">
                <thead>
                <tr>
                    <th style="width:36px; padding-left:1.25rem;">
                        <input type="checkbox"
                               class="form-check-input"
                               style="width:1rem; height:1rem;"
                               id="select-all"
                               title="Select all">
                    </th>
                    <th>Invoice #</th>
                    <th>Client</th>
                    <th class="col-project">Project</th>
                    <th class="col-issued">Issued</th>
                    <th class="col-due">Due</th>
                    <th class="text-end">Amount</th>
                    <th class="text-center">Status</th>
                    <th class="text-end" style="padding-right:1.25rem;">Actions</th>
                </tr>
                </thead>
                <tbody>
                @forelse($invoices as $invoice)
                    @php
                        $initials = collect(explode(' ', $invoice->client->name ?? ''))
                            ->take(2)->map(fn($w) => strtoupper($w[0] ?? ''))->implode('');
                        $outstanding = $invoice->completedOutstanding();
                    @endphp
                    <tr>
                        {{-- Checkbox --}}
                        <td style="padding-left:1.25rem; width:36px;">
                            <input type="checkbox"
                                   class="form-check-input row-check"
                                   style="width:1rem; height:1rem;"
                                   value="{{ $invoice->id }}">
                        </td>

                        {{-- Invoice # --}}
                        <td>
                            <a href="{{ route('admin.invoices.show', $invoice) }}"
                               class="t-inv-num">
                                {{ $invoice->number }}
                            </a>
                        </td>

                        {{-- Client --}}
                        <td>
                            <div class="d-flex align-items-center gap-2">
                                <div class="pac-av">{{ $initials }}</div>
                                <div>
                                    <div class="t-client-name">{{ $invoice->client->name ?? '—' }}</div>
                                    @if($invoice->client->company)
                                        <div class="t-client-company">{{ $invoice->client->company }}</div>
                                    @endif
                                </div>
                            </div>
                        </td>

                        {{-- Project --}}
                        <td class="col-project">
                            <span class="t-project">{{ $invoice->project_name ?: '—' }}</span>
                        </td>

                        {{-- Issued --}}
                        <td class="col-issued">
                                <span class="t-date">
                                    {{ \Carbon\Carbon::parse($invoice->submitted_at)->format('d M Y') }}
                                </span>
                        </td>

                        {{-- Due --}}
                        <td class="col-due">
                            <span class="t-date">{{ $invoice->due_date }}</span>
                        </td>

                        {{-- Amount --}}
                        <td class="text-end">
                            <div class="t-amount">₦{{ number_format($invoice->completedSubtotal(), 2) }}</div>
                            @if($outstanding > 0)
                                <div class="t-out {{ $invoice->status === 'overdue' ? 'danger' : '' }}">
                                    ₦{{ number_format($outstanding, 2) }} due
                                </div>
                            @elseif($invoice->paid_amount > 0)
                                <div class="t-out" style="color:#15803d;">
                                    Paid ₦{{ number_format($invoice->paid_amount, 2) }}
                                </div>
                            @endif
                        </td>

                        {{-- Status --}}
                        <td class="text-center">
                                <span class="pac-pill p-{{ $invoice->status }}">
                                    {{ ucfirst($invoice->status) }}
                                </span>
                            @if($invoice->has_proposed)
                                <div style="margin-top:3px;">
                                    <span style="font-size:0.62rem; color:#b5cc18; font-weight:600;">+Proposed</span>
                                </div>
                            @endif
                        </td>

                        {{-- Actions --}}
                        <td style="padding-right:1.25rem;">
                            <div class="pac-row-actions justify-content-end">

                                {{-- View --}}
                                <a href="{{ route('admin.invoices.show', $invoice) }}"
                                   class="pac-act-btn"
                                   title="View Invoice">
                                    <i class="ri ri-eye-line"></i>
                                </a>

                                {{-- Edit --}}
                                <a href="{{ route('admin.invoices.edit', $invoice) }}"
                                   class="pac-act-btn"
                                   title="Edit Invoice">
                                    <i class="ri ri-pencil-line"></i>
                                </a>

                                {{-- More dropdown --}}
                                <div class="dropdown">
                                    <button class="pac-act-btn"
                                            data-bs-toggle="dropdown"
                                            title="More actions">
                                        <i class="ri ri-more-2-line"></i>
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-end">
                                        <li>
                                            <a class="dropdown-item d-flex align-items-center gap-2"
                                               href="{{ route('admin.invoices.pdf', $invoice) }}"
                                               target="_blank">
                                                <i class="ri ri-download-2-line" style="font-size:0.9rem; color:#9ca3af;"></i>
                                                Download PDF
                                            </a>
                                        </li>
                                        <li>
                                            <form method="POST" action="{{ route('admin.invoices.duplicate', $invoice) }}">
                                                @csrf
                                                <button type="submit"
                                                        class="dropdown-item d-flex align-items-center gap-2">
                                                    <i class="ri ri-file-copy-line" style="font-size:0.9rem; color:#9ca3af;"></i>
                                                    Duplicate
                                                </button>
                                            </form>
                                        </li>
                                        @if($invoice->status !== 'sent' && $invoice->status !== 'paid')
                                            <li>
                                                <form method="POST" action="{{ route('admin.invoices.send', $invoice) }}">
                                                    @csrf
                                                    <button type="submit"
                                                            class="dropdown-item d-flex align-items-center gap-2">
                                                        <i class="ri ri-send-plane-line" style="font-size:0.9rem; color:#9ca3af;"></i>
                                                        Mark as Sent
                                                    </button>
                                                </form>
                                            </li>
                                        @endif
                                        <li><hr class="dropdown-divider"></li>
                                        <li>
                                            <form method="POST"
                                                  action="{{ route('admin.invoices.destroy', $invoice) }}"
                                                  onsubmit="return confirm('Delete invoice {{ $invoice->number }}? This cannot be undone.')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                        class="dropdown-item d-flex align-items-center gap-2"
                                                        style="color:#b91c1c;">
                                                    <i class="ri ri-delete-bin-7-line" style="font-size:0.9rem;"></i>
                                                    Delete
                                                </button>
                                            </form>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="9">
                            <div class="pac-empty-state">
                                <div class="pac-empty-ring">
                                    <i class="ri ri-file-list-3-line"></i>
                                </div>
                                @if(request()->hasAny(['search','client_id','period','status']))
                                    <h5>No invoices match your filters</h5>
                                    <p>Try adjusting the search or filter criteria.</p>
                                    <a href="{{ route('admin.invoices.index') }}"
                                       class="btn btn-sm"
                                       style="background:#f1f5f9; color:#374151; border-radius:0.4rem; font-size:0.8rem; font-weight:600;">
                                        Clear Filters
                                    </a>
                                @else
                                    <h5>No invoices yet</h5>
                                    <p>Create your first invoice to start billing clients.</p>
                                    <a href="{{ route('admin.invoices.create') }}"
                                       class="btn btn-sm"
                                       style="background:#b5cc18; color:#111827; border-radius:0.4rem; font-size:0.8rem; font-weight:700;">
                                        <i class="ri ri-add-line"></i> Create Invoice
                                    </a>
                                @endif
                            </div>
                        </td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>

        {{-- ── Pagination ── --}}
        @if($invoices->hasPages())
            <div class="pac-pagination">
                <span>
                    Showing {{ $invoices->firstItem() }}–{{ $invoices->lastItem() }}
                    of {{ $invoices->total() }} invoices
                </span>
                {{ $invoices->appends(request()->except('page'))->links() }}
            </div>
        @else
            @if($invoices->count() > 0)
                <div style="padding:0.75rem 1.25rem; font-size:0.78rem; color:#9ca3af; border-top:1px solid #f3f4f6;">
                    Showing all {{ $invoices->count() }} invoice{{ $invoices->count() === 1 ? '' : 's' }}
                </div>
            @endif
        @endif

    </div>
    {{-- / main card --}}

    {{-- ── Flash messages ── --}}
    @if(session('success'))
        <div class="toast-container position-fixed bottom-0 end-0 p-3" style="z-index:9999;">
            <div class="toast show align-items-center"
                 style="background:#fff; border-left:4px solid #b5cc18; border-radius:0.5rem; box-shadow:0 4px 20px rgba(0,0,0,0.1); min-width:280px;"
                 role="alert">
                <div class="d-flex">
                    <div class="toast-body d-flex align-items-center gap-2" style="font-size:0.83rem; color:#374151;">
                        <i class="ri ri-checkbox-circle-line" style="color:#b5cc18; font-size:1.1rem;"></i>
                        {{ session('success') }}
                    </div>
                    <button type="button" class="btn-close me-2 m-auto" data-bs-dismiss="toast"></button>
                </div>
            </div>
        </div>
    @endif

    @push('page-js')
        <script>
            (function () {

                /* ── Live search on Enter or 400ms debounce ── */
                const searchInput = document.querySelector('.pac-search-input');
                let searchTimer;
                if (searchInput) {
                    searchInput.addEventListener('input', function () {
                        clearTimeout(searchTimer);
                        searchTimer = setTimeout(() => {
                            document.getElementById('filter-form').submit();
                        }, 500);
                    });
                    searchInput.addEventListener('keydown', function (e) {
                        if (e.key === 'Enter') {
                            clearTimeout(searchTimer);
                            document.getElementById('filter-form').submit();
                        }
                    });
                }

                /* ── Checkbox select-all ── */
                const selectAll   = document.getElementById('select-all');
                const rowChecks   = document.querySelectorAll('.row-check');
                const bulkBar     = document.getElementById('bulk-bar');
                const bulkCount   = document.getElementById('bulk-count');
                const bulkIds     = document.getElementById('bulk-ids-container');

                function updateBulkBar() {
                    const checked = [...rowChecks].filter(c => c.checked);
                    if (checked.length > 0) {
                        bulkBar.classList.add('active');
                        bulkCount.textContent = checked.length;
                    } else {
                        bulkBar.classList.remove('active');
                    }
                    if (selectAll) {
                        selectAll.indeterminate = checked.length > 0 && checked.length < rowChecks.length;
                        selectAll.checked = checked.length === rowChecks.length && rowChecks.length > 0;
                    }
                }

                if (selectAll) {
                    selectAll.addEventListener('change', function () {
                        rowChecks.forEach(c => c.checked = this.checked);
                        updateBulkBar();
                    });
                }
                rowChecks.forEach(c => c.addEventListener('change', updateBulkBar));

                window.clearSelection = function () {
                    rowChecks.forEach(c => c.checked = false);
                    if (selectAll) selectAll.checked = false;
                    updateBulkBar();
                };

                window.bulkAction = function (action) {
                    const checked = [...rowChecks].filter(c => c.checked);
                    if (!checked.length) return;
                    document.getElementById('bulk-action-input').value = action;
                    bulkIds.innerHTML = '';
                    checked.forEach(c => {
                        const inp = document.createElement('input');
                        inp.type = 'hidden';
                        inp.name = 'ids[]';
                        inp.value = c.value;
                        bulkIds.appendChild(inp);
                    });
                    document.getElementById('bulk-form').submit();
                };

                /* ── Auto-dismiss toast ── */
                const toasts = document.querySelectorAll('.toast.show');
                toasts.forEach(t => {
                    setTimeout(() => {
                        const bsToast = bootstrap.Toast.getOrCreateInstance(t);
                        bsToast.hide();
                    }, 4000);
                });

            })();
        </script>
    @endpush

</x-admin-layout>
