{{--
    ┌─────────────────────────────────────────────────────────────────┐
    │  Pac Notifications — include once in admin.blade.php            │
    │  before </body>                                                  │
    │                                                                 │
    │  JS API (global, available on every admin page):                │
    │                                                                 │
    │  Toast (auto-dismisses):                                        │
    │    Pac.toast.success('Client created successfully.')            │
    │    Pac.toast.error('Something went wrong.')                     │
    │    Pac.toast.warning('This action cannot be undone.')           │
    │    Pac.toast.info('Invoice has been sent.')                     │
    │                                                                 │
    │  Confirm dialog (returns a Promise):                            │
    │    Pac.confirm({                                                 │
    │      title:   'Archive Client?',                                │
    │      message: 'They can be restored later.',                    │
    │      confirm: 'Archive',       // confirm button label          │
    │      cancel:  'Cancel',        // optional                      │
    │      type:    'danger',        // danger | warning | primary    │
    │    }).then(() => {                                               │
    │      // user clicked confirm                                    │
    │    });                                                           │
    └─────────────────────────────────────────────────────────────────┘
--}}

{{-- ── Toast container ──────────────────────────────────────────────── --}}
<div id="pac-toast-container"
     aria-live="polite"
     aria-atomic="true"
     style="
         position: fixed;
         top: 1.25rem;
         right: 1.25rem;
         z-index: 9999;
         display: flex;
         flex-direction: column;
         gap: 0.625rem;
         min-width: 300px;
         max-width: 380px;
     ">
</div>

{{-- ── Confirm modal ────────────────────────────────────────────────── --}}
<div class="modal fade" id="pac-confirm-modal" tabindex="-1" aria-hidden="true" data-bs-backdrop="static">
    <div class="modal-dialog modal-dialog-centered modal-simple" style="max-width: 420px;">
        <div class="modal-content">
            <div class="modal-body p-0">
                {{-- Icon --}}
                <div id="pac-confirm-icon-wrap"
                     class="d-flex align-items-center justify-content-center mx-auto mb-5"
                     style="width:56px; height:56px; border-radius:14px;">
                    <i id="pac-confirm-icon" class="icon-base ri icon-28px"></i>
                </div>

                {{-- Text --}}
                <div class="text-center mb-6">
                    <h4 class="mb-2" id="pac-confirm-title">Are you sure?</h4>
                    <p class="mb-0" id="pac-confirm-message"></p>
                </div>

                {{-- Actions --}}
                <div class="d-flex justify-content-center gap-3">
                    <button type="button"
                            id="pac-confirm-cancel"
                            class="btn btn-outline-secondary">
                        Cancel
                    </button>
                    <button type="button"
                            id="pac-confirm-ok"
                            class="btn btn-danger">
                        Confirm
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    /* ── Toast ── */
    .pac-toast {
        display: flex;
        align-items: flex-start;
        gap: 0.75rem;
        background: #fff;
        border-radius: 0.625rem;
        box-shadow: 0 4px 24px rgba(0,0,0,0.10), 0 1.5px 6px rgba(0,0,0,0.06);
        padding: 0.875rem 1rem;
        border-left: 4px solid transparent;
        animation: pacToastIn 0.22s cubic-bezier(.4,0,.2,1);
        position: relative;
        overflow: hidden;
    }
    .pac-toast.is-hiding {
        animation: pacToastOut 0.22s cubic-bezier(.4,0,.2,1) forwards;
    }

    /* Colour variants */
    .pac-toast--success { border-left-color: #22c55e; }
    .pac-toast--error   { border-left-color: #ef4444; }
    .pac-toast--warning { border-left-color: #f59e0b; }
    .pac-toast--info    { border-left-color: #3b82f6; }

    .pac-toast__icon {
        flex-shrink: 0;
        width: 32px;
        height: 32px;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1rem;
    }
    .pac-toast--success .pac-toast__icon { background: rgba(34,197,94,0.12);  color: #16a34a; }
    .pac-toast--error   .pac-toast__icon { background: rgba(239,68,68,0.12);  color: #dc2626; }
    .pac-toast--warning .pac-toast__icon { background: rgba(245,158,11,0.12); color: #d97706; }
    .pac-toast--info    .pac-toast__icon { background: rgba(59,130,246,0.12); color: #2563eb; }

    .pac-toast__body { flex: 1; min-width: 0; }
    .pac-toast__title {
        font-size: 0.84rem;
        font-weight: 600;
        color: #111827;
        margin-bottom: 0.1rem;
    }
    .pac-toast__msg {
        font-size: 0.78rem;
        color: #6b7280;
        line-height: 1.4;
    }
    .pac-toast__close {
        flex-shrink: 0;
        background: none;
        border: none;
        padding: 0;
        cursor: pointer;
        color: #9ca3af;
        font-size: 1rem;
        line-height: 1;
        transition: color 0.15s;
    }
    .pac-toast__close:hover { color: #374151; }

    /* Progress bar */
    .pac-toast__progress {
        position: absolute;
        bottom: 0; left: 0;
        height: 3px;
        border-radius: 0 0 0 4px;
        transform-origin: left;
        animation: pacProgress linear forwards;
    }
    .pac-toast--success .pac-toast__progress { background: #22c55e; }
    .pac-toast--error   .pac-toast__progress { background: #ef4444; }
    .pac-toast--warning .pac-toast__progress { background: #f59e0b; }
    .pac-toast--info    .pac-toast__progress { background: #3b82f6; }

    @keyframes pacToastIn {
        from { opacity: 0; transform: translateX(1.5rem); }
        to   { opacity: 1; transform: translateX(0); }
    }
    @keyframes pacToastOut {
        from { opacity: 1; transform: translateX(0); max-height: 120px; margin-bottom: 0; }
        to   { opacity: 0; transform: translateX(1.5rem); max-height: 0; margin-bottom: -0.625rem; }
    }
    @keyframes pacProgress {
        from { transform: scaleX(1); }
        to   { transform: scaleX(0); }
    }

    /* ── Confirm modal icon wraps ── */
    .pac-confirm-icon--danger  { background: rgba(239,68,68,0.12);  color: #dc2626; }
    .pac-confirm-icon--warning { background: rgba(245,158,11,0.12); color: #d97706; }
    .pac-confirm-icon--primary { background: rgba(181,204,24,0.12); color: #96aa12; }

    /* Dark mode */
    [data-bs-theme="dark"] .pac-toast {
        background: #1f2937;
        box-shadow: 0 4px 24px rgba(0,0,0,0.3);
    }
    [data-bs-theme="dark"] .pac-toast__title { color: #f9fafb; }
    [data-bs-theme="dark"] .pac-toast__msg   { color: #9ca3af; }
    [data-bs-theme="dark"] .pac-toast__close:hover { color: #e5e7eb; }
</style>

<script>
    window.Pac = window.Pac || {};

    /* ─────────────────────────────────────────
       TOAST
    ───────────────────────────────────────── */
    (function () {
        const DURATION = 4500; // ms before auto-dismiss

        const VARIANTS = {
            success: { icon: 'ri-checkbox-circle-line',  title: 'Success'  },
            error:   { icon: 'ri-close-circle-line',     title: 'Error'    },
            warning: { icon: 'ri-error-warning-line',    title: 'Warning'  },
            info:    { icon: 'ri-information-line',      title: 'Info'     },
        };

        function show(type, message, title) {
            const v       = VARIANTS[type] || VARIANTS.info;
            const label   = title || v.title;
            const container = document.getElementById('pac-toast-container');

            const el = document.createElement('div');
            el.className = `pac-toast pac-toast--${type}`;
            el.innerHTML = `
                <div class="pac-toast__icon"><i class="ri ${v.icon}"></i></div>
                <div class="pac-toast__body">
                    <div class="pac-toast__title">${label}</div>
                    <div class="pac-toast__msg">${message}</div>
                </div>
                <button class="pac-toast__close" aria-label="Dismiss">
                    <i class="ri ri-close-line"></i>
                </button>
                <div class="pac-toast__progress" style="animation-duration:${DURATION}ms;"></div>
            `;

            container.appendChild(el);

            const dismiss = () => {
                el.classList.add('is-hiding');
                el.addEventListener('animationend', () => el.remove(), { once: true });
            };

            el.querySelector('.pac-toast__close').addEventListener('click', dismiss);
            setTimeout(dismiss, DURATION);
        }

        Pac.toast = {
            success: (msg, title) => show('success', msg, title),
            error:   (msg, title) => show('error',   msg, title),
            warning: (msg, title) => show('warning', msg, title),
            info:    (msg, title) => show('info',    msg, title),
        };

        /* Backwards-compat shims — replaces toastr calls */
        window.toastr = {
            success: Pac.toast.success,
            error:   Pac.toast.error,
            warning: Pac.toast.warning,
            info:    Pac.toast.info,
        };
    })();

    /* ─────────────────────────────────────────
       CONFIRM DIALOG
    ───────────────────────────────────────── */
    (function () {
        const ICONS = {
            danger:  { icon: 'ri-delete-bin-6-line',  cls: 'pac-confirm-icon--danger'  },
            warning: { icon: 'ri-error-warning-line', cls: 'pac-confirm-icon--warning' },
            primary: { icon: 'ri-question-line',      cls: 'pac-confirm-icon--primary' },
        };

        const modalEl  = document.getElementById('pac-confirm-modal');
        const bsModal  = new bootstrap.Modal(modalEl);
        const titleEl  = document.getElementById('pac-confirm-title');
        const msgEl    = document.getElementById('pac-confirm-message');
        const okBtn    = document.getElementById('pac-confirm-ok');
        const cancelBtn= document.getElementById('pac-confirm-cancel');
        const iconWrap = document.getElementById('pac-confirm-icon-wrap');
        const iconEl   = document.getElementById('pac-confirm-icon');

        let _resolve, _reject;

        /* Clean up any previous listener before adding a new one */
        let _okHandler = null;

        Pac.confirm = function ({ title = 'Are you sure?', message = '', confirm = 'Confirm', cancel = 'Cancel', type = 'danger' } = {}) {
            return new Promise((resolve, reject) => {
                _resolve = resolve;
                _reject  = reject;

                const v = ICONS[type] || ICONS.danger;

                titleEl.textContent   = title;
                msgEl.textContent     = message;
                okBtn.textContent     = confirm;
                cancelBtn.textContent = cancel;
                okBtn.className       = `btn btn-${type}`;

                /* Icon */
                iconWrap.className = `d-flex align-items-center justify-content-center mx-auto mb-5 ${v.cls}`;
                iconEl.className   = `icon-base ri ${v.icon} icon-28px`;

                /* Remove previous ok handler */
                if (_okHandler) okBtn.removeEventListener('click', _okHandler);
                _okHandler = function () {
                    bsModal.hide();
                    resolve();
                };
                okBtn.addEventListener('click', _okHandler, { once: true });

                bsModal.show();
            });
        };

        /* Reject promise on cancel / backdrop dismiss */
        cancelBtn.addEventListener('click', () => {
            bsModal.hide();
            if (_reject) _reject();
        });
        modalEl.addEventListener('hidden.bs.modal', () => {
            if (_reject) _reject();
            _resolve = _reject = null;
        });
    })();
</script>
