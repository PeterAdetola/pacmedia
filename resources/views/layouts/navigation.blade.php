@php use App\Support\Initials; @endphp
<nav x-data="{ open: false }" class="w-full h-16 bg-white border-b border-gray-200">
    <div class="flex items-center justify-between h-full px-6">

        <!-- LEFT: Brand -->
        <div class="flex items-center gap-4">
            <!-- Mobile menu toggle (future sidebar) -->
            <button
                @click="open = !open"
                class="lg:hidden inline-flex items-center justify-center p-2 rounded-md
                       text-gray-500 hover:text-[#245624] hover:bg-gray-100
                       focus:outline-none focus:ring-2 focus:ring-[#245624]/40">
                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M4 6h16M4 12h16M4 18h16" />
                </svg>
            </button>

            <!-- Logo -->
            <a href="{{ route('dashboard') }}" class="flex items-center gap-2">
                <x-application-logo class="h-8 w-auto fill-current text-[#245624]" />
            </a>
        </div>

        <!-- RIGHT: User Menu -->
        <div class="flex items-center gap-4">
            <x-dropdown align="right" width="48">
                <x-slot name="trigger">
                    <div
                        class="w-9 h-9 rounded-full
         bg-[#245624]/10 text-[#245624]
         flex items-center justify-center
         text-sm font-semibold uppercase">
                        {{ Initials::fromName(Auth::user()->name) }}
                    </div>

                </x-slot>

                <x-slot name="content">
                    <!-- User identity -->
                    <div class="px-4 py-3">
                        <div class="flex items-center gap-3">


                            <div>
                                <div class="text-sm font-medium text-gray-900">
                                    {{ Auth::user()->name }}
                                </div>
                                <div class="text-xs text-gray-500">
                                    {{ Auth::user()->email }}
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="border-t border-gray-100"></div>

                    <x-dropdown-link :href="route('profile.edit')">
                        Profile
                    </x-dropdown-link>

                    <div class="border-t border-gray-100"></div>

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf

                        <x-dropdown-link
                            :href="route('logout')"
                            onclick="event.preventDefault(); this.closest('form').submit();"
                            class="text-red-600 hover:bg-red-50"
                        >
                            Log Out
                        </x-dropdown-link>
                    </form>
                </x-slot>

            </x-dropdown>
        </div>
    </div>

    <!-- Mobile Dropdown (optional future use) -->
    <div x-show="open" x-transition class="lg:hidden border-t border-gray-200 bg-white">
        <div class="px-6 py-4 space-y-2">
            <a href="{{ route('dashboard') }}"
               class="block text-sm text-gray-600 hover:text-[#245624]">
                Dashboard
            </a>
        </div>
    </div>
</nav>
