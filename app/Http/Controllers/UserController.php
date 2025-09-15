<?php

namespace App\Http\Controllers;
use App\Models\Order;
use App\Models\Address;
use App\Models\OrderItem;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;
class UserController extends Controller
{
    public function index()
    {
        return view('user.index');
    }
    public function orders(){
        $orders = Order::where('user_id',Auth::user()->id)->orderBy('created_at', 'DESC')->paginate(10);
        return view('user.orders', compact('orders'));
    }
    public function orderDetails($order_id){
        $order = Order::where('user_id', Auth::user()->id)
            ->where('id', $order_id)
            ->first();
        if ($order) {
            $orderItems = OrderItem::where('order_id', $order->id)->orderBy('id')->paginate(12);
            $transaction = Transaction::where('order_id',  $order->id )->first();
            return view('user.order-details', compact('order','orderItems', 'transaction'));
        } 
        else {
            return redirect()->route('login');
        }
    }
    // CANCELAR PEDIDO
    public function cancelOrder(Request $request){
        $order = Order::find($request->order_id);
        $order->status = 'canceled';
        $order->canceled_date = Carbon::now();
        $order->save();
        return back()->with('status', 'Se ha cancelado el pedido exitosamente.');
    }
    // public function editAddress()
    // {
    //     $address = Address::where('user_id', Auth::id())->first();
    //     return view('user.address.edit', compact('address'));
    // }

    // public function updateAddress(Request $request)
    // {
    //     $request->validate([
    //         'name' => 'required|string',
    //         'phone' => 'required|string',
    //         'address' => 'required|string',
    //         'city' => 'required|string',
    //         'province' => 'required|string',
    //         'country' => 'required|string',
    //         'zip' => 'required|string',
    //     ]);

    //     $address = Address::updateOrCreate(
    //         ['user_id' => Auth::id()],
    //         [
    //             'name' => $request->name,
    //             'phone' => $request->phone,
    //             'address' => $request->address,
    //             'city' => $request->city,
    //             'province' => $request->province,
    //             'country' => $request->country,
    //             'zip' => $request->zip,
    //             'is_default' => true
    //         ]
    //     );

    //     return redirect()->back()->with('status', 'Dirección guardada correctamente.');
    // }
} 