@extends('layouts.admin')

@section('content')
    <div class="container mx-auto px-6 py-8">
        <h3 class="text-gray-700 text-3xl font-medium">Checkup Details: {{ $checkup->code }}</h3>

        <div class="mt-8">
            <!-- Basic Information -->
            <div class="bg-white shadow overflow-hidden sm:rounded-lg mb-6">
                <div class="px-4 py-5 sm:px-6">
                    <h3 class="text-lg leading-6 font-medium text-gray-900">Basic Information</h3>
                </div>
                <div class="border-t border-gray-200">
                    <dl>
                        <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500">Status</dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                @php
                                    $statusColors = [
                                        'clean' => 'green',
                                        'with_infractions' => 'red',
                                        'in_progress' => 'yellow',
                                        'canceled' => 'gray'
                                    ];
                                    $color = $statusColors[$checkup->status] ?? 'gray';
                                @endphp
                                <span class="bg-{{ $color }}-100 text-{{ $color }}-800 text-xs font-medium px-2.5 py-0.5 rounded">
                                    {{ ucfirst(str_replace('_', ' ', $checkup->status)) }}
                                </span>
                            </dd>
                        </div>
                        <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500">Type</dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ ucfirst($checkup->type) }}</dd>
                        </div>
                        <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500">Started At</dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ $checkup->started_at ? $checkup->started_at->format('Y-m-d H:i') : 'Not yet' }}</dd>
                        </div>
                        <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500">Completed At</dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                {{ $checkup->completed_at ? $checkup->completed_at->format('Y-m-d H:i') : 'Not completed' }}
                            </dd>
                        </div>
                        @if($checkup->notes)
                            <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                <dt class="text-sm font-medium text-gray-500">Notes</dt>
                                <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ $checkup->notes }}</dd>
                            </div>
                        @endif
                    </dl>
                </div>
            </div>

            <!-- Agent Information -->
            <div class="bg-white shadow overflow-hidden sm:rounded-lg mb-6">
                <div class="px-4 py-5 sm:px-6">
                    <h3 class="text-lg leading-6 font-medium text-gray-900">Agent Information</h3>
                </div>
                <div class="border-t border-gray-200">
                    <dl>
                        <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500">Name</dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ $checkup->agent->name }}</dd>
                        </div>
                        <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500">Phone</dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ $checkup->agent->phonenumber }}</dd>
                        </div>
                    </dl>
                </div>
            </div>

            <!-- Entreprise Information -->
             @if($checkup->entreprise)
            <div class="bg-white shadow overflow-hidden sm:rounded-lg mb-6">
                <div class="px-4 py-5 sm:px-6">
                    <h3 class="text-lg leading-6 font-medium text-gray-900">Entreprise Information</h3>
                </div>
                <div class="border-t border-gray-200">
                    <dl>
                        <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500">Name</dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ $checkup->entreprise->name }}</dd>
                        </div>
                        <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500">Code</dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ $checkup->entreprise->code }}</dd>
                        </div>
                        <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500">Type</dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ $checkup->entreprise->type }}</dd>
                        </div>
                        <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500">Address</dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ $checkup->entreprise->address }}</dd>
                        </div>
                    </dl>
                </div>
            </div>
            @endif

            <!-- Infractions -->
            @if($checkup->checkupInfractions->isNotEmpty())
            <div class="bg-white shadow overflow-hidden sm:rounded-lg mb-6">
                <div class="px-4 py-5 sm:px-6">
                    <h3 class="text-lg leading-6 font-medium text-gray-900">Infractions Found</h3>
                </div>
                <div class="border-t border-gray-200">
                    @foreach($checkup->checkupInfractions as $checkupInfraction)
                        <div class="border-b border-gray-200 p-6">
                            <h4 class="text-md font-medium text-gray-900 mb-2">
                                {{ $checkupInfraction->infraction ? $checkupInfraction->infraction->label : $checkupInfraction->custom_infraction_text }}
                            </h4>
                            @if($checkupInfraction->notes)
                                <p class="text-sm text-gray-600 mb-4">{{ $checkupInfraction->notes }}</p>
                            @endif
                            
                            @if($checkupInfraction->evidence_files)
                                <div class="mt-4">
                                    <h5 class="text-sm font-medium text-gray-900 mb-2">Evidence Files:</h5>
                                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4">
                                        @foreach($checkupInfraction->evidence_files as $evidence)
                                            <div class="border rounded p-4">
                                                @php
                                                    $fileTypeIcons = [
                                                        'image' => 'photograph',
                                                        'document' => 'document-text',
                                                        'audio' => 'volume-up',
                                                        'video' => 'film'
                                                    ];
                                                    $icon = $fileTypeIcons[$evidence['file_type']] ?? 'document';
                                                @endphp
                                                <div class="flex items-center mb-2">
                                                    <svg class="h-5 w-5 text-gray-500 mr-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                                        <path fill-rule="evenodd" d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V5a2 2 0 00-2-2H4zm12 12H4l4-8 3 6 2-4 3 6z" clip-rule="evenodd" />
                                                    </svg>
                                                    <span class="text-sm text-gray-900">{{ basename($evidence['file_path']) }}</span>
                                                </div>
                                                @if($evidence['description'])
                                                    <p class="text-xs text-gray-500">{{ $evidence['description'] }}</p>
                                                @endif
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>
            @endif

            <!-- Related Complaint -->
            @if($checkup->complaint)
            <div class="bg-white shadow overflow-hidden sm:rounded-lg mb-6">
                <div class="px-4 py-5 sm:px-6">
                    <h3 class="text-lg leading-6 font-medium text-gray-900">Related Complaint</h3>
                </div>
                <div class="border-t border-gray-200">
                    <dl>
                        <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500">Code</dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ $checkup->complaint->code }}</dd>
                        </div>
                        <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500">Status</dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                <span class="bg-blue-100 text-blue-800 text-xs font-medium px-2.5 py-0.5 rounded">
                                    {{ ucfirst($checkup->complaint->status) }}
                                </span>
                            </dd>
                        </div>
                        <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500">Description</dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ $checkup->complaint->description }}</dd>
                        </div>
                        <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500">Reported At</dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                {{ $checkup->complaint->reported_at ? $checkup->complaint->reported_at->format('Y-m-d H:i') : 'N/A' }}
                            </dd>
                        </div>
                        <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500">Consumer</dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                {{ $checkup->complaint->consumer ? $checkup->complaint->consumer->fname . ' ' . $checkup->complaint->consumer->lname : 'N/A' }}
                            </dd>
                        </div>
                    </dl>
                </div>
            </div>
            @endif

            <!-- Related Summon -->
            @if($checkup->summon)
            <div class="bg-white shadow overflow-hidden sm:rounded-lg mb-6">
                <div class="px-4 py-5 sm:px-6">
                    <h3 class="text-lg leading-6 font-medium text-gray-900">Related Summon</h3>
                </div>
                <div class="border-t border-gray-200">
                    <dl>
                        <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500">Code</dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ $checkup->summon->code }}</dd>
                        </div>
                        <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500">Status</dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                @php
                                    $summonStatusColors = [
                                        'pending' => 'yellow',
                                        'fined' => 'red',
                                        'completed' => 'green',
                                        'appealed' => 'purple'
                                    ];
                                    $summonColor = $summonStatusColors[$checkup->summon->status] ?? 'gray';
                                @endphp
                                <span class="bg-{{ $summonColor }}-100 text-{{ $summonColor }}-800 text-xs font-medium px-2.5 py-0.5 rounded">
                                    {{ ucfirst($checkup->summon->status) }}
                                </span>
                            </dd>
                        </div>
                        <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500">Filed On</dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                {{ $checkup->summon->filledon ? $checkup->summon->filledon->format('Y-m-d H:i') : 'N/A' }}
                            </dd>
                        </div>
                        <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500">Due Date</dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                {{ $checkup->summon->duedate ? $checkup->summon->duedate->format('Y-m-d') : 'N/A' }}
                            </dd>
                        </div>
                        
                        @if($checkup->summon->fine)
                        <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500">Fine Amount</dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                {{ $checkup->summon->fine->amount }} MRU
                            </dd>
                        </div>
                        <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500">Fine Status</dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                @php
                                    $fineStatusColors = [
                                        'pending' => 'yellow',
                                        'paid' => 'green',
                                        'appealed' => 'purple'
                                    ];
                                    $fineColor = $fineStatusColors[$checkup->summon->fine->status] ?? 'gray';
                                @endphp
                                <span class="bg-{{ $fineColor }}-100 text-{{ $fineColor }}-800 text-xs font-medium px-2.5 py-0.5 rounded">
                                    {{ ucfirst($checkup->summon->fine->status) }}
                                </span>
                            </dd>
                        </div>
                        @if($checkup->summon->fine->paid_on)
                        <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500">Paid On</dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                {{ $checkup->summon->fine->paid_on->format('Y-m-d H:i') }}
                            </dd>
                        </div>
                        <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500">Receipt Number</dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                {{ $checkup->summon->fine->receipt_number }}
                            </dd>
                        </div>
                        @endif
                        @endif
                    </dl>
                </div>
            </div>
            @endif
        </div>
    </div>
@endsection