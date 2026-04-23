@extends('layouts.app')
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
                                    <span class="section-name-caption">{{ $service['index'] }} — Service</span>
                                    <i class="ph ph-arrow-down-right"></i>
                                </span>
                            </div>
                        </div>
                    </div>

                    {{-- Section Content --}}
                    <div class="col-12 col-xl-8">
                        <div class="inner__content">

                            {{-- Service Index + Title --}}
                            <div class="content__block section-tagline-title">
                                <div class="block__descr">
                                    {{--                                    <span class="service-index animate-in-up">{{ $service['index'] }}</span>--}}
                                    <h1 class="reveal-type animate-in-up">
                                        {!! $service['title'] !!}
                                    </h1>
                                </div>
                            </div>

                            {{-- Headline --}}
                            <div class="content__block pre-text-items">
                                <div class="block__subtitle">
                                    <p class="tagline-chapter animate-in-up">{{ $service['headline'] }}</p>
                                </div>
                            </div>

                            {{-- Body Copy --}}
                            <div class="content__block service-body animate-in-up">
                                {!! $service['body_html'] !!}
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
                                <div class="content__block service-process">
                                    <div class="faq-divider animate-in-up"></div>
                                    <p class="tagline-chapter animate-in-up" style="margin: 2.5rem 0;">
                                        Our Mode of Operation
                                    </p>
                                    <div class="faq-lines__divider"></div>

                                    <ul class="faq-lines d-flex flex-column">
                                        @foreach ($service['process'] as $index => $step)
                                            <li class="faq-lines__item">
                                                <div class="faq-lines__trigger">
                                                    <h4 class="animate-in-up">
                                                        <span
                                                            style="color: var(--t-muted); font-size: 0.6em; margin-right: 1.5rem; font-weight: 400;">
                                                            {{ str_pad($index + 1, 2, '0', STR_PAD_LEFT) }}.
                                                        </span>
                                                        {{ $step['label'] }} — {{ $step['title'] }}
                                                    </h4>
                                                    <div class="socials-lines__icon d-flex animate-in-up">
                                                        <i class="ph ph-arrow-up-right"></i>
                                                    </div>
                                                </div>
                                                <div class="faq-lines__answer">
                                                    <p class="faq-space">{{ $step['body'] }}</p>
                                                    @if (!empty($step['note']))
                                                        <p class="service-process__note faq-space">
                                                            <em>{{ $step['note'] }}</em>
                                                        </p>
                                                    @endif
                                                </div>
                                                <div class="faq-lines__divider"></div>
                                            </li>
                                        @endforeach
                                    </ul>

                                    <div class="faq-divider animate-in-up"></div>
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
            margin-bottom: 1.5rem;
            line-height: 1.8;
            color: var(--t-body);
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
            margin-top: 1.25rem;
            padding: 1rem 1.25rem;
            border-left: 2px solid var(--t-muted);
            color: var(--t-muted);
            font-size: 0.875rem;
            line-height: 1.75;
        }
    </style>
@endpush
