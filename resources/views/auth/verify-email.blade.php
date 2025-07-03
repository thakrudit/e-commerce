@extends('layouts.app')

@section('css')
@endsection

@section('content')
    <section class="h-screen">
        <div class="container mx-auto h-full px-4">
            <div class="flex justify-center items-center h-full">
                <!-- Sign up Form -->
                <div class="w-full max-w-md">
                    <div class="bg-white p-8 rounded shadow-md">
                        <div class="text-center">
                            <h1 class="text-3xl font-semibold mb-6">{{ __('Verify Email') }}</h1>
                        </div>

                        <div class="mb-4 text-sm text-gray-600">
                            {{ __('Thanks for signing up! Before getting started, could you verify your email address by clicking on the link we just emailed to you? If you didn\'t receive the email, we will gladly send you another.') }}
                        </div>

                        <!-- Message ! -->
                        @if (session('message'))
                            <div class="mb-4 font-medium text-sm text-green-600">
                                {{ __(session('message'))}}
                            </div>
                        @endif

                        <!-- Status Message -->
                        @if (session('status') == 'verification-link-sent')
                            <div class="mb-4 font-medium text-sm text-green-600">
                                {{ __('A new verification link has been sent to the email address you provided during registration.') }}
                            </div>
                        @endif

                        <div class="mt-4 flex items-center justify-between">
                            <form method="POST" action="{{ route('verification.resend') }}">
                                @csrf

                                <button type="submit" class="underline text-sm text-blue-500 hover:text-blue-700">
                                    {{ __('Resend Verification Email') }}
                                </button>
                            </form>

                            <form method="POST" action="{{ route('logout') }}">
                                @csrf

                                <button type="submit" class="underline text-sm text-gray-600 hover:text-gray-900">
                                    {{ __('Log Out') }}
                                </button>
                            </form>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('scripts')
@endsection