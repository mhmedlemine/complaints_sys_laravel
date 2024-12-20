@extends('layouts.admin')

@section('content')
    <h2 class="text-2xl font-semibold mb-4">Edit User</h2>
    <form action="{{ route('admin.users.update', $user) }}" method="POST" class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
        @csrf
        @method('PUT')
        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2" for="name">
                Name
            </label>
            <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="name" type="text" name="name" value="{{ $user->name }}" required>
        </div>
        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2" for="email">
                Email
            </label>
            <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="email" type="email" name="email" value="{{ $user->email }}" >
        </div>
        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2" for="phonenumber">
                Phone Number
            </label>
            <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="phonenumber" type="number" name="phonenumber" value="{{ $user->phonenumber }}" >
        </div>
        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2">
                Roles
            </label>
            @foreach($roles as $role)
                <div class="flex items-center">
                    <input type="checkbox" name="roles[]" value="{{ $role->id }}" id="role_{{ $role->id }}" class="form-checkbox h-5 w-5 text-blue-600" {{ $user->roles->contains($role) ? 'checked' : '' }}>
                    <label for="role_{{ $role->id }}" class="ml-2 text-gray-700">{{ $role->name }}</label>
                </div>
            @endforeach
        </div>
        <div class="flex items-center justify-between">
            <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" type="submit">
                Update User
            </button>
        </div>
    </form>
@endsection