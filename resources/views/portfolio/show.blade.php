@extends('layouts.app')

@section('title', $project['title'] . ' — Pacmedia')

@section('content')

    {{-- ============================================================
         PORTFOLIO DETAIL — show.blade.php
         Route:   /work/{slug}
         Data:    PortfolioController::show()
         ============================================================ --}}

    <section id="portfolio-detail" class="inner inner-grid-bottom">
        <div class="inner__wrapper">
            <div class="container-fluid p-0">
                <div class="row g-0">


                    {{-- ── Sidebar index label ─────────────────────── --}}
                    <div class="col-12 col-xl-2">
                        <div class="inner__name">
                            <div class="content__block name-block">
                                <span class="section-name icon-right animate-in-up">
                                    <span class="section-name-caption">
                                        {{ $project['index'] }} — Case Study
                                    </span>
                                    <i class="ph ph-arrow-down-right"></i>
                                </span>
                            </div>
                        </div>
                    </div>


                    {{-- ── Main column ─────────────────────────────── --}}
                    <div class="col-12 col-xl-8">
                        <div class="inner__content">


                            {{-- ════════════════════════════════════════
                                 1. EYEBROW + TITLE
                                 h1 mirrors the bare h2 scale in main.css
                                 (4.6 → 14rem, weight 300). reveal-type
                                 fires the word-clip animation in app.js.
                                 ════════════════════════════════════════ --}}
                            <div class="content__block grid-block section-tagline-title">
                                <h1 class="pf-proj-title reveal-type animate-in-up">
                                    {{ $project['title'] }}
                                </h1>
                                <p class="pf-eyebrow animate-in-up mt-4">
                                    {{ $project['meta']['Service'] ?? '' }}
                                </p>
                            </div>


                            {{-- ════════════════════════════════════════
                                 2. DISPLAY TAGLINE
                                 The pullquote from ## Brief rendered at
                                 blockquote scale (3.2 → 6.8rem, weight
                                 300) — same as the service page tagline.
                                 NOTE: we only use the brief pullquote
                                 here, NOT frontmatter 'tagline' (that
                                 field is a short card label, not prose).
                                 ════════════════════════════════════════ --}}
                            @php
                                $displayTagline = null;
                                $displaySubnote = null;
                                foreach ($project['blocks'] as $b) {
                                    if ($b['type'] === 'brief' && !empty($b['pullquote'])) {
                                        $displayTagline = $b['pullquote'];
                                        $displaySubnote = $b['subnote'] ?? null;
                                        break;
                                    }
                                }
                            @endphp
                            @if ($displayTagline)
                                <div class="content__block grid-block pf-tagline-block animate-in-up">
                                    <blockquote class="reveal-type pf-tagline-quote">{{ $displayTagline }}</blockquote>
                                    @if ($displaySubnote)
                                        <p class="about-descr__attribution pf-tagline-subnote animate-in-up">{{ $displaySubnote }}</p>
                                    @endif
                                </div>
                            @endif


                            {{-- ════════════════════════════════════════
                                 3. HERO — full-bleed parallax 16:6
                                 Breaks out of .inner__content padding via
                                 100vw + negative margins. Sits directly
                                 below the tagline with no gap.
                                 ════════════════════════════════════════ --}}
                            <div class="content__block no-padding pf-hero-bleed animate-in-up">
                                <div class="pf-hero-wrap">
                                    <picture>
                                        <source
                                            media="(max-width: 767px)"
                                            srcset="{{ asset($project['hero_mobile'] ?? $project['hero']) }}?v=2">
                                        <img class="pf-hero-img"
                                             src="{{ asset($project['hero']) }}"
                                             alt="{{ $project['title'] }}"
                                             fetchpriority="high"
                                             decoding="sync">
                                    </picture>
                                </div>
                            </div>


                            {{-- ════════════════════════════════════════
                                 4. META + OVERVIEW
                                 Left: stacked frontmatter fields.
                                 Right: overview paragraph (larger, muted).
                                 Sits in its own rhythm block below hero.
                                 ════════════════════════════════════════ --}}
                            <div class="content__block grid-block pf-meta-overview animate-in-up">
                                <div class="container-fluid p-0">
                                    <div class="row g-0">

                                        <div class="col-12 col-xl-4">
                                            <div class="pf-meta-col">
                                                @foreach ($project['meta'] as $label => $value)
                                                    <div class="pdata__item">
                                                        <p class="data__title">{{ $label }}</p>
                                                        <p class="data__descr">{{ $value }}</p>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>

                                        <div class="col-12 col-xl-8">
                                            @if (!empty($project['overview']))
                                                <p class="pf-overview-lead">{{ $project['overview'] }}</p>
                                            @elseif (!empty($project['brief_intro']))
                                                <p class="pf-overview-lead">{{ $project['brief_intro'] }}</p>
                                            @endif

                                            @if (!empty($project['live_url']))
                                                <div class="about-info__item pf-live-link-wrap animate-in-up">
                                                    <h6>
                                                        <a class="link-inline text-link"
                                                           href="{{ $project['live_url'] }}"
                                                           target="_blank" rel="noopener">
                                                            {{ $project['live_url_label'] ?? 'View Live' }}
                                                        </a>
                                                    </h6>
                                                </div>
                                            @endif
                                        </div>

                                    </div>
                                </div>
                            </div>


                            {{-- ════════════════════════════════════════
                                 5. CONTENT BLOCKS — document order
                                 Each text section gets a top rule and
                                 generous vertical padding. Images follow
                                 tight below their parent section with a
                                 consistent 1.6rem gap between siblings.
                                 ════════════════════════════════════════ --}}
                            @foreach ($project['blocks'] as $i => $block)

                                @if (in_array($block['type'], ['brief', 'process', 'outcome', 'section']))

                                    @php
                                        $sectionLabel = match($block['type']) {
                                            'brief'   => 'The Brief',
                                            'process' => 'The Process',
                                            'outcome' => 'The Outcome',
                                            default   => $block['label'] ?? ucfirst($block['type']),
                                        };
                                        // Is the pullquote already used as the display tagline?
                                        $skipPullquote = ($block['type'] === 'brief')
                                            && !empty($block['pullquote'])
                                            && $block['pullquote'] === $displayTagline;

                                        // Draw a top rule ONLY when the immediately preceding
                                        // block in the blocks array is also a text type.
                                        // — No rule on the first text block: the meta/overview
                                        //   border-bottom already provides that separation.
                                        // — No rule when text follows an image: the image
                                        //   itself provides the visual break.
                                        $textTypes   = ['brief', 'process', 'outcome', 'section', 'feedback'];
                                        $prevBlock   = $project['blocks'][$i - 1] ?? null;
                                        $showDivider = $prevBlock && in_array($prevBlock['type'], $textTypes);
                                    @endphp

                                    <div class="content__block grid-block pf-text-section {{ $showDivider ? 'pf-text-section--ruled' : '' }} animate-in-up">
                                        <div class="container-fluid p-0">
                                            <div class="row g-0">
                                                <div class="col-12 col-xl-4">
                                                    <p class="tagline-chapter pf-section-label">{{ $sectionLabel }}</p>
                                                </div>
                                                <div class="col-12 col-xl-8 pf-body-copy">
                                                    {!! $block['html'] !!}
                                                    @if (!$skipPullquote && !empty($block['pullquote']))
                                                        <blockquote class="pf-pullquote">{{ $block['pullquote'] }}</blockquote>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                @elseif ($block['type'] === 'image')

                                    {{-- Detect run: is the previous block also an image? --}}
                                    @php
                                        $prevIsImage = isset($project['blocks'][$i - 1])
                                            && $project['blocks'][$i - 1]['type'] === 'image';
                                    @endphp

                                    <div class="content__block no-padding pf-img-block {{ $prevIsImage ? 'pf-img-block--sibling' : 'pf-img-block--first' }} animate-in-up">
                                        <figure class="pf-img-figure">
                                            <div class="pf-img-wrap">
                                                <img class="pf-cs-img"
                                                     src="{{ asset($block['src']) }}"
                                                     alt="{{ $block['alt'] ?? $block['caption'] ?? $project['title'] }}"
                                                     loading="lazy"
                                                     decoding="async">
                                            </div>
                                        </figure>
                                    </div>

                                @elseif ($block['type'] === 'feedback')

                                    @php
                                        $prevBlock     = $project['blocks'][$i - 1] ?? null;
                                        $feedbackRuled = $prevBlock && in_array($prevBlock['type'], ['brief','process','outcome','section','feedback']);
                                    @endphp

                                    <div class="content__block grid-block pf-feedback-section {{ $feedbackRuled ? 'pf-feedback-section--ruled' : '' }} animate-in-up">
                                        <div class="container-fluid p-0">
                                            <div class="row g-0">
                                                <div class="col-12 col-xl-4">
                                                    <p class="tagline-chapter pf-section-label">Client's Feedback</p>
                                                </div>
                                                <div class="col-12 col-xl-8">
                                                    <div class="pf-feedback">
                                                        <div class="pf-feedback__header">
                                                            <div class="pf-feedback__avatar">
                                                                @if (!empty($block['avatar']))
                                                                    <img src="{{ asset($block['avatar']) }}" alt="{{ $block['name'] }}">
                                                                @else
                                                                    <span>{{ mb_strtoupper(mb_substr($block['name'], 0, 2)) }}</span>
                                                                @endif
                                                            </div>
                                                            <div class="pf-feedback__meta">
                                                                <p class="pf-feedback__name">{{ $block['name'] }}</p>
                                                                <p class="pf-feedback__role">{{ $block['role'] }}</p>
                                                                <div class="pf-feedback__stars" aria-label="5 out of 5 stars">
                                                                    @for ($i = 0; $i < 5; $i++)<i class="ph-fill ph-star"></i>@endfor
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <p class="pf-feedback__quote">{{ $block['quote'] }}</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                @elseif ($block['type'] === 'sister-brand')

                                    {{-- Chapter break — rule + label ──────── --}}
                                    <div class="content__block pf-chapter-break animate-in-up">
                                        <div class="pf-chapter-rule"></div>
                                        <p class="pf-chapter-label tagline-chapter">
                                            <i class="ph ph-arrow-down-right"></i>
                                            Brand Extension
                                        </p>
                                    </div>

                                    {{-- Sister name + tagline ──────────────── --}}
                                    <div class="content__block grid-block section-tagline-title animate-in-up">
                                        <h2 class="pf-proj-title pf-sister-heading reveal-type">{{ $block['name'] }}</h2>
                                        <p class="pf-eyebrow mt-4">{{ $block['tagline'] }}</p>
                                    </div>

                                    {{-- Sister hero ────────────────────────── --}}
                                    @if (!empty($block['hero']))
                                        <div class="content__block no-padding pf-hero-bleed animate-in-up">
                                            <div class="pf-hero-wrap">
                                                <picture>
                                                    <source
                                                        media="(max-width: 767px)"
                                                        srcset="{{ asset($block['hero_mobile'] ?? $block['hero']) }}">
                                                    <img class="pf-hero-img"
                                                         src="{{ asset($block['hero']) }}"
                                                         alt="{{ $block['name'] }}"
                                                         loading="lazy"
                                                         decoding="async">
                                                </picture>
                                            </div>
                                        </div>
                                    @endif

                                    {{-- Description + colour note ──────────── --}}
                                    @if (!empty($block['description']))
                                        <div class="content__block grid-block pf-text-section animate-in-up">
                                            <div class="container-fluid p-0">
                                                <div class="row g-0">
                                                    <div class="col-12 col-xl-4">
                                                        <p class="tagline-chapter pf-section-label">About</p>
                                                    </div>
                                                    <div class="col-12 col-xl-8 pf-body-copy">
                                                        <p>{{ $block['description'] }}</p>
                                                        @if (!empty($block['colour_note']))
                                                            <p class="mt-4">{{ $block['colour_note'] }}</p>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endif

                                    {{-- Sister images ───────────────────────── --}}
                                    @foreach ($block['images'] as $si => $simg)
                                        <div class="content__block no-padding pf-img-block {{ $si > 0 ? 'pf-img-block--sibling' : 'pf-img-block--first' }} animate-in-up">
                                            <figure class="pf-img-figure">
                                                <div class="pf-img-wrap">
                                                    <img class="pf-cs-img"
                                                         src="{{ asset($simg['src']) }}"
                                                         alt="{{ $simg['alt'] ?? $block['name'] }}"
                                                         loading="lazy"
                                                         decoding="async">
                                                </div>
                                            </figure>
                                        </div>
                                    @endforeach

                                    {{-- Sister live URL ─────────────────────── --}}
                                    @if (!empty($block['live_url']))
                                        <div class="content__block animate-in-up">
                                            <div class="about-info__item pf-live-link-wrap">
                                                <h6>
                                                    <a class="link-inline text-link"
                                                       href="{{ $block['live_url'] }}"
                                                       target="_blank" rel="noopener">
                                                        {{ $block['live_url_label'] ?? 'Visit website' }}
                                                    </a>
                                                </h6>
                                            </div>
                                        </div>
                                    @endif

                                    {{-- Chapter close rule ──────────────────── --}}
                                    <div class="content__block pf-chapter-break animate-in-up">
                                        <div class="pf-chapter-rule"></div>
                                    </div>

                                @endif

                            @endforeach


                        </div>{{-- /.inner__content --}}
                    </div>{{-- /.col --}}

                    <div class="col-12 col-xl-2"></div>

                </div>{{-- /.row --}}
            </div>
        </div>
    </section>

@endsection


{{-- ============================================================
     GALLERY — PhotoSwipe hidden list + floating "View Gallery" btn
     ============================================================ --}}
@php
    $galleryImages = [];
    if (!empty($project['hero']))
        $galleryImages[] = ['src' => asset($project['hero']), 'alt' => $project['title'], 'size' => '2160x810'];
    foreach ($project['blocks'] as $block) {
        if ($block['type'] === 'image') {
            $galleryImages[] = [
                'src'  => asset($block['src']),
                'alt'  => $block['caption'] ?? $project['title'],
                'size' => '2160x926',
            ];
        }
        if ($block['type'] === 'sister-brand') {
            if (!empty($block['hero']))
                $galleryImages[] = [
                    'src'  => asset($block['hero']),
                    'alt'  => $block['name'],
                    'size' => '2160x810',
                ];
            foreach ($block['images'] as $simg)
                $galleryImages[] = [
                    'src'  => asset($simg['src']),
                    'alt'  => $simg['alt'] ?? $block['name'],
                    'size' => '2160x926',
                ];
        }
    }
@endphp

@if (count($galleryImages) > 0)
    <style>#pf-gallery-list { display: none !important; }</style>
    <div id="pf-gallery-list" class="pf-gallery-list my-gallery"
         itemscope itemtype="http://schema.org/ImageGallery">
        @foreach ($galleryImages as $gi)
            <figure itemprop="associatedMedia" itemscope itemtype="http://schema.org/ImageObject">
                <a href="{{ $gi['src'] }}" data-size="{{ $gi['size'] }}" itemprop="contentUrl">
                    <img src="{{ $gi['src'] }}" itemprop="thumbnail" alt="{{ $gi['alt'] }}">
                </a>
                @if (!empty($gi['alt']))
                    <figcaption itemprop="caption description">{{ $gi['alt'] }}</figcaption>
                @endif
            </figure>
        @endforeach
    </div>
    <style>
        #pf-gallery-btn { opacity: 0; pointer-events: none; }
        #pf-gallery-btn.is-ready { opacity: 1; pointer-events: auto; transition: opacity .2s ease; }
    </style>
    <button id="pf-gallery-btn" class="pf-gallery-btn" type="button"
            aria-label="View project gallery ({{ count($galleryImages) }} images)">
        <span class="pf-gallery-btn__label">View Gallery</span>
        <i class="ph ph-images" aria-hidden="true"></i>
        <span class="pf-gallery-btn__count" aria-hidden="true">{{ count($galleryImages) }}</span>
    </button>
@endif


{{-- ============================================================
     STYLES
     ============================================================ --}}



@push('scripts')
    <script>
        (function () {
            'use strict';

            /* ── Parallax — smooth, all hero images ─────────────────────────── */
            var heroImgs = document.querySelectorAll('#portfolio-detail .pf-hero-img');
            var rafPending = false;

            function applyParallax() {
                rafPending = false;
                if (!heroImgs.length) return;

                var isMobile = window.innerWidth < 768;
                var travel   = isMobile ? 40 : 120;

                heroImgs.forEach(function (img) {
                    var wrap     = img.parentElement;
                    var rect     = wrap.getBoundingClientRect();

                    // Skip images not near the viewport — no point computing them
                    if (rect.bottom < -window.innerHeight || rect.top > window.innerHeight * 2) return;

                    var progress = (rect.top + rect.height / 2 - window.innerHeight / 2) / window.innerHeight;
                    progress = Math.max(-1, Math.min(1, progress));
                    img.style.transform = 'translateY(' + (progress * travel) + 'px)';
                });
            }

            function scheduleParallax() {
                if (rafPending) return;
                rafPending = true;
                requestAnimationFrame(applyParallax);
            }

// Desktop scroll
            window.addEventListener('scroll', scheduleParallax, { passive: true });

// Mobile — fire on touchmove for mid-scroll smoothness
            window.addEventListener('touchmove', scheduleParallax, { passive: true });

// Recalculate on resize / orientation change
            window.addEventListener('resize', scheduleParallax, { passive: true });
            window.addEventListener('orientationchange', function () {
                // Slight delay — browser hasn't finished repainting at the moment
                // orientationchange fires, so wait one frame
                setTimeout(scheduleParallax, 100);
            });

// Initial state
            applyParallax();

            /* ── PhotoSwipe gallery ─────────────────────────────────── */
            var galleryBtn  = document.getElementById('pf-gallery-btn');
            var galleryList = document.getElementById('pf-gallery-list');
            if (!galleryBtn || !galleryList) return;

            function buildAndOpen() {
                var pswpEl = document.querySelector('.pswp');
                if (!pswpEl || typeof PhotoSwipe === 'undefined') return;
                var figures = galleryList.querySelectorAll('figure');
                if (!figures.length) return;
                var items = Array.from(figures).map(function (fig) {
                    var a   = fig.querySelector('a');
                    var img = fig.querySelector('img');
                    var cap = fig.querySelector('figcaption');
                    var parts = (a && a.getAttribute('data-size') || '2160x926').split('x');
                    return {
                        src:   a   ? a.getAttribute('href') : '',
                        w:     img && img.naturalWidth  ? img.naturalWidth  : parseInt(parts[0], 10) || 2160,
                        h:     img && img.naturalHeight ? img.naturalHeight : parseInt(parts[1], 10) || 926,
                        msrc:  img ? img.getAttribute('src') : '',
                        title: cap ? cap.innerHTML : '',
                        el: fig,
                        _fw: parseInt(parts[0], 10) || 2160,
                        _fh: parseInt(parts[1], 10) || 926,
                    };
                });
                var pending = items.filter(function (it) { return !it.w || !it.h; }).length;
                if (pending === 0) { openSwipe(items, pswpEl); return; }
                items.forEach(function (item) {
                    if (item.w && item.h) return;
                    var probe = new Image();
                    probe.onload = probe.onerror = function () {
                        item.w = probe.naturalWidth  || item._fw;
                        item.h = probe.naturalHeight || item._fh;
                        if (--pending === 0) openSwipe(items, pswpEl);
                    };
                    probe.src = item.src;
                });
            }
            function openSwipe(items, pswpEl) {
                var gallery = new PhotoSwipe(pswpEl, PhotoSwipeUI_Default, items, {
                    index: 0, showHideOpacity: true, history: false
                });
                gallery.init();
            }
            galleryBtn.addEventListener('click', buildAndOpen);

            /* ── Sync gallery btn + #to-top ─────────────────────────── */
            var toTop = document.getElementById('to-top');
            var nav   = document.querySelector('.nav-container');
            function syncPositions(navGone) {
                galleryBtn.classList.toggle('scrolled', navGone);
                if (toTop) {
                    toTop.style.right = navGone
                        ? ''
                        : 'calc(5rem + ' + (galleryBtn.offsetWidth + 12) + 'px)';
                }
            }
            if (nav && 'IntersectionObserver' in window) {
                new IntersectionObserver(function (entries) {
                    syncPositions(!entries[0].isIntersecting);
                }, { threshold: 0 }).observe(nav);
            } else {
                window.addEventListener('scroll', function () {
                    syncPositions(nav ? nav.getBoundingClientRect().bottom < 0 : window.scrollY > 120);
                }, { passive: true });
            }
            syncPositions(nav ? nav.getBoundingClientRect().bottom < 0 : false);
            galleryBtn.classList.add('is-ready');
        })();
    </script>
@endpush
