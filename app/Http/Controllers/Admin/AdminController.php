<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Collection;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Log;

class AdminController extends Controller
{
    public function admin()
    {
        return view('admin.index', ['title' => 'Dashboard']);
    }

    // Category controllers
    public function allCategories()
    {
        return view('admin.category.all-categories', ['title' => 'All Categories']);
    }
    public function category()
    {
        return view('admin.category.category', ['title' => 'Category']);
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

    // Collection controllers
    public function allCollections()
    {
        return view('admin.collection.all-collections', ['title' => 'All Collections']);
    }
    public function collection()
    {
        return view('admin.collection.collection', ['title' => 'Collection']);
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
                'column' => 'required|string|in:tag,category',
                'relation' => 'required|string|in:equals,not_equals',
                'condition' => 'required|string'
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
            $additionalData['column'] = $validated['column'];
            $additionalData['relation'] = $validated['relation'];
            $additionalData['condition'] = $validated['condition'];
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
        $original = $base;
        $counter = 1;

        while (Collection::where('handle', $base)->exists()) {
            $counter++;
            $base = "{$original}-{$counter}";
        }

        return $base;
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

    // Product controllers
    public function allProducts()
    {
        return view('admin.product.all-products', ['title' => 'All Products']);
    }
    public function product()
    {
        return view('admin.product.product', ['title' => 'Product']);
    }

    // Order controllers
    public function allOrders()
    {
        return view('admin.order.all-orders', ['title' => 'All Orders']);
    }

    // User controllers
    public function allUsers()
    {
        $users = User::all();
        // Log::info('All user:', ['users' => $users]);
        $title = 'All Users';
        return view('admin.user.all-users', compact('title', 'users'));
    }
    public function viewUser($id)
    {
        $user = User::find($id);
        Log::info('View user:', ['user' => $user]);
        $title = 'View Users';
        return view('admin.user.view-user', compact('title', 'user'));

    }
    public function editUser($id)
    {
        $user = User::find($id);
        $title = 'Edit Users';
        // Log::info('Edit user:', ['user' => $user]);
        return view('admin.user.edit-user', compact('title', 'user'));

    }
    public function updateUser(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $user = User::findOrFail($request->id);
        // Log::info('User log when edit', ['user'=> $user]);
        $user->name = $request->name;
        $user->save();
        return redirect()->route('all.users')->with('message', 'User updated successfully~!'); // this message showwn in popup
    }
    public function deleteUser(Request $request)
    {
        $user = User::findOrFail($request->id);
        $user->delete();
        return redirect()->route('all.users')->with('message', 'User deleted successfully!'); // this message showwn in popup
    }
}
