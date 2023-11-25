<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\Log;

class CartController extends Controller
{

    public function updateCart(Request $request, $productId)
    {
        $product = Product::findOrFail($productId);

        if (auth()->check()) {
            $cart = $request->session()->get('cart', []);
            $cartItem = collect($cart)->firstWhere('id', $product->id);

            if ($cartItem) {
                $newQuantity = (int)$request->input('quantity');

                if($newQuantity <= $product->stock_quantity){ //users cannot add more items to the cart than the available stock
                    if ($newQuantity > 0) {
                        $existingItemIndex = null;

                        foreach ($cart as $index => $item) {
                            if ($item['id'] == $product->id) {
                                $existingItemIndex = $index;
                                break;
                            }
                        }
            
                        if ($existingItemIndex !== null) {
                            $cart[$existingItemIndex]['quantity'] = $newQuantity;

                            $request->session()->put('cart', $cart);

                            return redirect()->back()->with('success', 'Cart updated successfully.');
                        } 
                    }else {
                        $cart = array_filter($cart, function ($item) use ($product) {
                            return $item['id'] != $product->id;
                        });
                        $request->session()->put('cart', $cart);

                        return redirect()->back()->with('success', 'Item removed from the cart.');
                    }
                }else{
                    return redirect()->back()->with('error', 'Out of Stock');
                }
            }
        }

        return redirect()->back()->with('error', 'Unable to update the cart.');
    }
    public function removeFromCart(Request $request, $productId)
    {
        $cart = $request->session()->get('cart', []);
        $updatedCart = [];
        foreach ($cart as $item) {
            if ($item['id'] != $productId) {
                $updatedCart[] = $item;
            }
        }
        $request->session()->put('cart', $updatedCart);

        return response()->json(['message' => 'Item removed from the cart']);
    }
    
    public function updateTotalAmount(Request $request)
    {
        $cart = $request->session()->get('cart', []);

        $totalAmount = array_sum(array_map(function ($item) {
            return $item['price'] * $item['quantity'];
        }, $cart));

        Log::info('Total Amount: ' . $totalAmount);

        $request->session()->put('totalAmount', $totalAmount);

        return response()->json(['totalAmount' => $totalAmount]);
    }

}
