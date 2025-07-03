<!-- Sidebar -->
<aside class="w-64 bg-gradient-to-b from-gray-900 to-gray-800 text-white flex flex-col justify-between p-4">
    <div>
        <h2 class="text-2xl font-bold mb-6">Admin Dashboard</h2>
        <nav class="space-y-2">
            <a href="{{ route('admin.dashboard') }}"
                class="flex items-center px-3 py-2 bg-orange-500 rounded text-white font-semibold {{ request()->routeIs('admin.dashboard') ? 'bg-orange-700 text-white' : 'hover:bg-orange-700' }}">
                <i class="fas fa-tachometer-alt mr-2"></i> Dashboard
            </a>
            <a href="{{ route('all.categories') }}"
                class="flex items-center px-3 py-2 rounded {{ request()->routeIs('all.categories') ? 'bg-gray-700 text-white' : 'hover:bg-gray-700' }}">
                <i class="fas fa-list mr-2"></i> Categories
            </a>
            <a href="{{ route('category') }}"
                class="flex items-center px-3 py-2 rounded {{ request()->routeIs('category') ? 'bg-gray-700 text-white' : 'hover:bg-gray-700' }}">
                <i class="fas fa-plus mr-2"></i> Add Category
            </a>
            <a href="{{ route('all.collections') }}"
                class="flex items-center px-3 py-2 rounded {{ request()->routeIs('all.collections') ? 'bg-gray-700 text-white' : 'hover:bg-gray-700' }}">
                <i class="fas fa-list mr-2"></i> Collections
            </a>
            <a href="{{ route('collection') }}"
                class="flex items-center px-3 py-2 rounded {{ request()->routeIs('collection') ? 'bg-gray-700 text-white' : 'hover:bg-gray-700' }}">
                <i class="fas fa-plus mr-2"></i> Add Collection
            </a>
            <a href="{{ route('all.products') }}"
                class="flex items-center px-3 py-2 rounded {{ request()->routeIs('all.products') ? 'bg-gray-700 text-white' : 'hover:bg-gray-700' }}">
                <i class="fas fa-box mr-2"></i> Products
            </a>
            <a href="{{ route('product') }}"
                class="flex items-center px-3 py-2 rounded {{ request()->routeIs('product') ? 'bg-gray-700 text-white' : 'hover:bg-gray-700' }}">
                <i class="fas fa-plus-circle mr-2"></i> Add Product
            </a>
            <a href="{{ route('all.orders') }}"
                class="flex items-center px-3 py-2 rounded {{ request()->routeIs('all.orders') ? 'bg-gray-700 text-white' : 'hover:bg-gray-700' }}">
                <i class="fas fa-list-alt mr-2"></i> Orders List
            </a>
            <a href="{{ route('all.users') }}"
                class="flex items-center px-3 py-2 rounded {{ request()->routeIs('all.users') ? 'bg-gray-700 text-white' : 'hover:bg-gray-700' }}">
                <i class="fas fa-users mr-2"></i> Users List
            </a>
            <!-- <a href="#" class="flex items-center px-3 py-2 rounded">
                <i class="fas fa-envelope mr-2"></i> Messages
            </a> -->
        </nav>
    </div>
    <form method="POST" action="{{ route('logout') }}" class="flex items-center space-x-2 bg-transparent">
        @csrf
        <button type="submit" class="w-full bg-orange-500 py-2 rounded font-semibold hover:bg-orange-700 mt-4">
            <i class="fas fa-sign-out-alt mr-2"></i> LOGOUT
        </button>
    </form>

</aside>