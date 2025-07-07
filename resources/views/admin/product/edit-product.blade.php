@extends('layouts.admin')

@section('title')
    Admin
@endsection

@section('css')
@endsection

@section('content')
    <!-- Main Content -->
    <div class="flex-1">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-semibold">{{ $title }}</h1>
            <!-- Search Form -->
            <form method="POST" action="{{ url('searchProduct') }}" class="flex items-center space-x-2 bg-transparent">
                @csrf
                <input name="product_name" required type="search" id="search_product"
                    class="bg-gray-800 text-white px-3 py-1 rounded-full focus:outline-none" placeholder="Search..." />
                <button type="submit" class="text-orange-500 hover:text-white">
                    <i class="fa-solid fa-magnifying-glass"></i>
                </button>
            </form>
        </div>

        <!-- Collection Table -->
        <div class="bg-white shadow rounded-lg overflow-hidden">
            <form method="POST" action="{{ route('update.product', $product->id) }}">
                @csrf
                @method('PUT')

                <div class="flex items-center justify-between bg-gray-100 px-6 py-4 rounded-t-lg border-b border-gray-400">
                    <h4 class="text-lg font-semibold text-gray-800">{{ $title }}</h4>
                    <a href="{{ route('all.products') }}"
                        class="bg-gray-300 hover:bg-gray-400 text-gray-800 text-sm font-medium px-4 py-2 rounded">
                        Cancel
                    </a>
                </div>

                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        <!-- Title -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1" for="title">Title</label>
                            <input type="text" name="title" id="title" value="{{ old('title', $product->title) }}"
                                class="w-full p-3 border border-gray-300 rounded bg-white text-gray-800 focus:outline-none focus:ring-2 focus:ring-orange-500">
                        </div>
                        @error('title')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror

                        <!-- Description -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1"
                                for="description">Description</label>
                            <input type="text" name="description" id="description"
                                value="{{ old('description', $product->description) }}"
                                class="w-full p-3 border border-gray-300 rounded bg-white text-gray-800 focus:outline-none focus:ring-2 focus:ring-orange-500">
                        </div>
                    </div>

                    <!-- Save Button -->
                    <div class="mt-6">
                        <button type="submit"
                            class="bg-orange-500 hover:bg-orange-600 text-white font-medium px-6 py-2 rounded">
                            Save Changes
                        </button>
                    </div>
                </div>
            </form>
        </div>


    </div>
@endsection

@section('scripts')
@endsection