<x-admin-layout title="Clients">

    @push('page-css')
        <style>
            /* ── Remove DataTables default border/padding that clashes with card ── */
            .card-datatable .dataTables_wrapper { padding: 0; }

            /* ── Length select ── */
            .card-datatable .dataTables_length select {
                padding: 0.375rem 2rem 0.375rem 0.75rem;
                font-size: 0.85rem;
                border-radius: 0.375rem;
                border: 1px solid var(--bs-border-color);
                background-color: var(--bs-body-bg);
                color: var(--bs-body-color);
                min-width: 70px;
            }

            /* ── Search input ── */
            .card-datatable .dataTables_filter input {
                padding: 0.375rem 0.75rem;
                font-size: 0.85rem;
                border-radius: 0.375rem;
                border: 1px solid var(--bs-border-color);
                background-color: var(--bs-body-bg);
                color: var(--bs-body-color);
                min-width: 220px;
            }
            .card-datatable .dataTables_filter input:focus {
                outline: none;
                border-color: var(--pac-peridot);
                box-shadow: 0 0 0 3px rgba(181,204,24,0.12);
            }
            .card-datatable .dataTables_filter label { margin: 0; }

            /* ── Info text ── */
            .card-datatable .dataTables_info {
                font-size: 0.82rem;
                color: var(--bs-secondary-color);
                padding: 0;
            }

            /* ── Pagination ── */
            .card-datatable .dataTables_paginate .paginate_button {
                border-radius: 0.375rem !important;
                padding: 0.25rem 0.625rem !important;
                font-size: 0.82rem;
                border: 1px solid transparent !important;
                margin: 0 2px;
            }
            .card-datatable .dataTables_paginate .paginate_button.current,
            .card-datatable .dataTables_paginate .paginate_button.current:hover {
                background: var(--pac-peridot) !important;
                border-color: var(--pac-peridot) !important;
                color: #111827 !important;
                font-weight: 600;
            }
            .card-datatable .dataTables_paginate .paginate_button:hover:not(.current):not(.disabled) {
                background: rgba(181,204,24,0.1) !important;
                border-color: rgba(181,204,24,0.3) !important;
                color: var(--pac-peridot-dim) !important;
            }
            .card-datatable .dataTables_paginate .paginate_button.disabled {
                color: var(--bs-secondary-color) !important;
                opacity: 0.5;
            }

            /* ── Table itself ── */
            .card-datatable table.dataTable thead th {
                font-size: 0.72rem;
                font-weight: 700;
                letter-spacing: 0.06em;
                text-transform: uppercase;
                color: var(--bs-secondary-color);
                border-bottom: 1px solid var(--bs-border-color);
                padding: 0.75rem 1rem;
            }
            .card-datatable table.dataTable tbody td {
                font-size: 0.84rem;
                padding: 0.75rem 1rem;
                vertical-align: middle;
                border-bottom: 1px solid var(--bs-border-color);
            }
            .card-datatable table.dataTable tbody tr:last-child td { border-bottom: none; }
            .card-datatable table.dataTable tbody tr:hover td {
                background-color: rgba(181,204,24,0.04);
            }

            /* ── Processing overlay ── */
            .card-datatable .dataTables_processing {
                background: rgba(255,255,255,0.9);
                border: 1px solid var(--bs-border-color);
                border-radius: 0.5rem;
                font-size: 0.82rem;
                color: var(--pac-ink);
            }
        </style>
    @endpush

    {{-- ── Stats Cards ─────────────────────────────────────────────── --}}
    <div class="row g-6 mb-6">

        <div class="col-sm-6 col-xl-3">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div class="me-1">
                            <p class="text-heading mb-1">Total Clients</p>
                            <div class="d-flex align-items-center">
                                <h4 class="mb-1 me-2">{{ $stats['total'] }}</h4>
                            </div>
                            <small class="mb-0">All time</small>
                        </div>
                        <div class="avatar">
                            <div class="avatar-initial bg-label-primary rounded-3">
                                <i class="icon-base ri ri-group-line icon-26px"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-sm-6 col-xl-3">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div class="me-1">
                            <p class="text-heading mb-1">Active Clients</p>
                            <div class="d-flex align-items-center">
                                <h4 class="mb-1 me-2">{{ $stats['active'] }}</h4>
                            </div>
                            <small class="mb-0">Currently active</small>
                        </div>
                        <div class="avatar">
                            <div class="avatar-initial bg-label-success rounded-3">
                                <i class="icon-base ri ri-user-follow-line icon-26px"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-sm-6 col-xl-3">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div class="me-1">
                            <p class="text-heading mb-1">Inactive Clients</p>
                            <div class="d-flex align-items-center">
                                <h4 class="mb-1 me-2">{{ $stats['inactive'] }}</h4>
                            </div>
                            <small class="mb-0">Deactivated</small>
                        </div>
                        <div class="avatar">
                            <div class="avatar-initial bg-label-warning rounded-3">
                                <i class="icon-base ri ri-user-forbid-line icon-26px"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-sm-6 col-xl-3">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div class="me-1">
                            <p class="text-heading mb-1">Archived</p>
                            <div class="d-flex align-items-center">
                                <h4 class="mb-1 me-2">{{ $stats['deleted'] }}</h4>
                            </div>
                            <small class="mb-0">Soft deleted</small>
                        </div>
                        <div class="avatar">
                            <div class="avatar-initial bg-label-danger rounded-3">
                                <i class="icon-base ri ri-archive-line icon-26px"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
    {{-- ── /Stats Cards ─────────────────────────────────────────────── --}}

    {{-- ── Client List Table ────────────────────────────────────────── --}}
    <div class="card">
        <div class="card-header border-bottom">
            <h5 class="card-title mb-0">Filters</h5>
            <div class="d-flex justify-content-between align-items-center row gx-5 pt-4 gap-5 gap-md-0">

                {{-- Status filter --}}
                <div class="col-md-4">
                    <select id="filterStatus" class="form-select text-capitalize">
                        <option value="">All Statuses</option>
                        <option value="active">Active</option>
                        <option value="inactive">Inactive</option>
                    </select>
                </div>

                {{-- Archived toggle --}}
                <div class="col-md-4 d-flex align-items-center gap-2">
                    <div class="form-check form-switch mb-0">
                        <input class="form-check-input" type="checkbox" id="showDeleted" />
                        <label class="form-check-label" for="showDeleted">Show Archived</label>
                    </div>
                </div>

                {{-- Add Client button --}}
                <div class="col-md-4 d-flex justify-content-md-end">
                    <button
                        class="btn btn-primary"
                        data-bs-toggle="offcanvas"
                        data-bs-target="#offcanvasAddClient"
                        aria-controls="offcanvasAddClient">
                        <i class="ri ri-add-line me-1"></i> Add Client
                    </button>
                </div>

            </div>
        </div>

        <div class="card-datatable">
            <table class="datatables-clients table" id="clientsTable">
                <thead>
                <tr>
                    <th></th>
                    <th>Client</th>
                    <th>Company</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Invoices</th>
                    <th>Outstanding</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
                </thead>
            </table>
        </div>

        {{-- ── Offcanvas Add / Edit Client ─────────────────────────────── --}}
        <div
            class="offcanvas offcanvas-end"
            tabindex="-1"
            id="offcanvasAddClient"
            aria-labelledby="offcanvasClientLabel">

            <div class="offcanvas-header border-bottom">
                <h5 id="offcanvasClientLabel" class="offcanvas-title">Add Client</h5>
                <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            </div>

            <div class="offcanvas-body mx-0 flex-grow-0 h-100">
                <form id="clientForm" onsubmit="return false">
                    @csrf
                    <input type="hidden" id="clientId" name="clientId" value="" />

                    <div class="form-floating form-floating-outline mb-5 form-control-validation">
                        <input
                            type="text"
                            class="form-control"
                            id="clientName"
                            name="name"
                            placeholder="Acme Corp"
                            required />
                        <label for="clientName">Full Name</label>
                    </div>

                    <div class="form-floating form-floating-outline mb-5 form-control-validation">
                        <input
                            type="email"
                            class="form-control"
                            id="clientEmail"
                            name="email"
                            placeholder="hello@acme.com"
                            required />
                        <label for="clientEmail">Email</label>
                    </div>

                    <div class="form-floating form-floating-outline mb-5">
                        <input
                            type="text"
                            class="form-control"
                            id="clientPhone"
                            name="phone"
                            placeholder="+1 (555) 000-0000" />
                        <label for="clientPhone">Phone</label>
                    </div>

                    <div class="form-floating form-floating-outline mb-5">
                        <input
                            type="text"
                            class="form-control"
                            id="clientCompany"
                            name="company"
                            placeholder="Acme Corporation" />
                        <label for="clientCompany">Company</label>
                    </div>

                    <div class="form-floating form-floating-outline mb-5">
                        <textarea
                            class="form-control"
                            id="clientAddress"
                            name="address"
                            placeholder="123 Main St, City, Country"
                            style="height: 100px"></textarea>
                        <label for="clientAddress">Address</label>
                    </div>

                    <div class="mb-5">
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" id="clientActive" name="active" checked />
                            <label class="form-check-label text-heading" for="clientActive">Active</label>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary me-sm-3 me-1" id="clientSubmitBtn">Submit</button>
                    <button type="reset" class="btn btn-outline-danger" data-bs-dismiss="offcanvas">Cancel</button>
                </form>
            </div>
        </div>
        {{-- ── /Offcanvas ───────────────────────────────────────────────── --}}

    </div>
    {{-- ── /Client List Table ───────────────────────────────────────── --}}

    @push('page-js')
        <script>
            $(function () {

                // ── Routes (injected server-side) ─────────────────────────────────
                const ROUTES = {
                    data:    '{{ route('admin.clients.data') }}',
                    store:   '{{ route('admin.clients.store') }}',
                    show:    '{{ url('admin/clients') }}',   // + /{id}
                    update:  '{{ url('admin/clients') }}',   // + /{id}  PUT
                    destroy: '{{ url('admin/clients') }}',   // + /{id}  DELETE
                    restore: '{{ url('admin/clients') }}',   // + /{id}/restore  PATCH
                };

                const csrfToken = '{{ csrf_token() }}';

                // ── DataTable ─────────────────────────────────────────────────────
                let table = $('#clientsTable').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: {
                        url: ROUTES.data,
                        data: function (d) {
                            d.status       = $('#filterStatus').val();
                            d.show_deleted = $('#showDeleted').is(':checked') ? '1' : '0';
                        }
                    },
                    columns: [
                        { data: null, defaultContent: '', orderable: false, searchable: false },
                        {
                            data: 'name',
                            render: function (data, type, row) {
                                return `<a href="${ROUTES.show}/${row.id}" class="fw-medium text-heading">${data}</a>`;
                            }
                        },
                        { data: 'company' },
                        { data: 'email' },
                        { data: 'phone' },
                        {
                            data: 'active_invoices',
                            render: function (data) {
                                return `<span class="badge bg-label-primary rounded-pill">${data}</span>`;
                            }
                        },
                        {
                            data: 'outstanding',
                            render: function (data, type, row) {
                                if (type === 'sort') return row.outstanding_sort;
                                let cls = row.mixed_currency ? 'text-warning' : '';
                                return `<span class="${cls}">${data}</span>`;
                            }
                        },
                        {
                            data: 'status',
                            render: function (data, type, row) {
                                if (row.deleted_at) {
                                    return '<span class="badge bg-label-secondary rounded-pill">Archived</span>';
                                }
                                return data === 'active'
                                    ? '<span class="badge bg-label-success rounded-pill">Active</span>'
                                    : '<span class="badge bg-label-warning rounded-pill">Inactive</span>';
                            }
                        },
                        {
                            data: 'id',
                            orderable: false,
                            searchable: false,
                            render: function (data, type, row) {
                                let actions = `
                                    <a href="${ROUTES.show}/${data}" class="btn btn-sm btn-icon btn-text-secondary rounded-pill" title="View">
                                        <i class="ri ri-eye-line"></i>
                                    </a>`;

                                if (!row.deleted_at) {
                                    actions += `
                                        <button class="btn btn-sm btn-icon btn-text-secondary rounded-pill btn-edit"
                                            data-id="${data}"
                                            data-name="${row.name}"
                                            data-email="${row.email}"
                                            data-phone="${row.phone}"
                                            data-company="${row.company}"
                                            data-address="${row.address ?? ''}"
                                            data-active="${row.status === 'active' ? 1 : 0}"
                                            title="Edit">
                                            <i class="ri ri-edit-line"></i>
                                        </button>
                                        <button class="btn btn-sm btn-icon btn-text-danger rounded-pill btn-delete"
                                            data-id="${data}" data-name="${row.name}" title="Archive">
                                            <i class="ri ri-archive-line"></i>
                                        </button>`;
                                } else {
                                    actions += `
                                        <button class="btn btn-sm btn-icon btn-text-success rounded-pill btn-restore"
                                            data-id="${data}" data-name="${row.name}" title="Restore">
                                            <i class="ri ri-arrow-go-back-line"></i>
                                        </button>`;
                                }

                                return `<div class="d-flex align-items-center">${actions}</div>`;
                            }
                        },
                    ],
                    order: [[1, 'asc']],
                    autoWidth: false,
                    dom:
                        '<"d-flex justify-content-between align-items-center px-6 pt-4 pb-3"' +
                        '<"d-flex align-items-center gap-2"l>' +
                        '<"dt-search"f>' +
                        '>' +
                        'tr' +
                        '<"d-flex justify-content-between align-items-center px-6 py-4 border-top"' +
                        '<"dt-info"i>' +
                        '<"dt-paging"p>' +
                        '>',
                    language: {
                        search:            '',
                        searchPlaceholder: 'Search clients...',
                        lengthMenu:        '_MENU_ per page',
                        info:              'Showing _START_ to _END_ of _TOTAL_ clients',
                        infoEmpty:         'No clients found',
                        zeroRecords:       'No matching clients found',
                        emptyTable:        'No clients yet — add your first one above',
                    }
                });

                // Re-draw when filters change
                $('#filterStatus, #showDeleted').on('change', function () {
                    table.ajax.reload();
                });

                // ── Offcanvas: reset to Add mode on open ──────────────────────────
                $('#offcanvasAddClient').on('show.bs.offcanvas', function () {
                    if (!$('#clientId').val()) {
                        resetForm('add');
                    }
                });

                $('#offcanvasAddClient').on('hidden.bs.offcanvas', function () {
                    resetForm('add');
                });

                function resetForm(mode) {
                    $('#clientForm')[0].reset();
                    $('#clientId').val('');
                    $('#clientActive').prop('checked', true);
                    $('#offcanvasClientLabel').text(mode === 'edit' ? 'Edit Client' : 'Add Client');
                    $('#clientSubmitBtn').text('Submit');
                    clearErrors();
                }

                // ── Edit button: populate offcanvas ──────────────────────────────
                $(document).on('click', '.btn-edit', function () {
                    const btn = $(this);
                    $('#clientId').val(btn.data('id'));
                    $('#clientName').val(btn.data('name'));
                    $('#clientEmail').val(btn.data('email'));
                    $('#clientPhone').val(btn.data('phone') === '—' ? '' : btn.data('phone'));
                    $('#clientCompany').val(btn.data('company') === '—' ? '' : btn.data('company'));
                    $('#clientAddress').val(btn.data('address'));
                    $('#clientActive').prop('checked', btn.data('active') == 1);
                    $('#offcanvasClientLabel').text('Edit Client');
                    $('#clientSubmitBtn').text('Update');
                    clearErrors();

                    const offcanvas = new bootstrap.Offcanvas(document.getElementById('offcanvasAddClient'));
                    offcanvas.show();
                });

                // ── Form submit (store or update) ────────────────────────────────
                $('#clientForm').on('submit', function () {
                    clearErrors();
                    const id      = $('#clientId').val();
                    const isEdit  = !!id;
                    const url     = isEdit ? `${ROUTES.update}/${id}` : ROUTES.store;
                    const method  = isEdit ? 'PUT' : 'POST';

                    const payload = {
                        _token:  csrfToken,
                        name:    $('#clientName').val(),
                        email:   $('#clientEmail').val(),
                        phone:   $('#clientPhone').val(),
                        company: $('#clientCompany').val(),
                        address: $('#clientAddress').val(),
                        active:  $('#clientActive').is(':checked') ? 1 : 0,
                    };

                    $.ajax({
                        url, method,
                        data: payload,
                        success: function (res) {
                            if (res.success) {
                                bootstrap.Offcanvas.getInstance(document.getElementById('offcanvasAddClient'))?.hide();
                                table.ajax.reload(null, false);
                                toastSuccess(res.message);
                            }
                        },
                        error: function (xhr) {
                            if (xhr.status === 422) {
                                const errors = xhr.responseJSON.errors;
                                $.each(errors, function (field, messages) {
                                    const input = $(`#client${field.charAt(0).toUpperCase() + field.slice(1)}`);
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

                // ── Delete (soft) ─────────────────────────────────────────────────
                $(document).on('click', '.btn-delete', function () {
                    const id   = $(this).data('id');
                    const name = $(this).data('name');
                    if (!confirm(`Archive client "${name}"? They can be restored later.`)) return;

                    $.ajax({
                        url: `${ROUTES.destroy}/${id}`,
                        method: 'DELETE',
                        data: { _token: csrfToken },
                        success: function (res) {
                            if (res.success) {
                                table.ajax.reload(null, false);
                                toastSuccess(res.message);
                            }
                        },
                        error: () => toastError('Could not archive client.')
                    });
                });

                // ── Restore ───────────────────────────────────────────────────────
                $(document).on('click', '.btn-restore', function () {
                    const id   = $(this).data('id');
                    const name = $(this).data('name');
                    if (!confirm(`Restore client "${name}"?`)) return;

                    $.ajax({
                        url: `${ROUTES.restore}/${id}/restore`,
                        method: 'PATCH',
                        data: { _token: csrfToken },
                        success: function (res) {
                            if (res.success) {
                                table.ajax.reload(null, false);
                                toastSuccess(res.message);
                            }
                        },
                        error: () => toastError('Could not restore client.')
                    });
                });

                // ── Helpers ───────────────────────────────────────────────────────
                function clearErrors() {
                    $('#clientForm .is-invalid').removeClass('is-invalid');
                    $('#clientForm .invalid-feedback').remove();
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
