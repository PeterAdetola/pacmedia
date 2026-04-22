<footer class="content-footer footer bg-footer-theme">
    <div class="container-xxl">
        <div class="footer-container d-flex align-items-center justify-content-between py-4 flex-md-row flex-column gap-2">

            {{-- Left: copyright --}}
            <div style="font-size: 0.8125rem; color: #6b7280;">
                &copy; {{ date('Y') }}
                <a href="{{ url('/') }}"
                   target="_blank"
                   style="font-size: 0.8125rem; font-weight: 600; color: #6b7280; text-decoration: none; border-bottom: 1px solid #b5cc18; padding-bottom: 1px; transition: color 0.15s;"
                   onmouseover="this.style.color='#96aa12'"
                   onmouseout="this.style.color='#6b7280'">
                    The Pacmedia
                </a>
                &mdash; All rights reserved.
            </div>

            {{-- Right: tagline + nav links --}}
            <div class="d-none d-lg-flex align-items-center gap-4">
                <span style="font-size: 0.8125rem; color: #9ca3af;">
                    Forging Identity. Engineering Digital Infrastructure.
                </span>
                <div style="width: 1px; height: 12px; background: #e5e7eb;"></div>
                <div class="d-flex align-items-center gap-3">
                    <a href="{{ route('admin.settings.index') }}"
                       style="font-size: 0.8125rem; color: #9ca3af; text-decoration: none; transition: color 0.15s;"
                       onmouseover="this.style.color='#96aa12'"
                       onmouseout="this.style.color='#9ca3af'">Settings</a>
                    <a href="{{ route('admin.logs.index') }}"
                       style="font-size: 0.8125rem; color: #9ca3af; text-decoration: none; transition: color 0.15s;"
                       onmouseover="this.style.color='#96aa12'"
                       onmouseout="this.style.color='#9ca3af'">Activity Logs</a>
                    <a href="{{ url('/') }}"
                       target="_blank"
                       style="font-size: 0.8125rem; color: #9ca3af; text-decoration: none; transition: color 0.15s;"
                       onmouseover="this.style.color='#96aa12'"
                       onmouseout="this.style.color='#9ca3af'">Studio Site</a>
                </div>
            </div>

        </div>
    </div>
</footer>
