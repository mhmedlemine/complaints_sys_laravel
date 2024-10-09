@extends('layouts.admin')

@section('content')
    <div class="container mx-auto px-6 py-8">
        <h2 class="text-2xl font-semibold mb-4">Dashboard</h2>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
            <div class="bg-white shadow-md rounded-lg p-4">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <svg class="h-12 w-12 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7h18M3 12h18m-9 5h9" />
                        </svg>
                    </div>
                    <div class="ml-4">
                        <h3 class="text-lg font-semibold text-gray-700">Merchants</h3>
                        <p class="text-2xl font-bold">{{ $merchantCount }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white shadow-md rounded-lg p-4">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <svg class="h-12 w-12 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7h18M3 12h18m-9 5h9" />
                        </svg>
                    </div>
                    <div class="ml-4">
                        <h3 class="text-lg font-semibold text-gray-700">Entreprises</h3>
                        <p class="text-2xl font-bold">{{ $entrepriseCount }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white shadow-md rounded-lg p-4">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <svg class="h-12 w-12 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7h18M3 12h18m-9 5h9" />
                        </svg>
                    </div>
                    <div class="ml-4">
                        <h3 class="text-lg font-semibold text-gray-700">Summons</h3>
                        <p class="text-2xl font-bold">{{ $summonCount }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white shadow-md rounded-lg p-4">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <svg class="h-12 w-12 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7h18M3 12h18m-9 5h9" />
                        </svg>
                    </div>
                    <div class="ml-4">
                        <h3 class="text-lg font-semibold text-gray-700">Fines</h3>
                        <p class="text-2xl font-bold">{{ $fineCount }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white shadow-md rounded-lg p-4">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <svg class="h-12 w-12 text-yellow-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7h18M3 12h18m-9 5h9" />
                        </svg>
                    </div>
                    <div class="ml-4">
                        <h3 class="text-lg font-semibold text-gray-700">Complaints</h3>
                        <p class="text-2xl font-bold">{{ $complaintCount }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white shadow-md rounded-lg p-4">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <svg class="h-12 w-12 text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7h18M3 12h18m-9 5h9" />
                        </svg>
                    </div>
                    <div class="ml-4">
                        <h3 class="text-lg font-semibold text-gray-700">Infractions</h3>
                        <p class="text-2xl font-bold">{{ $infractionCount }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection