{{--
    Pacmedia Auth Card Component
    ─────────────────────────────
    Slots:
      $slot       — main form body (required)
      $cap        — optional top area: session status, intro heading
      $footer     — optional bottom area: secondary links

    Props:
      $cardClass  — extra classes on the outer card div (optional)

    Usage:
      <x-auth-card>
          <x-slot name="cap"> ... </x-slot>

          ... form content ...

          <x-slot name="footer"> ... </x-slot>
      </x-auth-card>
--}}

@props([
    'cardClass' => '',
])

<div class="card {{ $cardClass }}" style="border-radius: 0.625rem; overflow: hidden; box-shadow: 0 2px 8px rgba(0,0,0,0.08), 0 0 0 0.5px rgba(0,0,0,0.05); margin-bottom: 0;">

    {{-- Indeterminate progress bar --}}
    <div class="pac-progress idle" id="pac-preloader">
        <div class="pac-progress-bar"></div>
    </div>

    {{-- Cap slot: session status, heading, intro text --}}
    @if (!empty($cap))
        <div style="padding: 1.5rem 2rem 0;">
            {{ $cap }}
        </div>
    @endif

    {{-- Card body --}}
    <div class="card-body" style="padding: 1.5rem 2rem 1.6rem;">
        {{ $slot }}
    </div>

    {{-- Optional footer: divider + secondary links --}}
    @if (!empty($footer))
        <div style="border-top: 1px solid #f3f4f6; padding: 0.75rem 2rem;">
            {{ $footer }}
        </div>
    @endif

    {{-- Brand strip: peridot → metal → black --}}
    <div class="pac-strip"></div>

</div>
