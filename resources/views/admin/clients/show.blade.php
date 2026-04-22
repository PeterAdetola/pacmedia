<x-admin-layout :title="$client->name . ' — Client'">

    <div class="row">

        {{-- ── Left Sidebar ─────────────────────────────────────────────── --}}
        <div class="col-xl-4 col-lg-5 col-md-5 order-1 order-md-0">

            {{-- Client Card --}}
            <div class="card mb-6">
                <div class="card-body pt-12">

                    {{-- Avatar / Name / Status --}}
                    <div class="user-avatar-section mb-6">
                        <div class="d-flex align-items-center flex-column">
                            <div class="avatar avatar-xl mb-4">
                                <div class="avatar-initial bg-label-primary rounded-3 fs-2">
                                    {{ strtoupper(substr($client->name, 0, 2)) }}
                                </div>
                            </div>
                            <div class="user-info text-center">
                                <h5 class="mb-2">{{ $client->name }}</h5>
                                @if ($client->company)
                                    <p class="text-body-secondary mb-2">{{ $client->company }}</p>
                                @endif
                                @if ($client->active)
                                    <span class="badge bg-label-success rounded-pill">Active</span>
                                @else
                                    <span class="badge bg-label-warning rounded-pill">Inactive</span>
                                @endif
                                @if ($client->deleted_at)
                                    <span class="badge bg-label-danger rounded-pill ms-1">Archived</span>
                                @endif
                            </div>
                        </div>
                    </div>

                    {{-- Quick stats --}}
                    <div class="d-flex justify-content-around flex-wrap my-6 gap-0 gap-md-3 gap-lg-4">
                        <div class="d-flex align-items-center gap-4">
                            <div class="avatar">
                                <div class="avatar-initial bg-label-primary rounded-3">
                                    <i class="icon-base ri ri-file-text-line icon-24px"></i>
                                </div>
                            </div>
                            <div>
                                <h5 class="mb-0">{{ $invoices->count() }}</h5>
                                <span>Invoices</span>
                            </div>
                        </div>
                        <div class="d-flex align-items-center gap-4">
                            <div class="avatar">
                                <div class="avatar-initial bg-label-success rounded-3">
                                    <i class="icon-base ri ri-calendar-check-line icon-24px"></i>
                                </div>
                            </div>
                            <div>
                                <h5 class="mb-0">{{ $client->created_at->format('M Y') }}</h5>
                                <span>Client Since</span>
                            </div>
                        </div>
                    </div>

                    <h5 class="pb-4 border-bottom mb-4">Details</h5>

                    <div class="info-container">
                        <div class="d-flex flex-column gap-3 mb-6">

                            <div class="d-flex align-items-start gap-3">
                                <div class="flex-shrink-0" style="width: 36px; height: 36px; border-radius: 8px; background: rgba(181,204,24,0.1); display:flex; align-items:center; justify-content:center;">
                                    <i class="ri ri-user-line" style="color: var(--pac-peridot-dim); font-size: 0.95rem;"></i>
                                </div>
                                <div>
                                    <div style="font-size: 0.7rem; font-weight: 600; text-transform: uppercase; letter-spacing: 0.06em; color: #9ca3af;">Full Name</div>
                                    <div style="font-size: 0.875rem; color: #111827; font-weight: 500;">{{ $client->name }}</div>
                                </div>
                            </div>

                            <div class="d-flex align-items-start gap-3">
                                <div class="flex-shrink-0" style="width: 36px; height: 36px; border-radius: 8px; background: rgba(59,130,246,0.1); display:flex; align-items:center; justify-content:center;">
                                    <i class="ri ri-mail-line" style="color: #3b82f6; font-size: 0.95rem;"></i>
                                </div>
                                <div>
                                    <div style="font-size: 0.7rem; font-weight: 600; text-transform: uppercase; letter-spacing: 0.06em; color: #9ca3af;">Email</div>
                                    <div style="font-size: 0.875rem; color: #111827; font-weight: 500;">
                                        <a href="mailto:{{ $client->email }}" style="color: inherit; text-decoration: none;">{{ $client->email }}</a>
                                    </div>
                                </div>
                            </div>

                            @if ($client->phone)
                                <div class="d-flex align-items-start gap-3">
                                    <div class="flex-shrink-0" style="width: 36px; height: 36px; border-radius: 8px; background: rgba(16,185,129,0.1); display:flex; align-items:center; justify-content:center;">
                                        <i class="ri ri-phone-line" style="color: #10b981; font-size: 0.95rem;"></i>
                                    </div>
                                    <div>
                                        <div style="font-size: 0.7rem; font-weight: 600; text-transform: uppercase; letter-spacing: 0.06em; color: #9ca3af;">Phone</div>
                                        <div style="font-size: 0.875rem; color: #111827; font-weight: 500;">{{ $client->phone }}</div>
                                    </div>
                                </div>
                            @endif

                            @if ($client->company)
                                <div class="d-flex align-items-start gap-3">
                                    <div class="flex-shrink-0" style="width: 36px; height: 36px; border-radius: 8px; background: rgba(139,92,246,0.1); display:flex; align-items:center; justify-content:center;">
                                        <i class="ri ri-building-line" style="color: #8b5cf6; font-size: 0.95rem;"></i>
                                    </div>
                                    <div>
                                        <div style="font-size: 0.7rem; font-weight: 600; text-transform: uppercase; letter-spacing: 0.06em; color: #9ca3af;">Company</div>
                                        <div style="font-size: 0.875rem; color: #111827; font-weight: 500;">{{ $client->company }}</div>
                                    </div>
                                </div>
                            @endif

                            @if ($client->address)
                                <div class="d-flex align-items-start gap-3">
                                    <div class="flex-shrink-0" style="width: 36px; height: 36px; border-radius: 8px; background: rgba(245,158,11,0.1); display:flex; align-items:center; justify-content:center;">
                                        <i class="ri ri-map-pin-line" style="color: #f59e0b; font-size: 0.95rem;"></i>
                                    </div>
                                    <div>
                                        <div style="font-size: 0.7rem; font-weight: 600; text-transform: uppercase; letter-spacing: 0.06em; color: #9ca3af;">Address</div>
                                        <div style="font-size: 0.875rem; color: #111827; font-weight: 500; line-height: 1.5;">{{ $client->address }}</div>
                                    </div>
                                </div>
                            @endif

                            <div class="d-flex align-items-start gap-3">
                                <div class="flex-shrink-0" style="width: 36px; height: 36px; border-radius: 8px; background: rgba(107,114,128,0.1); display:flex; align-items:center; justify-content:center;">
                                    <i class="ri ri-calendar-line" style="color: #6b7280; font-size: 0.95rem;"></i>
                                </div>
                                <div>
                                    <div style="font-size: 0.7rem; font-weight: 600; text-transform: uppercase; letter-spacing: 0.06em; color: #9ca3af;">Client Since</div>
                                    <div style="font-size: 0.875rem; color: #111827; font-weight: 500;">{{ $client->created_at->format('d M, Y') }}</div>
                                </div>
                            </div>

                        </div>

                        {{-- Status & action chips --}}
                        <div class="d-flex align-items-center justify-content-between mb-6 px-1">
                            <div class="d-flex align-items-center gap-2">
                                <span style="font-size: 0.7rem; font-weight: 600; text-transform: uppercase; letter-spacing: 0.06em; color: #9ca3af;">Status</span>
                                @if ($client->active)
                                    <span class="badge bg-label-success rounded-pill">Active</span>
                                @else
                                    <span class="badge bg-label-warning rounded-pill">Inactive</span>
                                @endif
                                @if ($client->deleted_at)
                                    <span class="badge bg-label-danger rounded-pill">Archived</span>
                                @endif
                            </div>
                        </div>

                        <div class="d-flex justify-content-center gap-3 flex-wrap">
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
                    </div>

                </div>
            </div>
            {{-- /Client Card --}}

            {{-- Outstanding Balance Card --}}
            @if (count($currencyTotals) > 0)
                <div class="card mb-6">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Financial Summary</h5>
                    </div>
                    <div class="card-body">
                        @foreach ($currencyTotals as $code => $totals)
                            <div class="mb-4 {{ !$loop->last ? 'pb-4 border-bottom' : '' }}">
                                <div class="d-flex justify-content-between align-items-center mb-1">
                                    <span class="fw-medium text-heading">{{ $code }}</span>
                                    <span class="badge bg-label-secondary rounded-pill">{{ $code }}</span>
                                </div>
                                <ul class="list-unstyled mb-0 mt-3">
                                    <li class="d-flex justify-content-between mb-2">
                                        <span class="text-body-secondary">Total Invoiced</span>
                                        <span class="fw-medium">{{ $totals['symbol'] }} {{ number_format($totals['invoiced'], 2) }}</span>
                                    </li>
                                    <li class="d-flex justify-content-between mb-2">
                                        <span class="text-body-secondary">Amount Paid</span>
                                        <span class="fw-medium text-success">{{ $totals['symbol'] }} {{ number_format($totals['paid'], 2) }}</span>
                                    </li>
                                    <li class="d-flex justify-content-between">
                                        <span class="text-body-secondary">Outstanding</span>
                                        <span class="fw-medium {{ $totals['outstanding'] > 0 ? 'text-danger' : 'text-success' }}">
                                            {{ $totals['symbol'] }} {{ number_format($totals['outstanding'], 2) }}
                                        </span>
                                    </li>
                                </ul>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
            {{-- /Outstanding Balance Card --}}

        </div>
        {{-- ── /Left Sidebar ────────────────────────────────────────────── --}}

        {{-- ── Right Content ─────────────────────────────────────────────── --}}
        <div class="col-xl-8 col-lg-7 col-md-7 order-0 order-md-1">

            {{-- Invoice Table --}}
            <div class="card mb-6">
                <div class="card-header border-bottom d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0">Invoices</h5>
                    <a href="{{ route('admin.invoices.create', ['client_id' => $client->id]) }}" class="btn btn-sm btn-primary">
                        <i class="ri ri-add-line me-1"></i> New Invoice
                    </a>
                </div>
                <div class="table-responsive">
                    <table class="table table-hover mb-0" id="clientInvoicesTable">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Project</th>
                            <th>Currency</th>
                            <th>Status</th>
                            <th>Issued</th>
                            <th>Outstanding</th>
                            <th>Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse ($invoices as $invoice)
                            <tr>
                                <td>
                                    <a href="{{ route('admin.invoices.show', $invoice->id) }}" class="fw-medium">
                                        {{ $invoice->number }}
                                    </a>
                                </td>
                                <td>{{ $invoice->project_name ?? '—' }}</td>
                                <td>
                                    <span class="badge bg-label-secondary rounded-pill">{{ $invoice->currency ?? 'USD' }}</span>
                                </td>
                                <td>
                                    @php
                                        $statusMap = [
                                            'draft'   => 'bg-label-secondary',
                                            'sent'    => 'bg-label-info',
                                            'paid'    => 'bg-label-success',
                                            'partial' => 'bg-label-warning',
                                            'overdue' => 'bg-label-danger',
                                        ];
                                        $badgeClass = $statusMap[$invoice->status] ?? 'bg-label-secondary';
                                    @endphp
                                    <span class="badge {{ $badgeClass }} rounded-pill text-capitalize">{{ $invoice->status }}</span>
                                </td>
                                <td>{{ $invoice->submitted_at ? $invoice->submitted_at->format('d M, Y') : '—' }}</td>
                                <td>
                                    @php $outstanding = $invoice->completedOutstanding(); @endphp
                                    <span class="{{ $outstanding > 0 ? 'text-danger fw-medium' : 'text-success' }}">
                                        {{ $invoice->currencySymbol() }} {{ number_format($outstanding, 2) }}
                                    </span>
                                </td>
                                <td>
                                    <a href="{{ route('admin.invoices.show', $invoice->id) }}"
                                       class="btn btn-sm btn-icon btn-text-secondary rounded-pill" title="View">
                                        <i class="ri ri-eye-line"></i>
                                    </a>
                                    <a href="{{ route('admin.invoices.edit', $invoice->id) }}"
                                       class="btn btn-sm btn-icon btn-text-secondary rounded-pill" title="Edit">
                                        <i class="ri ri-edit-line"></i>
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center text-body-secondary py-6">
                                    <i class="ri ri-file-text-line icon-32px d-block mx-auto mb-2"></i>
                                    No invoices found for this client.
                                </td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            {{-- /Invoice Table --}}

        </div>
        {{-- ── /Right Content ───────────────────────────────────────────── --}}

    </div>

    {{-- ── Offcanvas Edit Client ─────────────────────────────────────── --}}
    <div
        class="offcanvas offcanvas-end"
        tabindex="-1"
        id="offcanvasEditClient"
        aria-labelledby="offcanvasEditClientLabel">

        <div class="offcanvas-header border-bottom">
            <h5 id="offcanvasEditClientLabel" class="offcanvas-title">Edit Client</h5>
            <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>

        <div class="offcanvas-body mx-0 flex-grow-0 h-100">
            <form id="editClientForm" onsubmit="return false">
                @csrf
                <input type="hidden" id="editClientId" name="clientId" value="{{ $client->id }}" />

                <div class="form-floating form-floating-outline mb-5">
                    <input type="text" class="form-control" id="editClientName" name="name"
                           value="{{ $client->name }}" placeholder="Acme Corp" required />
                    <label for="editClientName">Full Name</label>
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
                              placeholder="123 Main St" style="height: 100px">{{ $client->address }}</textarea>
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
    {{-- ── /Offcanvas Edit Client ───────────────────────────────────── --}}

    @push('page-js')
        <script>
            $(function () {

                const csrfToken  = '{{ csrf_token() }}';
                const updateUrl  = '{{ route('admin.clients.update', $client->id) }}';
                const destroyUrl = '{{ route('admin.clients.destroy', $client->id) }}';
                const restoreUrl = '{{ url('admin/clients/' . $client->id . '/restore') }}';
                const indexUrl   = '{{ route('admin.clients.index') }}';

                // ── Edit form submit ──────────────────────────────────────────────
                $('#editClientForm').on('submit', function () {
                    clearErrors('editClientForm');

                    $.ajax({
                        url: updateUrl,
                        method: 'PUT',
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
                                const errors = xhr.responseJSON.errors;
                                $.each(errors, function (field, messages) {
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
                    if (typeof toastr !== 'undefined') toastr.success(msg);
                    else alert(msg);
                }

                function toastError(msg) {
                    if (typeof toastr !== 'undefined') toastr.error(msg);
                    else alert(msg);
                }

            });
        </script>
    @endpush

</x-admin-layout>
