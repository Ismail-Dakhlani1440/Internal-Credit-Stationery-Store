<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Categorie;
use Illuminate\Http\Request;

class InventoryController extends Controller
{
    public function index()
    {
        $products = Product::all();

        return view('admin.inventory.index', compact('products'));
    }

    public function create()
    {
        $categories = Categorie::all();

        return view('admin.inventory.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'categorie_id' => 'required|exists:categories,id',
            'stock' => 'required|integer|min:0',
            'tokens_required' => 'required|numeric|min:0',
            'premium' => 'boolean',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        Product::create($validated);

        return redirect()->route('inventory.index')->with('success', 'Product created successfully.');
    }

    public function edit(Product $inventory)
    {
        $categories = Categorie::all();

        return view('admin.inventory.edit', [
            'product' => $inventory,
            'categories' => $categories
        ]);
    }


    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'categorie_id' => 'required|exists:categories,id',
            'stock' => 'required|integer|min:0',
            'tokens_required' => 'required|numeric|min:0',
            'premium' => 'boolean',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $validated['premium'] = $request->has('premium');

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('products', 'public');
        }

        $product->update($validated);

        return redirect()->route('inventory.index')->with('success', 'Product updated successfully.');
    }

    public function destroy(Product $inventory)
    {
        $inventory->delete();

        return redirect()->route('inventory.index')
            ->with('success', 'Product deleted successfully.');
    }
}
