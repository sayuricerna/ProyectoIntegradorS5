<?php


namespace App\Http\Controllers;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Address;
use Session;
use Surfsidemedia\Shoppingcart\Facades\Cart;
use Illuminate\Support\Facades\Auth;
class CartController extends Controller
{
    public function index()
    {
        $items = Cart::instance('cart')->content();
        return view('cart', compact('items'));

    }
    public function addToCart(Request $request)
    {
        Cart::instance('cart')->add( $request->id, $request->name, $request->quantity, $request->price )->associate('App\Models\Product');  
        return redirect()->back();

    }
    public function increaseCartQuantity($rowId)
    {
        $product = Cart::instance('cart')->get($rowId);
        $qty = $product->qty +1;
        Cart::instance('cart')->update($rowId, $qty);
        return redirect()->back();

    }
    public function decreaseCartQuantity($rowId)
    {
        $product = Cart::instance('cart')->get($rowId);
        $qty = $product->qty -1;
        Cart::instance('cart')->update($rowId, $qty);
        return redirect()->back();

    }
    public function removeItem($rowId)
    {
        Cart::instance('cart')->remove($rowId);
        return redirect()->back();
    }
    public function emptyCart()
    {
        Cart::instance('cart')->destroy();
        return redirect()->back();
    }
    public function checkout()
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }
        $address = Address::where('user_id', Auth::user()->id)->where('is_default', 1)->first();
        return view('checkout', compact('address'));
    }
    public function placeOrder( Request $request )
    {
        $user_id = Auth::user()->id;
        $address = Address::where('user_id', $user_id)->where('is_default', true)->first();

        if (!$address) {
            $request->validate([
                'name' => 'required',
                'phone' => 'required',
                'zip' => 'required',
                'province' => 'required',
                'city'=> 'required',
                'address' => 'required',
                'reference'=> 'required',
                // 'country'=> 'required',
            ]);

            $address = new Address();
            $address->name= $request->name;
            $address->phone= $request->phone;
            $address->zip= $request->zip;
            $address->province= $request->province;
            $address->city= $request->city;
            $address->address= $request->address;
            $address->reference= $request->reference;
            $address->country= 'Ecuador';
            // $address->country= $request->country;
            $address->user_id = $user_id;
            $address->is_default = true;
            $address->save();
        }
        $this->setAmountForCheckout();
        $order = new Order();
        $order->user_id = $user_id;
        $order->subtotal = Session::get('checkout')['subtotal'];
        $order->discount = Session::get('checkout')['discount'];
        $order->tax = Session::get('checkout')['tax'];
        $order->total = Session::get('checkout')['total'];
        $order->name = $address->name;
        $order->phone = $address->phone;
        $order->address = $address->address;
        $order->city = $address->city;
        $order->province = $address->province;
        $order->country = $address->country;
        $order->reference = $address->reference;
        $order->zip = $address->zip;
        $order->save();

        foreach(Cart::instance('cart')->content() as $item) {
            $orderItem = new OrderItem();
            $orderItem->product_id = $item->id;
            $orderItem->order_id = $order->id;
            $orderItem->price = $item->price;
            $orderItem->quantity = $item->qty;
            $orderItem->save();
        }
        $transaction = new Transaction();
        $transaction->user_id = $user_id;
        $transaction->order_id = $order->id;
        $transaction->amount = $order->total;
        $transaction->status = 'pending';
        $transaction->save();
        Cart::instance('cart')->destroy();
        Session::forget('checkout');
        Session::put('order_id',$order->id);
        return redirect()->route('cart.order.confirmation');
        // return redirect()->route('cart.order.confirmation', ['order_id' => $order->id]);


        if ($request->mode == 'stripe') {
            // return redirect()->route('stripe.checkout', $order->id);
        } else if ($request->mode == 'tranference') {
            // return redirect()->route('transfer.checkout', $order->id);
        return redirect()->route('cart.order.confirmation', ['order_id' => $order->id]);

        }
                return redirect()->route('index');


    }
    public function setAmountForCheckout()
    {
        if (!Cart::instance('cart')->content()->count()>0)
        {
            Session::forget('checkout');
            return;
        }
        else{
            Session::put('checkout',[
                'discount' => 0,
                'subtotal' => Cart::instance('cart')->subtotal(),
                'tax' => Cart::instance('cart')->tax(),
                'total' => Cart::instance('cart')->total(),
            ]);
        }
    }
    public function orderConfirmation($order_id)
    {
        $order = Order::find($order_id);
        if ($order) {
            return view('order-confirmation', compact('order'));
        }
        return redirect()->route('cart.index');
        // if (Session::has('order_id')) {
        //     $order = Order::find(Session::get('order_id'));
        //     return view('order-confirmation', compact('order'));
        // }
        // return redirect()->route('cart.index');
    }
}
