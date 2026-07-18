{{-- ================================================ --}}
{{-- Secondary Navbar — Inner Pages --}}
{{-- resources/views/layouts/navbar-inner.blade.php --}}
{{-- ─────────────────────────────────────────────────── --}}
{{-- Two dropdown-only crumbs live here, each gated to its
     own page type so they never leak onto unrelated pages:

     - "Case Studies" — shown only on a case study page,
       lists every OTHER case study from resources/markdown/works/*.md
     - "Capabilities"  — shown only on a service page,
       lists every OTHER service from the $services variable
       (already shared to every view — same source the footer uses)

     Both open DOWNWARD since this navbar sits at the top of
     the page. Adjust the route names below if yours differ. --}}
{{-- ================================================ --}}

@php
    use Illuminate\Support\Facades\File;
    use League\CommonMark\Environment\Environment;
    use League\CommonMark\Extension\CommonMark\CommonMarkCoreExtension;
    use League\CommonMark\Extension\FrontMatter\FrontMatterExtension;
    use League\CommonMark\Extension\FrontMatter\Output\RenderedContentWithFrontMatter;
    use League\CommonMark\MarkdownConverter;

    $currentUrl = url()->current();

    $mdEnv = new Environment();
    $mdEnv->addExtension(new CommonMarkCoreExtension());
    $mdEnv->addExtension(new FrontMatterExtension());
    $mdConverter = new MarkdownConverter($mdEnv);

    // ---------- Case Studies (route: portfolio.show) ----------
    $isCaseStudyPage = request()->routeIs('portfolio.show');
    $innerNavAllCaseStudies = [];
    $innerNavOtherCaseStudies = [];

    if ($isCaseStudyPage) {
        $worksPath = resource_path('markdown/works');

        if (File::isDirectory($worksPath)) {
            $innerNavAllCaseStudies = collect(File::files($worksPath))
                ->filter(fn($f) => $f->getExtension() === 'md')
                ->map(function ($f) use ($mdConverter, $currentUrl) {
                    $result = $mdConverter->convert(File::get($f->getPathname()));
                    $matter = $result instanceof RenderedContentWithFrontMatter
                        ? $result->getFrontMatter() : [];
                    $slug = $f->getFilenameWithoutExtension();
                    $url = route('portfolio.show', $slug);
                    return [
                        'slug'      => $slug,
                        'order'     => $matter['order'] ?? 99,
                        'title'     => $matter['title'] ?? $slug,
                        'tagline'   => $matter['service'] ?? null,
                        'icon'      => $matter['icon'] ?? null,
                        'url'       => $url,
                        'isCurrent' => $url === $currentUrl,
                    ];
                })
                ->sortBy('order')
                ->values()
                ->all();
        }

        $innerNavOtherCaseStudies = collect($innerNavAllCaseStudies)
            ->reject(fn($item) => $item['isCurrent'])
            ->take(5)
            ->values()
            ->all();
    }

    // ---------- Capabilities / Services (route: service.show) ----------
    // $services is already shared to every view (see the footer, which
    // consumes it the same way) — no need to read markdown here ourselves.
    $isServicePage = request()->routeIs('service.show');
    $innerNavAllServices = [];
    $innerNavOtherServices = [];

    if ($isServicePage) {
        $innerNavAllServices = collect($services ?? [])
            ->map(function ($service) use ($currentUrl) {
                $url = route('service.show', ['slug' => $service['slug']]);
                return [
                    'slug'      => $service['slug'],
                    'title'     => $service['title_plain'] ?? $service['title'],
                    'icon'      => $service['icon'] ?? null,
                    'url'       => $url,
                    'isCurrent' => $url === $currentUrl,
                ];
            })
            ->values()
            ->all();

        $innerNavOtherServices = collect($innerNavAllServices)
            ->reject(fn($item) => $item['isCurrent'])
            ->values()
            ->all();
    }
@endphp

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

                @if($isCaseStudyPage)
                    <li class="menu__item inner-nav__separator" aria-hidden="true">
                        <span class="inner-nav__slash">/</span>
                    </li>

                    {{-- Case Studies — dropdown-only crumb, no page of its own --}}
                    <li class="menu__item inner-nav__dropdown-wrap">
                        <button type="button"
                                class="menu__link btn inner-nav__dropdown-trigger"
                                aria-haspopup="true"
                                aria-expanded="false">
                            <span class="menu__caption">Case Studies</span>
                            <i class="ph ph-caret-down inner-nav__dropdown-caret"></i>
                        </button>

                        @if(count($innerNavOtherCaseStudies) > 0)
                            <div class="cs-dropdown" role="menu" aria-label="Other case studies">
                                @foreach($innerNavOtherCaseStudies as $i => $item)
                                    <a href="{{ $item['url'] }}" class="cs-dropdown__item" role="menuitem">
                                        <span class="cs-dropdown__index">{{ str_pad($i + 1, 2, '0', STR_PAD_LEFT) }}</span>
                                        <span class="cs-dropdown__info">
                                            <span class="cs-dropdown__title">{{ $item['title'] }}</span>
                                            @if(!empty($item['tagline']))
                                                <span class="cs-dropdown__tagline">{{ $item['tagline'] }}</span>
                                            @endif
                                        </span>
                                        <i class="ph ph-arrow-up-right cs-dropdown__arrow" aria-hidden="true"></i>
                                    </a>
                                @endforeach
                            </div>
                        @endif
                    </li>
                @elseif($isServicePage)
                    <li class="menu__item inner-nav__separator" aria-hidden="true">
                        <span class="inner-nav__slash">/</span>
                    </li>

                    {{-- Capabilities — dropdown-only crumb, no page of its own --}}
                    <li class="menu__item inner-nav__dropdown-wrap">
                        <button type="button"
                                class="menu__link btn inner-nav__dropdown-trigger"
                                aria-haspopup="true"
                                aria-expanded="false">
                            <span class="menu__caption">Capabilities</span>
                            <i class="ph ph-caret-down inner-nav__dropdown-caret"></i>
                        </button>

                        @if(count($innerNavOtherServices) > 0)
                            <div class="cs-dropdown" role="menu" aria-label="Other services">
                                @foreach($innerNavOtherServices as $i => $item)
                                    <a href="{{ $item['url'] }}" class="cs-dropdown__item" role="menuitem">
                                        <span class="cs-dropdown__index">{{ str_pad($i + 1, 2, '0', STR_PAD_LEFT) }}</span>
                                        <span class="cs-dropdown__info">
                                            <span class="cs-dropdown__title">{{ $item['title'] }}</span>
                                        </span>
                                        <i class="ph ph-arrow-up-right cs-dropdown__arrow" aria-hidden="true"></i>
                                    </a>
                                @endforeach
                            </div>
                        @endif
                    </li>
                @endif

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

        @if($isCaseStudyPage)
            {{-- Every case study, current one checked & selected, in natural order --}}
            @foreach($innerNavAllCaseStudies as $item)
                @if($item['isCurrent'])
                    <a href="{{ $item['url'] }}" class="dropdown-item inner-nav__active-item">
                        <i class="menu-icon ph ph-circle"></i>
                        {{ $item['title'] }}
                        <i class="ph ph-check inner-nav__check"></i>
                    </a>
                @else
                    <a href="{{ $item['url'] }}" class="dropdown-item">
                        <i class="menu-icon ph ph-circle"></i>{{ $item['title'] }}
                    </a>
                @endif
                @unless($loop->last)
                    <div class="dropdown-divider"></div>
                @endunless
            @endforeach
        @elseif($isServicePage)
            {{-- Every service, current one checked & selected, each with its own icon --}}
            @foreach($innerNavAllServices as $item)
                @if($item['isCurrent'])
                    <a href="{{ $item['url'] }}" class="dropdown-item inner-nav__active-item">
                        <i class="menu-icon {{ $item['icon'] ?? 'ph ph-file' }}"></i>
                        {{ $item['title'] }}
                        <i class="ph ph-check inner-nav__check"></i>
                    </a>
                @else
                    <a href="{{ $item['url'] }}" class="dropdown-item">
                        <i class="menu-icon {{ $item['icon'] ?? 'ph ph-file' }}"></i>{{ $item['title'] }}
                    </a>
                @endif
                @unless($loop->last)
                    <div class="dropdown-divider"></div>
                @endunless
            @endforeach
        @else
            {{-- Neither — just the current page, as before --}}
            <a href="{{ url()->current() }}" class="dropdown-item inner-nav__active-item">
                <i class="menu-icon ph {{ $pageIcon ?? 'ph-file' }}"></i>
                {{ $pageTitle ?? 'Page' }}
                <i class="ph ph-check inner-nav__check"></i>
            </a>
        @endif
    </div>
</div>

{{-- Toggle behaviour for any crumb dropdown (Case Studies, Capabilities, or
     future ones) — generalised so it isn't duplicated per crumb type. --}}
<script>
    document.addEventListener('DOMContentLoaded', function () {
        document.querySelectorAll('.inner-nav__dropdown-wrap').forEach(function (wrap) {
            var trigger = wrap.querySelector('.inner-nav__dropdown-trigger');
            var panel = wrap.querySelector('.cs-dropdown');
            if (!trigger || !panel) return;

            function closePanel() {
                panel.classList.remove('open');
                trigger.setAttribute('aria-expanded', 'false');
            }

            trigger.addEventListener('click', function (e) {
                e.stopPropagation();
                var isOpen = panel.classList.toggle('open');
                trigger.setAttribute('aria-expanded', isOpen ? 'true' : 'false');
            });

            document.addEventListener('click', function (e) {
                if (!wrap.contains(e.target)) closePanel();
            });

            document.addEventListener('keydown', function (e) {
                if (e.key === 'Escape') closePanel();
            });
        });
    });
</script>
