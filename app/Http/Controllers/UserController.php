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
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Hash;
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
    public function editProfile()
    {
        // Obtiene el usuario autenticado y lo pasa a la vista
        $user = Auth::user();
        return view('user.account-edit', compact('user'));
    }
    public function updateProfile(Request $request)
    {
        // Encuentra al usuario autenticado
        $user = Auth::user();

        // Valida los datos del formulario
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                // Ignora el email actual para evitar errores de unicidad
                Rule::unique('users')->ignore($user->id),
            ],
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        // Actualiza el nombre y el email
        $user->name = $request->name;
        $user->email = $request->email;

        // Actualiza la contraseña si el campo no está vacío
        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        return redirect()->back()->with('status', '¡Perfil actualizado correctamente!');
    }

    public function showAddressForm()
    {
        // Busca la dirección del usuario autenticado.
        // Si no existe, se creará una instancia de Address vacía.
        $address = Address::where('user_id', Auth::id())->firstOrNew(['user_id' => Auth::id()]);
        return view('user.address-form', compact('address'));
    }

    public function saveAddress(Request $request)
    {
        $user = Auth::user();

        // Valida los datos del formulario de dirección
        $request->validate([
            'name' => 'required|string|max:255',
            'cedula' => [
                'required',
                'string',
                'max:255',
                Rule::unique('addresses')->ignore($user->id, 'user_id'),
            ],
            'phone' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'province' => 'required|string|max:255',
            'country' => 'required|string|max:255',
            'zip' => 'required|string|max:255',
            'reference' => 'nullable|string|max:255',
        ]);

        // Usa updateOrCreate para simplificar: si el usuario ya tiene una dirección, la actualiza,
        // si no, la crea.
        Address::updateOrCreate(
            ['user_id' => $user->id],
            $request->only([
                'name',
                'cedula',
                'phone',
                'address',
                'city',
                'province',
                'country',
                'zip',
                'reference'
            ])
        );

        return redirect()->back()->with('status', '¡Dirección guardada correctamente!');
    }
} 