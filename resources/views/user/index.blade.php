@extends('layouts.user')

@section('title')
    E-COM
@endsection

@section('css')
@endsection

@section('content')
    @include('layouts.inc.banner')
    <!-- Section: Top Categories -->
    <div class="py-2">
        <div class="container mx-auto flex items-center justify-around p-4">
            <div class="border border-black w-80 bg-black"></div>
            <h3 class="text-xl font-bold px-2">Top Categories</h3>
            <div class="border border-black w-80 bg-black"></div>
        </div>
    </div>

    <!-- Section: Category Cards -->
    <div class="py-5">
        <div class="container mx-auto">
            <div class="flex flex-wrap -mx-2">

                <!-- Accessories -->
                <a href="{{url('/category')}}" class="w-full md:w-1/3 px-2 mb-4">
                    <div class="relative rounded overflow-hidden">
                        <img src="{{asset('images/accessories.jpg')}}" class="w-full h-[200px] object-cover rounded lazy"
                            alt="">
                        <div class="absolute inset-0 flex items-center justify-center text-white">
                            <h4 class="tracking-widest text-lg">ACCESSORIES</h4>
                        </div>
                    </div>
                </a>

                <!-- Equipments -->
                <a href="{{url('/category')}}" class="w-full md:w-1/3 px-2 mb-4">
                    <div class="relative rounded overflow-hidden">
                        <img src="{{asset('images/equipments.jpg')}}" class="w-full h-[200px] object-cover rounded lazy"
                            alt="">
                        <div class="absolute inset-0 flex items-center justify-center text-white">
                            <h4 class="tracking-widest text-lg">EQUIPMENTS</h4>
                        </div>
                    </div>
                </a>

                <!-- Supplements -->
                <a href="{{url('/category')}}" class="w-full md:w-1/3 px-2 mb-4">
                    <div class="relative rounded overflow-hidden">
                        <img src="{{asset('images/supplements.jpg')}}" class="w-full h-[200px] object-cover rounded lazy"
                            alt="">
                        <div class="absolute inset-0 flex items-center justify-center text-white">
                            <h4 class="tracking-widest text-lg">SUPPLEMENTS</h4>
                        </div>
                    </div>
                </a>

            </div>
        </div>
    </div>
@endsection

@section('scripts')
@endsection