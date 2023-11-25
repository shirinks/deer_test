<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Order;
use App\Models\OrderItem;

class OrderHistoryController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $items = OrderItem::leftJoin('orders', 'orders.id', '=', 'order_items.order_id')
        ->select('order_items.*','orders.*')
        ->where('orders.user_id', Auth::id())
        ->paginate(10);
        return view('order_history', ['orders' => $items]);
    }
}
