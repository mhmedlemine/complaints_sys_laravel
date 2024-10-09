<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }} Admin</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <script src="{{ asset('js/app.js') }}" defer></script>
    <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.x.x/dist/alpine.min.js" defer></script>
</head>
<body class="font-sans antialiased">
    <div x-data="{ sidebarOpen: false }" class="flex h-screen bg-gray-100">
        <!-- Sidebar -->
        <div :class="sidebarOpen ? 'block' : 'hidden'" @click.away="sidebarOpen = false" class="fixed inset-0 z-20 transition-opacity bg-black opacity-50 lg:hidden"></div>
    
        <div :class="sidebarOpen ? 'translate-x-0 ease-out' : '-translate-x-full ease-in'" class="fixed inset-y-0 left-0 z-30 w-64 overflow-y-auto transition duration-300 transform bg-gray-800 lg:translate-x-0 lg:static lg:inset-0 lg:h-full">
            <div class="flex items-center justify-center h-16 bg-gray-900">
                <div class="flex items-center">
                    <span class="mx-2 text-2xl font-semibold text-white">Admin Panel</span>
                </div>
            </div>

            <div class="h-full overflow-y-auto">
                @include('partials.admin-sidebar')
            </div>
        </div>

        <div class="flex flex-col flex-1 overflow-hidden lg:pl-64">
            <!-- Top bar -->
            <header class="flex items-center justify-between px-6 py-4 bg-white border-b-4 border-indigo-600">
                <div class="flex items-center">
                    <button @click="sidebarOpen = true" class="text-gray-500 focus:outline-none lg:hidden">
                        <svg class="w-6 h-6" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M4 6H20M4 12H20M4 18H11" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </button>
                </div>

                <div class="flex items-center">
                    @include('partials.user-menu')
                </div>
            </header>

            <!-- Main content -->
            <main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-200">
                <div class="container px-6 py-8 mx-auto">
                    @include('partials.flash-messages')
                    @yield('content')
                </div>
            </main>
        </div>
    </div>
</body>
</html>