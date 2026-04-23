@extends('components.app-layout')
@section('content')

    {{-- ================================================ --}}
    {{-- SERVICE DETAIL PAGE --}}
    {{-- ================================================ --}}
    <section id="service-detail" class="inner inner-grid-bottom">
        <div class="inner__wrapper">
            <div class="container-fluid p-0">
                <div class="row g-0">

                    {{-- Section Name --}}
                    <div class="col-12 col-xl-2">
                        <div class="inner__name">
                            <div class="content__block name-block">
                                <span class="section-name icon-right animate-in-up">
                                    <span class="section-name-caption">{{ $service['index'] }} — Capability</span>
                                    <i class="ph ph-arrow-down-right"></i>
                                </span>
                            </div>
                        </div>
                    </div>

                    {{-- Section Content --}}
                    <div class="col-12 col-xl-8">
                        <div class="inner__content">

                            {{-- Service Title --}}
                            <div class="content__block section-text-title">
                                <div class="block__descr">
                                    <i class="{{ $service['icon'] }}"
                                       style="font-size: 7rem; display: block; margin-bottom: 1.25rem; color: var(--t-muted);"></i>
                                    <h2 class="reveal-type animate-in-up">
                                        {!! $service['title'] !!}
                                    </h2>
                                </div>
                            </div>

                            {{-- Headline + Body --}}
                            <div class="content__block grid-block">
                                <div class="container-fluid p-0">
                                    <div class="row g-0">
                                        <div class="col-12">
                                            <blockquote class="reveal-type animate-in-up">
                                                {{ $service['headline'] }}
                                            </blockquote>
                                            <div class="service-body type-basic-160lh" style="margin-top: 1em; line-height: 2.5;
            color: var(--t-muted);">
                                                {!! $service['body_html'] !!}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- What This Covers --}}
                            @if (!empty($service['covers']))
                                <div class="content__block service-covers">
                                    <div class="faq-divider animate-in-up"></div>
                                    <p class="tagline-chapter animate-in-up" style="margin: 2.5rem 0;">
                                        What This Covers
                                    </p>
                                    <div class="faq-lines__divider"></div>

                                    @foreach ($service['covers'] as $group => $items)
                                        <div class="service-covers__group animate-in-up">
                                            @if ($group !== '_default')
                                                <p class="service-covers__group-label">{{ $group }}</p>
                                            @endif
                                            <ul class="service-covers__list">
                                                @foreach ($items as $item)
                                                    <li class="service-covers__item">
                                                        <i class="ph ph-arrow-right service-covers__arrow"></i>
                                                        <span>{{ $item }}</span>
                                                    </li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    @endforeach

                                    <div class="faq-divider animate-in-up"></div>
                                </div>
                            @endif

                            {{-- Process --}}
                            @if (!empty($service['process']))
                                @php
                                    $processIcons = [
                                        'ph-magnifying-glass',
                                        'ph-compass',
                                        'ph-pen-nib',
                                    ];
                                @endphp

                                <div class="content__block service-process">

                                    <div class="block__subtitle">
                                        <p class="tagline-chapter animate-in-up">Our Mode of Operation</p>
                                    </div>

                                    <div class="container-fluid p-0">
                                        @foreach ($service['process'] as $index => $step)
                                            <div class="process-card animate-in-up">

                                                {{-- Top row: number + icon --}}
                                                <div class="process-card__top">
                        <span class="process-card__number">
                            {{ str_pad($index + 1, 2, '0', STR_PAD_LEFT) }}.
                        </span>
                                                    <i class="ph-thin {{ $processIcons[$index] ?? 'ph-circle' }} process-card__icon"></i>
                                                </div>

                                                {{-- Label (Discovery / Direction / Design) --}}
                                                <h3 class="process-card__title">{{ $step['label'] }}</h3>

                                                {{-- Step title (Intelligence Gathering etc.) --}}
                                                <p class="process-card__subtitle">{{ $step['title'] }}</p>

                                                {{-- Body --}}
                                                <p class="process-card__desc type-basic-160lh">{{ $step['body'] }}</p>

                                                {{-- Optional note --}}
                                                @if (!empty($step['note']))
                                                    <p class="service-process__note process-card__desc"
                                                       style="margin-top: 1.25rem;">
                                                        <em>{{ $step['note'] }}</em>
                                                    </p>
                                                @endif

                                            </div>
                                        @endforeach
                                    </div>

                                </div>
                            @endif

                            {{-- CTA --}}
                            <div class="content__block animate-in-up" style="margin-top: 2rem; margin-bottom: 6rem;">
                                <a class="btn btn-default hover-default start-engagement-btn" href="#!">
                                    <em></em>
                                    <span class="btn-caption">Start Engagement →</span>
                                </a>
                            </div>

                        </div>
                    </div>

                    <div class="col-12 col-xl-2"></div>

                </div>
            </div>
        </div>
    </section>

@endsection

@push('styles')
    <style>
        /* ── Service Index ── */
        .service-index {
            display: block;
            font-size: 0.75rem;
            letter-spacing: 0.18em;
            text-transform: uppercase;
            color: var(--t-muted);
            margin-bottom: 1rem;
            font-weight: 400;
        }

        /* ── Body Copy ── */
        .service-body p {
            color: var(--t-medium);
            line-height: 1.8;
            margin-bottom: 1.5rem;
            max-width: 75%;
        }

        @media only screen and (max-width: 767px) {
            .service-body p {
                max-width: 100%;
            }
        }

        /* ── Covers ── */
        .service-covers__group {
            margin: 2rem 0;
        }

        .service-covers__group-label {
            font-size: 0.7rem;
            letter-spacing: 0.14em;
            text-transform: uppercase;
            color: var(--t-muted);
            margin-bottom: 1rem;
            font-weight: 500;
        }

        .service-covers__list {
            list-style: none;
            padding: 0;
            margin: 0;
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(260px, 1fr));
            gap: 0.5rem 2rem;
        }

        .service-covers__item {
            display: flex;
            align-items: baseline;
            gap: 0.6rem;
            font-size: 0.9rem;
            color: var(--t-body);
            padding: 0.35rem 0;
            border-bottom: 1px solid var(--border-subtle, rgba(255, 255, 255, 0.06));
        }

        .service-covers__arrow {
            font-size: 0.7rem;
            color: var(--t-muted);
            flex-shrink: 0;
            position: relative;
            top: 1px;
        }

        /* ── Process note ── */
        .service-process__note {
            color: var(--t-medium);
            line-height: 1.8;
            max-width: 75%;
            padding: 1rem 1.25rem;
            border-left: 2px solid var(--stroke-elements);
            font-size: 0.875rem;
            margin-top: 1.25rem;
        }
    </style>
@endpush
