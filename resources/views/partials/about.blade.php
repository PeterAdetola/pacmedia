{{-- ================================================ --}}
{{-- ABOUT SECTION --}}
{{-- ================================================ --}}
<section id="about" class="inner inner-grid-bottom about">
    <div class="inner__wrapper">
        <div class="container-fluid p-0">
            <div class="row g-0">
                <div class="col-12 col-xl-2">
                    <div class="inner__name">
                        <div class="content__block name-block">
                                <span class="section-name icon-right animate-in-up">
                                    <span class="section-name-caption">The Squad</span>
                                    <i class="ph ph-arrow-down-right"></i>
                                </span>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-xl-8">
                    <div class="inner__content">
                        <div class="content__block section-text-title">
                            <div class="block__descr">
                                <h2 class="reveal-type animate-in-up">
                                    Forging Identity.<br/>Engineering Digital Infrastructure
                                </h2>
                            </div>
                        </div>
                        <div class="content__block grid-block">
                            <div class="container-fluid p-0">
                                <div class="row g-0 justify-content-between">
                                    <div class="col-12 col-md-8 col-lg-7 col-xxl-9 grid-item about-descr pre-grid">
                                        {{-- About body text — pulled from about.md (content before first ---) --}}
                                        <div class="about-descr__text type-basic-160lh">
                                            {!! $aboutBody !!}
                                        </div>
                                    </div>
                                    <div
                                        class="col-12 col-md-4 col-xxl-3 grid-item about-info pre-grid d-none d-md-block">
                                        <div class="about-info__item animate-in-up">
                                            <h6>Direct Contact</h6>
                                        </div>
                                        <div class="about-info__item animate-in-up">
                                            <h6>
                                                <a class="link-inline text-link"
                                                   href="mailto:reach@thepacmedia.com?subject=Briefing%20Request">reach@thepacmedia.com</a>
                                            </h6>
                                        </div>
                                        <div class="about-info__item animate-in-up">
                                            <h6>
                                                <a class="link-inline text-link  start-engagement-btn" href="#!">Command Center</a>
                                            </h6>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="content__block grid-block pre-offcanvas-grid-block">
                            <div class="content__block">
                                <div class="container-fluid p-0">
                                    <div class="row g-0">
                                        <div class="col-12">
                                            <div class="divider divider-video">
                                                <video
                                                    class="bg-video lazyload-video"
                                                    autoplay loop muted playsinline
                                                    preload="none"
                                                    poster="{{ $lqip[lqipKey('img/video-poster.jpg')] ?? asset('img/video-poster.jpg') }}"
                                                    data-poster="{{ asset('img/video-poster.webp') }}"
                                                >
                                                    <source data-src="{{ asset('video/intro.mp4') }}" type="video/mp4"/>
                                                    Your browser does not support the video tag.
                                                </video>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="content__block large-text-block" style="margin-bottom: 0;">
                                <div class="container-fluid p-0">
                                    <div class="row g-0">
                                        <div class="col-12">
                                            {{-- Blockquote — pulled from about.md (content between --- separators) --}}
                                            <blockquote class="reveal-type animate-in-up">
                                                {{ $aboutQuote }}
                                            </blockquote>
                                            {{-- Attribution paragraph — pulled from about.md (content after second ---) --}}
                                            <p class="about-descr__attribution" style="margin-top: 1em;">{{ $aboutAttribution }}</p>
                                            <p style="margin-top: 1em; font-style: italic;">— The Pacmedia</p>
                                        </div>
                                    </div>

                                    <div class="block__subtitle grid-block-subtitle" style="margin-top: 3em;">
                                        <p class="tagline-chapter animate-in-up">In the Squad</p>
                                    </div>
                                    <div class="tools-cards d-flex justify-content-start flex-wrap">
                                        <div class="tools-cards__item d-flex grid-item animate-card-4">
                                            <div class="tools-cards__card">
                                                <div class="icon-container">
                                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"
                                                         width="64" height="64" fill="currentColor"
                                                         preserveAspectRatio="xMidYMid meet">
                                                        <g transform="translate(0,512) scale(0.1,-0.1)"
                                                           stroke="none">
                                                            <path
                                                                d="M2418 4708 c-9 -7 -59 -79 -111 -159 l-95 -146 -63 -12 c-135 -27 -267 -103 -348 -200 -41 -49 -111 -171 -111 -194 0 -7 -120 -131 -266 -277 -170 -170 -273 -279 -285 -305 -24 -53 -25 -147 0 -200 23 -52 88 -108 195 -168 66 -38 98 -50 143 -54 72 -7 96 3 265 103 124 74 127 75 156 60 50 -26 154 -40 211 -29 37 7 51 7 51 -1 0 -6 -11 -53 -25 -105 -34 -127 -110 -316 -245 -611 -264 -577 -360 -891 -387 -1269 l-6 -91 -56 0 c-98 -1 -199 -19 -256 -46 -77 -36 -149 -109 -188 -191 -30 -64 -32 -75 -35 -208 -4 -132 -3 -142 18 -167 l21 -28 1555 0 1554 0 21 21 c20 20 21 30 17 172 -3 143 -5 156 -31 209 -84 172 -216 237 -479 238 l-98 0 0 103 0 102 151 150 c83 83 155 160 160 173 12 30 -485 2163 -530 2277 -58 144 -161 278 -286 372 -33 25 -112 71 -175 103 l-115 58 -114 156 c-63 87 -122 161 -132 167 -25 13 -62 11 -81 -3z m132 -323 c40 -55 83 -111 96 -125 23 -26 180 -361 208 -446 8 -27 104 -476 211 -999 108 -522 201 -963 207 -978 12 -32 36 -47 73 -47 33 0 75 41 75 74 0 40 -396 1946 -418 2011 -12 33 -41 104 -67 159 l-45 98 31 -20 c87 -55 196 -187 246 -300 15 -35 121 -467 273 -1117 l248 -1060 -154 -156 -154 -157 0 -136 0 -136 -861 0 -862 0 7 98 c14 188 62 414 132 622 51 149 105 278 248 594 193 425 259 616 287 829 12 93 12 99 -8 125 -28 38 -79 41 -130 8 -82 -53 -167 -57 -255 -11 -26 14 -59 25 -74 25 -15 0 -92 -39 -184 -95 -87 -52 -169 -95 -182 -95 -27 0 -175 82 -200 112 -10 11 -18 36 -18 56 0 34 17 53 274 312 151 151 277 286 281 300 26 88 100 185 183 240 55 37 158 70 216 70 23 0 51 7 63 15 11 8 54 66 94 129 41 64 77 112 80 108 3 -4 39 -52 79 -107z m1285 -3515 c50 -16 114 -75 136 -125 12 -26 19 -64 19 -107 l0 -68 -1435 0 -1435 0 0 63 c1 126 78 226 190 245 23 4 592 6 1264 6 950 -1 1231 -4 1261 -14z"/>
                                                        </g>
                                                    </svg>
                                                </div>

                                                <h6 class="tools-cards__caption tagline-tool animate-in-up">
                                                    Strategists
                                                </h6>
                                            </div>
                                        </div>
                                        <div class="tools-cards__item d-flex grid-item animate-card-4">
                                            <div class="tools-cards__card">
                                                <div class="icon-container">
                                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"
                                                         width="64" height="64" fill="currentColor"
                                                         preserveAspectRatio="xMidYMid meet">
                                                        <g transform="translate(0,512) scale(0.1,-0.1)"
                                                           stroke="none">
                                                            <path
                                                                d="M2080 5114 c-340 -43 -630 -187 -853 -424 -141 -150 -238 -312 -302 -503 -61 -182 -66 -232 -72 -658 -6 -419 -1 -471 51 -549 47 -71 152 -150 200 -150 16 0 18 -8 41 -150 47 -288 138 -420 415 -612 83 -56 150 -108 150 -115 0 -7 -169 -68 -427 -152 -444 -146 -544 -186 -678 -276 -277 -185 -487 -501 -544 -820 -28 -155 -62 -444 -57 -483 11 -80 66 -156 146 -198 34 -18 112 -19 2375 -19 l2340 0 56 28 c67 33 142 109 171 175 26 58 37 220 19 275 -15 45 -68 92 -121 108 l-40 12 0 997 c0 1104 3 1048 -65 1128 -19 22 -56 50 -82 63 l-48 24 -718 5 c-715 5 -718 5 -666 24 73 25 158 112 187 189 21 56 22 72 22 455 0 446 -7 514 -65 690 -19 57 -58 149 -87 204 -188 366 -545 634 -951 713 -80 16 -328 28 -397 19z m313 -179 c191 -29 379 -106 532 -219 199 -147 346 -348 425 -584 47 -142 60 -241 60 -469 0 -191 -1 -205 -17 -198 -10 4 -30 11 -45 17 -19 7 -28 19 -32 43 -11 59 -74 171 -120 213 -61 56 -111 79 -210 97 -226 39 -391 93 -575 187 -184 95 -196 95 -386 0 -197 -99 -388 -161 -570 -187 -82 -11 -151 -43 -208 -95 -59 -54 -113 -144 -123 -207 -6 -37 -11 -43 -48 -57 -23 -9 -45 -16 -49 -16 -11 0 -8 269 3 395 27 289 144 539 345 740 272 272 644 396 1018 340z m-28 -1080 c163 -81 327 -136 519 -174 93 -18 159 -37 175 -49 46 -33 81 -104 96 -188 16 -91 30 -108 101 -118 100 -13 160 -85 152 -182 -7 -87 -55 -137 -147 -154 -73 -14 -97 -38 -107 -108 l-9 -57 -450 -5 c-496 -6 -483 -4 -560 -71 -21 -19 -49 -56 -61 -84 -23 -49 -24 -56 -24 -359 l0 -308 -26 6 c-37 10 -191 87 -261 132 -116 73 -262 185 -305 233 -89 99 -119 179 -159 425 -26 162 -39 184 -109 193 -57 7 -91 25 -124 63 -73 88 -45 214 58 261 23 10 53 19 68 19 14 0 34 3 43 6 24 10 45 58 45 106 0 54 38 136 78 170 40 34 90 50 232 77 159 30 333 90 480 165 69 35 134 64 145 65 10 1 78 -28 150 -64z m2360 -1220 c21 -8 39 -25 45 -40 6 -17 10 -383 10 -1011 l0 -984 -1280 0 -1280 0 0 994 c0 981 0 994 20 1019 11 14 30 28 43 30 12 2 559 5 1215 6 1022 1 1198 -1 1227 -14z m-2759 -794 l79 -29 3 -111 c2 -73 -1 -111 -8 -111 -22 0 -101 84 -125 134 -22 45 -45 146 -33 146 2 0 40 -13 84 -29z m-231 -130 c38 -116 154 -247 259 -292 l56 -24 0 -397 0 -397 -36 -7 c-41 -8 -98 -53 -120 -95 -28 -54 -17 -221 21 -311 7 -17 -37 -18 -840 -18 l-847 0 -30 30 c-35 35 -35 13 8 316 27 192 58 310 109 419 109 228 309 429 533 532 67 31 827 289 859 292 6 1 19 -21 28 -48z m3215 -1340 c0 -71 -12 -106 -48 -145 -56 -59 24 -56 -1404 -56 -1311 0 -1312 0 -1355 21 -63 30 -93 86 -93 172 l0 67 1450 0 1450 0 0 -59z"/>
                                                            <path
                                                                d="M4047 2375 c-88 -33 -760 -575 -827 -667 -17 -24 -34 -65 -41 -99 -11 -57 -13 -59 -44 -59 -17 0 -60 -14 -94 -31 -98 -49 -147 -127 -181 -291 -11 -51 -32 -121 -46 -156 -32 -75 -28 -121 13 -164 31 -33 67 -44 175 -52 154 -13 308 36 409 131 57 53 84 100 99 171 l11 48 57 12 c99 21 144 66 456 457 203 253 291 373 305 414 59 178 -116 350 -292 286z m113 -175 c11 -11 20 -29 20 -39 0 -33 -367 -505 -549 -706 -87 -96 -110 -97 -198 -12 -36 34 -70 71 -75 82 -16 29 -12 74 9 97 48 54 592 494 707 572 47 31 60 32 86 6z m-894 -839 c60 -37 95 -123 74 -185 -30 -92 -223 -180 -333 -152 l-24 6 18 54 c10 30 21 77 24 103 10 69 51 156 83 176 37 23 119 22 158 -2z"/>
                                                        </g>
                                                    </svg>
                                                </div>
                                                <h6 class="tools-cards__caption tagline-tool animate-in-up">
                                                    Designers</h6>
                                            </div>
                                        </div>
                                        <div class="tools-cards__item d-flex grid-item animate-card-4">
                                            <div class="tools-cards__card">
                                                <div class="icon-container">
                                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 2560 2560"
                                                         width="64" height="64" fill="currentColor"
                                                         preserveAspectRatio="xMidYMid meet">
                                                        <g transform="translate(0,2560) scale(1,-1)">
                                                            <path
                                                                d="M714 2491 c-44 -20 -91 -73 -103 -116 -5 -20 -17 -31 -45 -40 -49 -17 -93 -59 -117 -110 -15 -33 -19 -65 -19 -185 0 -126 -3 -151 -20 -185 -41 -80 -13 -175 63 -219 39 -23 46 -32 51 -69 12 -76 61 -165 131 -233 83 -81 84 -101 16 -168 -47 -46 -53 -49 -197 -87 -239 -63 -252 -68 -290 -102 -21 -17 -43 -45 -50 -62 -14 -35 -134 -640 -134 -679 0 -63 47 -134 112 -167 36 -18 71 -19 859 -19 818 0 823 0 867 21 84 41 119 128 98 241 l-13 68 39 0 c65 0 95 22 115 86 10 33 27 62 39 71 20 13 27 12 73 -11 79 -41 102 -36 176 35 91 87 93 96 44 217 -18 44 -6 61 62 84 79 26 89 43 89 149 0 125 -9 140 -104 172 -53 18 -64 37 -47 79 49 121 47 130 -44 217 -74 71 -97 76 -176 35 -46 -23 -53 -24 -73 -11 -12 9 -29 38 -39 71 -24 76 -50 89 -167 84 -105 -4 -122 -15 -147 -96 -23 -72 -46 -81 -113 -47 -80 40 -96 36 -178 -49 -82 -84 -86 -99 -47 -176 34 -68 25 -90 -49 -113 -30 -10 -58 -23 -62 -28 -4 -7 -24 7 -50 32 -55 54 -57 84 -9 119 75 53 155 185 170 277 5 32 12 42 30 47 32 8 82 68 94 113 11 40 1 107 -18 126 -6 6 -11 49 -11 97 -1 237 -68 386 -219 482 -89 56 -152 68 -360 68 -160 0 -192 -3 -227 -19z m498 -93 c151 -70 228 -206 228 -400 0 -54 -2 -58 -24 -58 -20 0 -24 6 -30 42 -9 57 -38 100 -83 125 -31 17 -63 22 -180 27 -78 4 -182 14 -230 22 -159 28 -194 29 -226 4 -35 -28 -64 -84 -80 -158 -13 -54 -15 -57 -45 -60 l-32 -3 0 118 c0 158 20 193 119 209 34 5 42 11 47 33 15 69 28 94 58 112 28 18 47 20 226 17 188 -3 197 -4 252 -30z m-324 -322 c52 -8 156 -18 232 -22 171 -8 180 -15 189 -121 l6 -68 56 -3 c45 -2 61 -8 79 -27 46 -49 20 -129 -45 -141 -41 -7 -50 -21 -59 -89 -9 -76 -58 -166 -121 -224 -75 -68 -145 -94 -255 -95 -75 -1 -93 3 -152 31 -119 56 -194 153 -219 283 -13 73 -23 90 -51 90 -31 0 -78 54 -78 90 0 51 38 80 104 80 64 0 67 3 86 100 6 35 21 82 32 103 22 45 6 44 196 13z m1124 -556 c20 -62 42 -85 99 -102 36 -10 45 -9 99 17 l60 29 45 -44 c25 -24 45 -49 45 -56 0 -6 -11 -36 -25 -66 -24 -53 -24 -56 -9 -101 19 -55 30 -65 97 -87 l52 -17 0 -73 0 -73 -54 -18 c-69 -24 -76 -31 -95 -86 -15 -45 -15 -48 9 -101 14 -30 25 -60 25 -66 0 -7 -20 -31 -44 -56 l-45 -43 -62 28 c-55 24 -66 26 -99 16 -56 -16 -78 -39 -98 -101 l-19 -55 -44 0 -43 0 -28 135 c-15 74 -27 141 -28 148 0 8 20 12 68 12 112 1 189 47 240 145 66 129 7 293 -128 354 -59 27 -159 28 -216 2 -76 -35 -138 -115 -151 -197 -3 -20 -11 -33 -17 -31 -6 2 -62 17 -123 33 -62 15 -113 32 -113 35 0 4 12 10 28 14 36 9 60 32 78 74 19 47 18 64 -12 123 l-26 51 51 50 50 51 53 -27 c63 -32 77 -33 127 -8 47 25 54 34 76 99 l17 53 71 -3 70 -3 19 -55z m-1103 -312 c62 -11 161 -3 216 18 16 7 17 2 13 -48 -5 -66 -34 -110 -88 -138 -117 -60 -250 30 -250 169 0 20 4 22 23 17 12 -4 51 -12 86 -18z m1101 -28 c126 -64 126 -256 0 -320 -47 -24 -136 -27 -166 -5 -12 8 -24 27 -27 43 -3 16 -22 46 -42 67 -50 54 -46 116 13 179 54 58 149 73 222 36z m-1251 -115 c89 -169 344 -164 433 9 l19 38 22 -20 c44 -40 76 -52 262 -102 105 -28 200 -57 212 -65 30 -20 37 -46 102 -382 63 -326 64 -338 11 -386 -30 -26 -33 -27 -155 -27 l-125 0 5 37 c14 95 75 621 75 645 0 15 -11 40 -24 55 l-24 28 -596 0 -596 0 -27 -27 c-34 -34 -34 -26 12 -405 19 -161 35 -302 35 -313 0 -19 -7 -20 -117 -20 -134 0 -169 13 -193 70 -13 30 -8 61 49 354 34 177 69 331 77 344 21 32 56 46 253 98 193 50 196 51 230 88 14 14 27 26 30 26 3 0 17 -20 30 -45z m781 -259 c0 -17 -67 -584 -76 -638 l-6 -38 -486 0 -487 0 -41 338 c-22 185 -39 340 -37 345 2 4 258 7 569 7 481 0 564 -2 564 -14z"/>
                                                            <path
                                                                d="M914 584 c-62 -31 -88 -127 -47 -182 58 -79 175 -74 219 9 56 110 -61 228 -172 173z m94 -76 c31 -31 -6 -96 -47 -83 -12 3 -26 15 -32 26 -23 43 44 92 79 57z"/>
                                                        </g>
                                                    </svg>
                                                </div>
                                                <h6 class="tools-cards__caption tagline-tool animate-in-up">
                                                    Developers</h6>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="btn-group about-descr__btnholder animate-in-up">
                                        <a class="btn btn-default hover-default start-engagement-btn" href="#!">
                                            <em></em>
                                            <span class="btn-caption">Start Engagement →</span>
                                        </a>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-xl-2"></div>
        </div>
    </div>
</section>
