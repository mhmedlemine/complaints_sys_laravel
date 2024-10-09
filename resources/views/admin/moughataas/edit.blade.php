@extends('layouts.admin')

@section('content')
    <h2 class="text-2xl font-semibold mb-4">Edit Moughataa</h2>
    <form action="{{ route('admin.moughataas.update', $moughataa) }}" method="POST" class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
        @csrf
        @method('PUT')
        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2" for="code">
                Code
            </label>
            <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="code" type="text" name="code" value="{{ $moughataa->code }}" required>
        </div>
        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2" for="name">
                Name
            </label>
            <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="name" type="text" name="name" value="{{ $moughataa->name }}" required>
        </div>
        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2" for="name_ar">
                Arabic Name
            </label>
            <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="name_ar" type="text" name="name_ar" value="{{ $moughataa->name_ar }}" required>
        </div>
        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2" for="lat">
                Latitude
            </label>
            <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="lat" type="number" step="any" name="lat" value="{{ $moughataa->lat }}" required>
        </div>
        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2" for="lon">
                Longitude
            </label>
            <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="lon" type="number" step="any" name="lon" value="{{ $moughataa->lon }}" required>
        </div>
        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2" for="wilaya_id">
                Wilaya
            </label>
            <select class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="wilaya_id" name="wilaya_id" required>
                @foreach($wilayas as $wilaya)
                    <option value="{{ $wilaya->id }}" {{ $moughataa->wilaya_id == $wilaya->id ? 'selected' : '' }}>{{ $wilaya->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="flex items-center justify-between">
            <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" type="submit">
                Update Moughataa
            </button>
        </div>
    </form>
@endsection