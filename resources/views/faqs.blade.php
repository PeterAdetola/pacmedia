@extends('layouts.app')
@section('content')

    {{-- ================================================ --}}
    {{-- FULL FAQs PAGE --}}
    {{-- ================================================ --}}
    <section id="faqs" class="inner inner-grid-bottom">
        <div class="inner__wrapper">
            <div class="container-fluid p-0">
                <div class="row g-0">

                    {{-- Section Name --}}
                    <div class="col-12 col-xl-2">
                        <div class="inner__name">
                            <div class="content__block name-block">
                            <span class="section-name icon-right animate-in-up">
                                <span class="section-name-caption">Intelligence Brief</span>
                                <i class="ph ph-arrow-down-right"></i>
                            </span>
                            </div>
                        </div>
                    </div>

                    {{-- Section Content --}}
                    <div class="col-12 col-xl-8">
                        <div class="inner__content">

                            {{-- Title --}}
                            <div class="content__block section-tagline-title">
                                <div class="block__descr">
                                    <h2 class="reveal-type animate-in-up">
                                        {!! $faqTitle !!}
                                    </h2>
                                </div>
                            </div>

                            {{-- Subtitle --}}
                            <div class="content__block pre-text-items" style="margin-bottom: 2rem;">
{{--                                <div class="block__subtitle">--}}
{{--                                    <p class="tagline-chapter animate-in-up">{{ $faqSubtitle }}</p>--}}
{{--                                </div>--}}

                                {{-- FAQ Groups --}}
                                @foreach($groups as $groupName => $faqs)
                                    <div class="container-fluid p-0 resume-lines" style="margin-bottom: 6rem;">

                                        {{-- Group Heading --}}
                                        <div class="faq-divider animate-in-up"></div>
                                        <p class="tagline-chapter animate-in-up"
                                           style="margin: 2.5rem 0;">
                                            {{ Str::title($groupName) }}
                                        </p>
                                        <div class="faq-lines__divider"></div>

                                        {{-- FAQ Items --}}
                                        <ul class="faq-lines d-flex flex-column">
                                            @foreach($faqs as $index => $faq)
                                                <li class="faq-lines__item">
                                                    <div class="faq-lines__trigger">
                                                        <h4 class="animate-in-up">
                                                <span style="color: var(--t-muted); font-size: 0.6em; margin-right: 1.5rem; font-weight: 400;">
                                                    {{ str_pad($index + 1, 2, '0', STR_PAD_LEFT) }}.
                                                </span>
                                                            {{ $faq['question'] }}
                                                        </h4>
                                                        <div class="socials-lines__icon d-flex animate-in-up">
                                                            <i class="ph ph-arrow-up-right"></i>
                                                        </div>
                                                    </div>
                                                    <div class="faq-lines__answer">
                                                        <p class="faq-space">{{ $faq['answer'] }}</p>
                                                    </div>
                                                    <div class="faq-lines__divider"></div>
                                                </li>
                                            @endforeach
                                        </ul>

                                        <div class="faq-divider animate-in-up"></div>
                                    </div>
                                @endforeach

                                {{-- CTA --}}
                                <div class="content__block animate-in-up" style="margin-top: 2rem; margin-bottom: 6rem;">
                                    <a class="btn btn-default hover-default start-engagement-btn" href="#!">
                                        <em></em>
                                        <span class="btn-caption">Start Engagement →</span>
                                    </a>
                                </div>

                            </div>

                        </div>
                    </div>

                    <div class="col-12 col-xl-2"></div>

                </div>
            </div>
        </div>
    </section>

@endsection
