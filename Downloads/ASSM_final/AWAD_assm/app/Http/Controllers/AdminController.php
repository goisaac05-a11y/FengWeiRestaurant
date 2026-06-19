<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Models\Product;

class AdminController extends Controller
{
    public function __construct()
    {
       $this->middleware('auth');

       $this->middleware(function ($request, $next) {
         if (!auth()->user() || auth()->user()->role !== 'admin') {
                abort(403, 'Unauthorized');
          }
           return $next($request);
       });
    }   
    // ==========================================
    // Authorize admin on every method
    // ==========================================
    private function authorizeAdmin()
    {
        Gate::authorize('admin-only');
    }

    // ==========================================
    // 1. List all products
    // ==========================================
    public function index()
    {
        $this->authorizeAdmin();

        $products = Product::orderBy('category')->orderBy('name')->get();

        return view('admin.index', compact('products'));
    }

    // ==========================================
    // 2. Show edit form
    // ==========================================
    public function edit($id)
    {
        $this->authorizeAdmin();

        $product = Product::findOrFail($id);

        return view('admin.edit', compact('product'));
    }

    // ==========================================
    // 3. Update product
    // ==========================================
    public function update(Request $request, $id)
    {
        $this->authorizeAdmin();

        $request->validate([
            'name'        => 'required|string|max:100',
            'description' => 'nullable|string',
            'price'       => 'required|numeric|min:0',
            'category'    => 'required|string|max:50',
            'image_url'   => 'nullable|string|max:255',
        ]);

        $product = Product::findOrFail($id);
        $product->update([
            'name'        => $request->name,
            'description' => $request->description,
            'price'       => $request->price,
            'category'    => $request->category,
            'image_url'   => $request->image_url ?? $product->image_url,
        ]);

        return redirect()->route('admin.index')->with('success', '"' . $product->name . '" updated successfully.');
    }

    // ==========================================
    // 4. Show create form
    // ==========================================
    public function create()
    {
        $this->authorizeAdmin();

        return view('admin.create');
    }

    // ==========================================
    // 5. Store new product
    // ==========================================
    public function store(Request $request)
    {
        $this->authorizeAdmin();

        $request->validate([
            'name'        => 'required|string|max:100',
            'description' => 'nullable|string',
            'price'       => 'required|numeric|min:0',
            'category'    => 'required|string|max:50',
            'image_url'   => 'nullable|string|max:255',
        ]);

        // Auto-generate slug from name
        $slug = \Illuminate\Support\Str::slug($request->name);

        // Ensure slug is unique
        $count = Product::where('slug', 'like', $slug . '%')->count();
        if ($count > 0) {
            $slug = $slug . '-' . ($count + 1);
        }

        Product::create([
            'slug'        => $slug,
            'name'        => $request->name,
            'description' => $request->description,
            'price'       => $request->price,
            'category'    => $request->category,
            'image_url'   => $request->image_url,
        ]);

        return redirect()->route('admin.index')->with('success', '"' . $request->name . '" added successfully.');
    }

    // ==========================================
    // 6. Delete product
    // ==========================================
    public function destroy($id)
    {
        $this->authorizeAdmin();

        $product = Product::findOrFail($id);
        $name    = $product->name;
        $product->delete();

        return redirect()->route('admin.index')->with('success', '"' . $name . '" deleted successfully.');
    }
}