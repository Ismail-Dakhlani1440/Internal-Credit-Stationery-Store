<?php

namespace App\Http\Controllers;

use App\Models\Department;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class OrderController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::where('department_id', auth()->user()->department_id)->get();
        $orders = Order::whereIn('user_id', $users->pluck('id'))->where('status', '!=', 'rejected')->orWhere('status', '!=', 'approved')->with('products')->get();
        return view('orders.index', compact('orders'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
   public function store(Request $request)
{
    $user = auth()->user();

    $products = $request->products;

    if (empty($products) || !is_array($products)) {
        return response()->json([
            'success' => false,
            'message' => 'No products selected.'
        ], 400);
    }
    $totalTokens = 0;
    
    foreach ($products as $item) {
        $product = Product::find($item['id']);
        if (!$product) {
            return response()->json([
                'success' => false,
                'message' => "Product ID {$item['id']} not found."
            ], 404);
        }
        $totalTokens += $item['quantity'] * $product->tokens_required;
    }

    if ($user->tokens < $totalTokens) {
        return response()->json([
            'success' => false,
            'message' => "You don't have enough tokens."
        ], 400);
    }

   
    foreach ($products as $item) {
        $product = Product::find($item['id']);
        if ($product->stock < $item['quantity']) {
            return response()->json([
                'success' => false,
                'message' => "Not enough stock for {$product->name}."
            ], 400);
        }
    }

    try {
        DB::transaction(function() use ($products, $user, &$orderTotalTokens) {

            $order = Order::create([
                'user_id' => $user->id,
                'total_price' => 0,
                'status' => 'pending'
            ]);

            $orderTotalTokens = 0;

            foreach ($products as $item) {
                $product = Product::findOrFail($item['id']);

                
                if ($user->role->title == 'manager') {
                    $status = 'approved'; 
                } else {
                    $status = $product->premium ? 'pending' : 'approved';
                }

                $order->products()->attach($product->id, [
                    'quantity' => $item['quantity'],
                    'tokens_required' => $product->tokens_required,
                    'status' => $status
                ]);

                
                if (!$product->premium) {
                    $product->stock -= $item['quantity'];
                    $product->save();
                   

                    $tokensToDeduct = $item['quantity'] * $product->tokens_required;
                    $user->tokens -= $tokensToDeduct;
                    $user->save();

                    $orderTotalTokens += $tokensToDeduct;
                }
            }

            $order->total_price = $orderTotalTokens;
            $order->save();

            
            if (method_exists($order, 'status')) {
                $order->status($order);
            }
        });

        return response()->json([
            'success' => true,
            'message' => 'Order created successfully!'
        ]);

    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => 'Failed to create order: ' . $e->getMessage()
        ], 500);
    }
}


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $orders = auth()->user()->orders()->get();
       
        return view('orders', compact('orders'));

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
