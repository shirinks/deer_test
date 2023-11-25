<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\Log;

class ProductController extends Controller
{
   
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $products = Product::all();
        return view('index', compact('products'));
    }

    public function search(Request $request)
    {
        $searchTerm = $request->input('search');

        $products = Product::where('name', 'like', '%' . $searchTerm . '%')
                          ->get();

        return view('index', compact('products'));
    }

    public function addToCart(Request $request, $productId)
    {
        $product = Product::findOrFail($productId);
        if(auth()->check()) {
            if($product->stock_quantity > 0){
                $cart = $request->session()->get('cart', []);
                $existingItemIndex = null;

                foreach ($cart as $index => $item) {
                    if ($item['id'] == $product->id) {
                        $existingItemIndex = $index;
                        break;
                    }
                }
    
                if ($existingItemIndex !== null) {
                    $cart[$existingItemIndex]['quantity'] += 1;
                } else {
                    $cart[] = [
                        'id' => $product->id,
                        'name' => $product->name,
                        'description'=>$product->description,
                        'price' => $product->price,
                        'quantity'=> 1,
                    ];
                }
                $request->session()->put('cart', $cart);

                return redirect()->back()->with('success', 'Item added to cart successfully.');

            }else{
                return redirect()->back()->with('error', 'Out Of Stock');
            }
        }

        return redirect()->back()->with('error', 'You must be logged in to add items to the cart.');
    }

}
