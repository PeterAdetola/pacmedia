{{-- ================================================ --}}
{{-- PROCESS SECTION --}}
{{-- ================================================ --}}
<section id="process" class="inner inner-grid-bottom">
    <div class="inner__wrapper">
        <div class="container-fluid p-0">
            <div class="row g-0">
                <div class="col-12 col-xl-2">
                    <div class="inner__name">
                        <div class="content__block name-block">
                            <span class="section-name icon-right animate-in-up">
                                <span class="section-name-caption">Process</span>
                                <i class="ph ph-arrow-down-right"></i>
                            </span>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-xl-8">
                    <div class="inner__content">

                        {{-- Section Title --}}
                        <div class="content__block section-tagline-title">
                            <div class="block__descr">
                                <h2 class="reveal-type animate-in-up">
                                    {{ $processTitle }}
                                </h2>
                            </div>
                        </div>

                        {{-- Process Steps --}}
                        <div class="content__block pre-text-items">
                            <div class="block__subtitle">
                                <p class="tagline-chapter animate-in-up">Our processes</p>
                            </div>

                            <div class="container-fluid p-0">
                                @php
                                    $processIcons = [
                                        'ph-magnifying-glass',
                                        'ph-compass',
                                        'ph-pen-nib',
                                    ];
                                @endphp

                                @foreach($processes as $index => $process)
                                    <div class="process-card animate-in-up">

                                        {{-- Top row: number + icon --}}
                                        <div class="process-card__top">
            <span class="process-card__number">
                {{ str_pad($index + 1, 2, '0', STR_PAD_LEFT) }}.
            </span>
                                            <i class="ph-thin {{ $processIcons[$index] ?? 'ph-circle' }} process-card__icon"></i>
                                        </div>

                                        {{-- Title --}}
                                        <h3 class="process-card__title">{{ $process['title'] }}</h3>

                                        {{-- Subtitle --}}
                                        <p class="process-card__subtitle">{{ $process['subtitle'] }}</p>

                                        {{-- Description --}}
                                        <p class="process-card__desc type-basic-160lh">{{ $process['description'] }}</p>

                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-xl-2"></div>
            </div>
        </div>
    </div>
</section>
