@extends('layouts.admin')

@section('content')
    <h2 class="text-2xl font-semibold mb-4">Create Role</h2>
    <form action="{{ route('admin.roles.store') }}" method="POST" class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
        @csrf
        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2" for="name">
                Name
            </label>
            <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="name" type="text" name="name" required>
        </div>
        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2">
                Permissions
            </label>
            @foreach($permissions as $permission)
                <div class="flex items-center">
                    <input type="checkbox" name="permissions[]" value="{{ $permission->id }}" id="permission_{{ $permission->id }}" class="form-checkbox h-5 w-5 text-blue-600">
                    <label for="permission_{{ $permission->id }}" class="ml-2 text-gray-700">{{ $permission->name }}</label>
                </div>
            @endforeach
        </div>
        <div class="flex items-center justify-between">
            <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" type="submit">
                Create Role
            </button>
        </div>
    </form>
@endsection