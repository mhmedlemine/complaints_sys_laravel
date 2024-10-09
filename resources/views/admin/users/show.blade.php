@extends('layouts.admin')

@section('content')
    <h2 class="text-2xl font-semibold mb-4">User Details</h2>
    <div class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2">
                Name
            </label>
            <p class="text-gray-700">{{ $user->name }}</p>
        </div>
        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2">
                Email
            </label>
            <p class="text-gray-700">{{ $user->email }}</p>
        </div>
        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2">
                Phone Number
            </label>
            <p class="text-gray-700">{{ $user->phonenumber }}</p>
        </div>
        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2">
                Roles
            </label>
            @foreach($user->roles as $role)
                <span class="bg-blue-200 text-blue-600 py-1 px-3 rounded-full text-xs">
                    {{ $role->name }}
                </span>
            @endforeach
        </div>
        <div class="flex items-center justify-between">
            <a href="{{ route('admin.users.edit', $user) }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                Edit User
            </a>
        </div>
    </div>
@endsection