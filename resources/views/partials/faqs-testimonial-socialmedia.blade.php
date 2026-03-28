{{-- ================================================ --}}
{{-- FAQs, TESTIMONIALS & SOCIAL MEDIA SECTION --}}
{{-- ================================================ --}}
<!-- Inner Section - FAQ - Start -->
<section id="faqs" class="inner inner-grid-bottom resume">
    <div class="inner__wrapper">
        <div class="container-fluid p-0 faq-section">
            <div class="row g-0">
                <!-- Inner Section Name Start -->
                <div class="col-12 col-xl-2">
                    <div class="inner__name">
                        <!-- Content Block - Section Name Start -->
                        <div class="content__block name-block">
                    <span class="section-name icon-right animate-in-up">
                      <span class="section-name-caption">Intelligence Brief</span>
                      <i class="ph ph-arrow-down-right"></i>
                    </span>
                        </div>
                        <!-- Content Block - Section Name Start -->
                    </div>
                </div>
                <!-- Inner Section Name End -->

                <!-- Inner Section Content Start -->
                <div class="col-12 col-xl-8">
                    <div class="inner__content">

                        <!-- Content Block - H2 Section Title Start -->
                        <div class="content__block section-tagline-title">
                            <div class="block__descr">
                                <h2 class="reveal-type animate-in-up">
                                    {!! $faqTitle !!}
                                </h2>
                            </div>
                        </div>
                        <!-- Content Block - H2 Section Title End -->

                        <!-- Content Block - FAQs Start -->
                        <div class="content__block pre-text-items" style="margin-bottom: 2rem">

                            <!-- Section Subtitle Start -->
                            <div class="block__subtitle">
                                <p class="tagline-chapter animate-in-up">{{ $faqSubtitle }}</p>
                            </div>
                            <!-- Section Subtitle End -->

                            <!-- FAQ Lines Start -->
                            <div class="container-fluid p-0 resume-lines">
                                <div class="faq-divider animate-in-up"></div>
{{--                                <h3 class="type-basic-160lh animate-in-up"--}}
{{--                                   style="margin-bottom: 3rem; color: var(--t-medium);">--}}
{{--                                    Before the briefing, here's what most people want to know.--}}
{{--                                </h3>--}}
                                <blockquote class="reveal-type animate-in-up">
                                    Before the briefing, here's what most people want to know.
                                </blockquote>
                                <br><br>
                                <div class="faq-lines__divider"></div>
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
                            <!-- FAQ Lines End -->

                        </div>
                        <!-- Content Block - FAQs End -->
                        <!-- More FAQs Link Start -->
                        <div class="content__block animate-in-up" style="margin-top: 0rem; margin-bottom: 10rem;">
                            <a class="btn btn-line icon-right slide-right" href="{{ route('faqs') }}">
                                <span class="btn-caption">More FAQs</span>
                                <i class="ph ph-arrow-right"></i>
                            </a>
                        </div>
                        <!-- More FAQs Link End -->

                        <!-- Content Block - Testimonials Start -->
{{--                        <div class="content__block pre-offcanvas-text-block">--}}
{{--                            <!-- Section Subtitle Start -->--}}
{{--                            <div class="block__subtitle">--}}
{{--                                <p class="tagline-chapter animate-in-up">--}}
{{--                                    My client's stories--}}
{{--                                </p>--}}
{{--                            </div>--}}
{{--                            <!-- Section Subtitle End -->--}}

{{--                            <!-- Testimonials Slider Start -->--}}
{{--                            <div class="testimonials-slider">--}}
{{--                                <!-- slider main container -->--}}
{{--                                <div class="swiper-testimonials">--}}
{{--                                    <!-- additional required wrapper -->--}}
{{--                                    <div class="swiper-wrapper">--}}
{{--                                        <!-- single slide -->--}}
{{--                                        <div class="swiper-slide">--}}
{{--                                            <div class="testimonials-card animate-in-up">--}}
{{--                                                <div class="container-fluid p-0 fullheight-l">--}}
{{--                                                    <div class="row g-0 d-flex align-items-stretch fullheight-l">--}}
{{--                                                        <div class="col-12 col-lg-6 testimonials-card__tdata">--}}
{{--                                                            <div class="testimonials-card__tauthor d-flex">--}}
{{--                                                                <div class="tauthor__avatar animate-in-up">--}}
{{--                                                                    <img--}}
{{--                                                                        src="https://dummyimage.com/400x400/4d4d4d/636363"--}}
{{--                                                                        alt="Review Author"/>--}}
{{--                                                                </div>--}}
{{--                                                                <div class="tauthor__info d-flex flex-column justify-content-center">--}}
{{--                                                                    <h4 class="tauthor__name animate-in-up">--}}
{{--                                                                        Alex Tomato--}}
{{--                                                                    </h4>--}}
{{--                                                                    <p class="tauthor__position small animate-in-up">--}}
{{--                                                                        Brand Manager in--}}
{{--                                                                        <a class="link-small-underline" href="#">Instant Design</a>--}}
{{--                                                                    </p>--}}
{{--                                                                    <div class="tauthor__rating d-flex animate-in-up">--}}
{{--                                                                        <i class="ph-fill ph-star"></i>--}}
{{--                                                                        <i class="ph-fill ph-star"></i>--}}
{{--                                                                        <i class="ph-fill ph-star"></i>--}}
{{--                                                                        <i class="ph-fill ph-star"></i>--}}
{{--                                                                        <i class="ph-fill ph-star"></i>--}}
{{--                                                                    </div>--}}
{{--                                                                </div>--}}
{{--                                                            </div>--}}
{{--                                                            <div class="testimonials-card__descr animate-in-up">--}}
{{--                                                                <p class="type-basic-160lh">--}}
{{--                                                                    Lorem ipsum dolor sit amet, consectetuer--}}
{{--                                                                    adipiscing elit, sed diam nonummy nibh--}}
{{--                                                                    euismod tincidunt ut laoreet dolore--}}
{{--                                                                    magna aliquam erat volutpat. Ut wisi--}}
{{--                                                                    enim ad minim veniam, quis nostrud.--}}
{{--                                                                </p>--}}
{{--                                                            </div>--}}
{{--                                                            <div class="testimonials-card__btnholder animate-in-up">--}}
{{--                                                                <a class="btn btn-line icon-right slide-right" href="#0">--}}
{{--                                                                    <span class="btn-caption">Project page</span>--}}
{{--                                                                    <i class="ph ph-arrow-right"></i>--}}
{{--                                                                </a>--}}
{{--                                                            </div>--}}
{{--                                                        </div>--}}
{{--                                                        <div class="col-12 col-lg-6 testimonials-card__timage fullheight-l">--}}
{{--                                                            <div class="timage__inner fullheight-l animate-in-up">--}}
{{--                                                                <img--}}
{{--                                                                    src="https://dummyimage.com/1400x1200/4d4d4d/636363"--}}
{{--                                                                    alt="Testimonials Image"/>--}}
{{--                                                            </div>--}}
{{--                                                        </div>--}}
{{--                                                    </div>--}}
{{--                                                </div>--}}
{{--                                            </div>--}}
{{--                                        </div>--}}
{{--                                        <!-- single slide -->--}}
{{--                                        <div class="swiper-slide">--}}
{{--                                            <div class="testimonials-card animate-in-up">--}}
{{--                                                <div class="container-fluid p-0 fullheight-l">--}}
{{--                                                    <div class="row g-0 d-flex align-items-stretch fullheight-l">--}}
{{--                                                        <div class="col-12 col-lg-6 testimonials-card__tdata">--}}
{{--                                                            <div class="testimonials-card__tauthor d-flex">--}}
{{--                                                                <div class="tauthor__avatar animate-in-up">--}}
{{--                                                                    <img--}}
{{--                                                                        src="https://dummyimage.com/400x400/4d4d4d/636363"--}}
{{--                                                                        alt="Review Author"/>--}}
{{--                                                                </div>--}}
{{--                                                                <div class="tauthor__info d-flex flex-column justify-content-center">--}}
{{--                                                                    <h4 class="tauthor__name animate-in-up">--}}
{{--                                                                        Jenny Lemon--}}
{{--                                                                    </h4>--}}
{{--                                                                    <p class="tauthor__position small animate-in-up">--}}
{{--                                                                        SEO in--}}
{{--                                                                        <a class="link-small-underline" href="#">Creative People</a>--}}
{{--                                                                    </p>--}}
{{--                                                                    <div class="tauthor__rating d-flex animate-in-up">--}}
{{--                                                                        <i class="ph-fill ph-star"></i>--}}
{{--                                                                        <i class="ph-fill ph-star"></i>--}}
{{--                                                                        <i class="ph-fill ph-star"></i>--}}
{{--                                                                        <i class="ph-fill ph-star"></i>--}}
{{--                                                                        <i class="ph-fill ph-star"></i>--}}
{{--                                                                    </div>--}}
{{--                                                                </div>--}}
{{--                                                            </div>--}}
{{--                                                            <div class="testimonials-card__descr animate-in-up">--}}
{{--                                                                <p class="type-basic-160lh">--}}
{{--                                                                    Lorem ipsum dolor sit amet, consectetuer--}}
{{--                                                                    adipiscing elit, sed diam nonummy nibh--}}
{{--                                                                    euismod tincidunt ut laoreet dolore--}}
{{--                                                                    magna aliquam erat volutpat. Ut wisi--}}
{{--                                                                    enim ad minim veniam, quis nostrud.--}}
{{--                                                                </p>--}}
{{--                                                            </div>--}}
{{--                                                            <div class="testimonials-card__btnholder animate-in-up">--}}
{{--                                                                <a class="btn btn-line icon-right slide-right" href="#0">--}}
{{--                                                                    <span class="btn-caption">Project page</span>--}}
{{--                                                                    <i class="ph ph-arrow-right"></i>--}}
{{--                                                                </a>--}}
{{--                                                            </div>--}}
{{--                                                        </div>--}}
{{--                                                        <div class="col-12 col-lg-6 testimonials-card__timage fullheight-l">--}}
{{--                                                            <div class="timage__inner fullheight-l animate-in-up">--}}
{{--                                                                <img--}}
{{--                                                                    src="https://dummyimage.com/1400x1200/4d4d4d/636363"--}}
{{--                                                                    alt="Testimonials Image"/>--}}
{{--                                                            </div>--}}
{{--                                                        </div>--}}
{{--                                                    </div>--}}
{{--                                                </div>--}}
{{--                                            </div>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}

{{--                                    <!-- Navigation Buttons -->--}}
{{--                                    <div class="swiper-button-prev mxd-slider-btn mxd-slider-btn-square-prev animate-in-up">--}}
{{--                                        <a class="btn btn-line icon-left slide-left" href="#0">--}}
{{--                                            <i class="ph ph-arrow-left"></i>--}}
{{--                                            <span class="btn-caption">Prev</span>--}}
{{--                                        </a>--}}
{{--                                    </div>--}}
{{--                                    <div class="swiper-button-next mxd-slider-btn mxd-slider-btn-square-next animate-in-up">--}}
{{--                                        <a class="btn btn-line icon-right slide-right" href="#0">--}}
{{--                                            <span class="btn-caption">Next</span>--}}
{{--                                            <i class="ph ph-arrow-right"></i>--}}
{{--                                        </a>--}}
{{--                                    </div>--}}

{{--                                    <!-- Pagination -->--}}
{{--                                    <div class="swiper-pagination mxd-swiper-pagination-fraction"></div>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                            <!-- Testimonials Slider End -->--}}

{{--                        </div>--}}
                        <!-- Content Block - Testimonials End -->

                    </div>
                </div>
                <!-- Inner Section Content End -->

                <!-- Inner Section Aside Start -->
                <div class="col-12 col-xl-2"></div>
                <!-- Inner Section Aside End -->
            </div>
        </div>
        {{-- SOCIAL MEDIA FOLLOW SECTION --}}
        <!-- Inner Section Off-canvas Content (Fullwidth Social Media Marquee & Lines) Start -->
        <div class="container-fluid p-0">
            <div class="row g-0">
                <div class="col-12">
                    <!-- Content Block - Follow us Marquee with SVG Objects Start -->
                    <div class="content__block no-padding section-tagline-title">
                        <div class="items items--gsap">
                            <div class="items__container">
                                <!-- single item -->
                                <div class="item item-regular text">
                                    <p class="item__text">Follow us</p>
                                    <div class="item__image">
                                        <svg
                                            xmlns="http://www.w3.org/2000/svg"
                                            viewBox="0 0 92.3 93.1"
                                            fill="currentColor"
                                        >
                                            <g>
                                                <rect
                                                    x="45.7"
                                                    class="st0"
                                                    width="1"
                                                    height="93.1"
                                                />
                                                <rect
                                                    x="45.7"
                                                    y="0"
                                                    transform="matrix(0.8412 -0.5407 0.5407 0.8412 -17.8476 32.3497)"
                                                    class="st0"
                                                    width="1"
                                                    height="93.1"
                                                />
                                                <rect
                                                    x="45.7"
                                                    y="0"
                                                    transform="matrix(0.4155 -0.9096 0.9096 0.4155 -15.3764 69.2119)"
                                                    class="st0"
                                                    width="1"
                                                    height="93.1"
                                                />
                                                <rect
                                                    x="-0.4"
                                                    y="46.1"
                                                    transform="matrix(0.9898 -0.1425 0.1425 0.9898 -6.1646 7.0506)"
                                                    class="st0"
                                                    width="93.1"
                                                    height="1"
                                                />
                                                <rect
                                                    x="-0.4"
                                                    y="46.1"
                                                    transform="matrix(0.7556 -0.655 0.655 0.7556 -19.2157 41.618)"
                                                    class="st0"
                                                    width="93.1"
                                                    height="1"
                                                />
                                                <rect
                                                    x="-0.4"
                                                    y="46.1"
                                                    transform="matrix(0.2812 -0.9597 0.9597 0.2812 -11.5032 77.7858)"
                                                    class="st0"
                                                    width="93.1"
                                                    height="1"
                                                />
                                                <rect
                                                    x="45.7"
                                                    y="0"
                                                    transform="matrix(0.9595 -0.2817 0.2817 0.9595 -11.2479 14.8866)"
                                                    class="st0"
                                                    width="1"
                                                    height="93.1"
                                                />
                                                <rect
                                                    x="45.7"
                                                    y="0"
                                                    transform="matrix(0.6549 -0.7557 0.7557 0.6549 -19.2631 50.9572)"
                                                    class="st0"
                                                    width="1"
                                                    height="93.1"
                                                />
                                                <rect
                                                    x="45.7"
                                                    y="0"
                                                    transform="matrix(0.1423 -0.9898 0.9898 0.1423 -6.4999 85.629)"
                                                    class="st0"
                                                    width="1"
                                                    height="93.1"
                                                />
                                                <rect
                                                    x="-0.4"
                                                    y="46.1"
                                                    transform="matrix(0.9097 -0.4153 0.4153 0.9097 -15.1716 23.381)"
                                                    class="st0"
                                                    width="93.1"
                                                    height="1"
                                                />
                                                <rect
                                                    x="-0.4"
                                                    y="46.1"
                                                    transform="matrix(0.5411 -0.8409 0.8409 0.5411 -17.9774 60.1901)"
                                                    class="st0"
                                                    width="93.1"
                                                    height="1"
                                                />
                                            </g>
                                        </svg>
                                    </div>
                                </div>
                                <!-- single item -->
                                <div class="item item-regular text">
                                    <p class="item__text">Follow us</p>
                                    <div class="item__image">
                                        <svg
                                            xmlns="http://www.w3.org/2000/svg"
                                            viewBox="0 0 92.3 93.1"
                                            fill="currentColor"
                                        >
                                            <g>
                                                <rect
                                                    x="45.7"
                                                    class="st0"
                                                    width="1"
                                                    height="93.1"
                                                />
                                                <rect
                                                    x="45.7"
                                                    y="0"
                                                    transform="matrix(0.8412 -0.5407 0.5407 0.8412 -17.8476 32.3497)"
                                                    class="st0"
                                                    width="1"
                                                    height="93.1"
                                                />
                                                <rect
                                                    x="45.7"
                                                    y="0"
                                                    transform="matrix(0.4155 -0.9096 0.9096 0.4155 -15.3764 69.2119)"
                                                    class="st0"
                                                    width="1"
                                                    height="93.1"
                                                />
                                                <rect
                                                    x="-0.4"
                                                    y="46.1"
                                                    transform="matrix(0.9898 -0.1425 0.1425 0.9898 -6.1646 7.0506)"
                                                    class="st0"
                                                    width="93.1"
                                                    height="1"
                                                />
                                                <rect
                                                    x="-0.4"
                                                    y="46.1"
                                                    transform="matrix(0.7556 -0.655 0.655 0.7556 -19.2157 41.618)"
                                                    class="st0"
                                                    width="93.1"
                                                    height="1"
                                                />
                                                <rect
                                                    x="-0.4"
                                                    y="46.1"
                                                    transform="matrix(0.2812 -0.9597 0.9597 0.2812 -11.5032 77.7858)"
                                                    class="st0"
                                                    width="93.1"
                                                    height="1"
                                                />
                                                <rect
                                                    x="45.7"
                                                    y="0"
                                                    transform="matrix(0.9595 -0.2817 0.2817 0.9595 -11.2479 14.8866)"
                                                    class="st0"
                                                    width="1"
                                                    height="93.1"
                                                />
                                                <rect
                                                    x="45.7"
                                                    y="0"
                                                    transform="matrix(0.6549 -0.7557 0.7557 0.6549 -19.2631 50.9572)"
                                                    class="st0"
                                                    width="1"
                                                    height="93.1"
                                                />
                                                <rect
                                                    x="45.7"
                                                    y="0"
                                                    transform="matrix(0.1423 -0.9898 0.9898 0.1423 -6.4999 85.629)"
                                                    class="st0"
                                                    width="1"
                                                    height="93.1"
                                                />
                                                <rect
                                                    x="-0.4"
                                                    y="46.1"
                                                    transform="matrix(0.9097 -0.4153 0.4153 0.9097 -15.1716 23.381)"
                                                    class="st0"
                                                    width="93.1"
                                                    height="1"
                                                />
                                                <rect
                                                    x="-0.4"
                                                    y="46.1"
                                                    transform="matrix(0.5411 -0.8409 0.8409 0.5411 -17.9774 60.1901)"
                                                    class="st0"
                                                    width="93.1"
                                                    height="1"
                                                />
                                            </g>
                                        </svg>
                                    </div>
                                </div>
                                <!-- single item -->
                                <div class="item item-regular text">
                                    <p class="item__text">Follow us</p>
                                    <div class="item__image">
                                        <svg
                                            xmlns="http://www.w3.org/2000/svg"
                                            viewBox="0 0 92.3 93.1"
                                            fill="currentColor"
                                        >
                                            <g>
                                                <rect
                                                    x="45.7"
                                                    class="st0"
                                                    width="1"
                                                    height="93.1"
                                                />
                                                <rect
                                                    x="45.7"
                                                    y="0"
                                                    transform="matrix(0.8412 -0.5407 0.5407 0.8412 -17.8476 32.3497)"
                                                    class="st0"
                                                    width="1"
                                                    height="93.1"
                                                />
                                                <rect
                                                    x="45.7"
                                                    y="0"
                                                    transform="matrix(0.4155 -0.9096 0.9096 0.4155 -15.3764 69.2119)"
                                                    class="st0"
                                                    width="1"
                                                    height="93.1"
                                                />
                                                <rect
                                                    x="-0.4"
                                                    y="46.1"
                                                    transform="matrix(0.9898 -0.1425 0.1425 0.9898 -6.1646 7.0506)"
                                                    class="st0"
                                                    width="93.1"
                                                    height="1"
                                                />
                                                <rect
                                                    x="-0.4"
                                                    y="46.1"
                                                    transform="matrix(0.7556 -0.655 0.655 0.7556 -19.2157 41.618)"
                                                    class="st0"
                                                    width="93.1"
                                                    height="1"
                                                />
                                                <rect
                                                    x="-0.4"
                                                    y="46.1"
                                                    transform="matrix(0.2812 -0.9597 0.9597 0.2812 -11.5032 77.7858)"
                                                    class="st0"
                                                    width="93.1"
                                                    height="1"
                                                />
                                                <rect
                                                    x="45.7"
                                                    y="0"
                                                    transform="matrix(0.9595 -0.2817 0.2817 0.9595 -11.2479 14.8866)"
                                                    class="st0"
                                                    width="1"
                                                    height="93.1"
                                                />
                                                <rect
                                                    x="45.7"
                                                    y="0"
                                                    transform="matrix(0.6549 -0.7557 0.7557 0.6549 -19.2631 50.9572)"
                                                    class="st0"
                                                    width="1"
                                                    height="93.1"
                                                />
                                                <rect
                                                    x="45.7"
                                                    y="0"
                                                    transform="matrix(0.1423 -0.9898 0.9898 0.1423 -6.4999 85.629)"
                                                    class="st0"
                                                    width="1"
                                                    height="93.1"
                                                />
                                                <rect
                                                    x="-0.4"
                                                    y="46.1"
                                                    transform="matrix(0.9097 -0.4153 0.4153 0.9097 -15.1716 23.381)"
                                                    class="st0"
                                                    width="93.1"
                                                    height="1"
                                                />
                                                <rect
                                                    x="-0.4"
                                                    y="46.1"
                                                    transform="matrix(0.5411 -0.8409 0.8409 0.5411 -17.9774 60.1901)"
                                                    class="st0"
                                                    width="93.1"
                                                    height="1"
                                                />
                                            </g>
                                        </svg>
                                    </div>
                                </div>
                                <!-- single item -->
                                <div class="item item-regular text">
                                    <p class="item__text">Follow us</p>
                                    <div class="item__image">
                                        <svg
                                            xmlns="http://www.w3.org/2000/svg"
                                            viewBox="0 0 92.3 93.1"
                                            fill="currentColor"
                                        >
                                            <g>
                                                <rect
                                                    x="45.7"
                                                    class="st0"
                                                    width="1"
                                                    height="93.1"
                                                />
                                                <rect
                                                    x="45.7"
                                                    y="0"
                                                    transform="matrix(0.8412 -0.5407 0.5407 0.8412 -17.8476 32.3497)"
                                                    class="st0"
                                                    width="1"
                                                    height="93.1"
                                                />
                                                <rect
                                                    x="45.7"
                                                    y="0"
                                                    transform="matrix(0.4155 -0.9096 0.9096 0.4155 -15.3764 69.2119)"
                                                    class="st0"
                                                    width="1"
                                                    height="93.1"
                                                />
                                                <rect
                                                    x="-0.4"
                                                    y="46.1"
                                                    transform="matrix(0.9898 -0.1425 0.1425 0.9898 -6.1646 7.0506)"
                                                    class="st0"
                                                    width="93.1"
                                                    height="1"
                                                />
                                                <rect
                                                    x="-0.4"
                                                    y="46.1"
                                                    transform="matrix(0.7556 -0.655 0.655 0.7556 -19.2157 41.618)"
                                                    class="st0"
                                                    width="93.1"
                                                    height="1"
                                                />
                                                <rect
                                                    x="-0.4"
                                                    y="46.1"
                                                    transform="matrix(0.2812 -0.9597 0.9597 0.2812 -11.5032 77.7858)"
                                                    class="st0"
                                                    width="93.1"
                                                    height="1"
                                                />
                                                <rect
                                                    x="45.7"
                                                    y="0"
                                                    transform="matrix(0.9595 -0.2817 0.2817 0.9595 -11.2479 14.8866)"
                                                    class="st0"
                                                    width="1"
                                                    height="93.1"
                                                />
                                                <rect
                                                    x="45.7"
                                                    y="0"
                                                    transform="matrix(0.6549 -0.7557 0.7557 0.6549 -19.2631 50.9572)"
                                                    class="st0"
                                                    width="1"
                                                    height="93.1"
                                                />
                                                <rect
                                                    x="45.7"
                                                    y="0"
                                                    transform="matrix(0.1423 -0.9898 0.9898 0.1423 -6.4999 85.629)"
                                                    class="st0"
                                                    width="1"
                                                    height="93.1"
                                                />
                                                <rect
                                                    x="-0.4"
                                                    y="46.1"
                                                    transform="matrix(0.9097 -0.4153 0.4153 0.9097 -15.1716 23.381)"
                                                    class="st0"
                                                    width="93.1"
                                                    height="1"
                                                />
                                                <rect
                                                    x="-0.4"
                                                    y="46.1"
                                                    transform="matrix(0.5411 -0.8409 0.8409 0.5411 -17.9774 60.1901)"
                                                    class="st0"
                                                    width="93.1"
                                                    height="1"
                                                />
                                            </g>
                                        </svg>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Content Block - Follow us Marquee with SVG Objects End -->
                </div>
            </div>
            <div class="row g-0 justify-content-center">
                <div class="col-12 col-xl-8">
                    <!-- Content Block - Socials Start -->
                    <div class="content__block">
                        <!-- Section Subtitle Start -->
                        <div class="block__subtitle">
                            <p class="tagline-chapter animate-in-up">Social media</p>
                        </div>
                        <!-- Section Subtitle End -->

                        <!-- Socials Lines Start -->
                        <ul class="socials-lines d-flex flex-column">
                            <!-- socials lines single item -->
                            <li class="socials-lines__item">
                                <a
                                    class="socials-lines__link d-flex align-items-center justify-content-between"
                                    href="https://www.instagram.com/"
                                    target="_blank"
                                >
                                    <h4 class="animate-in-up">Instagram</h4>
                                    <div class="socials-lines__icon d-flex animate-in-up">
                                        <i class="ph ph-arrow-up-right"></i>
                                    </div>
                                </a>
                                <div class="socials-lines__divider animate-in-up"></div>
                            </li>
                            <!-- socials lines single item -->
                            <li class="socials-lines__item">
                                <a
                                    class="socials-lines__link d-flex align-items-center justify-content-between"
                                    href="https://www.pinterest.com/"
                                    target="_blank"
                                >
                                    <h4 class="animate-in-up">Pinterest</h4>
                                    <div class="socials-lines__icon d-flex animate-in-up">
                                        <i class="ph ph-arrow-up-right"></i>
                                    </div>
                                </a>
                                <div class="socials-lines__divider animate-in-up"></div>
                            </li>
                            <!-- socials lines single item -->
                            <li class="socials-lines__item">
                                <a
                                    class="socials-lines__link d-flex align-items-center justify-content-between"
                                    href="https://www.linkedin.com/"
                                    target="_blank"
                                >
                                    <h4 class="animate-in-up">Linkedin</h4>
                                    <div class="socials-lines__icon d-flex animate-in-up">
                                        <i class="ph ph-arrow-up-right"></i>
                                    </div>
                                </a>
                                <div class="socials-lines__divider animate-in-up"></div>
                            </li>
                            <!-- socials lines single item -->
                            <li class="socials-lines__item">
                                <a
                                    class="socials-lines__link d-flex align-items-center justify-content-between"
                                    href="https://www.youtube.com/"
                                    target="_blank"
                                >
                                    <h4 class="animate-in-up">Youtube</h4>
                                    <div class="socials-lines__icon d-flex animate-in-up">
                                        <i class="ph ph-arrow-up-right"></i>
                                    </div>
                                </a>
                                <div class="socials-lines__divider animate-in-up"></div>
                            </li>
                        </ul>
                        <!-- Socials Lines End -->
                    </div>
                    <!-- Content Block - Socials End -->
                </div>
            </div>
        </div>
        <!-- Inner Section Off-canvas Content (Fullwidth Social Media Marquee & Lines) Start -->
    </div>
</section>
<!-- Inner Section - Resume - End -->
