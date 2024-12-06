@extends('layouts.admin')

@section('content')
    <h2 class="text-2xl font-semibold mb-4">Complaints Management</h2>
    
    <!-- Header Actions -->
    <div class="mb-6 flex justify-between items-center">
        <div class="flex gap-2">
            <a href="{{ route('admin.complaints.create') }}" 
               class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                New Complaint
            </a>
        </div>
    </div>

    <!-- Complaints Table -->
    <div class="bg-white shadow-md rounded my-6 overflow-x-auto">
        <table class="min-w-max w-full table-auto">
            <thead>
                <tr class="bg-gray-200 text-gray-600 uppercase text-sm leading-normal">
                    <th class="py-3 px-6 text-left">Code</th>
                    <th class="py-3 px-6 text-left">Title</th>
                    <th class="py-3 px-6 text-left">Enterprise</th>
                    <th class="py-3 px-6 text-left">Consumer</th>
                    <th class="py-3 px-6 text-left">Priority</th>
                    <th class="py-3 px-6 text-left">Status</th>
                    <th class="py-3 px-6 text-left">Assignment</th>
                    <th class="py-3 px-6 text-center">Actions</th>
                </tr>
            </thead>
            <tbody class="text-gray-600 text-sm font-light">
                @foreach ($complaints as $complaint)
                    <tr class="border-b border-gray-200 hover:bg-gray-100">
                        <td class="py-3 px-6 text-left whitespace-nowrap">
                            <span class="font-medium">{{ $complaint->code }}</span>
                            <div class="text-xs text-gray-500">
                                {{ $complaint->reported_at->format('Y-m-d H:i') }}
                            </div>
                        </td>
                        <td class="py-3 px-6 text-left max-w-xs">
                            <div class="truncate">{{ $complaint->title }}</div>
                        </td>
                        <td class="py-3 px-6 text-left">{{ $complaint->entreprise ? $complaint->entreprise->name : 'Not set' }}</td>
                        <td class="py-3 px-6 text-left">
                            <div>{{ $complaint->consumer->fname }} {{ $complaint->consumer->lname }}</div>
                            <div class="text-xs text-gray-500">{{ $complaint->consumer->phonenumber }}</div>
                        </td>
                        <td class="py-3 px-6 text-left">
                            <span class="px-2 py-1 text-xs rounded-full {{ 
                                $complaint->priority === 'high' ? 'bg-red-100 text-red-800' : 
                                ($complaint->priority === 'medium' ? 'bg-yellow-100 text-yellow-800' : 'bg-green-100 text-green-800') 
                            }}">
                                {{ ucfirst($complaint->priority) }}
                            </span>
                        </td>
                        <td class="py-3 px-6 text-left">
                            <span class="px-2 py-1 text-xs rounded-full {{ 
                                $complaint->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : 
                                ($complaint->status === 'investigating' ? 'bg-blue-100 text-blue-800' : 
                                ($complaint->status === 'resolved' ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800'))
                            }}">
                                {{ ucfirst($complaint->status) }}
                            </span>
                        </td>
                        <td class="py-3 px-6 text-left">
                            @if($complaint->checkup && $complaint->checkup->agent)
                                <div class="flex items-center">
                                    <span class="bg-blue-100 text-blue-800 text-xs px-2 py-1 rounded-full">
                                        {{ $complaint->checkup->agent->name }}
                                    </span>
                                </div>
                            @else
                                <span class="text-yellow-600 text-xs">Not Assigned</span>
                            @endif
                        </td>
                        <td class="py-3 px-6">
                            <div class="flex justify-center items-center space-x-3">
                                <!-- View Details -->
                                <a href="{{ route('admin.complaints.show', $complaint) }}" 
                                   class="text-blue-600 hover:text-blue-900" 
                                   title="View Details">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                </a>

                                <!-- Edit -->
                                <a href="{{ route('admin.complaints.edit', $complaint) }}" 
                                   class="text-yellow-600 hover:text-yellow-900"
                                   title="Edit">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                    </svg>
                                </a>

                                <!-- Assign Button (if not assigned) -->
                                @if(!$complaint->checkup || !$complaint->checkup->agent)
                                    <a href="{{ route('admin.complaints.assign', $complaint) }}" 
                                       class="text-green-600 hover:text-green-900"
                                       title="Assign Agent">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                                        </svg>
                                    </a>
                                @endif

                                <!-- Delete -->
                                <form action="{{ route('admin.complaints.index', $complaint) }}" 
                                      method="POST" 
                                      class="inline-block"
                                      onsubmit="return confirm('Are you sure you want to delete this complaint?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" 
                                            class="text-red-600 hover:text-red-900"
                                            title="Delete">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div class="mt-4">
        {{ $complaints->links() }}
    </div>
@endsection