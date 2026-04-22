<nav class="layout-navbar container-xxl navbar-detached navbar navbar-expand-xl align-items-center bg-navbar-theme"
     id="layout-navbar">

    {{-- Mobile sidebar toggle --}}
    <div class="layout-menu-toggle navbar-nav align-items-xl-center me-4 me-xl-0 d-xl-none">
        <a class="nav-item nav-link px-0 me-xl-6" href="javascript:void(0)">
            <i class="icon-base ri ri-menu-line icon-22px"></i>
        </a>
    </div>

    <div class="navbar-nav-right d-flex align-items-center justify-content-end w-100" id="navbar-collapse">

        {{-- Right side: theme toggle + user dropdown --}}
        <ul class="navbar-nav flex-row align-items-center gap-2 ms-auto">

            {{-- ─── Dark / Light mode toggle ──────────────────── --}}
            <li class="nav-item">
                <div class="nav-link btn-text-secondary rounded-pill btn-icon hide-arrow"
                     data-bs-toggle="dropdown"
                     aria-expanded="false">
                    <i class="icon-base ri ri-sun-line icon-22px"></i>
                </div>
                <ul class="dropdown-menu dropdown-menu-end" style="min-width: 10rem;">
                    <li>
                        <button type="button" class="dropdown-item active"
                                data-bs-theme-value="light" aria-pressed="true">
                            <i class="icon-base ri ri-sun-line icon-22px me-3"></i> Light
                        </button>
                    </li>
                    <li>
                        <button type="button" class="dropdown-item"
                                data-bs-theme-value="dark" aria-pressed="false">
                            <i class="icon-base ri ri-moon-line icon-22px me-3"></i> Dark
                        </button>
                    </li>
                    <li>
                        <button type="button" class="dropdown-item"
                                data-bs-theme-value="system" aria-pressed="false">
                            <i class="icon-base ri ri-computer-line icon-22px me-3"></i> System
                        </button>
                    </li>
                </ul>
            </li>

            {{-- ─── User dropdown ──────────────────────────────── --}}
            <li class="nav-item navbar-dropdown dropdown-user dropdown">
                <a class="nav-link dropdown-toggle hide-arrow p-0"
                   href="javascript:void(0);"
                   data-bs-toggle="dropdown">
                    <div class="avatar avatar-online">
                        @if(auth()->user()->profile_photo_path ?? false)
                            <img src="{{ asset('storage/' . auth()->user()->profile_photo_path) }}"
                                 alt="{{ auth()->user()->name }}"
                                 class="rounded-circle w-px-40 h-auto">
                        @else
                            {{-- Initials fallback --}}
                            <span class="avatar-initial rounded-circle bg-label-primary"
                                  style="background-color: color-mix(in sRGB, var(--pac-peridot) 15%, white) !important; color: var(--pac-peridot-dim) !important; font-weight: 600; font-size: 0.875rem;">
                                {{ strtoupper(substr(auth()->user()->name, 0, 2)) }}
                            </span>
                        @endif
                    </div>
                </a>

                <ul class="dropdown-menu dropdown-menu-end">

                    {{-- User info --}}
                    <li>
                        <a class="dropdown-item" href="{{ route('admin.settings.index') }}">
                            <div class="d-flex">
                                <div class="flex-shrink-0 me-3">
                                    <div class="avatar avatar-online">
                                        @if(auth()->user()->profile_photo_path ?? false)
                                            <img src="{{ asset('storage/' . auth()->user()->profile_photo_path) }}"
                                                 alt="{{ auth()->user()->name }}"
                                                 class="w-px-40 h-auto rounded-circle">
                                        @else
                                            <span class="avatar-initial rounded-circle"
                                                  style="background-color: color-mix(in sRGB, var(--pac-peridot) 15%, white) !important; color: var(--pac-peridot-dim) !important; font-weight: 600;">
                                                {{ strtoupper(substr(auth()->user()->name, 0, 2)) }}
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="flex-grow-1">
                                    <h6 class="mb-0">{{ auth()->user()->name }}</h6>
                                    <small class="text-body-secondary">
                                        {{ ucfirst(auth()->user()->role ?? 'Admin') }}
                                    </small>
                                </div>
                            </div>
                        </a>
                    </li>

                    <li><div class="dropdown-divider my-1"></div></li>

                    <li>
                        <a class="dropdown-item" href="{{ route('admin.settings.index') }}">
                            <i class="icon-base ri ri-user-line icon-22px me-3"></i>
                            <span>My Profile</span>
                        </a>
                    </li>
                    <li>
                        <a class="dropdown-item" href="{{ route('admin.settings.index') }}">
                            <i class="icon-base ri ri-settings-4-line icon-22px me-3"></i>
                            <span>Settings</span>
                        </a>
                    </li>

                    <li><div class="dropdown-divider my-1"></div></li>

                    {{-- Logout --}}
                    <li>
                        <div class="d-grid px-4 pt-2 pb-1">
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="btn btn-sm btn-danger d-flex align-items-center justify-content-center w-100">
                                    <small class="align-middle">Log out</small>
                                    <i class="icon-base ri ri-logout-box-r-line ms-2 icon-16px"></i>
                                </button>
                            </form>
                        </div>
                    </li>

                </ul>
            </li>
            {{-- ─── / User dropdown ────────────────────────────── --}}

        </ul>
    </div>
</nav>
