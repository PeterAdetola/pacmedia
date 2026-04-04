@props([
    'animate' => false, // whether animation is enabled
])

<div class="bg-white shadow-md overflow-hidden sm:rounded-lg w-full">

    <!-- FORM CAP -->
    <div class="px-6 pt-6 pb-4 rounded-t-lg">
        {{ $cap ?? '' }}
    </div>

    <!-- GRADIENT BAR (EDGE-TO-EDGE) -->
    @php
        $hasErrors = $errors->any();
    @endphp

    <div
        class="auth-gradient-bar h-[2px] w-full transition-opacity duration-300
        {{ $hasErrors ? 'opacity-100 bg-gradient-to-r from-[#f3f4f6] via-red-600 to-[#f3f4f6]' : 'opacity-0 bg-gradient-to-r from-[#eef0f1] via-[#245624] to-[#eef0f1]' }}">
    </div>


    <!-- FORM BODY -->
    <div class="px-6 py-6 rounded-b-lg">
        {{ $slot }}
    </div>

</div>
