{{--
    ┌─────────────────────────────────────────────────────────────────────────┐
    │  resources/views/components/admin/navbar.blade.php                      │
    │  The Pacmedia — Materialize Bootstrap admin navbar                      │
    │                                                                          │
    │  Features adopted from Materialize template:                             │
    │  • Detached / floating navbar style (navbar-detached)                    │
    │  • Search toggler slot (algolia autocomplete hook)                       │
    │  • Dark-mode / theme switcher                                            │
    │  • Notification bell with unread badge + dropdown panel                  │
    │  • Quick-links shortcut dropdown                                          │
    │  • User avatar dropdown (profile, settings, logout)                      │
    └─────────────────────────────────────────────────────────────────────────┘
--}}

<nav
    class="layout-navbar container-xxl navbar-detached navbar navbar-expand-xl align-items-center bg-navbar-theme"
    id="layout-navbar"
    style="border-radius: 0.75rem; margin: 0.875rem 1.5rem 0;">

    {{-- ── Mobile menu toggle ──────────────────────────────────────────── --}}
    <div class="layout-menu-toggle navbar-nav align-items-xl-center me-4 me-xl-0 d-xl-none">
        <a class="nav-item nav-link px-0 me-xl-6" href="javascript:void(0)">
            <i class="icon-base ri ri-menu-line icon-22px"></i>
        </a>
    </div>

    {{-- ── Right side items ────────────────────────────────────────────── --}}
    <div class="navbar-nav-right d-flex align-items-center justify-content-between w-100" id="navbar-collapse">

        {{-- ── Search toggler (left side of right section) ─────────────── --}}
        <div class="navbar-nav align-items-center">
            <div class="nav-item navbar-search-wrapper mb-0">
                <a class="nav-item nav-link search-toggler d-flex align-items-center gap-2 px-0 text-body-secondary"
                   href="javascript:void(0);"
                   style="font-size: 0.82rem;">
                    <i class="icon-base ri ri-search-line icon-20px"></i>
                    <span class="d-none d-sm-inline" id="autocomplete">Search…</span>
                    <span class="d-none d-md-inline-flex align-items-center gap-1 ms-2"
                          style="font-size: 0.7rem; background: #f3f4f6; border: 1px solid #e5e7eb;
                                 border-radius: 4px; padding: 1px 6px; color: #9ca3af; font-family: monospace;">
                        ⌘K
                    </span>
                </a>
            </div>
        </div>

        {{-- ── Icon group: right ──────────────────────────────────────── --}}
        <ul class="navbar-nav flex-row align-items-center gap-1">

            {{-- Theme / Dark-mode switcher --}}
            <li class="nav-item dropdown">
                <a class="nav-link btn btn-icon btn-text-secondary rounded-pill hide-arrow"
                   id="nav-theme"
                   href="javascript:void(0);"
                   data-bs-toggle="dropdown"
                   title="Switch theme">
                    <i class="icon-base ri ri-sun-line icon-22px theme-icon-active"></i>
                </a>
                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="nav-theme">
                    <li>
                        <button type="button" class="dropdown-item d-flex align-items-center gap-2 active" data-bs-theme-value="light">
                            <i class="icon-base ri ri-sun-line icon-20px"></i> Light
                        </button>
                    </li>
                    <li>
                        <button type="button" class="dropdown-item d-flex align-items-center gap-2" data-bs-theme-value="dark">
                            <i class="icon-base ri ri-moon-clear-line icon-20px"></i> Dark
                        </button>
                    </li>
                    <li>
                        <button type="button" class="dropdown-item d-flex align-items-center gap-2" data-bs-theme-value="system">
                            <i class="icon-base ri ri-computer-line icon-20px"></i> System
                        </button>
                    </li>
                </ul>
            </li>

            {{-- Quick shortcuts dropdown --}}
            <li class="nav-item dropdown-shortcuts dropdown">
                <a class="nav-link btn btn-icon btn-text-secondary rounded-pill hide-arrow"
                   href="javascript:void(0);"
                   data-bs-toggle="dropdown"
                   data-bs-auto-close="outside"
                   title="Quick links">
                    <i class="icon-base ri ri-apps-2-line icon-22px"></i>
                </a>
                <div class="dropdown-menu dropdown-menu-end p-0" style="width: 260px;">
                    <div class="dropdown-menu-header border-bottom">
                        <div class="dropdown-header d-flex align-items-center py-3 px-4">
                            <h6 class="mb-0 me-auto fw-semibold" style="font-size:0.82rem;">Quick Access</h6>
                        </div>
                    </div>
                    <div class="p-3">
                        <div class="row g-2">
                            @php
                                $shortcuts = [
                                    ['route' => 'admin.invoices.index',  'icon' => 'ri-file-list-3-line', 'label' => 'Invoices'],
                                    ['route' => 'admin.invoices.create', 'icon' => 'ri-file-add-line',    'label' => 'New Invoice'],
                                    ['route' => 'admin.clients.index',   'icon' => 'ri-group-line',        'label' => 'Clients'],
                                    ['route' => 'admin.clients.create',  'icon' => 'ri-user-add-line',     'label' => 'New Client'],
                                    ['route' => 'admin.projects.index',  'icon' => 'ri-layout-column-line','label' => 'Projects'],
                                    ['route' => 'admin.inbox.index',     'icon' => 'ri-inbox-line',        'label' => 'Inbox'],
                                ];
                            @endphp
                            @foreach($shortcuts as $sc)
                                <div class="col-4">
                                    <a href="{{ route($sc['route']) }}"
                                       class="d-flex flex-column align-items-center gap-1 p-2 rounded text-decoration-none text-center"
                                       style="border: 1px solid #f0f0f0; transition: background 0.15s, border-color 0.15s;"
                                       onmouseover="this.style.background='color-mix(in sRGB, var(--pac-peridot) 8%, white)'; this.style.borderColor='rgba(181,204,24,0.35)';"
                                       onmouseout="this.style.background='transparent'; this.style.borderColor='#f0f0f0';">
                                        <i class="ri {{ $sc['icon'] }}" style="font-size:1.25rem; color: var(--pac-peridot-dim);"></i>
                                        <span style="font-size:0.68rem; color:#374151; font-weight:500; line-height:1.2;">{{ $sc['label'] }}</span>
                                    </a>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </li>

            {{-- Notification bell --}}
            <li class="nav-item dropdown-notifications dropdown">
                <a class="nav-link btn btn-icon btn-text-secondary rounded-pill hide-arrow"
                   href="javascript:void(0);"
                   data-bs-toggle="dropdown"
                   data-bs-auto-close="outside"
                   title="Notifications">
                    <i class="icon-base ri ri-notification-3-line icon-22px"></i>
                    {{--
                        Wire up: when unread notifications exist, add a badge span here.
                        Use position:absolute; top:6px; right:6px on the parent nav-link.
                        Show count capped at 9+ using a text-bg-danger rounded-pill badge.
                    --}}
                </a>
                <div class="dropdown-menu dropdown-menu-end p-0" style="width: 340px; max-height: 480px;">

                    {{-- Notification header --}}
                    <div class="dropdown-menu-header border-bottom">
                        <div class="dropdown-header d-flex align-items-center py-3 px-4">
                            <h6 class="mb-0 me-auto fw-semibold" style="font-size:0.82rem;">Notifications</h6>
                            <a href="javascript:void(0)" class="text-body-secondary" style="font-size:0.72rem;" title="Mark all read">
                                <i class="ri ri-check-double-line me-1"></i> All read
                            </a>
                        </div>
                    </div>

                    {{-- Notification list --}}
                    <ul class="list-group list-group-flush overflow-auto" style="max-height: 340px;">
                        {{--
                            Wire up: pass $notifications to the navbar component or use
                            a View::share() call in AppServiceProvider.
                            Loop: forelse($notifications as $n) — each item needs:
                            avatar (icon or image), title, body text, created_at->diffForHumans()
                            and a dismiss/archive action link.
                        --}}
                        <li class="list-group-item list-group-item-action py-3 px-4">
                            <div class="d-flex gap-3 align-items-start">
                                <div class="avatar avatar-sm flex-shrink-0">
                                    <span class="avatar-initial rounded-circle"
                                          style="background: color-mix(in sRGB, var(--pac-peridot) 15%, white); color: var(--pac-peridot-dim); font-size:0.75rem;">
                                        <i class="ri ri-information-line"></i>
                                    </span>
                                </div>
                                <div class="flex-grow-1 min-width-0">
                                    <p class="mb-1 fw-semibold" style="font-size:0.8rem;">Welcome to The Pacmedia Admin</p>
                                    <p class="mb-1 text-body-secondary" style="font-size:0.75rem;">Your dashboard is ready. Start by adding a client or creating an invoice.</p>
                                    <small class="text-body-secondary" style="font-size:0.7rem;">just now</small>
                                </div>
                                <div class="flex-shrink-0">
                                    <a href="javascript:void(0)" title="Dismiss">
                                        <i class="ri ri-close-line text-body-secondary"></i>
                                    </a>
                                </div>
                            </div>
                        </li>
                        {{-- More notification items here --}}
                    </ul>

                    {{-- Notification footer --}}
                    <div class="border-top p-3 text-center">
                        <a href="{{ route('admin.inbox.index') }}"
                           class="btn btn-sm w-100 fw-medium"
                           style="background: #111827; color: #fff; border-radius: 0.5rem; font-size: 0.78rem;">
                            View All Messages
                        </a>
                    </div>

                </div>
            </li>

            {{-- ── User avatar dropdown ─────────────────────────────── --}}
            <li class="nav-item navbar-dropdown dropdown-user dropdown ms-1">
                <a class="nav-link dropdown-toggle hide-arrow d-flex align-items-center gap-2"
                   href="javascript:void(0);"
                   data-bs-toggle="dropdown">
                    <div class="avatar avatar-online">
                        @if(auth()->user()->avatar ?? null)
                            <img src="{{ auth()->user()->avatar }}" alt="{{ auth()->user()->name }}" class="rounded-circle" />
                        @else
                            <span class="avatar-initial rounded-circle fw-bold"
                                  style="background: color-mix(in sRGB, var(--pac-peridot) 20%, #111827); color: var(--pac-peridot); font-size: 0.78rem;">
                                {{ strtoupper(substr(auth()->user()->name ?? 'U', 0, 2)) }}
                            </span>
                        @endif
                    </div>
                    <span class="d-none d-lg-block" style="font-size: 0.82rem; font-weight: 600; color: #111827; max-width: 120px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">
                        {{ auth()->user()->name ?? 'User' }}
                    </span>
                </a>

                <ul class="dropdown-menu dropdown-menu-end mt-3 py-2" style="min-width: 210px;">

                    {{-- User info header --}}
                    <li>
                        <a class="dropdown-item pe-none" href="#">
                            <div class="d-flex align-items-center gap-2">
                                <div class="avatar avatar-online flex-shrink-0">
                                    @if(auth()->user()->avatar ?? null)
                                        <img src="{{ auth()->user()->avatar }}" alt="{{ auth()->user()->name }}" class="rounded-circle w-px-40 h-auto" />
                                    @else
                                        <span class="avatar-initial rounded-circle fw-bold"
                                              style="background: color-mix(in sRGB, var(--pac-peridot) 20%, #111827); color: var(--pac-peridot); font-size: 0.78rem;">
                                            {{ strtoupper(substr(auth()->user()->name ?? 'U', 0, 2)) }}
                                        </span>
                                    @endif
                                </div>
                                <div class="flex-grow-1 min-width-0">
                                    <h6 class="mb-0 fw-semibold" style="font-size:0.82rem; overflow:hidden; text-overflow:ellipsis; white-space:nowrap;">
                                        {{ auth()->user()->name ?? 'User' }}
                                    </h6>
                                    <small class="text-body-secondary" style="font-size:0.72rem; overflow:hidden; text-overflow:ellipsis; display:block; white-space:nowrap;">
                                        {{ auth()->user()->email ?? '' }}
                                    </small>
                                </div>
                            </div>
                        </a>
                    </li>

                    <li><div class="dropdown-divider my-1"></div></li>

                    <li>
                        <a class="dropdown-item d-flex align-items-center gap-2" href="{{ route('admin.settings.index') }}">
                            <i class="icon-base ri ri-user-3-line icon-20px text-body-secondary"></i>
                            <span>My Profile</span>
                        </a>
                    </li>
                    <li>
                        <a class="dropdown-item d-flex align-items-center gap-2" href="{{ route('admin.settings.index') }}">
                            <i class="icon-base ri ri-settings-4-line icon-20px text-body-secondary"></i>
                            <span>Settings</span>
                        </a>
                    </li>

                    <li><div class="dropdown-divider my-1"></div></li>

                    {{-- Logout --}}
                    <li>
                        <div class="px-3 py-1">
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit"
                                        class="btn w-100 d-flex align-items-center justify-content-center gap-2"
                                        style="background: #111827; color: #fff; border-radius: 0.5rem; font-size: 0.78rem; padding: 0.45rem 1rem;">
                                    <span>Sign Out</span>
                                    <i class="ri ri-logout-box-r-line icon-16px"></i>
                                </button>
                            </form>
                        </div>
                    </li>

                </ul>
            </li>

        </ul>
    </div>
</nav>
