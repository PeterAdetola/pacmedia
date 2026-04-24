<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice {{ $invoice->number }} — The Pacmedia</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Urbanist:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;1,400&family=JetBrains+Mono:wght@400;500;600&display=swap');

        /* ── Reset ── */
        *, *::before, *::after {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        /* ── Bleed / body ── */
        body {
            background-color: #e0e0e0;
            margin: 0;
            padding: 48px 0;
            font-family: 'Urbanist', sans-serif;
            color: #1a1a1a;
            -webkit-print-color-adjust: exact;
            print-color-adjust: exact;
        }

        /* ── Document ── */
        .invoice-wrapper {
            background: #ffffff;
            width: 100%;
            max-width: 620px;
            margin: 0 auto;
            padding: 60px;
            min-height: 100vh;
            box-shadow: 0 2px 32px rgba(0,0,0,0.13);
            box-sizing: border-box;
        }

        /* ── Logo block ── */
        .logo-container {
            width: 42px;
            margin-bottom: 36px;
        }
        .logo-container svg {
            width: 100%;
            display: block;
        }

        /* ── HEADER ── */
        .inv-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 40px;
            gap: 24px;
        }
        .inv-header-left h1 {
            font-family: 'Urbanist', sans-serif;
            font-size: 28px;
            font-weight: 800;
            color: #1e293b;
            letter-spacing: -0.03em;
            line-height: 1;
            margin-bottom: 10px;
        }
        .inv-header-left .inv-number-row {
            font-size: 12px;
            color: #6b7280;
            margin-bottom: 4px;
        }
        .inv-header-left .inv-number-val {
            font-family: 'JetBrains Mono', monospace;
            font-size: 13px;
            font-weight: 500;
            color: #b5cc18;
            letter-spacing: 0.02em;
        }
        .inv-header-right {
            text-align: right;
            flex-shrink: 0;
        }
        .inv-header-right .meta-row {
            font-size: 12px;
            color: #6b7280;
            margin-bottom: 5px;
            line-height: 1.5;
        }
        .inv-header-right .meta-row strong {
            color: #374151;
            font-weight: 600;
        }
        .inv-header-right .meta-row .mono {
            font-family: 'JetBrains Mono', monospace;
            font-size: 11.5px;
            color: #374151;
        }

        /* ── META GRID (Invoice For / Payable To) ── */
        .inv-meta {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 32px;
            margin-bottom: 40px;
            padding-bottom: 32px;
            border-bottom: 1px solid #e5e7eb;
        }
        .meta-label {
            font-size: 9px;
            font-weight: 800;
            letter-spacing: 0.14em;
            text-transform: uppercase;
            color: #b5cc18;
            margin-bottom: 8px;
        }
        .meta-project {
            font-size: 11px;
            color: #9ca3af;
            margin-bottom: 5px;
            font-style: italic;
        }
        .meta-name {
            font-size: 15px;
            font-weight: 800;
            color: #1e293b;
            margin-bottom: 4px;
            letter-spacing: -0.01em;
        }
        .meta-detail {
            font-size: 11.5px;
            color: #6b7280;
            line-height: 1.65;
        }

        /* Payment detail rows */
        .pay-row {
            display: flex;
            align-items: baseline;
            gap: 0;
            margin-bottom: 3px;
        }
        .pay-key {
            font-size: 10.5px;
            font-weight: 600;
            color: #9ca3af;
            min-width: 112px;
            flex-shrink: 0;
        }
        .pay-val {
            font-size: 11.5px;
            color: #374151;
            font-weight: 500;
        }
        .pay-val.mono-accent {
            font-family: 'JetBrains Mono', monospace;
            font-size: 13px;
            font-weight: 600;
            color: #1e293b;
            letter-spacing: 0.02em;
        }

        /* ── SECTION HEADING ── */
        .section-head {
            font-family: 'Urbanist', sans-serif;
            font-size: 13px;
            font-weight: 700;
            color: #1e293b;
            margin-bottom: 0;
            margin-top: 0;
        }

        /* ── SERVICES TABLE ── */
        .inv-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 0;
            font-family: 'JetBrains Mono', monospace;
        }
        .inv-table thead th {
            font-family: 'JetBrains Mono', monospace;
            font-size: 9.5px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.1em;
            color: #6b7280;
            padding: 10px 0 9px;
            border-bottom: 3px double #1e293b;
            text-align: left;
        }
        .inv-table thead th.right  { text-align: right; }
        .inv-table thead th.center { text-align: center; }

        .inv-table tbody td {
            font-family: 'JetBrains Mono', monospace;
            padding: 10px 0;
            font-size: 11.5px;
            color: #374151;
            border-bottom: 1px solid #eeeeee;
            vertical-align: middle;
        }
        .inv-table tbody tr:last-child td { border-bottom: none; }
        .inv-table tbody td.desc {
            font-size: 12px;
            font-weight: 500;
            color: #1e293b;
        }
        .inv-table tbody td.center {
            text-align: center;
            color: #9ca3af;
            font-size: 11.5px;
        }
        .inv-table tbody td.right  { text-align: right; }
        .inv-table tbody td.total  {
            text-align: right;
            font-weight: 600;
            font-size: 12px;
            color: #1e293b;
        }
        .inv-table tbody td.unit-price {
            text-align: right;
            font-size: 11.5px;
            color: #6b7280;
        }

        /* ── SUMMARY / TOTALS BLOCK ── */
        .summary-wrap {
            display: flex;
            justify-content: flex-end;
            margin-top: 16px;
            margin-bottom: 28px;
        }
        .totals-block {
            width: 260px;
            text-align: right;
        }
        .totals-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-size: 12px;
            color: #6b7280;
            padding: 4px 0;
        }
        .totals-row .mono {
            font-family: 'JetBrains Mono', monospace;
            font-size: 11.5px;
            color: #374151;
        }
        .totals-row.deduction { color: #b91c1c; }
        .totals-row.deduction .mono { color: #b91c1c; }
        .totals-row.paid-row  { color: #15803d; }
        .totals-row.paid-row .mono  { color: #15803d; }
        .totals-row.total-row {
            font-size: 13px;
            font-weight: 700;
            color: #1e293b;
            border-top: 1px solid #e5e7eb;
            margin-top: 6px;
            padding-top: 10px;
        }
        .totals-row.total-row .mono { font-size: 13px; font-weight: 600; color: #1e293b; }
        .totals-row.outstanding-row {
            font-size: 14px;
            font-weight: 800;
            color: #1e293b;
            border-top: 3px double #1e293b;
            margin-top: 6px;
            padding-top: 10px;
        }
        .totals-row.outstanding-row .mono {
            font-family: 'JetBrains Mono', monospace;
            font-size: 14px;
            font-weight: 600;
            color: #1e293b;
        }

        /* ── NOTES ── */
        .notes-wrap {
            margin-bottom: 32px;
        }
        .notes-label {
            font-size: 9px;
            font-weight: 800;
            letter-spacing: 0.12em;
            text-transform: uppercase;
            color: #9ca3af;
            margin-bottom: 6px;
        }
        .notes-body {
            font-size: 11.5px;
            color: #6b7280;
            line-height: 1.7;
            border-left: 3px solid #b5cc18;
            padding-left: 10px;
        }

        /* ── COMPLETED DIVIDER ── */
        .completed-divider {
            display: flex;
            align-items: center;
            gap: 12px;
            margin: 0 0 28px;
        }
        .completed-divider-line { flex: 1; height: 1px; background: rgba(234, 88, 12, 0.2); }
        .completed-badge {
            font-family: 'Urbanist', sans-serif;
            font-size: 9px;
            font-weight: 800;
            letter-spacing: 0.12em;
            text-transform: uppercase;
            color: #c2410c;
            background: rgba(234, 88, 12, 0.08);
            border: 1px solid rgba(234, 88, 12, 0.25);
            border-radius: 100px;
            padding: 4px 12px;
            white-space: nowrap;
        }

        /* ── PROPOSED DIVIDER ── */
        .proposed-divider {
            display: flex;
            align-items: center;
            gap: 12px;
            margin: 36px 0 28px;
        }
        .proposed-divider-line { flex: 1; height: 1px; background: #e5e7eb; }
        .proposed-badge {
            font-family: 'Urbanist', sans-serif;
            font-size: 9px;
            font-weight: 800;
            letter-spacing: 0.12em;
            text-transform: uppercase;
            color: #96aa12;
            background: rgba(181,204,24,0.1);
            border: 1px solid rgba(181,204,24,0.3);
            border-radius: 100px;
            padding: 4px 12px;
            white-space: nowrap;
        }

        /* ── SECTION SPACER ── */
        .section-spacer {
            margin-bottom: 0;
            margin-top: 32px;
        }

        /* ── PAYMENT INFO BOX (bottom, target style) ── */
        .payment-info {
            border: 1px solid #e0e0e0;
            padding: 20px 24px;
            margin-top: 36px;
            background: #fafafa;
            border-radius: 4px;
        }
        .payment-info-label {
            font-size: 9px;
            font-weight: 800;
            letter-spacing: 0.12em;
            text-transform: uppercase;
            color: #9ca3af;
            margin-bottom: 12px;
        }
        .payment-info-grid {
            display: grid;
            grid-template-columns: auto 1fr;
            gap: 4px 20px;
            align-items: baseline;
        }
        .pi-key {
            font-size: 11px;
            font-weight: 600;
            color: #9ca3af;
        }
        .pi-val {
            font-size: 11.5px;
            color: #374151;
            font-weight: 500;
        }
        .pi-val.mono-accent {
            font-family: 'JetBrains Mono', monospace;
            font-size: 13px;
            font-weight: 600;
            color: #1e293b;
            letter-spacing: 0.03em;
        }

        /* ── FOOTER ── */
        .inv-footer {
            margin-top: 48px;
            border-top: 1px solid #eeeeee;
            padding-top: 16px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        .inv-footer-brand {
            font-size: 9px;
            font-weight: 700;
            letter-spacing: 0.1em;
            text-transform: uppercase;
            color: #9ca3af;
        }
        .inv-footer-num {
            font-family: 'JetBrains Mono', monospace;
            font-size: 9px;
            color: #d1d5db;
            letter-spacing: 0.05em;
        }


        /*@media print {*/
            body {
                background: #ffffff;
                padding: 0;
            }
            .invoice-wrapper {
                max-width: 100%;
                box-shadow: none;
                padding: 40px 50px 56px;
                min-height: auto;
            }
            @page {
                size: A4;
                margin: 0;
            }

        /* ── SUBSCRIPTION DIVIDER ── */
        .subscription-divider {
            display: flex;
            align-items: center;
            gap: 12px;
            margin: 36px 0 28px;
        }
        .subscription-divider-line { flex: 1; height: 1px; background: rgba(59, 130, 246, 0.2); }
        .subscription-badge {
            font-family: 'Urbanist', sans-serif;
            font-size: 9px;
            font-weight: 800;
            letter-spacing: 0.12em;
            text-transform: uppercase;
            color: #1d4ed8;
            background: rgba(59, 130, 246, 0.1);
            border: 1px solid rgba(59, 130, 246, 0.3);
            border-radius: 100px;
            padding: 4px 12px;
            white-space: nowrap;
        }

        /* Badge for billing cycles */
        .cycle-badge {
            font-size: 8px;
            text-transform: uppercase;
            background: #f3f4f6;
            padding: 2px 6px;
            border-radius: 4px;
            color: #6b7280;
            margin-left: 8px;
        }
        /* ── STATUS BADGES ── */
        .status-badge {
            font-size: 9px;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            padding: 3px 10px;
            border-radius: 100px;
            display: inline-block;
        }

        /* Status-specific mapping */
        .s-draft   { background: #f1f5f9; color: #64748b; border: 1px solid #cbd5e1; }
        .s-sent    { background: rgba(59, 130, 246, 0.1);  color: #1d4ed8; border: 1px solid rgba(59,130,246,0.2); }
        .s-partial { background: rgba(245,158,11,0.1);  color: #b45309; border: 1px solid rgba(245,158,11,0.2); }
        .s-paid    { background: rgba(34,197,94,0.1);   color: #15803d; border: 1px solid rgba(34,197,94,0.2); }
        .s-overdue { background: rgba(239,68,68,0.1);   color: #b91c1c; border: 1px solid rgba(239,68,68,0.2); }

        .payment-info,
        .notes-wrap,
        .summary-wrap,
        .totals-block,
        .inv-footer {
            page-break-inside: avoid;
            break-inside: avoid;
        }

        .inv-table tr {
            page-break-inside: avoid;
            break-inside: avoid;
        }

        .payment-info {
            page-break-before: avoid;
            break-before: avoid;
        }

        .inv-footer {
            page-break-before: avoid;
            break-before: avoid;
        }
    </style>
</head>
<body>

<div class="invoice-wrapper">

    @php
        // Dynamic Currency Logic
         $symbol = $invoice->currencySymbol();
         $fmt = fn($n) => $symbol . ' ' . number_format((float) $n, 2);

         // Totals
         $completedSub  = $invoice->completedSubtotal();
         $completedTax  = $invoice->completedTax();
         $completedWht  = $invoice->completedWht();
         $outstanding   = $invoice->completedOutstanding();

         $proposedSub   = $invoice->proposedSubtotal();
         $proposedTax   = $invoice->proposedTax();
         $proposedTotal = $invoice->proposedTotal();

         // Subscription Totals
         $subSub        = $invoice->subscriptionSubtotal();
         $subTax        = $invoice->subscriptionTax();
         $subTotal      = $invoice->subscriptionOutstanding();

         $statusClasses = [
        'draft'   => 's-draft',
        'sent'    => 's-sent',
        'partial' => 's-partial',
        'paid'    => 's-paid',
        'overdue' => 's-overdue',
    ];
    @endphp

    {{-- ── Logo: yellow strip + dark square + peridot Pacmedia mark ── --}}
    <div class="logo-container">
        <svg version="1.0" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
             viewBox="0 0 42 50" enable-background="new 0 0 42 50" xml:space="preserve">
<rect y="0" fill="#FFEF04" width="42" height="2"/>
            <rect y="4" fill="#211F20" width="42" height="46"/>
            <g transform="translate(-4.114,-1.565) scale(0.5443)">
                <path fill="#FFFFFF" d="M44.6,80L30.4,66.6V51.5h14.2V80z M44.6,48.6H30.4V32.2l14.2-3.6V48.6z"/>
                <path fill="#FFFFFF" d="M61.9,63.1l-14.2,1.8V51.5h14.2V63.1z M61.9,48.6H47.7V34.5l14.2,2.2V48.6z"/>
            </g>
</svg>
    </div>

    {{-- ── Header: Invoice title + number / Client info right ── --}}
    <div class="inv-header">

        <div class="inv-header-left">
            <h1>Invoice</h1>
            <div class="inv-number-row">
                Invoice #:
                <span class="inv-number-val">{{ $invoice->number }}</span>
            </div>
            <div class="inv-number-row" style="margin-top:4px;">
                Submitted:
                <span class="inv-number-val" style="color:#374151;">
                    {{ \Carbon\Carbon::parse($invoice->submitted_at)->format('d/m/Y') }}
                </span>
            </div>
            <div class="inv-number-row" style="margin-top:2px;">
                Due:
                <span class="inv-number-val" style="color:#374151;">{{ $invoice->due_date }}</span>
            </div>
        </div>

        <div class="inv-number-row" style="margin-top:6px; display: flex; align-items: center; gap: 8px;">
            Status:
            <span class="status-badge {{ $statusClasses[$invoice->status] ?? 's-draft' }}">
        {{ $invoice->status }}
    </span>
        </div>

        <div class="inv-header-right">
            <div class="meta-row" style="margin-bottom:8px;">
                <strong style="font-size:9px;font-weight:800;letter-spacing:.12em;text-transform:uppercase;color:#b5cc18;">
                    Invoice to
                </strong>
            </div>
            @if($invoice->project_name)
                <div class="meta-row" style="font-style:italic;color:#9ca3af;font-size:11px;">
                    {{ $invoice->project_name }}
                </div>
            @endif
            <div class="meta-row">
                <strong style="font-size:15px;font-weight:800;color:#1e293b;letter-spacing:-.01em;">
                    {{ $invoice->client->name ?? '—' }}
                </strong>
            </div>
            @if($invoice->client->company)
                <div class="meta-row">{{ $invoice->client->company }}</div>
            @endif
            @if($invoice->client->email)
                <div class="meta-row">{{ $invoice->client->email }}</div>
            @endif
            @if($invoice->client->phone)
                <div class="meta-row">{{ $invoice->client->phone }}</div>
            @endif
        </div>

    </div>

    {{-- ══════════════════════════════════════
         COMPLETED SERVICES
    ═══════════════════════════════════════ --}}
    @if($invoice->completedItems->count() > 0)
        <div class="completed-divider">
            <div class="completed-divider-line"></div>
            <span class="completed-badge">Completed Services</span>
            <div class="completed-divider-line"></div>
        </div>
        <table class="inv-table">
            <thead>
            <tr>
                <th style="width:48%">Description</th>
                <th class="center" style="width:8%">Qty</th>
                <th class="right" style="width:20%">Unit Price</th>
                <th class="right" style="width:24%">Total</th>
            </tr>
            </thead>
            <tbody>
            @foreach($invoice->completedItems as $item)
                <tr>
                    <td class="desc">{{ $item->description }}</td>
                    <td class="center">{{ $item->qty }}</td>
                    <td class="unit-price">{{ $fmt($item->unit_price) }}</td>
                    <td class="total">{{ $fmt($item->total()) }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>

        {{-- Completed totals --}}
        <div class="summary-wrap">
            <div class="totals-block">
                <div class="totals-row">
                    <span>Subtotal</span>
                    <span class="mono">{{ $fmt($completedSub) }}</span>
                </div>

                @if($invoice->completed_discount > 0)
                    <div class="totals-row deduction">
                        <span>{{ $invoice->completed_discount_label ?: 'Discount' }}</span>
                        <span class="mono">-{{ $fmt($invoice->completed_discount) }}</span>
                    </div>
                @endif

                @if($invoice->tax_enabled && in_array($invoice->tax_applies_to, ['completed','both']))
                    <div class="totals-row">
                        <span>{{ $invoice->tax_label }} ({{ $invoice->tax_rate }}%)</span>
                        <span class="mono">{{ $fmt($completedTax) }}</span>
                    </div>
                @endif

                @if($invoice->paid_amount > 0)
                    <div class="totals-row paid-row">
                        <span>Paid</span>
                        <span class="mono">-{{ $fmt($invoice->paid_amount) }}</span>
                    </div>
                @endif

                @if($invoice->wht_enabled)
                    <div class="totals-row deduction">
                        <span>{{ $invoice->wht_label }}</span>
                        <span class="mono">-{{ $fmt($completedWht) }}</span>
                    </div>
                @endif

                <div class="totals-row outstanding-row">
                    <span>Outstanding</span>
                    <span class="mono">{{ $fmt(max(0, $outstanding)) }}</span>
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
    @endif

    {{-- ══════════════════════════════════════
         SUBSCRIPTION SERVICES (Added)
    ═══════════════════════════════════════ --}}
    @if($invoice->has_subscription && $invoice->subscriptionItems->count())
        <div class="subscription-divider">
            <div class="subscription-divider-line"></div>
            <span class="subscription-badge">Subscription Services</span>
            <div class="subscription-divider-line"></div>
        </div>

        <table class="inv-table">
            <thead>
            <tr>
                <th style="width:48%">Description</th>
                <th class="center" style="width:15%">Cycle</th>
                <th class="right" style="width:15%">Unit Price</th>
                <th class="right" style="width:22%">Total</th>
            </tr>
            </thead>
            <tbody>
            @foreach($invoice->subscriptionItems as $item)
                <tr>
                    <td class="desc">
                        {{ $item->description }}
                        @if($item->renewal_date)
                            <div style="font-size: 9px; color: #9ca3af; font-weight: 400; margin-top: 2px;">
                                Renews: {{ $item->renewal_date->format('d M, Y') }}
                            </div>
                        @endif
                    </td>
                    <td class="center">
                        <span class="cycle-badge">{{ str_replace('_', ' ', $item->billing_cycle) }}</span>
                    </td>
                    <td class="unit-price">{{ $fmt($item->unit_price) }}</td>
                    <td class="total">{{ $fmt($item->total()) }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>

        <div class="summary-wrap">
            <div class="totals-block">
                <div class="totals-row">
                    <span>Subtotal</span>
                    <span class="mono">{{ $fmt($subSub) }}</span>
                </div>
                @if($invoice->subscription_discount > 0)
                    <div class="totals-row deduction">
                        <span>{{ $invoice->subscription_discount_label ?: 'Discount' }}</span>
                        <span class="mono">-{{ $fmt($invoice->subscription_discount) }}</span>
                    </div>
                @endif
                @if($invoice->tax_enabled && in_array($invoice->tax_applies_to, ['subscription','all']))
                    <div class="totals-row">
                        <span>{{ $invoice->tax_label }} ({{ $invoice->tax_rate }}%)</span>
                        <span class="mono">{{ $fmt($subTax) }}</span>
                    </div>
                @endif
                <div class="totals-row total-row" style="border-top-style: solid; border-top-width: 1px;">
                    <span>Recurring Total</span>
                    <span class="mono">{{ $fmt($subTotal) }}</span>
                </div>
            </div>
        </div>

        @if($invoice->subscription_notes)
            <div class="notes-wrap">
                <div class="notes-label">Subscription Notes:</div>
                <div class="notes-body">{{ $invoice->subscription_notes }}</div>
            </div>
        @endif
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
                <th style="width:48%">Description</th>
                <th class="center" style="width:8%">Qty</th>
                <th class="right" style="width:20%">Unit Price</th>
                <th class="right" style="width:24%">Total</th>
            </tr>
            </thead>
            <tbody>
            @foreach($invoice->proposedItems as $item)
                <tr>
                    <td class="desc">{{ $item->description }}</td>
                    <td class="center">{{ $item->qty }}</td>
                    <td class="unit-price">{{ $fmt($item->unit_price) }}</td>
                    <td class="total">{{ $fmt($item->total()) }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>

        {{-- Proposed totals --}}
        <div class="summary-wrap">
            <div class="totals-block">
                <div class="totals-row">
                    <span>Subtotal</span>
                    <span class="mono">{{ $fmt($proposedSub) }}</span>
                </div>

                @if($invoice->proposed_discount > 0)
                    <div class="totals-row deduction">
                        <span>{{ $invoice->proposed_discount_label ?: 'Discount' }}</span>
                        <span class="mono">-{{ $fmt($invoice->proposed_discount) }}</span>
                    </div>
                @endif

                @if($invoice->tax_enabled && in_array($invoice->tax_applies_to, ['proposed','both']))
                    <div class="totals-row">
                        <span>{{ $invoice->tax_label }} ({{ $invoice->tax_rate }}%)</span>
                        <span class="mono">{{ $fmt($proposedTax) }}</span>
                    </div>
                @endif

                <div class="totals-row total-row">
                    <span>Total</span>
                    <span class="mono">{{ $fmt($proposedTotal) }}</span>
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

    {{-- ── Payment details box (bottom, target style) ── --}}
    @if($invoice->bank_name || $invoice->bank_account_name || $invoice->bank_account_number)
        <div class="payment-info">
            <div class="payment-info-label">Payment Details</div>
            <div class="payment-info-grid">
                @if($invoice->bank_name)
                    <span class="pi-key">Bank</span>
                    <span class="pi-val">{{ $invoice->bank_name }}</span>
                @endif
                @if($invoice->bank_account_name)
                    <span class="pi-key">Account Name</span>
                    <span class="pi-val">{{ $invoice->bank_account_name }}</span>
                @endif
                @if($invoice->bank_account_number)
                    <span class="pi-key">Account Number</span>
                    <span class="pi-val mono-accent">{{ $invoice->bank_account_number }}</span>
                @endif
            </div>
        </div>
    @endif

    {{-- ── Footer ── --}}
    <div class="inv-footer">
        <span class="inv-footer-brand">The Pacmedia &nbsp;·&nbsp; Pacmedia Creatives</span>
        <span class="inv-footer-num">{{ $invoice->number }}</span>
    </div>

</div>
</body>
</html>
