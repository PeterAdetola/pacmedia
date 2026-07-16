@extends('layouts.app')

@section('title', 'Brand Discovery — Pacmedia')

{{-- OG tags passed into layouts.app via $metaOgImage / $metaTitle / $metaDescription --}}

@php
    $metaTitle       = $metaTitle       ?? 'Brand Discovery & Positioning — Pacmedia';
    $metaDescription = $metaDescription ?? 'A strategic questionnaire that aligns your brand\'s core positioning, visual tone, and audience profile before we begin creative work.';
    $metaOgImage     = asset('img/og-image.jpg');
@endphp
@section('content')

    {{-- ============================================================
         BRAND DISCOVERY FORM — resources/views/brand-discovery/form.blade.php
         Route:   GET  /brand-discovery(?client=slug)
                  POST /brand-discovery/submit
         Data:    $clientToken  string|null
         ============================================================ --}}

    <section id="brand-discovery" class="inner inner-grid-bottom">
        <div class="inner__wrapper">
            <div class="container-fluid p-0">
                <div class="row g-0">

                    {{-- ── Sidebar label ───────────────────────────── --}}
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

                    {{-- ── Main column ─────────────────────────────── --}}
                    <div class="col-12 col-xl-8">
                        <div class="inner__content">

                            {{-- ── Form header ─────────────────────── --}}
                            <div class="content__block grid-block bd-header animate-in-up">
                                <p class="bd-eyebrow">Brand Discovery</p>
                                <h1 class="bd-title reveal-type animate-in-up">
                                    Strategic Discovery<br/><em>&amp; Style Positioning</em>
                                </h1>
                                <p class="bd-body">This questionnaire aligns your brand's core positioning, visual tone, and audience profile before we begin. Take your time — clear answers here shape sharper creative work.</p>
                                @if ($clientToken)
                                    <p class="bd-client-tag animate-in-up">
                                        Prepared for <strong>{{ ucwords(str_replace('-', ' ', $clientToken)) }}</strong>
                                    </p>
                                @endif
                            </div>

                            {{-- ── Discovery form ──────────────────── --}}
                            <form id="discovery-form"
                                  method="POST"
                                  action="{{ route('brand-discovery.submit') }}">
                                @csrf
                                <input type="hidden" name="token" value="{{ $linkToken }}"/>
                                <input type="hidden" name="client_token" value="{{ $clientToken }}"/>


                                <!-- ══ SECTION 00 — ABOUT YOU ══════════════ -->
                                <div class="bd-section content__block animate-in-up">
                                    <div class="bd-section__header">
                                        <span class="bd-section__num">00</span>
                                        <div>
                                            <h2 class="bd-section__title">About You</h2>
                                            <p class="bd-section__desc">Basic contact details so we can connect your responses to the right brief.</p>
                                        </div>
                                    </div>

                                    <div class="bd-slider-hint">
                                        <i class="ph ph-info"></i>
                                        Not sure how to use the sliders? Skip them and describe your brand in your own words in the "Anything Else" section below — we'll translate it ourselves.
                                    </div>

                                    <div class="bd-grid-2">
                                        <div class="bd-field">
                                            <label class="bd-field__label" for="name">Full Name *</label>
                                            <input type="text" id="name" name="name" placeholder="Your name"
                                                   value="{{ $discovery->name ?? '' }}" required/>
                                        </div>
                                        <div class="bd-field">
                                            <label class="bd-field__label" for="brand_name">Brand / Business Name *</label>
                                            <input type="text" id="brand_name" name="brand_name"
                                                   placeholder="What do you call it?"
                                                   value="{{ $discovery->brand_name ?? ($clientToken ? ucwords(str_replace('-', ' ', $clientToken)) : '') }}"
                                                   required/>
                                        </div>
                                        <div class="bd-field">
                                            <label class="bd-field__label" for="email">Email Address *</label>
                                            <input type="email" id="email" name="email" placeholder="you@yourbrand.com"
                                                   value="{{ $discovery->email ?? '' }}" required/>
                                        </div>
                                        <div class="bd-field">
                                            <label class="bd-field__label" for="industry">Industry / Category</label>
                                            <input type="text" id="industry" name="industry" placeholder="e.g. Fashion, Fintech, Hospitality"/>
                                        </div>
                                    </div>

                                    <div class="bd-field">
                                        <label class="bd-field__label" for="brand_description">Describe your brand in one sentence</label>
                                        <input type="text" id="brand_description" name="brand_description" placeholder="What do you do and for whom?"/>
                                    </div>

                                    <div class="bd-field">
                                        <label class="bd-field__label">Do you have an existing brand?</label>
                                        <div class="bd-radio-group bd-radio-group--row">
                                            <div class="bd-radio-item">
                                                <input type="radio" id="brand_yes" name="existing_brand" value="Yes — full identity"/>
                                                <label class="bd-radio-item__label" for="brand_yes"><span class="bd-radio-dot"></span>Yes — full identity</label>
                                            </div>
                                            <div class="bd-radio-item">
                                                <input type="radio" id="brand_partial" name="existing_brand" value="Partial — some elements"/>
                                                <label class="bd-radio-item__label" for="brand_partial"><span class="bd-radio-dot"></span>Partial — some elements</label>
                                            </div>
                                            <div class="bd-radio-item">
                                                <input type="radio" id="brand_no" name="existing_brand" value="No — starting fresh"/>
                                                <label class="bd-radio-item__label" for="brand_no"><span class="bd-radio-dot"></span>No — starting fresh</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>


                                <!-- ══ SECTION 01 — AUDIENCE PROFILE ═══════ -->
                                <div class="bd-section content__block animate-in-up">
                                    <div class="bd-section__header">
                                        <span class="bd-section__num">01</span>
                                        <div>
                                            <h2 class="bd-section__title">Client Audience Profile</h2>
                                            <p class="bd-section__desc">Describe the people your brand is built to serve.</p>
                                        </div>
                                    </div>

                                    <div class="bd-field">
                                        <label class="bd-field__label" for="persona">Ideal Client — Baseline Persona</label>
                                        <p class="bd-field__hint">Summarise who they are: habits, values, what they care about, where they live.</p>
                                        <textarea id="persona" name="persona" rows="4" placeholder="e.g. Urban professionals, 28–40, value quality over cost, discovery-driven shoppers…"></textarea>
                                    </div>

                                    <details class="bd-more">
                                        <summary>More detail (optional)</summary>
                                        <div class="bd-more__body">
                                            <p class="bd-more__intro">Only fill these in if age or profile genuinely narrows who this brand is for.</p>

                                            <div class="bd-field">
                                                <label class="bd-field__label">Age Range</label>
                                                <div class="bd-range-wrap">
                                                    <div class="bd-range-display">
                                                        <div class="bd-range-val" id="age-min-display">18 <span>min</span></div>
                                                        <div class="bd-range-label-center">Age Range</div>
                                                        <div class="bd-range-val" id="age-max-display">45 <span>max</span></div>
                                                    </div>
                                                    <div class="bd-range-track">
                                                        <div class="bd-range-fill" id="age-fill"></div>
                                                    </div>
                                                    <div class="bd-range-dual">
                                                        <input type="range" id="age-min" name="age_min" min="0" max="100" value="18"/>
                                                        <input type="range" id="age-max" name="age_max" min="0" max="100" value="45"/>
                                                    </div>
                                                    <div class="bd-range-labels"><span>0</span><span>25</span><span>50</span><span>75</span><span>100</span></div>
                                                </div>
                                            </div>

                                            <div class="bd-field">
                                                <label class="bd-field__label">Professional Profile</label>
                                                <div class="bd-check-group">
                                                    <div class="bd-check-pill"><input type="checkbox" id="p1" name="profile[]" value="Professionals"/><label class="bd-check-pill__label" for="p1">Professionals</label></div>
                                                    <div class="bd-check-pill"><input type="checkbox" id="p2" name="profile[]" value="Working Class"/><label class="bd-check-pill__label" for="p2">Working Class</label></div>
                                                    <div class="bd-check-pill"><input type="checkbox" id="p3" name="profile[]" value="Business Owners"/><label class="bd-check-pill__label" for="p3">Business Owners</label></div>
                                                    <div class="bd-check-pill"><input type="checkbox" id="p4" name="profile[]" value="Retirees"/><label class="bd-check-pill__label" for="p4">Retirees</label></div>
                                                    <div class="bd-check-pill"><input type="checkbox" id="p5" name="profile[]" value="People with Special Needs"/><label class="bd-check-pill__label" for="p5">People with Special Needs</label></div>
                                                    <div class="bd-check-pill"><input type="checkbox" id="p6" name="profile[]" value="Startups"/><label class="bd-check-pill__label" for="p6">Startups</label></div>
                                                    <div class="bd-check-pill"><input type="checkbox" id="p7" name="profile[]" value="Established Organisations"/><label class="bd-check-pill__label" for="p7">Established Organisations</label></div>
                                                </div>
                                            </div>
                                        </div>
                                    </details>
                                </div>


                                <!-- ══ SECTION 02 — TONE & BRAND VALUES ════ -->
                                <div class="bd-section content__block animate-in-up">
                                    <div class="bd-section__header">
                                        <span class="bd-section__num">02</span>
                                        <div>
                                            <h2 class="bd-section__title">Tone &amp; Brand Values</h2>
                                            <p class="bd-section__desc">Slide each axis toward the quality that best describes your brand. Extremes are fine.</p>
                                        </div>
                                    </div>

                                    <p class="bd-field__label" style="margin-bottom:0.6rem;">The Essentials</p>
                                    <p class="bd-field__hint" style="margin-bottom:2rem;">These five shape almost every creative decision we make.</p>

                                    <div class="bd-trait-row"><span class="bd-trait-label">Playful</span><input type="range" class="bd-trait-slider" name="trait_playful_serious" min="-3" max="3" value="0"/><span class="bd-trait-label bd-trait-label--right">Serious</span><p class="bd-trait-hint">Fun and energetic, or composed and formal?</p></div>
                                    <div class="bd-trait-row"><span class="bd-trait-label">Approachable</span><input type="range" class="bd-trait-slider" name="trait_approachable_elite" min="-3" max="3" value="0"/><span class="bd-trait-label bd-trait-label--right">Elite</span><p class="bd-trait-hint">Open to everyone, or reserved for a select few?</p></div>
                                    <div class="bd-trait-row"><span class="bd-trait-label">Casual</span><input type="range" class="bd-trait-slider" name="trait_casual_elegant" min="-3" max="3" value="0"/><span class="bd-trait-label bd-trait-label--right">Elegant</span><p class="bd-trait-hint">Relaxed and easygoing, or refined and polished?</p></div>
                                    <div class="bd-trait-row"><span class="bd-trait-label">Simple</span><input type="range" class="bd-trait-slider" name="trait_simple_complex" min="-3" max="3" value="0"/><span class="bd-trait-label bd-trait-label--right">Complex</span><p class="bd-trait-hint">Clear and minimal, or layered and detailed?</p></div>
                                    <div class="bd-trait-row"><span class="bd-trait-label">Classic</span><input type="range" class="bd-trait-slider" name="trait_classic_contemporary" min="-3" max="3" value="0"/><span class="bd-trait-label bd-trait-label--right">Contemporary</span><p class="bd-trait-hint">Rooted in tradition, or current and forward-looking?</p></div>

                                    <details class="bd-more">
                                        <summary>More nuance (optional)</summary>
                                        <div class="bd-more__body">
                                            <p class="bd-more__intro">Only worth the time if your brand sits at an unusual extreme on one of these.</p>
                                            <div class="bd-trait-row"><span class="bd-trait-label">Unconventional</span><input type="range" class="bd-trait-slider" name="trait_unconventional_mainstream" min="-3" max="3" value="0"/><span class="bd-trait-label bd-trait-label--right">Mainstream</span><p class="bd-trait-hint">Bold and different, or familiar and expected?</p></div>
                                            <div class="bd-trait-row"><span class="bd-trait-label">Industrial</span><input type="range" class="bd-trait-slider" name="trait_industrial_natural" min="-3" max="3" value="0"/><span class="bd-trait-label bd-trait-label--right">Natural</span><p class="bd-trait-hint">Raw and mechanical, or organic and earthy?</p></div>
                                            <div class="bd-trait-row"><span class="bd-trait-label">Feminine</span><input type="range" class="bd-trait-slider" name="trait_feminine_masculine" min="-3" max="3" value="0"/><span class="bd-trait-label bd-trait-label--right">Masculine</span><p class="bd-trait-hint">Soft and graceful, or strong and rugged?</p></div>
                                            <div class="bd-trait-row"><span class="bd-trait-label">Youthful</span><input type="range" class="bd-trait-slider" name="trait_youthful_established" min="-3" max="3" value="0"/><span class="bd-trait-label bd-trait-label--right">Established</span><p class="bd-trait-hint">Fresh and new, or seasoned with legacy?</p></div>
                                            <div class="bd-trait-row"><span class="bd-trait-label">Subtle</span><input type="range" class="bd-trait-slider" name="trait_subtle_bright" min="-3" max="3" value="0"/><span class="bd-trait-label bd-trait-label--right">Bright</span><p class="bd-trait-hint">Quiet and muted, or vivid and loud?</p></div>
                                            <div class="bd-trait-row"><span class="bd-trait-label">Friendly</span><input type="range" class="bd-trait-slider" name="trait_friendly_authoritative" min="-3" max="3" value="0"/><span class="bd-trait-label bd-trait-label--right">Authoritative</span><p class="bd-trait-hint">Warm and personable, or firm and commanding?</p></div>
                                            <div class="bd-trait-row"><span class="bd-trait-label">Economical</span><input type="range" class="bd-trait-slider" name="trait_economical_strong" min="-3" max="3" value="0"/><span class="bd-trait-label bd-trait-label--right">Strong</span><p class="bd-trait-hint">Efficient and lean, or powerful and dominant?</p></div>
                                            <div class="bd-trait-row"><span class="bd-trait-label">Empathetic</span><input type="range" class="bd-trait-slider" name="trait_empathetic_detached" min="-3" max="3" value="0"/><span class="bd-trait-label bd-trait-label--right">Detached</span><p class="bd-trait-hint">Emotionally attuned, or objective and distant?</p></div>
                                            <div class="bd-trait-row"><span class="bd-trait-label">Compassionate</span><input type="range" class="bd-trait-slider" name="trait_compassionate_functional" min="-3" max="3" value="0"/><span class="bd-trait-label bd-trait-label--right">Functional</span><p class="bd-trait-hint">People-first, or purely practical?</p></div>
                                            <div class="bd-trait-row"><span class="bd-trait-label">Diverse</span><input type="range" class="bd-trait-slider" name="trait_diverse_niche" min="-3" max="3" value="0"/><span class="bd-trait-label bd-trait-label--right">Niche</span><p class="bd-trait-hint">Broad appeal, or specialised focus?</p></div>
                                            <div class="bd-trait-row"><span class="bd-trait-label">Local</span><input type="range" class="bd-trait-slider" name="trait_local_global" min="-3" max="3" value="0"/><span class="bd-trait-label bd-trait-label--right">Global</span><p class="bd-trait-hint">Rooted in one place, or built for anywhere?</p></div>
                                        </div>
                                    </details>
                                </div>


                                <!-- ══ SECTION 03 — VISUAL DIRECTION ═══════ -->
                                <div class="bd-section content__block animate-in-up">
                                    <div class="bd-section__header">
                                        <span class="bd-section__num">03</span>
                                        <div>
                                            <h2 class="bd-section__title">Visual Direction</h2>
                                            <p class="bd-section__desc">Where your brand needs to look and feel when people encounter it.</p>
                                        </div>
                                    </div>

                                    <div class="bd-field">
                                        <label class="bd-field__label">Colour Mood</label>
                                        <p class="bd-field__hint">Select all that resonate.</p>
                                        <div class="bd-swatch-grid">
                                            <div class="bd-swatch-item"><input type="checkbox" id="c1" name="colour[]" value="Monochrome"/><div class="bd-swatch-item__chip" style="background:linear-gradient(135deg,#222,#888,#ddd);"></div><p class="bd-swatch-item__name">Mono</p></div>
                                            <div class="bd-swatch-item"><input type="checkbox" id="c2" name="colour[]" value="Warm Neutrals"/><div class="bd-swatch-item__chip" style="background:linear-gradient(135deg,#c4a882,#e8d5b7,#f5ece0);"></div><p class="bd-swatch-item__name">Warm</p></div>
                                            <div class="bd-swatch-item"><input type="checkbox" id="c3" name="colour[]" value="Cool Blues"/><div class="bd-swatch-item__chip" style="background:linear-gradient(135deg,#1a3a5c,#4a7fa8,#a8ccdd);"></div><p class="bd-swatch-item__name">Cool</p></div>
                                            <div class="bd-swatch-item"><input type="checkbox" id="c4" name="colour[]" value="Earth Tones"/><div class="bd-swatch-item__chip" style="background:linear-gradient(135deg,#5c3d1e,#a0724a,#d4a574);"></div><p class="bd-swatch-item__name">Earth</p></div>
                                            <div class="bd-swatch-item"><input type="checkbox" id="c5" name="colour[]" value="Bold & Vibrant"/><div class="bd-swatch-item__chip" style="background:linear-gradient(135deg,#e63946,#f4a261,#2a9d8f);"></div><p class="bd-swatch-item__name">Vibrant</p></div>
                                            <div class="bd-swatch-item"><input type="checkbox" id="c6" name="colour[]" value="Gold & Luxury"/><div class="bd-swatch-item__chip" style="background:linear-gradient(135deg,#1c1a17,#c8a96e,#f0e6c8);"></div><p class="bd-swatch-item__name">Luxury</p></div>
                                            <div class="bd-swatch-item"><input type="checkbox" id="c7" name="colour[]" value="Pastel & Soft"/><div class="bd-swatch-item__chip" style="background:linear-gradient(135deg,#ffd6e0,#c5e3f7,#d4f1c4);"></div><p class="bd-swatch-item__name">Soft</p></div>
                                            <div class="bd-swatch-item"><input type="checkbox" id="c8" name="colour[]" value="Dark & Moody"/><div class="bd-swatch-item__chip" style="background:linear-gradient(135deg,#0a0a0a,#1e1e2e,#2d2d44);"></div><p class="bd-swatch-item__name">Dark</p></div>
                                        </div>
                                    </div>

                                    <div class="bd-field">
                                        <label class="bd-field__label">Typography Feel</label>
                                        <div class="bd-check-group">
                                            <div class="bd-check-pill"><input type="checkbox" id="t1" name="typography[]" value="Clean & Geometric"/><label class="bd-check-pill__label" for="t1">Clean &amp; Geometric</label></div>
                                            <div class="bd-check-pill"><input type="checkbox" id="t2" name="typography[]" value="Serif & Editorial"/><label class="bd-check-pill__label" for="t2">Serif &amp; Editorial</label></div>
                                            <div class="bd-check-pill"><input type="checkbox" id="t3" name="typography[]" value="Handcrafted & Script"/><label class="bd-check-pill__label" for="t3">Handcrafted</label></div>
                                            <div class="bd-check-pill"><input type="checkbox" id="t4" name="typography[]" value="Bold & Expressive"/><label class="bd-check-pill__label" for="t4">Bold &amp; Expressive</label></div>
                                            <div class="bd-check-pill"><input type="checkbox" id="t5" name="typography[]" value="Minimal & Modern"/><label class="bd-check-pill__label" for="t5">Minimal &amp; Modern</label></div>
                                            <div class="bd-check-pill"><input type="checkbox" id="t6" name="typography[]" value="Classic & Timeless"/><label class="bd-check-pill__label" for="t6">Classic &amp; Timeless</label></div>
                                        </div>
                                    </div>

                                    <details class="bd-more">
                                        <summary>More detail (optional)</summary>
                                        <div class="bd-more__body">
                                            <p class="bd-more__intro">Useful for scoping the full rollout — skip it if you're not sure yet.</p>
                                            <div class="bd-field">
                                                <label class="bd-field__label">Brand Touchpoints</label>
                                                <p class="bd-field__hint">Where will your brand live? Select all that apply.</p>
                                                <div class="bd-check-group">
                                                    <div class="bd-check-pill"><input type="checkbox" id="tp1" name="touchpoints[]" value="Logo & Mark"/><label class="bd-check-pill__label" for="tp1">Logo &amp; Mark</label></div>
                                                    <div class="bd-check-pill"><input type="checkbox" id="tp2" name="touchpoints[]" value="Website"/><label class="bd-check-pill__label" for="tp2">Website</label></div>
                                                    <div class="bd-check-pill"><input type="checkbox" id="tp3" name="touchpoints[]" value="Packaging"/><label class="bd-check-pill__label" for="tp3">Packaging</label></div>
                                                    <div class="bd-check-pill"><input type="checkbox" id="tp4" name="touchpoints[]" value="Signage & Environmental"/><label class="bd-check-pill__label" for="tp4">Signage</label></div>
                                                    <div class="bd-check-pill"><input type="checkbox" id="tp5" name="touchpoints[]" value="Social Media"/><label class="bd-check-pill__label" for="tp5">Social Media</label></div>
                                                    <div class="bd-check-pill"><input type="checkbox" id="tp6" name="touchpoints[]" value="Print & Collateral"/><label class="bd-check-pill__label" for="tp6">Print</label></div>
                                                    <div class="bd-check-pill"><input type="checkbox" id="tp7" name="touchpoints[]" value="Uniforms & Merch"/><label class="bd-check-pill__label" for="tp7">Uniforms &amp; Merch</label></div>
                                                    <div class="bd-check-pill"><input type="checkbox" id="tp8" name="touchpoints[]" value="Motion & Video"/><label class="bd-check-pill__label" for="tp8">Motion &amp; Video</label></div>
                                                </div>
                                            </div>
                                        </div>
                                    </details>
                                </div>


                                <!-- ══ SECTION 04 — COMPETITIVE CONTEXT ════ -->
                                <div class="bd-section content__block animate-in-up">
                                    <div class="bd-section__header">
                                        <span class="bd-section__num">04</span>
                                        <div>
                                            <h2 class="bd-section__title">Competitive Context</h2>
                                            <p class="bd-section__desc">Understanding the landscape helps us position you distinctly within it.</p>
                                        </div>
                                    </div>

                                    <div class="bd-field">
                                        <label class="bd-field__label" for="competitors">Key Competitors</label>
                                        <p class="bd-field__hint">Name 2–4 brands you compete with or are often compared to.</p>
                                        <textarea id="competitors" name="competitors" rows="3" placeholder="e.g. Brand A, Brand B…"></textarea>
                                    </div>

                                    <div class="bd-field">
                                        <label class="bd-field__label" for="differentiator">Your Key Differentiator</label>
                                        <p class="bd-field__hint">What do you do or offer that your competitors genuinely don't or can't?</p>
                                        <textarea id="differentiator" name="differentiator" rows="3" placeholder="What makes you the only option for the right client?"></textarea>
                                    </div>

                                    <details class="bd-more">
                                        <summary>More detail (optional)</summary>
                                        <div class="bd-more__body">
                                            <div class="bd-field">
                                                <label class="bd-field__label" for="admired">Brands You Admire</label>
                                                <p class="bd-field__hint">Not necessarily competitors — any brand whose visual identity or positioning you respect.</p>
                                                <textarea id="admired" name="admired" rows="3" placeholder="e.g. Apple, Moët, Nike… and why they stand out to you."></textarea>
                                            </div>
                                        </div>
                                    </details>
                                </div>


                                <!-- ══ SECTION 05 — BRAND AMBITION ═════════ -->
                                <div class="bd-section content__block animate-in-up">
                                    <div class="bd-section__header">
                                        <span class="bd-section__num">05</span>
                                        <div>
                                            <h2 class="bd-section__title">Brand Ambition</h2>
                                            <p class="bd-section__desc">Where this brand is going — not where it is today.</p>
                                        </div>
                                    </div>

                                    <div class="bd-field">
                                        <label class="bd-field__label" for="five_year">5-Year Vision</label>
                                        <p class="bd-field__hint">What does this brand look like in five years? Scale, reach, reputation.</p>
                                        <textarea id="five_year" name="five_year" rows="4" placeholder="Describe the version of this brand that you're building toward."></textarea>
                                    </div>

                                    <div class="bd-field">
                                        <label class="bd-field__label">Urgency</label>
                                        <div class="bd-radio-group bd-radio-group--row">
                                            <div class="bd-radio-item"><input type="radio" id="u1" name="urgency" value="Launch ready — fast"/><label class="bd-radio-item__label" for="u1"><span class="bd-radio-dot"></span>Launch ready — fast</label></div>
                                            <div class="bd-radio-item"><input type="radio" id="u2" name="urgency" value="Considered — 4–8 weeks"/><label class="bd-radio-item__label" for="u2"><span class="bd-radio-dot"></span>Considered — 4–8 weeks</label></div>
                                            <div class="bd-radio-item"><input type="radio" id="u3" name="urgency" value="Strategic — no hard deadline"/><label class="bd-radio-item__label" for="u3"><span class="bd-radio-dot"></span>Strategic — no hard deadline</label></div>
                                        </div>
                                    </div>

                                    <div class="bd-field">
                                        <label class="bd-field__label" for="anything_else">Anything Else</label>
                                        <p class="bd-field__hint">Constraints, non-negotiables, things you've tried before that didn't work.</p>
                                        <textarea id="anything_else" name="anything_else" rows="5" placeholder="No limits here — the more context, the sharper the creative brief."></textarea>
                                    </div>
                                </div>


                                <!-- ══ SUBMIT ════════════════════════════════ -->
                                <div class="bd-footer content__block animate-in-up">
                                    <p class="bd-footer__note">Your responses go directly to the Pacmedia team. We'll review everything before our first session and come prepared.</p>
                                    <div id="form-response" style="display:none;">
                                        <p id="form-response-text"></p>
                                    </div>
                                    <button class="btn btn-default hover-default bd-submit" type="submit" id="form-submit-btn">
                                        <em></em>
                                        <span class="btn-caption" id="form-btn-caption">Submit Discovery →</span>
                                    </button>
                                </div>

                            </form>

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


@push('scripts')
    <script>
        /* ── Dual age range slider ───────────────────────────────────── */
        (function () {
            var minInput = document.getElementById('age-min');
            var maxInput = document.getElementById('age-max');
            var fill     = document.getElementById('age-fill');
            var minDisp  = document.getElementById('age-min-display');
            var maxDisp  = document.getElementById('age-max-display');
            if (!minInput) return;

            function update() {
                var minVal = parseInt(minInput.value);
                var maxVal = parseInt(maxInput.value);
                if (minVal > maxVal) {
                    if (this === minInput) maxInput.value = minVal;
                    else minInput.value = maxVal;
                    minVal = parseInt(minInput.value);
                    maxVal = parseInt(maxInput.value);
                }
                fill.style.left  = minVal + '%';
                fill.style.width = (maxVal - minVal) + '%';
                minDisp.innerHTML = minVal + ' <span>min</span>';
                maxDisp.innerHTML = maxVal + ' <span>max</span>';
            }
            minInput.addEventListener('input', update);
            maxInput.addEventListener('input', update);
            update.call(minInput);
        })();

        /* ── Swatch chips ───────────────────────────────────────────── */
        document.querySelectorAll('#brand-discovery .bd-swatch-item').forEach(function (item) {
            item.querySelector('.bd-swatch-item__chip').addEventListener('click', function () {
                item.querySelector('input').click();
            });
        });

        /* ── Mobile trait label bars ────────────────────────────────── */
        (function () {
            function buildBars() {
                if (window.innerWidth > 600) return;
                document.querySelectorAll('#brand-discovery .bd-trait-row').forEach(function (row) {
                    if (row.querySelector('.bd-trait-labels-bar')) return;
                    var labels = row.querySelectorAll('.bd-trait-label');
                    if (labels.length < 2) return;
                    var bar = document.createElement('div');
                    bar.className = 'bd-trait-labels-bar';
                    bar.innerHTML = '<span>' + labels[0].textContent + '</span>'
                        + '<span>' + labels[1].textContent + '</span>';
                    row.insertBefore(bar, row.querySelector('.bd-trait-slider'));
                });
            }
            buildBars();
            window.addEventListener('resize', buildBars, { passive: true });
        })();

        /* ── Form submission ────────────────────────────────────────── */
        (function () {
            var form    = document.getElementById('discovery-form');
            var btn     = document.getElementById('form-submit-btn');
            var caption = document.getElementById('form-btn-caption');
            var respBox = document.getElementById('form-response');
            var respTxt = document.getElementById('form-response-text');
            if (!form) return;

            form.addEventListener('submit', async function (e) {
                e.preventDefault();
                btn.disabled        = true;
                caption.textContent = 'Sending…';

                try {
                    var res  = await fetch('{{ route("brand-discovery.submit") }}', {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                            'Accept':       'application/json',
                        },
                        body: new FormData(form),
                    });
                    var json = await res.json();

                    respBox.style.display = 'block';
                    if (json.success) {
                        respTxt.style.color  = '';
                        respTxt.textContent  = json.message || 'Received. We\'ll be in touch.';
                        caption.textContent  = 'Sent ✓';
                        form.reset();
                    } else {
                        respTxt.style.color = '#c0392b';
                        respTxt.textContent = json.message || 'Something went wrong. Please try again.';
                        caption.textContent = 'Submit Discovery →';
                        btn.disabled        = false;
                    }
                } catch (err) {
                    respBox.style.display = 'block';
                    respTxt.style.color   = '#c0392b';
                    respTxt.textContent   = 'Network error. Please check your connection.';
                    caption.textContent   = 'Submit Discovery →';
                    btn.disabled          = false;
                }
            });
        })();
    </script>
@endpush
