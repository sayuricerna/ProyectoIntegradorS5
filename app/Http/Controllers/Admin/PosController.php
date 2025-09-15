<?php

// namespace App\Http\Controllers\Admin;

// use App\Http\Controllers\Controller;
// use App\Models\User;
// use Illuminate\Http\Request;
// use Illuminate\Support\Str;
// use Illuminate\Support\Facades\File;
// use Intervention\Image\Laravel\Facades\Image;
// use Carbon\Carbon;

// class PosController extends Controller
// {
//     public function pos()
//     {
//         $users = Pos::orderBy('id', 'DESC')->paginate(10);
//         return view('admin.pos', compact('pos'));
//     }

// }


namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderProduct;
use App\Models\Product;
use App\Models\ProductVariant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PosController extends Controller
{
    public function showPos()
    {
        // Muestra la vista principal del POS.
        // Aquí puedes precargar algunos productos o categorías si lo deseas.
        $products = Product::with('variants')->paginate(20);
        return view('admin.pos', compact('products'));
    }

    public function processOrder(Request $request)
    {
        // 1. Validar los datos del formulario
        $request->validate([
            'customer_name' => 'nullable|string|max:255',
            'customer_email' => 'nullable|email|max:255',
            'payment_method' => 'required|string',
            'products' => 'required|array|min:1',
            'products.*.variant_id' => 'required|exists:product_variants,id',
            'products.*.quantity' => 'required|integer|min:1',
        ]);
        
        try {
            DB::beginTransaction();

            // 2. Crear una nueva orden (similar a tu lógica de checkout online)
            $order = new Order();
            $order->customer_name = $request->input('customer_name');
            $order->customer_email = $request->input('customer_email');
            $order->payment_method = $request->input('payment_method');
            $order->status = 'completed'; // Un pedido en POS se considera completado
            $order->total = 0; // Se calculará a continuación
            $order->save();

            $totalPrice = 0;

            // 3. Procesar los productos del carrito
            foreach ($request->input('products') as $productData) {
                $variant = ProductVariant::findOrFail($productData['variant_id']);

                // Asegúrate de que haya suficiente stock
                if ($variant->quantity < $productData['quantity']) {
                    DB::rollBack();
                    return back()->with('error', 'No hay suficiente stock para el producto: ' . $variant->product->name . ' SKU: ' . $variant->sku);
                }

                $price = $variant->on_sale ? $variant->sale_price : $variant->regular_price;
                $subtotal = $price * $productData['quantity'];
                $totalPrice += $subtotal;

                // 4. Crear la entrada en la tabla order_product
                OrderProduct::create([
                    'order_id' => $order->id,
                    'product_id' => $variant->product_id,
                    'variant_id' => $variant->id,
                    'quantity' => $productData['quantity'],
                    'price' => $price,
                ]);

                // 5. Actualizar el stock del producto
                $variant->decrement('quantity', $productData['quantity']);
            }

            // 6. Actualizar el total de la orden y guardar
            $order->update(['total' => $totalPrice]);

            DB::commit();

            return redirect()->route('admin.pos')->with('success', 'Venta realizada con éxito! Orden #' . $order->id);

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Ocurrió un error al procesar la venta: ' . $e->getMessage());
        }
    }
}