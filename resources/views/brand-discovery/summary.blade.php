{{-- resources/views/brand-discovery/summary.blade.php --}}
@extends('layouts.app')

@section('title', 'Brand Discovery — Received')

@php
    $metaTitle       = $discovery->brand_name ? "Brand Discovery — {$discovery->brand_name}" : 'Brand Discovery — Received';
    $metaDescription = 'This discovery questionnaire has already been submitted and is now read-only.';
    $metaOgImage     = asset('img/og-image.jpg');

    $traitLabels = [
        'trait_playful_serious'            => ['Playful', 'Serious'],
        'trait_approachable_elite'         => ['Approachable', 'Elite'],
        'trait_casual_elegant'              => ['Casual', 'Elegant'],
        'trait_simple_complex'              => ['Simple', 'Complex'],
        'trait_classic_contemporary'        => ['Classic', 'Contemporary'],
        'trait_unconventional_mainstream'   => ['Unconventional', 'Mainstream'],
        'trait_industrial_natural'          => ['Industrial', 'Natural'],
        'trait_feminine_masculine'          => ['Feminine', 'Masculine'],
        'trait_youthful_established'        => ['Youthful', 'Established'],
        'trait_subtle_bright'               => ['Subtle', 'Bright'],
        'trait_friendly_authoritative'      => ['Friendly', 'Authoritative'],
        'trait_economical_strong'           => ['Economical', 'Strong'],
        'trait_empathetic_detached'         => ['Empathetic', 'Detached'],
        'trait_compassionate_functional'    => ['Compassionate', 'Functional'],
        'trait_diverse_niche'               => ['Diverse', 'Niche'],
        'trait_local_global'                => ['Local', 'Global'],
    ];
@endphp

@section('content')

    <section id="brand-discovery" class="inner inner-grid-bottom">
        <div class="inner__wrapper">
            <div class="container-fluid p-0">
                <div class="row g-0">

                    <div class="col-12 col-xl-2">
                        <div class="inner__name">
                            <div class="content__block name-block">
                            <span class="section-name icon-right animate-in-up">
                                <span class="section-name-caption">Brand Discovery</span>
                                <i class="ph ph-arrow-down-right"></i>
                            </span>
                            </div>
                        </div>
                    </div>

                    <div class="col-12 col-xl-8">
                        <div class="inner__content">

                            <div class="content__block grid-block bd-header animate-in-up">
                                <p class="bd-eyebrow">Received</p>
                                <h1 class="bd-title reveal-type animate-in-up">
                                    Thanks{{ $discovery->name ? ',' : '.' }}<br/>
                                    @if($discovery->name)<em>{{ $discovery->name }}</em>@endif
                                </h1>
                                <p class="bd-body">
                                    We've received your responses
                                    @if($discovery->brand_name) for <strong>{{ $discovery->brand_name }}</strong> @endif
                                    on {{ $discovery->submitted_at?->format('d M, Y') ?? $discovery->updated_at->format('d M, Y') }}.
                                    This link is now read-only — if anything needs to change, just reply to our last message.
                                </p>
                            </div>

                            {{-- 00 — About --}}
                            <div class="bd-section content__block animate-in-up">
                                <div class="bd-section__header">
                                    <span class="bd-section__num">00</span>
                                    <div>
                                        <h2 class="bd-section__title">About You</h2>
                                    </div>
                                </div>
                                <div class="bd-grid-2">
                                    <div class="bd-field">
                                        <div class="bd-field__label">Full Name</div>
                                        <div class="bd-summary-value">{{ $discovery->name ?: '—' }}</div>
                                    </div>
                                    <div class="bd-field">
                                        <div class="bd-field__label">Brand / Business Name</div>
                                        <div class="bd-summary-value">{{ $discovery->brand_name ?: '—' }}</div>
                                    </div>
                                    <div class="bd-field">
                                        <div class="bd-field__label">Email</div>
                                        <div class="bd-summary-value">{{ $discovery->email ?: '—' }}</div>
                                    </div>
                                    <div class="bd-field">
                                        <div class="bd-field__label">Industry</div>
                                        <div class="bd-summary-value">{{ $discovery->industry ?: '—' }}</div>
                                    </div>
                                </div>
                                @if($discovery->brand_description)
                                    <div class="bd-field">
                                        <div class="bd-field__label">Brand Description</div>
                                        <div class="bd-summary-value">{{ $discovery->brand_description }}</div>
                                    </div>
                                @endif
                                @if($discovery->existing_brand)
                                    <div class="bd-field">
                                        <div class="bd-field__label">Existing Brand?</div>
                                        <div class="bd-summary-value">{{ $discovery->existing_brand }}</div>
                                    </div>
                                @endif
                            </div>

                            {{-- 01 — Audience --}}
                            @if($discovery->persona || $discovery->age_min !== null || !empty($discovery->profile))
                                <div class="bd-section content__block animate-in-up">
                                    <div class="bd-section__header">
                                        <span class="bd-section__num">01</span>
                                        <div><h2 class="bd-section__title">Client Audience Profile</h2></div>
                                    </div>
                                    @if($discovery->persona)
                                        <div class="bd-field">
                                            <div class="bd-field__label">Ideal Client</div>
                                            <div class="bd-summary-value">{{ $discovery->persona }}</div>
                                        </div>
                                    @endif
                                    @if($discovery->age_min !== null)
                                        <div class="bd-field">
                                            <div class="bd-field__label">Age Range</div>
                                            <div class="bd-summary-value">{{ $discovery->age_min }} – {{ $discovery->age_max }}</div>
                                        </div>
                                    @endif
                                    @if(!empty($discovery->profile))
                                        <div class="bd-field">
                                            <div class="bd-field__label">Professional Profile</div>
                                            <div>@foreach($discovery->profile as $p)<span class="bd-summary-chip">{{ $p }}</span>@endforeach</div>
                                        </div>
                                    @endif
                                </div>
                            @endif

                            {{-- 02 — Tone & Values --}}
                            @if(!empty(array_filter($discovery->traits ?? [])))
                                <div class="bd-section content__block animate-in-up">
                                    <div class="bd-section__header">
                                        <span class="bd-section__num">02</span>
                                        <div><h2 class="bd-section__title">Tone &amp; Brand Values</h2></div>
                                    </div>
                                    @foreach($traitLabels as $key => [$left, $right])
                                        @php $val = $discovery->traits[$key] ?? 0; @endphp
                                        @if($val != 0)
                                            <div class="bd-summary-trait-row">
                                                <span class="bd-trait-label">{{ $left }}</span>
                                                <div class="bd-summary-trait-track">
                                                    <div class="bd-summary-trait-dot" style="left: {{ (($val + 3) / 6) * 100 }}%;"></div>
                                                </div>
                                                <span class="bd-trait-label bd-trait-label--right">{{ $right }}</span>
                                            </div>
                                        @endif
                                    @endforeach
                                </div>
                            @endif

                            {{-- 03 — Visual Direction --}}
                            @if(!empty($discovery->colour) || !empty($discovery->typography) || !empty($discovery->touchpoints))
                                <div class="bd-section content__block animate-in-up">
                                    <div class="bd-section__header">
                                        <span class="bd-section__num">03</span>
                                        <div><h2 class="bd-section__title">Visual Direction</h2></div>
                                    </div>
                                    @if(!empty($discovery->colour))
                                        <div class="bd-field">
                                            <div class="bd-field__label">Colour Mood</div>
                                            <div>@foreach($discovery->colour as $c)<span class="bd-summary-chip">{{ $c }}</span>@endforeach</div>
                                        </div>
                                    @endif
                                    @if(!empty($discovery->typography))
                                        <div class="bd-field">
                                            <div class="bd-field__label">Typography Feel</div>
                                            <div>@foreach($discovery->typography as $t)<span class="bd-summary-chip">{{ $t }}</span>@endforeach</div>
                                        </div>
                                    @endif
                                    @if(!empty($discovery->touchpoints))
                                        <div class="bd-field">
                                            <div class="bd-field__label">Brand Touchpoints</div>
                                            <div>@foreach($discovery->touchpoints as $t)<span class="bd-summary-chip">{{ $t }}</span>@endforeach</div>
                                        </div>
                                    @endif
                                </div>
                            @endif

                            {{-- 04 — Competitive Context --}}
                            @if($discovery->competitors || $discovery->differentiator || $discovery->admired)
                                <div class="bd-section content__block animate-in-up">
                                    <div class="bd-section__header">
                                        <span class="bd-section__num">04</span>
                                        <div><h2 class="bd-section__title">Competitive Context</h2></div>
                                    </div>
                                    @if($discovery->competitors)
                                        <div class="bd-field"><div class="bd-field__label">Key Competitors</div><div class="bd-summary-value">{{ $discovery->competitors }}</div></div>
                                    @endif
                                    @if($discovery->differentiator)
                                        <div class="bd-field"><div class="bd-field__label">Key Differentiator</div><div class="bd-summary-value">{{ $discovery->differentiator }}</div></div>
                                    @endif
                                    @if($discovery->admired)
                                        <div class="bd-field"><div class="bd-field__label">Brands You Admire</div><div class="bd-summary-value">{{ $discovery->admired }}</div></div>
                                    @endif
                                </div>
                            @endif

                            {{-- 05 — Ambition --}}
                            @if($discovery->five_year || $discovery->urgency || $discovery->anything_else)
                                <div class="bd-section content__block animate-in-up">
                                    <div class="bd-section__header">
                                        <span class="bd-section__num">05</span>
                                        <div><h2 class="bd-section__title">Brand Ambition</h2></div>
                                    </div>
                                    @if($discovery->five_year)
                                        <div class="bd-field"><div class="bd-field__label">5-Year Vision</div><div class="bd-summary-value">{{ $discovery->five_year }}</div></div>
                                    @endif
                                    @if($discovery->urgency)
                                        <div class="bd-field"><div class="bd-field__label">Urgency</div><div class="bd-summary-value">{{ $discovery->urgency }}</div></div>
                                    @endif
                                    @if($discovery->anything_else)
                                        <div class="bd-field"><div class="bd-field__label">Anything Else</div><div class="bd-summary-value">{{ $discovery->anything_else }}</div></div>
                                    @endif
                                </div>
                            @endif

                            <div class="bd-footer content__block animate-in-up">
                                <p class="bd-footer__note">This submission is locked. Reach out to us directly if anything above needs revisiting.</p>
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
        #brand-discovery {
            --bd-font:         var(--_font-default);
            --bd-radius-s:     1rem;
            --bd-surface:      var(--base-surface, #fff);
            --bd-stroke:       var(--stroke-elements);
            --bd-stroke-light: color-mix(in srgb, var(--stroke-elements) 40%, transparent);
            --bd-fw-med:       var(--font-weight-medium);
        }
        body:has(#brand-discovery) .bottom__background { display: none; }

        #brand-discovery .bd-header  { padding-bottom: 2rem; }
        #brand-discovery .bd-eyebrow {
            display: inline-flex; align-items: center; gap: 1rem;
            font: normal var(--bd-fw-med) 1.1rem/1 var(--bd-font);
            letter-spacing: 0.18em; text-transform: uppercase;
            color: var(--t-muted); margin-bottom: 2rem;
        }
        #brand-discovery .bd-eyebrow::before { content: ''; display: block; width: 3.2rem; height: 1px; background: var(--bd-stroke); }
        #brand-discovery .bd-title {
            font: normal 300 clamp(3.4rem, 6vw, 6rem)/1.08 var(--_font-accent, var(--bd-font));
            letter-spacing: -0.02em; color: var(--t-bright); margin-bottom: 2rem;
        }
        #brand-discovery .bd-title em { font-style: italic; font-weight: 200; }
        #brand-discovery .bd-body { font-size: 1.5rem; line-height: 1.75; color: var(--t-muted); max-width: 58ch; }

        #brand-discovery .bd-section { border-top: 1px solid var(--bd-stroke-light); padding-top: 4rem; padding-bottom: 1rem; }
        #brand-discovery .bd-section__header { display: grid; grid-template-columns: 2.4rem 1fr; gap: 1.6rem; align-items: start; margin-bottom: 3.2rem; }
        #brand-discovery .bd-section__num { font: normal var(--bd-fw-med) 1.1rem/1 var(--bd-font); letter-spacing: 0.15em; color: var(--t-muted); padding-top: 0.4rem; }
        #brand-discovery .bd-section__title { font-size: 2.2rem; font-weight: 600; letter-spacing: -0.01em; color: var(--t-bright); line-height: 1.2; }

        #brand-discovery .bd-field { margin-bottom: 2.4rem; }
        #brand-discovery .bd-field__label {
            display: block; font: normal var(--bd-fw-med) 1.2rem/1 var(--bd-font);
            letter-spacing: 0.1em; text-transform: uppercase; color: var(--t-muted); margin-bottom: 0.8rem;
        }
        #brand-discovery .bd-summary-value {
            font-size: 1.5rem; line-height: 1.6; color: var(--t-bright);
            background: var(--bd-surface); border: 1px solid var(--bd-stroke-light);
            border-radius: var(--bd-radius-s); padding: 1.4rem 1.8rem; white-space: pre-line;
        }
        #brand-discovery .bd-grid-2 { display: grid; grid-template-columns: 1fr 1fr; gap: 1.6rem; }
        @media (max-width: 600px) { #brand-discovery .bd-grid-2 { grid-template-columns: 1fr; } }

        #brand-discovery .bd-summary-chip {
            display: inline-block; font: normal var(--bd-fw-med) 1.3rem/1 var(--bd-font);
            padding: 0.7rem 1.5rem; border: 1px solid var(--bd-stroke-light); border-radius: 10rem;
            color: var(--t-bright); background: var(--bd-surface); margin: 0 0.8rem 0.8rem 0;
        }

        #brand-discovery .bd-summary-trait-row {
            display: grid; grid-template-columns: 12rem 1fr 12rem; align-items: center; gap: 1.6rem;
            margin-bottom: 1.6rem; padding: 1.6rem 2rem; background: var(--bd-surface);
            border: 1px solid var(--bd-stroke-light); border-radius: var(--bd-radius-s);
        }
        #brand-discovery .bd-trait-label { font: normal var(--bd-fw-med) 1.3rem/1.3 var(--bd-font); color: var(--t-medium); }
        #brand-discovery .bd-trait-label--right { text-align: right; }
        #brand-discovery .bd-summary-trait-track { position: relative; height: 2px; background: var(--bd-stroke-light); border-radius: 2px; }
        #brand-discovery .bd-summary-trait-dot {
            position: absolute; top: 50%; width: 1.6rem; height: 1.6rem; border-radius: 50%;
            background: var(--t-bright); transform: translate(-50%, -50%);
            box-shadow: 0 0 0 3px var(--bd-surface), 0 0 0 4px var(--bd-stroke);
        }
        @media (max-width: 600px) {
            #brand-discovery .bd-summary-trait-row { grid-template-columns: 1fr; gap: 0.8rem; padding: 1.4rem 1.6rem; }
            #brand-discovery .bd-trait-label { font-size: 1.2rem; }
        }

        #brand-discovery .bd-footer { border-top: 1px solid var(--bd-stroke-light); padding-top: 4rem; padding-bottom: 6rem; }
        #brand-discovery .bd-footer__note { font-size: 1.3rem; color: var(--t-muted); line-height: 1.6; max-width: 48ch; }
    </style>
@endpush
