{{-- resources/views/brand-discovery/expired.blade.php --}}
@extends('layouts.app')

@section('title', 'Brand Discovery — Link Expired')

@php
    $metaTitle       = 'Brand Discovery — Link Expired';
    $metaDescription = 'This discovery link has expired.';
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
                                Link <em>Expired</em>
                            </h1>
                            <p class="bd-body">
                                This discovery link{{ $discovery->name ? ' for ' . $discovery->name : '' }} is no longer active.
                                Reach out and we'll send you a fresh one right away.
                            </p>
                        </div>
                    </div>
                    <div class="col-12 col-xl-2"></div>
                </div>
            </div>
        </div>
    </section>
@endsection
