{{-- resources/views/admin/brand-discoveries/index.blade.php --}}
<x-admin-layout title="Brand Discoveries">

    {{-- ═══ INSERTED: header action button ═══ --}}
    <x-slot name="actions">
        <button type="button" class="btn btn-sm d-flex align-items-center gap-2"
                style="background:#111827;color:#fff;border-radius:.4rem;font-size:.82rem;font-weight:600;padding:.42rem .875rem;"
                data-bs-toggle="modal" data-bs-target="#bd-link-modal">
            <i class="ri ri-link"></i>
            <span class="d-none d-sm-inline">Generate Link</span>
        </button>
    </x-slot>
    {{-- ═══ /INSERTED ═══ --}}

    @push('page-css')
        <style>
            .card-widget-separator .card-widget-1,
            .card-widget-separator .card-widget-2,
            .card-widget-separator .card-widget-3 { border-right: 1px solid var(--bs-border-color); }
            @media (max-width: 991.98px) { .card-widget-separator .card-widget-3 { border-right: none; } }
            @media (max-width: 575.98px) {
                .card-widget-separator .card-widget-1,
                .card-widget-separator .card-widget-2,
                .card-widget-separator .card-widget-3 { border-right: none; }
            }
            .card-widget-separator h4 { font-size: 1.375rem; font-weight: 800; letter-spacing: -0.02em; }
            .card-widget-separator p  { font-size: 0.83rem; color: #9ca3af; }

            .av-peridot .avatar-initial { background: rgba(181,204,24,0.12) !important; color: #96aa12 !important; }
            .av-blue    .avatar-initial { background: rgba(59,130,246,0.1)  !important; color: #1d4ed8 !important; }
            .av-green   .avatar-initial { background: rgba(34,197,94,0.1)   !important; color: #15803d !important; }
            .av-metal   .avatar-initial { background: rgba(107,114,128,0.1)!important; color: #6b7280 !important; }

            .pac-filters { display:flex; align-items:center; gap:0.75rem; flex-wrap:wrap; }
            .pac-search-wrap { position:relative; flex:1; min-width:200px; max-width:290px; }
            .pac-search-wrap i {
                position:absolute; left:0.75rem; top:50%; transform:translateY(-50%);
                color:#9ca3af; font-size:1rem; pointer-events:none;
            }
            .pac-search-input {
                width:100%; border:1px solid var(--bs-border-color); border-radius:0.5rem;
                padding:0.45rem 0.875rem 0.45rem 2.25rem; font-size:0.82rem;
                color:var(--bs-body-color); background:var(--bs-body-bg); outline:none;
                transition:border-color .15s, box-shadow .15s;
            }
            .pac-search-input:focus { border-color:#b5cc18; box-shadow:0 0 0 3px rgba(181,204,24,.12); }
            .pac-filter-select {
                border:1px solid var(--bs-border-color); border-radius:0.5rem;
                padding:0.45rem 2rem 0.45rem 0.75rem; font-size:0.82rem;
                color:var(--bs-body-color); background-color:var(--bs-body-bg);
                outline:none; appearance:none; cursor:pointer;
                background-image:url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 24 24' fill='none' stroke='%239ca3af' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpolyline points='6 9 12 15 18 9'%3E%3C/polyline%3E%3C/svg%3E");
                background-repeat:no-repeat; background-position:right .6rem center;
            }

            .pac-status-tabs { display:flex; gap:0; border-bottom:1px solid var(--bs-border-color); overflow-x:auto; scrollbar-width:none; }
            .pac-status-tabs::-webkit-scrollbar { display:none; }
            .pac-status-tab {
                font-size:0.8rem; font-weight:600; color:#9ca3af; padding:0.8rem 1.1rem;
                text-decoration:none; border-bottom:2px solid transparent; white-space:nowrap;
                transition:color .15s, border-color .15s; display:flex; align-items:center; gap:0.4rem; margin-bottom:-1px;
            }
            .pac-status-tab:hover { color:var(--bs-body-color); }
            .pac-status-tab.active { color:#96aa12; border-bottom-color:#b5cc18; }
            .pac-tab-count { font-size:0.65rem; font-weight:700; padding:1px 7px; border-radius:100px; background:var(--bs-tertiary-bg,#f1f5f9); color:#64748b; }
            .pac-status-tab.active .pac-tab-count { background:rgba(181,204,24,.12); color:#96aa12; }

            .bd-list-table thead th {
                font-size:0.72rem; font-weight:700; text-transform:uppercase; letter-spacing:0.07em;
                color:#9ca3af; padding:0.75rem 1rem; white-space:nowrap;
                border-bottom:1px solid var(--bs-border-color); background:var(--bs-tertiary-bg,#f9fafb); vertical-align:middle;
            }
            .bd-list-table tbody td { padding:0.875rem 1rem; font-size:0.83rem; vertical-align:middle; border-bottom:1px solid var(--bs-border-color-translucent,#f3f4f6); }
            .bd-list-table tbody tr:last-child td { border-bottom:none; }
            .bd-list-table tbody tr:hover td { background:var(--bs-tertiary-bg,#fafafa); }

            .bd-av { width:36px; height:36px; border-radius:50%; background:rgba(181,204,24,.12); display:flex; align-items:center; justify-content:center; font-size:0.72rem; font-weight:700; color:#96aa12; flex-shrink:0; }
            .bd-name-link { font-size:0.84rem; font-weight:600; color:var(--bs-heading-color,#111827); text-decoration:none; line-height:1.2; }
            .bd-name-link:hover { color:#96aa12; }
            .bd-sub { font-size:0.71rem; color:#9ca3af; margin-top:1px; }
            .bd-date { font-size:0.79rem; color:#6b7280; }

            .pac-pill { font-size:0.67rem; font-weight:700; padding:3px 10px; border-radius:100px; white-space:nowrap; display:inline-block; letter-spacing:0.02em; }
            .p-new      { background:rgba(59,130,246,.1); color:#1d4ed8; }
            .p-reviewed { background:rgba(34,197,94,.1);  color:#15803d; }
            .p-archived { background:var(--bs-tertiary-bg,#f1f5f9); color:#64748b; }

            .bd-act-btn {
                display:inline-flex; align-items:center; justify-content:center; width:32px; height:32px;
                border-radius:50%; border:none; background:transparent; color:#9ca3af; font-size:1rem;
                cursor:pointer; transition:background .12s, color .12s; text-decoration:none;
            }
            .bd-act-btn:hover { background:var(--bs-tertiary-bg,#f3f4f6); color:var(--bs-body-color,#374151); }

            .pac-empty { display:flex; flex-direction:column; align-items:center; justify-content:center; padding:4rem 2rem; text-align:center; }
            .pac-empty-ring { width:64px; height:64px; border-radius:50%; border:2px dashed rgba(181,204,24,.3); display:flex; align-items:center; justify-content:center; background:rgba(181,204,24,.04); margin-bottom:1rem; }
            .pac-empty-ring i { font-size:1.6rem; color:rgba(181,204,24,.45); }
            .pac-empty h6 { font-size:0.95rem; font-weight:700; color:var(--bs-heading-color); margin-bottom:.35rem; }
            .pac-empty p  { font-size:0.82rem; color:#9ca3af; margin-bottom:1.1rem; }

            .pac-pagination { display:flex; align-items:center; justify-content:space-between; padding:0.875rem 1.25rem; border-top:1px solid var(--bs-border-color-translucent,#f3f4f6); font-size:0.78rem; color:#9ca3af; gap:1rem; flex-wrap:wrap; }
            .pac-pagination .pagination { margin:0; gap:.2rem; }
            .pac-pagination .page-link { border-radius:.375rem; border-color:var(--bs-border-color); color:var(--bs-body-color); font-size:.78rem; padding:.32rem .65rem; min-width:32px; text-align:center; }
            .pac-pagination .page-item.active .page-link { background:#b5cc18; border-color:#b5cc18; color:#111827; font-weight:700; }

            @media (max-width:1199.98px) { .col-industry { display:none; } }
            @media (max-width:991.98px)  { .col-urgency  { display:none; } }
            @media (max-width:767.98px)  { .col-date     { display:none; } }
        </style>
    @endpush

    <div class="card mb-6">
        <div class="card-widget-separator-wrapper">
            <div class="card-body card-widget-separator">
                <div class="row gy-4 gy-sm-1">
                    <div class="col-sm-6 col-lg-3">
                        <div class="d-flex justify-content-between align-items-start card-widget-1 border-end pb-4 pb-sm-0">
                            <div>
                                <h4 class="mb-1">{{ $stats['total'] ?? 0 }}</h4>
                                <p class="mb-0">Submissions</p>
                                <p class="mb-0" style="font-size:.72rem;color:#b5cc18;font-weight:600;margin-top:2px;">{{ $stats['this_month'] ?? 0 }} this month</p>
                            </div>
                            <div class="avatar me-sm-6 av-peridot">
                                <span class="avatar-initial rounded-3"><i class="icon-base ri ri-compass-3-line text-heading icon-26px"></i></span>
                            </div>
                        </div>
                        <hr class="d-none d-sm-block d-lg-none me-6">
                    </div>
                    <div class="col-sm-6 col-lg-3">
                        <div class="d-flex justify-content-between align-items-start card-widget-2 border-end pb-4 pb-sm-0">
                            <div>
                                <h4 class="mb-1">{{ $stats['new_count'] ?? 0 }}</h4>
                                <p class="mb-0">Awaiting Review</p>
                            </div>
                            <div class="avatar me-lg-6 av-blue">
                                <span class="avatar-initial rounded-3"><i class="icon-base ri ri-inbox-unarchive-line text-heading icon-26px"></i></span>
                            </div>
                        </div>
                        <hr class="d-none d-sm-block d-lg-none">
                    </div>
                    <div class="col-sm-6 col-lg-3">
                        <div class="d-flex justify-content-between align-items-start card-widget-3 border-end pb-4 pb-sm-0">
                            <div>
                                <h4 class="mb-1">{{ $stats['reviewed_count'] ?? 0 }}</h4>
                                <p class="mb-0">Reviewed</p>
                            </div>
                            <div class="avatar me-sm-6 av-green">
                                <span class="avatar-initial rounded-3"><i class="icon-base ri ri-checkbox-circle-line text-heading icon-26px"></i></span>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-lg-3">
                        <div class="d-flex justify-content-between align-items-start pb-4 pb-sm-0">
                            <div>
                                <h4 class="mb-1">{{ $stats['archived_count'] ?? 0 }}</h4>
                                <p class="mb-0">Archived</p>
                            </div>
                            <div class="avatar av-metal">
                                <span class="avatar-initial rounded-3"><i class="icon-base ri ri-archive-line text-heading icon-26px"></i></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header border-bottom p-0">
            <div class="pac-status-tabs px-4">
                <a href="{{ route('admin.brand-discoveries.index') }}" class="pac-status-tab {{ !request('status') ? 'active' : '' }}">
                    All <span class="pac-tab-count">{{ $stats['total'] ?? 0 }}</span>
                </a>
                @foreach(['new' => 'New', 'reviewed' => 'Reviewed', 'archived' => 'Archived'] as $key => $label)
                    <a href="{{ route('admin.brand-discoveries.index', ['status' => $key]) }}"
                       class="pac-status-tab {{ request('status') === $key ? 'active' : '' }}">
                        {{ $label }} <span class="pac-tab-count">{{ $stats[$key . '_count'] ?? 0 }}</span>
                    </a>
                @endforeach
            </div>

            <div class="p-4 d-flex align-items-center justify-content-between flex-wrap gap-4">
                <form action="{{ route('admin.brand-discoveries.index') }}" method="GET" class="pac-filters">
                    @if(request('status'))
                        <input type="hidden" name="status" value="{{ request('status') }}">
                    @endif
                    <div class="pac-search-wrap">
                        <i class="ri ri-search-line"></i>
                        <input type="text" name="search" class="pac-search-input"
                               placeholder="Search name, brand, email..." value="{{ request('search') }}">
                    </div>
                    <select name="per_page" class="pac-filter-select" onchange="this.form.submit()">
                        <option value="10" {{ request('per_page') == 10 ? 'selected' : '' }}>10 rows</option>
                        <option value="25" {{ request('per_page') == 25 ? 'selected' : '' }}>25 rows</option>
                        <option value="50" {{ request('per_page') == 50 ? 'selected' : '' }}>50 rows</option>
                    </select>
                </form>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table bd-list-table mb-0">
                <thead>
                <tr>
                    <th>Contact</th>
                    <th class="col-industry">Industry</th>
                    <th class="col-urgency">Urgency</th>
                    <th class="col-date">Submitted</th>
                    <th>Status</th>
                    <th class="text-end" style="padding-right:1.25rem;">Action</th>
                </tr>
                </thead>
                <tbody>
                @forelse($discoveries as $d)
                    @php
                        $initials = collect(explode(' ', $d->name))->take(2)->map(fn($w) => strtoupper($w[0] ?? ''))->implode('');
                    @endphp
                    <tr>
                        <td>
                            <div class="d-flex align-items-center gap-3">
                                <div class="bd-av">{{ $initials }}</div>
                                <div class="d-flex flex-column">
                                    <a href="{{ route('admin.brand-discoveries.show', $d) }}" class="bd-name-link">{{ $d->brand_name }}</a>
                                    <span class="bd-sub">{{ $d->name }} · {{ $d->email }}</span>
                                </div>
                            </div>
                        </td>
                        <td class="col-industry"><span style="font-weight:500;color:#4b5563;">{{ $d->industry ?: '—' }}</span></td>
                        <td class="col-urgency"><span class="bd-sub" style="font-size:.78rem;color:#6b7280;">{{ $d->urgency ?: '—' }}</span></td>
                        <td class="col-date"><div class="bd-date">{{ $d->created_at->format('d M, Y') }}</div></td>
                        <td>
                            @if($d->isExpired())
                                <span class="pac-pill" style="background:rgba(107,114,128,.1);color:#6b7280;">Expired</span>
                            @else
                                <span class="pac-pill p-{{ $d->status }}">{{ ucfirst($d->status) }}</span>
                            @endif
                        </td>
                        <td class="text-end" style="padding-right:1.25rem;">
                            <div class="d-inline-flex gap-1">
                                <a href="{{ route('admin.brand-discoveries.show', $d) }}" class="bd-act-btn" title="View">
                                    <i class="ri ri-eye-line"></i>
                                </a>
                                <div class="dropdown">
                                    <button class="bd-act-btn" type="button" data-bs-toggle="dropdown">
                                        <i class="ri ri-more-2-fill"></i>
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-end">
                                        @if($d->status !== 'reviewed')
                                            <li><button type="button" class="dropdown-item bd-status-btn" data-id="{{ $d->id }}" data-status="reviewed"><i class="ri ri-checkbox-circle-line"></i> Mark Reviewed</button></li>
                                        @endif
                                        @if($d->status !== 'archived')
                                            <li><button type="button" class="dropdown-item bd-status-btn" data-id="{{ $d->id }}" data-status="archived"><i class="ri ri-archive-line"></i> Archive</button></li>
                                        @endif
                                        @if($d->isExpired())
                                            <li><button type="button" class="dropdown-item bd-renew-btn" data-id="{{ $d->id }}"><i class="ri ri-refresh-line"></i> Renew Link</button></li>
                                        @endif
                                        <li><hr class="dropdown-divider"></li>
                                        <li><button type="button" class="dropdown-item text-danger bd-delete-btn" data-id="{{ $d->id }}"><i class="ri ri-delete-bin-line"></i> Delete</button></li>
                                    </ul>
                                </div>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6">
                            <div class="pac-empty">
                                <div class="pac-empty-ring"><i class="ri ri-compass-3-line"></i></div>
                                <h6>No submissions yet</h6>
                                <p>Discovery form responses will show up here.</p>
                            </div>
                        </td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>

        @if($discoveries->hasPages())
            <div class="pac-pagination">
                <div>Showing {{ $discoveries->firstItem() }} to {{ $discoveries->lastItem() }} of {{ $discoveries->total() }} entries</div>
                {{ $discoveries->links('pagination::bootstrap-5') }}
            </div>
        @endif
    </div>

    {{-- ═══ INSERTED: generate-link modal ═══ --}}
    <div class="modal fade" id="bd-link-modal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body">
                    <h5 class="mb-1">Generate Discovery Link</h5>
                    <p class="text-muted mb-4" style="font-size:.82rem;">
                        Prefill fields are optional — leave blank and the client fills everything in themselves.
                    </p>
                    <div class="mb-3">
                        <label class="form-label" style="font-size:.8rem;">Client / Contact Name</label>
                        <input type="text" id="bd-link-name" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label class="form-label" style="font-size:.8rem;">Brand Name</label>
                        <input type="text" id="bd-link-brand" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label class="form-label" style="font-size:.8rem;">Email</label>
                        <input type="email" id="bd-link-email" class="form-control">
                    </div>
                    <div id="bd-link-result" class="d-none">
                        <label class="form-label" style="font-size:.8rem;">Link</label>
                        <div class="input-group">
                            <input type="text" id="bd-link-url" class="form-control" readonly>
                            <button class="btn btn-outline-secondary" type="button" id="bd-link-copy">Copy</button>
                        </div>
                    </div>
                    <div class="d-flex justify-content-end gap-2 mt-4">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="button" class="btn" style="background:#b5cc18;font-weight:700;" id="bd-link-generate">Generate</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- ═══ /INSERTED ═══ --}}

    @push('page-js')
        <script>

            $(document).on('click', '.bd-renew-btn', function () {
                const id = $(this).data('id');

                $.ajax({
                    url: `/admin/brand-discoveries/${id}/renew`,
                    method: 'POST',
                    data: { _token: '{{ csrf_token() }}', _method: 'PATCH' },
                    success: function (res) {
                        if (res.success) {
                            Pac.toast.success(res.message);
                            setTimeout(() => location.reload(), 700);
                        } else {
                            Pac.toast.error(res.message);
                        }
                    },
                    error: () => Pac.toast.error('Could not renew link.')
                });
            });

            $(document).on('click', '.bd-status-btn', function () {
                const id     = $(this).data('id');
                const status = $(this).data('status');

                $.ajax({
                    url: `/admin/brand-discoveries/${id}/status`,
                    method: 'POST',
                    data: { _token: '{{ csrf_token() }}', _method: 'PATCH', status },
                    success: function (res) {
                        if (res.success) {
                            Pac.toast.success(res.message);
                            setTimeout(() => location.reload(), 700);
                        }
                    },
                    error: () => Pac.toast.error('Could not update status.')
                });
            });

            $(document).on('click', '.bd-delete-btn', function () {
                const id = $(this).data('id');

                Pac.confirm({
                    title: 'Delete Submission?',
                    message: 'This cannot be undone.',
                    confirm: 'Delete',
                    type: 'danger',
                }).then(() => {
                    $.ajax({
                        url: `/admin/brand-discoveries/${id}`,
                        method: 'POST',
                        data: { _token: '{{ csrf_token() }}', _method: 'DELETE' },
                        success: function (res) {
                            if (res.success) {
                                Pac.toast.success(res.message);
                                setTimeout(() => location.reload(), 700);
                            }
                        },
                        error: () => Pac.toast.error('Could not delete submission.')
                    });
                });
            });

            {{-- ═══ INSERTED: generate-link handlers ═══ --}}
            $('#bd-link-generate').on('click', function () {
                $.ajax({
                    url: '{{ route("admin.brand-discoveries.create-link") }}',
                    method: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        name: $('#bd-link-name').val(),
                        brand_name: $('#bd-link-brand').val(),
                        email: $('#bd-link-email').val(),
                    },
                    success: function (res) {
                        if (res.success) {
                            $('#bd-link-url').val(res.url);
                            $('#bd-link-result').removeClass('d-none');
                            Pac.toast.success('Link generated.');
                        }
                    },
                    error: () => Pac.toast.error('Could not generate link.')
                });
            });

            $('#bd-link-copy').on('click', function () {
                navigator.clipboard.writeText($('#bd-link-url').val());
                Pac.toast.info('Copied to clipboard.');
            });
            {{-- ═══ /INSERTED ═══ --}}
        </script>
    @endpush

</x-admin-layout>
