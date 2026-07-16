{{-- resources/views/admin/brand-discoveries/edit.blade.php --}}
<x-admin-layout title="Edit — {{ $discovery->brand_name }}">

    @push('page-css')
        <style>
            .bd-edit-hint {
                background: rgba(181,204,24,.06); border: 1px solid rgba(181,204,24,.2);
                border-radius: .625rem; padding: 1rem 1.25rem; font-size: .82rem;
                color: #4b5563; margin-bottom: 2rem;
            }
            .bd-edit-source {
                background: var(--bs-tertiary-bg, #f9fafb); border: 1px solid var(--bs-border-color);
                border-radius: .5rem; padding: .875rem 1rem; font-size: .82rem;
                color: #4b5563; margin-bottom: 1rem; white-space: pre-line; line-height: 1.6;
            }
            .bd-edit-source-label { font-size: .7rem; font-weight: 700; text-transform: uppercase; letter-spacing: .06em; color: #9ca3af; margin-bottom: .4rem; }
            .bd-edit-trait-row { display:grid; grid-template-columns: 9rem 1fr 9rem; align-items:center; gap:1rem; margin-bottom: .5rem; }
            .bd-edit-trait-label { font-size: .82rem; color: #6b7280; }
            .bd-edit-trait-label--right { text-align: right; }
            .bd-edit-trait-slider { width: 100%; }
        </style>
    @endpush

    <x-slot name="actions">
        <a href="{{ route('admin.brand-discoveries.show', $discovery) }}" class="btn btn-sm btn-outline-secondary" style="font-size:.82rem;">
            <i class="ri ri-arrow-left-line"></i> Cancel
        </a>
    </x-slot>

    <div class="bd-edit-hint">
        <i class="ri ri-information-line"></i>
        Everything the client wrote is shown for reference only and can't be edited here — this screen only sets sliders and checkboxes based on their words. Their brief stays exactly as they submitted it.
    </div>

    <form method="POST" action="{{ route('admin.brand-discoveries.update', $discovery) }}">
        @csrf
        @method('PUT')

        {{-- ── All client free-text — read-only reference, grouped in one place ── --}}
        @php
            $writtenFields = [
                'persona'        => 'Ideal Client / Audience Persona',
                'competitors'    => 'Key Competitors',
                'differentiator' => 'Key Differentiator',
                'admired'        => 'Brands They Admire',
                'five_year'      => '5-Year Vision',
                'anything_else'  => 'Anything Else',
            ];
        @endphp
        @if(collect($writtenFields)->keys()->contains(fn($f) => filled($discovery->{$f})))
            <div class="card mb-4">
                <div class="card-body">
                    <h6 class="mb-1">Client's Written Responses</h6>
                    <p class="text-muted mb-3" style="font-size:.8rem;">Read-only — use these to set the sliders and chips below.</p>
                    @foreach($writtenFields as $field => $label)
                        @if($discovery->{$field})
                            <div class="bd-edit-source-label">{{ $label }}</div>
                            <div class="bd-edit-source">{{ $discovery->{$field} }}</div>
                        @endif
                    @endforeach
                </div>
            </div>
        @endif

        {{-- ── Tone & Values — sliders ──────────────────────────────── --}}
        <div class="card mb-4">
            <div class="card-body">
                <h6 class="mb-1">Tone &amp; Brand Values</h6>
                <p class="text-muted mb-4" style="font-size:.82rem;">
                    Set each slider based on how the client described their brand above.
                </p>

                @php
                    $traitLabels = [
                        'trait_playful_serious'            => ['Playful', 'Serious'],
                        'trait_approachable_elite'         => ['Approachable', 'Elite'],
                        'trait_casual_elegant'              => ['Casual', 'Elegant'],
                        'trait_simple_complex'              => ['Simple', 'Complex'],
                        'trait_classic_contemporary'        => ['Classic', 'Contemporary'],
                        'trait_unconventional_mainstream'   => ['Unconventional', 'Mainstream'],
                        'trait_industrial_natural'          => ['Industrial', 'Natural'],
                        'trait_feminine_masculine'          => ['Feminine', 'Masculine'],
                        'trait_youthful_established'        => ['Youthful', 'Established'],
                        'trait_subtle_bright'               => ['Subtle', 'Bright'],
                        'trait_friendly_authoritative'      => ['Friendly', 'Authoritative'],
                        'trait_economical_strong'           => ['Economical', 'Strong'],
                        'trait_empathetic_detached'         => ['Empathetic', 'Detached'],
                        'trait_compassionate_functional'    => ['Compassionate', 'Functional'],
                        'trait_diverse_niche'               => ['Diverse', 'Niche'],
                        'trait_local_global'                => ['Local', 'Global'],
                    ];
                @endphp

                @foreach($traitLabels as $key => [$left, $right])
                    @php $val = $discovery->traits[$key] ?? 0; @endphp
                    <div class="bd-edit-trait-row">
                        <span class="bd-edit-trait-label">{{ $left }}</span>
                        <input type="range" class="form-range bd-edit-trait-slider" name="{{ $key }}" min="-3" max="3" value="{{ $val }}">
                        <span class="bd-edit-trait-label bd-edit-trait-label--right">{{ $right }}</span>
                    </div>
                @endforeach
            </div>
        </div>

        {{-- ── Visual direction — checkboxes, prefilled ─────────────── --}}
        <div class="card mb-4">
            <div class="card-body">
                <h6 class="mb-3">Visual Direction</h6>

                <div class="mb-3">
                    <label class="form-label" style="font-size:.82rem;font-weight:600;">Colour Mood</label>
                    <div class="d-flex flex-wrap gap-2">
                        @foreach(['Monochrome','Warm Neutrals','Cool Blues','Earth Tones','Bold & Vibrant','Gold & Luxury','Pastel & Soft','Dark & Moody'] as $c)
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" name="colour[]" value="{{ $c }}" id="c_{{ $loop->index }}"
                                    {{ in_array($c, $discovery->colour ?? []) ? 'checked' : '' }}>
                                <label class="form-check-label" style="font-size:.8rem;" for="c_{{ $loop->index }}">{{ $c }}</label>
                            </div>
                        @endforeach
                    </div>
                </div>

                <div class="mb-0">
                    <label class="form-label" style="font-size:.82rem;font-weight:600;">Typography Feel</label>
                    <div class="d-flex flex-wrap gap-2">
                        @foreach(['Clean & Geometric','Serif & Editorial','Handcrafted & Script','Bold & Expressive','Minimal & Modern','Classic & Timeless'] as $t)
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" name="typography[]" value="{{ $t }}" id="t_{{ $loop->index }}"
                                    {{ in_array($t, $discovery->typography ?? []) ? 'checked' : '' }}>
                                <label class="form-check-label" style="font-size:.8rem;" for="t_{{ $loop->index }}">{{ $t }}</label>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        <button type="submit" class="btn" style="background:#b5cc18;font-weight:700;">
            <i class="ri ri-save-line"></i> Save Adjustments
        </button>
    </form>

</x-admin-layout>
