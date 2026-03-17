{{--
    Materialize Auth Card Component
    --------------------------------
    Slots:
      $slot        — main form body
      $cap         — optional top area (session status, intro text)
      $footer      — optional bottom area (forgot password / register links)

    Props:
      $cardClass   — extra classes on the card div (optional)
--}}

@props([
    'cardClass' => '',
])

<div class="card border-radius-6 bg-opacity-8 {{ $cardClass }}" style="padding-top: 0;">

    {{-- Materialize indeterminate progress bar --}}
    <div class="progress collection">
        <div id="preloader" class="indeterminate" style="display:none; border: 2px #ebebeb solid;"></div>
    </div>

    {{-- Card cap — session status, intro text, etc. --}}
    @if (!empty($cap))
        <div style="padding: 1em 2em 0 2em;">
            {{ $cap }}
        </div>
    @endif

    {{-- Card body --}}
    <div style="padding: 0 2em 2em 2em;">
        {{ $slot }}
    </div>

    {{-- Card footer — divider + links row --}}
    @if (!empty($footer))
        <div class="divider"></div>
        <div style="padding: 0.5em 2em 0.5em 2em;">
            {{ $footer }}
        </div>
    @endif

</div>
