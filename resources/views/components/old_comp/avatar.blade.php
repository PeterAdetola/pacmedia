@props([
    'name' => '',
    'size' => 'md',
])

@php
    use App\Support\Initials;

    $sizes = [
        'sm' => 'w-8 h-8 text-xs',
        'md' => 'w-9 h-9 text-sm',
        'lg' => 'w-11 h-11 text-base',
    ];

    $sizeClass = $sizes[$size] ?? $sizes['md'];
@endphp

<div
    {{ $attributes->merge([
        'class' => "{$sizeClass} rounded-full
                   bg-[#245624]/10 text-[#245624]
                   flex items-center justify-center
                   font-semibold uppercase select-none"
    ]) }}
>
    {{ Initials::fromName($name) }}
</div>
