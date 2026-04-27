<x-admin-layout title="Compose Email">

    @push('page-css')
        <style>
            /* ── Repeater rows ───────────────────────────────── */
            .pac-para-row {
                position: relative;
                margin-bottom: 1rem;
            }
            .pac-para-row .pac-para-remove {
                position: absolute;
                top: 50%;
                right: -2rem;
                transform: translateY(-50%);
                width: 24px; height: 24px;
                display: flex; align-items: center; justify-content: center;
                border: none; background: transparent;
                color: #9ca3af; cursor: pointer;
                font-size: 1.1rem;
                transition: color 0.15s;
                padding: 0;
            }
            .pac-para-row .pac-para-remove:hover { color: #ef4444; }

            .pac-detail-row {
                display: flex; gap: 0.625rem;
                margin-bottom: 0.75rem; align-items: center;
            }
            .pac-detail-row input { flex: 1; min-width: 0; }
            .pac-detail-row .pac-remove-row {
                flex-shrink: 0; width: 32px; height: 32px;
                display: flex; align-items: center; justify-content: center;
                border: 1px solid var(--bs-border-color); border-radius: 0.375rem;
                cursor: pointer; color: #9ca3af; background: transparent;
                transition: all 0.15s; font-size: 1rem;
            }
            .pac-detail-row .pac-remove-row:hover { border-color: #ef4444; color: #ef4444; }

            /* ── Sidebar sticky ──────────────────────────────── */
            .pac-compose-actions { position: sticky; top: 80px; }

            /* ── Template hint strip ─────────────────────────── */
            .pac-hint {
                font-size: 0.76rem; color: #9ca3af;
                line-height: 1.6; padding: 0.875rem 1rem;
                background: rgba(181,204,24,0.04);
                border-left: 3px solid #b5cc18;
                border-radius: 0 0.375rem 0.375rem 0;
            }
            [data-bs-theme="dark"] .pac-hint { background: rgba(181,204,24,0.06); }

            /* ── Section divider label ───────────────────────── */
            .pac-section-label {
                font-size: 0.68rem; font-weight: 700;
                text-transform: uppercase; letter-spacing: 0.08em;
                color: #9ca3af; margin-bottom: 1.25rem;
            }

            /* ── Add row buttons ─────────────────────────────── */
            .btn-add-row {
                font-size: 0.78rem; padding: 0.3rem 0.875rem;
            }

            /* ── Focus ring matching brand ───────────────────── */
            .form-control:focus,
            .form-select:focus {
                border-color: #b5cc18;
                box-shadow: 0 0 0 0.2rem rgba(181,204,24,0.15);
            }
        </style>
    @endpush

    <form method="POST" action="{{ route('admin.mail.send') }}" id="pac-compose-form">
        @csrf

        <div class="row">

            {{-- ══════════════════════════════════════════════
                 LEFT — Main compose area (col 9)
            ═══════════════════════════════════════════════ --}}
            <div class="col-xl-9 col-md-8 col-12 mb-md-0 mb-6">
                <div class="card">

                    {{-- ── Routing ── --}}
                    <div class="card-body pb-0">
                        <p class="pac-section-label mb-4">Routing</p>

                        <div class="row g-5 mb-5">

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
                        <div class="form-floating form-floating-outline mb-5">
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
                    </div>

                    <hr class="my-1">

                    {{-- ── Template meta ── --}}
                    <div class="card-body pb-0">
                        <p class="pac-section-label">Template</p>

                        <div class="row g-5 mb-5">

                            {{-- Email type --}}
                            <div class="col-md-4">
                                <div class="form-floating form-floating-outline">
                                    <select class="form-select" id="email_type" name="email_type">
                                        <option value="Message" selected>Message</option>
                                        <option value="Update">Update</option>
                                        <option value="Confirmation">Confirmation</option>
                                        <option value="Reminder">Reminder</option>
                                        <option value="Alert">Alert</option>
                                        <option value="Proposal">Proposal</option>
                                    </select>
                                    <label for="email_type">Email Type</label>
                                </div>
                            </div>

                            {{-- Index label --}}
                            <div class="col-md-4">
                                <div class="form-floating form-floating-outline">
                                    <input type="text" class="form-control"
                                           id="index_label" name="index_label"
                                           value="{{ old('index_label', '01 — Message') }}"
                                           placeholder="01 — Message">
                                    <label for="index_label">Index Label</label>
                                </div>
                            </div>

                            {{-- Heading --}}
                            <div class="col-md-4">
                                <div class="form-floating form-floating-outline">
                                    <input type="text" class="form-control"
                                           id="heading" name="heading"
                                           value="{{ old('heading') }}"
                                           placeholder="Main headline">
                                    <label for="heading">Headline</label>
                                </div>
                            </div>

                        </div>

                        {{-- Hint strip --}}
                        <div class="pac-hint mb-5">
                            <strong>Template structure:</strong>
                            Index Label → Headline → Rule → Paragraphs → Detail Block → CTA Button → Note
                        </div>
                    </div>

                    <hr class="my-1">

                    {{-- ── Body paragraphs — dynamic repeater ── --}}
                    <div class="card-body pb-0">
                        <div class="d-flex align-items-center justify-content-between mb-4">
                            <p class="pac-section-label mb-0">Body</p>
                            <button type="button" class="btn btn-outline-secondary btn-sm btn-add-row"
                                    id="add-paragraph">
                                <i class="ri ri-add-line me-1"></i> Add Paragraph
                            </button>
                        </div>

                        {{-- Paragraph repeater container --}}
                        <div id="paragraph-container" style="padding-right: 2rem;">
                            {{-- First paragraph — always present, not removable --}}
                            <div class="pac-para-row">
                                <div class="form-floating form-floating-outline">
                                    <textarea class="form-control @error('paragraphs.0') is-invalid @enderror"
                                              name="paragraphs[]"
                                              style="height:110px;"
                                              placeholder="First paragraph" required>{{ old('paragraphs.0') }}</textarea>
                                    <label>Paragraph 1</label>
                                    @error('paragraphs.0')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                {{-- No remove button on first paragraph --}}
                            </div>
                        </div>
                    </div>

                    <hr class="my-1">

                    {{-- ── Detail rows — dynamic ── --}}
                    <div class="card-body pb-0">
                        <div class="d-flex align-items-center justify-content-between mb-4">
                            <p class="pac-section-label mb-0">
                                Detail Block
                                <span class="text-muted fw-normal text-lowercase" style="letter-spacing:0;">
                                    — key / value rows (optional)
                                </span>
                            </p>
                            <button type="button" class="btn btn-outline-secondary btn-sm btn-add-row"
                                    id="add-detail-row">
                                <i class="ri ri-add-line me-1"></i> Add Row
                            </button>
                        </div>

                        <div id="detail-rows-container" class="mb-2">
                            {{-- Rows injected by JS --}}
                        </div>

                        <p class="text-muted mb-5" style="font-size:0.76rem;">
                            Rows appear as a labelled table inside the email — useful for references, dates, amounts, etc.
                        </p>
                    </div>

                    <hr class="my-1">

                    {{-- ── CTA + Note ── --}}
                    <div class="card-body">
                        <p class="pac-section-label">Actions & Notes</p>

                        <div class="row g-5 mb-5">
                            <div class="col-md-8">
                                <div class="form-floating form-floating-outline">
                                    <input type="url" class="form-control"
                                           id="cta_url" name="cta_url"
                                           value="{{ old('cta_url') }}"
                                           placeholder="https://thepacmedia.com">
                                    <label for="cta_url">Button URL <span class="text-muted fw-normal">(optional)</span></label>
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

                        <div class="form-floating form-floating-outline">
                            <textarea class="form-control"
                                      id="note" name="note"
                                      style="height:80px;"
                                      placeholder="Italic note at bottom of email (optional)">{{ old('note') }}</textarea>
                            <label for="note">Note / Aside <span class="text-muted fw-normal">(optional, italic)</span></label>
                        </div>
                    </div>

                </div>
            </div>
            {{-- / left col --}}

            {{-- ══════════════════════════════════════════════
                 RIGHT — Actions sidebar (col 3)
            ═══════════════════════════════════════════════ --}}
            <div class="col-xl-3 col-md-4 col-12">
                <div class="pac-compose-actions">

                    {{-- Send card --}}
                    <div class="card mb-5">
                        <div class="card-body">

                            @if(session('success'))
                                <div class="alert alert-success d-flex align-items-center gap-2 mb-4 py-2"
                                     style="font-size:0.82rem;" role="alert">
                                    <i class="ri ri-checkbox-circle-line"></i>
                                    {{ session('success') }}
                                </div>
                            @endif

                            <button type="submit" class="btn btn-primary d-grid w-100 mb-4">
                                <span class="d-flex align-items-center justify-content-center">
                                    <i class="ri ri-send-plane-line me-2"></i> Send Email
                                </span>
                            </button>

                            <a href="{{ route('admin.mail.compose') }}"
                               class="btn btn-outline-secondary d-grid w-100">
                                Clear Form
                            </a>
                        </div>
                    </div>

                    {{-- Checklist card --}}
                    <div class="card">
                        <div class="card-body">
                            <h6 class="mb-4" style="font-size:0.78rem;text-transform:uppercase;letter-spacing:0.07em;color:#9ca3af;">
                                Before sending
                            </h6>
                            <ul class="list-unstyled mb-0" style="font-size:0.8rem; color:#6b7280; line-height:2;">
                                <li><i class="ri ri-checkbox-circle-line me-2" style="color:#b5cc18;"></i> From address correct</li>
                                <li><i class="ri ri-checkbox-circle-line me-2" style="color:#b5cc18;"></i> Recipient email verified</li>
                                <li><i class="ri ri-checkbox-circle-line me-2" style="color:#b5cc18;"></i> Subject line clear</li>
                                <li><i class="ri ri-checkbox-circle-line me-2" style="color:#b5cc18;"></i> Body reviewed</li>
                                <li><i class="ri ri-checkbox-circle-line me-2" style="color:#b5cc18;"></i> CTA URL tested</li>
                            </ul>
                        </div>
                    </div>

                </div>
            </div>
            {{-- / right col --}}

        </div>
    </form>

    @push('page-js')
        <script>
            (function () {

                // ── Paragraph repeater ────────────────────────────
                let paraCount = 1; // first paragraph already exists

                document.getElementById('add-paragraph').addEventListener('click', function () {
                    paraCount++;
                    const container = document.getElementById('paragraph-container');
                    const row = document.createElement('div');
                    row.className = 'pac-para-row';
                    row.innerHTML = `
                    <div class="form-floating form-floating-outline">
                        <textarea class="form-control"
                                  name="paragraphs[]"
                                  style="height:110px;"
                                  placeholder="Paragraph ${paraCount}"></textarea>
                        <label>Paragraph ${paraCount}</label>
                    </div>
                    <button type="button" class="pac-para-remove" title="Remove paragraph">
                        <i class="ri ri-close-line"></i>
                    </button>
                `;
                    row.querySelector('.pac-para-remove').addEventListener('click', function () {
                        row.remove();
                        renumberParagraphs();
                    });
                    container.appendChild(row);
                });

                function renumberParagraphs() {
                    document.querySelectorAll('#paragraph-container .pac-para-row label').forEach(function (lbl, i) {
                        lbl.textContent = 'Paragraph ' + (i + 1);
                    });
                    paraCount = document.querySelectorAll('#paragraph-container .pac-para-row').length;
                }

                // ── Detail rows repeater ──────────────────────────
                document.getElementById('add-detail-row').addEventListener('click', function () {
                    addDetailRow();
                });

                function addDetailRow(label, value) {
                    label = label || '';
                    value = value || '';
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
                    <button type="button" class="pac-remove-row" title="Remove">
                        <i class="ri ri-close-line"></i>
                    </button>
                `;
                    row.querySelector('.pac-remove-row').addEventListener('click', () => row.remove());
                    container.appendChild(row);
                }

                // ── Success toast auto-dismiss ────────────────────
                document.querySelectorAll('.toast.show').forEach(function (t) {
                    setTimeout(() => bootstrap.Toast.getOrCreateInstance(t).hide(), 4000);
                });

            })();
        </script>
    @endpush

</x-admin-layout>
