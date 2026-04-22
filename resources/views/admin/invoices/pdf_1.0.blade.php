<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice {{ $invoice->number }} — The Pacmedia</title>
    <style>
        /* ── Reset & base ── */
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            font-size: 13px;
            color: #111827;
            background: #ffffff;
            line-height: 1.5;
            -webkit-print-color-adjust: exact;
            print-color-adjust: exact;
        }

        /* ── Page wrapper ── */
        .page {
            width: 794px;        /* A4 width at 96dpi */
            min-height: 1123px;  /* A4 height — content expands beyond this naturally */
            margin: 0 auto;
            padding: 56px 60px 72px;
            background: #ffffff;
        }

        /* ── HEADER ── */
        .inv-header {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            padding-bottom: 32px;
            border-bottom: 2px solid #111827;
            margin-bottom: 32px;
        }
        .inv-logo img {
            height: 42px;
            width: auto;
            object-fit: contain;
            display: block;
        }
        .inv-logo-fallback {
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .inv-logo-mark {
            width: 36px;
            height: 36px;
            flex-shrink: 0;
        }
        .inv-logo-name {
            font-size: 18px;
            font-weight: 800;
            color: #111827;
            letter-spacing: -0.02em;
        }
        .inv-studio-sub {
            font-size: 11px;
            color: #6b7280;
            margin-top: 2px;
        }

        .inv-header-right {
            text-align: right;
        }
        .inv-word-invoice {
            font-size: 11px;
            font-weight: 700;
            letter-spacing: 0.14em;
            text-transform: uppercase;
            color: #9ca3af;
            margin-bottom: 4px;
        }
        .inv-number {
            font-size: 24px;
            font-weight: 800;
            color: #b5cc18;
            letter-spacing: -0.02em;
            line-height: 1;
            margin-bottom: 6px;
        }
        .inv-date-row {
            font-size: 11.5px;
            color: #6b7280;
        }
        .inv-date-row strong { color: #374151; font-weight: 600; }

        /* ── META GRID ── */
        .inv-meta {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 40px;
            margin-bottom: 36px;
        }
        .meta-label {
            font-size: 9px;
            font-weight: 800;
            letter-spacing: 0.13em;
            text-transform: uppercase;
            color: #b5cc18;
            margin-bottom: 6px;
        }
        .meta-project {
            font-size: 11px;
            color: #6b7280;
            margin-bottom: 4px;
        }
        .meta-name {
            font-size: 15px;
            font-weight: 800;
            color: #111827;
            margin-bottom: 3px;
            letter-spacing: -0.01em;
        }
        .meta-detail {
            font-size: 11.5px;
            color: #6b7280;
            line-height: 1.6;
        }

        /* Payment detail rows */
        .pay-row {
            display: flex;
            align-items: baseline;
            gap: 8px;
            margin-bottom: 3px;
        }
        .pay-key {
            font-size: 10.5px;
            font-weight: 600;
            color: #9ca3af;
            min-width: 116px;
            flex-shrink: 0;
        }
        .pay-val {
            font-size: 11.5px;
            color: #374151;
            font-weight: 500;
        }
        .pay-val.accent {
            font-size: 13px;
            font-weight: 800;
            color: #111827;
            letter-spacing: 0.02em;
        }

        /* ── SECTION HEADING ── */
        .section-head {
            font-size: 9px;
            font-weight: 800;
            letter-spacing: 0.12em;
            text-transform: uppercase;
            color: #9ca3af;
            border-bottom: 1px solid #e5e7eb;
            padding-bottom: 6px;
            margin-bottom: 0;
        }

        /* ── SERVICES TABLE ── */
        .inv-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 0;
        }
        .inv-table thead th {
            font-size: 9px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.09em;
            color: #9ca3af;
            padding: 10px 0 8px;
            border-bottom: 1px solid #e5e7eb;
            text-align: left;
        }
        .inv-table thead th.right { text-align: right; }
        .inv-table thead th.center { text-align: center; }

        .inv-table tbody td {
            padding: 10px 0;
            font-size: 12.5px;
            color: #374151;
            border-bottom: 1px solid #f3f4f6;
            vertical-align: middle;
        }
        .inv-table tbody tr:last-child td { border-bottom: none; }
        .inv-table tbody td.desc { font-weight: 500; color: #111827; }
        .inv-table tbody td.center { text-align: center; color: #6b7280; }
        .inv-table tbody td.right { text-align: right; }
        .inv-table tbody td.total {
            text-align: right;
            font-weight: 700;
            color: #111827;
        }

        /* ── SUMMARY BLOCK ── */
        .summary-wrap {
            display: flex;
            justify-content: flex-end;
            margin-top: 16px;
            margin-bottom: 28px;
        }
        .summary-box {
            width: 300px;
            background: #f8f9fa;
            border-radius: 8px;
            padding: 16px 20px;
        }
        .sum-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-size: 12px;
            color: #374151;
            padding: 4px 0;
        }
        .sum-row.deduction { color: #b91c1c; }
        .sum-row.paid-row  { color: #15803d; }
        .sum-row.total-row {
            font-size: 13px;
            font-weight: 700;
            color: #111827;
            border-top: 1px solid #e5e7eb;
            margin-top: 6px;
            padding-top: 10px;
        }
        .sum-row.outstanding-row {
            font-size: 14px;
            font-weight: 800;
            color: #111827;
            border-top: 2px solid #111827;
            margin-top: 6px;
            padding-top: 10px;
        }

        /* ── NOTES ── */
        .notes-wrap {
            margin-bottom: 28px;
        }
        .notes-label {
            font-size: 9px;
            font-weight: 800;
            letter-spacing: 0.1em;
            text-transform: uppercase;
            color: #9ca3af;
            margin-bottom: 6px;
        }
        .notes-body {
            font-size: 11.5px;
            color: #6b7280;
            line-height: 1.65;
            border-left: 3px solid #b5cc18;
            padding-left: 10px;
        }

        /* ── PROPOSED SECTION DIVIDER ── */
        .proposed-divider {
            display: flex;
            align-items: center;
            gap: 12px;
            margin: 32px 0 24px;
        }
        .proposed-divider-line {
            flex: 1;
            height: 1px;
            background: #e5e7eb;
        }
        .proposed-badge {
            font-size: 9px;
            font-weight: 800;
            letter-spacing: 0.1em;
            text-transform: uppercase;
            color: #96aa12;
            background: rgba(181,204,24,0.1);
            border: 1px solid rgba(181,204,24,0.3);
            border-radius: 100px;
            padding: 4px 12px;
            white-space: nowrap;
        }

        /* ── FOOTER ── */
        .inv-footer {
            margin-top: 48px;
            border-top: 1px solid #e5e7eb;
            padding-top: 18px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        .inv-footer-brand {
            font-size: 10px;
            font-weight: 700;
            color: #9ca3af;
            letter-spacing: 0.06em;
            text-transform: uppercase;
        }
        .inv-footer-num {
            font-size: 10px;
            color: #d1d5db;
        }

        /* ── Print-specific ── */
        @media print {
            body { background: #fff; }
            .page {
                width: 100%;
                padding: 40px 50px 60px;
                min-height: auto;
            }
            @page {
                size: A4;
                margin: 0;
            }
        }
    </style>
</head>
<body>
<div class="page">

    @php
        $fmt = fn($n) => '₦' . number_format($n, 2);
        $completedSub  = $invoice->completedSubtotal();
        $completedTax  = $invoice->completedTax();
        $completedWht  = $invoice->completedWht();
        $outstanding   = $invoice->completedOutstanding();
        $proposedSub   = $invoice->proposedSubtotal();
        $proposedTax   = $invoice->proposedTax();
        $proposedTotal = $invoice->proposedTotal();
    @endphp

    {{-- ── HEADER ── --}}
    <div class="inv-header">
        <div class="inv-logo">
            @if(file_exists(public_path('admin/assets/img/logo-wordmark.png')))
                <img src="{{ public_path('admin/assets/img/logo-wordmark.png') }}"
                     alt="The Pacmedia">
                <div class="inv-studio-sub">Pacmedia Creatives &nbsp;·&nbsp; Lagos, Nigeria</div>
            @else
                <div class="inv-logo-fallback">
                    <svg class="inv-logo-mark" viewBox="0 0 101.5 101.5"
                         fill="#b5cc18" xmlns="http://www.w3.org/2000/svg">
                        <path d="M0,0V92.7H92.7V0ZM44.13,85.55,25.84,68.33V48.91H44.13Zm0-40.42H25.84V24l18.29-4.59ZM66.44,63.74,48.15,66V48.91H66.44Zm0-18.61H48.15V26.91l18.29,2.87Z"/>
                    </svg>
                    <div>
                        <div class="inv-logo-name">The Pacmedia</div>
                        <div class="inv-studio-sub">Pacmedia Creatives &nbsp;·&nbsp; Lagos, Nigeria</div>
                    </div>
                </div>
            @endif
        </div>

        <div class="inv-header-right">
            <div class="inv-word-invoice">Invoice</div>
            <div class="inv-number">{{ $invoice->number }}</div>
            <div class="inv-date-row">
                Submitted on <strong>{{ \Carbon\Carbon::parse($invoice->submitted_at)->format('d/m/Y') }}</strong>
            </div>
            <div class="inv-date-row" style="margin-top:3px;">
                Due: <strong>{{ $invoice->due_date }}</strong>
            </div>
        </div>
    </div>

    {{-- ── META: Invoice For / Payable To ── --}}
    <div class="inv-meta">

        <div>
            <div class="meta-label">Invoice for</div>
            @if($invoice->project_name)
                <div class="meta-project">{{ $invoice->project_name }}</div>
            @endif
            <div class="meta-name">{{ $invoice->client->name ?? '—' }}</div>
            @if($invoice->client->company)
                <div class="meta-detail">{{ $invoice->client->company }}</div>
            @endif
            @if($invoice->client->email)
                <div class="meta-detail">{{ $invoice->client->email }}</div>
            @endif
            @if($invoice->client->phone)
                <div class="meta-detail">{{ $invoice->client->phone }}</div>
            @endif
        </div>

        <div>
            <div class="meta-label">Payable to</div>
            <div class="meta-name">Pacmedia Creatives</div>
            @if($invoice->bank_name || $invoice->bank_account_name || $invoice->bank_account_number)
                <div style="margin-top:8px;">
                    @if($invoice->bank_name)
                        <div class="pay-row">
                            <span class="pay-key">Bank Name:</span>
                            <span class="pay-val">{{ $invoice->bank_name }}</span>
                        </div>
                    @endif
                    @if($invoice->bank_account_name)
                        <div class="pay-row">
                            <span class="pay-key">Account Name:</span>
                            <span class="pay-val">{{ $invoice->bank_account_name }}</span>
                        </div>
                    @endif
                    @if($invoice->bank_account_number)
                        <div class="pay-row">
                            <span class="pay-key">Account Number:</span>
                            <span class="pay-val accent">{{ $invoice->bank_account_number }}</span>
                        </div>
                    @endif
                </div>
            @endif
        </div>

    </div>

    {{-- ══════════════════════════════════════
         COMPLETED SERVICES
    ═══════════════════════════════════════ --}}
    <div class="section-head">Completed Services</div>

    <table class="inv-table">
        <thead>
        <tr>
            <th style="width:50%">Description</th>
            <th class="center" style="width:8%">Qty</th>
            <th class="right" style="width:20%">Unit Price</th>
            <th class="right" style="width:22%">Total Price</th>
        </tr>
        </thead>
        <tbody>
        @foreach($invoice->completedItems as $item)
            <tr>
                <td class="desc">{{ $item->description }}</td>
                <td class="center">{{ $item->qty }}</td>
                <td class="right">{{ $fmt($item->unit_price) }}</td>
                <td class="total">{{ $fmt($item->total()) }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>

    {{-- Completed summary --}}
    <div class="summary-wrap">
        <div class="summary-box">
            <div class="sum-row">
                <span>Subtotal</span>
                <span>{{ $fmt($completedSub) }}</span>
            </div>

            @if($invoice->completed_discount > 0)
                <div class="sum-row deduction">
                    <span>{{ $invoice->completed_discount_label ?: 'Discount' }}</span>
                    <span>-{{ $fmt($invoice->completed_discount) }}</span>
                </div>
            @endif

            @if($invoice->tax_enabled && in_array($invoice->tax_applies_to, ['completed', 'both']))
                <div class="sum-row">
                    <span>{{ $invoice->tax_label }} ({{ $invoice->tax_rate }}%)</span>
                    <span>{{ $fmt($completedTax) }}</span>
                </div>
            @endif

            @if($invoice->paid_amount > 0)
                <div class="sum-row paid-row">
                    <span>Paid</span>
                    <span>-{{ $fmt($invoice->paid_amount) }}</span>
                </div>
            @endif

            @if($invoice->wht_enabled)
                <div class="sum-row deduction">
                    <span>{{ $invoice->wht_label }}</span>
                    <span>-{{ $fmt($completedWht) }}</span>
                </div>
            @endif

            <div class="sum-row outstanding-row">
                <span>Outstanding</span>
                <span>{{ $fmt(max(0, $outstanding)) }}</span>
            </div>
        </div>
    </div>

    {{-- Completed notes --}}
    @if($invoice->completed_notes)
        <div class="notes-wrap">
            <div class="notes-label">Notes:</div>
            <div class="notes-body">{{ $invoice->completed_notes }}</div>
        </div>
    @endif

    {{-- ══════════════════════════════════════
         PROPOSED SERVICES (conditional)
    ═══════════════════════════════════════ --}}
    @if($invoice->has_proposed && $invoice->proposedItems->count())

        <div class="proposed-divider">
            <div class="proposed-divider-line"></div>
            <span class="proposed-badge">Proposed Services</span>
            <div class="proposed-divider-line"></div>
        </div>

        <table class="inv-table">
            <thead>
            <tr>
                <th style="width:50%">Description</th>
                <th class="center" style="width:8%">Qty</th>
                <th class="right" style="width:20%">Unit Price</th>
                <th class="right" style="width:22%">Total Price</th>
            </tr>
            </thead>
            <tbody>
            @foreach($invoice->proposedItems as $item)
                <tr>
                    <td class="desc">{{ $item->description }}</td>
                    <td class="center">{{ $item->qty }}</td>
                    <td class="right">{{ $fmt($item->unit_price) }}</td>
                    <td class="total">{{ $fmt($item->total()) }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>

        {{-- Proposed summary --}}
        <div class="summary-wrap">
            <div class="summary-box">
                <div class="sum-row">
                    <span>Subtotal</span>
                    <span>{{ $fmt($proposedSub) }}</span>
                </div>

                @if($invoice->proposed_discount > 0)
                    <div class="sum-row deduction">
                        <span>{{ $invoice->proposed_discount_label ?: 'Discount' }}</span>
                        <span>-{{ $fmt($invoice->proposed_discount) }}</span>
                    </div>
                @endif

                @if($invoice->tax_enabled && in_array($invoice->tax_applies_to, ['proposed', 'both']))
                    <div class="sum-row">
                        <span>{{ $invoice->tax_label }} ({{ $invoice->tax_rate }}%)</span>
                        <span>{{ $fmt($proposedTax) }}</span>
                    </div>
                @endif

                <div class="sum-row total-row">
                    <span>Total</span>
                    <span>{{ $fmt($proposedTotal) }}</span>
                </div>
            </div>
        </div>

        {{-- Proposed notes --}}
        @if($invoice->proposed_notes)
            <div class="notes-wrap">
                <div class="notes-label">Proposed Notes:</div>
                <div class="notes-body">{{ $invoice->proposed_notes }}</div>
            </div>
        @endif

    @endif
    {{-- / proposed --}}

    {{-- ── FOOTER ── --}}
    <div class="inv-footer">
        <span class="inv-footer-brand">The Pacmedia · Pacmedia Creatives</span>
        <span class="inv-footer-num">{{ $invoice->number }}</span>
    </div>

</div>
</body>
</html>
