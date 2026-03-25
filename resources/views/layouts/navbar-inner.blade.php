{{-- ================================================ --}}
{{-- Secondary Navbar — Inner Pages --}}
{{-- resources/views/layouts/navbar-inner.blade.php --}}
{{-- ================================================ --}}

{{-- Desktop: bottom-left fixed nav --}}
<header id="header" class="header d-flex justify-content-center loading__fade">
    <div class="header__navigation d-flex justify-content-start">
        <nav id="menu" class="menu">
            <ul class="menu__list d-flex justify-content-start align-items-center">
                <li class="menu__item">
                    <a class="menu__link btn" href="{{ url('/') }}">
                        <span class="menu__caption">Home</span>
                        <i class="ph ph-house-simple"></i>
                    </a>
                </li>
                <li class="menu__item inner-nav__separator" aria-hidden="true">
                    <span class="inner-nav__slash">/</span>
                </li>
                <li class="menu__item">
                    <a class="menu__link btn active" href="{{ url()->current() }}">
                        <span class="menu__caption">{{ $pageTitle ?? 'Page' }}</span>
                        <i class="ph {{ $pageIcon ?? 'ph-file' }}"></i>
                    </a>
                </li>
            </ul>
        </nav>
    </div>
</header>

{{-- Mobile: dropdown nav --}}
<div class="translucent-element menu-call-container">
    <button class="menu-toggle" id="menu-toggle" aria-label="Toggle menu">
        <span class="hamburger-icon"></span>
    </button>&nbsp;&nbsp;

    <a href="#!" class="book-call-btn">
        <span class="book-call-text">Initiate Briefing</span>
        <span class="call-icon">
            <svg version="1.0" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 64 64"
                 preserveAspectRatio="xMidYMid meet" aria-hidden="true">
                <g transform="translate(0,64) scale(0.1,-0.1)">
                    <path d="M245 631 c-92 -24 -173 -90 -215 -176 -33 -69 -34 -199 -2 -265 35-71 75 -114 144 -151 58 -31 70 -34 148 -33 72 0 93 4 136 26 75 40 107 70 145 140 31 58 34 70 34 148 0 78 -3 90 -34 148 -57 104 -144 160 -260 167 -36 2 -79 1 -96 -4z m-1 -161 l36 -40 -21 -29 c-28 -37 -20 -58 41 -115 55 -52 66-55 103 -26 l26 21 41 -37 c46 -41 49 -58 18 -91 -49 -52 -154 -18 -256 83-97 97 -130 198 -80 251 30 33 50 29 92 -17z"/>
                </g>
            </svg>
        </span>
    </a>

    <div class="dropdown translucent-element" id="menu-dropdown">
        {{-- Home --}}
        <a href="{{ url('/') }}" class="dropdown-item">
            <i class="menu-icon ph ph-house-simple"></i>Home
        </a>
        <div class="dropdown-divider"></div>
        {{-- Current page — active --}}
        <a href="{{ url()->current() }}" class="dropdown-item inner-nav__active-item">
            <i class="menu-icon {{ $pageIcon ?? 'ph ph-file' }}"></i>
            {{ $pageTitle ?? 'Page' }}
            <i class="ph ph-check inner-nav__check"></i>
        </a>
    </div>
</div>
