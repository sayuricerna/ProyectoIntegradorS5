<?php
 
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Transaction;

class OrderController extends Controller
{
    public function orders()
    {
        $orders = Order::orderBy('created_at', 'DESC')->paginate(12);
        return view('admin.orders', compact('orders'));
    }

    public function orderDetails($id)
    {
        $order = Order::find($id);
        $orderItems = OrderItem::where('order_id', $id)->orderBy('id')->paginate(12);
        $transaction = Transaction::where('order_id', $id)->first();
        return view('admin.order-details', compact('order','orderItems','transaction'));
    }

}