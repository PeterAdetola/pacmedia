{{--
    ════════════════════════════════════════════════════════════════
    pac-ui.blade.php  —  Universal Modal + Toast System
    Include once in admin.blade.php just before </body>

    Usage from any page JS:
    ────────────────────────────────────────────────────────────────
    // Confirmation dialog (returns a Promise)
    Pac.confirm({
        title:   'Archive client?',
        message: 'They can be restored later.',
        icon:    'warning',              // warning | danger | info | success
        confirm: 'Yes, Archive',
        cancel:  'Cancel',              // optional, default 'Cancel'
    }).then(() => {
        // user confirmed — run your action here
    });

    // Toast notifications
    Pac.toast.success('Client saved successfully.');
    Pac.toast.error('Something went wrong.');
    Pac.toast.info('Invoice marked as sent.');
    Pac.toast.warning('No items added yet.');
    ════════════════════════════════════════════════════════════════
--}}

{{-- ── Confirmation Modal ─────────────────────────────────────────── --}}
<div class="modal fade" id="pacConfirmModal" tabindex="-1" aria-hidden="true" data-bs-backdrop="static">
    <div class="modal-dialog modal-dialog-centered modal-simple" style="max-width: 420px;">
        <div class="modal-content">
            <div class="modal-body p-0">

                {{-- Icon --}}
                <div class="text-center mb-5" id="pac-confirm-icon-wrap">
                    <div class="d-inline-flex align-items-center justify-content-center rounded-circle mb-4"
                         id="pac-confirm-icon-circle"
                         style="width:72px; height:72px;">
                        <i id="pac-confirm-icon" style="font-size:2rem;"></i>
                    </div>
                    <h4 class="mb-1" id="pac-confirm-title"></h4>
                    <p class="mb-0" id="pac-confirm-message" style="font-size:0.875rem; color:#6b7280;"></p>
                </div>

                {{-- Buttons --}}
                <div class="d-flex gap-3 justify-content-center">
                    <button type="button"
                            class="btn btn-outline-secondary"
                            id="pac-confirm-cancel"
                            data-bs-dismiss="modal">
                        Cancel
                    </button>
                    <button type="button"
                            class="btn"
                            id="pac-confirm-ok">
                        Confirm
                    </button>
                </div>

            </div>
        </div>
    </div>
</div>
{{-- ── /Confirmation Modal ─────────────────────────────────────────── --}}

{{-- ── Toast Container ───────────────────────────────────────────────── --}}
<div id="pac-toast-container"
     class="toast-container position-fixed bottom-0 end-0 p-3"
     style="z-index: 11000;">
</div>
{{-- ── /Toast Container ────────────────────────────────────────────────── --}}

{{-- ── Pac UI Styles ──────────────────────────────────────────────────── --}}
<style>
    /* ── Confirmation modal icon circles ── */
    .pac-icon-warning { background: rgba(245,158,11,0.12); color: #b45309; }
    .pac-icon-danger  { background: rgba(239,68,68,0.12);  color: #b91c1c; }
    .pac-icon-success { background: rgba(34,197,94,0.12);  color: #15803d; }
    .pac-icon-info    { background: rgba(59,130,246,0.12); color: #1d4ed8; }

    /* ── Confirm button variants ── */
    .pac-btn-warning { background: #f59e0b; border-color: #f59e0b; color: #fff; }
    .pac-btn-warning:hover { background: #d97706; border-color: #d97706; color: #fff; }
    .pac-btn-danger  { background: #ef4444; border-color: #ef4444; color: #fff; }
    .pac-btn-danger:hover  { background: #dc2626; border-color: #dc2626; color: #fff; }
    .pac-btn-success { background: #22c55e; border-color: #22c55e; color: #fff; }
    .pac-btn-success:hover { background: #16a34a; border-color: #16a34a; color: #fff; }
    .pac-btn-info    { background: #3b82f6; border-color: #3b82f6; color: #fff; }
    .pac-btn-info:hover    { background: #2563eb; border-color: #2563eb; color: #fff; }

    /* ── Toast ── */
    .pac-toast {
        min-width: 300px;
        max-width: 380px;
        border-radius: 0.625rem;
        border: none;
        box-shadow: 0 8px 32px rgba(0,0,0,0.12);
        overflow: hidden;
    }
    .pac-toast .toast-body {
        display: flex;
        align-items: flex-start;
        gap: 10px;
        padding: 0.875rem 1rem;
        font-size: 0.84rem;
        color: #111827;
        background: #fff;
    }
    .pac-toast .pac-toast-icon {
        width: 32px;
        height: 32px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1rem;
        flex-shrink: 0;
        margin-top: 1px;
    }
    .pac-toast .pac-toast-text { flex: 1; min-width: 0; }
    .pac-toast .pac-toast-title {
        font-weight: 700;
        font-size: 0.82rem;
        margin-bottom: 1px;
    }
    .pac-toast .pac-toast-msg {
        font-size: 0.8rem;
        color: #6b7280;
        line-height: 1.4;
    }
    .pac-toast .btn-close {
        padding: 0.875rem;
        opacity: 0.4;
        flex-shrink: 0;
    }
    .pac-toast .btn-close:hover { opacity: 0.8; }

    /* Toast accent strip (left border via box-shadow) */
    .pac-toast-success .toast-body { box-shadow: inset 4px 0 0 #22c55e; }
    .pac-toast-error   .toast-body { box-shadow: inset 4px 0 0 #ef4444; }
    .pac-toast-warning .toast-body { box-shadow: inset 4px 0 0 #f59e0b; }
    .pac-toast-info    .toast-body { box-shadow: inset 4px 0 0 #3b82f6; }

    /* Toast icon colours */
    .pac-toast-success .pac-toast-icon { background: rgba(34,197,94,0.12);  color: #15803d; }
    .pac-toast-error   .pac-toast-icon { background: rgba(239,68,68,0.12);  color: #b91c1c; }
    .pac-toast-warning .pac-toast-icon { background: rgba(245,158,11,0.12); color: #b45309; }
    .pac-toast-info    .pac-toast-icon { background: rgba(59,130,246,0.12); color: #1d4ed8; }

    [data-bs-theme="dark"] .pac-toast .toast-body { background: #1f2937; color: #f9fafb; }
    [data-bs-theme="dark"] .pac-toast .pac-toast-msg { color: #9ca3af; }
</style>
{{-- ── /Pac UI Styles ──────────────────────────────────────────────────── --}}

{{-- ── Pac UI Script ──────────────────────────────────────────────────── --}}
<script>
    (function (global) {
        'use strict';

        /* ════════════════════════════════════════════
           ICON MAP
        ════════════════════════════════════════════ */
        const ICONS = {
            warning: 'ri ri-error-warning-line',
            danger:  'ri ri-delete-bin-7-line',
            success: 'ri ri-checkbox-circle-line',
            info:    'ri ri-information-line',
        };

        const TOAST_ICONS = {
            success: 'ri ri-checkbox-circle-line',
            error:   'ri ri-close-circle-line',
            warning: 'ri ri-error-warning-line',
            info:    'ri ri-information-line',
        };

        const TOAST_TITLES = {
            success: 'Success',
            error:   'Error',
            warning: 'Warning',
            info:    'Info',
        };

        /* ════════════════════════════════════════════
           CONFIRMATION MODAL
        ════════════════════════════════════════════ */
        let _resolve = null;

        const modalEl   = document.getElementById('pacConfirmModal');
        const bsModal   = modalEl ? new bootstrap.Modal(modalEl) : null;

        const elCircle  = document.getElementById('pac-confirm-icon-circle');
        const elIcon    = document.getElementById('pac-confirm-icon');
        const elTitle   = document.getElementById('pac-confirm-title');
        const elMsg     = document.getElementById('pac-confirm-message');
        const elOk      = document.getElementById('pac-confirm-ok');
        const elCancel  = document.getElementById('pac-confirm-cancel');

        /* Confirm button click → resolve promise + close */
        if (elOk) {
            elOk.addEventListener('click', function () {
                bsModal.hide();
                if (_resolve) { _resolve(true); _resolve = null; }
            });
        }

        /* Cancel / backdrop / ESC → resolve promise with false */
        if (modalEl) {
            modalEl.addEventListener('hidden.bs.modal', function () {
                if (_resolve) { _resolve(false); _resolve = null; }
            });
        }

        /**
         * Pac.confirm(options) → Promise<boolean>
         *
         * options = {
         *   title:   string,
         *   message: string,
         *   icon:    'warning' | 'danger' | 'success' | 'info',
         *   confirm: string,   // confirm button label
         *   cancel:  string,   // cancel button label (optional)
         * }
         */
        function confirm(opts) {
            if (!bsModal) {
                return Promise.resolve(window.confirm(opts.message || opts.title));
            }

            opts = Object.assign({ icon: 'warning', confirm: 'Confirm', cancel: 'Cancel' }, opts);

            /* Set icon */
            const iconCls = ICONS[opts.icon] || ICONS.warning;
            elCircle.className = 'pac-icon-' + opts.icon +
                ' d-inline-flex align-items-center justify-content-center rounded-circle mb-4';
            elCircle.style.cssText = 'width:72px; height:72px;';
            elIcon.className = iconCls;

            /* Set text */
            elTitle.textContent = opts.title || 'Are you sure?';
            elMsg.textContent   = opts.message || '';

            /* Set confirm button */
            elOk.textContent  = opts.confirm;
            elOk.className    = 'btn pac-btn-' + opts.icon;

            /* Set cancel button */
            elCancel.textContent = opts.cancel;

            /* Show */
            bsModal.show();

            return new Promise(function (resolve) {
                _resolve = resolve;
            });
        }

        /* ════════════════════════════════════════════
           TOAST
        ════════════════════════════════════════════ */
        const toastContainer = document.getElementById('pac-toast-container');

        function showToast(type, message, title, duration) {
            if (!toastContainer) return;

            title    = title    || TOAST_TITLES[type]  || 'Notice';
            duration = duration || (type === 'error' ? 6000 : 4000);

            const iconCls = TOAST_ICONS[type] || TOAST_ICONS.info;

            const wrapper = document.createElement('div');
            wrapper.innerHTML = `
            <div class="toast pac-toast pac-toast-${type} show align-items-center mb-2"
                 role="alert" aria-live="assertive" aria-atomic="true">
                <div class="toast-body">
                    <div class="pac-toast-icon">
                        <i class="${iconCls}" style="font-size:1rem;"></i>
                    </div>
                    <div class="pac-toast-text">
                        <div class="pac-toast-title">${title}</div>
                        <div class="pac-toast-msg">${message}</div>
                    </div>
                    <button type="button" class="btn-close ms-auto" aria-label="Close"></button>
                </div>
            </div>`;

            const toastEl = wrapper.firstElementChild;
            toastContainer.appendChild(toastEl);

            /* Close button */
            toastEl.querySelector('.btn-close').addEventListener('click', function () {
                dismissToast(toastEl);
            });

            /* Auto dismiss */
            const timer = setTimeout(function () { dismissToast(toastEl); }, duration);

            toastEl._pacTimer = timer;
        }

        function dismissToast(el) {
            clearTimeout(el._pacTimer);
            el.classList.remove('show');
            el.style.opacity = '0';
            el.style.transition = 'opacity 0.25s';
            setTimeout(function () { el.remove(); }, 260);
        }

        /* ════════════════════════════════════════════
           PUBLIC API  →  window.Pac
        ════════════════════════════════════════════ */
        global.Pac = {
            confirm: confirm,
            toast: {
                success: function (msg, title, duration) { showToast('success', msg, title, duration); },
                error:   function (msg, title, duration) { showToast('error',   msg, title, duration); },
                warning: function (msg, title, duration) { showToast('warning', msg, title, duration); },
                info:    function (msg, title, duration) { showToast('info',    msg, title, duration); },
            },
        };

    }(window));
</script>
{{-- ── /Pac UI Script ──────────────────────────────────────────────────── --}}
