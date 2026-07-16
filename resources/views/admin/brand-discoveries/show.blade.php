{{-- resources/views/admin/brand-discoveries/show.blade.php --}}
<x-admin-layout title="Discovery — {{ $discovery->brand_name }}">

    @push('page-css')
        <style>
            .bd-detail-section { border-top: 1px solid var(--bs-border-color); padding: 1.75rem 0; }
            .bd-detail-section:first-child { border-top: none; padding-top: 0; }
            .bd-detail-label { font-size: 0.72rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.07em; color: #9ca3af; margin-bottom: 0.4rem; }
            .bd-detail-value { font-size: 0.9rem; color: var(--bs-heading-color,#111827); line-height: 1.6; white-space: pre-line; }
            .bd-detail-value.muted { color: #9ca3af; font-style: italic; }
            .bd-chip { display:inline-block; font-size:0.75rem; font-weight:600; padding:0.3rem 0.8rem; border-radius:100px; background:rgba(181,204,24,.1); color:#96aa12; margin:0 0.4rem 0.4rem 0; }
            .bd-trait-bar-row { display:grid; grid-template-columns: 9rem 1fr 9rem; align-items:center; gap:1rem; margin-bottom:0.9rem; }
            .bd-trait-bar-label { font-size:0.78rem; color:#6b7280; }
            .bd-trait-bar-label--right { text-align:right; }
            .bd-trait-track { position:relative; height:4px; background:var(--bs-border-color); border-radius:4px; }
            .bd-trait-dot { position:absolute; top:50%; width:12px; height:12px; border-radius:50%; background:#b5cc18; transform:translate(-50%,-50%); box-shadow:0 0 0 3px #fff; }
            .bd-side-card { border-radius:0.625rem; }
            .bd-side-label { font-size:0.72rem; font-weight:700; text-transform:uppercase; letter-spacing:0.06em; color:#9ca3af; margin-bottom:0.5rem; }
        </style>
    @endpush

    <x-slot name="actions">
        <a href="{{ route('admin.brand-discoveries.index') }}" class="btn btn-sm btn-outline-secondary" style="font-size:.82rem;">
            <i class="ri ri-arrow-left-line"></i> Back
        </a>
    </x-slot>

    <div class="row">
        {{-- ── Main content ─────────────────────────────────────── --}}
        <div class="col-12 col-lg-8">
            <div class="card mb-4">
                <div class="card-body">

                    {{-- About --}}
                    <div class="bd-detail-section">
                        <h5 class="mb-3">{{ $discovery->brand_name }}</h5>
                        <div class="row g-3">
                            <div class="col-sm-6">
                                <div class="bd-detail-label">Contact Name</div>
                                <div class="bd-detail-value">{{ $discovery->name }}</div>
                            </div>
                            <div class="col-sm-6">
                                <div class="bd-detail-label">Email</div>
                                <div class="bd-detail-value">
                                    <a href="mailto:{{ $discovery->email }}">{{ $discovery->email }}</a>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="bd-detail-label">Industry</div>
                                <div class="bd-detail-value {{ $discovery->industry ? '' : 'muted' }}">{{ $discovery->industry ?: 'Not specified' }}</div>
                            </div>
                            <div class="col-sm-6">
                                <div class="bd-detail-label">Existing Brand?</div>
                                <div class="bd-detail-value {{ $discovery->existing_brand ? '' : 'muted' }}">{{ $discovery->existing_brand ?: 'Not specified' }}</div>
                            </div>
                            @if($discovery->brand_description)
                                <div class="col-12">
                                    <div class="bd-detail-label">One-Sentence Description</div>
                                    <div class="bd-detail-value">{{ $discovery->brand_description }}</div>
                                </div>
                            @endif
                        </div>
                    </div>

                    {{-- Audience --}}
                    <div class="bd-detail-section">
                        <div class="bd-detail-label mb-2">Audience Profile</div>
                        <div class="bd-detail-value {{ $discovery->persona ? '' : 'muted' }} mb-3">
                            {{ $discovery->persona ?: 'No persona description provided.' }}
                        </div>
                        @if($discovery->age_min !== null || $discovery->age_max !== null)
                            <div class="mb-2">
                                <span class="bd-detail-label d-inline">Age Range: </span>
                                <span class="bd-detail-value d-inline">{{ $discovery->age_min ?? '—' }}–{{ $discovery->age_max ?? '—' }}</span>
                            </div>
                        @endif
                        @if(!empty($discovery->profile))
                            <div>
                                @foreach($discovery->profile as $p)
                                    <span class="bd-chip">{{ $p }}</span>
                                @endforeach
                            </div>
                        @endif
                    </div>

                    {{-- Tone & Values --}}
                    @if(!empty(array_filter($discovery->traits ?? [])))
                        <div class="bd-detail-section">
                            <div class="bd-detail-label mb-3">Tone &amp; Brand Values</div>
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
                                @if($val != 0)
                                    <div class="bd-trait-bar-row">
                                        <span class="bd-trait-bar-label">{{ $left }}</span>
                                        <div class="bd-trait-track">
                                            <div class="bd-trait-dot" style="left: {{ (($val + 3) / 6) * 100 }}%;"></div>
                                        </div>
                                        <span class="bd-trait-bar-label bd-trait-bar-label--right">{{ $right }}</span>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    @endif

                    {{-- Visual Direction --}}
                    @if(!empty($discovery->colour) || !empty($discovery->typography) || !empty($discovery->touchpoints))
                        <div class="bd-detail-section">
                            <div class="bd-detail-label mb-2">Visual Direction</div>
                            @if(!empty($discovery->colour))
                                <div class="mb-2">
                                    <span class="bd-detail-label d-block mb-1" style="font-size:.68rem;">Colour Mood</span>
                                    @foreach($discovery->colour as $c) <span class="bd-chip">{{ $c }}</span> @endforeach
                                </div>
                            @endif
                            @if(!empty($discovery->typography))
                                <div class="mb-2">
                                    <span class="bd-detail-label d-block mb-1" style="font-size:.68rem;">Typography</span>
                                    @foreach($discovery->typography as $t) <span class="bd-chip">{{ $t }}</span> @endforeach
                                </div>
                            @endif
                            @if(!empty($discovery->touchpoints))
                                <div>
                                    <span class="bd-detail-label d-block mb-1" style="font-size:.68rem;">Touchpoints</span>
                                    @foreach($discovery->touchpoints as $t) <span class="bd-chip">{{ $t }}</span> @endforeach
                                </div>
                            @endif
                        </div>
                    @endif

                    {{-- Competitive Context --}}
                    @if($discovery->competitors || $discovery->differentiator || $discovery->admired)
                        <div class="bd-detail-section">
                            <div class="bd-detail-label mb-2">Competitive Context</div>
                            @if($discovery->competitors)
                                <div class="mb-3"><span class="bd-detail-label d-block" style="font-size:.68rem;">Competitors</span><div class="bd-detail-value">{{ $discovery->competitors }}</div></div>
                            @endif
                            @if($discovery->differentiator)
                                <div class="mb-3"><span class="bd-detail-label d-block" style="font-size:.68rem;">Differentiator</span><div class="bd-detail-value">{{ $discovery->differentiator }}</div></div>
                            @endif
                            @if($discovery->admired)
                                <div><span class="bd-detail-label d-block" style="font-size:.68rem;">Admired Brands</span><div class="bd-detail-value">{{ $discovery->admired }}</div></div>
                            @endif
                        </div>
                    @endif

                    {{-- Ambition --}}
                    @if($discovery->five_year || $discovery->anything_else)
                        <div class="bd-detail-section">
                            <div class="bd-detail-label mb-2">Brand Ambition</div>
                            @if($discovery->five_year)
                                <div class="mb-3"><span class="bd-detail-label d-block" style="font-size:.68rem;">5-Year Vision</span><div class="bd-detail-value">{{ $discovery->five_year }}</div></div>
                            @endif
                            @if($discovery->anything_else)
                                <div><span class="bd-detail-label d-block" style="font-size:.68rem;">Anything Else</span><div class="bd-detail-value">{{ $discovery->anything_else }}</div></div>
                            @endif
                        </div>
                    @endif

                </div>
            </div>
        </div>

        {{-- ── Sidebar ──────────────────────────────────────────── --}}
        <div class="col-12 col-lg-4">
            <div class="card bd-side-card mb-4">
                <div class="card-body">
                    <div class="bd-side-label">Status</div>
                    <span class="pac-pill p-{{ $discovery->status }}" style="font-size:.75rem;padding:5px 12px;">{{ ucfirst($discovery->status) }}</span>

                    <div class="d-flex flex-column gap-2 mt-4">
                        @if($discovery->status !== 'reviewed')
                            <button type="button" class="btn btn-sm btn-outline-success bd-status-btn" data-id="{{ $discovery->id }}" data-status="reviewed">
                                <i class="ri ri-checkbox-circle-line"></i> Mark Reviewed
                            </button>
                        @endif
                        @if($discovery->status !== 'archived')
                            <button type="button" class="btn btn-sm btn-outline-secondary bd-status-btn" data-id="{{ $discovery->id }}" data-status="archived">
                                <i class="ri ri-archive-line"></i> Archive
                            </button>
                        @endif
                        @if($discovery->isExpired())
                            <button type="button" class="btn btn-sm btn-outline-primary bd-renew-btn" data-id="{{ $discovery->id }}">
                                <i class="ri ri-refresh-line"></i> Renew Link
                            </button>
                        @elseif(!$discovery->isSubmitted() && $discovery->token)
                            <button type="button" class="btn btn-sm btn-outline-secondary bd-expire-btn" data-id="{{ $discovery->id }}">
                                <i class="ri ri-time-line"></i> Expire Now
                            </button>
                        @endif
                        @if($discovery->admin_adjusted)
                            <span class="pac-pill" style="background:rgba(59,130,246,.1);color:#1d4ed8;margin-left:.5rem;">
                                Adjusted {{ $discovery->admin_adjusted_at->diffForHumans() }}
                            </span>
                        @endif
                        <button type="button" class="btn btn-sm btn-outline-danger bd-delete-btn" data-id="{{ $discovery->id }}">
                            <i class="ri ri-delete-bin-line"></i> Delete Submission
                        </button>
                    </div>
                </div>
            </div>

            <div class="card bd-side-card mb-4">
                <div class="card-body">
                    <div class="bd-side-label">Urgency</div>
                    <p class="mb-0" style="font-size:.85rem;">{{ $discovery->urgency ?: 'Not specified' }}</p>
                </div>
            </div>

            <div class="card bd-side-card">
                <div class="card-body">
                    <div class="bd-side-label">Submitted</div>
                    <p class="mb-1" style="font-size:.85rem;">{{ $discovery->created_at->format('d M Y, h:i A') }}</p>
                    @if($discovery->client_token)
                        <div class="bd-side-label mt-3">Client Token</div>
                        <p class="mb-0" style="font-size:.85rem;">{{ $discovery->client_token }}</p>
                    @endif
                </div>
            </div>
        </div>
    </div>

    @push('page-js')
        <script>
            $(document).on('click', '.bd-expire-btn', function () {
                const id = $(this).data('id');

                Pac.confirm({
                    title:   'Expire this link now?',
                    message: 'The client won\'t be able to open it until you renew it.',
                    confirm: 'Expire Now',
                    type:    'warning',
                }).then(() => {
                    $.ajax({
                        url: `/admin/brand-discoveries/${id}/expire`,
                        method: 'POST',
                        data: { _token: '{{ csrf_token() }}', _method: 'PATCH' },
                        success: function (res) {
                            if (res.success) {
                                Pac.toast.success(res.message);
                                setTimeout(() => location.reload(), 700);
                            } else {
                                Pac.toast.error(res.message);
                            }
                        },
                        error: () => Pac.toast.error('Could not expire link.')
                    });
                });
            });

            $(document).on('click', '.bd-status-btn', function () {
                const id     = $(this).data('id');
                const status = $(this).data('status');

                $.ajax({
                    url: `/admin/brand-discoveries/${id}/status`,
                    method: 'POST',
                    data: { _token: '{{ csrf_token() }}', _method: 'PATCH', status },
                    success: function (res) {
                        if (res.success) { Pac.toast.success(res.message); setTimeout(() => location.reload(), 700); }
                    },
                    error: () => Pac.toast.error('Could not update status.')
                });
            });

            $(document).on('click', '.bd-delete-btn', function () {
                const id = $(this).data('id');
                Pac.confirm({
                    title: 'Delete Submission?', message: 'This cannot be undone.', confirm: 'Delete', type: 'danger',
                }).then(() => {
                    $.ajax({
                        url: `/admin/brand-discoveries/${id}`,
                        method: 'POST',
                        data: { _token: '{{ csrf_token() }}', _method: 'DELETE' },
                        success: function (res) {
                            if (res.success) {
                                Pac.toast.success(res.message);
                                setTimeout(() => window.location.href = '{{ route("admin.brand-discoveries.index") }}', 700);
                            }
                        },
                        error: () => Pac.toast.error('Could not delete submission.')
                    });
                });
            });
        </script>
    @endpush

</x-admin-layout>
