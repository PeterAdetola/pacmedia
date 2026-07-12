{{--
    ============================================================
    PARTIAL: resources/views/partials/sister-brand.blade.php
    ============================================================
    Insert in show.blade.php AFTER the Corporate CTA block
    and BEFORE the client feedback block:

        @if (!empty($project['sister_brand']))
            @include('partials.sister-brand')
        @endif
    ============================================================
--}}

@php
    $sb   = $project['sister_brand'] ?? null;
    $base = 'img/works/' . $project['slug'] . '/';
@endphp

@if (!empty($sb))

    {{-- ════════════════════════════════════════════
         CHAPTER BREAK
         Full-width bold statement — announces a new
         brand is opening. Not a footnote. A door.
    ═════════════════════════════════════════════ --}}
    <div class="project__block no-margin sb-chapter animate-in-up">
        <div class="sb-chapter__inner">
            <div class="sb-chapter__top">
                <span class="sb-chapter__index">02</span>
                <span class="sb-chapter__rule"></span>
                <span class="sb-chapter__eyebrow">Brand Extension</span>
            </div>
            <h2 class="sb-chapter__name">{{ $sb['name'] }}</h2>
            <p class="sb-chapter__tagline">{{ $sb['tagline'] ?? '' }}</p>
        </div>
    </div>


    {{-- ════════════════════════════════════════════
         HERO — bold mark images for Legal
         Same structure as parent hero block
    ═════════════════════════════════════════════ --}}
    @if (!empty($sb['hero_landscape']) || !empty($sb['hero_portrait']))
        <div class="project__block no-padding no-margin animate-in-up">
            <div class="project-image-bg">
                @if (!empty($sb['hero_landscape']))
                    <img class="project-image-bg__landscape"
                         src="{{ asset($base . $sb['hero_landscape']) }}"
                         alt="{{ $sb['name'] }}"
                         loading="lazy"
                         decoding="async">
                @endif
                @if (!empty($sb['hero_portrait']))
                    <img class="project-image-bg__portrait"
                         src="{{ asset($base . $sb['hero_portrait']) }}"
                         alt="{{ $sb['name'] }}"
                         loading="lazy"
                         decoding="async">
                @endif
            </div>
        </div>
    @endif


    {{-- ════════════════════════════════════════════
         META + DESCRIPTION
         Mirrors the parent Overview block layout
    ═════════════════════════════════════════════ --}}
    <div class="project__block grid-block grid-items animate-in-up">
        <div class="project__data">
            <div class="container-fluid p-0">
                <div class="row g-0">

                    <div class="col-12 col-xl-4 pdata__col animate-in-up">
                        <div class="pdata__item">
                            <p class="data__title tagline-chapter small">Type</p>
                            <p class="data__descr small">Brand Extension</p>
                        </div>
                        <div class="pdata__item">
                            <p class="data__title tagline-chapter small">Year</p>
                            <p class="data__descr small">{{ $sb['year'] ?? '' }}</p>
                        </div>
                        <div class="pdata__item">
                            <p class="data__title tagline-chapter small">Scope</p>
                            <p class="data__descr small">Mark · Colour · Web Design · Development</p>
                        </div>
                    </div>

                    <div class="col-12 col-xl-8 grid-item animate-in-up">
                        @if (!empty($sb['description']))
                            <div class="service-body type-basic-160lh">
                                <p>{{ $sb['description'] }}</p>
                            </div>
                        @endif
                    </div>

                </div>
            </div>
        </div>
    </div>


    {{-- ════════════════════════════════════════════
         IMAGE GRID — all col-12, full width
    ═════════════════════════════════════════════ --}}
    @if (!empty($sb['grid_images']))
        <div class="project__block grid-block no-margin">
            <div class="project__illustrations">
                <div class="container-fluid p-0">
                    <div class="row g-0">
                        @foreach ($sb['grid_images'] as $img)
                            <div class="col-12 grid-item animate-in-up">
                                <div class="project__illustration project__illustration--full">
                                    <img src="{{ asset($base . ($img['file'] ?? '')) }}"
                                         alt="{{ $img['alt'] ?? $sb['name'] }}"
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
         COLOUR SYSTEM
         Priority: colour_palette image (full width)
         Fallback: colour swatches with colour_note
    ═════════════════════════════════════════════ --}}
    @if (!empty($sb['colour_palette']))
        <div class="project__block no-margin animate-in-up">
            <div class="project__illustration-xl pf-colour-palette">
                <img src="{{ asset($base . $sb['colour_palette']) }}"
                     alt="{{ $sb['name'] }} — colour palette"
                     loading="lazy"
                     decoding="async">
            </div>
        </div>
    @elseif (!empty($sb['colours']))
        <div class="project__block pre-grid-items animate-in-up">
            <div class="project__descr">
                <div class="container-fluid p-0">
                    <div class="row g-0">
                        <div class="col-12 col-xl-4">
                            <p class="project__subtitle tagline-chapter">Colour System</p>
                        </div>
                        <div class="col-12 col-xl-8">
                            @if (!empty($sb['colour_note']))
                                <div class="service-body type-basic-160lh">
                                    <p>{{ $sb['colour_note'] }}</p>
                                </div>
                            @endif
                            <div class="pf-swatches">
                                @foreach ($sb['colours'] as $colour)
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
         JUPITER LEGAL CTA
    ═════════════════════════════════════════════ --}}
    @if (!empty($sb['live_url']))
        <div class="project__block small-size animate-in-up">
            <div class="container-fluid p-0">
                <div class="row g-0">
                    <div class="btn-group about-descr__btnholder animate-in-up">
                        <a class="btn btn-default hover-default"
                           href="{{ $sb['live_url'] }}"
                           target="_blank"
                           rel="noopener">
                            <em></em>
                            <span class="btn-caption">
                                {{ $sb['live_url_label'] ?? 'Visit ' . $sb['name'] }}
                            </span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    @endif

@endif
