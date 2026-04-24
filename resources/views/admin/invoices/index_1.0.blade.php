<x-admin-layout title="Invoices">

    @push('page-css')
        <style>
            /* ══════════════════════════════════════
               STAT WIDGET SEPARATOR (matches template)
            ══════════════════════════════════════ */
            .card-widget-separator .card-widget-1,
            .card-widget-separator .card-widget-2,
            .card-widget-separator .card-widget-3 {
                border-right: 1px solid var(--bs-border-color);
            }
            @media (max-width: 991.98px) {
                .card-widget-separator .card-widget-3 { border-right: none; }
            }
            @media (max-width: 575.98px) {
                .card-widget-separator .card-widget-1,
                .card-widget-separator .card-widget-2,
                .card-widget-separator .card-widget-3 { border-right: none; }
            }
            .card-widget-separator h4 {
                font-size: 1.375rem;
                font-weight: 800;
                letter-spacing: -0.02em;
            }
            .card-widget-separator p { font-size: 0.83rem; color: #9ca3af; }

            .av-peridot .avatar-initial { background: rgba(181,204,24,0.12) !important; color: #96aa12 !important; }
            .av-green   .avatar-initial { background: rgba(34,197,94,0.1)  !important; color: #15803d !important; }
            .av-red     .avatar-initial { background: rgba(239,68,68,0.1)  !important; color: #b91c1c !important; }
            .av-metal   .avatar-initial { background: rgba(107,114,128,0.1)!important; color: #6b7280 !important; }

            /* ══════════════════════════════════════
               FILTERS
            ══════════════════════════════════════ */
            .pac-filters { display:flex; align-items:center; gap:0.75rem; flex-wrap:wrap; }
            .pac-search-wrap { position:relative; flex:1; min-width:200px; max-width:290px; }
            .pac-search-wrap i {
                position:absolute; left:0.75rem; top:50%; transform:translateY(-50%);
                color:#9ca3af; font-size:1rem; pointer-events:none;
            }
            .pac-search-input {
                width:100%; border:1px solid var(--bs-border-color); border-radius:0.5rem;
                padding:0.45rem 0.875rem 0.45rem 2.25rem; font-size:0.82rem;
                color:var(--bs-body-color); background:var(--bs-body-bg); outline:none;
                transition:border-color .15s, box-shadow .15s;
            }
            .pac-search-input:focus { border-color:#b5cc18; box-shadow:0 0 0 3px rgba(181,204,24,.12); }
            .pac-search-input::placeholder { color:#9ca3af; }
            .pac-filter-select {
                border:1px solid var(--bs-border-color); border-radius:0.5rem;
                padding:0.45rem 2rem 0.45rem 0.75rem; font-size:0.82rem;
                color:var(--bs-body-color); background-color:var(--bs-body-bg);
                outline:none; appearance:none; cursor:pointer;
                background-image:url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 24 24' fill='none' stroke='%239ca3af' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpolyline points='6 9 12 15 18 9'%3E%3C/polyline%3E%3C/svg%3E");
                background-repeat:no-repeat; background-position:right .6rem center;
            }
            .pac-filter-select:focus { border-color:#b5cc18; box-shadow:0 0 0 3px rgba(181,204,24,.12); outline:none; }

            /* ══════════════════════════════════════
               STATUS TABS
            ══════════════════════════════════════ */
            .pac-status-tabs {
                display:flex; gap:0; border-bottom:1px solid var(--bs-border-color);
                overflow-x:auto; scrollbar-width:none;
            }
            .pac-status-tabs::-webkit-scrollbar { display:none; }
            .pac-status-tab {
                font-size:0.8rem; font-weight:600; color:#9ca3af;
                padding:0.8rem 1.1rem; text-decoration:none;
                border-bottom:2px solid transparent; white-space:nowrap;
                transition:color .15s, border-color .15s;
                display:flex; align-items:center; gap:0.4rem; margin-bottom:-1px;
            }
            .pac-status-tab:hover { color:var(--bs-body-color); }
            .pac-status-tab.active { color:#96aa12; border-bottom-color:#b5cc18; }
            .pac-tab-count {
                font-size:0.65rem; font-weight:700; padding:1px 7px; border-radius:100px;
                background:var(--bs-tertiary-bg, #f1f5f9); color:#64748b;
            }
            .pac-status-tab.active .pac-tab-count { background:rgba(181,204,24,.12); color:#96aa12; }

            /* ══════════════════════════════════════
               TABLE (template card-datatable style)
            ══════════════════════════════════════ */
            .invoice-list-table thead th {
                font-size:0.72rem; font-weight:700; text-transform:uppercase;
                letter-spacing:0.07em; color:#9ca3af; padding:0.75rem 1rem;
                white-space:nowrap; border-bottom:1px solid var(--bs-border-color);
                background:var(--bs-tertiary-bg, #f9fafb); vertical-align:middle;
            }
            .invoice-list-table tbody td {
                padding:0.875rem 1rem; font-size:0.83rem; vertical-align:middle;
                border-bottom:1px solid var(--bs-border-color-translucent, #f3f4f6);
            }
            .invoice-list-table tbody tr:last-child td { border-bottom:none; }
            .invoice-list-table tbody tr:hover td { background:var(--bs-tertiary-bg, #fafafa); }

            .inv-num-link { font-size:0.8rem; font-weight:700; color:#96aa12; text-decoration:none; }
            .inv-num-link:hover { color:#b5cc18; text-decoration:underline; }

            .inv-client-av {
                width:36px; height:36px; border-radius:50%;
                background:rgba(181,204,24,.12); display:flex; align-items:center;
                justify-content:center; font-size:0.72rem; font-weight:700;
                color:#96aa12; flex-shrink:0; letter-spacing:0.02em;
            }
            .inv-client-name {
                font-size:0.84rem; font-weight:600;
                color:var(--bs-heading-color, #111827); text-decoration:none; line-height:1.2;
            }
            .inv-client-name:hover { color:#96aa12; }

            .inv-amount { font-size:0.875rem; font-weight:700; color:var(--bs-heading-color,#111827); }
            .inv-sub { font-size:0.71rem; color:#9ca3af; margin-top:1px; }
            .inv-sub.success { color:#15803d; }
            .inv-date { font-size:0.79rem; color:#6b7280; }

            .pac-pill {
                font-size:0.67rem; font-weight:700; padding:3px 10px;
                border-radius:100px; white-space:nowrap; display:inline-block; letter-spacing:0.02em;
            }
            .p-draft   { background:var(--bs-tertiary-bg, #f1f5f9); color:#64748b; }
            .p-sent    { background:rgba(59,130,246,.1);  color:#1d4ed8; }
            .p-partial { background:rgba(245,158,11,.1);  color:#b45309; }
            .p-paid    { background:rgba(34,197,94,.1);   color:#15803d; }
            .p-overdue { background:rgba(239,68,68,.1);   color:#b91c1c; }

            .inv-balance-paid {
                font-size:0.67rem; font-weight:700; padding:3px 10px; border-radius:100px;
                background:rgba(34,197,94,.1); color:#15803d; display:inline-block;
            }
            .inv-balance-due { font-size:0.8rem; font-weight:600; color:var(--bs-heading-color,#111827); }
            .inv-balance-due.overdue { color:#b91c1c; }

            /* ══════════════════════════════════════
               ACTION BUTTONS (template rounded icon btns)
            ══════════════════════════════════════ */
            .inv-act-btn {
                display:inline-flex; align-items:center; justify-content:center;
                width:32px; height:32px; border-radius:50%; border:none;
                background:transparent; color:#9ca3af; font-size:1rem;
                cursor:pointer; transition:background .12s, color .12s; text-decoration:none;
            }
            .inv-act-btn:hover { background:var(--bs-tertiary-bg,#f3f4f6); color:var(--bs-body-color,#374151); }
            .inv-act-btn.danger:hover { background:rgba(239,68,68,.08); color:#b91c1c; }
            .inv-act-btn:focus { outline:none; box-shadow:none; }

            .dropdown-menu {
                font-size:0.82rem; border-radius:0.5rem;
                border-color:var(--bs-border-color);
                box-shadow:0 4px 20px rgba(0,0,0,.08); min-width:168px;
            }
            .dropdown-item {
                font-size:0.82rem; padding:0.48rem 1rem;
                display:flex; align-items:center; gap:0.5rem;
            }
            .dropdown-item i { font-size:0.9rem; color:#9ca3af; }

            /* ══════════════════════════════════════
               BULK BAR
            ══════════════════════════════════════ */
            .pac-bulk-bar {
                display:none; align-items:center; gap:0.75rem; padding:0.6rem 1.25rem;
                background:rgba(181,204,24,.05); border-bottom:1px solid rgba(181,204,24,.2);
                font-size:0.8rem;
            }
            .pac-bulk-bar.active { display:flex; }
            .bulk-count { font-weight:700; color:#96aa12; }

            /* ══════════════════════════════════════
               EMPTY STATE
            ══════════════════════════════════════ */
            .pac-empty {
                display:flex; flex-direction:column; align-items:center;
                justify-content:center; padding:4rem 2rem; text-align:center;
            }
            .pac-empty-ring {
                width:64px; height:64px; border-radius:50%;
                border:2px dashed rgba(181,204,24,.3);
                display:flex; align-items:center; justify-content:center;
                background:rgba(181,204,24,.04); margin-bottom:1rem;
            }
            .pac-empty-ring i { font-size:1.6rem; color:rgba(181,204,24,.45); }
            .pac-empty h6 { font-size:0.95rem; font-weight:700; color:var(--bs-heading-color); margin-bottom:.35rem; }
            .pac-empty p  { font-size:0.82rem; color:#9ca3af; margin-bottom:1.1rem; }

            /* ══════════════════════════════════════
               PAGINATION
            ══════════════════════════════════════ */
            .pac-pagination {
                display:flex; align-items:center; justify-content:space-between;
                padding:0.875rem 1.25rem; border-top:1px solid var(--bs-border-color-translucent,#f3f4f6);
                font-size:0.78rem; color:#9ca3af; gap:1rem; flex-wrap:wrap;
            }
            .pac-pagination .pagination { margin:0; gap:.2rem; }
            .pac-pagination .page-link {
                border-radius:.375rem; border-color:var(--bs-border-color);
                color:var(--bs-body-color); font-size:.78rem;
                padding:.32rem .65rem; min-width:32px; text-align:center;
            }
            .pac-pagination .page-item.active .page-link {
                background:#b5cc18; border-color:#b5cc18; color:#111827; font-weight:700;
            }
            .pac-pagination .page-link:hover:not(.disabled) {
                background:var(--bs-tertiary-bg); border-color:#b5cc18; color:#96aa12;
            }
            .pac-pagination .page-item.disabled .page-link { opacity:.4; }

            /* ══════════════════════════════════════
               RESPONSIVE COLUMN HIDING
            ══════════════════════════════════════ */
            @media (max-width:1199.98px) { .col-project  { display:none; } }
            @media (max-width:991.98px)  { .col-issued   { display:none; } }
            @media (max-width:767.98px)  { .col-due, .col-cb { display:none; } }
            @media (max-width:575.98px)  { .col-balance  { display:none; } }
        </style>
    @endpush

    {{-- ── Page header action slot ── --}}
    <x-slot name="actions">
        <a href="{{ route('admin.invoices.create') }}"
           class="btn btn-sm d-flex align-items-center gap-2"
           style="background:#111827;color:#fff;border-radius:.4rem;font-size:.82rem;font-weight:600;padding:.42rem .875rem;">
            <i class="ri ri-add-line"></i>
            <span class="d-none d-sm-inline">New Invoice</span>
        </a>
    </x-slot>

    {{-- ══════════════════════════════════════════════
         STAT WIDGET BAR  (template card-widget-separator)
    ═══════════════════════════════════════════════ --}}
    <div class="card mb-6">
        <div class="card-widget-separator-wrapper">
            <div class="card-body card-widget-separator">
                <div class="row gy-4 gy-sm-1">

                    {{-- Invoices --}}
                    <div class="col-sm-6 col-lg-3">
                        <div class="d-flex justify-content-between align-items-start card-widget-1 border-end pb-4 pb-sm-0">
                            <div>
                                <h4 class="mb-1">{{ $stats['total'] ?? 0 }}</h4>
                                <p class="mb-0">Invoices</p>
                                <p class="mb-0" style="font-size:.72rem;color:#b5cc18;font-weight:600;margin-top:2px;">
                                    {{ $stats['this_month'] ?? 0 }} this month
                                </p>
                            </div>
                            <div class="avatar me-sm-6 av-peridot">
                                <span class="avatar-initial rounded-3">
                                    <i class="icon-base ri ri-pages-line text-heading icon-26px"></i>
                                </span>
                            </div>
                        </div>
                        <hr class="d-none d-sm-block d-lg-none me-6">
                    </div>

                    {{-- Total Billed --}}
                    <div class="col-sm-6 col-lg-3">
                        <div class="d-flex justify-content-between align-items-start card-widget-2 border-end pb-4 pb-sm-0">
                            <div>
                                <h4 class="mb-1" style="font-size:1.15rem;">
                                    ₦{{ number_format($stats['total_billed'] ?? 0, 0) }}
                                </h4>
                                <p class="mb-0">Total Billed</p>
                                <p class="mb-0" style="font-size:.72rem;color:#15803d;font-weight:600;margin-top:2px;">
                                    {{ $stats['paid_count'] ?? 0 }} paid in full
                                </p>
                            </div>
                            <div class="avatar me-lg-6 av-green">
                                <span class="avatar-initial rounded-3">
                                    <i class="icon-base ri ri-wallet-line text-heading icon-26px"></i>
                                </span>
                            </div>
                        </div>
                        <hr class="d-none d-sm-block d-lg-none">
                    </div>

                    {{-- Outstanding --}}
                    <div class="col-sm-6 col-lg-3">
                        <div class="d-flex justify-content-between align-items-start card-widget-3 border-end pb-4 pb-sm-0">
                            <div>
                                <h4 class="mb-1" style="font-size:1.15rem;{{ ($stats['total_outstanding']??0)>0 ? 'color:#b91c1c;' : '' }}">
                                    ₦{{ number_format($stats['total_outstanding'] ?? 0, 0) }}
                                </h4>
                                <p class="mb-0">Outstanding</p>
                                <p class="mb-0" style="font-size:.72rem;color:#b91c1c;font-weight:600;margin-top:2px;">
                                    {{ $stats['overdue_count'] ?? 0 }} overdue
                                </p>
                            </div>
                            <div class="avatar me-sm-6 av-red">
                                <span class="avatar-initial rounded-3">
                                    <i class="icon-base ri ri-money-dollar-circle-line text-heading icon-26px"></i>
                                </span>
                            </div>
                        </div>
                        <hr class="d-none d-sm-block d-lg-none">
                    </div>

                    {{-- Active Clients --}}
                    <div class="col-sm-6 col-lg-3">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <h4 class="mb-1">{{ $stats['client_count'] ?? 0 }}</h4>
                                <p class="mb-0">Active Clients</p>
                                <p class="mb-0" style="font-size:.72rem;color:#6b7280;font-weight:600;margin-top:2px;">
                                    {{ $stats['draft_count'] ?? 0 }} drafts pending
                                </p>
                            </div>
                            <div class="avatar av-metal">
                                <span class="avatar-initial rounded-3">
                                    <i class="icon-base ri ri-user-line text-heading icon-26px"></i>
                                </span>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

    {{-- ══════════════════════════════════════════════
         MAIN TABLE CARD
    ═══════════════════════════════════════════════ --}}
    <div class="card">

        {{-- Filters --}}
        <div class="d-flex align-items-center justify-content-between flex-wrap gap-3 px-4 pt-4 pb-3">
            <form method="GET" action="{{ route('admin.invoices.index') }}"
                  class="pac-filters" id="filter-form">
                <div class="pac-search-wrap">
                    <i class="ri ri-search-line"></i>
                    <input type="text" name="search" id="pac-search"
                           class="pac-search-input"
                           placeholder="Search # or client…"
                           value="{{ request('search') }}"
                           autocomplete="off">
                </div>
                @if(isset($clients) && $clients->count())
                    <select name="client_id" class="pac-filter-select" onchange="this.form.submit()">
                        <option value="">All Clients</option>
                        @foreach($clients as $c)
                            <option value="{{ $c->id }}"
                                {{ request('client_id') == $c->id ? 'selected':'' }}>
                                {{ $c->display_name }}
                            </option>
                        @endforeach
                    </select>
                @endif
                <select name="period" class="pac-filter-select" onchange="this.form.submit()">
                    <option value="">All Time</option>
                    <option value="today"      {{ request('period')==='today'      ?'selected':'' }}>Today</option>
                    <option value="this_week"  {{ request('period')==='this_week'  ?'selected':'' }}>This Week</option>
                    <option value="this_month" {{ request('period')==='this_month' ?'selected':'' }}>This Month</option>
                    <option value="last_month" {{ request('period')==='last_month' ?'selected':'' }}>Last Month</option>
                    <option value="this_year"  {{ request('period')==='this_year'  ?'selected':'' }}>This Year</option>
                </select>
                @if(request()->hasAny(['search','client_id','period','status']))
                    <a href="{{ route('admin.invoices.index') }}"
                       style="font-size:.78rem;color:#9ca3af;text-decoration:none;white-space:nowrap;display:flex;align-items:center;gap:3px;">
                        <i class="ri ri-close-circle-line"></i> Clear
                    </a>
                @endif
                <input type="hidden" name="status" value="{{ request('status') }}">
            </form>

            <div class="d-flex align-items-center gap-2"
                 style="font-size:.78rem;color:#9ca3af;white-space:nowrap;">
                Show
                <select class="pac-filter-select" style="padding:.32rem 1.5rem .32rem .5rem;"
                        onchange="location.href='{{ route('admin.invoices.index') }}?'+new URLSearchParams({...Object.fromEntries(new URLSearchParams(location.search)),per_page:this.value})">
                    @foreach([10,25,50,100] as $pp)
                        <option value="{{ $pp }}"
                            {{ request('per_page',10)==$pp ?'selected':'' }}>{{ $pp }}</option>
                    @endforeach
                </select>
                entries
            </div>
        </div>

        {{-- Status tabs --}}
        <div class="pac-status-tabs px-4">
            @php
                $tabs = [
                    ''        => ['label'=>'All',     'count'=>$stats['total']         ?? 0],
                    'draft'   => ['label'=>'Draft',   'count'=>$stats['draft_count']   ?? 0],
                    'sent'    => ['label'=>'Sent',    'count'=>$stats['sent_count']    ?? 0],
                    'partial' => ['label'=>'Partial', 'count'=>$stats['partial_count'] ?? 0],
                    'paid'    => ['label'=>'Paid',    'count'=>$stats['paid_count']    ?? 0],
                    'overdue' => ['label'=>'Overdue', 'count'=>$stats['overdue_count'] ?? 0],
                ];
                $currentStatus = request('status','');
            @endphp
            @foreach($tabs as $val => $tab)
                <a href="{{ route('admin.invoices.index', array_merge(request()->except(['status','page']), $val ? ['status'=>$val] : [])) }}"
                   class="pac-status-tab {{ $currentStatus===$val ? 'active':'' }}">
                    {{ $tab['label'] }}
                    @if($tab['count'] > 0)
                        <span class="pac-tab-count">{{ $tab['count'] }}</span>
                    @endif
                </a>
            @endforeach
        </div>

        {{-- Bulk bar --}}
        <div class="pac-bulk-bar" id="bulk-bar">
            <span class="bulk-count" id="bulk-count">0</span> selected
            <div style="width:1px;height:14px;background:var(--bs-border-color);"></div>
            <form method="POST" action="{{ route('admin.invoices.index') }}" id="bulk-form">
                @csrf
                <input type="hidden" name="_bulk_action" id="bulk-action-val">
                <div id="bulk-ids"></div>
                <button type="button" onclick="doBulk('mark_sent')"
                        class="inv-act-btn"
                        style="width:auto;height:auto;border-radius:4px;padding:3px 8px;font-size:.75rem;gap:4px;display:inline-flex;border:1px solid var(--bs-border-color);">
                    <i class="ri ri-send-plane-line" style="font-size:.85rem;"></i> Mark Sent
                </button>
                <button type="button" onclick="doBulk('mark_paid')"
                        class="inv-act-btn"
                        style="width:auto;height:auto;border-radius:4px;padding:3px 8px;font-size:.75rem;gap:4px;display:inline-flex;border:1px solid var(--bs-border-color);">
                    <i class="ri ri-check-double-line" style="font-size:.85rem;"></i> Mark Paid
                </button>
            </form>
            <button type="button" onclick="clearSel()" class="inv-act-btn ms-auto">
                <i class="ri ri-close-line"></i>
            </button>
        </div>

        {{-- Table --}}
        <div class="card-datatable table-responsive">
            <table class="invoice-list-table table table-hover mb-0">
                <thead>
                <tr>
                    <th class="col-cb" style="width:44px;padding-left:1.25rem;">
                        <input type="checkbox" class="form-check-input" id="sel-all"
                               style="width:1.05rem;height:1.05rem;">
                    </th>
                    <th>#</th>
                    <th>Client</th>
                    <th class="col-project">Project</th>
                    <th class="col-issued">Issued Date</th>
                    <th class="col-due">Due</th>
                    <th class="text-end">Total</th>
                    <th class="col-balance">Balance</th>
                    <th class="text-center">Status</th>
                    <th class="text-end cell-fit" style="padding-right:1.25rem;">Actions</th>
                </tr>
                </thead>
                <tbody>
                @forelse($invoices as $invoice)
                    @php
                        $initials    = collect(explode(' ', $invoice->client->name ?? ''))
                                        ->take(2)->map(fn($w) => strtoupper($w[0] ?? ''))->implode('');
                        $outstanding = $invoice->completedOutstanding();
                        $subtotal    = $invoice->completedSubtotal();
                    @endphp
                    <tr>
                        <td class="col-cb" style="padding-left:1.25rem;width:44px;">
                            <input type="checkbox" class="form-check-input row-cb"
                                   style="width:1.05rem;height:1.05rem;"
                                   value="{{ $invoice->id }}">
                        </td>

                        <td>
                            <a href="{{ route('admin.invoices.show', $invoice) }}"
                               class="inv-num-link">#{{ $invoice->number }}</a>
                        </td>

                        <td>
                            <div class="d-flex justify-content-start align-items-center gap-2">
                                <div class="avatar-wrapper">
                                    <div class="avatar avatar-sm">
                                        <div class="inv-client-av">{{ $initials }}</div>
                                    </div>
                                </div>
                                <div class="d-flex flex-column">
                                    <a href="{{ route('admin.invoices.show', $invoice) }}"
                                       class="inv-client-name text-truncate">
                                        {{ $invoice->client->name ?? '—' }}
                                    </a>
                                    @if($invoice->client->company)
                                        <small class="text-truncate"
                                               style="font-size:.72rem;color:#9ca3af;">
                                            {{ $invoice->client->company }}
                                        </small>
                                    @endif
                                </div>
                            </div>
                        </td>

                        <td class="col-project">
                                <span style="font-size:.79rem;color:#6b7280;max-width:150px;display:block;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;">
                                    {{ $invoice->project_name ?: '—' }}
                                </span>
                        </td>

                        <td class="col-issued">
                                <span class="inv-date">
                                    {{ \Carbon\Carbon::parse($invoice->submitted_at)->format('d M Y') }}
                                </span>
                        </td>

                        <td class="col-due">
                            <span class="inv-date">{{ $invoice->due_date }}</span>
                        </td>

                        <td class="text-end">
                            <div class="inv-amount">₦{{ number_format($subtotal, 2) }}</div>
                            @if($invoice->has_proposed)
                                <div class="inv-sub">
                                    +₦{{ number_format($invoice->proposedTotal(), 0) }} proposed
                                </div>
                            @endif
                        </td>

                        <td class="col-balance">
                            @if($invoice->status === 'paid' || $outstanding <= 0)
                                <span class="inv-balance-paid">Paid</span>
                            @else
                                <div class="inv-balance-due {{ $invoice->status==='overdue' ? 'overdue':'' }}">
                                    ₦{{ number_format($outstanding, 2) }}
                                </div>
                                @if($invoice->paid_amount > 0)
                                    <div class="inv-sub success">
                                        ₦{{ number_format($invoice->paid_amount, 2) }} rec'd
                                    </div>
                                @endif
                            @endif
                        </td>

                        <td class="text-center">
                                <span class="pac-pill p-{{ $invoice->status }}">
                                    {{ ucfirst($invoice->status) }}
                                </span>
                        </td>

                        <td class="text-end" style="padding-right:1.25rem;">
                            <div class="d-flex align-items-center justify-content-end gap-1">

                                <form method="POST"
                                      action="{{ route('admin.invoices.destroy', $invoice) }}"
                                      onsubmit="return confirm('Delete invoice #{{ $invoice->number }}?')">
                                    @csrf @method('DELETE')
                                    <button type="submit"
                                            class="inv-act-btn danger waves-effect waves-light"
                                            data-bs-toggle="tooltip"
                                            data-bs-placement="top"
                                            title="Delete Invoice">
                                        <i class="ri ri-delete-bin-7-line icon-20px"></i>
                                    </button>
                                </form>

                                <a href="{{ route('admin.invoices.show', $invoice) }}"
                                   class="inv-act-btn waves-effect waves-light"
                                   data-bs-toggle="tooltip"
                                   data-bs-placement="top"
                                   title="Preview Invoice">
                                    <i class="ri ri-eye-line icon-20px"></i>
                                </a>

                                <div class="dropdown">
                                    <button class="inv-act-btn waves-effect waves-light"
                                            data-bs-toggle="dropdown"
                                            aria-expanded="false">
                                        <i class="ri ri-more-2-line icon-20px"></i>
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-end">
                                        <li>
                                            <a class="dropdown-item"
                                               href="{{ route('admin.invoices.pdf', $invoice) }}"
                                               target="_blank">
                                                <i class="ri ri-download-2-line"></i> Download PDF
                                            </a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item"
                                               href="{{ route('admin.invoices.edit', $invoice) }}">
                                                <i class="ri ri-pencil-line"></i> Edit
                                            </a>
                                        </li>
                                        <li>
                                            <form method="POST"
                                                  action="{{ route('admin.invoices.duplicate', $invoice) }}">
                                                @csrf
                                                <button type="submit" class="dropdown-item">
                                                    <i class="ri ri-file-copy-line"></i> Duplicate
                                                </button>
                                            </form>
                                        </li>
                                        @if(!in_array($invoice->status, ['sent','paid']))
                                            <li>
                                                <form method="POST"
                                                      action="{{ route('admin.invoices.send', $invoice) }}">
                                                    @csrf
                                                    <button type="submit" class="dropdown-item">
                                                        <i class="ri ri-send-plane-line"></i> Mark as Sent
                                                    </button>
                                                </form>
                                            </li>
                                        @endif
                                        <li><hr class="dropdown-divider"></li>
                                        <li>
                                            <form method="POST"
                                                  action="{{ route('admin.invoices.destroy', $invoice) }}"
                                                  onsubmit="return confirm('Delete invoice #{{ $invoice->number }}?')">
                                                @csrf @method('DELETE')
                                                <button type="submit" class="dropdown-item"
                                                        style="color:#b91c1c;">
                                                    <i class="ri ri-delete-bin-7-line" style="color:#b91c1c;"></i>
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
                        <td colspan="10">
                            <div class="pac-empty">
                                <div class="pac-empty-ring">
                                    <i class="ri ri-file-list-3-line"></i>
                                </div>
                                @if(request()->hasAny(['search','client_id','period','status']))
                                    <h6>No invoices match your filters</h6>
                                    <p>Try adjusting the search or filter criteria above.</p>
                                    <a href="{{ route('admin.invoices.index') }}"
                                       class="btn btn-sm"
                                       style="background:var(--bs-tertiary-bg);color:var(--bs-body-color);border-radius:.4rem;font-size:.8rem;font-weight:600;">
                                        Clear Filters
                                    </a>
                                @else
                                    <h6>No invoices yet</h6>
                                    <p>Create your first invoice to start billing clients.</p>
                                    <a href="{{ route('admin.invoices.create') }}"
                                       class="btn btn-sm"
                                       style="background:#b5cc18;color:#111827;border-radius:.4rem;font-size:.8rem;font-weight:700;">
                                        <i class="ri ri-add-line"></i> New Invoice
                                    </a>
                                @endif
                            </div>
                        </td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        @if($invoices->hasPages())
            <div class="pac-pagination">
                <span>
                    Showing {{ $invoices->firstItem() }}–{{ $invoices->lastItem() }}
                    of {{ $invoices->total() }} invoices
                </span>
                {{ $invoices->appends(request()->except('page'))->links() }}
            </div>
        @elseif($invoices->count() > 0)
            <div style="padding:.75rem 1.25rem;font-size:.78rem;color:#9ca3af;border-top:1px solid var(--bs-border-color-translucent);">
                Showing all {{ $invoices->count() }} {{ Str::plural('invoice',$invoices->count()) }}
            </div>
        @endif

    </div>

    {{-- Flash toast --}}
    @if(session('success'))
        <div class="toast-container position-fixed bottom-0 end-0 p-3" style="z-index:9999;">
            <div class="toast show align-items-center"
                 style="background:var(--bs-body-bg);border-left:4px solid #b5cc18;border-radius:.5rem;box-shadow:0 4px 20px rgba(0,0,0,.1);min-width:280px;"
                 role="alert">
                <div class="d-flex">
                    <div class="toast-body d-flex align-items-center gap-2"
                         style="font-size:.83rem;color:var(--bs-body-color);">
                        <i class="ri ri-checkbox-circle-line" style="color:#b5cc18;font-size:1.1rem;"></i>
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

                /* Tooltips */
                document.querySelectorAll('[data-bs-toggle="tooltip"]').forEach(el =>
                    new bootstrap.Tooltip(el, { boundary: document.body })
                );

                /* Search debounce */
                const searchEl = document.getElementById('pac-search');
                let timer;
                if (searchEl) {
                    searchEl.addEventListener('input', () => {
                        clearTimeout(timer);
                        timer = setTimeout(() => document.getElementById('filter-form').submit(), 500);
                    });
                    searchEl.addEventListener('keydown', e => {
                        if (e.key === 'Enter') { clearTimeout(timer); document.getElementById('filter-form').submit(); }
                    });
                }

                /* Checkbox bulk select */
                const selAll  = document.getElementById('sel-all');
                const cbs     = document.querySelectorAll('.row-cb');
                const bulkBar = document.getElementById('bulk-bar');
                const bulkCnt = document.getElementById('bulk-count');

                function sync() {
                    const checked = [...cbs].filter(c => c.checked);
                    bulkBar.classList.toggle('active', checked.length > 0);
                    bulkCnt.textContent = checked.length;
                    if (selAll) {
                        selAll.indeterminate = checked.length > 0 && checked.length < cbs.length;
                        selAll.checked = checked.length === cbs.length && cbs.length > 0;
                    }
                }

                if (selAll) selAll.addEventListener('change', function () {
                    cbs.forEach(c => c.checked = this.checked); sync();
                });
                cbs.forEach(c => c.addEventListener('change', sync));

                window.clearSel = () => {
                    cbs.forEach(c => c.checked = false);
                    if (selAll) selAll.checked = false;
                    sync();
                };

                window.doBulk = action => {
                    const checked = [...cbs].filter(c => c.checked);
                    if (!checked.length) return;
                    document.getElementById('bulk-action-val').value = action;
                    const box = document.getElementById('bulk-ids');
                    box.innerHTML = '';
                    checked.forEach(c => {
                        const i = document.createElement('input');
                        i.type = 'hidden'; i.name = 'ids[]'; i.value = c.value;
                        box.appendChild(i);
                    });
                    document.getElementById('bulk-form').submit();
                };

                /* Auto-dismiss toast */
                document.querySelectorAll('.toast.show').forEach(t =>
                    setTimeout(() => bootstrap.Toast.getOrCreateInstance(t).hide(), 4500)
                );

            })();
        </script>
    @endpush

</x-admin-layout>
