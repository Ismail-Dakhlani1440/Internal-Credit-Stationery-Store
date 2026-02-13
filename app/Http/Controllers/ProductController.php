<?php

namespace App\Http\Controllers;

use App\Models\Categorie;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $products = Product::query();
        
        
        if($request->filled('categories')){
             $products->whereIn('categorie_id' , $request->categories);
        }
        if($request->filled('min_price')){
            $products->where('tokens_required' ,'>=' ,$request->min_price);
        }
        if($request->filled('max_price')){
            $products->where('tokens_required' ,'<=' ,$request->max_price);
        }
      $products  = $products->get();
        $categories = Categorie::all();
        return view('store' , compact('products', 'categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
     
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
           'name' => 'required|string',
           'stock' => 'required|integer',
           'tokens_required' => 'required|numeric|min:0',
           'image' => 'required|image|mimes:jpg,png,jpeg,gif,svg|max:2048',
           'categorie_id' => 'required|exists:categories,id',
        ]);
        if($request->hasFile('image')){
            $path = $request->file('image')->store('images' ,'public');
            $validated['image'] = $path;
        }

        Product::create($validated);
        return redirect()->route('inventory.index')->with('success','product added successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $product = Product::find($id);
        
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $product = Product::find($id);
        
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $product = Product::find($id);
        $validated = $request->validate([
           'name' => 'required|string',
           'stock' => 'required|integer',
           'categorie_id' => 'required|exisits:categories,id',
        ]);
        $product->update($validated);
        return redirect()->route('products.index')->with('success','product updated successfully');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $product = Product::find($id);
        $product->delete();
        return redirect()->route('products.index')->with('success','product deleted successfully');
    }
   
}
