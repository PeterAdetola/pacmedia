@extends('layouts.app')
@section('content')

    {{-- ================================================ --}}
    {{-- SERVICE DETAIL PAGE --}}
    {{-- ================================================ --}}
    <section id="service-detail" class="inner inner-grid-bottom">
        <div class="inner__wrapper">
            <div class="container-fluid p-0">
                <div class="row g-0">

                    {{-- ── Sidebar label ───────────────────────────── --}}
                    <div class="col-12 col-xl-2">
                        <div class="inner__name">
                            <div class="content__block name-block">
                                <span class="section-name icon-right animate-in-up">
                                    <span class="section-name-caption">
                                        {{ $service['index'] }} — Capability
                                    </span>
                                    <i class="ph ph-arrow-down-right"></i>
                                </span>
                            </div>
                        </div>
                    </div>

                    {{-- ── Main column ─────────────────────────────── --}}
                    <div class="col-12 col-xl-8">
                        <div class="inner__content">

                            {{-- ── Service icon + title ─────────────── --}}
                            <div class="content__block grid-block section-tagline-title">
                                <div class="block__descr">
                                    <i class="{{ $service['icon'] }} service-icon animate-in-up"></i>
                                    <h2 class="heading-two reveal-type animate-in-up">
                                        {!! $service['title'] !!}
                                    </h2>
                                </div>
                            </div>

                            {{-- ── Headline + Body ──────────────────── --}}
                            <div class="content__block grid-block">
                                <div class="container-fluid p-0">
                                    <div class="row g-0">
                                        <div class="col-12">
                                            <blockquote class="reveal-type animate-in-up">
                                                {{ $service['headline'] }}
                                            </blockquote>
                                            {{--
                                                type-basic-160lh is the global class that owns
                                                line-height — same as the about section.
                                                Do NOT set line-height anywhere else for this div.
                                            --}}
                                            <div class="service-body type-basic-160lh">
                                                {!! $service['body_html'] !!}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- ── What This Covers ──────────────────── --}}
                            @if (!empty($service['covers']))
                                <div class="content__block service-covers">

                                    <div class="block__subtitle">
                                        <p class="tagline-chapter animate-in-up">What This Covers</p>
                                    </div>

                                    <div class="service-covers__groups">
                                        @foreach ($service['covers'] as $group => $items)
                                            <div class="service-covers__group animate-in-up">

                                                @if ($group !== '_default')
                                                    <div class="service-covers__group-header">
                                                        <span class="service-covers__capsule">{{ $group }}</span>
                                                    </div>
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
                                    </div>

                                </div>
                            @endif

                            {{-- ── Our Mode of Operation ─────────────── --}}
                            @if (!empty($service['process']))
                                @php
                                    $processIcons = [
                                        'ph-magnifying-glass',
                                        'ph-compass',
                                        'ph-pen-nib',
                                    ];
                                @endphp

                                <div class="content__block service-process">

                                    <div class="block__subtitle" style="margin-bottom: 3rem;">
                                        <p class="tagline-chapter animate-in-up">
                                            Our Mode of Operation
                                        </p>
                                    </div>

                                    <div class="process-grid">
                                        @foreach ($service['process'] as $i => $step)
                                            <div class="process-card animate-in-up">

                                                {{-- Number + icon --}}
                                                <div class="process-card__top">
                                                    {{--                                                    <span class="process-card__number">--}}
                                                    {{--                                                        {{ str_pad($i + 1, 2, '0', STR_PAD_LEFT) }}.--}}
                                                    {{--                                                    </span>--}}
                                                    <i class="ph-thin {{ $processIcons[$i] ?? 'ph-circle' }} process-card__icon"></i>
                                                </div>

                                                {{-- Phase label: Discovery / Direction / Design --}}
                                                <h3 class="process-card__phase">{{ $step['label'] }}</h3>

                                                {{-- Step subtitle: Intelligence Gathering etc. --}}
                                                <p class="process-card__subtitle">{{ $step['title'] }}</p>

                                                {{-- Divider --}}
                                                <div class="process-card__rule"></div>

                                                {{-- Body --}}
                                                <p class="process-card__body">
                                                    {{ $step['body'] }}
                                                </p>

                                                {{-- Optional note --}}
                                                @if (!empty($step['note']))
                                                    <aside class="process-card__note">
                                                        {{ $step['note'] }}
                                                    </aside>
                                                @endif

                                            </div>
                                        @endforeach
                                    </div>

                                </div>
                            @endif

                            {{-- ── CTA ───────────────────────────────── --}}
                            <div class="content__block animate-in-up"
                                 style="margin-top: 2rem; margin-bottom: 6rem;">
                                <a class="btn btn-default hover-default start-engagement-btn" href="#!">
                                    <em></em>
                                    <span class="btn-caption">Start Engagement →</span>
                                </a>
                            </div>

                        </div>{{-- /.inner__content --}}
                    </div>{{-- /.col --}}

                    <div class="col-12 col-xl-2"></div>

                </div>{{-- /.row --}}
            </div>
        </div>
    </section>

@endsection

@push('styles')
    <style>

    </style>
@endpush
