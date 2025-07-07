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

        <!-- Products Table -->
        <div class="bg-white shadow rounded-lg overflow-hidden">
            <table class="w-full text-left">
                <thead class="bg-gray-800 text-white">
                    <tr>
                        <th class="px-4 py-3">Id</th>
                        <th class="px-4 py-3">Title</th>
                        <th class="px-4 py-3">Description</th>
                        <th class="px-4 py-3">Action</th>
                    </tr>
                </thead>
                <tbody class="text-gray-700">
                    @forelse ($products as $product)
                        <tr class="border-b border-gray-400">
                            <td class="px-4 py-3">{{ $product->id }}</td>
                            <td class="px-4 py-3">{{ $product->title }}</td>
                            <td class="px-4 py-3">{{ $product->description }}</td>
                            <td class="px-4 py-3">
                                <div class="flex space-x-2">
                                    <a href="{{ route('edit.product', $product->id) }}"
                                        class="bg-orange-500 text-white px-4 py-1 rounded hover:bg-orange-600 transition duration-200">
                                        Edit
                                    </a>
                                    <form method="POST" action="{{ route('delete.product', $product->id) }}"
                                        class="inline">
                                        @csrf
                                        <button type="submit"
                                            class="bg-orange-500 text-white px-4 py-1 rounded hover:bg-orange-600 transition duration-200">
                                            Delete
                                        </button>
                                    </form>
                                </div>
                            </td>

                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="p-4 text-center text-black font-semibold">No product found</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection

@section('scripts')
@endsection