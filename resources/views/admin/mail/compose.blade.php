<x-admin-layout title="Compose Email">

    @push('page-css')
        <style>
            /* ── Paragraph rows ──────────────────────────────── */
            .pac-para-row {
                position: relative;
                margin-bottom: 1rem;
                padding-right: 2.5rem;
            }
            .pac-para-remove {
                position: absolute;
                top: 0.6rem;
                right: 0;
                width: 26px; height: 26px;
                display: flex; align-items: center; justify-content: center;
                border: 1px solid var(--bs-border-color);
                border-radius: 0.3rem;
                cursor: pointer;
                color: #9ca3af;
                background: var(--bs-body-bg);
                transition: all 0.15s;
                font-size: 0.85rem;
                padding: 0;
            }
            .pac-para-remove:hover { border-color: #ef4444; color: #ef4444; }

            /* ── Closing paragraph ───────────────────────────── */
            .pac-closing-wrap { padding-right: 0; }
            .pac-closing-label {
                font-size: 0.68rem; font-weight: 700;
                letter-spacing: 0.08em; text-transform: uppercase;
                color: #9ca3af; margin-bottom: 0.4rem;
            }
            .pac-closing-wrap textarea {
                border-style: dashed;
            }

            /* ── Detail rows ─────────────────────────────────── */
            .pac-detail-row {
                display: flex; gap: 0.625rem;
                margin-bottom: 0.75rem; align-items: center;
            }
            .pac-detail-row input { flex: 1; min-width: 0; }
            .pac-remove-row {
                flex-shrink: 0; width: 32px; height: 32px;
                display: flex; align-items: center; justify-content: center;
                border: 1px solid var(--bs-border-color); border-radius: 0.375rem;
                cursor: pointer; color: #9ca3af; background: transparent;
                transition: all 0.15s; font-size: 1rem; padding: 0;
            }
            .pac-remove-row:hover { border-color: #ef4444; color: #ef4444; }

            /* ── Section label ───────────────────────────────── */
            .pac-section-label {
                font-size: 0.68rem; font-weight: 700;
                text-transform: uppercase; letter-spacing: 0.08em;
                color: #9ca3af; margin-bottom: 0;
            }

            /* ── Hint strip ──────────────────────────────────── */
            .pac-hint {
                font-size: 0.76rem; color: #9ca3af;
                line-height: 1.6; padding: 0.75rem 1rem;
                background: rgba(181,204,24,0.04);
                border-left: 3px solid #b5cc18;
                border-radius: 0 0.375rem 0.375rem 0;
            }
            [data-bs-theme="dark"] .pac-hint { background: rgba(181,204,24,0.07); }

            /* ── Signature preview ───────────────────────────── */
            .pac-sig-preview {
                display: flex; align-items: center; gap: 14px;
                padding: 0.875rem 1.125rem;
                background: #f9fafb;
                border: 1px solid var(--bs-border-color);
                border-radius: 0.625rem;
                margin-top: 1rem;
            }
            .pac-sig-avatar {
                width: 38px; height: 38px; border-radius: 50%; flex-shrink: 0;
                background: linear-gradient(to right, #faf195 0%, #e6da00 50%, #2b261f 100%);
            }
            .pac-sig-rule { border-left: 1px solid #d0cdc8; padding-left: 14px; }
            .pac-sig-name { font-size: 0.875rem; font-weight: 600; color: #151617; margin: 0 0 2px; }
            .pac-sig-role { font-size: 0.625rem; letter-spacing: 0.1em; text-transform: uppercase; color: #797d83; margin: 0; }
            [data-bs-theme="dark"] .pac-sig-preview { background: rgba(255,255,255,0.03); }
            [data-bs-theme="dark"] .pac-sig-name    { color: #f2f5fc; }

            /* ── Attachment dropzone ─────────────────────────── */
            .pac-dropzone {
                border: 2px dashed var(--bs-border-color);
                border-radius: 0.5rem;
                padding: 1rem;
                text-align: center;
                cursor: pointer;
                transition: all 0.2s;
                position: relative;
            }
            .pac-dropzone:hover,
            .pac-dropzone.dragover {
                border-color: var(--bs-primary);
                background: rgba(var(--bs-primary-rgb), 0.04);
            }
            .pac-dropzone input[type="file"] {
                position: absolute; inset: 0;
                opacity: 0; cursor: pointer; width: 100%; height: 100%;
            }
            .pac-dropzone-icon  { font-size: 1.3rem; color: #9ca3af; }
            .pac-dropzone-label { font-size: 0.76rem; color: #6b7280; margin: 0; }
            .pac-dropzone-sub   { font-size: 0.68rem; color: #9ca3af; margin: 0; }

            /* ── Attachment pills ────────────────────────────── */
            #attachment-list { display: flex; flex-direction: column; gap: 0.4rem; margin-top: 0.6rem; }
            .pac-pill {
                display: flex; align-items: center; gap: 0.5rem;
                background: rgba(var(--bs-primary-rgb), 0.06);
                border: 1px solid rgba(var(--bs-primary-rgb), 0.18);
                border-radius: 0.4rem;
                padding: 0.35rem 0.6rem;
                font-size: 0.76rem;
            }
            .pac-pill-icon   { font-size: 0.9rem; color: var(--bs-primary); flex-shrink: 0; }
            .pac-pill-name   { flex: 1; overflow: hidden; text-overflow: ellipsis; white-space: nowrap; font-weight: 500; }
            .pac-pill-size   { font-size: 0.66rem; color: #9ca3af; flex-shrink: 0; }
            .pac-pill-remove {
                background: none; border: none; padding: 0;
                color: #9ca3af; cursor: pointer; font-size: 0.9rem;
                line-height: 1; transition: color 0.15s; flex-shrink: 0;
            }
            .pac-pill-remove:hover { color: #ef4444; }

            /* ── Sticky sidebar ──────────────────────────────── */
            .pac-sidebar { position: sticky; top: 80px; }

            /* ── Focus ring ──────────────────────────────────── */
            .form-control:focus,
            .form-select:focus {
                border-color: #b5cc18;
                box-shadow: 0 0 0 0.2rem rgba(181,204,24,0.15);
            }
        </style>
    @endpush

    <form id="pac-compose-form"
          method="POST"
          action="{{ route('admin.mail.send') }}"
          enctype="multipart/form-data">
        @csrf

        <div class="row">

            {{-- ════════════════════════════════════════
                 LEFT — Main compose area (col-9)
            ════════════════════════════════════════ --}}
            <div class="col-xl-9 col-md-8 col-12 mb-md-0 mb-6">
                <div class="card">

                    {{-- ── 1. Routing ── --}}
                    <div class="card-body pb-0">
                        <div class="d-flex align-items-center justify-content-between mb-5">
                            <p class="pac-section-label">Routing</p>
                        </div>

                        <div class="row g-5 mb-5">
                            <div class="col-md-6">
                                <div class="form-floating form-floating-outline">
                                    <select class="form-select @error('from_address') is-invalid @enderror"
                                            name="from_address" id="from_address" required>
                                        @foreach($fromAddresses as $addr)
                                            <option value="{{ $addr['address'] }}"
                                                {{ $addr['address'] === 'updates@thepacmedia.com' ? 'selected' : '' }}>
{{--                                                {{ $addr['name'] }}--}}
                                               {{ $addr['address'] }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <label for="from_address">From</label>
                                    @error('from_address')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
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

                    <hr class="my-0">

                    {{-- ── 2. Template ── --}}
                    <div class="card-body pb-0">
                        <p class="pac-section-label mb-5">Template</p>

                        <div class="row g-5 mb-5">
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
                                    <label for="email_type">
                                        Email Type
                                        <small class="text-muted fw-normal">(top-right tag)</small>
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-floating form-floating-outline">
                                    <input type="text" class="form-control"
                                           id="index_label" name="index_label"
                                           value="{{ old('index_label', '01 — Message') }}"
                                           placeholder="01 — Message">
                                    <label for="index_label">
                                        Index Label
                                        <small class="text-muted fw-normal">(above headline)</small>
                                    </label>
                                </div>
                            </div>
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

                        <div class="pac-hint mb-5">
                            <strong>Structure:</strong>
                            Index Label → Headline → Rule → Body → Detail Block → CTA → Note → Signature
                        </div>
                    </div>

                    <hr class="my-0">

                    {{-- ── 3. Body paragraphs ── --}}
                    <div class="card-body pb-0">
                        <div class="d-flex align-items-center justify-content-between mb-5">
                            <p class="pac-section-label">Body</p>
                            <button type="button" class="btn btn-primary btn-sm" id="add-para-btn">
                                <i class="ri ri-add-line icon-14px me-1"></i> Add Paragraph
                            </button>
                        </div>

                        {{-- Paragraph 1 — always present, no remove button --}}
                        <div class="mb-4" style="padding-right:0;">
                            <div class="form-floating form-floating-outline">
                                <textarea class="form-control @error('body_paragraphs.0') is-invalid @enderror"
                                          name="body_paragraphs[]"
                                          id="para-0"
                                          style="height:110px;"
                                          placeholder="First paragraph"
                                          required>{{ old('body_paragraphs.0') }}</textarea>
                                <label for="para-0">Paragraph 1</label>
                                @error('body_paragraphs.0')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        {{-- Extra paragraphs injected here --}}
                        <div id="extra-paras-container"></div>

                        {{-- Closing — always last, dashed --}}
                        <div class="pac-closing-wrap mb-5">
                            <p class="pac-closing-label">Closing</p>
                            <textarea class="form-control"
                                      name="body_paragraphs[]"
                                      style="height:80px;"
                                      placeholder="e.g. Looking forward to hearing from you.">{{ old('body_closing', 'Looking forward to hearing from you.') }}</textarea>
                        </div>
                    </div>

                    <hr class="my-0">

                    {{-- ── 4. Detail block ── --}}
                    <div class="card-body pb-0">
                        <div class="d-flex align-items-center justify-content-between mb-5">
                            <div>
                                <p class="pac-section-label">Detail Block</p>
                                <small class="text-muted">Key / value rows — reference, amount, date, etc.</small>
                            </div>
                            <button type="button" class="btn btn-outline-secondary btn-sm" id="add-detail-row">
                                <i class="ri ri-add-line me-1"></i> Add Row
                            </button>
                        </div>
                        <div id="detail-rows-container" class="mb-5"></div>
                    </div>

                    <hr class="my-0">

                    {{-- ── 5. CTA + Note ── --}}
                    <div class="card-body pb-0">
                        <p class="pac-section-label mb-5">Call to Action & Note</p>

                        <div class="row g-5 mb-5">
                            <div class="col-md-8">
                                <div class="form-floating form-floating-outline">
                                    <input type="url" class="form-control"
                                           id="cta_url" name="cta_url"
                                           value="{{ old('cta_url') }}"
                                           placeholder="https://thepacmedia.com">
                                    <label for="cta_url">
                                        Button URL
                                        <small class="text-muted fw-normal">(optional)</small>
                                    </label>
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

                        <div class="form-floating form-floating-outline mb-5">
                            <textarea class="form-control" id="note" name="note"
                                      style="height:80px;"
                                      placeholder="Italic note at the bottom of the email (optional)">{{ old('note') }}</textarea>
                            <label for="note">
                                Note / Aside
                                <small class="text-muted fw-normal">(optional, italic)</small>
                            </label>
                        </div>
                    </div>

                    <hr class="my-0">

                    {{-- ── 6. Signature ── --}}
                    <div class="card-body">
                        <p class="pac-section-label mb-1">Signature</p>
                        <p class="text-muted mb-5" style="font-size:0.82rem;">
                            Edit if sending on behalf of someone else.
                        </p>

                        <div class="row g-5">
                            <div class="col-md-6">
                                <div class="form-floating form-floating-outline">
                                    <input type="text" class="form-control"
                                           id="sig_name" name="sig_name"
                                           value="{{ old('sig_name', auth()->user()->name ?? 'Peter') }}"
                                           placeholder="Name">
                                    <label for="sig_name">Name</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating form-floating-outline">
                                    <input type="text" class="form-control"
                                           id="sig_role" name="sig_role"
                                           value="{{ old('sig_role', 'Founder, The Pacmedia') }}"
                                           placeholder="Role / Title">
                                    <label for="sig_role">Role / Title</label>
                                </div>
                            </div>
                        </div>

                        {{-- Live preview --}}
                        <div class="pac-sig-preview">
                            <div class="pac-sig-avatar"></div>
                            <div class="pac-sig-rule">
                                <p class="pac-sig-name" id="sig-preview-name">{{ auth()->user()->name ?? 'Peter' }}</p>
                                <p class="pac-sig-role" id="sig-preview-role">Founder, The Pacmedia</p>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
            {{-- /Left col --}}

            {{-- ════════════════════════════════════════
                 RIGHT — Sticky sidebar (col-3)
            ════════════════════════════════════════ --}}
            <div class="col-xl-3 col-md-4 col-12">
                <div class="pac-sidebar">

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

                    {{-- Attachments card --}}
                    <div class="card mb-5">
                        <div class="card-body">
                            <p class="pac-section-label mb-4">Attachments</p>

                            <div class="pac-dropzone" id="pac-dropzone">
                                <input type="file"
                                       id="attachments-input"
                                       multiple
                                       accept=".pdf,.doc,.docx,.xls,.xlsx,.ppt,.pptx,image/jpeg,image/png,image/gif,image/webp">
                                <div class="pac-dropzone-icon"><i class="ri ri-upload-cloud-2-line"></i></div>
                                <p class="pac-dropzone-label">Drop files or click to browse</p>
                                <p class="pac-dropzone-sub">PDF, Word, Excel, Images · Max 10MB each</p>
                            </div>

                            <div id="attachment-list"></div>
                        </div>
                    </div>

                    {{-- Checklist card --}}
                    <div class="card">
                        <div class="card-body">
                            <p class="pac-section-label mb-4">Before Sending</p>
                            <ul class="list-unstyled mb-0" style="font-size:0.8rem; color:#6b7280; line-height:2.2;">
                                <li><i class="ri ri-checkbox-circle-line me-2" style="color:#b5cc18;"></i>From address correct</li>
                                <li><i class="ri ri-checkbox-circle-line me-2" style="color:#b5cc18;"></i>Recipient verified</li>
                                <li><i class="ri ri-checkbox-circle-line me-2" style="color:#b5cc18;"></i>Subject line clear</li>
                                <li><i class="ri ri-checkbox-circle-line me-2" style="color:#b5cc18;"></i>Body reviewed</li>
                                <li><i class="ri ri-checkbox-circle-line me-2" style="color:#b5cc18;"></i>CTA URL tested</li>
                            </ul>
                        </div>
                    </div>

                </div>
            </div>
            {{-- /Right col --}}

        </div>
    </form>

    @push('page-js')
        <script>
            (function () {

                // ── Extra paragraph repeater ──────────────────────
                const extraContainer = document.getElementById('extra-paras-container');
                let paraIndex = 2; // para 1 exists, closing exists — extras start at 2

                document.getElementById('add-para-btn').addEventListener('click', function () {
                    const wrap = document.createElement('div');
                    wrap.className = 'pac-para-row';

                    const inner = document.createElement('div');
                    inner.className = 'form-floating form-floating-outline';

                    const ta = document.createElement('textarea');
                    ta.className   = 'form-control';
                    ta.name        = 'body_paragraphs[]';
                    ta.style.height = '110px';
                    ta.placeholder = 'Paragraph ' + paraIndex;
                    ta.id = 'para-extra-' + paraIndex;

                    const lbl = document.createElement('label');
                    lbl.setAttribute('for', ta.id);
                    lbl.textContent = 'Paragraph ' + paraIndex;

                    inner.appendChild(ta);
                    inner.appendChild(lbl);

                    const btn = document.createElement('button');
                    btn.type      = 'button';
                    btn.className = 'pac-para-remove';
                    btn.title     = 'Remove';
                    btn.innerHTML = '<i class="ri ri-close-line"></i>';
                    btn.addEventListener('click', function () {
                        wrap.remove();
                        renumber();
                    });

                    wrap.appendChild(inner);
                    wrap.appendChild(btn);
                    extraContainer.appendChild(wrap);
                    ta.focus();
                    paraIndex++;
                });

                function renumber() {
                    extraContainer.querySelectorAll('.pac-para-row').forEach(function (row, i) {
                        const n   = i + 2; // para 1 is fixed above
                        const ta  = row.querySelector('textarea');
                        const lbl = row.querySelector('label');
                        if (ta)  ta.placeholder  = 'Paragraph ' + n;
                        if (lbl) lbl.textContent = 'Paragraph ' + n;
                    });
                    paraIndex = extraContainer.querySelectorAll('.pac-para-row').length + 2;
                }

                // ── Detail rows repeater ──────────────────────────
                document.getElementById('add-detail-row').addEventListener('click', function () {
                    addDetailRow();
                });

                function addDetailRow(label, value) {
                    const container = document.getElementById('detail-rows-container');
                    const row = document.createElement('div');
                    row.className = 'pac-detail-row';
                    row.innerHTML = `
                <input type="text"
                       class="form-control form-control-sm"
                       name="detail_labels[]"
                       value="${label || ''}"
                       placeholder="Label e.g. Reference">
                <input type="text"
                       class="form-control form-control-sm"
                       name="detail_values[]"
                       value="${value || ''}"
                       placeholder="Value e.g. PCM-001">
                <button type="button" class="pac-remove-row" title="Remove">
                    <i class="ri ri-close-line"></i>
                </button>
            `;
                    row.querySelector('.pac-remove-row').addEventListener('click', () => row.remove());
                    container.appendChild(row);
                }

                // ── Live signature preview ────────────────────────
                document.getElementById('sig_name').addEventListener('input', function () {
                    document.getElementById('sig-preview-name').textContent = this.value || 'Your Name';
                });
                document.getElementById('sig_role').addEventListener('input', function () {
                    document.getElementById('sig-preview-role').textContent = this.value || 'Role, Company';
                });

                // ── Attachments ───────────────────────────────────
                let attachedFiles = [];
                const dropzone    = document.getElementById('pac-dropzone');
                const fileInput   = document.getElementById('attachments-input');
                const pillList    = document.getElementById('attachment-list');

                function fileIcon(name) {
                    const ext = name.split('.').pop().toLowerCase();
                    if (['jpg','jpeg','png','gif','webp'].includes(ext)) return 'ri-image-line';
                    if (ext === 'pdf')                                   return 'ri-file-pdf-line';
                    if (['doc','docx'].includes(ext))                    return 'ri-file-word-line';
                    if (['xls','xlsx'].includes(ext))                    return 'ri-file-excel-line';
                    if (['ppt','pptx'].includes(ext))                    return 'ri-file-ppt-line';
                    return 'ri-file-line';
                }

                function humanSize(b) {
                    if (b < 1024)    return b + ' B';
                    if (b < 1048576) return (b / 1024).toFixed(1) + ' KB';
                    return (b / 1048576).toFixed(1) + ' MB';
                }

                function renderPills() {
                    pillList.innerHTML = '';
                    attachedFiles.forEach(function (file, idx) {
                        const pill = document.createElement('div');
                        pill.className = 'pac-pill';
                        pill.innerHTML = `
                    <i class="ri ${fileIcon(file.name)} pac-pill-icon"></i>
                    <span class="pac-pill-name" title="${file.name}">${file.name}</span>
                    <span class="pac-pill-size">${humanSize(file.size)}</span>
                    <button type="button" class="pac-pill-remove" title="Remove">
                        <i class="ri ri-close-line"></i>
                    </button>
                `;
                        pill.querySelector('.pac-pill-remove').addEventListener('click', function () {
                            attachedFiles.splice(idx, 1);
                            renderPills();
                        });
                        pillList.appendChild(pill);
                    });
                }

                function addFiles(list) {
                    Array.from(list).forEach(function (f) {
                        if (!attachedFiles.some(x => x.name === f.name && x.size === f.size)) {
                            attachedFiles.push(f);
                        }
                    });
                    renderPills();
                    fileInput.value = '';
                }

                fileInput.addEventListener('change', () => addFiles(fileInput.files));
                dropzone.addEventListener('dragover',  e => { e.preventDefault(); dropzone.classList.add('dragover'); });
                dropzone.addEventListener('dragleave', ()  => dropzone.classList.remove('dragover'));
                dropzone.addEventListener('drop', function (e) {
                    e.preventDefault();
                    dropzone.classList.remove('dragover');
                    addFiles(e.dataTransfer.files);
                });

                // Inject files into form on submit via DataTransfer
                document.getElementById('pac-compose-form').addEventListener('submit', function () {
                    if (!attachedFiles.length) return;
                    const dt = new DataTransfer();
                    attachedFiles.forEach(f => dt.items.add(f));
                    const inp    = document.createElement('input');
                    inp.type     = 'file';
                    inp.name     = 'attachments[]';
                    inp.multiple = true;
                    inp.style.display = 'none';
                    Object.defineProperty(inp, 'files', { value: dt.files });
                    this.appendChild(inp);
                });

                // ── Auto-dismiss success alert ────────────────────
                document.querySelectorAll('.alert-success').forEach(function (el) {
                    setTimeout(() => el.remove(), 4000);
                });

            })();
        </script>
    @endpush

</x-admin-layout>
