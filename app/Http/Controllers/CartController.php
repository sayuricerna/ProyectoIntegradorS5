<?php


namespace App\Http\Controllers;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Invoice;
use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Address;
use Session;
use Surfsidemedia\Shoppingcart\Facades\Cart;
use Illuminate\Support\Facades\Auth;
use App\Services\PaymentProcessor; 
use App\Services\Payments\BankPaymentStrategy;
use App\Services\Payments\StripePaymentStrategy; 
use App\Http\Controllers\Admin\InvoiceController; 
class CartController extends Controller
{
    // CODIGO COMENTADO FUNCIONANDO
    protected $paymentProcessor;

    public function __construct(PaymentProcessor $paymentProcessor)
    {
        $this->paymentProcessor = $paymentProcessor;
    }
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
            $item = Cart::instance('cart')->get($rowId);
    $product = Product::find($item->id); // Buscamos el producto en la base de datos

    // Verificamos si la cantidad en el carrito ya es igual o mayor al stock
    if ($item->qty >= $product->quantity) {
        // Si no hay más stock, regresamos con un mensaje de error
        return redirect()->back()->with('error_message', 'Se ha alcanzado el stock máximo para este producto.');
    }

    // Si hay stock, aumentamos la cantidad
    $qty = $item->qty + 1;
    Cart::instance('cart')->update($rowId, $qty);
    return redirect()->back();
        // $product = Cart::instance('cart')->get($rowId);
        // $qty = $product->qty +1;
        // Cart::instance('cart')->update($rowId, $qty);
        // return redirect()->back();

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
        $stripeKey = env('STRIPE_KEY');
        return view('checkout', compact('address','stripeKey'));
    }
    public function placeOrder( Request $request )
    {
        // Validacion de stock
        foreach (Cart::instance('cart')->content() as $item) {
            $product = Product::find($item->id);
            if ($product->quantity < $item->qty) {
                // Redirige al carrito si no hay stock suficiente para algún producto
                return redirect()->route('cart.index')->with('error_message', 'El producto "' . $product->name . '" ya no tiene suficiente stock. Por favor, revisa tu carrito.');
            }
        }
        // Validacion de direccion
        $user_id = Auth::user()->id;
        $address = Address::where('user_id', $user_id)->where('is_default', true)->first();

        if (!$address) {
            $request->validate([
                'name' => 'required',
                'cedula' =>'required',
                'phone' => 'required',
                'zip' => 'required',
                'province' => 'required',
                'city'=> 'required',
                'address' => 'required',
                'reference'=> 'required',
            ]);

            $address = new Address();
            $address->name= $request->name;
            $address->cedula = $request->cedula;
            $address->phone= $request->phone;
            $address->zip= $request->zip;
            $address->province= $request->province;
            $address->city= $request->city;
            $address->address= $request->address;
            $address->reference= $request->reference;
            $address->country= 'Ecuador';
            $address->user_id = $user_id;
            $address->is_default = true;
            $address->save();
        }
        // Crear la orden
        $this->setAmountForCheckout();
        $order = new Order();
        $order->user_id = $user_id;
        $order->subtotal = Session::get('checkout')['subtotal'];
        $order->discount = Session::get('checkout')['discount'];
        $order->tax = Session::get('checkout')['tax'];
        $order->total = Session::get('checkout')['total'];
        $order->name = $address->name;
        $order->cedula = $address->cedula;
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
    

        // STRATEGY 
        switch ($request->mode) {
            case 'stripe':
                $this->paymentProcessor->setPaymentStrategy(new StripePaymentStrategy());
                break;
            case 'tranference': 
                $this->paymentProcessor->setPaymentStrategy(new BankPaymentStrategy());
                break;
            default:
                return redirect()->back()->with('error', 'Método de pago no soportado.');
        }
        $paymentSuccess = $this->paymentProcessor->process($order, $request);
        if (!$paymentSuccess) {
            return redirect()->back()->with('error', 'El pago no pudo ser procesado.');
        }

        if ($paymentSuccess) {
                // ===================== INICIO: BLOQUE PARA DESCONTAR STOCK =====================
            foreach ($order->orderItems as $item) {
                $product = Product::find($item->product_id);
                $product->quantity -= $item->quantity; // Restamos la cantidad comprada
                // Si el stock llega a 0, actualizamos el estado
                if ($product->quantity <= 0) {
                    $product->stock_status = 'outofstock';
                }
                
                $product->save(); // Guardamos los cambios en el producto
            }

                    Cart::instance('cart')->destroy();
                    Session::forget('checkout');
                    Session::put('order_id',$order->id);
                    $invoiceController = new InvoiceController();
                    $invoiceController->generate($order); 
                    return redirect()->route('cart.order.confirmation', ['order_id' => $order->id]);
                } else {
                    // Si el pago falla se elimina la orden
                    $order->delete(); 
                    return redirect()->back(); 
                }
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
        if (Session::has('order_id')) {
            $order = Order::with('orderItems')->find(Session::get('order_id'));
            return view('order-confirmation', compact('order'));
        }
        return redirect()->route('cart.index');
    }

}
