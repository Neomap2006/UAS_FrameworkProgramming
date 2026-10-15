<nav x-data="{ open: false }" class="bg-white border-b border-slate-200 sticky top-0 z-40 shadow-xs">
    <!-- Primary Navigation Menu -->
    <div class="px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16 pl-64 pr-4">
            <div class="flex items-center">
                <!-- Portal Brand / Header Title -->
                <div class="flex items-center gap-2">
                    <span class="inline-flex items-center justify-center w-8 h-8 rounded-lg bg-blue-600 text-white font-bold text-sm shadow-xs">
                        LP
                    </span>
                    <span class="text-base font-semibold text-slate-800 tracking-tight">
                        Portal Akademik & eKYC
                    </span>
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-6 sm:-my-px sm:ms-8 sm:flex">
                    <a href="{{ route('dashboard') }}"
                       class="inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium transition {{ request()->routeIs('dashboard') ? 'border-blue-600 text-blue-600' : 'border-transparent text-slate-500 hover:text-slate-700 hover:border-slate-300' }}">
                        Dashboard
                    </a>
                    <a href="{{ url('/') }}" target="_blank"
                       class="inline-flex items-center px-1 pt-1 border-b-2 border-transparent text-sm font-medium text-slate-500 hover:text-blue-600 hover:border-slate-300 transition">
                        Lihat Website ↗
                    </a>
                </div>
            </div>

            <!-- Settings Dropdown -->
            <div class="hidden sm:flex sm:items-center sm:ms-6">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center gap-2 px-3 py-1.5 border border-slate-200 text-sm font-medium rounded-full text-slate-700 bg-slate-50 hover:bg-slate-100 hover:border-slate-300 focus:outline-none transition ease-in-out duration-150">
                            <!-- User Avatar Placeholder -->
                            <div class="w-7 h-7 rounded-full bg-blue-600 text-white flex items-center justify-center text-xs font-bold uppercase shadow-xs">
                                {{ substr(Auth::user()->name, 0, 1) }}
                            </div>

                            <span class="font-medium text-slate-800">{{ Auth::user()->name }}</span>

                            <span class="text-xs px-2 py-0.5 rounded-full font-semibold bg-blue-100 text-blue-700">
                                {{ ucfirst(Auth::user()->role ?? 'Admin') }}
                            </span>

                            <svg class="h-4 w-4 text-slate-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                            </svg>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.edit')">
                            👤 {{ __('Profile') }}
                        </x-dropdown-link>

                        <!-- Authentication -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <x-dropdown-link :href="route('logout')"
                                    onclick="event.preventDefault(); this.closest('form').submit();"
                                    class="text-red-600 hover:text-red-700 hover:bg-red-50">
                                🚪 {{ __('Log Out') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            <!-- Hamburger (Mobile) -->
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-slate-500 hover:text-slate-700 hover:bg-slate-100 focus:outline-none transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu (Mobile) -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden bg-white border-b border-slate-200">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                {{ __('Dashboard') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="url('/')" target="_blank">
                {{ __('Lihat Website Publik') }}
            </x-responsive-nav-link>
        </div>

        <div class="pt-4 pb-3 border-t border-slate-200">
            <div class="px-4">
                <div class="font-medium text-base text-slate-800">{{ Auth::user()->name }}</div>
                <div class="font-medium text-sm text-slate-500">{{ Auth::user()->email }}</div>
            </div>

            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')">
                    {{ __('Profile') }}
                </x-responsive-nav-link>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <x-responsive-nav-link :href="route('logout')"
                            onclick="event.preventDefault(); this.closest('form').submit();">
                        {{ __('Log Out') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>
