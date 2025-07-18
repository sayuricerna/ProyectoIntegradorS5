<?php


namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Address;
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
                'country'=> 'required',
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

    }
}
