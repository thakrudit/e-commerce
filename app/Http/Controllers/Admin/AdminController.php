<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Collection;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Log;

class AdminController extends Controller
{
    public function admin()
    {
        $title = 'Dashboard';
        return view('admin.index', compact('title'));
    }

    // Category controllers
    public function allCategories()
    {
        $categories = Category::all();
        $title = 'All Categories';
        return view('admin.category.all-categories', compact('title', 'categories'));
    }
    public function category()
    {
        $title = 'Category';
        return view('admin.category.category', compact('title'));
    }
    public function createCategory(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|unique:categories,name', // must be unique in categories table
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048' // max 2mb
        ]);

        $image = null;
        if ($request->hasFile('image')) {
            $file = $request->File('image');
            $ext = $file->getClientOriginalExtension();
            $fileName = time() . '.' . $ext;
            $file->move('upload/category', $fileName);
            $image = $fileName;
        }

        $data = Category::create([
            'name' => $validated['name'],
            'description' => $validated['description'] ?? null,
            'image' => $image,
        ]);
        return redirect()->route('all.categories')->with("message", "Category created successfully!");
    }
    public function editCategory($id)
    {
        $category = Category::find($id);
        $title = 'Edit Category';
        return view('admin.category.edit-category', compact('title', 'category'));
    }
    public function updateCategory(Request $request, $id)
    {
        $request->validate([
            'name' => [
                'required',
                'string',
                Rule::unique('categories', 'name')->ignore($id),
            ],
            'description' => 'nullable|string',
        ]);

        $category = Category::findOrFail($id);
        $category->name = $request->input('name', $category->name); // keep the old name
        $category->description = $request->description;
        $category->save();
        return redirect()->route('all.categories')->with('message', 'Category updated successfully~!'); // this message showwn in popup
    }
    public function deleteCategory(Request $request, $id)
    {
        $category = Category::findOrFail($id);
        $category->delete();
        return redirect()->route('all.categories')->with('message', 'Category deleted successfully!'); // this message showwn in popup
    }

    // Collection controllers
    public function allCollections()
    {
        $collections = Collection::all();
        $title = 'All Collections';
        return view('admin.collection.all-collections', compact('collections', 'title'));
    }
    public function collection()
    {
        $title = 'Collection';
        return view('admin.collection.collection', compact('title'));
    }
    public function createCollection(Request $request)
    {
        $commonRules = [
            'title' => 'required|string',
            'description' => 'nullable|string',
            'collection_type' => 'required|in:custom,smart',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048'
        ];

        if ($request->collection_type == "custom") {
            $rules = array_merge($commonRules, [
                'product_ids' => 'required|array',
                'product_ids.*' => 'integer|exists:products,id', //each value in the array exists in the products table
            ]);
        } else {
            $rules = array_merge($commonRules, [
                'rules' => 'required|array|min:1',
                'rules.*.column' => 'required|string|in:tag,category',
                'rules.*.relation' => 'required|string|in:equals,not_equals',
                'rules.*.condition' => 'required|string'
            ]);
        }

        $validated = $request->validate($rules);

        $image = null;
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $ext = $file->getClientOriginalExtension();
            $fileName = time() . '.' . $ext;
            $file->move('upload/collection', $fileName);
            $image = $fileName;
        }

        $additionalData = [];
        if ($request->collection_type == 'custom') {
            $additionalData['products'] = $validated['product_ids'];
        } else {
            $matchedProductIds = [];

            foreach ($validated['rules'] as $rule) {
                $column = $rule['column'];
                $relation = $rule['relation'];
                $condition = $rule['condition'];

                $query = Product::query();

                if ($column === 'tag') {
                    if ($relation === 'equals') {
                        $query->whereJsonContains('tags', $condition);
                    } elseif ($relation === 'not_equals') {
                        $query->whereJsonDoesntContain('tags', $condition);
                    }
                }

                if ($column === 'category') {
                    if ($relation === 'equals') {
                        $query->where('product_type', $condition);
                    } elseif ($relation === 'not_equals') {
                        $query->where('product_type', '!=', $condition);
                    }
                }

                $matchedIds = array_map('strval', $query->pluck('id')->toArray());
                $matchedProductIds = array_merge($matchedProductIds, $matchedIds);
            }
            $matchedProductIds = array_unique($matchedProductIds);

            $additionalData['rules'] = $validated['rules'];
            $additionalData['products'] = $matchedProductIds;
        }

        $data = Collection::create([
            'title' => $validated['title'],
            'handle' => $this->generateUniqueHandle($validated['title']),
            'description' => $validated['description'],
            'collection_type' => $validated['collection_type'],
            'image' => $image,
            ...$additionalData,
        ]);

        return redirect()->route('all.collections')->with("message", "Collection created successfully!");
    }
    public function generateUniqueHandle($title)
    {
        $base = Str::slug($title);
        $counter = 1;
        $original = "{$base}-{$counter}";

        while (Collection::where('handle', $original)->exists()) {
            $counter++;
            $original = "{$base}-{$counter}";
        }

        return $original;
    }
    public function searchProduct(Request $request)
    {
        $query = $request->get('q');

        $products = Product::where('title', 'like', '%' . $query . '%')
            ->select('id', 'title', 'image') // include image path
            ->limit(10)
            ->get();

        return response()->json($products);
    }
    public function editCollection($id)
    {
        $collection = Collection::find($id);
        $title = 'Edit Collection';
        return view('admin.collection.edit-collection', compact('title', 'collection'));
    }
    public function updateCollection(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|string',
            'description' => 'nullable|string',
        ]);

        $collection = Collection::findOrFail($id);
        $collection->title = $request->title;
        $collection->description = $request->description;
        $collection->save();
        return redirect()->route('all.collections')->with('message', 'Collection updated successfully~!'); // this message showwn in popup
    }
    public function deleteCollection(Request $request, $id)
    {
        $collection = Collection::findOrFail($id);
        $collection->delete();
        return redirect()->route('all.collections')->with('message', 'Collection deleted successfully!'); // this message showwn in popup
    }

    // Product controllers
    public function allProducts()
    {
        $products = Product::all();
        $title = 'All Products';
        return view('admin.product.all-products', compact('title', 'products'));
    }
    public function product()
    {
        $title = 'Product';
        return view('admin.product.product', compact('title'));
    }

    // Order controllers
    public function allOrders()
    {
        $title = 'All Orders';
        return view('admin.order.all-orders', compact('title'));
    }

    // User controllers
    public function allUsers()
    {
        $users = User::all();
        $title = 'All Users';
        return view('admin.user.all-users', compact('title', 'users'));
    }
    public function viewUser($id)
    {
        $user = User::find($id);
        $title = 'View User';
        return view('admin.user.view-user', compact('title', 'user'));

    }
    public function editUser($id)
    {
        $user = User::find($id);
        $title = 'Edit User';
        return view('admin.user.edit-user', compact('title', 'user'));
    }
    public function updateUser(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $user = User::findOrFail($id);
        $user->name = $request->name;
        $user->save();
        return redirect()->route('all.users')->with('message', 'User updated successfully~!'); // this message showwn in popup
    }
    public function deleteUser(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $user->delete();
        return redirect()->route('all.users')->with('message', 'User deleted successfully!'); // this message showwn in popup
    }
}
