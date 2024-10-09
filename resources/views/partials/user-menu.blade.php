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
                Logout
            </a>
        </form>
    </div>
</div>