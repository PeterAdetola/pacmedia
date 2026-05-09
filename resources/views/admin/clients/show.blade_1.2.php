<x-admin-layout :title="$client->name . ' — Client'">

    @push('page-css')
        <style>

            /* ── Page header breadcrumb area ─────────────────────────────────── */
            .page-meta {
                display: flex;
                align-items: center;
                justify-content: space-between;
                flex-wrap: wrap;
                gap: 0.75rem;
                margin-bottom: 1.5rem;
            }

            .page-meta__breadcrumb {
                display: flex;
                align-items: center;
                gap: 0.375rem;
                font-size: 0.75rem;
                color: var(--bs-secondary-color);
                font-weight: 500;
                text-transform: uppercase;
                letter-spacing: 0.07em;
            }

            .page-meta__breadcrumb a {
                color: var(--bs-secondary-color);
                text-decoration: none;
            }

            .page-meta__breadcrumb a:hover {
                color: var(--bs-primary);
            }

            .page-meta__breadcrumb-sep {
                opacity: 0.4;
                font-size: 0.875rem;
            }

            /* ── Client hero card ────────────────────────────────────────────── */
            .client-hero-card {
                border: 1px solid color-mix(in sRGB, var(--bs-base-color) 10%, var(--bs-paper-bg));
                border-radius: var(--bs-border-radius-lg);
                background: var(--bs-paper-bg);
                overflow: hidden;
            }

            /* Coloured top strip */
            .client-hero-card__stripe {
                height: 6px;
                background: linear-gradient(90deg, var(--bs-primary) 0%, color-mix(in sRGB, var(--bs-primary) 60%, var(--bs-info)) 100%);
            }

            .client-hero-card__body {
                padding: 1.5rem 1.75rem;
            }

            /* Identity row: avatar + name/badges */
            .client-identity {
                display: flex;
                align-items: flex-start;
                gap: 1.125rem;
                margin-bottom: 1.5rem;
                padding-bottom: 1.25rem;
                border-bottom: 1px solid color-mix(in sRGB, var(--bs-base-color) 8%, var(--bs-paper-bg));
            }

            .client-avatar {
                width: 56px;
                height: 56px;
                border-radius: 14px;
                background: color-mix(in sRGB, var(--bs-primary) 12%, var(--bs-paper-bg));
                border: 1.5px solid color-mix(in sRGB, var(--bs-primary) 25%, var(--bs-paper-bg));
                display: flex;
                align-items: center;
                justify-content: center;
                font-size: 1.25rem;
                font-weight: 700;
                color: var(--bs-primary);
                flex-shrink: 0;
                letter-spacing: -0.02em;
            }

            .client-identity__info {
                flex: 1;
                min-width: 0;
            }

            .client-identity__name {
                font-size: 1.1875rem;
                font-weight: 700;
                color: var(--bs-heading-color);
                line-height: 1.2;
                margin: 0 0 0.375rem;
                white-space: nowrap;
                overflow: hidden;
                text-overflow: ellipsis;
            }

            .client-identity__company {
                font-size: 0.8125rem;
                color: var(--bs-secondary-color);
                margin: 0 0 0.5rem;
            }

            .client-identity__badges {
                display: flex;
                flex-wrap: wrap;
                gap: 0.375rem;
            }

            /* Field grid */
            .client-fields {
                display: grid;
                grid-template-columns: 1fr 1fr;
                gap: 1.125rem 2.5rem;
                margin-bottom: 1.5rem;
            }

            .client-field__label {
                font-size: 0.625rem;
                font-weight: 700;
                text-transform: uppercase;
                letter-spacing: 0.09em;
                color: var(--bs-secondary-color);
                margin-bottom: 0.25rem;
                line-height: 1;
                display: flex;
                align-items: center;
                gap: 0.3rem;
            }

            .client-field__label i {
                font-size: 0.75rem;
                opacity: 0.7;
            }

            .client-field__value {
                font-size: 0.875rem;
                font-weight: 500;
                color: var(--bs-heading-color);
                line-height: 1.4;
                margin: 0;
                word-break: break-word;
            }

            .client-field__value a {
                color: var(--bs-primary);
                text-decoration: none;
            }

            .client-field__value a:hover {
                text-decoration: underline;
            }

            /* Stat pills row */
            .client-stats {
                display: flex;
                gap: 0.625rem;
                flex-wrap: wrap;
                padding: 1rem 1.25rem;
                background: color-mix(in sRGB, var(--bs-base-color) 2.5%, var(--bs-paper-bg));
                border-top: 1px solid color-mix(in sRGB, var(--bs-base-color) 8%, var(--bs-paper-bg));
            }

            .client-stat {
                display: flex;
                align-items: center;
                gap: 0.5rem;
                padding: 0.5rem 0.875rem;
                border-radius: 999px;
                border: 1px solid color-mix(in sRGB, var(--bs-base-color) 12%, var(--bs-paper-bg));
                background: var(--bs-paper-bg);
                flex-shrink: 0;
            }

            .client-stat__icon {
                width: 26px;
                height: 26px;
                border-radius: 50%;
                display: flex;
                align-items: center;
                justify-content: center;
                font-size: 0.8125rem;
                flex-shrink: 0;
            }

            .client-stat__label {
                font-size: 0.625rem;
                font-weight: 700;
                text-transform: uppercase;
                letter-spacing: 0.08em;
                color: var(--bs-secondary-color);
                line-height: 1;
                margin-bottom: 2px;
            }

            .client-stat__value {
                font-size: 0.8125rem;
                font-weight: 700;
                color: var(--bs-heading-color);
                line-height: 1;
            }

            /* Actions bar */
            .client-actions {
                display: flex;
                align-items: center;
                justify-content: flex-end;
                gap: 0.5rem;
                padding: 1rem 1.75rem;
                border-top: 1px solid color-mix(in sRGB, var(--bs-base-color) 8%, var(--bs-paper-bg));
            }

            /* ── Financial summary card ───────────────────────────────────────── */
            .fin-card {
                border: 1px solid color-mix(in sRGB, var(--bs-base-color) 10%, var(--bs-paper-bg));
                border-radius: var(--bs-border-radius-lg);
                background: var(--bs-paper-bg);
                overflow: hidden;
                height: 100%;
                display: flex;
                flex-direction: column;
            }

            .fin-card__header {
                padding: 1.125rem 1.5rem 0.75rem;
                border-bottom: 1px solid color-mix(in sRGB, var(--bs-base-color) 8%, var(--bs-paper-bg));
                display: flex;
                align-items: center;
                justify-content: space-between;
            }

            .fin-card__title {
                font-size: 0.8125rem;
                font-weight: 700;
                text-transform: uppercase;
                letter-spacing: 0.07em;
                color: var(--bs-secondary-color);
                margin: 0;
            }

            .fin-card__body {
                padding: 1.25rem 1.5rem;
                flex: 1;
                overflow-y: auto;
            }

            .fin-currency-block + .fin-currency-block {
                margin-top: 1.25rem;
                padding-top: 1.25rem;
                border-top: 1px solid color-mix(in sRGB, var(--bs-base-color) 8%, var(--bs-paper-bg));
            }

            .fin-currency-code {
                font-size: 0.6875rem;
                font-weight: 700;
                text-transform: uppercase;
                letter-spacing: 0.1em;
                color: var(--bs-secondary-color);
                margin-bottom: 0.875rem;
                display: flex;
                align-items: center;
                gap: 0.5rem;
            }

            .fin-currency-code::after {
                content: '';
                flex: 1;
                height: 1px;
                background: color-mix(in sRGB, var(--bs-base-color) 8%, var(--bs-paper-bg));
            }

            .fin-row {
                display: flex;
                justify-content: space-between;
                align-items: center;
                padding: 0.35rem 0;
                font-size: 0.84375rem;
            }

            .fin-row__label {
                color: var(--bs-secondary-color);
                font-weight: 400;
            }

            .fin-row__value {
                font-weight: 600;
                color: var(--bs-heading-color);
            }

            .fin-outstanding {
                display: flex;
                justify-content: space-between;
                align-items: center;
                margin-top: 0.75rem;
                padding: 0.625rem 0.875rem;
                border-radius: var(--bs-border-radius);
                font-size: 0.9375rem;
                font-weight: 700;
                background: color-mix(in sRGB, var(--bs-base-color) 3%, var(--bs-paper-bg));
                border: 1px solid color-mix(in sRGB, var(--bs-base-color) 9%, var(--bs-paper-bg));
            }

            .fin-outstanding__label {
                color: var(--bs-heading-color);
                font-weight: 700;
            }

            /* Progress bar for paid/invoiced */
            .fin-progress {
                height: 4px;
                border-radius: 999px;
                background: color-mix(in sRGB, var(--bs-base-color) 8%, var(--bs-paper-bg));
                overflow: hidden;
                margin-top: 0.625rem;
            }

            .fin-progress__fill {
                height: 100%;
                border-radius: 999px;
                background: var(--bs-success);
                transition: width 0.6s ease;
            }

            /* ── Invoice table ───────────────────────────────────────────────── */
            .invoices-card {
                border: 1px solid color-mix(in sRGB, var(--bs-base-color) 10%, var(--bs-paper-bg));
                border-radius: var(--bs-border-radius-lg);
                background: var(--bs-paper-bg);
                overflow: hidden;
            }

            .invoices-card__header {
                display: flex;
                align-items: center;
                justify-content: space-between;
                flex-wrap: wrap;
                gap: 0.75rem;
                padding: 1.125rem 1.5rem;
                border-bottom: 1px solid color-mix(in sRGB, var(--bs-base-color) 8%, var(--bs-paper-bg));
            }

            .invoices-card__title {
                font-size: 0.8125rem;
                font-weight: 700;
                text-transform: uppercase;
                letter-spacing: 0.07em;
                color: var(--bs-secondary-color);
                margin: 0 0 0.125rem;
            }

            .invoices-card__subtitle {
                font-size: 0.75rem;
                color: var(--bs-secondary-color);
                opacity: 0.7;
                margin: 0;
            }

            #clientInvoicesTable {
                margin: 0;
            }

            #clientInvoicesTable thead th {
                font-size: 0.625rem;
                font-weight: 700;
                text-transform: uppercase;
                letter-spacing: 0.09em;
                color: var(--bs-secondary-color);
                white-space: nowrap;
                padding: 0.75rem 1rem;
                background: color-mix(in sRGB, var(--bs-base-color) 2%, var(--bs-paper-bg));
                border-bottom: 1px solid color-mix(in sRGB, var(--bs-base-color) 8%, var(--bs-paper-bg));
            }

            #clientInvoicesTable tbody td {
                padding: 1rem;
                vertical-align: middle;
                border-bottom: 1px solid color-mix(in sRGB, var(--bs-base-color) 6%, var(--bs-paper-bg));
            }

            #clientInvoicesTable tbody tr:last-child td {
                border-bottom: 0;
            }

            #clientInvoicesTable tbody tr {
                transition: background 0.12s;
            }

            #clientInvoicesTable tbody tr:hover td {
                background: color-mix(in sRGB, var(--bs-primary) 3%, var(--bs-paper-bg));
            }

            .inv-number {
                font-weight: 700;
                font-size: 0.8125rem;
                color: var(--bs-primary);
                text-decoration: none;
                font-family: var(--bs-font-monospace);
                letter-spacing: 0.02em;
                white-space: nowrap;
            }

            .inv-number:hover { text-decoration: underline; color: var(--bs-primary); }

            .inv-project {
                font-size: 0.875rem;
                color: var(--bs-heading-color);
                font-weight: 500;
            }

            .inv-date {
                font-size: 0.8125rem;
                color: var(--bs-secondary-color);
                white-space: nowrap;
            }

            .inv-amount {
                font-weight: 700;
                font-size: 0.875rem;
                white-space: nowrap;
                font-feature-settings: 'tnum';
            }

            .tbl-action {
                display: inline-flex;
                align-items: center;
                justify-content: center;
                width: 2rem;
                height: 2rem;
                border-radius: var(--bs-border-radius);
                border: 1px solid color-mix(in sRGB, var(--bs-base-color) 13%, var(--bs-paper-bg));
                background: transparent;
                color: var(--bs-secondary-color);
                text-decoration: none;
                font-size: 0.9375rem;
                transition: background 0.15s, color 0.15s, border-color 0.15s;
            }

            .tbl-action:hover {
                background: color-mix(in sRGB, var(--bs-base-color) 6%, var(--bs-paper-bg));
                color: var(--bs-body-color);
                border-color: color-mix(in sRGB, var(--bs-base-color) 22%, var(--bs-paper-bg));
            }

            .inv-empty {
                padding: 4rem 1rem;
                text-align: center;
                color: var(--bs-secondary-color);
            }

            .inv-empty__icon {
                width: 52px;
                height: 52px;
                border-radius: 14px;
                background: color-mix(in sRGB, var(--bs-base-color) 5%, var(--bs-paper-bg));
                border: 1px solid color-mix(in sRGB, var(--bs-base-color) 10%, var(--bs-paper-bg));
                display: flex;
                align-items: center;
                justify-content: center;
                font-size: 1.5rem;
                color: var(--bs-secondary-color);
                margin: 0 auto 1rem;
                opacity: 0.6;
            }

            .inv-empty__title {
                font-size: 0.9375rem;
                font-weight: 600;
                color: var(--bs-heading-color);
                margin-bottom: 0.25rem;
            }

            .inv-empty__text {
                font-size: 0.8125rem;
                opacity: 0.7;
            }

            /* ── Offcanvas refinements ────────────────────────────────────────── */
            .offcanvas-header {
                padding: 1.25rem 1.5rem;
            }

            .offcanvas-body {
                padding: 1.5rem;
            }

            /* ── Responsive ──────────────────────────────────────────────────── */
            @media (max-width: 767px) {
                .client-fields {
                    grid-template-columns: 1fr;
                }
                .client-actions {
                    justify-content: stretch;
                }
                .client-actions .btn {
                    flex: 1;
                    justify-content: center;
                }
                .client-identity__name {
                    font-size: 1rem;
                }
            }

            @media (max-width: 479px) {
                .client-hero-card__body {
                    padding: 1.125rem;
                }
                .client-stats {
                    padding: 0.875rem 1.125rem;
                }
                .client-actions {
                    padding: 0.875rem 1.125rem;
                }
            }

        </style>
    @endpush

    {{-- ══════════════════════════════════════════════════════════════════ --}}
    {{-- Page meta / breadcrumb                                            --}}
    {{-- ══════════════════════════════════════════════════════════════════ --}}
    <div class="page-meta">
        <div class="page-meta__breadcrumb">
            <a href="{{ route('admin.clients.index') }}">Clients</a>
            <span class="page-meta__breadcrumb-sep"><i class="ri ri-arrow-right-s-line"></i></span>
            <span>{{ $client->name }}</span>
        </div>
        @if ($client->deleted_at)
            <span class="badge bg-label-danger rounded-pill">
                <i class="ri ri-archive-line me-1"></i>Archived
            </span>
        @endif
    </div>

    {{-- ══════════════════════════════════════════════════════════════════ --}}
    {{-- Row 1: Hero card + Financial summary                              --}}
    {{-- ══════════════════════════════════════════════════════════════════ --}}
    <div class="row g-4 mb-4">

        {{-- ── Hero card ─────────────────────────────────────────────────── --}}
        <div class="{{ count($currencyTotals) > 0 ? 'col-xl-8 col-lg-7' : 'col-12' }}">
            <div class="client-hero-card">
                <div class="client-hero-card__stripe"></div>

                <div class="client-hero-card__body">

                    {{-- Identity: avatar + name + company + status badges --}}
                    <div class="client-identity">
                        <div class="client-avatar">
                            {{ strtoupper(substr($client->name, 0, 2)) }}
                        </div>
                        <div class="client-identity__info">
                            <h2 class="client-identity__name">{{ $client->name }}</h2>
                            @if ($client->company)
                                <p class="client-identity__company">
                                    <i class="ri ri-building-2-line me-1" style="font-size:.875rem;"></i>{{ $client->company }}
                                </p>
                            @endif
                            <div class="client-identity__badges">
                                @if ($client->active)
                                    <span class="badge bg-label-success rounded-pill">
                                        <i class="ri ri-checkbox-circle-line me-1"></i>Active
                                    </span>
                                @else
                                    <span class="badge bg-label-warning rounded-pill">
                                        <i class="ri ri-pause-circle-line me-1"></i>Inactive
                                    </span>
                                @endif
                                @if ($client->deleted_at)
                                    <span class="badge bg-label-danger rounded-pill">
                                        <i class="ri ri-archive-line me-1"></i>Archived
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>

                    {{-- Field grid --}}
                    <div class="client-fields">

                        <div>
                            <p class="client-field__label">
                                <i class="ri ri-mail-line"></i> Email
                            </p>
                            <p class="client-field__value">
                                <a href="mailto:{{ $client->email }}">{{ $client->email }}</a>
                            </p>
                        </div>

                        @if ($client->phone)
                            <div>
                                <p class="client-field__label">
                                    <i class="ri ri-phone-line"></i> Phone
                                </p>
                                <p class="client-field__value">{{ $client->phone }}</p>
                            </div>
                        @endif

                        <div>
                            <p class="client-field__label">
                                <i class="ri ri-calendar-line"></i> Client since
                            </p>
                            <p class="client-field__value">{{ $client->created_at->format('d M, Y') }}</p>
                        </div>

                        @if ($client->address)
                            <div style="{{ $client->phone ? '' : '' }} grid-column: 1 / -1;">
                                <p class="client-field__label">
                                    <i class="ri ri-map-pin-line"></i> Address
                                </p>
                                <p class="client-field__value">{{ $client->address }}</p>
                            </div>
                        @endif

                    </div>
                    {{-- /Field grid --}}

                </div>

                {{-- Stat pills --}}
                <div class="client-stats">
                    <div class="client-stat">
                        <div class="client-stat__icon bg-label-success">
                            <i class="ri ri-calendar-check-line"></i>
                        </div>
                        <div>
                            <p class="client-stat__label mb-0">Client since</p>
                            <p class="client-stat__value mb-0">{{ $client->created_at->format('M Y') }}</p>
                        </div>
                    </div>

                    <div class="client-stat">
                        <div class="client-stat__icon bg-label-primary">
                            <i class="ri ri-file-text-line"></i>
                        </div>
                        <div>
                            <p class="client-stat__label mb-0">Invoices</p>
                            <p class="client-stat__value mb-0">{{ $invoices->count() }}</p>
                        </div>
                    </div>

                    @if (count($currencyTotals) > 0)
                        <div class="client-stat">
                            <div class="client-stat__icon bg-label-info">
                                <i class="ri ri-coins-line"></i>
                            </div>
                            <div>
                                <p class="client-stat__label mb-0">Currencies</p>
                                <p class="client-stat__value mb-0">{{ count($currencyTotals) }}</p>
                            </div>
                        </div>
                    @endif
                </div>

                {{-- Actions --}}
                <div class="client-actions">
                    @if (!$client->deleted_at)
                        <button
                            class="btn btn-outline-secondary btn-sm btn-archive-client"
                            data-id="{{ $client->id }}">
                            <i class="ri ri-archive-line me-1"></i> Archive
                        </button>
                    @else
                        <button class="btn btn-outline-success btn-sm btn-restore-client" data-id="{{ $client->id }}">
                            <i class="ri ri-arrow-go-back-line me-1"></i> Restore
                        </button>
                    @endif
                    <button
                        class="btn btn-primary btn-sm btn-edit-client"
                        data-id="{{ $client->id }}"
                        data-name="{{ $client->name }}"
                        data-email="{{ $client->email }}"
                        data-phone="{{ $client->phone }}"
                        data-company="{{ $client->company }}"
                        data-address="{{ $client->address }}"
                        data-active="{{ $client->active ? 1 : 0 }}"
                        data-bs-toggle="offcanvas"
                        data-bs-target="#offcanvasEditClient">
                        <i class="ri ri-edit-line me-1"></i> Edit client
                    </button>
                </div>

            </div>
        </div>
        {{-- /Hero card --}}

        {{-- ── Financial summary ─────────────────────────────────────────── --}}
        @if (count($currencyTotals) > 0)
            <div class="col-xl-4 col-lg-5">
                <div class="fin-card">
                    <div class="fin-card__header">
                        <h5 class="fin-card__title">Financial summary</h5>
                        <span class="badge bg-label-secondary rounded-pill" style="font-size:.6875rem;">
                            {{ count($currencyTotals) }} {{ Str::plural('currency', count($currencyTotals)) }}
                        </span>
                    </div>
                    <div class="fin-card__body">
                        @foreach ($currencyTotals as $code => $totals)
                            @php
                                $paidPct = $totals['invoiced'] > 0
                                    ? min(100, ($totals['paid'] / $totals['invoiced']) * 100)
                                    : 0;
                            @endphp
                            <div class="fin-currency-block">
                                <p class="fin-currency-code">{{ $code }}</p>

                                <div class="fin-row">
                                    <span class="fin-row__label">Total invoiced</span>
                                    <span class="fin-row__value">{{ $totals['symbol'] }} {{ number_format($totals['invoiced'], 2) }}</span>
                                </div>

                                <div class="fin-row">
                                    <span class="fin-row__label">Amount paid</span>
                                    <span class="fin-row__value text-success">{{ $totals['symbol'] }} {{ number_format($totals['paid'], 2) }}</span>
                                </div>

                                {{-- Paid progress bar --}}
                                <div class="fin-progress" title="{{ round($paidPct) }}% paid">
                                    <div class="fin-progress__fill" style="width: {{ $paidPct }}%;"></div>
                                </div>

                                <div class="fin-outstanding">
                                    <span class="fin-outstanding__label">Outstanding</span>
                                    <span class="{{ $totals['outstanding'] > 0 ? 'text-danger' : 'text-success' }}">
                                        {{ $totals['symbol'] }} {{ number_format($totals['outstanding'], 2) }}
                                    </span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        @endif
        {{-- /Financial summary --}}

    </div>
    {{-- /Row 1 --}}

    {{-- ══════════════════════════════════════════════════════════════════ --}}
    {{-- Row 2: Invoice table (full width)                                 --}}
    {{-- ══════════════════════════════════════════════════════════════════ --}}
    <div class="invoices-card">

        <div class="invoices-card__header">
            <div>
                <h5 class="invoices-card__title">Invoices</h5>
                @if ($invoices->count() > 0)
                    <p class="invoices-card__subtitle">
                        {{ $invoices->count() }} {{ Str::plural('invoice', $invoices->count()) }}
                        &middot;
                        {{ count($currencyTotals) }} {{ Str::plural('currency', count($currencyTotals)) }}
                    </p>
                @endif
            </div>
            <a href="{{ route('admin.invoices.create', ['client_id' => $client->id]) }}" class="btn btn-primary btn-sm">
                <i class="ri ri-add-line me-1"></i> New invoice
            </a>
        </div>

        <div class="table-responsive">
            <table class="table mb-0" id="clientInvoicesTable">
                <thead>
                <tr>
                    <th style="width:150px;">Invoice #</th>
                    <th>Project</th>
                    <th style="width:100px;">Currency</th>
                    <th style="width:110px;">Status</th>
                    <th style="width:125px;">Issued</th>
                    <th style="width:145px;">Outstanding</th>
                    <th style="width:90px;">Actions</th>
                </tr>
                </thead>
                <tbody>
                @forelse ($invoices as $invoice)
                    @php
                        $statusMap = [
                            'draft'   => 'bg-label-secondary',
                            'sent'    => 'bg-label-info',
                            'paid'    => 'bg-label-success',
                            'partial' => 'bg-label-warning',
                            'overdue' => 'bg-label-danger',
                        ];
                        $badgeClass  = $statusMap[$invoice->status] ?? 'bg-label-secondary';
                        $outstanding = $invoice->completedOutstanding();
                    @endphp
                    <tr>
                        <td>
                            <a href="{{ route('admin.invoices.show', $invoice->id) }}" class="inv-number">
                                {{ $invoice->number }}
                            </a>
                        </td>
                        <td>
                            <span class="inv-project">{{ $invoice->project_name ?? '—' }}</span>
                        </td>
                        <td>
                            <span class="badge bg-label-secondary rounded-pill">{{ $invoice->currency ?? 'USD' }}</span>
                        </td>
                        <td>
                            <span class="badge {{ $badgeClass }} rounded-pill text-capitalize">{{ $invoice->status }}</span>
                        </td>
                        <td>
                            <span class="inv-date">
                                {{ $invoice->submitted_at ? $invoice->submitted_at->format('d M, Y') : '—' }}
                            </span>
                        </td>
                        <td>
                            <span class="inv-amount {{ $outstanding > 0 ? 'text-danger' : 'text-success' }}">
                                {{ $invoice->currencySymbol() }} {{ number_format($outstanding, 2) }}
                            </span>
                        </td>
                        <td>
                            <div class="d-flex gap-2">
                                <a href="{{ route('admin.invoices.show', $invoice->id) }}"
                                   class="tbl-action" title="View">
                                    <i class="ri ri-eye-line"></i>
                                </a>
                                <a href="{{ route('admin.invoices.edit', $invoice->id) }}"
                                   class="tbl-action" title="Edit">
                                    <i class="ri ri-edit-line"></i>
                                </a>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7">
                            <div class="inv-empty">
                                <div class="inv-empty__icon">
                                    <i class="ri ri-file-text-line"></i>
                                </div>
                                <p class="inv-empty__title">No invoices yet</p>
                                <p class="inv-empty__text">Create the first invoice for this client to get started.</p>
                            </div>
                        </td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>

    </div>
    {{-- /Invoices card --}}

    {{-- ══════════════════════════════════════════════════════════════════ --}}
    {{-- Offcanvas — Edit client                                           --}}
    {{-- ══════════════════════════════════════════════════════════════════ --}}
    <div class="offcanvas offcanvas-end" tabindex="-1"
         id="offcanvasEditClient" aria-labelledby="offcanvasEditClientLabel">

        <div class="offcanvas-header border-bottom">
            <div>
                <h5 id="offcanvasEditClientLabel" class="offcanvas-title mb-0">Edit client</h5>
                <small class="text-body-secondary">{{ $client->name }}</small>
            </div>
            <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>

        <div class="offcanvas-body">
            <form id="editClientForm" onsubmit="return false">
                @csrf
                <input type="hidden" id="editClientId" name="clientId" value="{{ $client->id }}" />

                <div class="form-floating form-floating-outline mb-4">
                    <input type="text" class="form-control" id="editClientName" name="name"
                           value="{{ $client->name }}" placeholder="Acme Corp" required />
                    <label for="editClientName">Full name</label>
                </div>

                <div class="form-floating form-floating-outline mb-4">
                    <input type="email" class="form-control" id="editClientEmail" name="email"
                           value="{{ $client->email }}" placeholder="hello@acme.com" required />
                    <label for="editClientEmail">Email</label>
                </div>

                <div class="form-floating form-floating-outline mb-4">
                    <input type="text" class="form-control" id="editClientPhone" name="phone"
                           value="{{ $client->phone }}" placeholder="+1 (555) 000-0000" />
                    <label for="editClientPhone">Phone</label>
                </div>

                <div class="form-floating form-floating-outline mb-4">
                    <input type="text" class="form-control" id="editClientCompany" name="company"
                           value="{{ $client->company }}" placeholder="Acme Corporation" />
                    <label for="editClientCompany">Company</label>
                </div>

                <div class="form-floating form-floating-outline mb-4">
                    <textarea class="form-control" id="editClientAddress" name="address"
                              placeholder="123 Main St" style="height:100px">{{ $client->address }}</textarea>
                    <label for="editClientAddress">Address</label>
                </div>

                <div class="mb-5">
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" id="editClientActive" name="active"
                            {{ $client->active ? 'checked' : '' }} />
                        <label class="form-check-label text-heading" for="editClientActive">Active client</label>
                    </div>
                </div>

                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary flex-grow-1">
                        <i class="ri ri-check-line me-1"></i> Update client
                    </button>
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="offcanvas">Cancel</button>
                </div>
            </form>
        </div>
    </div>
    {{-- /Offcanvas --}}

    @push('page-js')
        <script>
            $(function () {

                const csrfToken  = '{{ csrf_token() }}';
                const updateUrl  = '{{ route('admin.clients.update', $client->id) }}';
                const destroyUrl = '{{ route('admin.clients.destroy', $client->id) }}';
                const restoreUrl = '{{ url('admin/clients/' . $client->id . '/restore') }}';
                const indexUrl   = '{{ route('admin.clients.index') }}';

                // ── Edit ──────────────────────────────────────────────────────────
                $('#editClientForm').on('submit', function () {
                    clearErrors('editClientForm');
                    $.ajax({
                        url: updateUrl, method: 'PUT',
                        data: {
                            _token:  csrfToken,
                            name:    $('#editClientName').val(),
                            email:   $('#editClientEmail').val(),
                            phone:   $('#editClientPhone').val(),
                            company: $('#editClientCompany').val(),
                            address: $('#editClientAddress').val(),
                            active:  $('#editClientActive').is(':checked') ? 1 : 0,
                        },
                        success: function (res) {
                            if (res.success) {
                                bootstrap.Offcanvas.getInstance(document.getElementById('offcanvasEditClient'))?.hide();
                                toastSuccess(res.message);
                                setTimeout(() => location.reload(), 800);
                            }
                        },
                        error: function (xhr) {
                            if (xhr.status === 422) {
                                $.each(xhr.responseJSON.errors, function (field, messages) {
                                    const cap   = field.charAt(0).toUpperCase() + field.slice(1);
                                    const input = $(`#editClient${cap}`);
                                    input.addClass('is-invalid');
                                    input.closest('.form-floating, .mb-4, .mb-5').append(
                                        `<div class="invalid-feedback">${messages[0]}</div>`
                                    );
                                });
                            } else {
                                toastError('Something went wrong. Please try again.');
                            }
                        }
                    });
                });

                // ── Archive ───────────────────────────────────────────────────────
                $('.btn-archive-client').on('click', function () {
                    if (!confirm('Archive this client? They can be restored later.')) return;
                    $.ajax({
                        url: destroyUrl, method: 'DELETE',
                        data: { _token: csrfToken },
                        success: function (res) {
                            if (res.success) {
                                toastSuccess(res.message);
                                setTimeout(() => window.location.href = indexUrl, 1000);
                            }
                        },
                        error: () => toastError('Could not archive client.')
                    });
                });

                // ── Restore ───────────────────────────────────────────────────────
                $('.btn-restore-client').on('click', function () {
                    if (!confirm('Restore this client?')) return;
                    $.ajax({
                        url: restoreUrl, method: 'PATCH',
                        data: { _token: csrfToken },
                        success: function (res) {
                            if (res.success) {
                                toastSuccess(res.message);
                                setTimeout(() => location.reload(), 800);
                            }
                        },
                        error: () => toastError('Could not restore client.')
                    });
                });

                // ── Helpers ───────────────────────────────────────────────────────
                function clearErrors(formId) {
                    $(`#${formId} .is-invalid`).removeClass('is-invalid');
                    $(`#${formId} .invalid-feedback`).remove();
                }
                function toastSuccess(msg) {
                    if (typeof toastr !== 'undefined') toastr.success(msg); else alert(msg);
                }
                function toastError(msg) {
                    if (typeof toastr !== 'undefined') toastr.error(msg); else alert(msg);
                }
            });
        </script>
    @endpush

</x-admin-layout>
