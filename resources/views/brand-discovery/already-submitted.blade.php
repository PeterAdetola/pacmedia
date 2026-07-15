{{-- resources/views/brand-discovery/already-submitted.blade.php --}}
@extends('layouts.app')

@section('title', 'Brand Discovery — Already Received')

@php
    $metaTitle       = 'Brand Discovery — Already Received';
    $metaDescription = 'This discovery questionnaire has already been submitted.';
    $metaOgImage     = asset('img/og-image.jpg');
@endphp

@section('content')
    <section id="brand-discovery" class="inner inner-grid-bottom">
        <div class="inner__wrapper">
            <div class="container-fluid p-0">
                <div class="row g-0">
                    <div class="col-12 col-xl-2"></div>
                    <div class="col-12 col-xl-8">
                        <div class="inner__content d-flex flex-column align-items-start justify-content-center" style="min-height:60vh;">
                            <p class="bd-eyebrow">Brand Discovery</p>
                            <h1 class="bd-title animate-in-up">
                                Already <em>Received</em>
                            </h1>
                            <p class="bd-body">
                                Thanks{{ $discovery->name ? ', ' . $discovery->name : '' }} — we've already received your response
                                @if($discovery->brand_name)
                                    for <strong>{{ $discovery->brand_name }}</strong>
                                @endif
                                on {{ $discovery->submitted_at?->format('d M, Y') }}.
                            </p>
                            <p class="bd-body">If something needs to change, just reply to our last message and we'll sort it out directly.</p>
                        </div>
                    </div>
                    <div class="col-12 col-xl-2"></div>
                </div>
            </div>
        </div>
    </section>
@endsection
