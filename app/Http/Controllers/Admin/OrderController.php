<?php
 
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Transaction;
use Carbon\Carbon;
use Illuminate\Http\Request;

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
    public function updateOrderStatus(Request $request)
    {
        $order = Order::find($request->order_id);
        $order->status = $request->order_status;
        if($request->order_status == 'delivered') {
            $order->delivered_date = Carbon::now();
        } else if ($request->order_status == 'cancelled') {
            $order->cancelled_date = Carbon::now();
        }
        $order->save();
        if($request->order_status == 'delivered') {
            $transaction = Transaction::where('order_id', $request->order_id)->first();
            $transaction->status = 'approved';
            $transaction->save();
        }
        return back()->with('status', 'Order status updated successfully.');
        
    }

}