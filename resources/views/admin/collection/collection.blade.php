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
            <form action="{{route('create.collection')}}" method="POST" enctype="multipart/form-data" class="space-y-5">
                <div class="w-4xl flex flex-col gap-6 p-6 text-gray-700">
                    @csrf
                    <!-- Title Field -->
                    <div>
                        <label for="title" class="block text-sm font-medium mb-1">Title</label>
                        <input type="text" name="title" id="title" required
                            class="w-full p-3 border border-gray-300 rounded-md bg-white focus:outline-none focus:ring-2 focus:ring-orange-500" />
                    </div>
                    @error('title')
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

                    <!-- Collection Type -->
                    <div>
                        <span class="block text-sm font-medium mb-1">Collection Type</span>
                        <div class="flex items-center gap-6">
                            <label class="flex items-center">
                                <input type="radio" name="collection_type" value="custom" class="form-radio text-orange-500"
                                    {{ old('collection_type', 'custom') == 'custom' ? 'checked' : '' }}
                                    onchange="toggleCollectionType()">
                                <span class="ml-2 text-sm">Manual</span>
                            </label>
                            <label class="flex items-center">
                                <input type="radio" name="collection_type" value="smart" class="form-radio text-orange-500"
                                    {{ old('collection_type') === 'smart' ? 'checked' : '' }}
                                    onchange="toggleCollectionType()">
                                <span class="ml-2 text-sm">Automatic</span>
                            </label>
                        </div>
                    </div>

                    <!-- Manual div -->
                    <div id="manual-fields" class="p-4 bg-white border border-gray-200 rounded-md shadow-sm w-full">
                        <div class="relative w-full flex items-center space-x-2 bg-transparent">
                            <input type="search" id="product-form"
                                class="w-full p-3 border border-gray-300 rounded-md bg-white focus:outline-none focus:ring-2 focus:ring-orange-500"
                                placeholder="Search products" oninput="showSuggestions()" autocomplete="off" />

                            <ul id="suggestion-list"
                                class="absolute z-10 top-8 w-full bg-white border border-gray-300 rounded-md shadow mt-1 hidden max-h-48 overflow-y-auto">
                            </ul>

                            <button type="button" onclick="submitProductSearch()"
                                class=" bg-orange-500 text-white px-3 py-1 rounded-md hover:bg-orange-600 transition">Search</button>
                        </div>

                        <div id="selected-product-ids">
                        </div>

                        <div id="selected-products-div"
                            class="hidden w-full mt-4 bg-gray-50 border border-gray-200 px-3 py-2 rounded-md shadow-sm">
                            <ul id="selected-products" class="flex flex-wrap gap-3">
                            </ul>
                        </div>

                        @error('product_ids')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Automatic div -->
                    <div id="automatic-fields" class="p-4 bg-white border border-gray-200 rounded-md shadow-sm w-full">
                        <div class="flex flex-col sm:flex-row sm:items-center sm:space-x-4 space-y-4 sm:space-y-0">
                            <!-- Column Selector -->
                            <div class="flex-1">
                                <label for="column" class="block text-sm font-medium mb-1">Column</label>
                                <select name="rules[0][column]" id="column"
                                    class="w-full border border-gray-300 rounded-md p-2 text-sm focus:outline-none focus:ring-2 focus:ring-orange-500">
                                    <option value="tag">Tag</option>
                                    <option value="category">Category</option>
                                </select>
                            </div>

                            <!-- Relation Selector -->
                            <div class="flex-1">
                                <label for="relation" class="block text-sm font-medium mb-1">Relation</label>
                                <select name="rules[0][relation]" id="relation"
                                    class="w-full border border-gray-300 rounded-md p-2 text-sm focus:outline-none focus:ring-2 focus:ring-orange-500">
                                    <option value="equals">is equal to</option>
                                    <option value="not_equals">is not equal to</option>
                                </select>
                            </div>

                            <!-- Condition Input -->
                            <div class="flex-1">
                                <label for="condition" class="block text-sm font-medium mb-1">Condition</label>
                                <input type="text" id="condition" name="rules[0][condition]" placeholder="Enter value..."
                                    class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-orange-500" />
                            </div>

                            @error('rules.*.condition')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Image Field -->
                    <div>
                        <label for="image" class="block text-sm font-medium mb-1">Collection Image</label>
                        <input type="file" name="image" id="image"
                            class="block text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded file:border-0 file:text-sm file:font-semibold file:bg-orange-50 file:text-orange-500 hover:file:bg-orange-100" />
                    </div>
                    @error('image')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror

                    <!-- Submit Button -->
                    <div>
                        <button type="submit"
                            class="bg-orange-500 hover:bg-orange-600 text-white font-medium px-6 py-2 rounded-md transition">
                            Create Collection
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        async function toggleCollectionType() {
            const manualDiv = document.getElementById('manual-fields')
            const automaticDiv = document.getElementById('automatic-fields')
            const selected = document.querySelector('input[name="collection_type"]:checked').value;

            if (selected === 'custom') {
                manualDiv.classList.remove('hidden');
                automaticDiv.classList.add('hidden');
            } else {
                manualDiv.classList.add('hidden');
                automaticDiv.classList.remove('hidden');
            }
        }

        async function submitProductSearch() {
            const productForm = document.getElementById('product-form').value;

            const searchUrl = "{{route('admin.dashboard')}}?product_name=" + encodeURIComponent(productForm);
            window.location.href = searchUrl;
        }

        let timeout = null;

        async function showSuggestions() {
            const query = document.getElementById('product-form').value;
            clearTimeout(timeout);
            timeout = setTimeout(async () => {
                if (query.length == 0) return;

                const response = await fetch(`/admin/search-product?q=${encodeURIComponent(query)}`);
                if (!response.ok) {
                    throw new Error(`Response status: ${response.status}`);
                }

                const products = await response.json();

                const list = document.getElementById('suggestion-list')
                list.innerHTML = "";

                if (products?.length === 0) {
                    list.classList.add('hidden');
                    return;
                }

                products.forEach(product => {
                    const li = document.createElement('li');
                    li.className = "cursor-pointer hover:bg-gray-100 px-3 py-2 text-sm";
                    li.textContent = product.title;
                    li.onclick = () => addProductToList(product);
                    list.appendChild(li);
                })
                list.classList.remove('hidden');

            }, 300)
        }

        // Optional: Hide suggestions when clicking outside
        document.addEventListener('click', (e) => {
            const list = document.getElementById('suggestion-list');
            const input = document.getElementById('product-form');
            if (!list.contains(e.target) && e.target !== input) {
                list.classList.add('hidden');
            }
        })

        const selectedProductsDiv = document.getElementById('selected-products-div');
        const selectedProducts = new Set();

        async function addProductToList(product) {
            if (selectedProducts.has(product.id)) return;

            selectedProducts.add(product.id);

            // Add hidden input
            const hiddenInputs = document.getElementById('selected-product-ids');
            const input = document.createElement('input');
            input.type = 'hidden';
            input.name = 'product_ids[]';
            input.value = product.id;
            input.dataset.id = product.id;
            hiddenInputs.appendChild(input);

            // Add visible product item
            const li = document.createElement('li');
            li.className = 'w-full flex items-center justify-between border-b border-gray-300 py-2';
            li.dataset.id = product.id;
            li.innerHTML = `
                                                                                                                                                    <div class="flex items-center gap-2">
                                                                                                                                                        <img src="http://localhost:8000/upload/category/1751530596.jpg" class="w-10 h-10 object-cover rounded" />
                                                                                                                                                        <span class="text-sm text-gray-700">${product.title}</span>
                                                                                                                                                    </div>
                                                                                                                                                    <button type="button" class="text-gray-400 hover:text-red-500 transition" onclick="removeProduct(${product.id})">
                                                                                                                                                        &times;
                                                                                                                                                    </button>
                                                                                                                                                `;
            document.getElementById('selected-products').appendChild(li);
            selectedProductsDiv.classList.remove("hidden")

            // Hide suggestions
            document.getElementById('suggestion-list').classList.add('hidden');
            document.getElementById('product-form').value = '';
        }

        async function removeProduct(id) {
            selectedProducts.delete(id);

            const input = document.querySelector(`#selected-product-ids input[data-id="${id}"]`)
            if (input) input.remove();

            const li = document.querySelector(`#selected-products li[data-id="${id}"]`);
            if (li) li.remove();

            if (selectedProducts?.size == 0) {
                selectedProductsDiv.classList.add("hidden")
            }
        }

        document.addEventListener('DOMContentLoaded', toggleCollectionType);
    </script>
@endsection