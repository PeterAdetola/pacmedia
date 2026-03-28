{{--
    Contact Form Component
    ─────────────────────────────────────────────────────────────
    Usage:
        <x-contact-form />

    Props:
        $projectName  — hidden field value (default: 'Pacmedia Briefing Request')
        $adminEmail   — hidden field value (default: 'reach@thepacmedia.com')
        $formSubject  — hidden field value (default: 'New Contact us Request')
        $submitLabel  — button caption      (default: 'Deploy Request →')
--}}

@props([
    'projectName' => 'Pacmedia Briefing Request',
    'adminEmail'  => 'reach@thepacmedia.com',
    'formSubject' => 'New Contact us Request',
    'submitLabel' => 'Deploy Request →',
])

<form class="form contact-form" id="contact-form">
    @csrf
    <input type="hidden" name="project_name" value="{{ $projectName }}"/>
    <input type="hidden" name="admin_email"  value="{{ $adminEmail }}"/>
    <input type="hidden" name="form_subject" value="{{ $formSubject }}"/>

    {{-- Honeypot — hidden from humans, bots will fill this --}}
    <div style="display:none;" aria-hidden="true">
        <input type="text" name="website" value="" tabindex="-1" autocomplete="off"/>
    </div>

    <div class="container-fluid p-0">
        <div class="row gx-0">

            <div class="col-12 col-md-6 form__item animate-in-up">
                <input type="text" name="name" placeholder="Your Name*" required/>
            </div>
            <div class="col-12 col-md-6 form__item animate-in-up">
                <input type="text" name="company" placeholder="Company / Brand"/>
            </div>
            <div class="col-12 col-md-6 form__item animate-in-up">
                <input type="email" name="email" placeholder="Email*" required/>
            </div>
            <div class="col-12 col-md-6 form__item animate-in-up">
                <input type="text" name="location" placeholder="Location"/>
            </div>

            <p class="h2__text text-twothirds type-basic-160lh animate-in-up">
                Select your operation
            </p>

            <div class="demo-section form__item animate-in-up">
                <label class="checkbox-container link-small-160lh">
                    <input type="checkbox" name="services[]" value="Visual Brand Architecture">
                    <span class="custom-checkbox"></span>
                    <span class="checkbox-label">Visual Brand Architecture</span>
                </label>
                <label class="checkbox-container">
                    <input type="checkbox" name="services[]" value="Web Design & Development">
                    <span class="custom-checkbox"></span>
                    <span class="checkbox-label">Web Design & Development</span>
                </label>
                <label class="checkbox-container">
                    <input type="checkbox" name="services[]" value="Intelligent Automation">
                    <span class="custom-checkbox"></span>
                    <span class="checkbox-label">Intelligent Automation</span>
                </label>
                <label class="checkbox-container">
                    <input type="checkbox" name="services[]" value="Other">
                    <span class="custom-checkbox"></span>
                    <span class="checkbox-label">Other</span>
                </label>
            </div>

            <div class="col-12 form__item animate-in-up">
                <textarea
                    name="message"
                    placeholder="Tell us about your project*"
                    required
                ></textarea>
            </div>

            {{-- Response message --}}
            <div id="form-response" class="col-12 form__item animate-in-up" style="display:none;">
                <p id="form-response-text" style="padding:1rem 0; line-height:1.6;"></p>
            </div>

            <div class="btn-group about-descr__btnholder form__item animate-in-up">
                <button class="btn btn-default hover-default" type="submit" id="form-submit-btn">
                    <em></em>
                    <span class="btn-caption" id="form-btn-caption">{{ $submitLabel }}</span>
                </button>
            </div>

        </div>
    </div>
</form>

<script>
    (function () {
        const form        = document.getElementById('contact-form');
        const btn         = document.getElementById('form-submit-btn');
        const btnCaption  = document.getElementById('form-btn-caption');
        const responseBox = document.getElementById('form-response');
        const responseMsg = document.getElementById('form-response-text');

        if (!form) return;

        form.addEventListener('submit', async function (e) {
            e.preventDefault();

            // Loading state
            btn.disabled           = true;
            btnCaption.textContent = 'Sending…';

            try {
                const res  = await fetch('{{ route("contact.submit") }}', {
                    method:  'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Accept':       'application/json',
                    },
                    body: new FormData(form),
                });

                const json = await res.json();

                // Handle Laravel validation errors (422)
                if (res.status === 422 && json.errors) {
                    const firstError          = Object.values(json.errors)[0][0];
                    responseMsg.style.color   = '#e55';
                    responseMsg.textContent   = firstError;
                    responseBox.style.display = 'block';
                    btnCaption.textContent    = '{{ $submitLabel }}';
                    btn.disabled              = false;
                    return;
                }

                responseBox.style.display = 'block';

                if (json.success) {
                    responseMsg.style.color = 'var(--t-medium)';
                    responseMsg.textContent = json.message;
                    btnCaption.textContent  = 'Sent ✓';
                    form.reset();
                } else {
                    responseMsg.style.color = '#e55';
                    responseMsg.textContent = json.message ?? 'Something went wrong. Please try again.';
                    btnCaption.textContent  = '{{ $submitLabel }}';
                    btn.disabled            = false;
                }

            } catch (err) {
                responseBox.style.display = 'block';
                responseMsg.style.color   = '#e55';
                responseMsg.textContent   = 'Network error. Please check your connection and try again.';
                btnCaption.textContent    = '{{ $submitLabel }}';
                btn.disabled              = false;
            }
        });
    })();
</script>
