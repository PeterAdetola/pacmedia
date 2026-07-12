@extends('layouts.app')

@section('title', strip_tags($project['title']) . ' — Pacmedia')

@section('content')

    {{-- ============================================================
         PORTFOLIO DETAIL PAGE
         Route:  /work/{slug}
         Data:   PortfolioController::show()
         Source: resources/markdown/works/{slug}.md

         BLOCK ORDER (all optional except Hero + Meta)
         ─────────────────────────────────────────────
         1.  Hero                       always
         2.  Meta + Overview            always
         3.  The Brief / Challenge      challenge_html  + challenge_pullquote
         4.  Before / After             has_before_after + old/new_logo_url
         5.  Design / Dev Process       process_html
         6.  Sketch board               sketch_url
         7.  Logo System                logo_system_html
         8.  Image Grid                 grid_images[]
         9.  Colour Palette             colour_palette_url  OR colours[]
         10. Pattern 1                  pattern_1_url
         11. Pattern 2                  pattern_2_url
         12. Collateral                 collateral_url
         13. The Outcome                solution_html
         14. Storefront / Environmental storefront_url
         15. Live URL CTA               live_url
         16. Sister Brand               sister_brand
         17. Client Feedback            feedback
    ============================================================ --}}

    <section id="portfolio-detail" class="inner inner-grid-bottom">
        <div class="inner__wrapper">
            <div class="container-fluid p-0">
                <div class="row g-0">

                    {{-- ── Sidebar label ─────────────────────────────────── --}}
                    <div class="col-12 col-xl-2">
                        <div class="inner__name">
                            <div class="content__block name-block">
                                <span class="section-name icon-right animate-in-up">
                                    <span class="section-name-caption">
                                        {{ $project['index'] }} — Work
                                    </span>
                                    <i class="ph ph-arrow-down-right"></i>
                                </span>
                            </div>
                        </div>
                    </div>

                    {{-- ── Main column ────────────────────────────────────── --}}
                    <div class="col-12 col-xl-8">
                        <div class="inner__content">


                            {{-- ════════════════════════════════════════════
                                 1. HERO
                                 Full-bleed image, no title overlay.
                                 Landscape / portrait swap via orientation MQ.
                                 Tagline pill sits top-left.
                            ═════════════════════════════════════════════ --}}
                            <div class="project__block no-padding no-margin">
                                <div class="project-image-bg animate-in-up">
                                    <img class="project-image-bg__landscape"
                                         src="{{ $project['hero_landscape_url'] }}"
                                         alt="{{ strip_tags($project['title']) }}"
                                         fetchpriority="high"
                                         decoding="sync">
                                    <img class="project-image-bg__portrait"
                                         src="{{ $project['hero_portrait_url'] }}"
                                         alt="{{ strip_tags($project['title']) }}"
                                         fetchpriority="high"
                                         decoding="sync">
                                    @if (!empty($project['tagline']))
                                        <div class="project__hero-pill animate-in-up">
                                            {{ $project['tagline'] }}
                                        </div>
                                    @endif
                                </div>
                            </div>


                            {{-- ════════════════════════════════════════════
                                 2. META + OVERVIEW
                                 Left col:  pdata items stacked vertically
                                 Right col: overview body text (HTML from MD)
                            ═════════════════════════════════════════════ --}}
                            <div class="project__block grid-block grid-items">
                                <div class="project__data">
                                    <div class="container-fluid p-0">
                                        <div class="row g-0">

                                            {{-- Meta list --}}
                                            <div class="col-12 col-xl-4 pdata__col animate-in-up">
                                                @foreach ($project['meta'] as $label => $value)
                                                    <div class="pdata__item">
                                                        <p class="data__title tagline-chapter small">{{ $label }}</p>
                                                        <p class="data__descr small">{{ $value }}</p>
                                                    </div>
                                                @endforeach
                                            </div>

                                            {{-- Overview --}}
                                            <div class="col-12 col-xl-8 grid-item animate-in-up">
                                                <div class="service-body type-basic-160lh">
                                                    {!! $project['overview_html'] !!}
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>


                            {{-- ════════════════════════════════════════════
                                 3. THE BRIEF / CHALLENGE  (optional)
                                 Left col:  "The Brief" label
                                 Right col: challenge body + optional pullquote
                            ═════════════════════════════════════════════ --}}
                            @if (!empty($project['challenge_html']))
                                <div class="project__block pre-grid-items animate-in-up">
                                    <div class="project__descr">
                                        <div class="container-fluid p-0">
                                            <div class="row g-0">
                                                <div class="col-12 col-xl-4">
                                                    <p class="project__subtitle tagline-chapter">The Brief</p>
                                                </div>
                                                <div class="col-12 col-xl-8">
                                                    <div class="service-body type-basic-160lh">
                                                        {!! $project['challenge_html'] !!}
                                                    </div>
                                                    @if (!empty($project['challenge_pullquote']))
                                                        <blockquote class="animate-in-up">
                                                            {{ $project['challenge_pullquote'] }}
                                                        </blockquote>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif


                            {{-- ════════════════════════════════════════════
                                 4. BEFORE / AFTER  (optional)
                                 Branding projects only.
                                 Requires: has_before_after, old_logo_url, new_logo_url
                                 Both panels share a fixed 4:3 canvas for scale parity.
                            ═════════════════════════════════════════════ --}}
                            @if (!empty($project['has_before_after']) && !empty($project['old_logo_url']) && !empty($project['new_logo_url']))
                                <div class="project__block grid-block no-margin animate-in-up">
                                    <div class="container-fluid p-0">
                                        <div class="row g-0">

                                            {{-- OLD LOGO --}}
                                            <div class="col-12 col-md-6 grid-item">
                                                <div class="project__illustration pf-before">
                                                    <span class="pf-label pf-label--before">Before</span>
                                                    <div class="pf-logo-canvas">
                                                        <img src="{{ $project['old_logo_url'] }}"
                                                             alt="{{ strip_tags($project['title']) }} — previous logo"
                                                             loading="lazy"
                                                             decoding="async">
                                                    </div>
                                                    <p class="pf-note pf-note--before">
                                                        {{ $project['old_logo_note'] ?? '' }}
                                                    </p>
                                                </div>
                                            </div>

                                            {{-- NEW LOGO --}}
                                            <div class="col-12 col-md-6 grid-item">
                                                <div class="project__illustration pf-after">
                                                    <span class="pf-label pf-label--after">After</span>
                                                    <div class="pf-logo-canvas">
                                                        <img src="{{ $project['new_logo_url'] }}"
                                                             alt="{{ strip_tags($project['title']) }} — new logo"
                                                             loading="lazy"
                                                             decoding="async">
                                                    </div>
                                                    <p class="pf-note pf-note--after">
                                                        {{ $project['new_logo_note'] ?? '' }}
                                                    </p>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            @endif


                            {{-- ════════════════════════════════════════════
                                 5. DESIGN / DEV PROCESS  (optional)
                                 Works for branding ("Design Process") and
                                 web ("The Process") — controller maps both
                                 headings to process_html.
                            ═════════════════════════════════════════════ --}}
                            @if (!empty($project['process_html']))
                                <div class="project__block pre-grid-items animate-in-up">
                                    <div class="project__descr">
                                        <div class="container-fluid p-0">
                                            <div class="row g-0">
                                                <div class="col-12 col-xl-4">
                                                    <p class="project__subtitle tagline-chapter">The Process</p>
                                                </div>
                                                <div class="col-12 col-xl-8">
                                                    <div class="service-body type-basic-160lh">
                                                        {!! $project['process_html'] !!}
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif


                            {{-- ════════════════════════════════════════════
                                 6. SKETCH BOARD  (optional)
                                 Full-width image — sits immediately after
                                 the process text with no extra margin.
                            ═════════════════════════════════════════════ --}}
                            @if (!empty($project['sketch_url']))
                                <div class="project__block no-margin animate-in-up">
                                    <div class="project__illustration-xl">
                                        <img src="{{ $project['sketch_url'] }}"
                                             alt="{{ strip_tags($project['title']) }} — sketches"
                                             loading="lazy"
                                             decoding="async">
                                    </div>
                                </div>
                            @endif


                            {{-- ════════════════════════════════════════════
                                 7. LOGO SYSTEM  (optional)
                                 Branding projects only.
                            ═════════════════════════════════════════════ --}}
                            @if (!empty($project['logo_system_html']))
                                <div class="project__block pre-grid-items animate-in-up">
                                    <div class="project__descr">
                                        <div class="container-fluid p-0">
                                            <div class="row g-0">
                                                <div class="col-12 col-xl-4">
                                                    <p class="project__subtitle tagline-chapter">Logo System</p>
                                                </div>
                                                <div class="col-12 col-xl-8">
                                                    <div class="service-body type-basic-160lh">
                                                        {!! $project['logo_system_html'] !!}
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif


                            {{-- ════════════════════════════════════════════
                                 8. IMAGE GRID  (optional)
                                 Each image runs full column width.
                                 Defined as grid_images[] in frontmatter.
                                 For web projects this shows screen mockups.
                                 For branding it shows identity applications.
                            ═════════════════════════════════════════════ --}}
                            @if (!empty($project['grid_images']))
                                <div class="project__block grid-block no-margin">
                                    <div class="project__illustrations">
                                        <div class="container-fluid p-0">
                                            <div class="row g-0">
                                                @foreach ($project['grid_images'] as $img)
                                                    <div class="col-12 grid-item animate-in-up">
                                                        <div class="project__illustration project__illustration--full">
                                                            <img src="{{ $img['url'] }}"
                                                                 alt="{{ $img['alt'] }}"
                                                                 loading="lazy"
                                                                 decoding="async">
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif


                            {{-- ════════════════════════════════════════════
                                 9. COLOUR SYSTEM  (optional)
                                 Priority: colour_palette_url (full-width img)
                                 Fallback:  colours[] array → rendered swatches
                            ═════════════════════════════════════════════ --}}
                            @if (!empty($project['colour_palette_url']))

                                <div class="project__block no-margin animate-in-up">
                                    <div class="project__illustration-xl pf-colour-palette">
                                        <img src="{{ $project['colour_palette_url'] }}"
                                             alt="{{ strip_tags($project['title']) }} — colour palette"
                                             loading="lazy"
                                             decoding="async">
                                    </div>
                                </div>

                            @elseif (!empty($project['colours']))

                                <div class="project__block pre-grid-items animate-in-up">
                                    <div class="project__descr">
                                        <div class="container-fluid p-0">
                                            <div class="row g-0">
                                                <div class="col-12 col-xl-4">
                                                    <p class="project__subtitle tagline-chapter">Colour System</p>
                                                </div>
                                                <div class="col-12 col-xl-8">
                                                    @if (!empty($project['colour_rationale']))
                                                        <div class="service-body type-basic-160lh" style="margin-bottom: 3rem;">
                                                            <p>{{ $project['colour_rationale'] }}</p>
                                                        </div>
                                                    @endif
                                                    <div class="pf-swatches">
                                                        @foreach ($project['colours'] as $colour)
                                                            <div class="pf-swatch">
                                                                <div class="pf-swatch__chip"
                                                                     style="background: {{ $colour['hex'] }};"></div>
                                                                <p class="pf-swatch__name">{{ $colour['name'] }}</p>
                                                                <p class="pf-swatch__hex">{{ $colour['hex'] }}</p>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            @endif


                            {{-- ════════════════════════════════════════════
                                 10 & 11. PATTERN 1 / PATTERN 2  (optional)
                                 Full-width, no top margin (continuation of
                                 colour section visual rhythm).
                            ═════════════════════════════════════════════ --}}
                            @if (!empty($project['pattern_1_url']))
                                <div class="project__block no-margin-top animate-in-up">
                                    <div class="project__illustration-xl">
                                        <img src="{{ $project['pattern_1_url'] }}"
                                             alt="{{ strip_tags($project['title']) }} — pattern"
                                             loading="lazy"
                                             decoding="async">
                                    </div>
                                </div>
                            @endif

                            @if (!empty($project['pattern_2_url']))
                                <div class="project__block no-margin-top animate-in-up">
                                    <div class="project__illustration-xl">
                                        <img src="{{ $project['pattern_2_url'] }}"
                                             alt="{{ strip_tags($project['title']) }} — pattern"
                                             loading="lazy"
                                             decoding="async">
                                    </div>
                                </div>
                            @endif


                            {{-- ════════════════════════════════════════════
                                 12. COLLATERAL  (optional)
                                 Full-width — brand collateral mockup.
                            ═════════════════════════════════════════════ --}}
                            @if (!empty($project['collateral_url']))
                                <div class="project__block no-margin animate-in-up">
                                    <div class="project__illustration-xl">
                                        <img src="{{ $project['collateral_url'] }}"
                                             alt="{{ strip_tags($project['title']) }} — collateral"
                                             loading="lazy"
                                             decoding="async">
                                    </div>
                                </div>
                            @endif


                            {{-- ════════════════════════════════════════════
                                 13. THE OUTCOME  (optional)
                                 Controller maps: Outcome / The Outcome /
                                 Solution / The Solution → solution_html
                            ═════════════════════════════════════════════ --}}
                            @if (!empty($project['solution_html']))
                                <div class="project__block animate-in-up">
                                    <div class="project__descr">
                                        <div class="container-fluid p-0">
                                            <div class="row g-0">
                                                <div class="col-12 col-xl-4">
                                                    <p class="project__subtitle tagline-chapter">The Outcome</p>
                                                </div>
                                                <div class="col-12 col-xl-8">
                                                    <div class="service-body type-basic-160lh">
                                                        {!! $project['solution_html'] !!}
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif


                            {{-- ════════════════════════════════════════════
                                 14. STOREFRONT / ENVIRONMENTAL  (optional)
                                 Full-width — signage, office, outdoor shot.
                                 Sits after outcome so the narrative completes
                                 before the visual lands.
                            ═════════════════════════════════════════════ --}}
                            @if (!empty($project['storefront_url']))
                                <div class="project__block no-margin animate-in-up">
                                    <div class="project__illustration-xl">
                                        <img src="{{ $project['storefront_url'] }}"
                                             alt="{{ strip_tags($project['title']) }} — environmental"
                                             loading="lazy"
                                             decoding="async">
                                    </div>
                                </div>
                            @endif


                            {{-- ════════════════════════════════════════════
                                 15. LIVE URL CTA  (optional)
                                 Shown when a live_url is set in frontmatter.
                            ═════════════════════════════════════════════ --}}

                            @if (!empty($project['live_url']))
                                <div class="project__block small-size animate-in-up">
                                    <div class="container-fluid p-0">
                                        <div class="row g-0">
                                            <div class="btn-group about-descr__btnholder animate-in-up">
                                                <a class="btn btn-default hover-default"
                                                   href="{{ $project['live_url'] }}"
                                                   target="_blank"
                                                   rel="noopener">
                                                    <em></em>
                                                    <span class="btn-caption">{{ $project['live_url_label'] }}</span>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif


                            {{-- ════════════════════════════════════════════
                                 16. SISTER BRAND  (optional)
                                 Self-contained sub-section — its own chapter
                                 header, hero, description, colour palette,
                                 image grid, and live-url CTA.
                                 Currently only Jupiter Corporate → Jupiter Legal.
                            ═════════════════════════════════════════════ --}}
                            @if (!empty($project['sister_brand']))
                                @include('partials.sister-brand')
                            @endif


                            {{-- ════════════════════════════════════════════
                                 17. CLIENT FEEDBACK  (optional)
                                 Avatar image if available, initials fallback.
                                 Stars rendered from feedback.rating integer.
                            ═════════════════════════════════════════════ --}}
                            @if (!empty($project['feedback']))
                                <div class="project__block normal-size no-margin-bottom animate-in-up">
                                    <div class="project__descr">
                                        <div class="container-fluid p-0">
                                            <div class="row g-0">

                                                <div class="col-12 col-xl-4">
                                                    <p class="project__subtitle image-top-subtitle tagline-chapter">
                                                        Client's Feedback
                                                    </p>
                                                </div>

                                                <div class="col-12 col-xl-8">
                                                    <div class="project__feedback">

                                                        {{-- Author row --}}
                                                        <div class="feedback__fauthor d-flex">
                                                            <div class="fauthor__avatar">
                                                                @if (!empty($project['feedback']['avatar_url']))
                                                                    <img src="{{ $project['feedback']['avatar_url'] }}"
                                                                         alt="{{ $project['feedback']['author'] }}">
                                                                @else
                                                                    <span>{{ $project['feedback']['initials'] ?? '??' }}</span>
                                                                @endif
                                                            </div>
                                                            <div class="fauthor__info d-flex flex-column justify-content-center">
                                                                <h4 class="fauthor__name">
                                                                    {{ $project['feedback']['author'] }}
                                                                </h4>
                                                                <p class="fauthor__position small">
                                                                    {{ $project['feedback']['position'] }}
                                                                    @if (!empty($project['feedback']['company']))
                                                                        ·
                                                                        @if (!empty($project['feedback']['company_url']))
                                                                            <a class="link-small-underline"
                                                                               href="{{ $project['feedback']['company_url'] }}"
                                                                               target="_blank"
                                                                               rel="noopener noreferrer">
                                                                                {{ $project['feedback']['company'] }}
                                                                            </a>
                                                                        @else
                                                                            {{ $project['feedback']['company'] }}
                                                                        @endif
                                                                    @endif
                                                                </p>
                                                                @if (!empty($project['feedback']['rating']))
                                                                    <div class="fauthor__rating d-flex">
                                                                        @for ($i = 0; $i < (int) $project['feedback']['rating']; $i++)
                                                                            <i class="ph-fill ph-star"></i>
                                                                        @endfor
                                                                    </div>
                                                                @endif
                                                            </div>
                                                        </div>

                                                        {{-- Quote --}}
                                                        <div class="feedback__descr">
                                                            <p class="type-basic-160lh">
                                                                {{ $project['feedback']['quote'] }}
                                                            </p>
                                                        </div>

                                                    </div>{{-- /.project__feedback --}}
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                    <div class="project__divider"></div>
                                </div>
                            @endif


                        </div>{{-- /.inner__content --}}
                    </div>{{-- /.col --}}

                    <div class="col-12 col-xl-2"></div>

                </div>{{-- /.row --}}
            </div>
        </div>
    </section>

@endsection

{{-- ============================================================
     STYLES
     All portfolio detail styles live in custom.css under
     /* ── PORTFOLIO DETAIL ── */
     Nothing project-specific is scoped here; this push block
     is intentionally left empty unless you need a one-off
     per-project override.
============================================================ --}}
@push('styles')
    <style>
        {{-- One-off per-project overrides go here if needed --}}
    </style>
@endpush
