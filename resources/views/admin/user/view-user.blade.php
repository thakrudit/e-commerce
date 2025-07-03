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

        <!-- Users Table -->
        <div class="bg-white shadow rounded-lg overflow-hidden">
            <div class="flex items-center justify-between bg-gray-100 px-6 py-4 rounded-t-lg border-b border-gray-400">
                <h4 class="text-lg font-semibold text-gray-800">User Details</h4>
                <a href="{{ route('all.users') }}"
                    class="bg-orange-500 hover:bg-orange-600 text-white text-sm font-medium px-4 py-2 rounded">
                    All Users
                </a>
            </div>
            
            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Name</label>
                        <div class="p-3 border border-gray-300 rounded bg-gray-50 text-gray-800">
                            {{ $user->name }}
                        </div>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                        <div class="p-3 border border-gray-300 rounded bg-gray-50 text-gray-800">
                            {{ $user->email }}
                        </div>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Role</label>
                        <div class="p-3 border border-gray-300 rounded bg-gray-50 text-gray-800">
                            {{ $user->role == "1" ? "Admin" : "User" }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
@endsection