@extends('layouts.app')
@section('content')

    {{-- ================================================ --}}
    {{-- LEGAL PAGE — Terms & Conditions / Privacy Policy --}}
    {{-- ================================================ --}}
    <section id="legal-page" class="inner inner-grid-bottom">
        <div class="inner__wrapper">
            <div class="container-fluid p-0">
                <div class="row g-0">

                    {{-- ── Sidebar label ───────────────────────────── --}}
                    <div class="col-12 col-xl-2">
                        <div class="inner__name">
                            <div class="content__block name-block">
                            <span class="section-name icon-right animate-in-up">
                                <span class="section-name-caption">Legal</span>
                                <i class="ph ph-arrow-down-right"></i>
                            </span>
                            </div>
                        </div>
                    </div>

                    {{-- ── Main column ─────────────────────────────── --}}
                    <div class="col-12 col-xl-8">
                        <div class="inner__content">

                            {{-- ── Icon + Title ─────────────────────── --}}
                            <div class="content__block section-text-title">
                                <div class="block__descr">
                                    <i class="{{ $pageIcon }} legal-icon animate-in-up"></i>
                                    <h2 class="reveal-type animate-in-up">
                                        {!! $pageTitle !!}
                                    </h2>
                                </div>
                            </div>

                            {{-- ── Meta: effective date + tagline ────── --}}
                            <div class="content__block legal-meta animate-in-up">
                                <div class="legal-meta__inner">
                                    <p class="legal-meta__date">
                                        Effective Date: {{ $effectiveDate }}
                                    </p>
                                    <p class="legal-meta__tagline">
                                        {{ $tagline }}
                                    </p>
                                </div>
                            </div>

                            {{-- ── Sections ─────────────────────────── --}}
                            @foreach($sections as $section)
                                <div class="content__block legal-section animate-in-up">

                                    {{-- Section heading --}}
                                    <h3 class="legal-section__heading">
                                        {{ $section['heading'] }}
                                    </h3>

                                    {{-- Subsections --}}
                                    @foreach($section['subsections'] as $sub)
                                        <div class="legal-subsection">

                                            @if(!empty($sub['title']))
                                                <h4 class="legal-subsection__title">
                                                    {{ $sub['title'] }}
                                                </h4>
                                            @endif

                                            @foreach($sub['blocks'] as $block)

                                                @if($block['type'] === 'paragraph')
                                                    <p class="legal-body">{{ $block['content'] }}</p>

                                                @elseif($block['type'] === 'bullets')
                                                    <ul class="legal-list">
                                                        @foreach($block['items'] as $item)
                                                            <li class="legal-list__item">
                                                                <i class="ph ph-caret-right legal-list__caret"></i>
                                                                <span>{{ $item }}</span>
                                                            </li>
                                                        @endforeach
                                                    </ul>

                                                @elseif($block['type'] === 'note')
                                                    <aside class="legal-note">
                                                        {{ $block['content'] }}
                                                    </aside>

                                                @endif

                                            @endforeach

                                        </div>
                                    @endforeach

                                </div>
                            @endforeach


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

    </style>
@endpush
