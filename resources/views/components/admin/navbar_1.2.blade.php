{{--
    ┌──────────────────────────────────────────────────────────────────────────┐
    │  resources/views/components/admin/navbar.blade.php                        │
    │  The Pacmedia — Admin navbar  (v3 — fixed)                                │
    │                                                                            │
    │  Root causes fixed vs v2:                                                  │
    │  1. Mobile search moved OUT of <nav> flex row into a sibling div          │
    │  2. CSS moved to admin.blade.php <style> block (see INSTALL NOTE below)   │
    │  3. icon-base class restored on all Remix Icon elements                   │
    │  4. search-toggler class kept on desktop trigger for template compat       │
    │  5. Theme switcher uses template's own data-bs-theme-value system         │
    │  6. Inline JS uses DOMContentLoaded — no conflict with template JS        │
    └──────────────────────────────────────────────────────────────────────────┘

    ══════════════════════════════════════════════════════════════════════════════
    INSTALL NOTE — ADD THIS CSS TO admin.blade.php <style> BLOCK
    (inside the existing brand overrides <style> tag — do NOT @push from here)
    ══════════════════════════════════════════════════════════════════════════════

        /* ── Navbar enhancements ── */
        #layout-navbar {
            border-radius: 0.75rem;
            margin: 0.875rem 1.5rem 0;
            box-shadow: 0 2px 12px rgba(0,0,0,0.06);
            border: 1px solid rgba(0,0,0,0.05);
        }
        .pac-search-trigger {
            display: flex; align-items: center; gap: 0.5rem;
            font-size: 0.82rem; color: var(--bs-body-secondary);
            padding: 0.3rem 0.75rem; border-radius: 0.5rem;
            border: 1px solid transparent;
            transition: background 0.15s, border-color 0.15s;
            text-decoration: none;
        }
        .pac-search-trigger:hover {
            background: rgba(0,0,0,0.04); border-color: #e5e7eb;
            color: var(--bs-body-color);
        }
        .pac-kbd {
            font-size: 0.67rem; font-family: ui-monospace, monospace;
            background: #f3f4f6; border: 1px solid #e5e7eb;
            border-radius: 4px; padding: 1px 5px; color: #9ca3af;
        }
        .pac-notif-badge {
            position: absolute; top: 2px; right: 2px;
            min-width: 16px; height: 16px; border-radius: 10px;
            background: #ef4444; color: #fff;
            font-size: 0.58rem; font-weight: 800;
            display: flex; align-items: center; justify-content: center;
            padding: 0 3px; border: 2px solid #fff;
            pointer-events: none; line-height: 1;
        }
        .pac-shortcut-item {
            display: flex; flex-direction: column; align-items: center;
            gap: 0.3rem; padding: 0.6rem 0.25rem; border-radius: 0.5rem;
            border: 1px solid #f0f0f0; text-decoration: none;
            transition: background 0.15s, border-color 0.15s; text-align: center;
        }
        .pac-shortcut-item:hover {
            background: color-mix(in sRGB, var(--pac-peridot) 8%, white);
            border-color: rgba(181,204,24,0.4);
        }
        .pac-shortcut-item i   { font-size: 1.2rem; color: var(--pac-peridot-dim); }
        .pac-shortcut-item span { font-size: 0.67rem; color: #374151; font-weight: 600; }
        .pac-notif-item {
            display: flex; gap: 0.75rem; align-items: flex-start;
            padding: 0.875rem 1.125rem; border-bottom: 1px solid #f3f4f6;
            transition: background 0.12s; position: relative;
        }
        .pac-notif-item:last-child { border-bottom: none; }
        .pac-notif-item:hover { background: #fafafa; }
        .pac-notif-item.unread { background: rgba(181,204,24,0.04); }
        .pac-notif-item.unread::before {
            content: ''; position: absolute; left: 0; top: 0; bottom: 0;
            width: 3px; background: var(--pac-peridot);
        }
        .pac-notif-dismiss {
            flex-shrink: 0; color: #d1d5db; background: none; border: none;
            padding: 0; font-size: 1rem; cursor: pointer; line-height: 1;
            transition: color 0.12s;
        }
        .pac-notif-dismiss:hover { color: #6b7280; }
        .pac-user-avatar-init {
            width: 34px; height: 34px; border-radius: 50%;
            background: color-mix(in sRGB, var(--pac-peridot) 20%, #111827);
            color: var(--pac-peridot); font-size: 0.75rem; font-weight: 800;
            display: flex; align-items: center; justify-content: center;
            position: relative; flex-shrink: 0; overflow: hidden;
        }
        .pac-user-avatar-init::after {
            content: ''; position: absolute; bottom: 1px; right: 1px;
            width: 8px; height: 8px; border-radius: 50%;
            background: var(--pac-peridot); border: 2px solid #fff;
        }
        .pac-user-avatar-init img {
            width: 100%; height: 100%; border-radius: 50%; object-fit: cover;
        }
        /* Mobile search bar — sits BELOW the nav as a sibling div */
        .pac-mobile-search-bar {
            display: none;
            padding: 0.5rem 1.5rem 0.875rem;
        }
        .pac-mobile-search-bar.open { display: block; }
        .pac-mobile-search-bar input {
            width: 100%; padding: 0.5rem 0.875rem;
            border-radius: 0.5rem; border: 1px solid #e5e7eb;
            font-size: 0.84rem; outline: none;
            transition: border-color 0.15s, box-shadow 0.15s;
        }
        .pac-mobile-search-bar input:focus {
            border-color: var(--pac-peridot);
            box-shadow: 0 0 0 3px rgba(181,204,24,0.12);
        }
        /* Dark mode */
        [data-bs-theme="dark"] #layout-navbar {
            border-color: rgba(255,255,255,0.06);
            box-shadow: 0 2px 16px rgba(0,0,0,0.35);
        }
        [data-bs-theme="dark"] .pac-search-trigger:hover {
            background: rgba(255,255,255,0.06); border-color: rgba(255,255,255,0.1);
        }
        [data-bs-theme="dark"] .pac-kbd {
            background: rgba(255,255,255,0.08); border-color: rgba(255,255,255,0.1);
        }
        [data-bs-theme="dark"] .pac-shortcut-item { border-color: rgba(255,255,255,0.07); }
        [data-bs-theme="dark"] .pac-shortcut-item:hover {
            background: rgba(181,204,24,0.1); border-color: rgba(181,204,24,0.3);
        }
        [data-bs-theme="dark"] .pac-shortcut-item span { color: rgba(255,255,255,0.75); }
        [data-bs-theme="dark"] .pac-notif-item { border-color: rgba(255,255,255,0.05); }
        [data-bs-theme="dark"] .pac-notif-item:hover { background: rgba(255,255,255,0.03); }
        [data-bs-theme="dark"] .pac-notif-item.unread { background: rgba(181,204,24,0.06); }
        [data-bs-theme="dark"] .pac-user-avatar-init::after { border-color: var(--bs-paper-bg, #2b2c40); }
        [data-bs-theme="dark"] .pac-mobile-search-bar input {
            background: rgba(255,255,255,0.07); border-color: rgba(255,255,255,0.1); color: #fff;
        }

    ══════════════════════════════════════════════════════════════════════════════
    END OF CSS TO ADD TO admin.blade.php
    ══════════════════════════════════════════════════════════════════════════════
--}}

<nav class="layout-navbar container-xxl navbar-detached navbar navbar-expand-xl align-items-center bg-navbar-theme"
     id="layout-navbar">

    {{-- Mobile sidebar toggle --}}
    <div class="layout-menu-toggle navbar-nav align-items-xl-center me-3 me-xl-0 d-xl-none">
        <a class="nav-item nav-link px-0 me-xl-6" href="javascript:void(0)" aria-label="Toggle sidebar">
            <i class="icon-base ri ri-menu-line icon-22px"></i>
        </a>
    </div>

    <div class="navbar-nav-right d-flex align-items-center justify-content-between w-100" id="navbar-collapse">

        {{-- ── LEFT: Search ─────────────────────────────────────────────── --}}
        <div class="navbar-nav align-items-center">

            {{-- Desktop search (hooks into template's Algolia search overlay) --}}
            <a class="pac-search-trigger search-toggler d-none d-sm-flex"
               href="javascript:void(0);"
               aria-label="Open search">
                <i class="icon-base ri ri-search-line" style="font-size:1rem;"></i>
                <span style="color:#9ca3af;">Search anything…</span>
                <span class="pac-kbd d-none d-md-inline">⌘K</span>
            </a>

            {{-- Mobile: icon only, reveals search bar below --}}
            <a class="nav-item nav-link px-0 d-flex d-sm-none"
               href="javascript:void(0);"
               id="pac-mobile-search-btn"
               aria-label="Search">
                <i class="icon-base ri ri-search-line icon-22px"></i>
            </a>

        </div>

        {{-- ── RIGHT: Icon cluster ──────────────────────────────────────── --}}
        <ul class="navbar-nav flex-row align-items-center gap-1 ms-auto">

            {{-- Theme switcher --}}
            <li class="nav-item dropdown">
                <a class="nav-link btn btn-icon btn-text-secondary rounded-pill hide-arrow"
                   href="javascript:void(0);"
                   data-bs-toggle="dropdown"
                   aria-label="Switch theme"
                   aria-expanded="false">
                    <i class="icon-base ri ri-sun-line icon-22px"></i>
                </a>
                <ul class="dropdown-menu dropdown-menu-end" style="min-width:160px; border-radius:0.625rem;">
                    <li>
                        <button type="button" class="dropdown-item d-flex align-items-center gap-2" data-bs-theme-value="light">
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

            {{-- Quick shortcuts --}}
            <li class="nav-item dropdown dropdown-shortcuts">
                <a class="nav-link btn btn-icon btn-text-secondary rounded-pill hide-arrow"
                   href="javascript:void(0);"
                   data-bs-toggle="dropdown"
                   data-bs-auto-close="outside"
                   aria-label="Quick shortcuts"
                   aria-expanded="false">
                    <i class="icon-base ri ri-apps-2-line icon-22px"></i>
                </a>
                <div class="dropdown-menu dropdown-menu-end p-0"
                     style="width:270px; border-radius:0.75rem; overflow:hidden;">
                    <div class="d-flex align-items-center justify-content-between px-4 py-3 border-bottom">
                        <h6 class="mb-0 fw-semibold" style="font-size:0.82rem;">Quick Access</h6>
                        <span style="font-size:0.68rem; color:#9ca3af;">Jump anywhere</span>
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
                                    ['route' => 'admin.chat.index',      'icon' => 'ri-message-3-line',     'label' => 'Chat'],
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

            {{-- Notification bell --}}
            <li class="nav-item dropdown dropdown-notifications">
                <a class="nav-link btn btn-icon btn-text-secondary rounded-pill hide-arrow position-relative"
                   href="javascript:void(0);"
                   data-bs-toggle="dropdown"
                   data-bs-auto-close="outside"
                   aria-label="Notifications"
                   aria-expanded="false">
                    <i class="icon-base ri ri-notification-3-line icon-22px"></i>
                    {{--
                        WIRE BADGE — add inside AppServiceProvider:
                        View::composer('components.admin.navbar', fn($v) =>
                            $v->with('unreadCount', auth()->user()?->unreadNotifications()->count() ?? 0)
                        );
                        Then uncomment:
                        @if(($unreadCount ?? 0) > 0)
                            <span class="pac-notif-badge">
                                {{ ($unreadCount ?? 0) > 9 ? '9+' : $unreadCount }}
                            </span>
                        @endif
                    --}}
                </a>

                <div class="dropdown-menu dropdown-menu-end p-0"
                     style="width:350px; border-radius:0.75rem; overflow:hidden;">

                    <div class="d-flex align-items-center justify-content-between px-4 py-3 border-bottom"
                         style="background:#fafafa;">
                        <h6 class="mb-0 fw-semibold" style="font-size:0.82rem;">Notifications</h6>
                        <a href="javascript:void(0);" id="pac-mark-all-read"
                           style="font-size:0.72rem; color:var(--pac-peridot-dim); text-decoration:none; display:flex; align-items:center; gap:3px;">
                            <i class="icon-base ri ri-check-double-line"></i> Mark all read
                        </a>
                    </div>

                    <ul class="list-unstyled mb-0" id="pac-notif-list"
                        style="max-height:330px; overflow-y:auto;">
                        {{--
                            WIRE: @forelse($notifications ?? [] as $notif)
                            <li class="pac-notif-item {{ $notif->read_at ? '' : 'unread' }}"
                                data-notif-id="{{ $notif->id }}">
                                <div class="avatar avatar-sm flex-shrink-0">
                                    <span class="avatar-initial rounded-circle"
                                          style="background:rgba(181,204,24,0.12);color:var(--pac-peridot-dim);font-size:0.75rem;">
                                        <i class="ri ri-{{ $notif->data['icon'] ?? 'information-line' }}"></i>
                                    </span>
                                </div>
                                <div class="flex-grow-1 min-width-0">
                                    <p class="mb-1 fw-semibold" style="font-size:0.79rem;">{{ $notif->data['title'] }}</p>
                                    <p class="mb-1 text-body-secondary" style="font-size:0.73rem;">{{ $notif->data['body'] }}</p>
                                    <small style="font-size:0.68rem;color:#9ca3af;">{{ $notif->created_at->diffForHumans() }}</small>
                                </div>
                                <button class="pac-notif-dismiss" data-notif-id="{{ $notif->id }}" title="Dismiss">
                                    <i class="icon-base ri ri-close-line"></i>
                                </button>
                            </li>
                            @empty ... @endforelse
                        --}}

                        {{-- Placeholder (remove once wired) --}}
                        <li class="pac-notif-item unread">
                            <div class="avatar avatar-sm flex-shrink-0">
                                <span class="avatar-initial rounded-circle"
                                      style="background:rgba(181,204,24,0.12);color:var(--pac-peridot-dim);font-size:0.75rem;">
                                    <i class="ri ri-information-line"></i>
                                </span>
                            </div>
                            <div class="flex-grow-1 min-width-0">
                                <p class="mb-1 fw-semibold" style="font-size:0.79rem;">Welcome to The Pacmedia Admin</p>
                                <p class="mb-1 text-body-secondary" style="font-size:0.73rem; line-height:1.45;">Your dashboard is live. Start by adding a client or creating an invoice.</p>
                                <small style="font-size:0.68rem; color:#9ca3af;">just now</small>
                            </div>
                            <button class="pac-notif-dismiss" title="Dismiss">
                                <i class="icon-base ri ri-close-line"></i>
                            </button>
                        </li>
                    </ul>

                    <div id="pac-notif-empty" style="display:none; padding:2rem; text-align:center;">
                        <i class="icon-base ri ri-notification-off-line"
                           style="font-size:1.75rem; color:#d1d5db; display:block; margin-bottom:0.5rem;"></i>
                        <p style="font-size:0.78rem; color:#9ca3af; margin:0;">All caught up!</p>
                    </div>

                    <div class="border-top p-3" style="background:#fafafa;">
                        <a href="{{ route('admin.inbox.index') }}"
                           class="btn w-100 fw-semibold"
                           style="background:#111827; color:#fff; border-radius:0.5rem; font-size:0.78rem;">
                            View All Messages
                        </a>
                    </div>

                </div>
            </li>

            {{-- Divider --}}
            <li class="nav-item d-none d-xl-flex align-items-center">
                <div style="width:1px; height:20px; background:var(--bs-border-color); margin:0 0.25rem;"></div>
            </li>

            {{-- User dropdown --}}
            <li class="nav-item navbar-dropdown dropdown-user dropdown">
                <a class="nav-link dropdown-toggle hide-arrow d-flex align-items-center gap-2 py-1 px-2"
                   style="border-radius:0.5rem; text-decoration:none;"
                   href="javascript:void(0);"
                   data-bs-toggle="dropdown">

                    <div class="pac-user-avatar-init">
                        @if(auth()->user()->profile_photo_path ?? false)
                            <img src="{{ asset('storage/' . auth()->user()->profile_photo_path) }}"
                                 alt="{{ auth()->user()->name }}">
                        @else
                            {{ strtoupper(substr(auth()->user()->name ?? 'U', 0, 2)) }}
                        @endif
                    </div>

                    <div class="d-none d-lg-block lh-1">
                        <div style="font-size:0.82rem; font-weight:700; color:var(--pac-ink); max-width:110px; overflow:hidden; text-overflow:ellipsis; white-space:nowrap;">
                            {{ auth()->user()->name ?? 'User' }}
                        </div>
                        <div style="font-size:0.67rem; color:#9ca3af; margin-top:1px;">
                            {{ ucfirst(auth()->user()->role ?? 'Admin') }}
                        </div>
                    </div>

                    <i class="icon-base ri ri-arrow-down-s-line d-none d-lg-block"
                       style="font-size:0.9rem; color:#9ca3af;"></i>

                </a>

                <ul class="dropdown-menu dropdown-menu-end py-0"
                    style="min-width:215px; border-radius:0.75rem; overflow:hidden;">

                    {{-- Clickable user header --}}
                    <li>
                        <a class="dropdown-item py-0 px-3" href="{{ route('admin.settings.index') }}"
                           style="border-bottom:1px solid var(--bs-border-color);">
                            <div class="d-flex align-items-center gap-2 py-3">
                                <div class="pac-user-avatar-init" style="width:40px;height:40px;font-size:0.82rem;">
                                    @if(auth()->user()->profile_photo_path ?? false)
                                        <img src="{{ asset('storage/' . auth()->user()->profile_photo_path) }}"
                                             alt="{{ auth()->user()->name }}">
                                    @else
                                        {{ strtoupper(substr(auth()->user()->name ?? 'U', 0, 2)) }}
                                    @endif
                                </div>
                                <div class="flex-grow-1 min-width-0">
                                    <div class="fw-semibold" style="font-size:0.82rem; overflow:hidden; text-overflow:ellipsis; white-space:nowrap;">
                                        {{ auth()->user()->name ?? 'User' }}
                                    </div>
                                    <div class="text-body-secondary" style="font-size:0.72rem; overflow:hidden; text-overflow:ellipsis; white-space:nowrap;">
                                        {{ auth()->user()->email ?? '' }}
                                    </div>
                                </div>
                            </div>
                        </a>
                    </li>

                    <li>
                        <a class="dropdown-item d-flex align-items-center gap-2 py-2"
                           href="{{ route('admin.settings.index') }}">
                            <i class="icon-base ri ri-user-3-line icon-20px text-body-secondary"></i>
                            My Profile
                        </a>
                    </li>
                    <li>
                        <a class="dropdown-item d-flex align-items-center gap-2 py-2"
                           href="{{ route('admin.settings.index') }}">
                            <i class="icon-base ri ri-settings-4-line icon-20px text-body-secondary"></i>
                            Settings
                        </a>
                    </li>
                    <li>
                        <a class="dropdown-item d-flex align-items-center gap-2 py-2"
                           href="{{ route('admin.logs.index') }}">
                            <i class="icon-base ri ri-history-line icon-20px text-body-secondary"></i>
                            Activity Log
                        </a>
                    </li>

                    <li><div class="dropdown-divider my-1"></div></li>

                    <li>
                        <div class="d-grid px-3 pb-3 pt-1">
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit"
                                        class="btn d-flex align-items-center justify-content-center gap-2 w-100"
                                        style="background:#111827; color:#fff; border-radius:0.5rem; font-size:0.78rem; padding:0.45rem 1rem;">
                                    Sign Out
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

{{--
    !! CRITICAL !!
    This div MUST be a sibling of <nav>, not inside it.
    The <nav> is display:flex — any child renders inline.
    This sits below the navbar and opens downward.
--}}
<div class="pac-mobile-search-bar container-xxl d-sm-none" id="pac-mobile-search-bar">
    <input type="text"
           id="pac-mobile-search-input"
           placeholder="Search invoices, clients, projects…"
           autocomplete="off">
</div>


{{-- Navbar JS — inline is fine here, runs after DOM ready --}}
<script>
    (function () {
        'use strict';

        document.addEventListener('DOMContentLoaded', function () {

            /* ⌘K / Ctrl+K → fire template search toggler */
            document.addEventListener('keydown', function (e) {
                if ((e.metaKey || e.ctrlKey) && e.key === 'k') {
                    e.preventDefault();
                    var t = document.querySelector('.search-toggler');
                    if (t) t.click();
                }
            });

            /* Mobile search toggle */
            var btn   = document.getElementById('pac-mobile-search-btn');
            var bar   = document.getElementById('pac-mobile-search-bar');
            var input = document.getElementById('pac-mobile-search-input');

            if (btn && bar) {
                btn.addEventListener('click', function () {
                    var open = bar.classList.toggle('open');
                    if (open && input) setTimeout(function () { input.focus(); }, 60);
                });
                document.addEventListener('keydown', function (e) {
                    if (e.key === 'Escape') bar.classList.remove('open');
                });
            }

            /* Notification dismiss */
            var list  = document.getElementById('pac-notif-list');
            var empty = document.getElementById('pac-notif-empty');

            function checkEmpty() {
                if (list && empty)
                    empty.style.display = list.querySelectorAll('.pac-notif-item').length ? 'none' : 'block';
            }

            document.addEventListener('click', function (e) {
                var btn  = e.target.closest('.pac-notif-dismiss');
                if (!btn) return;
                var item = btn.closest('.pac-notif-item');
                if (!item) return;
                item.style.cssText += ';transition:opacity .2s,max-height .25s,padding .25s;overflow:hidden;max-height:' + item.scrollHeight + 'px';
                requestAnimationFrame(function () {
                    item.style.opacity = '0';
                    item.style.maxHeight = '0';
                    item.style.paddingTop = '0';
                    item.style.paddingBottom = '0';
                });
                setTimeout(function () { item.remove(); checkEmpty(); }, 280);
                /*
                 * WIRE: fetch('/admin/notifications/' + btn.dataset.notifId + '/dismiss', {
                 *     method:'POST', headers:{'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content}
                 * });
                 */
            });

            /* Mark all read */
            var markAll = document.getElementById('pac-mark-all-read');
            if (markAll) {
                markAll.addEventListener('click', function (e) {
                    e.preventDefault();
                    if (list) list.querySelectorAll('.pac-notif-item.unread').forEach(function (el) { el.classList.remove('unread'); });
                    /*
                     * WIRE: fetch('/admin/notifications/mark-all-read', {
                     *     method:'POST', headers:{'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content}
                     * });
                     */
                });
            }

        });
    })();
</script>
