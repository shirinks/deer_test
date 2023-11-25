<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Support\Facades\Log;

class OrderController extends Controller
{
    public function viewOrderSummary(Request $request)
    {
        session()->forget('cart');
        $user = auth()->user();
        $lastOrder = Order::latest()->first();
        $orderItems = OrderItem::where('order_id',$lastOrder->id)->get();

        return view('order_summary', compact('orderItems','lastOrder'));
    }

}
