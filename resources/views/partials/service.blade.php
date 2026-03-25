{{-- ================================================ --}}
{{-- SERVICES SECTION --}}
{{-- ================================================ --}}
<section id="services" class="inner inner-grid-bottom services">
    <div class="inner__wrapper">
        <div class="container-fluid p-0">
            <div class="row g-0">

                {{-- Section Name --}}
                <div class="col-12 col-xl-2">
                    <div class="inner__name">
                        <div class="content__block name-block">
              <span class="section-name icon-right animate-in-up">
                <span class="section-name-caption">Capability</span>
                <i class="ph ph-arrow-down-right"></i>
              </span>
                        </div>
                    </div>
                </div>

                {{-- Section Content --}}
                <div class="col-12 col-xl-8">
                    <div class="inner__content">

                        {{-- Title --}}
                        <div class="content__block section-grid-title">
                            <div class="block__descr">
                                <h2 class="reveal-type animate-in-up">
                                    Tactical<br>Operations
                                </h2>
                            </div>
                        </div>

                        {{-- Service Cards --}}
                        <div class="content__block grid-block">
                            <div class="container-fluid p-0">
                                <div class="row g-0 align-items-stretch cards">

                                    @foreach($services as $service)
                                        <div class="col-12 col-md-6 cards__item grid-item animate-card-2">
                                            <div class="cards__card d-flex flex-column">

                                                <div class="cards__descr">
                                                    <h3 class="cards__title animate-in-up">
                                                        {!! $service['title'] !!}
                                                    </h3>
                                                    <p class="cards__text type-basic-160lh animate-in-up">
                                                        {{ $service['description'] }}
                                                    </p>
                                                    <hr class="animate-in-up"
                                                        style="border: none; border-top: 1px solid var(--stroke-elements); margin: 3rem 0 2.5rem 0;">
                                                    <h6>
                                                        <a href="{{ route('service.show', ['slug' => $service['slug']]) }}"
                                                           class="link-inline text-link animate-in-up">
                                                            View Full Scope →
                                                        </a>
                                                    </h6>
                                                </div>

                                                <div class="cards__image d-flex animate-in-up">
                                                    <img
                                                        src="{{ asset('img/services/' . $service['image']) }}"
                                                        alt="{{ $service['title'] }}"/>
                                                </div>

                                            </div>
                                        </div>
                                    @endforeach

                                </div>
                            </div>
                        </div>

                    </div>
                </div>

                <div class="col-12 col-xl-2"></div>

            </div>
        </div>
    </div>
</section>
