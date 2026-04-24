<x-admin-layout title="Invoice {{ $invoice->number }}">

    @push('page-css')
        <link rel="stylesheet" href="{{ asset('admin/assets/css/pages/app-invoice.css') }}">
        <style>
            .pac-inv-table { width: 100%; border-collapse: collapse; }
            .pac-inv-table thead tr { border-bottom: 1px solid var(--bs-border-color); }
            .pac-inv-table thead th {
                font-size: 0.7rem; font-weight: 700;
                text-transform: uppercase; letter-spacing: 0.07em;
                color: #9ca3af; padding: 0.5rem 0.5rem 0.5rem 0;
                background: transparent;
            }
            .pac-inv-table thead th:last-child,
            .pac-inv-table thead th.col-up { text-align: right; }
            .pac-inv-table thead th.col-qty { text-align: center; }
            .pac-inv-table tbody tr { border-bottom: 1px solid #f3f4f6; }
            .pac-inv-table tbody tr:last-child { border-bottom: none; }
            .pac-inv-table tbody td {
                padding: 0.75rem 0.5rem 0.75rem 0;
                font-size: 0.83rem; color: #374151; vertical-align: middle;
            }
            .pac-inv-table tbody td.col-qty { text-align: center; color: #6b7280; }
            .pac-inv-table tbody td.col-up  { text-align: right; color: #6b7280; }
            .pac-inv-table tbody td.col-total { text-align: right; font-weight: 700; color: #111827; }
            .pac-inv-table tbody td.col-desc { font-weight: 500; }

            /* Summary block */
            .pac-inv-summary { min-width: 180px; }
            .pac-inv-summary p { font-size: 0.83rem; color: #374151; }
            .pac-inv-summary .fw-medium { color: #111827; }

            /* Notes */
            .pac-notes-wrap {
                border-left: 3px solid #b5cc18;
                border-radius: 0 0.375rem 0.375rem 0;
                padding: 0.625rem 1rem;
                background: rgba(181,204,24,0.04);
                font-size: 0.82rem; color: #6b7280; line-height: 1.6;
            }


            /* completed divider */
            .pac-completed-divider {
                display: flex; align-items: center; gap: 0.75rem; margin: 1.5rem 0 1rem;
            }
            .pac-completed-divider hr { flex: 1; margin: 0; }
            .pac-completed-badge {
                font-size: 0.68rem; font-weight: 700; letter-spacing: 0.07em;
                text-transform: uppercase; color: #96aa12;
                background: rgba(234,88,12,0.1);
                border-color: rgba(234,88,12,0.25);
                border-radius: 100px; padding: 3px 10px; white-space: nowrap;
            }

            /* Proposed divider */
            .pac-proposed-divider {
                display: flex; align-items: center; gap: 0.75rem; margin: 1.5rem 0 1rem;
            }
            .pac-proposed-divider hr { flex: 1; margin: 0; }
            .pac-proposed-badge {
                font-size: 0.68rem; font-weight: 700; letter-spacing: 0.07em;
                text-transform: uppercase; color: #96aa12;
                background: rgba(181,204,24,0.1);
                border: 1px solid rgba(181,204,24,0.25);
                border-radius: 100px; padding: 3px 10px; white-space: nowrap;
            }

            /* Status badge */
            .pac-status-badge {
                font-size: 0.72rem; font-weight: 700;
                padding: 4px 12px; border-radius: 100px;
                letter-spacing: 0.04em; display: inline-block;
            }
            .s-draft   { background: #f1f5f9; color: #64748b; }
            .s-sent    { background: rgba(59,130,246,0.1);  color: #1d4ed8; }
            .s-partial { background: rgba(245,158,11,0.1);  color: #b45309; }
            .s-paid    { background: rgba(34,197,94,0.1);   color: #15803d; }
            .s-overdue { background: rgba(239,68,68,0.1);   color: #b91c1c; }

            /* Actions sidebar */
            .invoice-actions .pac-actions-card { position: sticky; top: 80px; }

            /* Record payment offcanvas input */
            .pac-payment-form input:focus { border-color: #b5cc18; box-shadow: 0 0 0 0.2rem rgba(181,204,24,0.15); }

            [data-bs-theme="dark"] .pac-inv-table tbody td.col-total { color: #f9fafb; }
            [data-bs-theme="dark"] .pac-notes-wrap { background: rgba(181,204,24,0.06); }

            @media print {
                .invoice-actions, .toast-container { display: none !important; }
                .card { box-shadow: none !important; border: none !important; }
            }

            /* Add this new style for Subscriptions */
            .pac-subscription-divider {
                display: flex; align-items: center; gap: 0.75rem; margin: 2rem 0 1rem;
            }
            .pac-subscription-divider hr { flex: 1; margin: 0; border-color: rgba(59, 130, 246, 0.2); }
            .pac-subscription-badge {
                font-size: 0.68rem; font-weight: 700; letter-spacing: 0.07em;
                text-transform: uppercase; color: #1d4ed8;
                background: rgba(59, 130, 246, 0.1);
                border: 1px solid rgba(59, 130, 246, 0.25);
                border-radius: 100px; padding: 3px 10px; white-space: nowrap;
            }
        </style>
    @endpush

    @php
        $statusClasses = [
            'draft'   => 's-draft',
            'sent'    => 's-sent',
            'partial' => 's-partial',
            'paid'    => 's-paid',
            'overdue' => 's-overdue',
        ];

        // Tactical Fix: Use the dynamic currency from the model helper
        $symbol = $invoice->currencySymbol();
        $fmt = fn($n) => $symbol . ' ' . number_format((float) $n, 2);

        $outstanding   = $invoice->completedOutstanding();
        $completedSub  = $invoice->completedSubtotal();
        $completedTax  = $invoice->completedTax();
        $completedWht  = $invoice->completedWht();
        $proposedSub   = $invoice->proposedSubtotal();
        $proposedTax   = $invoice->proposedTax();
        $proposedTotal = $invoice->proposedTotal();
//        $fmt = fn($n) => '₦' . number_format((float) $n, 2);

    // NEW: Subscription Calculations
        $subSub        = $invoice->subscriptionSubtotal();
        $subTax        = $invoice->subscriptionTax();
        $subTotal      = $invoice->subscriptionOutstanding();
    @endphp

    <div class="row invoice-preview">

        {{-- ══════════════════════════════════════════════
             INVOICE DOCUMENT (col 9)
        ═══════════════════════════════════════════════ --}}
        <div class="col-xl-9 col-md-8 col-12 mb-md-0 mb-6">
            <div class="card invoice-preview-card p-sm-12 p-6">

                {{-- ── Header ── --}}
                <div class="card-body invoice-preview-header rounded-4 p-6">
                    <div class="d-flex justify-content-between flex-xl-row flex-md-column flex-sm-row flex-column text-heading align-items-xl-center align-items-md-start align-items-sm-center flex-wrap gap-6">

                        {{-- Studio identity --}}
                        <div>
                            <div class="d-flex svg-illustration align-items-center gap-2 mb-6">
                                <svg width="32" height="32" viewBox="0 0 101.5 101.5"
                                     fill="#b5cc18" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M0,0V92.7H92.7V0ZM44.13,85.55,25.84,68.33V48.91H44.13Zm0-40.42H25.84V24l18.29-4.59ZM66.44,63.74,48.15,66V48.91H66.44Zm0-18.61H48.15V26.91l18.29,2.87Z"/>
                                </svg>
{{--                                <span class="mb-0 app-brand-text fw-semibold">The Pacmedia</span>--}}
                            </div>
                            <p class="mb-1">Pacmedia Creatives</p>
                            <p class="mb-0">Lagos, Nigeria</p>
                        </div>

                        {{-- Invoice # + dates --}}
                        <div>
                            <h5 class="mb-6 text-nowrap">
                                Invoice
                                <span style="color:#b5cc18;">{{ $invoice->number }}</span>
                                <span class="ms-2 pac-status-badge {{ $statusClasses[$invoice->status] ?? 's-draft' }}">
                                    {{ ucfirst($invoice->status) }}
                                </span>
                            </h5>
                            <div class="mb-1">
                                <span class="me-1">Submitted on:</span>
                                <span class="fw-medium">
                                    {{ \Carbon\Carbon::parse($invoice->submitted_at)->format('d/m/Y') }}
                                </span>
                            </div>
                            <div>
                                <span class="me-1">Due Date:</span>
                                <span class="fw-medium">{{ $invoice->due_date }}</span>
                            </div>
                        </div>

                    </div>
                </div>
                {{-- / header --}}

                {{-- ── Invoice For / Payable To ── --}}
                <div class="card-body py-6 px-0">
                    <div class="d-flex justify-content-between flex-wrap gap-6">

                        <div>
                            <h6>Invoice For:</h6>
                            @if($invoice->project_name)
                                <p class="mb-1 text-muted" style="font-size:0.8rem;">{{ $invoice->project_name }}</p>
                            @endif
                            <p class="mb-1 fw-medium">{{ $invoice->client->name ?? '—' }}</p>
                            @if($invoice->client->company)
                                <p class="mb-1">{{ $invoice->client->company }}</p>
                            @endif
                            @if($invoice->client->address)
                                <p class="mb-1">{{ $invoice->client->address }}</p>
                            @endif
                            @if($invoice->client->phone)
                                <p class="mb-1">{{ $invoice->client->phone }}</p>
                            @endif
                            @if($invoice->client->email)
                                <p class="mb-0">{{ $invoice->client->email }}</p>
                            @endif
                        </div>

                        <div>
                            <h6>Payable To:</h6>
                            <table>
                                <tbody>
                                <tr>
                                    <td class="pe-4 text-muted" style="font-size:0.83rem;">Outstanding:</td>
                                    <td class="fw-bold" style="color: {{ $invoice->status === 'paid' ? '#15803d' : '#111827' }};">
                                        {{ $fmt(max(0, $outstanding)) }}
                                    </td>
                                </tr>
                                @if($invoice->bank_name)
                                    <tr>
                                        <td class="pe-4 text-muted" style="font-size:0.83rem;">Bank Name:</td>
                                        <td>{{ $invoice->bank_name }}</td>
                                    </tr>
                                @endif
                                @if($invoice->bank_account_name)
                                    <tr>
                                        <td class="pe-4 text-muted" style="font-size:0.83rem;">Account Name:</td>
                                        <td>{{ $invoice->bank_account_name }}</td>
                                    </tr>
                                @endif
                                @if($invoice->bank_account_number)
                                    <tr>
                                        <td class="pe-4 text-muted" style="font-size:0.83rem;">Account Number:</td>
                                        <td class="fw-bold" style="letter-spacing:0.04em;">
                                            {{ $invoice->bank_account_number }}
                                        </td>
                                    </tr>
                                @endif
                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>
                {{-- / invoice for --}}

                {{-- ══════════════════════════════════════
                     COMPLETED SERVICES TABLE
                ═══════════════════════════════════════ --}}
                <div class="pac-subscription-divider px-6">
                    <hr>
                    <span class="pac-completed-badge">Completed Services</span>
                    <hr>
                </div>
                <div class="table-responsive border rounded-4 border-bottom-0">
                    <table class="table m-0">
                        <thead>
                        <tr>
                            <th>Description</th>
                            <th class="text-center">Qty</th>
                            <th class="text-end">Unit Price</th>
                            <th class="text-end">Total Price</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($invoice->completedItems as $item)
                            <tr @if($loop->last) class="border-bottom" @endif>
                                <td class="text-heading fw-medium">{{ $item->description }}</td>
                                <td class="text-center text-muted">{{ $item->qty }}</td>
                                <td class="text-end text-muted">{{ $fmt($item->unit_price) }}</td>
                                <td class="text-end fw-semibold">{{ $fmt($item->total()) }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>

                {{-- ── Completed summary ── --}}
                <div class="table-responsive">
                    <table class="table m-0 table-borderless">
                        <tbody>
                        <tr>
                            {{-- Notes left --}}
                            <td class="align-top px-0 py-6">
                                @if($invoice->completed_notes)
                                    <p class="mb-1">
                                        <span class="fw-medium text-heading me-1">Notes:</span>
                                    </p>
                                    <div class="pac-notes-wrap">{{ $invoice->completed_notes }}</div>
                                @endif
                            </td>

                            {{-- Summary labels --}}
                            <td class="pe-0 py-6 w-px-150 text-nowrap">
                                <p class="mb-1">Subtotal:</p>
                                @if($invoice->completed_discount > 0)
                                    <p class="mb-1">{{ $invoice->completed_discount_label ?: 'Discount' }}:</p>
                                @endif
                                @if($invoice->tax_enabled && in_array($invoice->tax_applies_to, ['completed','both']))
                                    <p class="mb-1">{{ $invoice->tax_label }} ({{ $invoice->tax_rate }}%):</p>
                                @endif
                                @if($invoice->paid_amount > 0)
                                    <p class="mb-1 text-success">Paid:</p>
                                @endif
                                @if($invoice->wht_enabled)
                                    <p class="mb-1 text-danger">{{ $invoice->wht_label }}:</p>
                                @endif
                                <p class="mb-0 pt-2 fw-bold border-top" style="color:{{ $invoice->status === 'overdue' ? '#b91c1c' : '#111827' }};">
                                    Outstanding:
                                </p>
                            </td>

                            {{-- Summary values --}}
                            <td class="text-end px-0 py-6 w-px-100 text-nowrap">
                                <p class="fw-medium mb-1">{{ $fmt($completedSub) }}</p>
                                @if($invoice->completed_discount > 0)
                                    <p class="fw-medium mb-1 text-danger">-{{ $fmt($invoice->completed_discount) }}</p>
                                @endif
                                @if($invoice->tax_enabled && in_array($invoice->tax_applies_to, ['completed','both']))
                                    <p class="fw-medium mb-1">{{ $fmt($completedTax) }}</p>
                                @endif
                                @if($invoice->paid_amount > 0)
                                    <p class="fw-medium mb-1 text-success">-{{ $fmt($invoice->paid_amount) }}</p>
                                @endif
                                @if($invoice->wht_enabled)
                                    <p class="fw-medium mb-1 text-danger">-{{ $fmt($completedWht) }}</p>
                                @endif
                                <p class="fw-bold mb-0 pt-2 border-top" style="color:{{ $invoice->status === 'overdue' ? '#b91c1c' : '#111827' }};">
                                    {{ $fmt(max(0, $outstanding)) }}
                                </p>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
                {{-- / completed summary --}}

                {{-- ══════════════════════════════════════
                     SUBSCRIPTION SERVICES
                ═══════════════════════════════════════ --}}
                @if($invoice->has_subscription && $invoice->subscriptionItems->count())
                    <div class="pac-subscription-divider px-6">
                        <hr>
                        <span class="pac-subscription-badge">Subscription Services</span>
                        <hr>
                    </div>

                    <div class="table-responsive border rounded-4 border-bottom-0">
                        <table class="table m-0">
                            <thead>
                            <tr>
                                <th>Description</th>
                                <th class="text-center">Billing Cycle</th>
                                <th class="text-end">Unit Price</th>
                                <th class="text-end">Total Price</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($invoice->subscriptionItems as $item)
                                <tr @if($loop->last) class="border-bottom" @endif>
                                    <td>
                                        <div class="text-heading fw-medium">{{ $item->description }}</div>
                                        @if($item->renewal_date)
                                            <small class="text-muted">Renews: {{ $item->renewal_date->format('d M, Y') }}</small>
                                        @endif
                                    </td>
                                    <td class="text-center text-muted">
                                        <span class="badge bg-label-info text-capitalize">{{ str_replace('_', ' ', $item->billing_cycle) }}</span>
                                    </td>
                                    <td class="text-end text-muted">{{ $fmt($item->unit_price) }}</td>
                                    <td class="text-end fw-semibold">{{ $fmt($item->total()) }}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>

                    {{-- Subscription summary --}}
                    <div class="table-responsive">
                        <table class="table m-0 table-borderless">
                            <tbody>
                            <tr>
                                <td class="align-top px-0 py-6">
                                    @if($invoice->subscription_notes)
                                        <p class="mb-1"><span class="fw-medium text-heading me-1">Subscription Notes:</span></p>
                                        <div class="pac-notes-wrap">{{ $invoice->subscription_notes }}</div>
                                    @endif
                                </td>
                                <td class="pe-0 py-6 w-px-150 text-nowrap">
                                    <p class="mb-1">Subtotal:</p>
                                    @if($invoice->subscription_discount > 0)
                                        <p class="mb-1">{{ $invoice->subscription_discount_label ?: 'Discount' }}:</p>
                                    @endif
                                    @if($invoice->tax_enabled && in_array($invoice->tax_applies_to, ['subscription','all']))
                                        <p class="mb-1">{{ $invoice->tax_label }} ({{ $invoice->tax_rate }}%):</p>
                                    @endif
                                    <p class="mb-0 pt-2 fw-bold border-top">Recurring Total:</p>
                                </td>
                                <td class="text-end px-0 py-6 w-px-100 text-nowrap">
                                    <p class="fw-medium mb-1">{{ $fmt($subSub) }}</p>
                                    @if($invoice->subscription_discount > 0)
                                        <p class="fw-medium mb-1 text-danger">-{{ $fmt($invoice->subscription_discount) }}</p>
                                    @endif
                                    @if($invoice->tax_enabled && in_array($invoice->tax_applies_to, ['subscription','all']))
                                        <p class="fw-medium mb-1">{{ $fmt($subTax) }}</p>
                                    @endif
                                    <p class="fw-bold mb-0 pt-2 border-top">{{ $fmt($subTotal) }}</p>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                @endif

                {{-- ══════════════════════════════════════
                     PROPOSED SERVICES (conditional)
                ═══════════════════════════════════════ --}}
                @if($invoice->has_proposed && $invoice->proposedItems->count())

                    <div class="pac-proposed-divider px-6">
                        <hr>
                        <span class="pac-proposed-badge">Proposed Services</span>
                        <hr>
                    </div>

                    <div class="table-responsive border rounded-4 border-bottom-0">
                        <table class="table m-0">
                            <thead>
                            <tr>
                                <th>Description</th>
                                <th class="text-center">Qty</th>
                                <th class="text-end">Unit Price</th>
                                <th class="text-end">Total Price</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($invoice->proposedItems as $item)
                                <tr @if($loop->last) class="border-bottom" @endif>
                                    <td class="text-heading fw-medium">{{ $item->description }}</td>
                                    <td class="text-center text-muted">{{ $item->qty }}</td>
                                    <td class="text-end text-muted">{{ $fmt($item->unit_price) }}</td>
                                    <td class="text-end fw-semibold">{{ $fmt($item->total()) }}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>

                    {{-- Proposed summary --}}
                    <div class="table-responsive">
                        <table class="table m-0 table-borderless">
                            <tbody>
                            <tr>
                                <td class="align-top px-0 py-6">
                                    @if($invoice->proposed_notes)
                                        <p class="mb-1">
                                            <span class="fw-medium text-heading me-1">Proposed Notes:</span>
                                        </p>
                                        <div class="pac-notes-wrap">{{ $invoice->proposed_notes }}</div>
                                    @endif
                                </td>
                                <td class="pe-0 py-6 w-px-150 text-nowrap">
                                    <p class="mb-1">Subtotal:</p>
                                    @if($invoice->proposed_discount > 0)
                                        <p class="mb-1">{{ $invoice->proposed_discount_label ?: 'Discount' }}:</p>
                                    @endif
                                    @if($invoice->tax_enabled && in_array($invoice->tax_applies_to, ['proposed','both']))
                                        <p class="mb-1">{{ $invoice->tax_label }} ({{ $invoice->tax_rate }}%):</p>
                                    @endif
                                    <p class="mb-0 pt-2 fw-bold border-top">Total:</p>
                                </td>
                                <td class="text-end px-0 py-6 w-px-100 text-nowrap">
                                    <p class="fw-medium mb-1">{{ $fmt($proposedSub) }}</p>
                                    @if($invoice->proposed_discount > 0)
                                        <p class="fw-medium mb-1 text-danger">-{{ $fmt($invoice->proposed_discount) }}</p>
                                    @endif
                                    @if($invoice->tax_enabled && in_array($invoice->tax_applies_to, ['proposed','both']))
                                        <p class="fw-medium mb-1">{{ $fmt($proposedTax) }}</p>
                                    @endif
                                    <p class="fw-bold mb-0 pt-2 border-top">{{ $fmt($proposedTotal) }}</p>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>

                @endif
                {{-- / proposed --}}

            </div>
            {{-- / invoice-preview-card --}}
        </div>
        {{-- / col 9 --}}

        {{-- ══════════════════════════════════════════════
             ACTIONS SIDEBAR (col 3)
        ═══════════════════════════════════════════════ --}}
        <div class="col-xl-3 col-md-4 col-12 invoice-actions">
            <div class="pac-actions-card">
                <div class="card">
                    <div class="card-body">

                        {{-- Send Invoice --}}
                        <button class="btn btn-primary d-grid w-100 mb-4"
                                data-bs-toggle="offcanvas"
                                data-bs-target="#sendInvoiceOffcanvas">
                            <span class="d-flex align-items-center justify-content-center text-nowrap">
                                <i class="icon-base ri ri-send-plane-line icon-16px scaleX-n1-rtl me-2"></i>
                                Send Invoice
                            </span>
                        </button>


                        {{-- Print + Edit --}}
                        <div class="d-flex mb-4 gap-4">
                            <a href="{{ route('admin.invoices.pdf', $invoice) }}"
                               target="_blank"
                               class="btn btn-outline-secondary d-grid w-100">
                                <span class="d-flex align-items-center justify-content-center gap-2">
                                    <i class="ri ri-file-pdf-line icon-16px"></i>
                                    Print
                                </span>
                            </a>
                            <a href="{{ route('admin.invoices.edit', $invoice) }}"
                               class="btn btn-outline-secondary d-grid w-100">
                                Edit
                            </a>
                        </div>

                        {{-- Add Payment --}}
                        @if($invoice->status !== 'paid')
                            <button class="btn btn-success d-grid w-100 mb-4"
                                    data-bs-toggle="offcanvas"
                                    data-bs-target="#addPaymentOffcanvas">
                                <span class="d-flex align-items-center justify-content-center text-nowrap">
                                    <i class="icon-base ri ri-money-dollar-circle-line icon-16px me-2"></i>
                                    Add Payment
                                </span>
                            </button>
                        @else
                            <div class="text-center py-2 mb-4">
                                <i class="ri ri-checkbox-circle-line"
                                   style="font-size:1.4rem; color:#15803d; display:block; margin-bottom:0.3rem;"></i>
                                <p style="font-size:0.82rem; font-weight:700; color:#15803d; margin:0;">Paid in Full</p>
                                <p style="font-size:0.72rem; color:#9ca3af; margin:0;">
                                    {{ $fmt($invoice->paid_amount) }} received
                                </p>
                            </div>
                        @endif

                        {{-- Duplicate --}}
                        <form method="POST"
                              action="{{ route('admin.invoices.duplicate', $invoice) }}"
                              class="mb-3">
                            @csrf
                            <button type="submit"
                                    class="btn btn-outline-secondary d-grid w-100">
                                <span class="d-flex align-items-center justify-content-center gap-2">
                                    <i class="ri ri-file-copy-line"></i> Duplicate
                                </span>
                            </button>
                        </form>

                        {{-- Delete --}}
                        <form method="POST"
                              action="{{ route('admin.invoices.destroy', $invoice) }}"
                              onsubmit="return confirm('Delete invoice {{ $invoice->number }}? This cannot be undone.')">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                    class="btn btn-outline-danger d-grid w-100">
                                <span class="d-flex align-items-center justify-content-center gap-2">
                                    <i class="ri ri-delete-bin-7-line"></i> Delete
                                </span>
                            </button>
                        </form>

                    </div>
                </div>
            </div>
        </div>
        {{-- / sidebar --}}

    </div>
    {{-- / row --}}

    {{-- ══════════════════════════════════════════════
         SEND INVOICE OFFCANVAS
    ═══════════════════════════════════════════════ --}}
    <div class="offcanvas offcanvas-end" id="sendInvoiceOffcanvas" aria-hidden="true">
        <div class="offcanvas-header border-bottom">
            <h5 class="offcanvas-title">Send Invoice</h5>
            <button type="button" class="btn-close text-reset"
                    data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body flex-grow-1">
            <form method="POST" action="{{ route('admin.invoices.send', $invoice) }}">
                @csrf
                <div class="form-floating form-floating-outline mb-5">
                    <input type="email" class="form-control" id="invoice-from"
                           value="hello@thepacmedia.com" placeholder="company@email.com">
                    <label for="invoice-from">From</label>
                </div>
                <div class="form-floating form-floating-outline mb-5">
                    <input type="email" class="form-control" id="invoice-to"
                           value="{{ $invoice->client->email ?? '' }}"
                           placeholder="client@email.com">
                    <label for="invoice-to">To</label>
                </div>
                <div class="form-floating form-floating-outline mb-5">
                    <input type="text" class="form-control" id="invoice-subject"
                           value="Invoice {{ $invoice->number }} — The Pacmedia"
                           placeholder="Invoice subject">
                    <label for="invoice-subject">Subject</label>
                </div>
                <div class="form-floating form-floating-outline mb-5">
                    <textarea class="form-control" id="invoice-message"
                              style="height: 160px;">Dear {{ $invoice->client->name ?? 'Client' }},

Thank you for your business. Please find attached Invoice {{ $invoice->number }} for {{ $invoice->project_name ?: 'our services' }}.

Outstanding balance: {{ $fmt(max(0, $outstanding)) }}
Due: {{ $invoice->due_date }}

Kindly process payment at your earliest convenience.

Warm regards,
The Pacmedia</textarea>
                    <label for="invoice-message">Message</label>
                </div>
                <div class="mb-5">
                    <span class="badge bg-label-primary rounded-pill">
                        <i class="icon-base ri ri-links-line icon-14px me-1"></i>
                        <span class="align-middle">Invoice Attached</span>
                    </span>
                </div>
                <div class="mb-4 d-flex flex-wrap gap-3">
                    <button type="submit" class="btn btn-primary">Send</button>
                    <button type="button" class="btn btn-outline-secondary"
                            data-bs-dismiss="offcanvas">Cancel</button>
                </div>
            </form>
        </div>
    </div>

    {{-- ══════════════════════════════════════════════
         ADD PAYMENT OFFCANVAS
    ═══════════════════════════════════════════════ --}}
    @if($invoice->status !== 'paid')
        <div class="offcanvas offcanvas-end" id="addPaymentOffcanvas" aria-hidden="true">
            <div class="offcanvas-header border-bottom">
                <h5 class="offcanvas-title">Add Payment</h5>
                <button type="button" class="btn-close text-reset"
                        data-bs-dismiss="offcanvas" aria-label="Close"></button>
            </div>
            <div class="offcanvas-body flex-grow-1">

                <div class="d-flex justify-content-between bg-lighter p-2 mb-5 rounded">
                    <p class="mb-0">Invoice Balance:</p>
                    <p class="fw-medium mb-0">{{ $fmt(max(0, $outstanding)) }}</p>
                </div>

                <form method="POST" action="{{ route('admin.invoices.payment', $invoice) }}">
                    @csrf

                    <div class="input-group input-group-merge mb-5">
                        <span class="input-group-text">₦</span>
                        <div class="form-floating form-floating-outline">
                            <input type="number"
                                   id="invoiceAmount"
                                   name="amount"
                                   class="form-control pac-payment-form"
                                   placeholder="0.00"
                                   step="0.01"
                                   min="0.01"
                                   value="{{ $outstanding > 0 ? number_format($outstanding, 2, '.', '') : '' }}"
                                   required>
                            <label for="invoiceAmount">Payment Amount</label>
                        </div>
                    </div>

                    <div class="form-floating form-floating-outline mb-5">
                        <select class="form-select" id="payment-method" name="payment_method">
                            <option value="" selected disabled>Select payment method</option>
                            <option value="Bank Transfer">Bank Transfer</option>
                            <option value="Cash">Cash</option>
                            <option value="Cheque">Cheque</option>
                            <option value="POS">POS</option>
                            <option value="Mobile Transfer">Mobile Transfer</option>
                        </select>
                        <label for="payment-method">Payment Method</label>
                    </div>

                    <div class="form-floating form-floating-outline mb-5">
                        <textarea class="form-control" id="payment-note"
                                  name="note" style="height: 62px"
                                  placeholder="Internal note"></textarea>
                        <label for="payment-note">Internal Payment Note</label>
                    </div>

                    <div class="d-flex flex-wrap gap-3">
                        <button type="submit" class="btn btn-success">Record Payment</button>
                        <button type="button" class="btn btn-outline-secondary"
                                data-bs-dismiss="offcanvas">Cancel</button>
                    </div>

                </form>
            </div>
        </div>
    @endif
    {{-- / add payment offcanvas --}}

    {{-- Flash success toast --}}
    @if(session('success'))
        <div class="toast-container position-fixed bottom-0 end-0 p-3" style="z-index:9999;">
            <div class="toast show align-items-center"
                 style="background:#fff; border-left:4px solid #b5cc18; border-radius:0.5rem; box-shadow:0 4px 20px rgba(0,0,0,0.1); min-width:280px;"
                 role="alert" aria-live="assertive">
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
                document.querySelectorAll('.toast.show').forEach(function (t) {
                    setTimeout(function () {
                        bootstrap.Toast.getOrCreateInstance(t).hide();
                    }, 4000);
                });
            })();
        </script>
    @endpush

</x-admin-layout>
