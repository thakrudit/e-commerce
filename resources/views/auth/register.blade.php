@extends('layouts.app')

@section('css')
@endsection

@section('content')
<section class="h-screen">
    <div class="container mx-auto h-full px-4">
        <div class="flex justify-center items-center h-full">
            <!-- Sign up Form -->
            <div class="w-full max-w-md">
                <form action="{{ route('auth.register') }}" method="POST" class="bg-white p-8 rounded shadow-md">
                    @csrf
                    <div class="text-center">
                        <h1 class="text-3xl font-semibold mb-6">{{ __('Sign up') }}</h1>
                    </div>

                    <!-- Name input -->
                    <div class="mb-4">
                        <label for="name" class="block text-gray-700 text-sm font-bold mb-2">{{ __('Name') }}</label>
                        <input id="name" type="name"
                            class="w-full px-4 py-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-500 @error('name') border-red-500 @enderror"
                            name="name" value="{{ old('name') }}" required autocomplete="name" autofocus />
                        @error('name')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Email input -->
                    <div class="mb-4">
                        <label for="email" class="block text-gray-700 text-sm font-bold mb-2">{{ __('Email Address') }}</label>
                        <input id="email" type="email"
                            class="w-full px-4 py-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-500 @error('email') border-red-500 @enderror"
                            name="email" value="{{ old('email') }}" required autocomplete="email" autofocus />
                        @error('email')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Password input -->
                    <div class="mb-4">
                        <label for="password" class="block text-gray-700 text-sm font-bold mb-2">{{ __('Password') }}</label>
                        <input id="password" type="password"
                            class="w-full px-4 py-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-500 @error('password') border-red-500 @enderror"
                            name="password" required autocomplete="new-password" />
                        @error('password')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Confirm Password input -->
                    <div class="mb-4">
                        <label for="confirmpassword" class="block text-gray-700 text-sm font-bold mb-2">{{ __('Confirm Password') }}</label>
                        <input id="confirmpassword" type="password"
                            class="w-full px-4 py-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-500 @error('password') border-red-500 @enderror"
                            name="password_confirmation" required autocomplete="new-password" />
                        @error('confirmpassword')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- User Role -->
                    <!-- <div class="mb-4">
                        <label for="role" class="block text-gray-700 text-sm font-bold mb-2">{{ __('Role') }}</label>
                        <select id="role"
                            class="w-full px-4 py-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-500 @error('name') border-red-500 @enderror"
                            name="role" required autofocus>
                            <option value="" disabled {{ old('role') ? '' : 'selected' }}>Select a role</option>
                            <option value="2" {{ old('role') == '2' ? 'selected' : '' }}>Vendor</option>
                            <option value="3" {{ old('role') == '3' ? 'selected' : '' }}>User</option>
                        </select>
                        @error('role')
                        <p class="text-red-500 text-xs mt-1">{{ $role }}</p>
                        @enderror
                    </div> -->

                    <!-- Submit Button -->
                    <div class="mb-4">
                        <button type="submit"
                            class="w-full py-2 px-4 bg-blue-500 text-white rounded hover:bg-blue-600 transition">{{ __('Register') }}</button>
                    </div>

                    <!-- Register Link -->
                    <p class="text-center text-sm text-gray-600">
                        {{ __("Already have an account?") }}
                        <a href="{{ url('/login') }}" class="text-blue-500 hover:underline">Login</a>
                    </p>
                </form>
            </div>
        </div>
    </div>
</section>
@endsection

@section('scripts')
@endsection