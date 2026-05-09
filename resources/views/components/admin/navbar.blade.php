{{--
    navbar.blade.php — The Pacmedia Admin

    ROOT CAUSE OF ALL PREVIOUS FAILURES:
    main.js line: container: '#autocomplete'
    Algolia autocomplete() targets id="autocomplete" and REPLACES the entire
    navbar-search-wrapper content with its own detached search UI.
    This was restructuring the navbar on every load, collapsing the right side.

    FIX: Keep id="autocomplete" on an empty <span> inside the template's exact
    search wrapper structure — exactly as the original template HTML does it.
    Our styled search look is achieved via CSS on the wrapper, not by replacing
    the Algolia hook element.

    CARD STYLE TOGGLE:
    Sits between shortcuts and notifications. On xl+ it shows icon + text label.
    On smaller screens the text labels collapse and only icons show, keeping the
    toggle compact. The group itself is hidden below sm (phones) and tucked into
    the user dropdown instead — see the dropdown additions at the bottom.
--}}

<nav class="layout-navbar container-xxl navbar-detached navbar navbar-expand-xl align-items-center bg-navbar-theme"
     id="layout-navbar">

    {{-- Mobile sidebar toggle --}}
    <div class="layout-menu-toggle navbar-nav align-items-xl-center me-4 me-xl-0 d-xl-none">
        <a class="nav-item nav-link px-0 me-xl-6" href="javascript:void(0)">
            <i class="icon-base ri ri-menu-line icon-22px"></i>
        </a>
    </div>

    <div class="navbar-nav-right d-flex align-items-center justify-content-end" id="navbar-collapse">

        {{-- Search — desktop only --}}
        <div class="navbar-nav align-items-center d-none d-xl-flex">
            <div class="nav-item mb-0">
                <div class="pac-search-bar">
                    <i class="icon-base ri ri-search-line pac-search-icon"></i>
                    <input type="text"
                           class="pac-search-input"
                           placeholder="Search invoices, clients, projects…"
                           id="pac-search-input"
                           autocomplete="off"
                           readonly
                           onclick="this.removeAttribute('readonly'); this.focus();">
                    <span class="pac-kbd">⌘K</span>
                </div>
            </div>
        </div>

        <ul class="navbar-nav flex-row align-items-center ms-md-auto">

            {{-- Theme switcher --}}
            <li class="nav-item dropdown me-sm-1 me-xl-0">
                <a class="nav-link dropdown-toggle hide-arrow btn btn-icon btn-text-secondary rounded-pill"
                   id="nav-theme"
                   href="javascript:void(0);"
                   data-bs-toggle="dropdown">
                    <i class="icon-base ri ri-sun-line icon-22px theme-icon-active"></i>
                    <span class="d-none ms-2" id="nav-theme-text">Toggle theme</span>
                </a>
                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="nav-theme-text">
                    <li>
                        <button type="button" class="dropdown-item align-items-center active"
                                data-bs-theme-value="light" aria-pressed="false">
                            <span><i class="icon-base ri ri-sun-line icon-22px me-3" data-icon="sun-line"></i>Light</span>
                        </button>
                    </li>
                    <li>
                        <button type="button" class="dropdown-item align-items-center"
                                data-bs-theme-value="dark" aria-pressed="true">
                            <span><i class="icon-base ri ri-moon-clear-line icon-22px me-3" data-icon="moon-clear-line"></i>Dark</span>
                        </button>
                    </li>
                    <li>
                        <button type="button" class="dropdown-item align-items-center"
                                data-bs-theme-value="system" aria-pressed="false">
                            <span><i class="icon-base ri ri-computer-line icon-22px me-3" data-icon="computer-line"></i>System</span>
                        </button>
                    </li>
                </ul>
            </li>

            {{-- Quick shortcuts --}}
            <li class="nav-item dropdown-shortcuts navbar-dropdown dropdown me-sm-1 me-xl-0">
                <a class="nav-link dropdown-toggle hide-arrow btn btn-icon btn-text-secondary rounded-pill"
                   href="javascript:void(0);"
                   data-bs-toggle="dropdown"
                   data-bs-auto-close="outside"
                   aria-expanded="false">
                    <i class="icon-base ri ri-apps-2-line icon-22px"></i>
                </a>
                <div class="dropdown-menu dropdown-menu-end p-0"
                     style="width:270px; border-radius:0.625rem; overflow:hidden;">
                    <div class="dropdown-menu-header border-bottom">
                        <div class="dropdown-header d-flex align-items-center py-3 px-4">
                            <h6 class="mb-0 me-auto fw-semibold" style="font-size:0.82rem;">Quick Access</h6>
                            <span style="font-size:0.68rem; color:#9ca3af;">Jump anywhere</span>
                        </div>
                    </div>
                    <div class="p-3">
                        <div class="row g-2">
                            @php
                                $shortcuts = [
                                    ['route' => 'admin.invoices.index',  'icon' => 'ri-file-list-3-line',  'label' => 'Invoices'],
                                    ['route' => 'admin.invoices.create', 'icon' => 'ri-file-add-line',     'label' => 'New Invoice'],
                                    ['route' => 'admin.clients.index',   'icon' => 'ri-group-line',         'label' => 'Clients'],
                                    ['route' => 'admin.clients.create',  'icon' => 'ri-user-add-line',      'label' => 'Add Client'],
                                    ['route' => 'admin.projects.index',  'icon' => 'ri-layout-column-line', 'label' => 'Projects'],
                                    ['route' => 'admin.inbox.index',     'icon' => 'ri-inbox-line',         'label' => 'Inbox'],
                                    ['route' => 'admin.letters.index',   'icon' => 'ri-quill-pen-line',     'label' => 'Letters'],
                                    ['route' => 'admin.mail.compose',    'icon' => 'ri-message-3-line',     'label' => 'Send Mail'],
                                    ['route' => 'admin.logs.index',      'icon' => 'ri-history-line',       'label' => 'Logs'],
                                ];
                            @endphp
                            @foreach($shortcuts as $sc)
                                <div class="col-4">
                                    <a href="{{ route($sc['route']) }}" class="pac-shortcut-item">
                                        <i class="icon-base ri {{ $sc['icon'] }}"></i>
                                        <span>{{ $sc['label'] }}</span>
                                    </a>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </li>

            {{-- ── Card style toggle ────────────────────────────────────────────
                 Visible from sm upward (hidden on xs phones — available in the
                 user dropdown below instead). Labels collapse at sm–md so only
                 the icons show, keeping the navbar tidy on tablets.
            ──────────────────────────────────────────────────────────────────── --}}
            <li class="nav-item d-none d-sm-flex align-items-center me-sm-1 me-xl-2">
                <div class="pac-cst-group" role="group" aria-label="Card shadow style">

                    <button type="button"
                            class="pac-cst-btn"
                            data-set-card-style="flat"
                            title="Flat — no shadow"
                            aria-label="Flat cards">
                        <i class="ri ri-layout-line"></i>
                        <span class="pac-cst-label d-none d-xl-inline">Flat</span>
                    </button>

                    <button type="button"
                            class="pac-cst-btn"
                            data-set-card-style="elevated"
                            title="Elevated — subtle shadow"
                            aria-label="Elevated cards">
                        <i class="ri ri-stack-line"></i>
                        <span class="pac-cst-label d-none d-xl-inline">Elevated</span>
                    </button>

                    <button type="button"
                            class="pac-cst-btn"
                            data-set-card-style="floating"
                            title="Floating — deep shadow"
                            aria-label="Floating cards">
                        <i class="ri ri-drop-line"></i>
                        <span class="pac-cst-label d-none d-xl-inline">Floating</span>
                    </button>

                </div>
            </li>
            {{-- /Card style toggle --}}

            {{-- Notifications --}}
            <li class="nav-item dropdown-notifications navbar-dropdown dropdown me-4 me-xl-1">
                <a class="nav-link dropdown-toggle hide-arrow btn btn-icon btn-text-secondary rounded-pill"
                   href="javascript:void(0);"
                   data-bs-toggle="dropdown"
                   data-bs-auto-close="outside"
                   aria-expanded="false">
                    <i class="icon-base ri ri-notification-3-line icon-22px"></i>
                    {{--
                        WIRE BADGE: @if(($unreadCount ?? 0) > 0)
                            <span class="position-absolute top-0 start-50 translate-middle-y badge badge-dot bg-danger mt-2 border"></span>
                        @endif
                    --}}
                </a>
                <ul class="dropdown-menu dropdown-menu-end py-0">
                    <li class="dropdown-menu-header border-bottom py-50">
                        <div class="dropdown-header d-flex align-items-center py-2">
                            <h6 class="mb-0 me-auto">Notifications</h6>
                            <div class="d-flex align-items-center h6 mb-0">
                                <a href="javascript:void(0)"
                                   class="dropdown-notifications-all p-2"
                                   data-bs-toggle="tooltip"
                                   data-bs-placement="top"
                                   title="Mark all as read">
                                    <i class="icon-base ri ri-mail-open-line text-heading"></i>
                                </a>
                            </div>
                        </div>
                    </li>
                    <li class="dropdown-notifications-list scrollable-container">
                        <ul class="list-group list-group-flush">
                            {{--
                                WIRE: @forelse($notifications ?? [] as $notif)
                                <li class="list-group-item list-group-item-action dropdown-notifications-item {{ $notif->read_at ? 'marked-as-read' : '' }}">
                                    <div class="d-flex">
                                        <div class="flex-shrink-0 me-3">
                                            <div class="avatar">
                                                <span class="avatar-initial rounded-circle bg-label-primary">
                                                    <i class="icon-base ri ri-{{ $notif->data['icon'] ?? 'information-line' }} icon-18px"></i>
                                                </span>
                                            </div>
                                        </div>
                                        <div class="flex-grow-1">
                                            <h6 class="small mb-1">{{ $notif->data['title'] }}</h6>
                                            <small class="mb-1 d-block text-body">{{ $notif->data['body'] }}</small>
                                            <small class="text-body-secondary">{{ $notif->created_at->diffForHumans() }}</small>
                                        </div>
                                        <div class="flex-shrink-0 dropdown-notifications-actions">
                                            <a href="javascript:void(0)" class="dropdown-notifications-read">
                                                <span class="badge badge-dot"></span>
                                            </a>
                                            <a href="javascript:void(0)" class="dropdown-notifications-archive">
                                                <span class="icon-base ri ri-close-line"></span>
                                            </a>
                                        </div>
                                    </div>
                                </li>
                                @empty ... @endforelse
                            --}}
                            <li class="list-group-item list-group-item-action dropdown-notifications-item">
                                <div class="d-flex">
                                    <div class="flex-shrink-0 me-3">
                                        <div class="avatar">
                                            <span class="avatar-initial rounded-circle"
                                                  style="background:color-mix(in sRGB,var(--pac-peridot) 15%,white);color:var(--pac-peridot-dim);">
                                                <i class="icon-base ri ri-information-line icon-18px"></i>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="flex-grow-1">
                                        <h6 class="small mb-1">Welcome to The Pacmedia Admin</h6>
                                        <small class="mb-1 d-block text-body">Your dashboard is live. Start by adding a client or creating an invoice.</small>
                                        <small class="text-body-secondary">just now</small>
                                    </div>
                                    <div class="flex-shrink-0 dropdown-notifications-actions">
                                        <a href="javascript:void(0)" class="dropdown-notifications-read">
                                            <span class="badge badge-dot"></span>
                                        </a>
                                        <a href="javascript:void(0)" class="dropdown-notifications-archive">
                                            <span class="icon-base ri ri-close-line"></span>
                                        </a>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </li>
                    <li class="border-top">
                        <div class="d-grid p-4">
                            <a class="btn btn-sm d-flex align-items-center justify-content-center gap-2 fw-semibold"
                               href="{{ route('admin.inbox.index') }}"
                               style="background:#111827; color:#fff; border-radius:0.5rem;">
                                <small class="align-middle">View all messages</small>
                            </a>
                        </div>
                    </li>
                </ul>
            </li>

            {{-- User dropdown --}}
            <li class="nav-item navbar-dropdown dropdown-user dropdown">
                <a class="nav-link dropdown-toggle hide-arrow" href="javascript:void(0);" data-bs-toggle="dropdown">
                    <div class="avatar avatar-online">
                        @if(auth()->user()->profile_photo_path ?? false)
                            <img src="{{ asset('storage/' . auth()->user()->profile_photo_path) }}"
                                 alt="{{ auth()->user()->name }}"
                                 class="rounded-circle w-px-40 h-auto">
                        @else
                            <span class="avatar-initial rounded-circle fw-bold"
                                  style="background:color-mix(in sRGB,var(--pac-peridot) 20%,#111827);color:var(--pac-peridot);font-size:0.78rem;">
                                {{ strtoupper(substr(auth()->user()->name ?? 'U', 0, 2)) }}
                            </span>
                        @endif
                    </div>
                </a>
                <ul class="dropdown-menu dropdown-menu-end mt-3 py-2">
                    <li>
                        <a class="dropdown-item" href="{{ route('admin.settings.index') }}">
                            <div class="d-flex align-items-center">
                                <div class="flex-shrink-0 me-2">
                                    <div class="avatar avatar-online">
                                        @if(auth()->user()->profile_photo_path ?? false)
                                            <img src="{{ asset('storage/' . auth()->user()->profile_photo_path) }}"
                                                 alt="{{ auth()->user()->name }}"
                                                 class="w-px-40 h-auto rounded-circle">
                                        @else
                                            <span class="avatar-initial rounded-circle fw-bold"
                                                  style="background:color-mix(in sRGB,var(--pac-peridot) 20%,#111827);color:var(--pac-peridot);font-size:0.78rem;">
                                                {{ strtoupper(substr(auth()->user()->name ?? 'U', 0, 2)) }}
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="flex-grow-1">
                                    <h6 class="mb-0 small">{{ auth()->user()->name ?? 'User' }}</h6>
                                    <small class="text-body-secondary">{{ ucfirst(auth()->user()->role ?? 'Admin') }}</small>
                                </div>
                            </div>
                        </a>
                    </li>
                    <li><div class="dropdown-divider"></div></li>
                    <li>
                        <a class="dropdown-item" href="{{ route('admin.settings.index') }}">
                            <i class="icon-base ri ri-user-3-line icon-22px me-3"></i>
                            <span class="align-middle">My Profile</span>
                        </a>
                    </li>
                    <li>
                        <a class="dropdown-item" href="{{ route('admin.settings.index') }}">
                            <i class="icon-base ri ri-settings-4-line icon-22px me-3"></i>
                            <span class="align-middle">Settings</span>
                        </a>
                    </li>
                    <li>
                        <a class="dropdown-item" href="{{ route('admin.logs.index') }}">
                            <i class="icon-base ri ri-history-line icon-22px me-3"></i>
                            <span class="align-middle">Activity Log</span>
                        </a>
                    </li>

                    {{-- ── Card style — mobile fallback (xs only, hidden sm+) ──────
                         On phones the toggle group is hidden from the navbar.
                         These three items expose the same functionality inside
                         the user dropdown so it's never inaccessible.
                    ────────────────────────────────────────────────────────────── --}}
                    <li class="d-sm-none"><div class="dropdown-divider"></div></li>
                    <li class="d-sm-none px-4 py-2">
                        <p class="text-body-secondary mb-2" style="font-size:0.7rem; font-weight:700; text-transform:uppercase; letter-spacing:.07em;">
                            Card style
                        </p>
                        <div class="d-flex gap-2">
                            <button type="button"
                                    class="btn btn-sm flex-fill pac-cst-btn pac-cst-btn--mobile"
                                    data-set-card-style="flat"
                                    style="font-size:0.75rem;">
                                <i class="ri ri-layout-line me-1"></i>Flat
                            </button>
                            <button type="button"
                                    class="btn btn-sm flex-fill pac-cst-btn pac-cst-btn--mobile"
                                    data-set-card-style="elevated"
                                    style="font-size:0.75rem;">
                                <i class="ri ri-stack-line me-1"></i>Elevated
                            </button>
                            <button type="button"
                                    class="btn btn-sm flex-fill pac-cst-btn pac-cst-btn--mobile"
                                    data-set-card-style="floating"
                                    style="font-size:0.75rem;">
                                <i class="ri ri-drop-line me-1"></i>Float
                            </button>
                        </div>
                    </li>
                    {{-- /Card style mobile fallback --}}

                    <li><div class="dropdown-divider"></div></li>
                    <li>
                        <div class="d-grid px-4 pt-2 pb-1">
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit"
                                        class="btn btn-sm d-flex align-items-center justify-content-center gap-2 w-100"
                                        style="background:#111827;color:#fff;border-radius:0.5rem;font-size:0.78rem;padding:0.45rem 1rem;">
                                    <small class="align-middle">Sign Out</small>
                                    <i class="icon-base ri ri-logout-box-r-line icon-16px"></i>
                                </button>
                            </form>
                        </div>
                    </li>
                </ul>
            </li>

        </ul>
    </div>
</nav>
