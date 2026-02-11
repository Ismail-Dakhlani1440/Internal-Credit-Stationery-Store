<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
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
        return view('admin.inventory.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'categorie_id' => 'required|exists:categories,id',
            'stock' => 'required|integer|min:0',
            'tokens_required' => 'required|numeric|min:0',
            'premium' => 'boolean',
            'image' => 'nullable|string'
        ]);

        Product::create($validated);

        return redirect()->route('admin.inventory.index')->with('success', 'Product created successfully.');
    }

    public function edit(Product $product)
    {
        return view('admin.inventory.edit', compact('product'));
    }

    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'categorie_id' => 'required|exists:categories,id',
            'stock' => 'required|integer|min:0',
            'tokens_required' => 'required|numeric|min:0',
            'premium' => 'boolean',
            'image' => 'nullable|string'
        ]);

        $product->update($validated);

        return redirect()->route('admin.inventory.index')->with('success', 'Product updated successfully.');
    }

    public function destroy(Product $product)
    {
        $product->delete();
        return redirect()->route('admin.inventory.index')->with('success', 'Product deleted successfully.');
    }
}