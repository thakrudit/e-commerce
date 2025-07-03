<header>
    <nav class="fixed top-0 left-0 w-full bg-gray-900 text-white z-50">
        <div class="max-w-screen-xl mx-auto px-4 flex items-center justify-between h-16">
            <!-- Brand -->
            <a href="{{ url('/') }}" class="text-xl font-bold text-orange-500">E-COM</a>

            <!-- Mobile menu toggle -->
            <!-- <button class="md:hidden text-white focus:outline-none" type="button" @click="open = !open"
            aria-label="Toggle navigation">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16"></path>
            </svg>
        </button> -->

            <!-- Navigation Links -->
            <div class="hidden md:flex items-center space-x-6">
                @if(Auth::user())
                    <a href="/" class="hover:text-orange-500 px-3">Home</a>
                    <a href="{{ url('collections') }}" class="hover:text-orange-500 px-3">Collections</a>
                    <a href="{{ url('contact') }}" class="hover:text-orange-500 px-3">Contact</a>
                    <a href="{{ url('about') }}" class="hover:text-orange-500 px-3">About</a>
                @endif

                @guest
                    @if (Route::has('login'))
                        <a href="{{ route('login') }}" class="hover:text-orange-500 px-3">Login</a>
                    @endif
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="hover:text-orange-500 px-3">Register</a>
                    @endif
                @else
                    <!-- Search Form -->
                    <form method="POST" action="{{ url('searchProduct') }}"
                        class="flex items-center space-x-2 bg-transparent">
                        @csrf
                        <input name="product_name" required type="search" id="search_product"
                            class="bg-gray-800 text-white px-3 py-1 rounded-full focus:outline-none"
                            placeholder="Search..." />
                        <button type="submit" class="text-orange-500 hover:text-white">
                            <i class="fa-solid fa-magnifying-glass"></i>
                        </button>
                    </form>

                    <!-- Cart Icon -->
                    <a href="{{ url('cart') }}" class="hover:text-orange-500 px-3">
                        <i class="fa-solid fa-cart-shopping"></i>
                    </a>

                    <!-- Profile Dropdown -->
                    <div class="relative group">
                        <button class="focus:outline-none">
                            <img src="https://mdbcdn.b-cdn.net/img/Photos/Avatars/img (31).webp"
                                class="rounded-full h-6 w-6 object-cover" alt="User Avatar" />
                        </button>
                        <div
                            class="absolute right-0 mt-2 w-48 bg-white text-black rounded shadow-md opacity-0 group-hover:opacity-100 transition-opacity duration-300 z-10">
                            <span class="block px-4 py-2 font-semibold">{{ Auth::user()->name }}</span>
                            <a href="{{ url('my-order') }}" class="block px-4 py-2 hover:bg-gray-100">My Orders</a>
                            <a href="{{ route('logout') }}" class="block px-4 py-2 hover:bg-gray-100"
                                onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                Logout
                            </a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
                                @csrf
                            </form>
                        </div>
                    </div>
                @endguest
            </div>
        </div>

        <!-- Mobile Navigation Menu -->
        <!-- <div x-data="{ open: false }" x-show="open" class="md:hidden px-4 pb-4 bg-gray-900 text-white space-y-2">
        <a href="/" class="block hover:text-orange-500">Home</a>
        <a href="{{ url('collections') }}" class="block hover:text-orange-500">Collections</a>
        <a href="{{ url('contact') }}" class="block hover:text-orange-500">Contact</a>
        <a href="{{ url('about') }}" class="block hover:text-orange-500">About</a>

        @guest
        @if (Route::has('login'))
        <a href="{{ route('login') }}" class="block hover:text-orange-500">Login</a>
        @endif
        @if (Route::has('register'))
        <a href="{{ route('register') }}" class="block hover:text-orange-500">Register</a>
        @endif
        @else
        <form method="POST" action="{{ url('searchProduct') }}" class="flex items-center space-x-2 bg-transparent mt-2">
            @csrf
            <input
                name="product_name"
                required
                type="search"
                class="bg-gray-800 text-white px-3 py-1 rounded-full w-full focus:outline-none"
                placeholder="Search..." />
            <button type="submit" class="text-orange-500 hover:text-white">
                <i class="fa-solid fa-magnifying-glass"></i>
            </button>
        </form>

        <a href="{{ url('cart') }}" class="block hover:text-orange-500 mt-2">
            <i class="fa-solid fa-cart-shopping"></i>
        </a>

        <div class="mt-2 space-y-1">
            <span class="block font-semibold">{{ Auth::user()->name }}</span>
            <a href="{{ url('my-order') }}" class="block hover:text-orange-500">My Orders</a>
            <a href="{{ route('logout') }}"
                class="block hover:text-orange-500"
                onclick="event.preventDefault(); document.getElementById('logout-form-mobile').submit();">
                Logout
            </a>
            <form id="logout-form-mobile" action="{{ route('logout') }}" method="POST" class="hidden">
                @csrf
            </form>
        </div>
        @endguest
    </div> -->
    </nav>
</header>