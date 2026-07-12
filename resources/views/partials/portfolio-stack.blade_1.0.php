<section id="portfolio" class="inner no-padding-top portfolio">
    <div class="inner__wrapper">
        <div class="container-fluid p-0">
            <div class="row g-0">

                <!-- Section Name -->
                <div class="col-12 col-xl-2">
                    <div class="inner__name">
                        <div class="content__block name-block">
                            <span class="section-name icon-right animate-in-up">
                                <span class="section-name-caption">Portfolio</span>
                                <i class="ph ph-arrow-down-right"></i>
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Section Title -->
                <div class="col-12 col-xl-8">
                    <div class="inner__content">
                        <div class="content__block section-grid-text-title">
                            <div class="block__descr">
                                <h2 class="reveal-type animate-in-up">Design, tech &<br>some magic</h2>
                                <p class="h2__text type-basic-160lh animate-in-up">I wonder if I've been changed in the night? Let me think.
                                    Was I the same when I got up this morning? I almost think I can remember feeling a little different.</p>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            <!-- Grid at full width, outside the two-column row -->
            <div class="row g-0">
                <div class="col-12">
                    <div class="inner__content">
                        <div class="content__block">
                            <div class="pf-grid">
                                @foreach ($cards as $card)
                                <a href="{{ $card['url'] }}"
                                   class="pf-grid__card"
                                   aria-label="View project: {{ $card['title'] }}">

                                    <div class="pf-grid__stage" style="background-color: {{ $card['card_color'] ?? '#e0e0e0' }};">

                                        @if (!empty($card['card_video']))
                                        <video
                                            class="pf-grid__mockup pf-grid__mockup--video"
                                            src="{{ $card['card_video'] }}"
                                            poster="{{ $card['card_image'] }}"
                                            muted
                                            playsinline
                                            preload="none"
                                            loop>
                                            <source src="{{ $card['card_video'] }}" type="video/webm">
                                            <source src="{{ str_replace('.webm', '.mp4', $card['card_video']) }}" type="video/mp4">
                                        </video>
                                        @elseif (!empty($card['card_image']))
                                        <img
                                            src="{{ $card['card_image'] }}"
                                            alt="{{ $card['title'] }} mockup"
                                            class="pf-grid__mockup"
                                            loading="lazy">
                                        @endif

                                    </div>

                                    <div class="pf-grid__meta">
                                        <div class="pf-grid__meta-top">
                                            <p class="pf-grid__title">{{ $card['title'] }}</p>
                                            <span class="pf-grid__bullet">●</span>
                                            <span class="pf-grid__industry">{{ $card['industry'] }}</span>
                                        </div>
                                        @if (!empty($card['card_service']))
                                        <p class="pf-grid__service">
                                            {{ is_array($card['card_service']) ? implode(', ', $card['card_service']) : $card['card_service'] }}
                                        </p>
                                        @endif
                                    </div>

                                </a>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>
