@extends('layouts.admin')

@section('content')
    <h2 class="text-2xl font-semibold mb-4">Edit Municipality</h2>
    <form action="{{ route('admin.municipalities.update', $municipality) }}" method="POST" class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
        @csrf
        @method('PUT')
        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2" for="code">
                Code
            </label>
            <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="code" type="text" name="code" value="{{ $municipality->code }}" required>
        </div>
        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2" for="name">
                Name
            </label>
            <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="name" type="text" name="name" value="{{ $municipality->name }}" required>
        </div>
        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2" for="name_ar">
                Arabic Name
            </label>
            <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="name_ar" type="text" name="name_ar" value="{{ $municipality->name_ar }}" required>
        </div>
        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2" for="lat">
                Latitude
            </label>
            <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="lat" type="number" step="any" name="lat" value="{{ $municipality->lat }}" required>
        </div>
        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2" for="lon">
                Longitude
            </label>
            <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="lon" type="number" step="any" name="lon" value="{{ $municipality->lon }}" required>
        </div>
        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2" for="moughataa_id">
                Moughataa
            </label>
            <select class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="moughataa_id" name="moughataa_id" required>
                @foreach($moughataas as $moughataa)
                    <option value="{{ $moughataa->id }}" {{ $municipality->moughataa_id == $moughataa->id ? 'selected' : '' }}>{{ $moughataa->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="flex items-center justify-between">
            <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" type="submit">
                Update Municipality
            </button>
        </div>
    </form>
@endsection