<aside id="layout-menu" class="layout-menu menu-vertical menu">

    {{-- ─── Brand ──────────────────────────────────────────────── --}}
    <div class="app-brand demo">
        <a href="{{ route('admin.dashboard') }}" class="app-brand-link">

            <img src="{{ asset('img/logo-full.svg') }}"
                 alt="The Pacmedia"
                 class="pac-logo-full">

            <img src="{{ asset('img/logo-mark.svg') }}"
                 alt="The Pacmedia"
                 class="pac-logo-mark">

        </a>

        <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                <path d="M8.47365 11.7183C8.11707 12.0749 8.11707 12.6531 8.47365 13.0097L12.071 16.607C12.4615 16.9975 12.4615 17.6305 12.071 18.021C11.6805 18.4115 11.0475 18.4115 10.657 18.021L5.83009 13.1941C5.37164 12.7356 5.37164 11.9924 5.83009 11.5339L10.657 6.707C11.0475 6.31653 11.6805 6.31653 12.071 6.707C12.4615 7.09747 12.4615 7.73053 12.071 8.121L8.47365 11.7183Z" fill-opacity="0.9"/>
                <path d="M14.3584 11.8336C14.0654 12.1266 14.0654 12.6014 14.3584 12.8944L18.071 16.607C18.4615 16.9975 18.4615 17.6305 18.071 18.021C17.6805 18.4115 17.0475 18.4115 16.657 18.021L11.6819 13.0459C11.3053 12.6693 11.3053 12.0587 11.6819 11.6821L16.657 6.707C17.0475 6.31653 17.6805 6.31653 18.071 6.707C18.4615 7.09747 18.4615 7.73053 18.071 8.121L14.3584 11.8336Z" fill-opacity="0.4"/>
            </svg>
        </a>
    </div>
    {{-- ─── / Brand ─────────────────────────────────────────────── --}}

    <div class="menu-inner-shadow"></div>

    <ul class="menu-inner py-1">

        {{-- ─── Dashboard ──────────────────────────────────────── --}}
        <li class="menu-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
            <a href="{{ route('admin.dashboard') }}" class="menu-link">
                <i class="menu-icon icon-base ri ri-dashboard-line"></i>
                <div data-i18n="Dashboard">Dashboard</div>
            </a>
        </li>

        {{-- ─── Divider ─────────────────────────────────────────── --}}
        <li class="menu-header small text-uppercase">
            <span class="menu-header-text">Business</span>
        </li>

        {{-- ─── Invoices ────────────────────────────────────────── --}}
        <li class="menu-item {{ request()->routeIs('admin.invoices.*') ? 'active open' : '' }}">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon icon-base ri ri-file-list-3-line"></i>
                <div data-i18n="Invoices">Invoices</div>
            </a>
            <ul class="menu-sub">
                <li class="menu-item {{ request()->routeIs('admin.invoices.index') ? 'active' : '' }}">
                    <a href="{{ route('admin.invoices.index') }}" class="menu-link">
                        <div data-i18n="All Invoices">All Invoices</div>
                    </a>
                </li>
                <li class="menu-item {{ request()->routeIs('admin.invoices.create') ? 'active' : '' }}">
                    <a href="{{ route('admin.invoices.create') }}" class="menu-link">
                        <div data-i18n="New Invoice">New Invoice</div>
                    </a>
                </li>
            </ul>
        </li>

        {{-- ─── Clients ─────────────────────────────────────────── --}}
{{--        <li class="menu-item {{ request()->routeIs('admin.clients.*') ? 'active open' : '' }}">--}}
{{--            <a href="javascript:void(0);" class="menu-link menu-toggle">--}}
{{--                <i class="menu-icon icon-base ri ri-group-line"></i>--}}
{{--                <div data-i18n="Clients">Clients</div>--}}
{{--            </a>--}}
{{--            <ul class="menu-sub">--}}
{{--                <li class="menu-item {{ request()->routeIs('admin.clients.index') ? 'active' : '' }}">--}}
{{--                    <a href="{{ route('admin.clients.index') }}" class="menu-link">--}}
{{--                        <div data-i18n="All Clients">All Clients</div>--}}
{{--                    </a>--}}
{{--                </li>--}}
{{--                <li class="menu-item {{ request()->routeIs('admin.clients.create') ? 'active' : '' }}">--}}
{{--                    <a href="{{ route('admin.clients.create') }}" class="menu-link">--}}
{{--                        <div data-i18n="Add Client">Add Client</div>--}}
{{--                    </a>--}}
{{--                </li>--}}
{{--            </ul>--}}
{{--        </li>--}}
        <li class="menu-item {{ request()->routeIs('admin.clients.*') ? 'active open' : '' }}">
            <a href="{{ route('admin.clients.index') }}" class="menu-link">
                <i class="menu-icon icon-base ri ri-group-line"></i>
                <div data-i18n="Clients">Clients</div>
            </a>
        </li>

        {{-- ─── Divider ─────────────────────────────────────────── --}}
        <li class="menu-header small text-uppercase">
            <span class="menu-header-text">Work</span>
        </li>

        {{-- ─── Projects / Kanban ───────────────────────────────── --}}
        <li class="menu-item {{ request()->routeIs('admin.projects.*') ? 'active' : '' }}">
            <a href="{{ route('admin.projects.index') }}" class="menu-link">
                <i class="menu-icon icon-base ri ri-layout-column-line"></i>
                <div data-i18n="Projects">Projects</div>
            </a>
        </li>

        {{-- ─── Letters ─────────────────────────────────────────── --}}
        <li class="menu-item {{ request()->routeIs('admin.letters.*') ? 'active' : '' }}">
            <a href="{{ route('admin.letters.index') }}" class="menu-link">
                <i class="menu-icon icon-base ri ri-quill-pen-line"></i>
                <div data-i18n="Letters">Letters</div>
            </a>
        </li>

        {{-- ─── Divider ─────────────────────────────────────────── --}}
        <li class="menu-header small text-uppercase">
            <span class="menu-header-text">Communication</span>
        </li>

        {{-- ─── Inbox ───────────────────────────────────────────── --}}
        <li class="menu-item {{ request()->routeIs('admin.inbox.*') ? 'active' : '' }}">
            <a href="{{ route('admin.inbox.index') }}" class="menu-link">
                <i class="menu-icon icon-base ri ri-mail-line"></i>
                <div data-i18n="Inbox">Inbox</div>
                {{-- Unread badge — wire to real count later --}}
                {{-- <span class="badge badge-center rounded-pill bg-danger ms-auto">3</span> --}}
            </a>
        </li>

        {{-- ─── Chat ────────────────────────────────────────────── --}}
        <li class="menu-item {{ request()->routeIs('admin.chat.*') ? 'active' : '' }}">
            <a href="{{ route('admin.chat.index') }}" class="menu-link">
                <i class="menu-icon icon-base ri ri-message-3-line"></i>
                <div data-i18n="Chat">Chat</div>
            </a>
        </li>

        {{-- ─── Divider ─────────────────────────────────────────── --}}
        <li class="menu-header small text-uppercase">
            <span class="menu-header-text">System</span>
        </li>

        {{-- ─── Activity Logs ───────────────────────────────────── --}}
        <li class="menu-item {{ request()->routeIs('admin.logs.*') ? 'active' : '' }}">
            <a href="{{ route('admin.logs.index') }}" class="menu-link">
                <i class="menu-icon icon-base ri ri-history-line"></i>
                <div data-i18n="Activity Logs">Activity Logs</div>
            </a>
        </li>

        {{-- ─── Settings ────────────────────────────────────────── --}}
        <li class="menu-item {{ request()->routeIs('admin.settings.*') ? 'active' : '' }}">
            <a href="{{ route('admin.settings.index') }}" class="menu-link">
                <i class="menu-icon icon-base ri ri-settings-4-line"></i>
                <div data-i18n="Settings">Settings</div>
            </a>
        </li>

    </ul>
</aside>
