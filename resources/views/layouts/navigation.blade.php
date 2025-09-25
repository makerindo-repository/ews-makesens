<nav x-data="{ open: false }" class="bg-primary border-b border-gray-100">
    <!-- Primary Navigation Menu -->
    <div class="md:max-w-7x xl:max-w-full mx-auto px-4 md:px-6 lg:px-8">
        <div class="flex justify-between items-center h-16">
            <div class="flex gap-2 py-2">
                <button @click="sideopen = ! sideopen"
                    class="max-md:hidden inline-flex items-center justify-center p-2 rounded-md text-white">
                    <svg class="h-7 w-7" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                    <p class="text-white font-semibold text-2xl ms-3">Early Warning System</p>
                </button>
            </div>

            <!-- Settings Dropdown -->
            <div class="hidden md:flex md:items-center md:ms-6">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button
                            class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-50">
                            {{-- <div>{{ Auth::user()->name }}</div> --}}
                            <img src="{{ Auth::user()->profile_picture ?? asset('images/default-user-avatar.png') }}"
                                alt="User Avatar" class="h-10 w-10 rounded-full object-cover">
                            {{-- <div class="ms-1">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg"
                                    viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                        clip-rule="evenodd" />
                                </svg>
                            </div> --}}
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.edit')">
                            <i class="fa-solid fa-user text-primary me-2"></i>
                            {{ __('Profile') }}
                        </x-dropdown-link>
                        
                        <x-dropdown-link :href="route('profile.edit')">
                            <i class="fa-solid fa-headset text-green-500 me-2"></i>
                            {{ __('Hubungi CS') }}
                        </x-dropdown-link>
                        
                        <x-dropdown-link :href="route('profile.edit')">
                            <i class="fa-solid fa-triangle-exclamation text-yellow-500 me-2"></i>
                            {{ __('Laporkan Bug') }}
                        </x-dropdown-link>

                        <!-- Authentication -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf

                            <x-dropdown-link :href="'#'" x-data=""
                                x-on:click.prevent="$dispatch('open-modal', 'sign-out')">
                                <i class="fa-solid fa-right-from-bracket text-red-600 me-2"></i>
                                {{ __('Sign Out') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            <!-- Hamburger -->
            <div class="-me-2 flex items-center md:hidden">
                <button @click="open = ! open"
                    class="inline-flex items-center justify-center p-2 rounded-md text-white">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{ 'hidden': open, 'inline-flex': !open }" class="inline-flex"
                            stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{ 'hidden': !open, 'inline-flex': open }" class="hidden" stroke-linecap="round"
                            stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{ 'block': open, 'hidden': !open }" class="block md:hidden">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                {{ __('Dashboard') }}
            </x-responsive-nav-link>

            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')">
                    {{ __('Profile') }}
                </x-responsive-nav-link>

                <!-- Authentication -->
                <x-responsive-nav-link :href="'#'" x-data=""
                    x-on:click.prevent="$dispatch('open-modal', 'sign-out')">
                    {{ __('Sign Out') }}
                </x-responsive-nav-link>
            </div>
        </div>
    </div>
</nav>
