<nav x-data="{ open: false }" class="bg-white border-b border-gray-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <div class="flex-shrink-0 flex items-center">
                    <a href="{{ route('admin.dashboard') }}">
                        <x-application-logo class="block h-10 w-auto fill-current text-gray-600" />
                    </a>
                </div>

                <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                    <x-nav-link :href="route('admin.dashboard')" :active="request()->routeIs('admin.dashboard')">
                        {{ __('Dashboard') }}
                    </x-nav-link>
                    <x-nav-link :href="route('admin.dashboard')" :active="request()->routeIs('admin.dashboard')">
                        {{ __('Dashboard') }}
                    </x-nav-link>
                    <x-nav-link :href="route('admin.users')" :active="request()->routeIs('admin.users')">
                        {{ __('Users') }}
                    </x-nav-link>
                    <x-nav-link :href="route('admin.roles')" :active="request()->routeIs('admin.roles')">
                        {{ __('Roles') }}
                    </x-nav-link>
                    <x-nav-link :href="route('admin.permissions')" :active="request()->routeIs('admin.permissions')">
                        {{ __('Permissions') }}
                    </x-nav-link>
                    <x-nav-link :href="route('admin.wilayas')" :active="request()->routeIs('admin.wilayas')">
                        {{ __('Wilayas') }}
                    </x-nav-link>
                    <x-nav-link :href="route('admin.moughataas')" :active="request()->routeIs('admin.moughataas')">
                        {{ __('Moughataas') }}
                    </x-nav-link>
                    <x-nav-link :href="route('admin.municipalities')" :active="request()->routeIs('admin.municipalities')">
                        {{ __('Municipalities') }}
                    </x-nav-link>
                    <x-nav-link :href="route('admin.neighbourhoods')" :active="request()->routeIs('admin.neighbourhood')">
                        {{ __('Neighbourhood') }}
                    </x-nav-link>
                    <x-nav-link :href="route('admin.infractions')" :active="request()->routeIs('admin.infractions')">
                        {{ __('Infractions') }}
                    </x-nav-link>
                    <x-nav-link :href="route('admin.consumers')" :active="request()->routeIs('admin.consumers')">
                        {{ __('Consumers') }}
                    </x-nav-link>
                    <x-nav-link :href="route('admin.merchants')" :active="request()->routeIs('admin.merchants')">
                        {{ __('Merchants') }}
                    </x-nav-link>
                    <x-nav-link :href="route('admin.entreprises')" :active="request()->routeIs('admin.entreprises')">
                        {{ __('Entreprises') }}
                    </x-nav-link>
                    <x-nav-link :href="route('admin.checkups')" :active="request()->routeIs('admin.checkups')">
                        Checkups
                    </x-nav-link>
                    <x-nav-link :href="route('admin.complaints')" :active="request()->routeIs('admin.complaints')">
                        {{ __('Complaints') }}
                    </x-nav-link>
                    <x-nav-link :href="route('admin.summons')" :active="request()->routeIs('admin.summons')">
                        {{ __('Summons') }}
                    </x-nav-link>
                    <x-nav-link :href="route('admin.fines')" :active="request()->routeIs('admin.fines')">
                        {{ __('Fines') }}
                    </x-nav-link>
                </div>
            </div>
            
            <div class="hidden sm:flex sm:items-center sm:ml-6">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="flex items-center text-sm font-medium text-gray-500 hover:text-gray-700 hover:border-gray-300 focus:outline-none focus:text-gray-700 focus:border-gray-300 transition duration-150 ease-in-out">
                            <div>{{ Auth::user()->name }}</div>
                            <div class="ml-1">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <x-dropdown-link :href="route('logout')"
                                    onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                {{ __('Log Out') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>
        </div>
    </div>
</nav>