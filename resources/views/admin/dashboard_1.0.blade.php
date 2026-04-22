<x-admin-layout title="Dashboard">

    {{-- ─── Stats row ──────────────────────────────────────────────── --}}
    <div class="row g-4 mb-4">

        {{-- Outstanding Invoices --}}
        <div class="col-sm-6 col-xl-3">
            <div class="card h-100">
                <div class="card-body d-flex align-items-center gap-3">
                    <div class="avatar flex-shrink-0">
                        <span class="avatar-initial rounded-circle"
                              style="background-color: color-mix(in sRGB, var(--pac-peridot) 15%, white); color: var(--pac-peridot-dim);">
                            <i class="icon-base ri ri-file-list-3-line icon-22px"></i>
                        </span>
                    </div>
                    <div>
                        <small class="text-body-secondary d-block">Outstanding</small>
                        <h5 class="mb-0 fw-semibold">—</h5>
                        <small class="text-body-secondary">Invoices</small>
                    </div>
                </div>
            </div>
        </div>

        {{-- Active Clients --}}
        <div class="col-sm-6 col-xl-3">
            <div class="card h-100">
                <div class="card-body d-flex align-items-center gap-3">
                    <div class="avatar flex-shrink-0">
                        <span class="avatar-initial rounded-circle"
                              style="background-color: color-mix(in sRGB, #6b7280 15%, white); color: #374151;">
                            <i class="icon-base ri ri-group-line icon-22px"></i>
                        </span>
                    </div>
                    <div>
                        <small class="text-body-secondary d-block">Active</small>
                        <h5 class="mb-0 fw-semibold">—</h5>
                        <small class="text-body-secondary">Clients</small>
                    </div>
                </div>
            </div>
        </div>

        {{-- Projects in Progress --}}
        <div class="col-sm-6 col-xl-3">
            <div class="card h-100">
                <div class="card-body d-flex align-items-center gap-3">
                    <div class="avatar flex-shrink-0">
                        <span class="avatar-initial rounded-circle"
                              style="background-color: color-mix(in sRGB, #111827 12%, white); color: #111827;">
                            <i class="icon-base ri ri-layout-column-line icon-22px"></i>
                        </span>
                    </div>
                    <div>
                        <small class="text-body-secondary d-block">In Progress</small>
                        <h5 class="mb-0 fw-semibold">—</h5>
                        <small class="text-body-secondary">Projects</small>
                    </div>
                </div>
            </div>
        </div>

        {{-- Unread Messages --}}
        <div class="col-sm-6 col-xl-3">
            <div class="card h-100">
                <div class="card-body d-flex align-items-center gap-3">
                    <div class="avatar flex-shrink-0">
                        <span class="avatar-initial rounded-circle bg-label-danger">
                            <i class="icon-base ri ri-message-3-line icon-22px"></i>
                        </span>
                    </div>
                    <div>
                        <small class="text-body-secondary d-block">Unread</small>
                        <h5 class="mb-0 fw-semibold">—</h5>
                        <small class="text-body-secondary">Messages</small>
                    </div>
                </div>
            </div>
        </div>

    </div>
    {{-- ─── / Stats row ─────────────────────────────────────────────── --}}

    {{-- ─── Main content row ──────────────────────────────────────────── --}}
    <div class="row g-4">

        {{-- Recent Invoices --}}
        <div class="col-xl-7">
            <div class="card h-100">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <h5 class="mb-0">Recent Invoices</h5>
                    <a href="{{ route('admin.invoices.index') }}"
                       class="btn btn-sm"
                       style="font-size: 0.78rem; color: var(--pac-peridot-dim); border: 1px solid var(--pac-peridot); border-radius: 0.375rem; padding: 0.3rem 0.75rem;">
                        View All
                    </a>
                </div>
                <div class="card-body">
                    <div class="text-center text-body-secondary py-5">
                        <i class="ri ri-file-list-3-line icon-base mb-2" style="font-size: 2rem; opacity: 0.3;"></i>
                        <p class="mb-0" style="font-size: 0.875rem;">
                            No invoices yet.
                            <a href="{{ route('admin.invoices.create') }}" style="color: var(--pac-peridot-dim);">Create your first one →</a>
                        </p>
                    </div>
                </div>
            </div>
        </div>

        {{-- Recent Clients --}}
        <div class="col-xl-5">
            <div class="card h-100">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <h5 class="mb-0">Recent Clients</h5>
                    <a href="{{ route('admin.clients.index') }}"
                       class="btn btn-sm"
                       style="font-size: 0.78rem; color: var(--pac-peridot-dim); border: 1px solid var(--pac-peridot); border-radius: 0.375rem; padding: 0.3rem 0.75rem;">
                        View All
                    </a>
                </div>
                <div class="card-body">
                    <div class="text-center text-body-secondary py-5">
                        <i class="ri ri-group-line icon-base mb-2" style="font-size: 2rem; opacity: 0.3;"></i>
                        <p class="mb-0" style="font-size: 0.875rem;">
                            No clients yet.
                            <a href="{{ route('admin.clients.create') }}" style="color: var(--pac-peridot-dim);">Add your first one →</a>
                        </p>
                    </div>
                </div>
            </div>
        </div>

    </div>
    {{-- ─── / Main content row ─────────────────────────────────────────── --}}

</x-admin-layout>
