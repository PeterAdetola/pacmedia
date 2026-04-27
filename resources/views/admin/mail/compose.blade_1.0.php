<x-admin-layout title="Compose Email">

    @push('page-css')
        <style>
            .pac-composer-card { max-width: 760px; }

            /* Detail rows repeater */
            .pac-detail-row { display: flex; gap: 0.75rem; margin-bottom: 0.75rem; align-items: center; }
            .pac-detail-row input { flex: 1; }
            .pac-detail-row .pac-remove-row {
                flex-shrink: 0;
                width: 32px; height: 32px;
                display: flex; align-items: center; justify-content: center;
                border: 1px solid var(--bs-border-color);
                border-radius: 0.375rem;
                cursor: pointer;
                color: #9ca3af;
                background: transparent;
                transition: all 0.15s;
            }
            .pac-detail-row .pac-remove-row:hover { border-color: #ef4444; color: #ef4444; }

            /* Optional sections */
            .pac-optional-toggle {
                display: flex; align-items: center; gap: 0.5rem;
                font-size: 0.8rem; font-weight: 600;
                color: #6b7280; cursor: pointer;
                padding: 0.4rem 0;
                user-select: none;
            }
            .pac-optional-toggle i { font-size: 1rem; transition: transform 0.2s; }
            .pac-optional-toggle.open i { transform: rotate(90deg); }

            /* Preview strip */
            .pac-template-preview {
                background: #f9fafb;
                border: 1px solid var(--bs-border-color);
                border-radius: 0.625rem;
                padding: 1.25rem 1.5rem;
                font-size: 0.82rem;
                color: #6b7280;
                line-height: 1.7;
            }

            [data-bs-theme="dark"] .pac-template-preview { background: rgba(255,255,255,0.03); }
            [data-bs-theme="dark"] .pac-optional-toggle { color: #9ca3af; }
        </style>
    @endpush

    <div class="row justify-content-center">
        <div class="col-12 pac-composer-card">

            {{-- Page header --}}
            <div class="d-flex align-items-center justify-content-between mb-5">
                <div>
                    <h4 class="mb-1">Compose Email</h4>
                    <p class="text-muted mb-0" style="font-size:0.83rem;">
                        Send a branded email using The Pacmedia template.
                    </p>
                </div>
                <a href="{{ url()->previous() }}" class="btn btn-outline-secondary btn-sm">
                    <i class="ri ri-arrow-left-line me-1"></i> Back
                </a>
            </div>

            @if(session('success'))
                <div class="alert alert-success d-flex align-items-center gap-2 mb-5" role="alert">
                    <i class="ri ri-checkbox-circle-line"></i>
                    {{ session('success') }}
                </div>
            @endif

            <form method="POST" action="{{ route('admin.mail.send') }}">
                @csrf

                <div class="card mb-5">
                    <div class="card-body">

                        {{-- ── SECTION: Routing ── --}}
                        <p class="text-uppercase fw-bold mb-4"
                           style="font-size:0.68rem; letter-spacing:0.1em; color:#9ca3af;">
                            Routing
                        </p>

                        <div class="row g-4 mb-4">

                            {{-- From --}}
                            <div class="col-md-6">
                                <div class="form-floating form-floating-outline">
                                    <select class="form-select @error('from_address') is-invalid @enderror"
                                            id="from_address" name="from_address" required>
                                        @foreach($fromAddresses as $addr)
                                            <option value="{{ $addr['address'] }}"
                                                {{ $addr['address'] === 'updates@thepacmedia.com' ? 'selected' : '' }}>
                                                {{ $addr['name'] }} &lt;{{ $addr['address'] }}&gt;
                                            </option>
                                        @endforeach
                                    </select>
                                    <label for="from_address">From</label>
                                    @error('from_address')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            {{-- To --}}
                            <div class="col-md-6">
                                <div class="form-floating form-floating-outline">
                                    <input type="email"
                                           class="form-control @error('to') is-invalid @enderror"
                                           id="to" name="to"
                                           value="{{ old('to') }}"
                                           placeholder="recipient@email.com" required>
                                    <label for="to">To</label>
                                    @error('to')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                        </div>

                        {{-- Subject --}}
                        <div class="form-floating form-floating-outline mb-4">
                            <input type="text"
                                   class="form-control @error('subject') is-invalid @enderror"
                                   id="subject" name="subject"
                                   value="{{ old('subject') }}"
                                   placeholder="Email subject" required>
                            <label for="subject">Subject</label>
                            @error('subject')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <hr class="my-5">

                        {{-- ── SECTION: Template fields ── --}}
                        <p class="text-uppercase fw-bold mb-4"
                           style="font-size:0.68rem; letter-spacing:0.1em; color:#9ca3af;">
                            Template
                        </p>

                        <div class="row g-4 mb-4">

                            {{-- Email type tag --}}
                            <div class="col-md-6">
                                <div class="form-floating form-floating-outline">
                                    <select class="form-select" id="email_type" name="email_type">
                                        <option value="Message"       selected>Message</option>
                                        <option value="Update">Update</option>
                                        <option value="Confirmation">Confirmation</option>
                                        <option value="Reminder">Reminder</option>
                                        <option value="Alert">Alert</option>
                                        <option value="Proposal">Proposal</option>
                                    </select>
                                    <label for="email_type">Email Type <small class="text-muted">(top-right tag)</small></label>
                                </div>
                            </div>

                            {{-- Index label --}}
                            <div class="col-md-6">
                                <div class="form-floating form-floating-outline">
                                    <input type="text" class="form-control"
                                           id="index_label" name="index_label"
                                           value="{{ old('index_label', '01 — Message') }}"
                                           placeholder="01 — Message">
                                    <label for="index_label">Index Label <small class="text-muted">(small text above headline)</small></label>
                                </div>
                            </div>

                        </div>

                        {{-- Heading --}}
                        <div class="form-floating form-floating-outline mb-4">
                            <input type="text"
                                   class="form-control @error('heading') is-invalid @enderror"
                                   id="heading" name="heading"
                                   value="{{ old('heading') }}"
                                   placeholder="Your heading here">
                            <label for="heading">
                                Headline <small class="text-muted">(large text — HTML allowed e.g. Line one&lt;br/&gt;Line two)</small>
                            </label>
                        </div>

                        {{-- Body line 1 --}}
                        <div class="form-floating form-floating-outline mb-4">
                            <textarea class="form-control @error('body_line1') is-invalid @enderror"
                                      id="body_line1" name="body_line1"
                                      style="height:120px;" required
                                      placeholder="First paragraph">{{ old('body_line1') }}</textarea>
                            <label for="body_line1">Body — First Paragraph</label>
                            @error('body_line1')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Body line 2 (optional) --}}
                        <div class="form-floating form-floating-outline mb-4">
                            <textarea class="form-control"
                                      id="body_line2" name="body_line2"
                                      style="height:100px;"
                                      placeholder="Second paragraph (optional)">{{ old('body_line2') }}</textarea>
                            <label for="body_line2">Body — Second Paragraph <small class="text-muted">(optional)</small></label>
                        </div>

                        <hr class="my-5">

                        {{-- ── SECTION: Detail rows ── --}}
                        <div class="d-flex align-items-center justify-content-between mb-3">
                            <p class="text-uppercase fw-bold mb-0"
                               style="font-size:0.68rem; letter-spacing:0.1em; color:#9ca3af;">
                                Detail Block <span class="text-muted fw-normal">(optional key-value rows)</span>
                            </p>
                            <button type="button" class="btn btn-outline-secondary btn-sm"
                                    id="add-detail-row">
                                <i class="ri ri-add-line me-1"></i> Add Row
                            </button>
                        </div>

                        <div id="detail-rows-container">
                            {{-- Rows injected by JS --}}
                        </div>

                        <hr class="my-5">

                        {{-- ── SECTION: CTA (optional) ── --}}
                        <p class="text-uppercase fw-bold mb-4"
                           style="font-size:0.68rem; letter-spacing:0.1em; color:#9ca3af;">
                            Call to Action <span class="text-muted fw-normal">(optional button)</span>
                        </p>

                        <div class="row g-4 mb-4">
                            <div class="col-md-8">
                                <div class="form-floating form-floating-outline">
                                    <input type="url" class="form-control"
                                           id="cta_url" name="cta_url"
                                           value="{{ old('cta_url') }}"
                                           placeholder="https://thepacmedia.com">
                                    <label for="cta_url">Button URL</label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-floating form-floating-outline">
                                    <input type="text" class="form-control"
                                           id="cta_label" name="cta_label"
                                           value="{{ old('cta_label', 'Visit Our Website →') }}"
                                           placeholder="Button text">
                                    <label for="cta_label">Button Text</label>
                                </div>
                            </div>
                        </div>

                        {{-- Note (optional) --}}
                        <div class="form-floating form-floating-outline mb-4">
                            <textarea class="form-control"
                                      id="note" name="note"
                                      style="height:80px;"
                                      placeholder="Italic note shown at the bottom of the email body (optional)">{{ old('note') }}</textarea>
                            <label for="note">Note / Aside <small class="text-muted">(italic, optional)</small></label>
                        </div>

                    </div>
                </div>

                {{-- ── Template preview strip ── --}}
                <div class="pac-template-preview mb-5">
                    <strong style="font-size:0.7rem;letter-spacing:0.1em;text-transform:uppercase;color:#9ca3af;">
                        What the recipient will see
                    </strong><br><br>
                    <span style="color:#797d83;font-size:0.75rem;letter-spacing:0.12em;text-transform:uppercase;">
                        [Email Type tag] → [Index Label] → [Headline] → [Rule] → [Body] → [Detail Block] → [CTA Button] → [Note] → Signature
                    </span>
                    <br><br>
                    The email is sent using The Pacmedia branded template with your gradient mark and footer.
                    Dark mode is handled automatically.
                </div>

                {{-- Submit --}}
                <div class="d-flex gap-3">
                    <button type="submit" class="btn btn-primary">
                        <i class="ri ri-send-plane-line me-1"></i> Send Email
                    </button>
                    <a href="{{ route('admin.mail.compose') }}" class="btn btn-outline-secondary">
                        Clear
                    </a>
                </div>

            </form>
        </div>
    </div>

    @push('page-js')
        <script>
            (function () {

                let rowIndex = 0;

                function addRow(label = '', value = '') {
                    const container = document.getElementById('detail-rows-container');
                    const row = document.createElement('div');
                    row.className = 'pac-detail-row';
                    row.innerHTML = `
                    <input type="text"
                           class="form-control form-control-sm"
                           name="detail_labels[]"
                           value="${label}"
                           placeholder="Label e.g. Reference">
                    <input type="text"
                           class="form-control form-control-sm"
                           name="detail_values[]"
                           value="${value}"
                           placeholder="Value e.g. PCM-001">
                    <button type="button" class="pac-remove-row" title="Remove row">
                        <i class="ri ri-close-line"></i>
                    </button>
                `;
                    row.querySelector('.pac-remove-row').addEventListener('click', () => row.remove());
                    container.appendChild(row);
                    rowIndex++;
                }

                document.getElementById('add-detail-row').addEventListener('click', () => addRow());

                // Flash success toast auto-dismiss
                document.querySelectorAll('.toast.show').forEach(function (t) {
                    setTimeout(() => bootstrap.Toast.getOrCreateInstance(t).hide(), 4000);
                });

            })();
        </script>
    @endpush

</x-admin-layout>
