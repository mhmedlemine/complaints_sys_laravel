<div class="flex items-center space-x-4">
    <div class="relative" x-data="{ open: false }" style="margin-left:20px; margin-right:20px;">
        <button @click="open = !open" class="flex items-center text-gray-600 hover:text-gray-700 focus:outline-none">
            <span class="text-sm font-medium">
                @if(app()->getLocale() == 'en')
                English
                @elseif(app()->getLocale() == 'fr')
                Français
                @else
                العربية
                @endif
            </span>
            <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
            </svg>
        </button>

        <div x-show="open"
            @click.away="open = false"
            class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1"
            style="display: none;">
            <a href="{{ route('language.switch', 'ar') }}"
                class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 {{ app()->getLocale() == 'ar' ? 'bg-gray-100' : '' }}">
                العربية
            </a>
            <a href="{{ route('language.switch', 'fr') }}"
                class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 {{ app()->getLocale() == 'fr' ? 'bg-gray-100' : '' }}">
                Français
            </a>
            <a href="{{ route('language.switch', 'en') }}"
                class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 {{ app()->getLocale() == 'en' ? 'bg-gray-100' : '' }}">
                English
            </a>
        </div>
    </div>

    <!-- Existing User Menu -->
    <div x-data="{ isOpen: false }" class="relative">
        <button @click="isOpen = !isOpen" class="flex items-center space-x-2 relative focus:outline-none">
            <h2 class="text-gray-700 font-semibold">{{ Auth::user()->name }}</h2>
            <!-- <img class="h-9 w-9 rounded-full border-2 border-purple-500 object-cover" src="https://images.unsplash.com/photo-1553267751-1c148a7280a1?ixid=MXwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHw%3D&ixlib=rb-1.2.1&auto=format&fit=crop&w=634&q=80" alt="User avatar"> -->
        </button>

        <div x-show="isOpen"
            @click.away="isOpen = false"
            class="absolute right-0 w-48 mt-2 py-2 bg-white rounded-md shadow-xl z-20">
            <!-- <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-purple-600 hover:text-white">Profile</a>
        <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-purple-600 hover:text-white">Settings</a> -->
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <a href="{{ route('logout') }}"
                    class="block px-4 py-2 text-sm text-gray-700 hover:bg-purple-600 hover:text-white"
                    onclick="event.preventDefault(); this.closest('form').submit();">
                    {{ __('messages.Logout') }}
                </a>
            </form>
        </div>
    </div>
</div>