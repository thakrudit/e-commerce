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
            <!-- <input type="text" placeholder="Search..." class="border px-3 py-1 rounded-md w-1/3"> -->
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

        <!-- Category Table -->
        <div class="bg-white shadow rounded-lg overflow-hidden">
            <form action="{{route('create.category')}}" method="POST" enctype="multipart/form-data" class="space-y-5">
                @csrf
                <div class="w-4xl flex flex-col gap-6 p-6 text-gray-700">
                    <!-- Name Field -->
                    <div>
                        <label class="block text-sm font-medium mb-1" for="name">Category Name</label>
                        <input type="text" name="name" id="name" required
                            class="w-full p-3 border border-gray-300 rounded-md bg-white focus:outline-none focus:ring-2 focus:ring-orange-500">
                    </div>
                    @error('name')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror

                    <!-- Description Field -->
                    <div>
                        <label for="description" class="block text-sm font-medium mb-1">Description</label>
                        <textarea name="description" id="description" rows="4"
                            class="w-full p-3 border border-gray-300 rounded-md bg-white focus:outline-none focus:ring-2 focus:ring-orange-500"></textarea>
                    </div>
                    @error('description')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror

                    <!-- Image Field -->
                    <div>
                        <label for="image" class="block text-sm font-medium mb-1">Category Image</label>
                        <input type="file" name="image" id="image"
                            class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-orange-500 hover:file:bg-blue-100" />
                    </div>
                    @error('image')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror

                    <!-- Submit Button -->
                    <div>
                        <button type="submit"
                            class="bg-orange-500 hover:bg-orange-600 text-white font-medium px-6 py-2 rounded-md transition">
                            Create Category
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('scripts')
@endsection