@extends('layouts.admin')

@section('content')
    <div class="container mx-auto px-6 py-8">
        <h3 class="text-gray-700 text-3xl font-medium">Assign Complaint: {{ $complaint->code }}</h3>

        <div class="mt-8">
            <div class="bg-white shadow overflow-hidden sm:rounded-lg">
                <div class="px-4 py-5 sm:px-6">
                    <h3 class="text-lg leading-6 font-medium text-gray-900">
                        Complaint Information
                    </h3>
                </div>
                <div class="border-t border-gray-200 px-4 py-5 sm:px-6">
                    <dl class="grid grid-cols-1 gap-x-4 gap-y-8 sm:grid-cols-2">
                        <div class="sm:col-span-1">
                            <dt class="text-sm font-medium text-gray-500">Title</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $complaint->title }}</dd>
                        </div>
                        @if($complaint->entreprise)
                        <div class="sm:col-span-1">
                            <dt class="text-sm font-medium text-gray-500">Enterprise</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $complaint->entreprise->name }}</dd>
                        </div>
                        @endif
                        <div class="sm:col-span-1">
                            <dt class="text-sm font-medium text-gray-500">Consumer</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $complaint->consumer->fname }} {{ $complaint->consumer->lname }}</dd>
                        </div>
                        <div class="sm:col-span-1">
                            <dt class="text-sm font-medium text-gray-500">Priority</dt>
                            <dd class="mt-1 text-sm text-gray-900">
                                <span class="px-2 py-1 text-xs rounded-full {{ 
                                    $complaint->priority === 'high' ? 'bg-red-100 text-red-800' : 
                                    ($complaint->priority === 'medium' ? 'bg-yellow-100 text-yellow-800' : 'bg-green-100 text-green-800') 
                                }}">
                                    {{ ucfirst($complaint->priority) }}
                                </span>
                            </dd>
                        </div>
                    </dl>
                </div>
            </div>

            <form action="{{ route('admin.complaints.storeAssignment', $complaint) }}" method="POST" class="mt-8">
                @csrf
                <div class="shadow sm:rounded-md sm:overflow-hidden">
                    <div class="px-4 py-5 bg-white space-y-6 sm:p-6">
                        <div>
                            <label for="agent_id" class="block text-sm font-medium text-gray-700">
                                Assign Agent
                            </label>
                            <select id="agent_id" name="agent_id" required
                                class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                                <option value="">Select an agent</option>
                                @foreach($agents as $agent)
                                    <option value="{{ $agent->id }}">{{ $agent->name }}</option>
                                @endforeach
                            </select>
                            @error('agent_id')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                    <div class="px-4 py-3 bg-gray-50 text-right sm:px-6">
                        <a href="{{ route('admin.complaints.index') }}" 
                           class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-gray-700 bg-gray-100 hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 mr-3">
                            Cancel
                        </a>
                        <button type="submit"
                            class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            Assign Complaint
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection