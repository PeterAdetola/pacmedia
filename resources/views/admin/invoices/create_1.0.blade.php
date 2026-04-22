<x-admin-layout title="New Invoice">

    @push('page-css')
        <link rel="stylesheet" href="{{ asset('admin/assets/vendor/libs/flatpickr/flatpickr.css') }}">
        <link rel="stylesheet" href="{{ asset('admin/assets/css/pages/app-invoice.css') }}">
        <style>
            /* ── Invoice shell ── */
            .pac-invoice-card {
                border-radius: 0.875rem;
                overflow: hidden;
            }
            .pac-invoice-header {
                background: #f8f9fa;
                border-bottom: 1px solid #e5e7eb;
                padding: 2rem;
            }

            /* ── Section headers ── */
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

            /* ── Line item rows ── */
            .pac-item-row {
                display: grid;
                grid-template-columns: 1fr 80px 140px 120px 36px;
                gap: 0.625rem;
                align-items: start;
                padding: 0.875rem 0;
                border-bottom: 1px solid #f3f4f6;
            }
            .pac-item-row:last-child { border-bottom: none; }
            .pac-item-row .col-label {
                font-size: 0.68rem;
                font-weight: 700;
                text-transform: uppercase;
                letter-spacing: 0.07em;
                color: #9ca3af;
                margin-bottom: 0.35rem;
            }
            .pac-item-total {
                font-size: 0.875rem;
                font-weight: 700;
                color: #111827;
                padding-top: 0.5rem;
                text-align: right;
            }
            .pac-remove-btn {
                width: 32px; height: 32px;
                border-radius: 6px;
                border: 1px solid #e5e7eb;
                background: #fff;
                display: flex;
                align-items: center;
                justify-content: center;
                cursor: pointer;
                color: #9ca3af;
                margin-top: 0.5rem;
                transition: border-color 0.15s, color 0.15s;
                flex-shrink: 0;
            }
            .pac-remove-btn:hover { border-color: #ef4444; color: #ef4444; }

            /* ── Summary block ── */
            .pac-summary {
                background: #f8f9fa;
                border-radius: 0.625rem;
                padding: 1.25rem 1.5rem;
                min-width: 280px;
            }
            .pac-summary-row {
                display: flex;
                justify-content: space-between;
                align-items: center;
                font-size: 0.83rem;
                padding: 0.3rem 0;
                color: #374151;
            }
            .pac-summary-row.total {
                font-size: 0.95rem;
                font-weight: 700;
                color: #111827;
                border-top: 1px solid #e5e7eb;
                margin-top: 0.5rem;
                padding-top: 0.75rem;
            }
            .pac-summary-row.deduction { color: #b91c1c; }
            .pac-summary-row.paid-row  { color: #15803d; }
            .pac-summary-row.outstanding-row {
                font-size: 1rem;
                font-weight: 800;
                color: #111827;
                border-top: 2px solid #111827;
                margin-top: 0.5rem;
                padding-top: 0.75rem;
            }

            /* ── Add item button ── */
            .pac-add-btn {
                display: inline-flex;
                align-items: center;
                gap: 6px;
                font-size: 0.78rem;
                font-weight: 600;
                color: #96aa12;
                border: 1px dashed rgba(181,204,24,0.45);
                border-radius: 0.4rem;
                padding: 0.45rem 1rem;
                background: rgba(181,204,24,0.04);
                cursor: pointer;
                transition: all 0.15s;
                margin-top: 0.75rem;
            }
            .pac-add-btn:hover {
                background: rgba(181,204,24,0.1);
                border-color: rgba(181,204,24,0.7);
            }

            /* ── Proposed section toggle ── */
            .pac-proposed-toggle {
                display: flex;
                align-items: center;
                gap: 0.75rem;
                padding: 1rem 1.5rem;
                background: rgba(181,204,24,0.04);
                border: 1px dashed rgba(181,204,24,0.3);
                border-radius: 0.625rem;
                cursor: pointer;
                transition: all 0.15s;
                margin-top: 1.5rem;
            }
            .pac-proposed-toggle:hover { background: rgba(181,204,24,0.08); }
            .pac-proposed-toggle-label {
                font-size: 0.83rem;
                font-weight: 600;
                color: #96aa12;
            }
            .pac-proposed-toggle-sub {
                font-size: 0.72rem;
                color: #9ca3af;
            }

            /* ── Tax panel ── */
            .pac-tax-panel {
                background: #f8f9fa;
                border: 1px solid #e5e7eb;
                border-radius: 0.625rem;
                padding: 1rem 1.25rem;
            }
            .pac-tax-row {
                display: grid;
                grid-template-columns: 1fr 1fr 1fr;
                gap: 0.75rem;
                margin-top: 0.75rem;
            }

            /* ── Actions sidebar ── */
            .pac-actions-card {
                position: sticky;
                top: 80px;
            }
            .pac-status-badge {
                font-size: 0.7rem;
                font-weight: 700;
                padding: 3px 10px;
                border-radius: 100px;
                letter-spacing: 0.04em;
            }
            .s-draft   { background: #f1f5f9; color: #64748b; }
            .s-sent    { background: rgba(59,130,246,0.1); color: #1d4ed8; }
            .s-partial { background: rgba(245,158,11,0.1); color: #b45309; }
            .s-paid    { background: rgba(34,197,94,0.1);  color: #15803d; }
            .s-overdue { background: rgba(239,68,68,0.1);  color: #b91c1c; }

            /* ── Mobile ── */
            @media (max-width: 767.98px) {
                .pac-item-row {
                    grid-template-columns: 1fr 1fr;
                    gap: 0.5rem;
                }
                .pac-item-row > *:first-child { grid-column: 1 / -1; }
                .pac-invoice-header { padding: 1.25rem; }
            }
        </style>
    @endpush

    <form method="POST"
          action="{{ route('admin.invoices.store') }}"
          id="pac-invoice-form">
        @csrf

        <div class="row g-4 invoice-add">

            {{-- ══════════════════════════════════════════════
                 MAIN INVOICE CARD (col 9)
            ═══════════════════════════════════════════════ --}}
            <div class="col-lg-9 col-12">
                <div class="card pac-invoice-card">

                    {{-- ── Header: Logo + Invoice # + Dates ── --}}
                    <div class="pac-invoice-header">
                        <div class="row align-items-start g-4">

                            {{-- Studio info --}}
                            <div class="col-md-7">
                                <div class="d-flex align-items-center gap-2 mb-3">
                                    <svg width="32" height="32" viewBox="0 0 101.5 101.5"
                                         fill="#b5cc18" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M0,0V92.7H92.7V0ZM44.13,85.55,25.84,68.33V48.91H44.13Zm0-40.42H25.84V24l18.29-4.59ZM66.44,63.74,48.15,66V48.91H66.44Zm0-18.61H48.15V26.91l18.29,2.87Z"/>
                                    </svg>
                                    <span style="font-size:1.1rem; font-weight:800; color:#111827; letter-spacing:-0.02em;">
                                        The Pacmedia
                                    </span>
                                </div>
                                <p class="mb-0" style="font-size:0.8rem; color:#6b7280;">Pacmedia Creatives</p>
                                <p class="mb-0" style="font-size:0.8rem; color:#6b7280;">Lagos, Nigeria</p>
                            </div>

                            {{-- Invoice # + dates --}}
                            <div class="col-md-5">
                                <div class="row g-2 align-items-center mb-2">
                                    <div class="col-5">
                                        <label class="form-label mb-0" style="font-size:0.78rem; font-weight:600; color:#374151;">
                                            Invoice #
                                        </label>
                                    </div>
                                    <div class="col-7">
                                        <div class="input-group input-group-sm">
                                            <span class="input-group-text" style="font-size:0.78rem;">P</span>
                                            <input type="text"
                                                   name="number"
                                                   class="form-control form-control-sm @error('number') is-invalid @enderror"
                                                   value="{{ old('number', substr($nextNumber, 1)) }}"
                                                   required>
                                        </div>
                                        @error('number')
                                        <div class="invalid-feedback d-block" style="font-size:0.7rem;">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row g-2 align-items-center mb-2">
                                    <div class="col-5">
                                        <label class="form-label mb-0" style="font-size:0.78rem; color:#374151;">Date Issued</label>
                                    </div>
                                    <div class="col-7">
                                        <input type="text"
                                               name="submitted_at"
                                               class="form-control form-control-sm invoice-date @error('submitted_at') is-invalid @enderror"
                                               value="{{ old('submitted_at', now()->format('Y-m-d')) }}"
                                               required>
                                    </div>
                                </div>
                                <div class="row g-2 align-items-center">
                                    <div class="col-5">
                                        <label class="form-label mb-0" style="font-size:0.78rem; color:#374151;">Due Date</label>
                                    </div>
                                    <div class="col-7">
                                        <input type="text"
                                               name="due_date"
                                               class="form-control form-control-sm @error('due_date') is-invalid @enderror"
                                               value="{{ old('due_date', 'Upon Receipt') }}"
                                               placeholder="Upon Receipt or date"
                                               required>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>

                    <div class="card-body px-4 py-4">

                        {{-- ── Invoice To + Payment Details ── --}}
                        <div class="row g-4 mb-4">

                            {{-- Invoice To --}}
                            <div class="col-md-6">
                                <div class="pac-section-label">Invoice To</div>
                                <select name="client_id"
                                        class="form-select form-select-sm mb-3 @error('client_id') is-invalid @enderror"
                                        id="client-select"
                                        required>
                                    <option value="">— Select Client —</option>
                                    @foreach($clients as $client)
                                        <option value="{{ $client->id }}"
                                                data-company="{{ $client->company }}"
                                                data-email="{{ $client->email }}"
                                                data-phone="{{ $client->phone }}"
                                            {{ old('client_id') == $client->id ? 'selected' : '' }}>
                                            {{ $client->display_name }}
                                        </option>
                                    @endforeach
                                </select>
                                {{-- Client preview (populated by JS) --}}
                                <div id="client-preview" style="font-size:0.8rem; color:#6b7280; display:none;">
                                    <p class="mb-0" id="cp-company" style="font-weight:600; color:#111827;"></p>
                                    <p class="mb-0" id="cp-email"></p>
                                    <p class="mb-0" id="cp-phone"></p>
                                </div>
                                <div class="mt-3">
                                    <label class="form-label" style="font-size:0.78rem; font-weight:600; color:#374151;">
                                        Project / Service
                                    </label>
                                    <input type="text"
                                           name="project_name"
                                           class="form-control form-control-sm"
                                           value="{{ old('project_name') }}"
                                           placeholder="e.g. Enamux Branding & Website">
                                </div>
                            </div>

                            {{-- Payment Details --}}
                            <div class="col-md-6">
                                <div class="pac-section-label">Payment Details</div>
                                <div class="mb-2">
                                    <input type="text"
                                           name="bank_name"
                                           class="form-control form-control-sm"
                                           value="{{ old('bank_name', 'First Bank of Nigeria') }}"
                                           placeholder="Bank Name">
                                </div>
                                <div class="mb-2">
                                    <input type="text"
                                           name="bank_account_name"
                                           class="form-control form-control-sm"
                                           value="{{ old('bank_account_name', 'Peter Adetola') }}"
                                           placeholder="Account Name">
                                </div>
                                <div>
                                    <input type="text"
                                           name="bank_account_number"
                                           class="form-control form-control-sm"
                                           value="{{ old('bank_account_number', '3077124451') }}"
                                           placeholder="Account Number">
                                </div>
                            </div>

                        </div>

                        <hr class="my-4">

                        {{-- ══════════════════════════════════
                             COMPLETED SERVICES
                        ═══════════════════════════════════ --}}
                        <div class="pac-section-label">Completed Services</div>

                        {{-- Column headers --}}
                        <div class="pac-item-row" style="border-bottom: 1px solid #e5e7eb; padding-bottom:0.5rem; margin-bottom:0;">
                            <div class="col-label">Description</div>
                            <div class="col-label text-center">Qty</div>
                            <div class="col-label text-end">Unit Price (₦)</div>
                            <div class="col-label text-end">Total (₦)</div>
                            <div></div>
                        </div>

                        {{-- Completed items container --}}
                        <div id="completed-items-container">
                            {{-- JS clones from template below --}}
                        </div>

                        <button type="button" class="pac-add-btn" id="add-completed-item">
                            <i class="ri ri-add-line"></i> Add Service
                        </button>

                        {{-- Completed summary --}}
                        <div class="row mt-4">
                            <div class="col-md-6">
                                <label class="form-label" style="font-size:0.78rem; font-weight:600; color:#374151;">
                                    Notes
                                </label>
                                <textarea name="completed_notes"
                                          class="form-control form-control-sm"
                                          rows="3"
                                          placeholder="e.g. Outstanding from Logo service is Business card design and Letterhead">{{ old('completed_notes') }}</textarea>
                            </div>
                            <div class="col-md-6 d-flex justify-content-end">
                                <div class="pac-summary w-100">
                                    <div class="pac-summary-row">
                                        <span>Subtotal</span>
                                        <span id="c-subtotal">₦0.00</span>
                                    </div>
                                    <div class="pac-summary-row" id="c-discount-row" style="display:none !important;">
                                        <span id="c-discount-label-display">Discount</span>
                                        <span class="text-danger" id="c-discount-display">-₦0.00</span>
                                    </div>
                                    <div class="pac-summary-row" id="c-tax-row" style="display:none !important;">
                                        <span id="c-tax-label-display">VAT</span>
                                        <span id="c-tax-display">₦0.00</span>
                                    </div>
                                    <div class="pac-summary-row paid-row" id="c-paid-row" style="display:none !important;">
                                        <span>Paid</span>
                                        <span id="c-paid-display">-₦0.00</span>
                                    </div>
                                    <div class="pac-summary-row" id="c-wht-row" style="display:none !important;">
                                        <span id="c-wht-label-display">WHT</span>
                                        <span class="text-danger" id="c-wht-display">-₦0.00</span>
                                    </div>
                                    <div class="pac-summary-row outstanding-row">
                                        <span>Outstanding</span>
                                        <span id="c-outstanding">₦0.00</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Completed discount + paid inputs (hidden, used in summary calc) --}}
                        <div class="row g-3 mt-2">
                            <div class="col-md-4">
                                <label class="form-label" style="font-size:0.75rem; font-weight:600; color:#374151;">
                                    Discount Label
                                </label>
                                <input type="text"
                                       name="completed_discount_label"
                                       id="completed_discount_label"
                                       class="form-control form-control-sm"
                                       value="{{ old('completed_discount_label') }}"
                                       placeholder="e.g. Early payment discount">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label" style="font-size:0.75rem; font-weight:600; color:#374151;">
                                    Discount Amount (₦)
                                </label>
                                <input type="number"
                                       name="completed_discount"
                                       id="completed_discount"
                                       class="form-control form-control-sm"
                                       value="{{ old('completed_discount', 0) }}"
                                       min="0" step="0.01">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label" style="font-size:0.75rem; font-weight:600; color:#374151;">
                                    Amount Paid (₦)
                                </label>
                                <input type="number"
                                       name="paid_amount"
                                       id="paid_amount"
                                       class="form-control form-control-sm"
                                       value="{{ old('paid_amount', 0) }}"
                                       min="0" step="0.01">
                            </div>
                        </div>

                        <hr class="my-4">

                        {{-- ══════════════════════════════════
                             TAX & WHT PANEL
                        ═══════════════════════════════════ --}}
                        <div class="pac-tax-panel mb-4">
                            <div class="d-flex align-items-center justify-content-between">
                                <span style="font-size:0.82rem; font-weight:600; color:#374151;">
                                    Tax & Withholding
                                </span>
                                <div class="d-flex gap-3">
                                    <div class="form-check form-switch mb-0">
                                        <input class="form-check-input" type="checkbox"
                                               name="tax_enabled" id="tax_enabled"
                                               value="1" {{ old('tax_enabled') ? 'checked' : '' }}>
                                        <label class="form-check-label" for="tax_enabled"
                                               style="font-size:0.78rem;">Apply Tax</label>
                                    </div>
                                    <div class="form-check form-switch mb-0">
                                        <input class="form-check-input" type="checkbox"
                                               name="wht_enabled" id="wht_enabled"
                                               value="1" {{ old('wht_enabled') ? 'checked' : '' }}>
                                        <label class="form-check-label" for="wht_enabled"
                                               style="font-size:0.78rem;">Client deducts WHT</label>
                                    </div>
                                </div>
                            </div>

                            {{-- Tax fields --}}
                            <div id="tax-fields" style="display:none;">
                                <div class="pac-tax-row mt-3">
                                    <div>
                                        <label class="form-label" style="font-size:0.72rem; font-weight:600; color:#374151;">Label</label>
                                        <input type="text" name="tax_label" id="tax_label"
                                               class="form-control form-control-sm"
                                               value="{{ old('tax_label', 'VAT') }}">
                                    </div>
                                    <div>
                                        <label class="form-label" style="font-size:0.72rem; font-weight:600; color:#374151;">Rate (%)</label>
                                        <input type="number" name="tax_rate" id="tax_rate"
                                               class="form-control form-control-sm"
                                               value="{{ old('tax_rate', '7.50') }}"
                                               min="0" max="100" step="0.01">
                                    </div>
                                    <div>
                                        <label class="form-label" style="font-size:0.72rem; font-weight:600; color:#374151;">Applies to</label>
                                        <select name="tax_applies_to" id="tax_applies_to"
                                                class="form-select form-select-sm">
                                            <option value="completed" {{ old('tax_applies_to','completed') === 'completed' ? 'selected' : '' }}>Completed only</option>
                                            <option value="proposed"  {{ old('tax_applies_to') === 'proposed'  ? 'selected' : '' }}>Proposed only</option>
                                            <option value="both"      {{ old('tax_applies_to') === 'both'      ? 'selected' : '' }}>Both</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            {{-- WHT fields --}}
                            <div id="wht-fields" style="display:none;">
                                <div class="pac-tax-row mt-3">
                                    <div>
                                        <label class="form-label" style="font-size:0.72rem; font-weight:600; color:#374151;">WHT Label</label>
                                        <input type="text" name="wht_label" id="wht_label"
                                               class="form-control form-control-sm"
                                               value="{{ old('wht_label', 'WHT (5%)') }}">
                                    </div>
                                    <div>
                                        <label class="form-label" style="font-size:0.72rem; font-weight:600; color:#374151;">WHT Rate (%)</label>
                                        <input type="number" name="wht_rate" id="wht_rate"
                                               class="form-control form-control-sm"
                                               value="{{ old('wht_rate', '5.00') }}"
                                               min="0" max="100" step="0.01">
                                    </div>
                                    <div></div>
                                </div>
                            </div>
                        </div>

                        {{-- ══════════════════════════════════
                             PROPOSED SERVICES (toggle)
                        ═══════════════════════════════════ --}}
                        <input type="hidden" name="has_proposed" id="has_proposed" value="0">

                        <div class="pac-proposed-toggle" id="proposed-toggle">
                            <div style="width:36px; height:36px; border-radius:8px; background:rgba(181,204,24,0.12); display:flex; align-items:center; justify-content:center;">
                                <i class="ri ri-add-line" style="color:#96aa12; font-size:1.1rem;"></i>
                            </div>
                            <div>
                                <div class="pac-proposed-toggle-label">Add Proposed Services</div>
                                <div class="pac-proposed-toggle-sub">Optional — quote additional work on the same invoice</div>
                            </div>
                        </div>

                        {{-- Proposed section (hidden until toggled) --}}
                        <div id="proposed-section" style="display:none; margin-top:1.5rem;">
                            <div class="d-flex align-items-center justify-content-between mb-3">
                                <div class="pac-section-label" style="flex:1;">Proposed Services</div>
                                <button type="button" id="remove-proposed"
                                        style="font-size:0.72rem; color:#9ca3af; border:none; background:none; cursor:pointer; padding:0 0 0 1rem;">
                                    Remove section
                                </button>
                            </div>

                            {{-- Column headers --}}
                            <div class="pac-item-row" style="border-bottom: 1px solid #e5e7eb; padding-bottom:0.5rem; margin-bottom:0;">
                                <div class="col-label">Description</div>
                                <div class="col-label text-center">Qty</div>
                                <div class="col-label text-end">Unit Price (₦)</div>
                                <div class="col-label text-end">Total (₦)</div>
                                <div></div>
                            </div>

                            <div id="proposed-items-container"></div>

                            <button type="button" class="pac-add-btn" id="add-proposed-item">
                                <i class="ri ri-add-line"></i> Add Proposed Service
                            </button>

                            {{-- Proposed summary --}}
                            <div class="row mt-4">
                                <div class="col-md-6">
                                    <label class="form-label" style="font-size:0.78rem; font-weight:600; color:#374151;">
                                        Proposed Notes
                                    </label>
                                    <textarea name="proposed_notes"
                                              class="form-control form-control-sm"
                                              rows="2"
                                              placeholder="e.g. Prices valid for 30 days">{{ old('proposed_notes') }}</textarea>
                                </div>
                                <div class="col-md-6 d-flex justify-content-end">
                                    <div class="pac-summary w-100">
                                        <div class="pac-summary-row">
                                            <span>Subtotal</span>
                                            <span id="p-subtotal">₦0.00</span>
                                        </div>
                                        <div class="pac-summary-row" id="p-discount-row" style="display:none !important;">
                                            <span id="p-discount-label-display">Discount</span>
                                            <span class="text-danger" id="p-discount-display">-₦0.00</span>
                                        </div>
                                        <div class="pac-summary-row" id="p-tax-row" style="display:none !important;">
                                            <span id="p-tax-label-display">VAT</span>
                                            <span id="p-tax-display">₦0.00</span>
                                        </div>
                                        <div class="pac-summary-row total">
                                            <span>Total</span>
                                            <span id="p-total">₦0.00</span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- Proposed discount --}}
                            <div class="row g-3 mt-2">
                                <div class="col-md-6">
                                    <label class="form-label" style="font-size:0.75rem; font-weight:600; color:#374151;">
                                        Discount Label
                                    </label>
                                    <input type="text"
                                           name="proposed_discount_label"
                                           id="proposed_discount_label"
                                           class="form-control form-control-sm"
                                           value="{{ old('proposed_discount_label') }}"
                                           placeholder="e.g. AI Automation Bundle Discount">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label" style="font-size:0.75rem; font-weight:600; color:#374151;">
                                        Discount Amount (₦)
                                    </label>
                                    <input type="number"
                                           name="proposed_discount"
                                           id="proposed_discount"
                                           class="form-control form-control-sm"
                                           value="{{ old('proposed_discount', 0) }}"
                                           min="0" step="0.01">
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

            {{-- ══════════════════════════════════════════════
                 ACTIONS SIDEBAR (col 3)
            ═══════════════════════════════════════════════ --}}
            <div class="col-lg-3 col-12">
                <div class="pac-actions-card">

                    {{-- Save / Preview actions --}}
                    <div class="card mb-4" style="border-radius:0.75rem;">
                        <div class="card-body">
                            <button type="submit"
                                    name="status_action"
                                    value="draft"
                                    class="btn d-grid w-100 mb-3"
                                    style="background:#111827; color:#fff; border-radius:0.4rem; font-size:0.82rem; font-weight:600;">
                                <span class="d-flex align-items-center justify-content-center gap-2">
                                    <i class="ri ri-save-line"></i> Save as Draft
                                </span>
                            </button>
                            <button type="submit"
                                    name="status_action"
                                    value="sent"
                                    class="btn btn-primary d-grid w-100 mb-3"
                                    style="border-radius:0.4rem; font-size:0.82rem; font-weight:600;">
                                <span class="d-flex align-items-center justify-content-center gap-2">
                                    <i class="ri ri-send-plane-line"></i> Save & Send
                                </span>
                            </button>
                            <input type="hidden" name="status" id="form-status" value="draft">
                        </div>
                    </div>

                    {{-- Status selector --}}
                    <div class="card mb-4" style="border-radius:0.75rem;">
                        <div class="card-body">
                            <label class="form-label" style="font-size:0.78rem; font-weight:600; color:#374151;">
                                Status
                            </label>
                            <select name="status" class="form-select form-select-sm" id="status-select">
                                @foreach(['draft','sent','partial','paid','overdue'] as $s)
                                    <option value="{{ $s }}" {{ old('status','draft') === $s ? 'selected' : '' }}>
                                        {{ ucfirst($s) }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    {{-- Invoice summary totals --}}
                    <div class="card" style="border-radius:0.75rem;">
                        <div class="card-body">
                            <div class="pac-section-label">Summary</div>
                            <div class="d-flex justify-content-between mb-2" style="font-size:0.8rem;">
                                <span style="color:#6b7280;">Completed</span>
                                <span style="font-weight:600;" id="sidebar-completed">₦0.00</span>
                            </div>
                            <div class="d-flex justify-content-between mb-2" style="font-size:0.8rem;" id="sidebar-proposed-row" style="display:none !important;">
                                <span style="color:#6b7280;">Proposed</span>
                                <span style="font-weight:600;" id="sidebar-proposed">₦0.00</span>
                            </div>
                            <div class="d-flex justify-content-between mb-2" style="font-size:0.8rem;" id="sidebar-paid-row" style="display:none !important;">
                                <span style="color:#15803d;">Paid</span>
                                <span style="font-weight:600; color:#15803d;" id="sidebar-paid">-₦0.00</span>
                            </div>
                            <hr style="margin: 0.5rem 0;">
                            <div class="d-flex justify-content-between" style="font-size:0.9rem; font-weight:800; color:#111827;">
                                <span>Outstanding</span>
                                <span id="sidebar-outstanding">₦0.00</span>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

        </div>
    </form>

    {{-- ── Item row template (hidden, cloned by JS) ── --}}
    <template id="item-row-template">
        <div class="pac-item-row" data-item-row>
            <div>
                <input type="text"
                       class="form-control form-control-sm item-description"
                       placeholder="Service description"
                       required>
            </div>
            <div>
                <input type="number"
                       class="form-control form-control-sm item-qty"
                       value="1" min="1" step="1" required>
            </div>
            <div>
                <input type="number"
                       class="form-control form-control-sm item-price"
                       placeholder="0.00" min="0" step="0.01" required>
            </div>
            <div class="pac-item-total item-total text-end">₦0.00</div>
            <div>
                <button type="button" class="pac-remove-btn remove-item">
                    <i class="ri ri-close-line" style="font-size:0.9rem;"></i>
                </button>
            </div>
        </div>
    </template>

    @push('page-js')
        <script src="{{ asset('admin/assets/vendor/libs/flatpickr/flatpickr.js') }}"></script>
        <script>
            (function () {

                /* ══════════════════════════════════════════════
                   HELPERS
                ══════════════════════════════════════════════ */
                const fmt = n => '₦' + parseFloat(n || 0).toLocaleString('en-NG', {
                    minimumFractionDigits: 2, maximumFractionDigits: 2
                });

                const num = el => parseFloat(el?.value || 0) || 0;

                const show = (el, visible) => {
                    if (el) el.style.setProperty('display', visible ? 'flex' : 'none', 'important');
                };

                /* ══════════════════════════════════════════════
                   FLATPICKR
                ══════════════════════════════════════════════ */
                flatpickr('.invoice-date', { dateFormat: 'Y-m-d', monthSelectorType: 'static' });

                /* ══════════════════════════════════════════════
                   CLIENT PREVIEW
                ══════════════════════════════════════════════ */
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

                /* ══════════════════════════════════════════════
                   LINE ITEM ENGINE
                ══════════════════════════════════════════════ */
                const template = document.getElementById('item-row-template');

                function addItem(containerId, section) {
                    const container = document.getElementById(containerId);
                    const idx       = container.querySelectorAll('[data-item-row]').length;
                    const clone     = template.content.cloneNode(true);
                    const row       = clone.querySelector('[data-item-row]');

                    /* Wire input names */
                    row.querySelector('.item-description').name = `${section}_items[${idx}][description]`;
                    row.querySelector('.item-qty').name         = `${section}_items[${idx}][qty]`;
                    row.querySelector('.item-price').name       = `${section}_items[${idx}][unit_price]`;

                    /* Live row total */
                    const updateRowTotal = () => {
                        const qty   = num(row.querySelector('.item-qty'));
                        const price = num(row.querySelector('.item-price'));
                        row.querySelector('.item-total').textContent = fmt(qty * price);
                        recalc();
                    };
                    row.querySelector('.item-qty').addEventListener('input',   updateRowTotal);
                    row.querySelector('.item-price').addEventListener('input', updateRowTotal);

                    /* Remove */
                    row.querySelector('.remove-item').addEventListener('click', () => {
                        row.remove();
                        reindexItems(containerId, section);
                        recalc();
                    });

                    container.appendChild(clone);
                }

                function reindexItems(containerId, section) {
                    document.querySelectorAll(`#${containerId} [data-item-row]`).forEach((row, i) => {
                        row.querySelector('.item-description').name = `${section}_items[${i}][description]`;
                        row.querySelector('.item-qty').name         = `${section}_items[${i}][qty]`;
                        row.querySelector('.item-price').name       = `${section}_items[${i}][unit_price]`;
                    });
                }

                document.getElementById('add-completed-item').addEventListener('click', () => {
                    addItem('completed-items-container', 'completed');
                });
                document.getElementById('add-proposed-item').addEventListener('click', () => {
                    addItem('proposed-items-container', 'proposed');
                });

                /* ══════════════════════════════════════════════
                   RECALCULATE SUMMARIES
                ══════════════════════════════════════════════ */
                function sectionSubtotal(containerId) {
                    let total = 0;
                    document.querySelectorAll(`#${containerId} [data-item-row]`).forEach(row => {
                        total += num(row.querySelector('.item-qty')) * num(row.querySelector('.item-price'));
                    });
                    return total;
                }

                function recalc() {
                    const taxEnabled  = document.getElementById('tax_enabled').checked;
                    const whtEnabled  = document.getElementById('wht_enabled').checked;
                    const taxRate     = num(document.getElementById('tax_rate'))  / 100;
                    const whtRate     = num(document.getElementById('wht_rate'))  / 100;
                    const taxApplies  = document.getElementById('tax_applies_to')?.value || 'completed';
                    const taxLabel    = document.getElementById('tax_label')?.value || 'VAT';
                    const whtLabel    = document.getElementById('wht_label')?.value || 'WHT';
                    const cDiscount   = num(document.getElementById('completed_discount'));
                    const pDiscount   = num(document.getElementById('proposed_discount'));
                    const paid        = num(document.getElementById('paid_amount'));
                    const cDiscLabel  = document.getElementById('completed_discount_label')?.value || 'Discount';
                    const pDiscLabel  = document.getElementById('proposed_discount_label')?.value  || 'Discount';

                    /* ── Completed ── */
                    const cSub  = sectionSubtotal('completed-items-container');
                    const cTax  = taxEnabled && ['completed','both'].includes(taxApplies) ? cSub * taxRate : 0;
                    const cWht  = whtEnabled ? cSub * whtRate : 0;
                    const cOut  = cSub + cTax - cDiscount - paid - cWht;

                    document.getElementById('c-subtotal').textContent = fmt(cSub);

                    show(document.getElementById('c-discount-row'), cDiscount > 0);
                    document.getElementById('c-discount-label-display').textContent = cDiscLabel;
                    document.getElementById('c-discount-display').textContent = '-' + fmt(cDiscount);

                    show(document.getElementById('c-tax-row'), taxEnabled && ['completed','both'].includes(taxApplies));
                    document.getElementById('c-tax-label-display').textContent = taxLabel;
                    document.getElementById('c-tax-display').textContent = fmt(cTax);

                    show(document.getElementById('c-paid-row'), paid > 0);
                    document.getElementById('c-paid-display').textContent = '-' + fmt(paid);

                    show(document.getElementById('c-wht-row'), whtEnabled);
                    document.getElementById('c-wht-label-display').textContent = whtLabel;
                    document.getElementById('c-wht-display').textContent = '-' + fmt(cWht);

                    document.getElementById('c-outstanding').textContent = fmt(cOut);

                    /* ── Proposed ── */
                    const pSub  = sectionSubtotal('proposed-items-container');
                    const pTax  = taxEnabled && ['proposed','both'].includes(taxApplies) ? pSub * taxRate : 0;
                    const pTot  = pSub + pTax - pDiscount;

                    document.getElementById('p-subtotal').textContent = fmt(pSub);

                    show(document.getElementById('p-discount-row'), pDiscount > 0);
                    document.getElementById('p-discount-label-display').textContent = pDiscLabel;
                    document.getElementById('p-discount-display').textContent = '-' + fmt(pDiscount);

                    show(document.getElementById('p-tax-row'), taxEnabled && ['proposed','both'].includes(taxApplies));
                    document.getElementById('p-tax-label-display').textContent = taxLabel;
                    document.getElementById('p-tax-display').textContent = fmt(pTax);

                    document.getElementById('p-total').textContent = fmt(pTot);

                    /* ── Sidebar ── */
                    document.getElementById('sidebar-completed').textContent   = fmt(cSub);
                    document.getElementById('sidebar-proposed').textContent    = fmt(pTot);
                    document.getElementById('sidebar-paid').textContent        = '-' + fmt(paid);
                    document.getElementById('sidebar-outstanding').textContent = fmt(cOut);

                    const proposedVisible = document.getElementById('has_proposed').value === '1';
                    show(document.getElementById('sidebar-proposed-row'), proposedVisible && pSub > 0);
                    show(document.getElementById('sidebar-paid-row'), paid > 0);
                }

                /* ══════════════════════════════════════════════
                   TAX / WHT TOGGLES
                ══════════════════════════════════════════════ */
                document.getElementById('tax_enabled').addEventListener('change', function () {
                    document.getElementById('tax-fields').style.display = this.checked ? 'block' : 'none';
                    recalc();
                });
                document.getElementById('wht_enabled').addEventListener('change', function () {
                    document.getElementById('wht-fields').style.display = this.checked ? 'block' : 'none';
                    recalc();
                });

                /* Live recalc on tax inputs */
                ['tax_rate','tax_label','tax_applies_to','wht_rate','wht_label',
                    'completed_discount','proposed_discount','paid_amount',
                    'completed_discount_label','proposed_discount_label'].forEach(id => {
                    const el = document.getElementById(id);
                    if (el) el.addEventListener('input', recalc);
                    if (el) el.addEventListener('change', recalc);
                });

                /* ══════════════════════════════════════════════
                   PROPOSED SECTION TOGGLE
                ══════════════════════════════════════════════ */
                document.getElementById('proposed-toggle').addEventListener('click', () => {
                    document.getElementById('proposed-section').style.display = 'block';
                    document.getElementById('proposed-toggle').style.display  = 'none';
                    document.getElementById('has_proposed').value = '1';
                    addItem('proposed-items-container', 'proposed');
                    recalc();
                });

                document.getElementById('remove-proposed').addEventListener('click', () => {
                    document.getElementById('proposed-section').style.display = 'none';
                    document.getElementById('proposed-toggle').style.display  = 'flex';
                    document.getElementById('has_proposed').value = '0';
                    document.getElementById('proposed-items-container').innerHTML = '';
                    recalc();
                });

                /* ══════════════════════════════════════════════
                   FORM SUBMIT — wire status from button click
                ══════════════════════════════════════════════ */
                document.querySelectorAll('button[name="status_action"]').forEach(btn => {
                    btn.addEventListener('click', function () {
                        document.getElementById('form-status').value = this.value;
                    });
                });

                /* ══════════════════════════════════════════════
                   INIT — add one blank completed item on load
                ══════════════════════════════════════════════ */
                addItem('completed-items-container', 'completed');
                recalc();

            })();
        </script>
    @endpush

</x-admin-layout>
