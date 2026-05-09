<x-admin-layout :title="$client->name . ' — Client'">

    @push('page-css')
    <style>

        /* ── Hero card inner layout ──────────────────────────────────────── */
        .client-hero {
            display: grid;
            grid-template-columns: auto 1fr;
            grid-template-rows: auto auto;
            gap: 1.25rem 1.75rem;
        }

        /* Left column: avatar + stat chips */
        .client-hero__left {
            display: flex;
            flex-direction: column;
            gap: 0.625rem;
            align-items: flex-start;
        }

        /* Stat chip — the small "Client Since / Apr 2026" boxes */
        .stat-chip {
            display: flex;
            align-items: center;
            gap: 0.625rem;
            padding: 0.45rem 0.75rem;
            border-radius: var(--bs-border-radius);
            border: 1px solid color-mix(in sRGB, var(--bs-base-color) 12%, var(--bs-paper-bg));
            background: color-mix(in sRGB, var(--bs-base-color) 3%, var(--bs-paper-bg));
            min-width: 130px;
        }

        .stat-chip__icon {
            width: 32px;
            height: 32px;
            border-radius: var(--bs-border-radius);
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            font-size: 1rem;
        }

        .stat-chip__label {
            font-size: 0.625rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.08em;
            color: var(--bs-secondary-color);
            line-height: 1;
            margin-bottom: 3px;
        }

        .stat-chip__value {
            font-size: 0.875rem;
            font-weight: 700;
            color: var(--bs-heading-color);
            line-height: 1;
        }

        /* Right column: field grid */
        .client-hero__fields {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 0.875rem 2rem;
            align-content: start;
        }

        .client-hero__field-label {
            font-size: 0.65rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.08em;
            color: var(--bs-secondary-color);
            margin-bottom: 3px;
            line-height: 1;
        }

        .client-hero__field-value {
            font-size: 0.875rem;
            font-weight: 500;
            color: var(--bs-heading-color);
            line-height: 1.35;
            margin: 0;
        }

        .client-hero__field-value a {
            color: var(--bs-primary);
            text-decoration: none;
        }

        .client-hero__field-value a:hover {
            text-decoration: underline;
        }

        /* Bottom row: action buttons — spans both columns, right-aligned */
        .client-hero__actions {
            grid-column: 1 / -1;
            display: flex;
            justify-content: flex-end;
            gap: 0.5rem;
            padding-top: 0.75rem;
            border-top: 1px solid color-mix(in sRGB, var(--bs-base-color) 10%, var(--bs-paper-bg));
        }

        /* ── Financial summary ───────────────────────────────────────────── */
        .fin-line {
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-size: 0.875rem;
            padding: 0.4rem 0;
        }

        .fin-line--outstanding {
            margin-top: 0.625rem;
            padding-top: 0.875rem;
            border-top: 1px solid color-mix(in sRGB, var(--bs-base-color) 12%, var(--bs-paper-bg));
            font-weight: 700;
            font-size: 0.9375rem;
        }

        /* ── Invoice table ───────────────────────────────────────────────── */
        #clientInvoicesTable thead th {
            font-size: 0.65rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.09em;
            color: var(--bs-secondary-color);
            white-space: nowrap;
            padding-top: 0.875rem;
            padding-bottom: 0.875rem;
            background: color-mix(in sRGB, var(--bs-base-color) 2%, var(--bs-paper-bg));
        }

        #clientInvoicesTable tbody td {
            padding-top: 1.125rem;
            padding-bottom: 1.125rem;
            vertical-align: middle;
        }

        #clientInvoicesTable tbody tr:last-child td {
            border-bottom: 0;
        }

        .inv-number {
            font-weight: 600;
            font-size: 0.875rem;
            color: var(--bs-primary);
            text-decoration: none;
            white-space: nowrap;
        }

        .inv-number:hover { text-decoration: underline; color: var(--bs-primary); }

        .inv-amount {
            font-weight: 600;
            font-size: 0.875rem;
            white-space: nowrap;
        }

        /* Icon-only action buttons — two separate, matching the mockup */
        .tbl-action {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 2rem;
            height: 2rem;
            border-radius: var(--bs-border-radius);
            border: 1px solid color-mix(in sRGB, var(--bs-base-color) 15%, var(--bs-paper-bg));
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
            padding: 3.5rem 1rem;
            text-align: center;
            color: var(--bs-secondary-color);
        }

        .inv-empty i {
            display: block;
            font-size: 2rem;
            margin-bottom: 0.5rem;
            opacity: 0.4;
        }

        /* ── Responsive ──────────────────────────────────────────────────── */
        @media (max-width: 767px) {
            .client-hero {
                grid-template-columns: 1fr;
            }
            .client-hero__left {
                flex-direction: row;
                flex-wrap: wrap;
                align-items: center;
            }
            .client-hero__actions {
                justify-content: stretch;
            }
            .client-hero__actions .btn {
                flex: 1;
                justify-content: center;
            }
        }

        @media (max-width: 479px) {
            .client-hero__fields {
                grid-template-columns: 1fr;
            }
        }
    </style>
    @endpush

    {{-- ══════════════════════════════════════════════════════════════════ --}}
    {{-- Row 1: Hero card + Financial summary                              --}}
    {{-- ══════════════════════════════════════════════════════════════════ --}}
    <div class="row g-4 mb-4">

        {{-- ── Hero card ─────────────────────────────────────────────────── --}}
        <div class="{{ count($currencyTotals) > 0 ? 'col-xl-8 col-lg-7' : 'col-12' }}">
            <div class="card h-100">
                <div class="card-body">
                    <div class="client-hero">

                        {{-- Left: avatar + stat chips --}}
                        <div class="client-hero__left">

                            <div class="avatar avatar-xl">
                                <div class="avatar-initial bg-label-primary rounded-3 fs-3 fw-bold">
                                    {{ strtoupper(substr($client->name, 0, 2)) }}
                                </div>
                            </div>

                            <div class="stat-chip">
                                <div class="stat-chip__icon bg-label-success">
                                    <i class="ri ri-calendar-check-line"></i>
                                </div>
                                <div>
                                    <p class="stat-chip__label mb-0">Client since</p>
                                    <p class="stat-chip__value mb-0">{{ $client->created_at->format('M Y') }}</p>
                                </div>
                            </div>

                            <div class="stat-chip">
                                <div class="stat-chip__icon bg-label-primary">
                                    <i class="ri ri-file-text-line"></i>
                                </div>
                                <div>
                                    <p class="stat-chip__label mb-0">Invoices</p>
                                    <p class="stat-chip__value mb-0">{{ $invoices->count() }}</p>
                                </div>
                            </div>

                        </div>
                        {{-- /Left --}}

                        {{-- Right: field grid --}}
                        <div class="client-hero__fields">

                            <div>
                                <p class="client-hero__field-label">Full name</p>
                                <p class="client-hero__field-value">{{ $client->name }}</p>
                            </div>

                            <div>
                                <p class="client-hero__field-label">Email</p>
                                <p class="client-hero__field-value">
                                    <a href="mailto:{{ $client->email }}">{{ $client->email }}</a>
                                </p>
                            </div>

                            @if ($client->phone)
                            <div>
                                <p class="client-hero__field-label">Phone</p>
                                <p class="client-hero__field-value">{{ $client->phone }}</p>
                            </div>
                            @endif

                            @if ($client->company)
                            <div>
                                <p class="client-hero__field-label">Company</p>
                                <p class="client-hero__field-value">{{ $client->company }}</p>
                            </div>
                            @endif

                            <div>
                                <p class="client-hero__field-label">Status</p>
                                <p class="client-hero__field-value">
                                    @if ($client->active)
                                    <span class="badge bg-label-success rounded-pill">Active</span>
                                    @else
                                    <span class="badge bg-label-warning rounded-pill">Inactive</span>
                                    @endif
                                    @if ($client->deleted_at)
                                    <span class="badge bg-label-danger rounded-pill ms-1">Archived</span>
                                    @endif
                                </p>
                            </div>

                            <div>
                                <p class="client-hero__field-label">Client since</p>
                                <p class="client-hero__field-value">{{ $client->created_at->format('d M, Y') }}</p>
                            </div>

                            @if ($client->address)
                            <div style="grid-column: 1 / -1;">
                                <p class="client-hero__field-label">Address</p>
                                <p class="client-hero__field-value">{{ $client->address }}</p>
                            </div>
                            @endif

                        </div>
                        {{-- /Field grid --}}

                        {{-- Actions row — spans full width, pinned to bottom --}}
                        <div class="client-hero__actions">
                            <button
                                class="btn btn-primary btn-edit-client"
                                data-id="{{ $client->id }}"
                                data-name="{{ $client->name }}"
                                data-email="{{ $client->email }}"
                                data-phone="{{ $client->phone }}"
                                data-company="{{ $client->company }}"
                                data-address="{{ $client->address }}"
                                data-active="{{ $client->active ? 1 : 0 }}"
                                data-bs-toggle="offcanvas"
                                data-bs-target="#offcanvasEditClient">
                                <i class="ri ri-edit-line me-1"></i> Edit
                            </button>
                            @if (!$client->deleted_at)
                            <button class="btn btn-outline-danger btn-archive-client" data-id="{{ $client->id }}">
                                <i class="ri ri-archive-line me-1"></i> Archive
                            </button>
                            @else
                            <button class="btn btn-outline-success btn-restore-client" data-id="{{ $client->id }}">
                                <i class="ri ri-arrow-go-back-line me-1"></i> Restore
                            </button>
                            @endif
                        </div>

                    </div>{{-- /client-hero --}}
                </div>
            </div>
        </div>
        {{-- /Hero card --}}

        {{-- ── Financial summary ─────────────────────────────────────────── --}}
        @if (count($currencyTotals) > 0)
        <div class="col-xl-4 col-lg-5">
            <div class="card h-100">
                <div class="card-header border-0 pb-0">
                    <h5 class="card-title mb-0">Financial summary</h5>
                </div>
                <div class="card-body pt-3">
                    @foreach ($currencyTotals as $code => $totals)
                    <div class="{{ !$loop->last ? 'mb-5 pb-5 border-bottom' : '' }}">

                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <span class="fw-semibold text-heading" style="font-size:.8125rem;">{{ $code }}</span>
                            <span class="badge bg-label-secondary rounded-pill">{{ $code }}</span>
                        </div>

                        <div class="fin-line">
                            <span class="text-body-secondary">Total invoiced</span>
                            <span class="fw-medium text-heading">{{ $totals['symbol'] }} {{ number_format($totals['invoiced'], 2) }}</span>
                        </div>

                        <div class="fin-line">
                            <span class="text-body-secondary">Amount paid</span>
                            <span class="fw-medium text-success">{{ $totals['symbol'] }} {{ number_format($totals['paid'], 2) }}</span>
                        </div>

                        <div class="fin-line fin-line--outstanding">
                            <span class="text-heading">Outstanding</span>
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
    <div class="card">

        <div class="card-header d-flex justify-content-between align-items-center flex-wrap gap-2 py-4">
            <div>
                <h5 class="card-title mb-0">Invoices</h5>
                @if ($invoices->count() > 0)
                <small class="text-body-secondary">
                    {{ $invoices->count() }} {{ Str::plural('invoice', $invoices->count()) }}
                    &middot;
                    {{ count($currencyTotals) }} {{ Str::plural('currency', count($currencyTotals)) }}
                </small>
                @endif
            </div>
            <a href="{{ route('admin.invoices.create', ['client_id' => $client->id]) }}" class="btn btn-primary">
                <i class="ri ri-add-line me-1"></i> New invoice
            </a>
        </div>

        <div class="table-responsive">
            <table class="table table-hover mb-0" id="clientInvoicesTable">
                <thead>
                <tr>
                    <th style="width:150px;">#</th>
                    <th>Project</th>
                    <th style="width:105px;">Currency</th>
                    <th style="width:110px;">Status</th>
                    <th style="width:130px;">Issued</th>
                    <th style="width:150px;">Outstanding</th>
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
                    <td style="font-size:.875rem;">{{ $invoice->project_name ?? '—' }}</td>
                    <td>
                        <span class="badge bg-label-secondary rounded-pill">{{ $invoice->currency ?? 'USD' }}</span>
                    </td>
                    <td>
                        <span class="badge {{ $badgeClass }} rounded-pill text-capitalize">{{ $invoice->status }}</span>
                    </td>
                    <td style="font-size:.875rem; color:var(--bs-secondary-color); white-space:nowrap;">
                        {{ $invoice->submitted_at ? $invoice->submitted_at->format('d M, Y') : '—' }}
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
                            <i class="ri ri-file-text-line"></i>
                            No invoices found for this client.
                        </div>
                    </td>
                </tr>
                @endforelse
                </tbody>
            </table>
        </div>

    </div>
    {{-- /Row 2 --}}

    {{-- ══════════════════════════════════════════════════════════════════ --}}
    {{-- Offcanvas — Edit client                                           --}}
    {{-- ══════════════════════════════════════════════════════════════════ --}}
    <div class="offcanvas offcanvas-end" tabindex="-1"
         id="offcanvasEditClient" aria-labelledby="offcanvasEditClientLabel">

        <div class="offcanvas-header border-bottom">
            <h5 id="offcanvasEditClientLabel" class="offcanvas-title">Edit client</h5>
            <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>

        <div class="offcanvas-body mx-0 flex-grow-0 h-100">
            <form id="editClientForm" onsubmit="return false">
                @csrf
                <input type="hidden" id="editClientId" name="clientId" value="{{ $client->id }}" />

                <div class="form-floating form-floating-outline mb-5">
                    <input type="text" class="form-control" id="editClientName" name="name"
                           value="{{ $client->name }}" placeholder="Acme Corp" required />
                    <label for="editClientName">Full name</label>
                </div>

                <div class="form-floating form-floating-outline mb-5">
                    <input type="email" class="form-control" id="editClientEmail" name="email"
                           value="{{ $client->email }}" placeholder="hello@acme.com" required />
                    <label for="editClientEmail">Email</label>
                </div>

                <div class="form-floating form-floating-outline mb-5">
                    <input type="text" class="form-control" id="editClientPhone" name="phone"
                           value="{{ $client->phone }}" placeholder="+1 (555) 000-0000" />
                    <label for="editClientPhone">Phone</label>
                </div>

                <div class="form-floating form-floating-outline mb-5">
                    <input type="text" class="form-control" id="editClientCompany" name="company"
                           value="{{ $client->company }}" placeholder="Acme Corporation" />
                    <label for="editClientCompany">Company</label>
                </div>

                <div class="form-floating form-floating-outline mb-5">
                    <textarea class="form-control" id="editClientAddress" name="address"
                              placeholder="123 Main St" style="height:100px">{{ $client->address }}</textarea>
                    <label for="editClientAddress">Address</label>
                </div>

                <div class="mb-5">
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" id="editClientActive" name="active"
                               {{ $client->active ? 'checked' : '' }} />
                        <label class="form-check-label text-heading" for="editClientActive">Active</label>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary me-sm-3 me-1">Update</button>
                <button type="button" class="btn btn-outline-danger" data-bs-dismiss="offcanvas">Cancel</button>
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
                                input.closest('.form-floating, .mb-5').append(
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
