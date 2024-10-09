@extends('layouts.admin')

@section('content')
    <h2 class="text-2xl font-semibold mb-4">Role Details</h2>
    <div class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2">
                Name
            </label>
            <p class="text-gray-700">{{ $role->name }}</p>
        </div>
        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2">
                Permissions
            </label>
            @foreach($role->permissions as $permission)
                <span class="bg-green-200 text-green-600 py-1 px-3 rounded-full text-xs">
                    {{ $permission->name }}
                </span>
            @endforeach
        </div>
        <div class="flex items-center justify-between">
            <a href="{{ route('admin.roles.edit', $role) }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                Edit Role
            </a>
        </div>
    </div>
@endsection