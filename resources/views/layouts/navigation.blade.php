<nav x-data="{ open: false }" class="bg-white border-b border-gray-100 shadow-sm">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}">
                        <span class="text-2xl font-black text-orange-500">ISI BURGER</span>
                    </a>
                </div>

                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                        📊 {{ __('Dashboard') }}
                    </x-nav-link>

                    <x-nav-link :href="route('burgers.index')" :active="request()->routeIs('burgers.index')">
                        🍔 {{ __('Menu Burgers') }}
                    </x-nav-link>

                    <x-nav-link :href="route('commandes.client')" :active="request()->routeIs('commandes.client')">
                        🛍️ {{ __('Mes Commandes') }}
                    </x-nav-link>

                    <x-nav-link :href="route('admin.commandes.index')" :active="request()->routeIs('admin.commandes.*')">
                        📦 {{ __('Admin Commandes') }}
                    </x-nav-link>
                </div>
            </div>

            <div class="hidden sm:flex sm:items-center sm:ms-6">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm font-bold rounded-md text-gray-500 bg-gray-50 hover:text-gray-700 transition">
                            <div>{{ Auth::user()->name }}</div>
                            <div class="ms-1 italic text-xs text-orange-500">(L3GL)</div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.edit')">
                            {{ __('Profil') }}
                        </x-dropdown-link>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <x-dropdown-link :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();">
                                {{ __('Déconnexion') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>
        </div>
    </div>
</nav>
