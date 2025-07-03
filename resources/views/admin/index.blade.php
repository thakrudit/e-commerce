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

        <!-- Content -->
        <div class="bg-white shadow rounded-lg overflow-hidden">
            {{ $title }}
        </div>
    </div>
@endsection

@section('scripts')
@endsection