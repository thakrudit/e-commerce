@extends('layouts.app')

@section('css')
@endsection

@section('content')
    <section class="h-screen">
        <div class="container mx-auto h-full px-4">
            <div class="flex justify-center items-center h-full">
                <!-- Login Form -->
                <div class="w-full max-w-md">
                    <form action="{{ route('auth.login') }}" method="POST" class="bg-white p-8 rounded shadow-md">
                        @csrf
                        <div class="text-center">
                            <h1 class="text-3xl font-semibold mb-6">{{ __('Login') }}</h1>
                        </div>

                        <!-- Email input -->
                        <div class="mb-4">
                            <label for="email"
                                class="block text-gray-700 text-sm font-bold mb-2">{{ __('Email Address') }}</label>
                            <input id="email" type="email"
                                class="w-full px-4 py-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-500 @error('email') border-red-500 @enderror"
                                name="email" value="{{ old('email') }}" required autocomplete="email" autofocus />
                            @error('email')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Password input -->
                        <div class="mb-4">
                            <label for="password"
                                class="block text-gray-700 text-sm font-bold mb-2">{{ __('Password') }}</label>
                            <input id="password" type="password"
                                class="w-full px-4 py-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-500 @error('password') border-red-500 @enderror"
                                name="password" required autocomplete="current-password" />
                            @error('password')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Remember Me and Forgot Password -->
                        <div class="flex justify-between items-center mb-6">
                            <label class="inline-flex items-center">
                                <input id="remember" name="remember" type="checkbox" class="form-checkbox text-blue-600" />
                                <span class="ml-2 text-sm text-gray-600">{{ __('Remember Me') }}</span>
                            </label>
                            @if (Route::has('password.request'))
                                <a href="{{ route('password.request') }}"
                                    class="text-sm text-blue-500 hover:underline">{{ __('Forgot password!') }}</a>
                            @endif
                        </div>

                        <!-- Status Message -->
                        @if (session('status'))
                            <div class="mb-4 font-medium text-sm text-green-600">
                                {{ __(session('status'))}}
                            </div>
                        @endif

                        <!-- Submit Button -->
                        <div class="mb-4">
                            <button type="submit"
                                class="w-full py-2 px-4 bg-blue-500 text-white rounded hover:bg-blue-600 transition">{{ __('Login') }}</button>
                        </div>

                        <!-- Register Link -->
                        <p class="text-center text-sm text-gray-600">
                            {{ __("Don't have an account?") }}
                            <a href="{{ url('/register') }}" class="text-blue-500 hover:underline">Register</a>
                        </p>
                    </form>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('scripts')
@endsection