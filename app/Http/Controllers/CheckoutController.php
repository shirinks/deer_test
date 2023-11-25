<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Product;
use App\Models\OrderItem;

class CheckoutController extends Controller
{
    public function processCheckout(Request $request)
    {
        $validator =Validator::make($request->all(), [
            'fullName' => 'required|string|max:255',
            'address' => 'required|string|max:1000',
            'cardNumber' => 'required|string|max:16',
            'expiryDate' => 'required|string|max:5',
            'cvv' => 'required|string|max:3',
        ]);
        if ($validator->passes()) {

            $cart = $request->session()->get('cart', []);
            $subTotal = collect($cart)->sum(function ($item) {
                return $item['quantity'] * $item['price'];
            });
            $totalQuantity = collect($cart)->sum('quantity');

            $order = Order::create([
                'order_number'      =>  'ORD-'.strtoupper(uniqid()),
                'user_id'           => auth()->user()->id,
                'status'            =>  'pending',
                'grand_total'       =>  $subTotal,
                'item_count'        =>  $totalQuantity,
                'payment_status'    =>  0,
                'payment_method'    =>  null,
                'full_name'        =>   $request['fullName'],
                'address'           =>  $request['address'],
                'post_code'         =>  $request['post_code'],
                'phone_number'      =>  $request['phoneNumber'],
                'notes'             =>  $request['notes']
            ]);
       
            if ($order) {
        
                foreach ($cart as $key=>$item)
                {
                    $product = Product::where('name',$item['name'])->first();
        
                    $orderItem = new OrderItem([
                        'product_id'    =>  $product->id,
                        'quantity'      =>  $item['quantity'],
                        'price'         =>  $item['quantity']*$item['price'],
                    ]);
                    
                    $order->items()->save($orderItem);
                    //update stock_quantity

                    if ($product->stock_quantity < 0) {
                        // Handle negative stock quantity (e.g., set it to 0 or trigger an alert)
                        $product->update(['stock_quantity' => 0]);
                    }else{
                        $product->update(['stock_quantity' => $product->stock_quantity-$item['quantity']]);
                    }
                    $product->save();

                }
            }
            return response()->json(['message' => $order]);
        }else{
            return response()->json(['message' => $validator]);
        }
    }
}
