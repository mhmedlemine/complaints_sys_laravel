@extends('layouts.admin')

@section('content')
<div class="container mx-auto px-6 py-8">
    <div class="flex justify-between items-center">
        <h3 class="text-gray-700 text-3xl font-medium">Register New Complaint</h3>
    </div>

    <div class="mt-8">
        <form action="{{ route('admin.complaints.store') }}" method="POST" class="space-y-6">
            @csrf

            <div class="grid grid-cols-1 gap-6 mt-4 sm:grid-cols-2">
                <div>
                    <label class="text-gray-700" for="title">Title</label>
                    <input type="text" name="title" id="title" value="{{ old('title') }}"
                        class="form-input w-full mt-2 rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                    @error('title')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="text-gray-700" for="consumer_id">Consumer</label>
                    <select name="consumer_id" id="consumer_id" class="form-select w-full mt-2 rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                        <option value="">Select Consumer...</option>
                        @foreach($consumers as $consumer)
                        <option value="{{ $consumer->id }}" {{ old('consumer_id') == $consumer->id ? 'selected' : '' }}>
                            {{ $consumer->fname }} {{ $consumer->lname }} - {{ $consumer->phonenumber }}
                        </option>
                        @endforeach
                    </select>
                    @error('consumer_id')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="text-gray-700" for="entreprise_id">Enterprise</label>
                    <select name="entreprise_id" id="entreprise_id" class="form-select w-full mt-2 rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                        <option value="">Select Enterprise...</option>
                        @foreach($entreprises as $entreprise)
                        <option value="{{ $entreprise->id }}" {{ old('entreprise_id') == $entreprise->id ? 'selected' : '' }}>
                            {{ $entreprise->name }} - {{ $entreprise->code }}
                        </option>
                        @endforeach
                    </select>
                    @error('entreprise_id')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="text-gray-700" for="priority">Priority</label>
                    <select name="priority" id="priority" class="form-select w-full mt-2 rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                        <option value="low" {{ old('priority') == 'low' ? 'selected' : '' }}>Low</option>
                        <option value="medium" {{ old('priority') == 'medium' ? 'selected' : '' }}>Medium</option>
                        <option value="high" {{ old('priority') == 'high' ? 'selected' : '' }}>High</option>
                    </select>
                    @error('priority')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="text-gray-700" for="greenNumber">Green Number</label>
                    <input type="text" name="greenNumber" id="greenNumber" value="{{ old('greenNumber') }}"
                        class="form-input w-full mt-2 rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                    @error('greenNumber')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="text-gray-700" for="reported_at">Reported At</label>
                    <input type="datetime-local" name="reported_at" id="reported_at" value="{{ old('reported_at') }}"
                        class="form-input w-full mt-2 rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                    @error('reported_at')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="sm:col-span-2">
                    <label class="text-gray-700" for="shop_address">Shop Address</label>
                    <input type="text" name="shop_address" id="shop_address" value="{{ old('shop_address') }}"
                        class="form-input w-full mt-2 rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                    @error('shop_address')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="sm:col-span-2">
                    <label class="text-gray-700" for="description">Description</label>
                    <textarea name="description" id="description" rows="4"
                        class="form-textarea w-full mt-2 rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">{{ old('description') }}</textarea>
                    @error('description')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="flex justify-end mt-6">
                <button type="submit"
                    class="px-6 py-2 leading-5 text-white transition-colors duration-200 transform bg-gray-700 rounded-md hover:bg-gray-600 focus:outline-none focus:bg-gray-600">
                    Register Complaint
                </button>
            </div>
        </form>
    </div>
</div>
@endsection