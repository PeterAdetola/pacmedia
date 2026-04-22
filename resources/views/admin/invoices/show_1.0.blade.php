<x-admin-layout title="Invoice {{ $invoice->number }}">

    @push('page-css')
        <link rel="stylesheet" href="{{ asset('admin/assets/css/pages/app-invoice.css') }}">
        <style>
            /* ══════════════════════════════════════
               INVOICE DOCUMENT SHELL
            ══════════════════════════════════════ */
            .pac-invoice-card {
                border-radius: 0.875rem;
                overflow: hidden;
            }

            /* ── Section label (matches create blade) ── */
            .pac-section-label {
                font-size: 0.7rem;
                font-weight: 700;
                letter-spacing: 0.1em;
                text-transform: uppercase;
                color: #9ca3af;
                margin-bottom: 1rem;
                display: flex;
                align-items: center;
                gap: 0.5rem;
            }
            .pac-section-label::after {
                content: '';
                flex: 1;
                height: 1px;
                background: #e5e7eb;
            }

            /* ══════════════════════════════════════
               INVOICE HEADER AREA
            ══════════════════════════════════════ */
            .pac-inv-header {
                background: #f8f9fa;
                border-bottom: 1px solid #e5e7eb;
                padding: 2rem;
            }

            /* ══════════════════════════════════════
               INVOICE META GRID  (Invoice For / Payable To / Project / Due)
            ══════════════════════════════════════ */
            .pac-inv-meta {
                display: grid;
                grid-template-columns: 1fr 1fr;
                gap: 2rem;
            }
            .pac-meta-label {
                font-size: 0.68rem;
                font-weight: 700;
                letter-spacing: 0.09em;
                text-transform: uppercase;
                color: #b5cc18;
                margin-bottom: 0.4rem;
            }
            .pac-meta-name {
                font-size: 0.95rem;
                font-weight: 700;
                color: #111827;
                margin-bottom: 0.1rem;
            }
            .pac-meta-sub {
                font-size: 0.8rem;
                color: #6b7280;
                line-height: 1.5;
            }
            .pac-meta-accent {
                font-size: 0.78rem;
                font-weight: 600;
                color: #374151;
            }

            /* ══════════════════════════════════════
               SERVICES TABLE
            ══════════════════════════════════════ */
            .pac-inv-table {
                width: 100%;
                border-collapse: collapse;
            }
            .pac-inv-table thead tr {
                border-bottom: 1px solid #e5e7eb;
            }
            .pac-inv-table thead th {
                font-size: 0.67rem;
                font-weight: 700;
                text-transform: uppercase;
                letter-spacing: 0.08em;
                color: #9ca3af;
                padding: 0.5rem 0;
            }
            .pac-inv-table thead th:last-child { text-align: right; }
            .pac-inv-table thead th.col-qty { text-align: center; }
            .pac-inv-table thead th.col-up  { text-align: right; }

            .pac-inv-table tbody tr {
                border-bottom: 1px solid #f3f4f6;
            }
            .pac-inv-table tbody tr:last-child { border-bottom: none; }
            .pac-inv-table tbody td {
                padding: 0.75rem 0;
                font-size: 0.83rem;
                color: #374151;
                vertical-align: middle;
            }
            .pac-inv-table tbody td.col-qty  { text-align: center; color: #6b7280; }
            .pac-inv-table tbody td.col-up   { text-align: right; color: #6b7280; }
            .pac-inv-table tbody td.col-total {
                text-align: right;
                font-weight: 700;
                color: #111827;
            }
            .pac-inv-table tbody td.col-desc {
                font-weight: 500;
            }

            /* ══════════════════════════════════════
               SUMMARY BLOCK
            ══════════════════════════════════════ */
            .pac-summary {
                background: #f8f9fa;
                border-radius: 0.625rem;
                padding: 1.25rem 1.5rem;
                min-width: 260px;
            }
            .pac-summary-row {
                display: flex;
                justify-content: space-between;
                align-items: center;
                font-size: 0.83rem;
                padding: 0.3rem 0;
                color: #374151;
            }
            .pac-summary-row.deduction { color: #b91c1c; }
            .pac-summary-row.paid-row  { color: #15803d; }
            .pac-summary-row.total-row {
                font-size: 0.9rem;
                font-weight: 700;
                color: #111827;
                border-top: 1px solid #e5e7eb;
                margin-top: 0.4rem;
                padding-top: 0.65rem;
            }
            .pac-summary-row.outstanding-row {
                font-size: 1rem;
                font-weight: 800;
                color: #111827;
                border-top: 2px solid #111827;
                margin-top: 0.4rem;
                padding-top: 0.65rem;
            }
            .pac-summary-row.outstanding-row.overdue {
                color: #b91c1c;
                border-color: #b91c1c;
            }

            /* ══════════════════════════════════════
               NOTES BLOCK
            ══════════════════════════════════════ */
            .pac-notes {
                background: rgba(181,204,24,0.04);
                border-left: 3px solid #b5cc18;
                border-radius: 0 0.375rem 0.375rem 0;
                padding: 0.75rem 1rem;
                font-size: 0.82rem;
                color: #6b7280;
                line-height: 1.6;
            }
            .pac-notes-label {
                font-size: 0.68rem;
                font-weight: 700;
                text-transform: uppercase;
                letter-spacing: 0.08em;
                color: #9ca3af;
                margin-bottom: 0.35rem;
            }

            /* ══════════════════════════════════════
               PROPOSED SECTION DIVIDER
            ══════════════════════════════════════ */
            .pac-proposed-divider {
                display: flex;
                align-items: center;
                gap: 0.75rem;
                padding: 1.25rem 0 0.5rem;
            }
            .pac-proposed-divider-line {
                flex: 1;
                height: 1px;
                background: linear-gradient(90deg, #b5cc18 0%, #e5e7eb 100%);
            }
            .pac-proposed-badge {
                font-size: 0.68rem;
                font-weight: 700;
                letter-spacing: 0.08em;
                text-transform: uppercase;
                color: #96aa12;
                background: rgba(181,204,24,0.1);
                border: 1px solid rgba(181,204,24,0.25);
                border-radius: 100px;
                padding: 3px 10px;
                white-space: nowrap;
            }

            /* ══════════════════════════════════════
               PAYMENT DETAILS
            ══════════════════════════════════════ */
            .pac-payment-row {
                display: flex;
                align-items: baseline;
                gap: 0.5rem;
                font-size: 0.82rem;
                padding: 0.2rem 0;
            }
            .pac-payment-key {
                font-size: 0.72rem;
                font-weight: 600;
                color: #9ca3af;
                min-width: 110px;
                flex-shrink: 0;
            }
            .pac-payment-val {
                color: #374151;
                font-weight: 500;
            }

            /* ══════════════════════════════════════
               SIDEBAR (actions card)
            ══════════════════════════════════════ */
            .pac-actions-card {
                position: sticky;
                top: 80px;
            }
            .pac-status-badge {
                font-size: 0.7rem;
                font-weight: 700;
                padding: 4px 12px;
                border-radius: 100px;
                letter-spacing: 0.04em;
                display: inline-block;
            }
            .s-draft   { background: #f1f5f9; color: #64748b; }
            .s-sent    { background: rgba(59,130,246,0.1);  color: #1d4ed8; }
            .s-partial { background: rgba(245,158,11,0.1);  color: #b45309; }
            .s-paid    { background: rgba(34,197,94,0.1);   color: #15803d; }
            .s-overdue { background: rgba(239,68,68,0.1);   color: #b91c1c; }

            /* Sidebar summary rows */
            .pac-sb-row {
                display: flex;
                justify-content: space-between;
                align-items: center;
                font-size: 0.8rem;
                padding: 0.25rem 0;
                color: #6b7280;
            }
            .pac-sb-row strong { font-weight: 700; color: #111827; }
            .pac-sb-row.outstanding {
                font-size: 0.9rem;
                font-weight: 800;
                color: #111827;
                border-top: 2px solid #111827;
                margin-top: 0.35rem;
                padding-top: 0.5rem;
            }
            .pac-sb-row.outstanding.overdue {
                color: #b91c1c;
                border-color: #b91c1c;
            }

            /* Record payment input group */
            .pac-payment-form {
                display: flex;
                gap: 0.4rem;
                margin-top: 0.5rem;
            }
            .pac-payment-form input {
                flex: 1;
                min-width: 0;
                font-size: 0.8rem;
                padding: 0.4rem 0.6rem;
                border: 1px solid #e5e7eb;
                border-radius: 0.375rem;
                outline: none;
                transition: border-color 0.15s;
            }
            .pac-payment-form input:focus { border-color: #b5cc18; }
            .pac-payment-form button {
                font-size: 0.75rem;
                font-weight: 700;
                padding: 0.4rem 0.7rem;
                background: #111827;
                color: #fff;
                border: none;
                border-radius: 0.375rem;
                cursor: pointer;
                white-space: nowrap;
                transition: background 0.15s;
            }
            .pac-payment-form button:hover { background: #1f2937; }

            /* ══════════════════════════════════════
               PRINT / DARK MODE
            ══════════════════════════════════════ */
            [data-bs-theme="dark"] .pac-inv-header { background: rgba(255,255,255,0.03); }
            [data-bs-theme="dark"] .pac-summary { background: rgba(255,255,255,0.04); }
            [data-bs-theme="dark"] .pac-meta-name { color: #f9fafb; }
            [data-bs-theme="dark"] .pac-inv-table tbody td.col-total { color: #f9fafb; }
            [data-bs-theme="dark"] .pac-sb-row strong { color: #f9fafb; }
            [data-bs-theme="dark"] .pac-payment-form input { background: rgba(255,255,255,0.05); border-color: rgba(255,255,255,0.1); color: #f9fafb; }

            @media (max-width: 767.98px) {
                .pac-inv-meta { grid-template-columns: 1fr; gap: 1.25rem; }
                .pac-inv-header { padding: 1.25rem; }
            }
        </style>
    @endpush

    {{-- ══════════════════════════════════════════════
         BREADCRUMB slot
    ═══════════════════════════════════════════════ --}}
    <x-slot name="actions">
        <a href="{{ route('admin.invoices.index') }}"
           style="font-size:0.78rem; color:#9ca3af; text-decoration:none; display:flex; align-items:center; gap:4px;">
            <i class="ri ri-arrow-left-line"></i> All Invoices
        </a>
    </x-slot>

    @php
        $statusClasses = [
            'draft'   => 's-draft',
            'sent'    => 's-sent',
            'partial' => 's-partial',
            'paid'    => 's-paid',
            'overdue' => 's-overdue',
        ];
        $outstanding     = $invoice->completedOutstanding();
        $completedSub    = $invoice->completedSubtotal();
        $completedTax    = $invoice->completedTax();
        $completedWht    = $invoice->completedWht();
        $proposedSub     = $invoice->proposedSubtotal();
        $proposedTax     = $invoice->proposedTax();
        $proposedTotal   = $invoice->proposedTotal();
        $fmt = fn($n) => '₦' . number_format($n, 2);
    @endphp

    <div class="row g-4 invoice-preview">

        {{-- ══════════════════════════════════════════════
             MAIN INVOICE DOCUMENT (col 9)
        ═══════════════════════════════════════════════ --}}
        <div class="col-lg-9 col-12">
            <div class="card pac-invoice-card">

                {{-- ── Header: Logo + Invoice # + Dates ── --}}
                <div class="pac-inv-header">
                    <div class="row align-items-start g-4">

                        {{-- Studio identity --}}
                        <div class="col-md-7">
                            <div class="d-flex align-items-center gap-2 mb-3">
                                {{-- Full wordmark image — falls back to SVG mark if missing --}}
                                @if(file_exists(public_path('admin/assets/img/logo-wordmark.png')))
                                    <img src="{{ asset('admin/assets/img/logo-wordmark.png') }}"
                                         alt="The Pacmedia"
                                         style="height: 36px; width: auto; object-fit: contain;">
                                @else
                                    <svg width="32" height="32" viewBox="0 0 101.5 101.5"
                                         fill="#b5cc18" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M0,0V92.7H92.7V0ZM44.13,85.55,25.84,68.33V48.91H44.13Zm0-40.42H25.84V24l18.29-4.59ZM66.44,63.74,48.15,66V48.91H66.44Zm0-18.61H48.15V26.91l18.29,2.87Z"/>
                                    </svg>
                                    <span style="font-size:1.1rem; font-weight:800; color:#111827; letter-spacing:-0.02em;">
                                        The Pacmedia
                                    </span>
                                @endif
                            </div>
                            <p class="mb-0" style="font-size:0.8rem; color:#6b7280;">Pacmedia Creatives</p>
                            <p class="mb-0" style="font-size:0.8rem; color:#6b7280;">Lagos, Nigeria</p>
                        </div>

                        {{-- Invoice # + dates --}}
                        <div class="col-md-5 text-md-end">
                            <div style="font-size:0.68rem; font-weight:700; letter-spacing:0.12em; text-transform:uppercase; color:#9ca3af; margin-bottom:0.4rem;">
                                Invoice
                            </div>
                            <div style="font-size:1.5rem; font-weight:800; color:#b5cc18; letter-spacing:-0.02em; line-height:1; margin-bottom:0.5rem;">
                                {{ $invoice->number }}
                            </div>
                            <div style="font-size:0.78rem; color:#6b7280;">
                                Submitted on
                                <strong style="color:#374151;">
                                    {{ \Carbon\Carbon::parse($invoice->submitted_at)->format('d/m/Y') }}
                                </strong>
                            </div>
                            <div style="font-size:0.78rem; color:#6b7280; margin-top:0.2rem;">
                                Due:
                                <strong style="color:#374151;">{{ $invoice->due_date }}</strong>
                            </div>
                        </div>

                    </div>
                </div>

                <div class="card-body px-4 py-4">

                    {{-- ── Invoice For / Payable To / Project / Due ── --}}
                    <div class="pac-inv-meta mb-4">

                        <div>
                            <div class="pac-meta-label">Invoice for</div>
                            <div class="pac-meta-sub" style="font-size:0.78rem; color:#6b7280; margin-bottom:0.25rem;">
                                {{ $invoice->project_name ?: 'General Services' }}
                            </div>
                            <div class="pac-meta-name">{{ $invoice->client->name ?? '—' }}</div>
                            @if($invoice->client->company)
                                <div class="pac-meta-sub">{{ $invoice->client->company }}</div>
                            @endif
                            @if($invoice->client->email)
                                <div class="pac-meta-sub">{{ $invoice->client->email }}</div>
                            @endif
                            @if($invoice->client->phone)
                                <div class="pac-meta-sub">{{ $invoice->client->phone }}</div>
                            @endif
                        </div>

                        <div>
                            <div class="pac-meta-label">Payable to</div>
                            <div class="pac-meta-name">Pacmedia Creatives</div>
                            @if($invoice->bank_name)
                                <div class="pac-meta-sub" style="margin-top:0.4rem;">
                                    <div class="pac-payment-row">
                                        <span class="pac-payment-key">Bank</span>
                                        <span class="pac-payment-val">{{ $invoice->bank_name }}</span>
                                    </div>
                                    <div class="pac-payment-row">
                                        <span class="pac-payment-key">Account name</span>
                                        <span class="pac-payment-val">{{ $invoice->bank_account_name }}</span>
                                    </div>
                                    <div class="pac-payment-row">
                                        <span class="pac-payment-key">Account number</span>
                                        <span class="pac-payment-val" style="font-weight:700; color:#111827; font-size:0.875rem; letter-spacing:0.03em;">
                                            {{ $invoice->bank_account_number }}
                                        </span>
                                    </div>
                                </div>
                            @endif
                        </div>

                    </div>

                    <hr class="my-4">

                    {{-- ══════════════════════════════════════
                         COMPLETED SERVICES
                    ═══════════════════════════════════════ --}}
                    <div class="pac-section-label">Completed Services</div>

                    <table class="pac-inv-table mb-3">
                        <thead>
                        <tr>
                            <th style="width:50%">Description</th>
                            <th class="col-qty">Qty</th>
                            <th class="col-up">Unit Price</th>
                            <th style="text-align:right">Total Price</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($invoice->completedItems as $item)
                            <tr>
                                <td class="col-desc">{{ $item->description }}</td>
                                <td class="col-qty">{{ $item->qty }}</td>
                                <td class="col-up">{{ $fmt($item->unit_price) }}</td>
                                <td class="col-total">{{ $fmt($item->total()) }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>

                    {{-- Completed summary + notes --}}
                    <div class="row g-4 mb-4">

                        {{-- Notes left --}}
                        <div class="col-md-6">
                            @if($invoice->completed_notes)
                                <div class="pac-notes-label">Notes</div>
                                <div class="pac-notes">{{ $invoice->completed_notes }}</div>
                            @endif
                        </div>

                        {{-- Summary right --}}
                        <div class="col-md-6 d-flex justify-content-end">
                            <div class="pac-summary w-100">

                                <div class="pac-summary-row">
                                    <span>Subtotal</span>
                                    <span>{{ $fmt($completedSub) }}</span>
                                </div>

                                @if($invoice->completed_discount > 0)
                                    <div class="pac-summary-row deduction">
                                        <span>{{ $invoice->completed_discount_label ?: 'Discount' }}</span>
                                        <span>-{{ $fmt($invoice->completed_discount) }}</span>
                                    </div>
                                @endif

                                @if($invoice->tax_enabled && in_array($invoice->tax_applies_to, ['completed', 'both']))
                                    <div class="pac-summary-row">
                                        <span>{{ $invoice->tax_label }} ({{ $invoice->tax_rate }}%)</span>
                                        <span>{{ $fmt($completedTax) }}</span>
                                    </div>
                                @endif

                                @if($invoice->paid_amount > 0)
                                    <div class="pac-summary-row paid-row">
                                        <span>Paid</span>
                                        <span>-{{ $fmt($invoice->paid_amount) }}</span>
                                    </div>
                                @endif

                                @if($invoice->wht_enabled)
                                    <div class="pac-summary-row deduction">
                                        <span>{{ $invoice->wht_label }} (deducted by client)</span>
                                        <span>-{{ $fmt($completedWht) }}</span>
                                    </div>
                                @endif

                                <div class="pac-summary-row outstanding-row {{ $invoice->status === 'overdue' ? 'overdue' : '' }}">
                                    <span>Outstanding</span>
                                    <span>{{ $fmt(max(0, $outstanding)) }}</span>
                                </div>

                            </div>
                        </div>
                    </div>

                    {{-- ══════════════════════════════════════
                         PROPOSED SERVICES (conditional)
                    ═══════════════════════════════════════ --}}
                    @if($invoice->has_proposed && $invoice->proposedItems->count())

                        <div class="pac-proposed-divider">
                            <div class="pac-proposed-divider-line"></div>
                            <span class="pac-proposed-badge">Proposed Services</span>
                            <div class="pac-proposed-divider-line" style="background: linear-gradient(90deg, #e5e7eb 0%, transparent 100%);"></div>
                        </div>

                        <table class="pac-inv-table mb-3 mt-3">
                            <thead>
                            <tr>
                                <th style="width:50%">Description</th>
                                <th class="col-qty">Qty</th>
                                <th class="col-up">Unit Price</th>
                                <th style="text-align:right">Total Price</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($invoice->proposedItems as $item)
                                <tr>
                                    <td class="col-desc">{{ $item->description }}</td>
                                    <td class="col-qty">{{ $item->qty }}</td>
                                    <td class="col-up">{{ $fmt($item->unit_price) }}</td>
                                    <td class="col-total">{{ $fmt($item->total()) }}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>

                        {{-- Proposed summary + notes --}}
                        <div class="row g-4">

                            <div class="col-md-6">
                                @if($invoice->proposed_notes)
                                    <div class="pac-notes-label">Proposed Notes</div>
                                    <div class="pac-notes">{{ $invoice->proposed_notes }}</div>
                                @endif
                            </div>

                            <div class="col-md-6 d-flex justify-content-end">
                                <div class="pac-summary w-100">

                                    <div class="pac-summary-row">
                                        <span>Subtotal</span>
                                        <span>{{ $fmt($proposedSub) }}</span>
                                    </div>

                                    @if($invoice->proposed_discount > 0)
                                        <div class="pac-summary-row deduction">
                                            <span>{{ $invoice->proposed_discount_label ?: 'Discount' }}</span>
                                            <span>-{{ $fmt($invoice->proposed_discount) }}</span>
                                        </div>
                                    @endif

                                    @if($invoice->tax_enabled && in_array($invoice->tax_applies_to, ['proposed', 'both']))
                                        <div class="pac-summary-row">
                                            <span>{{ $invoice->tax_label }} ({{ $invoice->tax_rate }}%)</span>
                                            <span>{{ $fmt($proposedTax) }}</span>
                                        </div>
                                    @endif

                                    <div class="pac-summary-row total-row">
                                        <span>Total</span>
                                        <span>{{ $fmt($proposedTotal) }}</span>
                                    </div>

                                </div>
                            </div>
                        </div>

                    @endif
                    {{-- / proposed --}}

                </div>
                {{-- / card-body --}}

            </div>
            {{-- / main card --}}
        </div>

        {{-- ══════════════════════════════════════════════
             ACTIONS SIDEBAR (col 3)
        ═══════════════════════════════════════════════ --}}
        <div class="col-lg-3 col-12">
            <div class="pac-actions-card">

                {{-- ── Primary actions ── --}}
                <div class="card mb-4" style="border-radius:0.75rem;">
                    <div class="card-body d-flex flex-column gap-2">

                        {{-- Download PDF --}}
                        <a href="{{ route('admin.invoices.pdf', $invoice) }}"
                           class="btn d-flex align-items-center justify-content-center gap-2 w-100"
                           style="background:#b5cc18; color:#111827; border-radius:0.4rem; font-size:0.82rem; font-weight:700;">
                            <i class="ri ri-download-2-line"></i> Download PDF
                        </a>

                        {{-- Edit --}}
                        <a href="{{ route('admin.invoices.edit', $invoice) }}"
                           class="btn d-flex align-items-center justify-content-center gap-2 w-100"
                           style="background:#111827; color:#fff; border-radius:0.4rem; font-size:0.82rem; font-weight:600;">
                            <i class="ri ri-pencil-line"></i> Edit Invoice
                        </a>

                        {{-- Duplicate --}}
                        <form method="POST" action="{{ route('admin.invoices.duplicate', $invoice) }}">
                            @csrf
                            <button type="submit"
                                    class="btn d-flex align-items-center justify-content-center gap-2 w-100"
                                    style="background:#f8f9fa; color:#374151; border:1px solid #e5e7eb; border-radius:0.4rem; font-size:0.82rem; font-weight:600;">
                                <i class="ri ri-file-copy-line"></i> Duplicate
                            </button>
                        </form>

                        {{-- Mark as Sent (only if not already sent/paid) --}}
                        @if(!in_array($invoice->status, ['sent', 'paid']))
                            <form method="POST" action="{{ route('admin.invoices.send', $invoice) }}">
                                @csrf
                                <button type="submit"
                                        class="btn d-flex align-items-center justify-content-center gap-2 w-100"
                                        style="background:#f8f9fa; color:#1d4ed8; border:1px solid rgba(59,130,246,0.3); border-radius:0.4rem; font-size:0.82rem; font-weight:600;">
                                    <i class="ri ri-send-plane-line"></i> Mark as Sent
                                </button>
                            </form>
                        @endif

                        {{-- Delete --}}
                        <form method="POST"
                              action="{{ route('admin.invoices.destroy', $invoice) }}"
                              onsubmit="return confirm('Delete invoice {{ $invoice->number }}? This cannot be undone.')">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                    class="btn d-flex align-items-center justify-content-center gap-2 w-100"
                                    style="background:#fff; color:#b91c1c; border:1px solid rgba(239,68,68,0.25); border-radius:0.4rem; font-size:0.82rem; font-weight:600;">
                                <i class="ri ri-delete-bin-7-line"></i> Delete
                            </button>
                        </form>

                    </div>
                </div>

                {{-- ── Status ── --}}
                <div class="card mb-4" style="border-radius:0.75rem;">
                    <div class="card-body">
                        <div class="pac-section-label" style="font-size:0.65rem; margin-bottom:0.65rem;">Status</div>
                        <span class="pac-status-badge {{ $statusClasses[$invoice->status] ?? 's-draft' }}">
                            {{ ucfirst($invoice->status) }}
                        </span>
                        @if($invoice->status === 'overdue')
                            <p style="font-size:0.72rem; color:#b91c1c; margin-top:0.5rem; margin-bottom:0;">
                                <i class="ri ri-error-warning-line"></i>
                                Payment past due
                            </p>
                        @endif
                    </div>
                </div>

                {{-- ── Financial summary ── --}}
                <div class="card mb-4" style="border-radius:0.75rem;">
                    <div class="card-body">
                        <div class="pac-section-label" style="font-size:0.65rem; margin-bottom:0.75rem;">Summary</div>

                        <div class="pac-sb-row">
                            <span>Billed</span>
                            <strong>{{ $fmt($completedSub) }}</strong>
                        </div>

                        @if($invoice->paid_amount > 0)
                            <div class="pac-sb-row">
                                <span style="color:#15803d;">Paid</span>
                                <strong style="color:#15803d;">{{ $fmt($invoice->paid_amount) }}</strong>
                            </div>
                        @endif

                        @if($invoice->completed_discount > 0)
                            <div class="pac-sb-row">
                                <span>Discount</span>
                                <strong style="color:#b91c1c;">-{{ $fmt($invoice->completed_discount) }}</strong>
                            </div>
                        @endif

                        @if($invoice->has_proposed && $proposedTotal > 0)
                            <div class="pac-sb-row">
                                <span style="color:#96aa12;">Proposed</span>
                                <strong style="color:#96aa12;">{{ $fmt($proposedTotal) }}</strong>
                            </div>
                        @endif

                        <div class="pac-sb-row outstanding {{ $invoice->status === 'overdue' ? 'overdue' : '' }}">
                            <span>Outstanding</span>
                            <span>{{ $fmt(max(0, $outstanding)) }}</span>
                        </div>

                    </div>
                </div>

                {{-- ── Record payment ── --}}
                @if($invoice->status !== 'paid')
                    <div class="card" style="border-radius:0.75rem;">
                        <div class="card-body">
                            <div class="pac-section-label" style="font-size:0.65rem; margin-bottom:0.65rem;">Record Payment</div>
                            <form method="POST" action="{{ route('admin.invoices.payment', $invoice) }}">
                                @csrf
                                <div class="pac-payment-form">
                                    <input type="number"
                                           name="amount"
                                           step="0.01"
                                           min="0.01"
                                           placeholder="Amount (₦)"
                                           required>
                                    <button type="submit">Add</button>
                                </div>
                                @if($outstanding > 0)
                                    <button type="button"
                                            onclick="this.closest('form').querySelector('input').value = '{{ number_format($outstanding, 2, '.', '') }}'"
                                            style="font-size:0.7rem; color:#96aa12; background:none; border:none; padding:0; margin-top:0.4rem; cursor:pointer; font-weight:600;">
                                        Fill outstanding ({{ $fmt($outstanding) }})
                                    </button>
                                @endif
                            </form>
                        </div>
                    </div>
                @else
                    <div class="card" style="border-radius:0.75rem; border-color:rgba(34,197,94,0.25);">
                        <div class="card-body text-center py-3">
                            <i class="ri ri-checkbox-circle-line" style="font-size:1.5rem; color:#15803d; display:block; margin-bottom:0.35rem;"></i>
                            <p style="font-size:0.8rem; font-weight:700; color:#15803d; margin:0;">Paid in Full</p>
                            <p style="font-size:0.72rem; color:#9ca3af; margin:0.2rem 0 0;">{{ $fmt($invoice->paid_amount) }} received</p>
                        </div>
                    </div>
                @endif

            </div>
        </div>
        {{-- / sidebar --}}

    </div>
    {{-- / row --}}

    {{-- Flash toast --}}
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
                const toasts = document.querySelectorAll('.toast.show');
                toasts.forEach(t => {
                    setTimeout(() => bootstrap.Toast.getOrCreateInstance(t).hide(), 4000);
                });
            })();
        </script>
    @endpush

</x-admin-layout>
