@extends('layouts.admin')

@section('content')
<div class="container mx-auto px-6 py-8">
    <h2 class="text-2xl font-semibold mb-4">{{ __('messages.Dashboard') }}</h2>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
        <div class="bg-white shadow-md rounded-lg p-4">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <svg class="h-12 w-12 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7h18M3 12h18m-9 5h9" />
                    </svg>
                </div>
                <div class="ml-4">
                    <h3 class="text-lg font-semibold text-gray-700">{{ __('messages.Merchants') }}</h3>
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
                    <h3 class="text-lg font-semibold text-gray-700">{{ __('messages.Consumers') }}</h3>
                    <p class="text-2xl font-bold">{{ $consumerCount }}</p>
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
                    <h3 class="text-lg font-semibold text-gray-700">{{ __('messages.Entreprises') }}</h3>
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
                    <h3 class="text-lg font-semibold text-gray-700">{{ __('messages.Summons') }}</h3>
                    <p class="text-2xl font-bold">{{ $summonCount }}</p>
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
                    <h3 class="text-lg font-semibold text-gray-700">{{ __('messages.Checkups') }}</h3>
                    <p class="text-2xl font-bold">{{ $checkupCount }}</p>
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
                    <h3 class="text-lg font-semibold text-gray-700">{{ __('messages.Fines') }}</h3>
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
                    <h3 class="text-lg font-semibold text-gray-700">{{ __('messages.Complaints') }}</h3>
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
                    <h3 class="text-lg font-semibold text-gray-700">{{ __('messages.Infractions') }}</h3>
                    <p class="text-2xl font-bold">{{ $infractionCount }}</p>
                </div>
            </div>
        </div>

    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
        <div class="bg-white shadow-md rounded-lg p-4">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <div class="rounded-full h-12 w-12 flex items-center justify-center bg-green-100">
                        <svg class="h-6 w-6 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                </div>
                <div class="ml-4">
                    <h3 class="text-lg font-semibold text-gray-700">{{ __('messages.Compliance Rate') }}</h3>
                    <p class="text-2xl font-bold">{{ $complianceRate }}%</p>
                </div>
            </div>
        </div>

        <div class="bg-white shadow-md rounded-lg p-4">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <div class="rounded-full h-12 w-12 flex items-center justify-center bg-yellow-100">
                        <svg class="h-6 w-6 text-yellow-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                </div>
                <div class="ml-4">
                    <h3 class="text-lg font-semibold text-gray-700">{{ __('messages.Pending Summons') }}</h3>
                    <p class="text-2xl font-bold">{{ $pendingSummons }}</p>
                </div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
        <div class="bg-white shadow-md rounded-lg p-4">
            <h3 class="text-lg font-semibold text-gray-700 mb-4">{{ __('messages.Most Common Infractions') }}</h3>
            <div class="space-y-4">
                @foreach($commonInfractions as $infraction)
                <div class="flex justify-between items-center">
                    <span class="text-gray-600">{{ $infraction->infraction->label }}</span>
                    <span class="font-semibold">{{ $infraction->total }}</span>
                </div>
                <div class="w-full bg-gray-200 rounded-full h-2">
                    <div class="bg-blue-600 h-2 rounded-full" style="width: {{ ($infraction->total / $commonInfractions->max('total')) * 100 }}%"></div>
                </div>
                @endforeach
            </div>
        </div>

        <div class="bg-white shadow-md rounded-lg p-4">
            <h3 class="text-lg font-semibold text-gray-700 mb-4">{{ __('messages.Moughataas with most complaints') }}</h3>
            <div class="space-y-4">
                @foreach($complaintHotspots as $hotspot)
                <div class="flex justify-between items-center">
                    <span class="text-gray-600">{{ $hotspot->entreprise ? $hotspot->entreprise->moughataa->name : __('messages.Shop not set yet') }}</span>
                    <span class="font-semibold">{{ $hotspot->total }}</span>
                </div>
                <div class="w-full bg-gray-200 rounded-full h-2">
                    <div class="bg-red-600 h-2 rounded-full" style="width: {{ ($hotspot->total / $complaintHotspots->max('total')) * 100 }}%"></div>
                </div>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Charts Section -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
        <!-- Entreprises by Moughataa Chart -->
        <div class="bg-white shadow-md rounded-lg p-4">
            <h3 class="text-lg font-semibold text-gray-700 mb-4">{{ __('messages.Entreprises by Moughataa') }}</h3>
            <div class="chart-container">
                <canvas id="moughataaChart"></canvas>
                <div class="chart-loading animate-pulse">
                    <div class="h-64 bg-gray-200 rounded"></div>
                </div>
            </div>
        </div>

        <!-- Entreprises by Type Chart -->
        <div class="bg-white shadow-md rounded-lg p-4">
            <h3 class="text-lg font-semibold text-gray-700 mb-4">{{ __('messages.Entreprises by Type') }}</h3>
            <div class="chart-container">
                <canvas id="typeChart"></canvas>
                <div class="chart-loading animate-pulse">
                    <div class="h-64 bg-gray-200 rounded"></div>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Entreprises Table -->
    <div class="bg-white shadow-md rounded-lg p-4">
        <h3 class="text-lg font-semibold text-gray-700 mb-4">{{ __('messages.Recent Entreprises') }}</h3>
        <div class="overflow-x-auto">
            <table class="min-w-full table-auto">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('messages.Name') }}</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('messages.Type') }}</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('messages.Location') }}</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('messages.Status') }}</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('messages.Registered On') }}</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($recentEntreprises as $entreprise)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $entreprise->name }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $entreprise->type }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $entreprise->moughataa->name }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                {{ $entreprise->status === 'open' ? 'bg-green-100 text-green-800' : 
                                ($entreprise->status === 'summoned' ? 'bg-yellow-100 text-yellow-800' : 
                                'bg-blue-100 text-blue-800') }}">
                                {{ $entreprise->status }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $entreprise->created_at }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- Todays Work -->
    <div class="bg-white shadow-md rounded-lg p-4 mt-6">
        <h3 class="text-lg font-semibold text-gray-700 mb-4">{{ __('messages.Today\'s Work') }}</h3>
        
        <div class="flex mb-4">
            <button onclick="showTab('checkups')" id="checkups-tab" class="px-4 py-2 font-medium rounded-lg mr-2 bg-blue-100 text-blue-600">{{__('messages.Checkups')}}</button>
            <button onclick="showTab('complaints')" id="complaints-tab" class="px-4 py-2 font-medium rounded-lg mr-2">{{__('messages.Complaints')}}</button>
            <button onclick="showTab('summons')" id="summons-tab" class="px-4 py-2 font-medium rounded-lg">{{__('messages.Summons')}}</button>
            <button onclick="showTab('fines')" id="fines-tab" class="px-4 py-2 font-medium rounded-lg">{{__('messages.Fines')}}</button>
            <button onclick="showTab('entreprises')" id="entreprises-tab" class="px-4 py-2 font-medium rounded-lg">{{__('messages.Entreprises')}}</button>
        </div>

        <!-- Checkups Tab -->
        <div id="checkups-content" class="tab-content">
            @if($todaysWork['checkups']->isEmpty())
                <p class="text-gray-500 text-center py-4">{{__('messages.No checkups performed today')}}</p>
            @else
                <div class="overflow-x-auto">
                    <table class="min-w-full table-auto">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">{{__('messages.Time')}}</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">{{__('messages.Agent')}}</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">{{__('messages.Enterprise')}}</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">{{__('messages.Status')}}</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($todaysWork['checkups'] as $checkup)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $checkup->created_at->format('H:i') }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $checkup->agent->name }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $checkup->entreprise->name }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                            {{ $checkup->status === 'clean' ? 'bg-green-100 text-green-800' : 
                                            ($checkup->status === 'with_infractions' ? 'bg-red-100 text-red-800' : 
                                            'bg-yellow-100 text-yellow-800') }}">
                                            {{ $checkup->status }}
                                        </span>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>

        <!-- Complaints Tab -->
        <div id="complaints-content" class="tab-content hidden">
            @if($todaysWork['complaints']->isEmpty())
                <p class="text-gray-500 text-center py-4">{{__('messages.No complaints filed today')}}</p>
            @else
                <div class="overflow-x-auto">
                    <table class="min-w-full table-auto">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">{{__('messages.Time')}}</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">{{__('messages.Consumer')}}</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">{{__('messages.Enterprise')}}</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">{{__('messages.Status')}}</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($todaysWork['complaints'] as $complaint)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $complaint->created_at->format('H:i') }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $complaint->consumer->fname }} {{ $complaint->consumer->lname }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $complaint->entreprise->name }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                            {{ $complaint->status }}
                                        </span>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>

        <!-- Summons Tab -->
        <div id="summons-content" class="tab-content hidden">
            @if($todaysWork['summons']->isEmpty())
                <p class="text-gray-500 text-center py-4">{{__('messages.No summons issued today')}}</p>
            @else
                <div class="overflow-x-auto">
                    <table class="min-w-full table-auto">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">{{__('messages.Time')}}</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">{{__('messages.Agent')}}</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">{{__('messages.Enterprise')}}</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">{{__('messages.Due Date')}}</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($todaysWork['summons'] as $summon)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $summon->created_at->format('H:i') }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $summon->agent->name }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $summon->entreprise->name }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $summon->duedate->format('d/m/Y') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>

        <!-- Fines Tab -->
        <div id="fines-content" class="tab-content hidden">
            @if($todaysWork['fines']->isEmpty())
                <p class="text-gray-500 text-center py-4">{{__('messages.No fines issued today')}}</p>
            @else
                <div class="overflow-x-auto">
                    <table class="min-w-full table-auto">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">{{__('messages.Time')}}</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">{{__('messages.Summon')}}</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">{{__('messages.Enterprise')}}</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">{{__('messages.Amount')}}</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">{{__('messages.Status')}}</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">{{__('messages.Due Date')}}</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($todaysWork['fines'] as $fine)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $fine->created_at->format('H:i') }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $fine->summon->code }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $fine->entreprise->name }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $fine->amount }}</td>
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                        {{ $fine->status === 'paid' ? 'bg-green-100 text-green-800' : 
                                        ($fine->status === 'appealed' ? 'bg-yellow-100 text-yellow-800' : 
                                        'bg-blue-100 text-blue-800') }}">
                                        {{ $fine->status }}
                                    </span>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $fine->status }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $fine->duedate->format('d/m/Y') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>

        <!-- Entreprises Tab -->
        <div id="entreprises-content" class="tab-content hidden">
            @if($todaysWork['entreprises']->isEmpty())
                <p class="text-gray-500 text-center py-4">{{__('messages.No entreprises added today')}}</p>
            @else
            <div class="overflow-x-auto">
                <table class="min-w-full table-auto">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">{{ __('messages.Time') }}</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">{{ __('messages.Name') }}</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">{{ __('messages.Type') }}</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">{{ __('messages.Location') }}</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">{{ __('messages.Status') }}</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">{{ __('messages.Registered On') }}</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($todaysWork['entreprises'] as $entreprise)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $entreprise->created_at->format('H:i') }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $entreprise->name }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $entreprise->type }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $entreprise->moughataa->name }}</td>
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                    {{ $entreprise->status === 'open' ? 'bg-green-100 text-green-800' : 
                                    ($entreprise->status === 'summoned' ? 'bg-yellow-100 text-yellow-800' : 
                                    'bg-blue-100 text-blue-800') }}">
                                    {{ $entreprise->status }}
                                </span>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @endif
        </div>
    </div>

    @push('scripts')
    <script>
    function showTab(tabName) {
        // Hide all content
        document.querySelectorAll('.tab-content').forEach(content => {
            content.classList.add('hidden');
        });
        
        // Show selected content
        document.getElementById(tabName + '-content').classList.remove('hidden');
        
        // Update tab styles
        document.querySelectorAll('button').forEach(button => {
            button.classList.remove('bg-blue-100', 'text-blue-600');
        });
        document.getElementById(tabName + '-tab').classList.add('bg-blue-100', 'text-blue-600');
    }
    </script>
    @endpush
    @push('styles')
    <style>
        .chart-container {
            position: relative;
            height: 300px;
            width: 100%;
        }

        .chart-loading {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
        }

        .chart-loading.hidden {
            display: none;
        }
    </style>
    @endpush

    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Common chart options
            Chart.defaults.font.family = "'Inter', 'system-ui', '-apple-system', 'sans-serif'";
            Chart.defaults.color = '#374151'; // text-gray-700

            // Helper function to create charts with loading states
            const createChart = async (elementId, config) => {
                const canvas = document.getElementById(elementId);
                const container = canvas.parentElement;
                const loadingElement = container.querySelector('.chart-loading');

                try {
                    // Show loading state
                    if (loadingElement) {
                        loadingElement.classList.remove('hidden');
                    }

                    const chart = new Chart(canvas, config);

                    // Hide loading state
                    if (loadingElement) {
                        loadingElement.classList.add('hidden');
                    }

                    return chart;
                } catch (error) {
                    console.error(`Error creating chart ${elementId}:`, error);
                    container.innerHTML = `
              <div class="flex items-center justify-center h-full">
                  <div class="text-red-500 text-center">
                      <svg class="w-12 h-12 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                      </svg>
                      <p>Error loading chart</p>
                  </div>
              </div>
          `;
                }
            };

            // Moughataa Chart
            createChart('moughataaChart', {
                type: 'bar',
                data: {
                    labels: @json($entreprisesByMoughataa -> keys()),
                    datasets: [{
                        label: 'Entreprises',
                        data: @json($entreprisesByMoughataa -> values()),
                        backgroundColor: '#3B82F6',
                        borderColor: '#2563EB',
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                precision: 0
                            }
                        }
                    }
                }
            });

            // Type Chart
            createChart('typeChart', {
                type: 'pie',
                data: {
                    labels: @json($entreprisesByType -> keys()),
                    datasets: [{
                        data: @json($entreprisesByType -> values()),
                        backgroundColor: [
                            '#3B82F6', // blue
                            '#10B981', // green
                            '#F59E0B', // yellow
                            '#EF4444', // red
                            '#8B5CF6', // purple
                            '#EC4899' // pink
                        ]
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'bottom'
                        }
                    }
                }
            });
        });
    </script>
    @endpush
    @endsection