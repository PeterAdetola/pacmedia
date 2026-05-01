<x-admin-layout title="Edit Invoice {{ $invoice->number }}">

    @push('page-css')
        <link rel="stylesheet" href="{{ asset('admin/assets/vendor/libs/flatpickr/flatpickr.css') }}">
        <link rel="stylesheet" href="{{ asset('admin/assets/css/pages/app-invoice.css') }}">
        <style>
            /* ── Repeater item rows ── */

            /* No padding-top — labels are INSIDE the card, not floating above as column headers */
            .invoice-edit .repeater-wrapper {
                position: relative;
                padding-top: 0 !important;
                margin-top: 0 !important;
            }

            /* Neutralise app-invoice.css which uses position:absolute + negative inset
               to lift .repeater-title above the card border as floating column headers.
               Our two-zone design puts labels inside the card — restore to static flow. */
            .invoice-edit .repeater-title {
                position: static !important;
                inset-block-start: auto !important;
                top: auto !important;
                font-size: 0.72rem !important;
                font-weight: 700;
                text-transform: uppercase;
                letter-spacing: 0.06em;
                color: #9ca3af;
                margin-bottom: 0.4rem;
                white-space: nowrap;
            }

            /* Remove the spacer the template creates for the first item */
            #completed-items-container    .repeater-wrapper:first-child,
            #subscription-items-container .repeater-wrapper:first-child,
            #proposed-items-container     .repeater-wrapper:first-child {
                margin-top: 0 !important;
                padding-top: 0 !important;
            }

            /* ── Item card zone separator ── */
            .item-zone-bottom {
                border-top: 1px dashed #e5e7eb;
                background: #f9fafb;
            }
            [data-bs-theme="dark"] .item-zone-bottom {
                border-color: rgba(255,255,255,0.08);
                background: rgba(255,255,255,0.02);
            }

            /* ── Item total display ── */
            .item-total-display {
                font-size: 1.05rem;
                font-weight: 800;
                color: #1e293b;
                white-space: nowrap;
                letter-spacing: -0.02em;
                line-height: 1.2;
            }
            [data-bs-theme="dark"] .item-total-display { color: #f1f5f9; }

            /* ── Remove icon button ── */
            .remove-item-btn {
                width: 28px;
                height: 28px;
                border-radius: 6px;
                display: flex;
                align-items: center;
                justify-content: center;
                cursor: pointer;
                color: #9ca3af;
                transition: background 0.15s, color 0.15s;
                flex-shrink: 0;
            }
            .remove-item-btn:hover {
                background: rgba(239,68,68,0.08);
                color: #ef4444;
            }

            /* ── Subscription item blue border ── */
            .subs-item-card {
                border-color: rgba(59,130,246,0.25) !important;
            }
            .subs-item-zone-bottom {
                border-top: 1px dashed rgba(59,130,246,0.2);
                background: rgba(59,130,246,0.02);
            }

            /* ── Shared section-toggle style ── */
            .pac-section-toggle {
                display: flex;
                align-items: center;
                gap: 0.75rem;
                padding: 1rem 1.5rem;
                border: 1px dashed;
                border-radius: 0.625rem;
                cursor: pointer;
                transition: all 0.15s;
                margin-top: 1.5rem;
            }
            .pac-section-toggle-label { font-size: 0.83rem; font-weight: 600; }
            .pac-section-toggle-sub   { font-size: 0.72rem; color: #9ca3af; }

            /* ── Completed toggle ── */
            .pac-completed-toggle { background: rgba(234,88,12,0.04); border-color: rgba(234,88,12,0.3); margin-top: 0; }
            .pac-completed-toggle:hover { background: rgba(234,88,12,0.08); }
            .pac-completed-toggle .pac-section-toggle-label { color: #c2410c; }
            .pac-completed-icon { width:34px; height:34px; border-radius:8px; background: rgba(234,88,12,0.12); display:flex; align-items:center; justify-content:center; }
            .pac-completed-icon i { color:#c2410c; font-size:1.1rem; }

            /* ── Subscription toggle ── */
            .pac-subscription-toggle { background: rgba(59,130,246,0.04); border-color: rgba(59,130,246,0.3); }
            .pac-subscription-toggle:hover { background: rgba(59,130,246,0.08); }
            .pac-subscription-toggle .pac-section-toggle-label { color: #1d4ed8; }
            .pac-subscription-icon { width:34px; height:34px; border-radius:8px; background: rgba(59,130,246,0.12); display:flex; align-items:center; justify-content:center; }
            .pac-subscription-icon i { color:#1d4ed8; font-size:1.1rem; }

            /* ── Proposed toggle ── */
            .pac-proposed-toggle { background: rgba(181,204,24,0.04); border-color: rgba(181,204,24,0.3); }
            .pac-proposed-toggle:hover { background: rgba(181,204,24,0.08); }
            .pac-proposed-toggle .pac-section-toggle-label { color: #96aa12; }
            .pac-proposed-icon { width:34px; height:34px; border-radius:8px; background: rgba(181,204,24,0.12); display:flex; align-items:center; justify-content:center; }
            .pac-proposed-icon i { color:#96aa12; font-size:1.1rem; }

            /* ── Section dividers ── */
            .pac-section-divider { display: flex; align-items: center; gap: 0.75rem; margin: 1.5rem 0 1rem; }
            .pac-section-divider hr { flex: 1; margin: 0; }
            .pac-section-badge { font-size: 0.68rem; font-weight: 700; letter-spacing: 0.07em; text-transform: uppercase; border-radius: 100px; padding: 3px 10px; white-space: nowrap; border: 1px solid; }
            .pac-completed-badge    { color: #c2410c; background: rgba(234,88,12,0.1);   border-color: rgba(234,88,12,0.25); }
            .pac-subscription-badge { color: #1d4ed8; background: rgba(59,130,246,0.1);  border-color: rgba(59,130,246,0.25); }
            .pac-proposed-badge     { color: #96aa12; background: rgba(181,204,24,0.1);   border-color: rgba(181,204,24,0.25); }

            /* ── Tax panel ── */
            .pac-tax-panel { background: var(--bs-gray-50); border: 1px solid var(--bs-border-color); border-radius: 0.5rem; padding: 1rem 1.25rem; }
            .pac-tax-grid  { display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 0.75rem; margin-top: 0.75rem; }

            /* ── Invoice calculations ── */
            .invoice-calculations { min-inline-size: 200px; }
            .invoice-calculations p { font-size: 0.83rem; color: #374151; margin-bottom: 0.4rem; }
            .invoice-calculations .fw-bold { color: #111827; font-size: 0.9rem; }

            /* ── Sticky actions ── */
            .invoice-actions .card { position: sticky; top: 80px; }

            /* ── Submit error banner ── */
            #pac-submit-error {
                display: none;
                background: rgba(239,68,68,0.08);
                border: 1px solid rgba(239,68,68,0.3);
                border-radius: 0.5rem;
                padding: 0.75rem 1rem;
                font-size: 0.82rem;
                color: #b91c1c;
                margin-bottom: 1rem;
                align-items: center;
                gap: 0.5rem;
            }

            /* ── Toast ── */
            #pac-toast {
                position: fixed; bottom: 1.5rem; right: 1.5rem; z-index: 9999;
                background: #1f2937; color: #fff; border-radius: 0.625rem;
                padding: 0.875rem 1.25rem; font-size: 0.82rem;
                display: flex; align-items: center; gap: 0.625rem;
                box-shadow: 0 8px 24px rgba(0,0,0,0.18);
                transform: translateY(120%); opacity: 0;
                transition: transform 0.3s cubic-bezier(.4,0,.2,1), opacity 0.3s ease;
                max-width: 320px;
            }
            #pac-toast.show { transform: translateY(0); opacity: 1; }
            #pac-toast i { color: #f87171; font-size: 1rem; flex-shrink: 0; }

            @media (max-width: 575.98px) {
                .invoice-edit .invoice-preview-card .invoice-calculations { inline-size: 100%; }
            }
            @media print {
                .invoice-edit hr { margin-block: 1rem !important; }
            }
        </style>
    @endpush

    {{-- Toast --}}
    <div id="pac-toast">
        <i class="ri ri-error-warning-line"></i>
        <span id="pac-toast-msg">Please add at least one item before saving.</span>
    </div>

    <form method="POST"
          action="{{ route('admin.invoices.update', $invoice) }}"
          id="pac-invoice-form">
        @csrf
        @method('PUT')

        <div class="row invoice-edit">

            {{-- ══════════════════════════════════════════════
                 MAIN INVOICE CARD (col 9)
            ═══════════════════════════════════════════════ --}}
            <div class="col-lg-9 col-12 mb-lg-0 mb-6">
                <div class="card invoice-preview-card p-sm-12 p-6">

                    {{-- ── Header ── --}}
                    <div class="card-body invoice-preview-header rounded-4 text-heading p-6 px-3">
                        <div class="row mx-0 px-3 row-gap-6">

                            <div class="col-md-8 ps-0">
                                <div class="d-flex svg-illustration align-items-center gap-2 mb-6">
                                    <span class="app-brand-logo demo">
                                        <svg width="32" height="32" viewBox="0 0 101.5 101.5"
                                             fill="#b5cc18" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M0,0V92.7H92.7V0ZM44.13,85.55,25.84,68.33V48.91H44.13Zm0-40.42H25.84V24l18.29-4.59ZM66.44,63.74,48.15,66V48.91H66.44Zm0-18.61H48.15V26.91l18.29,2.87Z"/>
                                        </svg>
                                    </span>
                                </div>
                                <p class="mb-1">Pacmedia Creatives</p>
                                <p class="mb-0">Lagos, Nigeria</p>
                            </div>

                            <div class="col-md-4 col-8 pe-0 ps-0 ps-md-2">
                                <dl class="row mb-0 gx-4">
                                    <dt class="col-sm-5 mb-2 d-md-flex align-items-center justify-content-start">
                                        <span class="h5 text-capitalize mb-0 text-nowrap">Invoice</span>
                                    </dt>
                                    <dd class="col-sm-7">
                                        <div class="input-group input-group-merge input-group-sm">
                                            <span class="input-group-text">P</span>
                                            <input type="text" name="number"
                                                   class="form-control @error('number') is-invalid @enderror"
                                                   value="{{ old('number', substr($invoice->number, 1)) }}"
                                                   required>
                                        </div>
                                        @error('number')
                                        <div class="text-danger" style="font-size:0.72rem;">{{ $message }}</div>
                                        @enderror
                                    </dd>
                                    <dt class="col-sm-5 mb-2 d-md-flex align-items-center justify-content-start">
                                        <span class="fw-normal text-nowrap">Date Issued:</span>
                                    </dt>
                                    <dd class="col-sm-7">
                                        <input type="text" name="submitted_at"
                                               class="form-control form-control-sm invoice-date @error('submitted_at') is-invalid @enderror"
                                               value="{{ old('submitted_at', $invoice->submitted_at?->format('Y-m-d')) }}"
                                               required>
                                    </dd>
                                    <dt class="col-sm-5 d-md-flex align-items-center justify-content-start">
                                        <span class="fw-normal">Due Date:</span>
                                    </dt>
                                    <dd class="col-sm-7 mb-0">
                                        <input type="text" name="due_date"
                                               class="form-control form-control-sm @error('due_date') is-invalid @enderror"
                                               value="{{ old('due_date', $invoice->due_date) }}"
                                               placeholder="Upon Receipt" required>
                                    </dd>
                                </dl>
                            </div>

                        </div>
                    </div>
                    {{-- / header --}}

                    {{-- ── Invoice To + Payment Details ── --}}
                    <div class="card-body py-6 px-0">
                        <div class="row">

                            <div class="col-md-6 col-sm-5 col-12 mb-sm-0 mb-6">
                                <h6>Invoice To:</h6>
                                <select name="client_id"
                                        class="form-select mb-4 w-75 @error('client_id') is-invalid @enderror"
                                        id="client-select" required>
                                    <option value="">— Select Client —</option>
                                    @foreach($clients as $client)
                                        <option value="{{ $client->id }}"
                                                data-company="{{ $client->company }}"
                                                data-email="{{ $client->email }}"
                                                data-phone="{{ $client->phone }}"
                                            {{ old('client_id', $invoice->client_id) == $client->id ? 'selected' : '' }}>
                                            {{ $client->display_name }}
                                        </option>
                                    @endforeach
                                </select>
                                <div id="client-preview"
                                     style="{{ $invoice->client_id ? 'display:block' : 'display:none' }};">
                                    <p class="mb-1 fw-medium" id="cp-company">{{ $invoice->client->company ?? '' }}</p>
                                    <p class="mb-1" id="cp-email">{{ $invoice->client->email ?? '' }}</p>
                                    <p class="mb-1" id="cp-phone">{{ $invoice->client->phone ?? '' }}</p>
                                </div>
                                <div class="mt-3">
                                    <label class="form-label fw-medium" style="font-size:0.82rem;">Project / Service</label>
                                    <input type="text" name="project_name"
                                           class="form-control form-control-sm"
                                           value="{{ old('project_name', $invoice->project_name) }}"
                                           placeholder="e.g. Enamux Branding & Website">
                                </div>
                            </div>

                            <div class="col-md-6 col-sm-7">
                                <h6>Payment Details:</h6>
                                <table><tbody>
                                    <tr>
                                        <td class="pe-4 text-nowrap align-middle" style="font-size:0.83rem;">Bank Name:</td>
                                        <td>
                                            <input type="text" name="bank_name" class="form-control form-control-sm"
                                                   value="{{ old('bank_name', $invoice->bank_name) }}" placeholder="Bank Name">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="pe-4 text-nowrap align-middle" style="font-size:0.83rem;">Account Name:</td>
                                        <td>
                                            <input type="text" name="bank_account_name" class="form-control form-control-sm"
                                                   value="{{ old('bank_account_name', $invoice->bank_account_name) }}" placeholder="Account Name">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="pe-4 text-nowrap align-middle" style="font-size:0.83rem;">Account Number:</td>
                                        <td>
                                            <input type="text" name="bank_account_number" class="form-control form-control-sm"
                                                   value="{{ old('bank_account_number', $invoice->bank_account_number) }}" placeholder="Account Number">
                                        </td>
                                    </tr>
                                    </tbody></table>
                            </div>

                        </div>
                    </div>

                    <hr class="mt-0 mb-6">

                    {{-- ══════════════════════════════════════
                         SECTION TOGGLES
                    ═══════════════════════════════════════ --}}

                    @php
                        $hasCompOld = old('has_completed',    $invoice->has_completed);
                        $hasSubOld  = old('has_subscription', $invoice->has_subscription);
                        $hasPropOld = old('has_proposed',     $invoice->has_proposed);
                    @endphp

                    <div class="card-body py-0 px-0">

                        {{-- ── COMPLETED SERVICES ── --}}
                        <input type="hidden" name="has_completed" id="has_completed"
                               value="{{ $hasCompOld ? '1' : '0' }}">

                        <div id="completed-toggle"
                             class="pac-section-toggle pac-completed-toggle"
                             style="{{ $hasCompOld ? 'display:none' : 'display:flex' }};">
                            <div class="pac-completed-icon"><i class="ri ri-checkbox-circle-line"></i></div>
                            <div>
                                <div class="pac-section-toggle-label">Add Completed Services</div>
                                <div class="pac-section-toggle-sub">Work already delivered — ready to invoice</div>
                            </div>
                        </div>

                        <div id="completed-section"
                             style="{{ $hasCompOld ? 'display:block' : 'display:none' }};">
                            <div class="pac-section-divider">
                                <hr>
                                <span class="pac-section-badge pac-completed-badge">Completed Services</span>
                                <hr>
                            </div>

                            <div id="completed-items-container" class="mb-4"></div>

                            <div class="d-flex align-items-center gap-3 mb-6">
                                <button type="button" class="btn btn-primary btn-sm" id="add-completed-item">
                                    <i class="icon-base ri ri-add-line icon-14px me-1"></i>Add Item
                                </button>
                                <button type="button" id="remove-completed" class="btn btn-outline-secondary btn-sm">
                                    Remove Section
                                </button>
                            </div>

                            <div class="row row-gap-4">
                                <div class="col-md-6 mb-md-0 mb-3">
                                    <div class="mb-4">
                                        <label class="fw-medium text-heading mb-1" style="font-size:0.82rem;">Notes:</label>
                                        <textarea name="completed_notes" class="form-control" rows="2"
                                                  placeholder="e.g. Outstanding from Logo service is Business card and Letterhead">{{ old('completed_notes', $invoice->completed_notes) }}</textarea>
                                    </div>
                                    <div class="row g-2">
                                        <div class="col-12">
                                            <label class="form-label mb-1" style="font-size:0.78rem; font-weight:600; color:#374151;">Discount Label</label>
                                            <input type="text" name="completed_discount_label" id="completed_discount_label"
                                                   class="form-control form-control-sm"
                                                   value="{{ old('completed_discount_label', $invoice->completed_discount_label) }}"
                                                   placeholder="e.g. Early payment discount">
                                        </div>
                                        <div class="col-6">
                                            <label class="form-label mb-1" style="font-size:0.78rem; font-weight:600; color:#374151;">Discount (₦)</label>
                                            <input type="number" name="completed_discount" id="completed_discount"
                                                   class="form-control form-control-sm"
                                                   value="{{ old('completed_discount', $invoice->completed_discount) }}"
                                                   min="0" step="0.01">
                                        </div>
                                        <div class="col-6">
                                            <label class="form-label mb-1" style="font-size:0.78rem; font-weight:600; color:#374151;">Amount Paid (₦)</label>
                                            <input type="number" name="paid_amount" id="paid_amount"
                                                   class="form-control form-control-sm"
                                                   value="{{ old('paid_amount', $invoice->paid_amount) }}"
                                                   min="0" step="0.01">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 d-flex justify-content-md-end mt-2">
                                    <div class="invoice-calculations">
                                        <div class="d-flex justify-content-between mb-1"><span>Subtotal:</span><span class="fw-medium" id="c-subtotal">₦0.00</span></div>
                                        <div class="d-flex justify-content-between mb-1" id="c-discount-row" style="display:none !important;"><span id="c-discount-label-display">Discount:</span><span class="fw-medium text-danger" id="c-discount-display">-₦0.00</span></div>
                                        <div class="d-flex justify-content-between mb-1" id="c-tax-row" style="display:none !important;"><span id="c-tax-label-display">VAT:</span><span class="fw-medium" id="c-tax-display">₦0.00</span></div>
                                        <div class="d-flex justify-content-between mb-1" id="c-paid-row" style="display:none !important;"><span>Paid:</span><span class="fw-medium text-success" id="c-paid-display">-₦0.00</span></div>
                                        <div class="d-flex justify-content-between mb-1" id="c-wht-row" style="display:none !important;"><span id="c-wht-label-display">WHT:</span><span class="fw-medium text-danger" id="c-wht-display">-₦0.00</span></div>
                                        <hr class="my-2">
                                        <div class="d-flex justify-content-between"><span>Outstanding:</span><span class="fw-bold" id="c-outstanding">₦0.00</span></div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <hr class="my-6" id="completed-divider"
                            style="{{ $hasCompOld ? 'display:block' : 'display:none' }};">

                        {{-- ── SUBSCRIPTION SERVICES ── --}}
                        <input type="hidden" name="has_subscription" id="has_subscription"
                               value="{{ $hasSubOld ? '1' : '0' }}">

                        <div id="subscription-toggle"
                             class="pac-section-toggle pac-subscription-toggle"
                             style="{{ $hasSubOld ? 'display:none' : 'display:flex' }};">
                            <div class="pac-subscription-icon"><i class="ri ri-loop-right-line"></i></div>
                            <div>
                                <div class="pac-section-toggle-label">Add Subscription / Renewal Services</div>
                                <div class="pac-section-toggle-sub">Hosting, domain renewals, retainers — monthly or annual</div>
                            </div>
                        </div>

                        <div id="subscription-section"
                             style="{{ $hasSubOld ? 'display:block' : 'display:none' }};">
                            <div class="pac-section-divider">
                                <hr>
                                <span class="pac-section-badge pac-subscription-badge">Subscription / Renewals</span>
                                <hr>
                            </div>

                            <div id="subscription-items-container" class="mb-4"></div>

                            <div class="d-flex align-items-center gap-3 mb-6">
                                <button type="button" class="btn btn-primary btn-sm" id="add-subscription-item">
                                    <i class="icon-base ri ri-add-line icon-14px me-1"></i>Add Item
                                </button>
                                <button type="button" id="remove-subscription" class="btn btn-outline-secondary btn-sm">
                                    Remove Section
                                </button>
                            </div>

                            <div class="row row-gap-4">
                                <div class="col-md-6">
                                    <label class="fw-medium text-heading mb-1" style="font-size:0.82rem;">Subscription Notes:</label>
                                    <textarea name="subscription_notes" class="form-control" rows="2"
                                              placeholder="e.g. Annual hosting renewal — next due April 2026">{{ old('subscription_notes', $invoice->subscription_notes) }}</textarea>
                                    <div class="row g-2 mt-1">
                                        <div class="col-12">
                                            <label class="form-label mb-1" style="font-size:0.78rem; font-weight:600; color:#374151;">Discount Label</label>
                                            <input type="text" name="subscription_discount_label" id="subscription_discount_label"
                                                   class="form-control form-control-sm"
                                                   value="{{ old('subscription_discount_label', $invoice->subscription_discount_label) }}"
                                                   placeholder="e.g. Loyalty discount">
                                        </div>
                                        <div class="col-12">
                                            <label class="form-label mb-1" style="font-size:0.78rem; font-weight:600; color:#374151;">Discount Amount (₦)</label>
                                            <input type="number" name="subscription_discount" id="subscription_discount"
                                                   class="form-control form-control-sm"
                                                   value="{{ old('subscription_discount', $invoice->subscription_discount) }}"
                                                   min="0" step="0.01">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 d-flex justify-content-md-end mt-2">
                                    <div class="invoice-calculations">
                                        <div class="d-flex justify-content-between mb-1"><span>Subtotal:</span><span class="fw-medium" id="s-subtotal">₦0.00</span></div>
                                        <div class="d-flex justify-content-between mb-1" id="s-discount-row" style="display:none !important;"><span id="s-discount-label-display">Discount:</span><span class="fw-medium text-danger" id="s-discount-display">-₦0.00</span></div>
                                        <div class="d-flex justify-content-between mb-1" id="s-tax-row" style="display:none !important;"><span id="s-tax-label-display">VAT:</span><span class="fw-medium" id="s-tax-display">₦0.00</span></div>
                                        <hr class="my-2">
                                        <div class="d-flex justify-content-between"><span>Total Due:</span><span class="fw-bold" id="s-total">₦0.00</span></div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <hr class="my-6" id="subscription-divider"
                            style="{{ $hasSubOld ? 'display:block' : 'display:none' }};">

                        {{-- ── Tax & WHT Panel ── --}}
                        <div class="pac-tax-panel my-6">
                            <div class="d-flex align-items-center justify-content-between">
                                <span class="fw-medium text-heading" style="font-size:0.83rem;">Tax & Withholding</span>
                                <div class="d-flex gap-4">
                                    <div class="form-check form-switch mb-0">
                                        <input class="form-check-input" type="checkbox"
                                               name="tax_enabled" id="tax_enabled" value="1"
                                            {{ old('tax_enabled', $invoice->tax_enabled) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="tax_enabled" style="font-size:0.78rem;">Apply Tax</label>
                                    </div>
                                    <div class="form-check form-switch mb-0">
                                        <input class="form-check-input" type="checkbox"
                                               name="wht_enabled" id="wht_enabled" value="1"
                                            {{ old('wht_enabled', $invoice->wht_enabled) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="wht_enabled" style="font-size:0.78rem;">Client deducts WHT</label>
                                    </div>
                                </div>
                            </div>
                            <div id="tax-fields"
                                 style="{{ old('tax_enabled', $invoice->tax_enabled) ? 'display:block' : 'display:none' }};">
                                <div class="pac-tax-grid">
                                    <div>
                                        <label class="form-label" style="font-size:0.72rem; font-weight:600; color:#374151;">Label</label>
                                        <input type="text" name="tax_label" id="tax_label"
                                               class="form-control form-control-sm"
                                               value="{{ old('tax_label', $invoice->tax_label) }}">
                                    </div>
                                    <div>
                                        <label class="form-label" style="font-size:0.72rem; font-weight:600; color:#374151;">Rate (%)</label>
                                        <input type="number" name="tax_rate" id="tax_rate"
                                               class="form-control form-control-sm"
                                               value="{{ old('tax_rate', $invoice->tax_rate) }}"
                                               min="0" max="100" step="0.01">
                                    </div>
                                    <div>
                                        <label class="form-label" style="font-size:0.72rem; font-weight:600; color:#374151;">Applies to</label>
                                        <select name="tax_applies_to" id="tax_applies_to" class="form-select form-select-sm">
                                            @foreach([
                                                'completed'    => 'Completed only',
                                                'subscription' => 'Subscriptions only',
                                                'proposed'     => 'Proposed only',
                                                'both'         => 'Completed + Proposed',
                                                'all'          => 'All sections',
                                            ] as $val => $label)
                                                <option value="{{ $val }}"
                                                    {{ old('tax_applies_to', $invoice->tax_applies_to) === $val ? 'selected' : '' }}>
                                                    {{ $label }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div id="wht-fields"
                                 style="{{ old('wht_enabled', $invoice->wht_enabled) ? 'display:block' : 'display:none' }};">
                                <div class="pac-tax-grid">
                                    <div>
                                        <label class="form-label" style="font-size:0.72rem; font-weight:600; color:#374151;">WHT Label</label>
                                        <input type="text" name="wht_label" id="wht_label"
                                               class="form-control form-control-sm"
                                               value="{{ old('wht_label', $invoice->wht_label) }}">
                                    </div>
                                    <div>
                                        <label class="form-label" style="font-size:0.72rem; font-weight:600; color:#374151;">WHT Rate (%)</label>
                                        <input type="number" name="wht_rate" id="wht_rate"
                                               class="form-control form-control-sm"
                                               value="{{ old('wht_rate', $invoice->wht_rate) }}"
                                               min="0" max="100" step="0.01">
                                    </div>
                                    <div></div>
                                </div>
                            </div>
                        </div>

                        {{-- ── PROPOSED SERVICES ── --}}
                        <input type="hidden" name="has_proposed" id="has_proposed"
                               value="{{ $hasPropOld ? '1' : '0' }}">

                        <div id="proposed-toggle"
                             class="pac-section-toggle pac-proposed-toggle"
                             style="{{ $hasPropOld ? 'display:none' : 'display:flex' }};">
                            <div class="pac-proposed-icon"><i class="ri ri-add-line"></i></div>
                            <div>
                                <div class="pac-section-toggle-label">Add Proposed Services</div>
                                <div class="pac-section-toggle-sub">Optional — quote additional work on the same invoice</div>
                            </div>
                        </div>

                        <div id="proposed-section"
                             style="{{ $hasPropOld ? 'display:block' : 'display:none' }};">
                            <div class="pac-section-divider">
                                <hr>
                                <span class="pac-section-badge pac-proposed-badge">Proposed Services</span>
                                <hr>
                            </div>

                            <div id="proposed-items-container" class="mb-4"></div>

                            <div class="d-flex align-items-center gap-3">
                                <button type="button" class="btn btn-primary btn-sm" id="add-proposed-item">
                                    <i class="icon-base ri ri-add-line icon-14px me-1"></i>Add Item
                                </button>
                                <button type="button" id="remove-proposed" class="btn btn-outline-secondary btn-sm">
                                    Remove Section
                                </button>
                            </div>

                            <hr class="my-6">
                            <div class="row row-gap-4">
                                <div class="col-md-6">
                                    <label class="fw-medium text-heading mb-1" style="font-size:0.82rem;">Proposed Notes:</label>
                                    <textarea name="proposed_notes" class="form-control" rows="2"
                                              placeholder="e.g. Prices valid for 30 days">{{ old('proposed_notes', $invoice->proposed_notes) }}</textarea>
                                    <div class="row g-2 mt-1">
                                        <div class="col-12">
                                            <label class="form-label mb-1" style="font-size:0.78rem; font-weight:600; color:#374151;">Discount Label</label>
                                            <input type="text" name="proposed_discount_label" id="proposed_discount_label"
                                                   class="form-control form-control-sm"
                                                   value="{{ old('proposed_discount_label', $invoice->proposed_discount_label) }}"
                                                   placeholder="e.g. AI Automation Bundle Discount">
                                        </div>
                                        <div class="col-12">
                                            <label class="form-label mb-1" style="font-size:0.78rem; font-weight:600; color:#374151;">Discount Amount (₦)</label>
                                            <input type="number" name="proposed_discount" id="proposed_discount"
                                                   class="form-control form-control-sm"
                                                   value="{{ old('proposed_discount', $invoice->proposed_discount) }}"
                                                   min="0" step="0.01">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 d-flex justify-content-md-end mt-2">
                                    <div class="invoice-calculations">
                                        <div class="d-flex justify-content-between mb-1"><span>Subtotal:</span><span class="fw-medium" id="p-subtotal">₦0.00</span></div>
                                        <div class="d-flex justify-content-between mb-1" id="p-discount-row" style="display:none !important;"><span id="p-discount-label-display">Discount:</span><span class="fw-medium text-danger" id="p-discount-display">-₦0.00</span></div>
                                        <div class="d-flex justify-content-between mb-1" id="p-tax-row" style="display:none !important;"><span id="p-tax-label-display">VAT:</span><span class="fw-medium" id="p-tax-display">₦0.00</span></div>
                                        <hr class="my-2">
                                        <div class="d-flex justify-content-between"><span>Total:</span><span class="fw-bold" id="p-total">₦0.00</span></div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>

                </div>
            </div>
            {{-- / col 9 --}}

            {{-- ══════════════════════════════════════════════
                 ACTIONS SIDEBAR (col 3)
            ═══════════════════════════════════════════════ --}}
            <div class="col-lg-3 col-12 invoice-actions">

                <div class="card mb-6">
                    <div class="card-body">
                        <div id="pac-submit-error">
                            <i class="ri ri-error-warning-line" style="font-size:1rem; flex-shrink:0;"></i>
                            <span>Add at least one item to any section before saving.</span>
                        </div>
                        <button type="submit" name="status_action" value="sent"
                                class="btn btn-primary d-grid w-100 mb-4">
                            <span class="d-flex align-items-center justify-content-center text-nowrap">
                                <i class="icon-base ri ri-save-line icon-16px me-2"></i>Save Changes
                            </span>
                        </button>
                        <a href="{{ route('admin.invoices.show', $invoice) }}"
                           class="btn btn-outline-secondary d-grid w-100 mb-4">Cancel</a>
                        <input type="hidden" name="status" id="form-status"
                               value="{{ old('status', $invoice->status) }}">
                    </div>
                </div>

                <div>
                    <div class="mb-6">
                        <label class="form-label fw-medium" style="font-size:0.82rem;">Status</label>
                        <select class="form-select" id="status-select">
                            @foreach(['draft','sent','partial','paid','overdue'] as $s)
                                <option value="{{ $s }}"
                                    {{ old('status', $invoice->status) === $s ? 'selected' : '' }}>
                                    {{ ucfirst($s) }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-6">
                        <label class="form-label fw-medium" style="font-size:0.82rem;">Currency</label>
                        <select name="currency" id="currency-select" class="form-select">
                            @foreach(\App\Models\Invoice::$currencySymbols as $code => $symbol)
                                <option value="{{ $code }}"
                                    {{ old('currency', $invoice->currency ?? 'NGN') === $code ? 'selected' : '' }}>
                                    {{ $code }} ({{ $symbol }})
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-medium" style="font-size:0.82rem;">Summary</label>
                        <div class="d-flex justify-content-between mb-2" id="sidebar-completed-row" style="font-size:0.8rem; display:none !important;">
                            <span style="color:#c2410c;"><i class="ri ri-checkbox-circle-line me-1" style="font-size:0.75rem;"></i>Completed</span>
                            <span class="fw-medium" id="sidebar-completed">₦0.00</span>
                        </div>
                        <div class="d-flex justify-content-between mb-2" id="sidebar-subscription-row" style="font-size:0.8rem; display:none !important;">
                            <span style="color:#1d4ed8;"><i class="ri ri-loop-right-line me-1" style="font-size:0.75rem;"></i>Subscriptions</span>
                            <span class="fw-medium" id="sidebar-subscription">₦0.00</span>
                        </div>
                        <div class="d-flex justify-content-between mb-2" id="sidebar-proposed-row" style="font-size:0.8rem; display:none !important;">
                            <span style="color:#96aa12;">Proposed</span>
                            <span class="fw-medium" id="sidebar-proposed">₦0.00</span>
                        </div>
                        <div class="d-flex justify-content-between mb-2" id="sidebar-paid-row" style="font-size:0.8rem; display:none !important;">
                            <span class="text-success">Paid</span>
                            <span class="fw-medium text-success" id="sidebar-paid">-₦0.00</span>
                        </div>
                        <hr class="my-2">
                        <div class="d-flex justify-content-between" style="font-size:0.88rem; font-weight:700; color:#111827;">
                            <span>Outstanding</span>
                            <span id="sidebar-outstanding">₦0.00</span>
                        </div>
                    </div>

                    <div class="text-center" style="font-size:0.78rem;">
                        <a href="{{ route('admin.invoices.show', $invoice) }}"
                           style="color:#9ca3af; text-decoration:none;">
                            <i class="ri ri-eye-line me-1"></i> View Invoice
                        </a>
                    </div>
                </div>

            </div>

        </div>

    </form>

    {{-- ══════════════════════════════════════════════
         TEMPLATES
    ═══════════════════════════════════════════════ --}}

    {{-- ─────────────────────────────────────────────────────────────────
         Standard line item — two-zone card
         Zone 1 (white): Description full-width + × remove button
         Zone 2 (grey bg, dashed top): Unit Price · Qty · Total
    ───────────────────────────────────────────────────────────────── --}}
    <template id="item-row-template">
        <div class="repeater-wrapper mb-3" data-item-row>
            <div class="border rounded overflow-hidden">

                {{-- Zone 1: Description ── --}}
                <div class="d-flex align-items-center gap-3 px-4 pt-4 pb-3">
                    <div class="flex-grow-1">
                        <p class="repeater-title">Description</p>
                        <input type="text"
                               class="form-control item-description"
                               placeholder="Service description">
                    </div>
                    <div class="remove-item-btn remove-item flex-shrink-0 mt-3">
                        <i class="ri ri-close-line icon-18px"></i>
                    </div>
                </div>

                {{-- Zone 2: Price · Qty · Total ── --}}
                <div class="item-zone-bottom d-flex align-items-center gap-4 px-4 py-3 flex-wrap">

                    <div style="flex: 1; min-width: 120px;">
                        <p class="repeater-title">Unit Price (₦)</p>
                        <input type="number"
                               class="form-control form-control-sm item-price"
                               placeholder="0.00" min="0" step="0.01">
                    </div>

                    <div style="width: 80px; flex-shrink: 0;">
                        <p class="repeater-title">Qty</p>
                        <input type="number"
                               class="form-control form-control-sm item-qty"
                               value="1" min="1" step="1">
                    </div>

                    <div class="ms-auto text-end" style="flex-shrink: 0; min-width: 100px;">
                        <p class="repeater-title" style="text-align: right;">Total</p>
                        <p class="mb-0 item-total item-total-display">₦0.00</p>
                    </div>

                </div>

            </div>
        </div>
    </template>

    {{-- ─────────────────────────────────────────────────────────────────
         Subscription line item — two-zone card
         Zone 1: Description · Cycle · Renewal Date + × remove
         Zone 2: Amount · Qty · Total
    ───────────────────────────────────────────────────────────────── --}}
    <template id="subscription-row-template">
        <div class="repeater-wrapper mb-3" data-item-row>
            <div class="border rounded overflow-hidden subs-item-card">

                {{-- Zone 1: Description + meta ── --}}
                <div class="d-flex align-items-start gap-3 px-4 pt-4 pb-3">
                    <div class="flex-grow-1">
                        <div class="row g-3">
                            <div class="col-12 col-md-6">
                                <p class="repeater-title">Description</p>
                                <input type="text"
                                       class="form-control item-description"
                                       placeholder="e.g. Website Hosting — annual">
                            </div>
                            <div class="col-6 col-md-3">
                                <p class="repeater-title">Cycle</p>
                                <select class="form-select form-select-sm item-cycle">
                                    <option value="annual">Annual</option>
                                    <option value="monthly">Monthly</option>
                                </select>
                            </div>
                            <div class="col-6 col-md-3">
                                <p class="repeater-title">Renewal Date</p>
                                <input type="text"
                                       class="form-control form-control-sm item-renewal flatpickr-renewal"
                                       placeholder="YYYY-MM-DD">
                            </div>
                        </div>
                    </div>
                    <div class="remove-item-btn remove-item flex-shrink-0" style="margin-top: 1.4rem;">
                        <i class="ri ri-close-line icon-18px"></i>
                    </div>
                </div>

                {{-- Zone 2: Amount · Qty · Total ── --}}
                <div class="subs-item-zone-bottom d-flex align-items-center gap-4 px-4 py-3 flex-wrap">

                    <div style="flex: 1; min-width: 120px;">
                        <p class="repeater-title">Amount (₦)</p>
                        <input type="number"
                               class="form-control form-control-sm item-price"
                               placeholder="0.00" min="0" step="0.01">
                    </div>

                    <div style="width: 80px; flex-shrink: 0;">
                        <p class="repeater-title">Qty</p>
                        <input type="number"
                               class="form-control form-control-sm item-qty"
                               value="1" min="1" step="1">
                    </div>

                    <div class="ms-auto text-end" style="flex-shrink: 0; min-width: 100px;">
                        <p class="repeater-title" style="text-align: right;">Total</p>
                        <p class="mb-0 item-total item-total-display" style="color:#1d4ed8;">₦0.00</p>
                    </div>

                </div>

            </div>
        </div>
    </template>

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
        <script src="{{ asset('admin/assets/vendor/libs/flatpickr/flatpickr.js') }}"></script>

        @php
            $existingCompleted    = $invoice->completedItems->map(fn($i) => [
                'description' => $i->description,
                'unit_price'  => (float) $i->unit_price,
                'qty'         => (int)   $i->qty,
            ])->values();

            $existingSubscription = $invoice->subscriptionItems->map(fn($i) => [
                'description'   => $i->description,
                'unit_price'    => (float) $i->unit_price,
                'qty'           => (int)   $i->qty,
                'billing_cycle' => $i->billing_cycle,
                'renewal_date'  => $i->renewal_date?->format('Y-m-d'),
            ])->values();

            $existingProposed     = $invoice->proposedItems->map(fn($i) => [
                'description' => $i->description,
                'unit_price'  => (float) $i->unit_price,
                'qty'         => (int)   $i->qty,
            ])->values();
        @endphp

        <script>
            (function () {

                const existingCompleted    = @json($existingCompleted);
                const existingSubscription = @json($existingSubscription);
                const existingProposed     = @json($existingProposed);

                /* ── Helpers ── */
                const fmt  = n => '₦' + parseFloat(n || 0).toLocaleString('en-NG', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
                const num  = el => parseFloat(el?.value || 0) || 0;
                const show = (el, v) => { if (el) el.style.setProperty('display', v ? 'flex' : 'none', 'important'); };

                /* ── Flatpickr ── */
                flatpickr('.invoice-date', { dateFormat: 'Y-m-d', monthSelectorType: 'static' });
                function initRenewalPicker(input) {
                    flatpickr(input, { dateFormat: 'Y-m-d', monthSelectorType: 'static' });
                }

                /* ── Toast ── */
                function showToast(msg) {
                    const toast = document.getElementById('pac-toast');
                    document.getElementById('pac-toast-msg').textContent = msg;
                    toast.classList.add('show');
                    setTimeout(() => toast.classList.remove('show'), 4000);
                }

                /* ── Error banner ── */
                function showError(msg) {
                    const el = document.getElementById('pac-submit-error');
                    el.querySelector('span').textContent = msg;
                    el.style.display = 'flex';
                    el.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
                }
                function hideError() { document.getElementById('pac-submit-error').style.display = 'none'; }

                /* ── Submit guard ── */
                document.getElementById('pac-invoice-form').addEventListener('submit', function (e) {
                    const c = document.querySelectorAll('#completed-items-container [data-item-row]').length;
                    const s = document.querySelectorAll('#subscription-items-container [data-item-row]').length;
                    const p = document.querySelectorAll('#proposed-items-container [data-item-row]').length;
                    if (c + s + p === 0) {
                        e.preventDefault();
                        const msg = 'Add at least one item to any section before saving.';
                        showError(msg);
                        showToast(msg);
                    } else {
                        hideError();
                    }
                });

                /* ── Client preview ── */
                const clientSelect  = document.getElementById('client-select');
                const clientPreview = document.getElementById('client-preview');
                clientSelect.addEventListener('change', function () {
                    const opt = this.options[this.selectedIndex];
                    if (!this.value) { clientPreview.style.display = 'none'; return; }
                    document.getElementById('cp-company').textContent = opt.dataset.company || '';
                    document.getElementById('cp-email').textContent   = opt.dataset.email   || '';
                    document.getElementById('cp-phone').textContent   = opt.dataset.phone   || '';
                    clientPreview.style.display = 'block';
                });

                /* ── Templates ── */
                const tpl     = document.getElementById('item-row-template');
                const subsTpl = document.getElementById('subscription-row-template');

                /* ── Add standard item ── */
                function addItem(containerId, section, prefill) {
                    const container = document.getElementById(containerId);
                    const idx       = container.querySelectorAll('[data-item-row]').length;
                    const clone     = tpl.content.cloneNode(true);
                    const row       = clone.querySelector('[data-item-row]');

                    const descEl  = row.querySelector('.item-description');
                    const priceEl = row.querySelector('.item-price');
                    const qtyEl   = row.querySelector('.item-qty');

                    descEl.name  = `${section}_items[${idx}][description]`;
                    priceEl.name = `${section}_items[${idx}][unit_price]`;
                    qtyEl.name   = `${section}_items[${idx}][qty]`;

                    if (prefill) {
                        descEl.value  = prefill.description || '';
                        priceEl.value = prefill.unit_price  || '';
                        qtyEl.value   = prefill.qty         || 1;
                        row.querySelector('.item-total').textContent = fmt((parseFloat(prefill.qty) || 1) * (parseFloat(prefill.unit_price) || 0));
                    }

                    const updateTotal = () => {
                        row.querySelector('.item-total').textContent = fmt(num(qtyEl) * num(priceEl));
                        recalc();
                    };
                    priceEl.addEventListener('input', updateTotal);
                    qtyEl.addEventListener('input',   updateTotal);
                    row.querySelector('.remove-item').addEventListener('click', () => {
                        row.remove();
                        reindex(containerId, section);
                        recalc();
                    });

                    container.appendChild(clone);
                }

                /* ── Add subscription item ── */
                function addSubscriptionItem(prefill) {
                    const container = document.getElementById('subscription-items-container');
                    const idx       = container.querySelectorAll('[data-item-row]').length;
                    const clone     = subsTpl.content.cloneNode(true);
                    const row       = clone.querySelector('[data-item-row]');

                    const descEl    = row.querySelector('.item-description');
                    const cycleEl   = row.querySelector('.item-cycle');
                    const renewalEl = row.querySelector('.item-renewal');
                    const priceEl   = row.querySelector('.item-price');
                    const qtyEl     = row.querySelector('.item-qty');

                    descEl.name    = `subscription_items[${idx}][description]`;
                    cycleEl.name   = `subscription_items[${idx}][billing_cycle]`;
                    renewalEl.name = `subscription_items[${idx}][renewal_date]`;
                    priceEl.name   = `subscription_items[${idx}][unit_price]`;
                    qtyEl.name     = `subscription_items[${idx}][qty]`;

                    if (prefill) {
                        descEl.value    = prefill.description  || '';
                        priceEl.value   = prefill.unit_price   || '';
                        qtyEl.value     = prefill.qty          || 1;
                        renewalEl.value = prefill.renewal_date || '';
                        if (prefill.billing_cycle) {
                            [...cycleEl.options].forEach(o => o.selected = o.value === prefill.billing_cycle);
                        }
                        row.querySelector('.item-total').textContent = fmt((parseFloat(prefill.qty) || 1) * (parseFloat(prefill.unit_price) || 0));
                    }

                    const updateTotal = () => {
                        row.querySelector('.item-total').textContent = fmt(num(qtyEl) * num(priceEl));
                        recalc();
                    };
                    priceEl.addEventListener('input', updateTotal);
                    qtyEl.addEventListener('input',   updateTotal);
                    row.querySelector('.remove-item').addEventListener('click', () => {
                        row.remove();
                        reindexSubscription();
                        recalc();
                    });

                    container.appendChild(clone);
                    initRenewalPicker(row.querySelector('.flatpickr-renewal'));
                }

                function reindex(containerId, section) {
                    document.querySelectorAll(`#${containerId} [data-item-row]`).forEach((row, i) => {
                        row.querySelector('.item-description').name = `${section}_items[${i}][description]`;
                        row.querySelector('.item-price').name       = `${section}_items[${i}][unit_price]`;
                        row.querySelector('.item-qty').name         = `${section}_items[${i}][qty]`;
                    });
                }
                function reindexSubscription() {
                    document.querySelectorAll('#subscription-items-container [data-item-row]').forEach((row, i) => {
                        row.querySelector('.item-description').name = `subscription_items[${i}][description]`;
                        row.querySelector('.item-cycle').name       = `subscription_items[${i}][billing_cycle]`;
                        row.querySelector('.item-renewal').name     = `subscription_items[${i}][renewal_date]`;
                        row.querySelector('.item-price').name       = `subscription_items[${i}][unit_price]`;
                        row.querySelector('.item-qty').name         = `subscription_items[${i}][qty]`;
                    });
                }

                document.getElementById('add-completed-item').addEventListener('click',    () => addItem('completed-items-container', 'completed', null));
                document.getElementById('add-subscription-item').addEventListener('click', () => addSubscriptionItem(null));
                document.getElementById('add-proposed-item').addEventListener('click',     () => addItem('proposed-items-container',  'proposed',  null));

                /* ── Subtotal ── */
                function subtotal(containerId) {
                    let t = 0;
                    document.querySelectorAll(`#${containerId} [data-item-row]`).forEach(row => {
                        t += num(row.querySelector('.item-qty')) * num(row.querySelector('.item-price'));
                    });
                    return t;
                }

                /* ── Recalculate ── */
                function recalc() {
                    const taxOn    = document.getElementById('tax_enabled').checked;
                    const whtOn    = document.getElementById('wht_enabled').checked;
                    const taxRate  = num(document.getElementById('tax_rate'))  / 100;
                    const whtRate  = num(document.getElementById('wht_rate'))  / 100;
                    const taxTo    = document.getElementById('tax_applies_to')?.value || 'completed';
                    const taxLabel = document.getElementById('tax_label')?.value      || 'VAT';
                    const whtLabel = document.getElementById('wht_label')?.value      || 'WHT';

                    const cDisc = num(document.getElementById('completed_discount'));
                    const sDisc = num(document.getElementById('subscription_discount'));
                    const pDisc = num(document.getElementById('proposed_discount'));
                    const paid  = num(document.getElementById('paid_amount'));

                    const cDiscLabel = document.getElementById('completed_discount_label')?.value    || 'Discount';
                    const sDiscLabel = document.getElementById('subscription_discount_label')?.value || 'Discount';
                    const pDiscLabel = document.getElementById('proposed_discount_label')?.value     || 'Discount';

                    const taxAppliesTo = {
                        completed:    ['completed','both','all'].includes(taxTo),
                        subscription: ['subscription','all'].includes(taxTo),
                        proposed:     ['proposed','both','all'].includes(taxTo),
                    };

                    const compVis = document.getElementById('has_completed').value === '1';
                    const subsVis = document.getElementById('has_subscription').value === '1';
                    const propVis = document.getElementById('has_proposed').value === '1';

                    /* Completed */
                    const cSub = subtotal('completed-items-container');
                    const cTax = taxOn && taxAppliesTo.completed    ? cSub * taxRate : 0;
                    const cWht = whtOn ? cSub * whtRate : 0;
                    const cOut = cSub + cTax - cDisc - paid - cWht;

                    document.getElementById('c-subtotal').textContent = fmt(cSub);
                    show(document.getElementById('c-discount-row'), cDisc > 0);
                    document.getElementById('c-discount-label-display').textContent = cDiscLabel + ':';
                    document.getElementById('c-discount-display').textContent       = '-' + fmt(cDisc);
                    show(document.getElementById('c-tax-row'), taxOn && taxAppliesTo.completed);
                    document.getElementById('c-tax-label-display').textContent = taxLabel + ':';
                    document.getElementById('c-tax-display').textContent       = fmt(cTax);
                    show(document.getElementById('c-paid-row'), paid > 0);
                    document.getElementById('c-paid-display').textContent = '-' + fmt(paid);
                    show(document.getElementById('c-wht-row'), whtOn);
                    document.getElementById('c-wht-label-display').textContent = whtLabel + ':';
                    document.getElementById('c-wht-display').textContent       = '-' + fmt(cWht);
                    document.getElementById('c-outstanding').textContent = fmt(cOut);

                    /* Subscription */
                    const sSub = subtotal('subscription-items-container');
                    const sTax = taxOn && taxAppliesTo.subscription ? sSub * taxRate : 0;
                    const sTot = sSub + sTax - sDisc;

                    document.getElementById('s-subtotal').textContent = fmt(sSub);
                    show(document.getElementById('s-discount-row'), sDisc > 0);
                    document.getElementById('s-discount-label-display').textContent = sDiscLabel + ':';
                    document.getElementById('s-discount-display').textContent       = '-' + fmt(sDisc);
                    show(document.getElementById('s-tax-row'), taxOn && taxAppliesTo.subscription);
                    document.getElementById('s-tax-label-display').textContent = taxLabel + ':';
                    document.getElementById('s-tax-display').textContent       = fmt(sTax);
                    document.getElementById('s-total').textContent = fmt(sTot);

                    /* Proposed */
                    const pSub = subtotal('proposed-items-container');
                    const pTax = taxOn && taxAppliesTo.proposed     ? pSub * taxRate : 0;
                    const pTot = pSub + pTax - pDisc;

                    document.getElementById('p-subtotal').textContent = fmt(pSub);
                    show(document.getElementById('p-discount-row'), pDisc > 0);
                    document.getElementById('p-discount-label-display').textContent = pDiscLabel + ':';
                    document.getElementById('p-discount-display').textContent       = '-' + fmt(pDisc);
                    show(document.getElementById('p-tax-row'), taxOn && taxAppliesTo.proposed);
                    document.getElementById('p-tax-label-display').textContent = taxLabel + ':';
                    document.getElementById('p-tax-display').textContent       = fmt(pTax);
                    document.getElementById('p-total').textContent = fmt(pTot);

                    /* Sidebar */
                    const totalOutstanding = (compVis ? cOut : 0) + (subsVis ? sTot : 0);
                    document.getElementById('sidebar-completed').textContent    = fmt(cSub);
                    document.getElementById('sidebar-subscription').textContent = fmt(sTot);
                    document.getElementById('sidebar-proposed').textContent     = fmt(pTot);
                    document.getElementById('sidebar-paid').textContent         = '-' + fmt(paid);
                    document.getElementById('sidebar-outstanding').textContent  = fmt(totalOutstanding);
                    show(document.getElementById('sidebar-completed-row'),    compVis && cSub > 0);
                    show(document.getElementById('sidebar-subscription-row'), subsVis && sSub > 0);
                    show(document.getElementById('sidebar-proposed-row'),     propVis && pSub > 0);
                    show(document.getElementById('sidebar-paid-row'),         paid > 0);
                }

                /* ── Tax toggles ── */
                document.getElementById('tax_enabled').addEventListener('change', function () {
                    document.getElementById('tax-fields').style.display = this.checked ? 'block' : 'none';
                    recalc();
                });
                document.getElementById('wht_enabled').addEventListener('change', function () {
                    document.getElementById('wht-fields').style.display = this.checked ? 'block' : 'none';
                    recalc();
                });
                ['tax_rate','tax_label','tax_applies_to','wht_rate','wht_label',
                    'completed_discount','subscription_discount','proposed_discount','paid_amount',
                    'completed_discount_label','subscription_discount_label','proposed_discount_label'
                ].forEach(id => {
                    const el = document.getElementById(id);
                    if (el) { el.addEventListener('input', recalc); el.addEventListener('change', recalc); }
                });

                /* ── Section toggles ── */
                document.getElementById('completed-toggle').addEventListener('click', () => {
                    document.getElementById('completed-section').style.display = 'block';
                    document.getElementById('completed-toggle').style.display  = 'none';
                    document.getElementById('has_completed').value = '1';
                    document.getElementById('completed-divider').style.display = 'block';
                    addItem('completed-items-container', 'completed', null);
                    recalc();
                });
                document.getElementById('remove-completed').addEventListener('click', () => {
                    document.getElementById('completed-section').style.display = 'none';
                    document.getElementById('completed-toggle').style.display  = 'flex';
                    document.getElementById('has_completed').value = '0';
                    document.getElementById('completed-divider').style.display = 'none';
                    document.getElementById('completed-items-container').innerHTML = '';
                    recalc();
                });

                document.getElementById('subscription-toggle').addEventListener('click', () => {
                    document.getElementById('subscription-section').style.display = 'block';
                    document.getElementById('subscription-toggle').style.display  = 'none';
                    document.getElementById('has_subscription').value = '1';
                    document.getElementById('subscription-divider').style.display = 'block';
                    addSubscriptionItem(null);
                    recalc();
                });
                document.getElementById('remove-subscription').addEventListener('click', () => {
                    document.getElementById('subscription-section').style.display = 'none';
                    document.getElementById('subscription-toggle').style.display  = 'flex';
                    document.getElementById('has_subscription').value = '0';
                    document.getElementById('subscription-divider').style.display = 'none';
                    document.getElementById('subscription-items-container').innerHTML = '';
                    recalc();
                });

                document.getElementById('proposed-toggle').addEventListener('click', () => {
                    document.getElementById('proposed-section').style.display = 'block';
                    document.getElementById('proposed-toggle').style.display  = 'none';
                    document.getElementById('has_proposed').value = '1';
                    addItem('proposed-items-container', 'proposed', null);
                    recalc();
                });
                document.getElementById('remove-proposed').addEventListener('click', () => {
                    document.getElementById('proposed-section').style.display = 'none';
                    document.getElementById('proposed-toggle').style.display  = 'flex';
                    document.getElementById('has_proposed').value = '0';
                    document.getElementById('proposed-items-container').innerHTML = '';
                    recalc();
                });

                /* ── Submit status ── */
                document.querySelectorAll('button[name="status_action"]').forEach(btn => {
                    btn.addEventListener('click', function () {
                        document.getElementById('form-status').value = this.value;
                    });
                });

                /* ── Init: load existing items ── */
                if (existingCompleted.length > 0) {
                    document.getElementById('completed-section').style.display = 'block';
                    document.getElementById('completed-toggle').style.display  = 'none';
                    document.getElementById('has_completed').value = '1';
                    document.getElementById('completed-divider').style.display = 'block';
                    existingCompleted.forEach(item => addItem('completed-items-container', 'completed', item));
                }

                existingSubscription.forEach(item => addSubscriptionItem(item));
                existingProposed.forEach(item => addItem('proposed-items-container', 'proposed', item));

                /* ── Session toast auto-hide ── */
                document.querySelectorAll('.toast.show').forEach(t => {
                    setTimeout(() => bootstrap.Toast.getOrCreateInstance(t).hide(), 4000);
                });

                recalc();

            })();
        </script>
    @endpush

</x-admin-layout>
