{{--
    Engagement Modal Component
    ─────────────────────────────────────────────────────────────
    Usage in app.blade.php (just before closing </body>):
        <x-engagement-modal />

    Props:
        $calendarId  — Cal.com inline element ID (default: my-cal-inline-15min)
--}}

@props([
    'calendarId' => 'my-cal-inline-15min',
])

<div class="engagement-modal" id="engagement-modal" role="dialog" aria-modal="true" aria-labelledby="modal-title">

    <div class="engagement-modal__backdrop" id="modal-backdrop"></div>

    <div class="engagement-modal__container">

        {{-- Close button --}}
        <button class="engagement-modal__close" id="modal-close" aria-label="Close">
            <i class="ph ph-x"></i>
        </button>

        {{-- Step 1 — Choose path --}}
        <div class="engagement-modal__step" id="modal-step-1">
            <span class="section-name icon-right animate-in-up">
                <span class="section-name-caption">Ready to engage?</span>
                <i class="ph ph-arrow-down-right"></i>
            </span>
            <h3 class="engagement-modal__title" id="modal-title">
                How would you<br/>like to proceed?
            </h3>
            <p class="engagement-modal__subtitle">
                Choose the path that works best for you.
            </p>
            <div class="engagement-modal__choices">

                <button class="engagement-modal__choice" id="choice-briefing">
                    <div class="engagement-modal__choice-icon">
                        <i class="ph ph-file-text"></i>
                    </div>
                    <div class="engagement-modal__choice-text">
                        <span class="engagement-modal__choice-title">Submit Briefing</span>
                        <span class="engagement-modal__choice-desc">
                            Fill out our intake form. We'll review and respond within 24 hours.
                        </span>
                    </div>
                    <i class="ph ph-arrow-right engagement-modal__choice-arrow"></i>
                </button>

                <button class="engagement-modal__choice" id="choice-calendar">
                    <div class="engagement-modal__choice-icon">
                        <i class="ph ph-calendar"></i>
                    </div>
                    <div class="engagement-modal__choice-text">
                        <span class="engagement-modal__choice-title">Schedule a Call</span>
                        <span class="engagement-modal__choice-desc">
                            Pick a time that works for you and speak directly with our squad representative.
                        </span>
                    </div>
                    <i class="ph ph-arrow-right engagement-modal__choice-arrow"></i>
                </button>

            </div>
        </div>

        {{-- Step 2 — Calendar --}}
        <div class="engagement-modal__step engagement-modal__step--hidden" id="modal-step-2">
            <button class="engagement-modal__back" id="modal-back">
                <i class="ph ph-arrow-left"></i>
                <span>Back</span>
            </button>
            <h3 class="engagement-modal__title">Schedule a Call</h3>
            <p class="engagement-modal__subtitle">Pick a time that works best for you.</p>
            <div class="engagement-modal__calendar-wrap">
                <div style="width:100%; height:100%; overflow:scroll" id="{{ $calendarId }}"></div>
            </div>
        </div>

    </div>
</div>
