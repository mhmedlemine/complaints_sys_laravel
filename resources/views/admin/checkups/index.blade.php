@extends('layouts.admin')

@section('content')
    <h2 class="text-2xl font-semibold mb-4">Checkups</h2>
    
    <div class="table-responsive bg-white shadow-md rounded my-6">
        <table class="table min-w-max w-full table-auto">
            <thead>
                <tr class="bg-gray-200 text-gray-600 uppercase text-sm leading-normal">
                    <th class="py-3 px-6 text-left">Code</th>
                    <th class="py-3 px-6 text-left">Entreprise</th>
                    <th class="py-3 px-6 text-left">Agent</th>
                    <th class="py-3 px-6 text-left">Type</th>
                    <th class="py-3 px-6 text-left">Status</th>
                    <th class="py-3 px-6 text-left">Date</th>
                    <th class="py-3 px-6 text-center">Actions</th>
                </tr>
            </thead>
            <tbody class="text-gray-600 text-sm font-light">
                @foreach ($checkups as $checkup)
                    <tr class="border-b border-gray-200 hover:bg-gray-100">
                        <td class="py-3 px-6 text-left">{{ $checkup->code }}</td>
                        <td class="py-3 px-6 text-left">{{ $checkup->entreprise ? $checkup->entreprise->name : 'Not set' }}</td>
                        <td class="py-3 px-6 text-left">{{ $checkup->agent->name }}</td>
                        <td class="py-3 px-6 text-left">
                            <span class="bg-blue-100 text-blue-800 text-xs font-medium px-2.5 py-0.5 rounded">
                                {{ ucfirst($checkup->type) }}
                            </span>
                        </td>
                        <td class="py-3 px-6 text-left">
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
                        </td>
                        <td class="py-3 px-6 text-left">{{ $checkup->started_at ? $checkup->started_at->format('Y-m-d H:i') : 'Not yet' }}</td>
                        <td class="py-3 px-6 text-center">
                            <div class="flex item-center justify-center">
                                <a href="{{ route('admin.checkups.show', $checkup) }}" class="w-4 mr-2 transform hover:text-purple-500 hover:scale-110">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                </a>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    {{ $checkups->links() }}
@endsection
