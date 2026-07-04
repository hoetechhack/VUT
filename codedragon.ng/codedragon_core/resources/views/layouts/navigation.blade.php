<nav x-data="{ open: false }" class="bg-[#0b0618]/60 backdrop-blur-xl border-b border-white/10 sticky top-0 z-50">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-20">
            <div class="flex">
                <!-- Logo -->
                    <a href="{{ route('dashboard') }}" class="no-underline group">
                        <x-logo height="77" />
                    </a>

                <!-- Navigation Links -->
                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" class="text-white font-bold hover:text-[#E11D2E] transition-all">
                        {{ __('Dashboard') }}
                    </x-nav-link>
                    <x-nav-link :href="route('admin.settings')" :active="request()->routeIs('admin.settings')" class="text-white font-bold hover:text-[#E11D2E] transition-all">
                        {{ __('API Settings') }}
                    </x-nav-link>
                    <x-nav-link :href="route('admin.pricing.index')" :active="request()->routeIs('admin.pricing.*')" class="text-white font-bold hover:text-[#E11D2E] transition-all">
                        {{ __('Pricing Engine') }}
                    </x-nav-link>
                    <x-nav-link :href="route('admin.broadcast.index')" :active="request()->routeIs('admin.broadcast.*')" class="text-white font-bold hover:text-[#E11D2E] transition-all">
                        {{ __('Broadcast') }}
                    </x-nav-link>
                    <x-nav-link :href="route('admin.users.index')" :active="request()->routeIs('admin.users.index')" class="text-white font-bold hover:text-[#E11D2E] transition-all">
                        {{ __('Users') }}
                    </x-nav-link>
                    <x-nav-link :href="route('admin.support.index')" :active="request()->routeIs('admin.support.index')" class="text-white font-bold hover:text-[#E11D2E] transition-all">
                        {{ __('Support') }}
                    </x-nav-link>
                </div>
            </div>

            @auth
            <!-- Settings Dropdown -->
            <div class="hidden sm:flex sm:items-center sm:ms-6">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center px-4 py-2 bg-white/5 border border-white/10 rounded-xl text-white font-black hover:bg-white/10 transition-all">
                            <div>{{ Auth::user()->name }}</div>
                            <div class="ms-2">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.edit')" class="font-bold">
                            {{ __('Profile') }}
                        </x-dropdown-link>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <x-dropdown-link :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();" class="font-bold text-red-400">
                                {{ __('Log Out') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>
            @endauth

            <!-- Hamburger -->
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="p-2 rounded-xl text-white hover:bg-white/10 transition-all">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden bg-[#0b0618] border-t border-white/10">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" class="text-white font-bold">
                {{ __('Dashboard') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('admin.pricing.index')" :active="request()->routeIs('admin.pricing.*')" class="text-white font-bold">
                {{ __('Pricing Engine') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('admin.broadcast.index')" :active="request()->routeIs('admin.broadcast.*')" class="text-white font-bold">
                {{ __('Broadcast') }}
            </x-responsive-nav-link>
        </div>

        @auth
        <div class="pt-4 pb-1 border-t border-white/10">
            <div class="px-4">
                <div class="font-black text-base text-white">{{ Auth::user()->name }}</div>
                <div class="font-bold text-sm text-gray-400">{{ Auth::user()->email }}</div>
            </div>
            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')" class="text-white font-bold">
                    {{ __('Profile') }}
                </x-responsive-nav-link>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <x-responsive-nav-link :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();" class="text-red-400 font-bold">
                        {{ __('Log Out') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
        @endauth
    </div>
</nav>
