{{-- ================================================ --}}
{{-- HERO SECTION --}}
{{-- ================================================ --}}
<section id="home" class="main home">
    <div class="main__intro">
        <div class="intro__background intro-bg-01">
            <div class="intro-bg-01__01" data-speed="0.6">
{{--                <img src="{{ asset('img/backgrounds/1200x1200_bg01.webp') }}" alt="Background Objects"/>--}}
                <img
                    src="{{ $lqip[lqipKey('img/backgrounds/1200x1200_bg01.webp')] ?? asset('img/backgrounds/1200x1200_bg01.webp') }}"
                    data-src="{{ asset('img/backgrounds/1200x1200_bg01.webp') }}"
                    alt="Background Objects"
                    class="lazyload"
                />
                <div class="intro-bg__shadow"></div>
            </div>
            <div class="intro-bg-01__02" data-speed="0.8">
{{--                <img src="{{ asset('img/backgrounds/1200x1200_bg02.webp') }}" alt="Background Objects"/>--}}
                <img
                    src="{{ $lqip['img_backgrounds_1200x1200_bg02'] ?? asset('img/backgrounds/1200x1200_bg02.webp')}}"
                    data-src="{{ asset('img/backgrounds/1200x1200_bg02.webp') }}"
                    alt="Background"
                    class="lazyload"
                />
                <div class="intro-bg__shadow"></div>
            </div>
        </div>
        <div class="container-fluid p-0 fullheight-desktop">
            <div class="row g-0 fullheight-desktop align-items-xl-stretch">
                <div class="col-12 col-xl-2"></div>
                <div class="col-12 col-xl-8 fullheight-desktop">
                    <div id="headline"
                         class="headline headline-95-desktop d-flex align-items-start flex-column loading-wrap">
                        <p class="headline__subtitle space-top animated-type loading__item">
                            {{-- STATUS banner — edit in hero.md (first line before ---) --}}
                            <span class="text-uppercase"
                                  style="color: #e6e117; font-weight: 700; letter-spacing: 1px; font-family: monospace;">
                                    {{ $heroStatus }}
                                </span>
                            <br/>
                            {{-- Typed strings — pulled from hero.md (lines before first ---) --}}
                            <span id="typed-strings">
                                    @foreach($heroTyped as $line)
                                    <b>{{ $line }}</b>
                                @endforeach
                                </span>
                            <span id="typed"></span>
                        </p>
                        {{-- Main headline — pulled from hero.md (line after first ---) --}}
                        <h1 class="headline__title loading__item">{{ $heroHeadline }}</h1>

                        <div class="action__btn">
                            <div class="btn-group about-descr__btnholder animate-in-up">
                                <a class="btn btn-default hover-default  start-engagement-btn" href="#!">
                                    <em></em>
                                    <span class="btn-caption">{{ $heroCta }}</span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-xl-2"></div>
            </div>
        </div>
    </div>
    <div class="main__media media-grid-bottom">
        <div class="container-fluid p-0">
            <div class="row g-0">
                <div class="col-12 col-xl-2"></div>
                <div class="col-12 col-xl-2"></div>
                <div class="media__fullwidth">
                    <div class="items items--gsap">
                        <div class="items__container">
                            <div class="item icon">
                                <svg xmlns="http://www.w3.org/2000/svg" id="Layer_1" data-name="Layer 1"
                                     viewBox="0 0 24 24" fill="currentColor">
                                    <path
                                        d="m2.5,0C1.121,0,0,1.121,0,2.5v11.207l2.5,2.5,2.5-2.5V2.5c0-1.379-1.121-2.5-2.5-2.5Zm1.5,13.293l-1.5,1.5-1.5-1.5V2.5c0-.827.673-1.5,1.5-1.5s1.5.673,1.5,1.5v10.793Zm13.5.707h-8c-1.379,0-2.5,1.121-2.5,2.5v7.5h13v-7.5c0-1.379-1.121-2.5-2.5-2.5Zm-8,1h8c.483,0,.909.234,1.184.59l-3.864,3.864c-.705.705-1.934.705-2.639,0l-3.864-3.864c.275-.356.701-.59,1.184-.59Zm-1.5,8v-6.313l3.474,3.473c.542.542,1.261.84,2.026.84s1.484-.298,2.026-.84l3.474-3.473v6.313h-11ZM17.812,0h-8.628c-1.204,0-2.185.98-2.185,2.185v10.577c.307-.206.647-.359,1-.485V2.185c0-.653.531-1.185,1.185-1.185h7.815v6h6v13h-1v1h2V6.188L17.812,0Zm.188,1.602l4.398,4.398h-4.398V1.602Z"/>
                                </svg>
                            </div>
                            <div class="item image image-1">
                                <img src="{{ asset('img/marquee/branding.webp') }}" alt="branding"/>
                            </div>
                            <div class="item icon">
                                <svg xmlns="http://www.w3.org/2000/svg" id="Layer_1" data-name="Layer 1"
                                     viewBox="0 0 24 24" width="24" height="24" fill="currentColor">
                                    <path
                                        d="M21.5,2H2.5C1.122,2,0,3.121,0,4.5V22H24V4.5c0-1.379-1.122-2.5-2.5-2.5ZM1,4.5c0-.827,.673-1.5,1.5-1.5h5.5V21H1V4.5ZM23,21H9V3h12.5c.827,0,1.5,.673,1.5,1.5V21ZM3,10h3v1H3v-1Zm0,4h3v1H3v-1ZM6,6v1H3v-1h3Z"/>
                                </svg>
                            </div>
                            <div class="item image image-2">
                                <img src="{{ asset('img/marquee/web_design.webp') }}" alt="web design"/>
                            </div>
                            <div class="item icon">
                                <svg id="Layer_1" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"
                                     data-name="Layer 1" fill="currentColor">
                                    <path
                                        d="m7.143 15.8 2.72 2.855-.725.689-2.711-2.847c-.571-.572-.571-1.517.009-2.097l2.708-2.752.713.701-2.711 2.755c-.193.193-.193.504-.003.694zm7.614-4.156-.701.713 2.802 2.752c.19.19.19.501-.003.694l-2.805 2.847.713.701 2.802-2.844c.58-.581.58-1.525-.003-2.108zm9.243-8.144v19.5h-24v-19.5c0-1.379 1.121-2.5 2.5-2.5h19c1.379 0 2.5 1.121 2.5 2.5zm-23 0v4.5h22v-4.5c0-.827-.673-1.5-1.5-1.5h-19c-.827 0-1.5.673-1.5 1.5zm22 18.5v-13h-22v13zm-19-16c.552 0 1-.448 1-1s-.448-1-1-1-1 .448-1 1 .448 1 1 1zm3 0c.552 0 1-.448 1-1s-.448-1-1-1-1 .448-1 1 .448 1 1 1zm3 0c.552 0 1-.448 1-1s-.448-1-1-1-1 .448-1 1 .448 1 1 1z"/>
                                </svg>
                            </div>
                            <div class="item image image-3">
                                <img src="{{ asset('img/marquee/develop.webp') }}" alt="Image"/>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
