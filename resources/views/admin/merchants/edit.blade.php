@extends('layouts.admin')

@section('content')
    <h2 class="text-2xl font-semibold mb-4">Edit Merchant</h2>
    <form action="{{ route('admin.merchants.update', $merchant) }}" method="POST" class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
        @csrf
        @method('PUT')
        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2" for="nni">
                NNI
            </label>
            <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="nni" type="text" name="nni" value="{{ $merchant->nni }}" required>
        </div>
        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2" for="fname">
                First Name
            </label>
            <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="fname" type="text" name="fname" value="{{ $merchant->fname }}" required>
        </div>
        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2" for="lname">
                Last Name
            </label>
            <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="lname" type="text" name="lname" value="{{ $merchant->lname }}" required>
        </div>
        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2" for="phonenumber">
                Phone Number
            </label>
            <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="phonenumber" type="number" step="any" name="phonenumber" value="{{ $merchant->phonenumber }}" required>
        </div>
        <div class="flex items-center justify-between">
            <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" type="submit">
                Update Merchant
            </button>
        </div>
    </form>
@endsection