{{-- ================================================ --}}
{{-- CONTACT SECTION --}}
{{-- ================================================ --}}
<section id="contact" class="inner contact inner-grid-bottom no-padding-bottom theme-dark">
    <div class="inner__wrapper">
        <div class="container-fluid p-0">
            <div class="row g-0">
                <div class="col-12 col-xl-2">
                    <div class="inner__name">
                        <div class="content__block name-block">
                                <span class="section-name icon-right animate-in-up">
                                    <span class="section-name-caption">Secure Channel</span>
                                    <i class="ph ph-arrow-down-right"></i>
                                </span>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-xl-8">
                    <div class="inner__content">
                        <div class="content__block section-form-title">
                            <div class="block__descr">
                                <h2 class="reveal-type animate-in-up">Start Here</h2>
                                {{-- Contact intro — pulled from contact.md --}}
                                <div class="h2__text text-twothirds type-basic-160lh animate-in-up">
                                    {!! $contactIntro !!}
                                </div>
                            </div>
                        </div>
                        <div class="content__block grid-block">
                            <div class="form-container">
                                <div class="form__reply centered text-center">
                                    <i class="ph-thin ph-smiley reply__icon"></i>
                                    <p class="reply__title">Message Received</p>
                                    <span class="reply__text">Transmission successful. Stand by for response.</span>
                                </div>
                                <form class="form contact-form" id="contact-form">
                                    <input type="hidden" name="project_name" value="Pacmedia Briefing Request"/>
                                    <input type="hidden" name="admin_email" value="reach@thepacmedia.com"/>
                                    <input type="hidden" name="form_subject" value="New Let's talk Request"/>
                                    <div class="container-fluid p-0">
                                        <div class="row gx-0">
                                            <div class="col-12 col-md-6 form__item animate-in-up">
                                                <input type="text" name="Name" placeholder="Your Name*" required/>
                                            </div>
                                            <div class="col-12 col-md-6 form__item animate-in-up">
                                                <input type="text" name="Company" placeholder="Company / Brand"/>
                                            </div>
                                            <div class="col-12 col-md-6 form__item animate-in-up">
                                                <input type="email" name="E-mail" placeholder="Email*" required/>
                                            </div>
                                            <div class="col-12 col-md-6 form__item animate-in-up">
                                                <input type="tel" name="location"
                                                       placeholder="Location"/>
                                            </div>
                                            <p class="h2__text text-twothirds type-basic-160lh animate-in-up">
                                                Select your operation
                                            </p>
                                            <div class="demo-section form__item animate-in-up">
                                                <label class="checkbox-container link-small-160lh">
                                                    <input type="checkbox" name="Service_Strategy">
                                                    <span class="custom-checkbox"></span>
                                                    <span class="checkbox-label">Visual Brand Architecture</span>
                                                </label>
                                                <label class="checkbox-container">
                                                    <input type="checkbox" name="Service_Automation">
                                                    <span class="custom-checkbox"></span>
                                                    <span class="checkbox-label">Web Design & Development</span>
                                                </label>
                                                <label class="checkbox-container">
                                                    <input type="checkbox" name="Service_Web">
                                                    <span class="custom-checkbox"></span>
                                                    <span class="checkbox-label">Other</span>
                                                </label>
                                            </div>
                                            <div class="col-12 form__item animate-in-up">
                                                  <textarea
                                                      name="Message"
                                                      placeholder="Tell us about your project*"
                                                      required
                                                  ></textarea>
                                            </div>
                                            <div class="btn-group about-descr__btnholder form__item animate-in-up">
                                                <button class="btn btn-default hover-default" type="submit">
                                                    <em></em>
                                                    <span class="btn-caption">Deploy Request →</span>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>

                        <footer class="footer">
                            <div class="container-fluid p-0">
                                <div class="row g-0">
                                    <div class="col-12">
                                        <div class="content__block pre-grid-items">
                                            <div
                                                class="footer__link d-flex flex-column flex-md-row justify-content-md-between align-items-md-center">
                                                <div class="footer__text reveal-type animate-in-up">
                                                    Skip the form?<br/>Book a Call!
                                                </div>
                                                <div class="footer__btn animate-in-up">
                                                    <a href="mailto:reach@thepacmedia.com?subject=Briefing%20Request"
                                                       class="btn btn-circle-icon hover-circle">
                                                        <em></em>
                                                        <i class="ph-light ph-arrow-right"></i>
                                                    </a>
                                                </div>
                                            </div>
                                            <div class="footer__divider animate-in-up"></div>
                                        </div>
                                        <div class="content__block grid-block">
                                            <div class="container-fluid p-0 contact-data">
                                                <div class="row g-0">
                                                    <div class="col-12 col-lg-3 contact-data__item grid-item">
                                                        <a href="#home" class="footer-logo logo-text animate-in-up">
                                                                <span
                                                                    style="display: inline-block; width: 8em; padding-left: 0;">
                                                                    <svg xmlns="http://www.w3.org/2000/svg"
                                                                         viewBox="0 0 263.2 43.7"
                                                                         style="width: 100%; height: auto; display: block;"
                                                                         class="logo-svg-alt" aria-label="Text Logo">
                                                                        <style>
                                                                            .logo-svg-alt .logo-fill {
                                                                                fill: currentColor;
                                                                            }

                                                                            .logo-svg-alt .logo-dot {
                                                                                fill: #e6e117;
                                                                            }
                                                                        </style>
                                                                        <g>
                                                                            <path class="logo-fill"
                                                                                  d="M0 42.9v-40h13.8c2.2 0 4.1.5 5.8 1.6 1.7 1.1 3.1 2.5 4.2 4.3 1 1.8 1.6 3.8 1.6 6s-.5 4.2-1.6 6-2.5 3.2-4.2 4.3c-1.8 1.1-3.7 1.6-5.8 1.6H6v16.2H0zm6-22.1h7.2c1.1 0 2.2-.3 3.1-.9s1.7-1.3 2.3-2.3c.6-1 .8-2 .8-3.2s-.3-2.3-.8-3.2c-.6-1-1.3-1.7-2.3-2.3-.9-.6-2-.8-3.1-.8H6v12.7zm44.8-6.5h5.9v28.6h-6l-.2-4.1c-.8 1.5-2 2.6-3.4 3.5S44 43.6 42 43.6c-2.1 0-4.1-.4-5.9-1.2-1.8-.8-3.5-1.9-4.9-3.3s-2.5-3-3.3-4.9c-.8-1.8-1.2-3.8-1.2-5.9 0-2 .4-4 1.1-5.8.8-1.8 1.8-3.4 3.2-4.7 1.4-1.4 2.9-2.4 4.7-3.2 1.8-.8 3.7-1.2 5.7-1.2 2.1 0 3.9.5 5.5 1.4s2.9 2.1 4 3.6l-.1-4.1zM42 37.9c1.7 0 3.1-.4 4.4-1.2 1.3-.8 2.2-1.9 2.9-3.4.7-1.4 1-3 1-4.7s-.4-3.3-1.1-4.7-1.7-2.5-2.9-3.4c-1.2-.8-2.7-1.2-4.4-1.2-1.7 0-3.2.4-4.5 1.3-1.4.8-2.5 2-3.3 3.4s-1.2 3-1.2 4.7.4 3.3 1.2 4.7c.8 1.4 1.9 2.5 3.3 3.3 1.5.8 3 1.2 4.6 1.2zm38.6-3.1 5.3 2.9C84.6 39.5 83 41 81 42c-2 1.1-4.1 1.6-6.5 1.6-2.6 0-5-.7-7.2-2-2.2-1.4-3.9-3.2-5.2-5.4-1.3-2.3-1.9-4.8-1.9-7.6 0-2.1.4-4 1.1-5.9.7-1.8 1.8-3.4 3.1-4.8s2.8-2.5 4.6-3.2c1.7-.8 3.6-1.2 5.5-1.2 2.3 0 4.5.5 6.5 1.6s3.6 2.5 4.9 4.4l-5.3 2.9c-.8-1-1.7-1.7-2.8-2.2s-2.2-.8-3.3-.8c-1.6 0-3 .4-4.2 1.3-1.3.8-2.3 2-3 3.3-.7 1.4-1.1 2.9-1.1 4.5s.4 3.1 1.1 4.5c.7 1.4 1.7 2.5 3 3.3 1.3.8 2.7 1.3 4.2 1.3 1.2 0 2.3-.3 3.4-.8 1-.5 1.9-1.2 2.7-2zM91 42.9V14.3h5.9v3c1-1.2 2.2-2.1 3.6-2.8s3-1 4.7-1c2 0 3.9.5 5.6 1.5 1.7 1 3.1 2.3 4.1 3.9 1-1.6 2.4-2.9 4-3.9 1.7-1 3.5-1.5 5.6-1.5s4 .5 5.8 1.5c1.7 1 3.1 2.4 4.1 4.1s1.5 3.7 1.5 5.8v18H130V26.5c0-1.3-.3-2.4-.9-3.5-.6-1-1.4-1.9-2.5-2.5s-2.2-1-3.4-1c-1.3 0-2.4.3-3.4.9-1 .6-1.8 1.4-2.5 2.5-.6 1-.9 2.2-.9 3.6v16.4h-5.9V26.5c0-1.3-.3-2.5-.9-3.6-.6-1-1.4-1.9-2.5-2.5-1-.6-2.2-.9-3.4-.9s-2.4.3-3.4 1c-1 .6-1.9 1.5-2.5 2.5s-.9 2.2-.9 3.5v16.4H91zm62.8.7c-2.6 0-5-.7-7.2-2-2.2-1.4-3.9-3.2-5.2-5.4-1.3-2.3-1.9-4.8-1.9-7.6 0-2.1.4-4 1.1-5.9.7-1.8 1.8-3.4 3.1-4.8s2.8-2.5 4.6-3.2c1.7-.8 3.6-1.2 5.5-1.2 2.2 0 4.2.5 6 1.4s3.4 2.2 4.7 3.7c1.3 1.6 2.2 3.4 2.9 5.5.6 2.1.8 4.3.5 6.6h-22c.2 1.3.7 2.5 1.4 3.6s1.6 1.9 2.7 2.5c1.1.6 2.4.9 3.7.9 1.4 0 2.8-.4 4-1.1s2.2-1.7 2.9-3l6 1.4c-1.1 2.5-2.9 4.6-5.2 6.2-2.2 1.6-4.8 2.4-7.6 2.4zm-8.1-17.5h16.2c-.2-1.4-.7-2.6-1.4-3.7-.8-1.1-1.7-2-2.9-2.7s-2.4-1-3.8-1-2.6.3-3.8 1c-1.2.6-2.1 1.5-2.9 2.6-.7 1.2-1.2 2.5-1.4 3.8zM194.8 0h5.9v42.9h-5.9v-4.2c-.9 1.5-2.2 2.7-3.7 3.6s-3.3 1.4-5.3 1.4c-2.1 0-4-.4-5.8-1.2-1.8-.8-3.4-1.9-4.8-3.2-1.4-1.4-2.5-3-3.2-4.8-.8-1.8-1.2-3.8-1.2-5.8 0-2.1.4-4 1.2-5.8s1.9-3.4 3.2-4.8c1.4-1.4 3-2.5 4.8-3.2 1.8-.8 3.8-1.2 5.8-1.2s3.8.5 5.3 1.4 2.7 2.1 3.7 3.6V0zm-8.9 37.9c1.7 0 3.1-.4 4.4-1.2 1.3-.8 2.2-1.9 2.9-3.4.7-1.4 1-3 1-4.7s-.4-3.3-1.1-4.7-1.7-2.5-2.9-3.4c-1.2-.8-2.7-1.2-4.4-1.2-1.7 0-3.2.4-4.5 1.3-1.4.8-2.4 2-3.3 3.4-.8 1.4-1.2 3-1.2 4.7s.4 3.3 1.2 4.7c.8 1.4 1.9 2.5 3.3 3.3 1.5.8 3 1.2 4.6 1.2zm21.7-23.6h5.9v28.6h-5.9V14.3zm34.5 0h5.9v28.6h-6l-.2-4.1c-.8 1.5-2 2.6-3.4 3.5s-3.1 1.3-5.1 1.3c-2.1 0-4.1-.4-5.9-1.2s-3.5-1.9-4.9-3.3-2.5-3-3.3-4.9c-.8-1.8-1.2-3.8-1.2-5.9 0-2 .4-4 1.1-5.8.8-1.8 1.8-3.4 3.2-4.7 1.4-1.4 2.9-2.4 4.7-3.2 1.8-.8 3.7-1.2 5.7-1.2 2.1 0 3.9.5 5.5 1.4s2.9 2.1 4 3.6l-.1-4.1zm-8.9 23.6c1.7 0 3.1-.4 4.4-1.2 1.3-.8 2.2-1.9 2.9-3.4.7-1.4 1-3 1-4.7s-.4-3.3-1.1-4.7-1.7-2.5-2.9-3.4c-1.2-.8-2.7-1.2-4.4-1.2-1.7 0-3.2.4-4.5 1.3-1.4.8-2.5 2-3.3 3.4s-1.2 3-1.2 4.7.4 3.3 1.2 4.7c.8 1.4 1.9 2.5 3.3 3.3 1.5.8 3 1.2 4.6 1.2z"/>
                                                                            <path class="logo-dot"
                                                                                  d="M258.2 42.5c-1.5 0-2.7-.5-3.5-1.3-1-1-1.5-2-1.5-3.5 0-1.3.5-2.5 1.5-3.5s2.2-1.3 3.5-1.3c1.3 0 2.5.5 3.5 1.3 1 1 1.5 2 1.5 3.5 0 1.3-.5 2.5-1.3 3.5-.9 1-2.4 1.3-3.7 1.3z"
                                                                                  style="fill:#e6e117"/>
                                                                        </g>
                                                                    </svg>
                                                                </span>
                                                        </a>
                                                    </div>
                                                    <div class="col-12 col-md-4 col-lg-4 contact-data__item grid-item">
                                                        <p class="contact-data__title tagline-chapter animate-in-up">Navigation</p>
                                                        <p class="contact-data__text small type-basic-160lh">
                                                            @if(request()->is('/'))
                                                                <a class="link-small-160lh animate-in-up" href="#about">About</a><br/>
                                                                <a class="link-small-160lh animate-in-up" href="#services">Capability</a><br/>
                                                            @else
                                                                <a class="link-small-160lh animate-in-up" href="/">Home</a><br/>
                                                            @endif
                                                            <a class="link-small-160lh animate-in-up" href="#contact">Let's talk</a>
                                                        </p>
                                                    </div>
                                                    <div
                                                        class="col-12 col-md-4 col-lg-4 contact-data__item grid-item">
                                                        <p class="contact-data__title tagline-chapter animate-in-up">
                                                            Copyright & Terms</p>
                                                        <p class="contact-data__text small type-basic-160lh">
                                                            <a class="link-small-160lh animate-in-up" href="#">Terms
                                                                & Conditions</a><br/>
                                                            <a class="link-small-160lh animate-in-up" href="#">Privacy
                                                                policy</a>
                                                        </p><br/>
                                                        <p class="contact-data__text small type-basic-160lh">
                                                            <a class="link-small-160lh animate-in-up"
                                                               href="mailto:reach@thepacmedia.com?subject=Briefing%20Request">reach@thepacmedia.com</a><br/>
                                                        <div class="copyright"
                                                             style="color: white; margin-top: 1em;">
                                                            &copy;<span id="current-year">{{ date('Y') }}</span>
                                                            Pacmedia Creatives
                                                        </div>
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </footer>
                    </div>
                </div>
                <div class="col-12 col-xl-2"></div>
            </div>
        </div>
    </div>
</section>
