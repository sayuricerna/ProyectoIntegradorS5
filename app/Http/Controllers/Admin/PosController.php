<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderProduct;
use App\Models\ProductVariant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Admin\InvoiceController;

class PosController extends Controller
{
    public function showSimplePos()
    {
        // Muestra la vista del POS simple
        return view('admin.pos-simple');
    }

    public function processSimpleOrder(Request $request)
    {
        // 1. Validar los datos del formulario
        $request->validate([
            'customer_name' => 'required|string|max:255',
            'customer_cedula' => 'nullable|string|max:255',
            'customer_phone' => 'nullable|string|max:255',
            'payment_method' => 'required|string',
            'products' => 'required|array|min:1',
            'products.*.sku' => 'required|string',
            'products.*.quantity' => 'required|integer|min:1',
        ]);
        
        try {
            DB::beginTransaction();

            // 2. Crear una nueva orden con los datos del formulario
            $order = new Order();
            // Asigna un usuario por defecto si no hay uno (en este caso, null)
            $order->user_id = auth()->check() ? auth()->id() : null; 
            $order->customer_name = $request->input('customer_name');
            $order->customer_cedula = $request->input('customer_cedula');
            $order->customer_phone = $request->input('customer_phone');
            $order->payment_method = $request->input('payment_method');
            $order->status = 'completed';
            $order->total = 0; 
            $order->save();

            $totalPrice = 0;

            // 3. Procesar los productos enviados por SKU
            foreach ($request->input('products') as $productData) {
                // Busca el producto o variante por SKU
                $variant = ProductVariant::where('sku', $productData['sku'])->firstOrFail();

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

                // 5. Actualizar el stock
                $variant->decrement('quantity', $productData['quantity']);
            }

            // 6. Actualizar el total de la orden
            $order->update(['total' => $totalPrice]);

            DB::commit();

            // 7. Generar la factura y redirigir a la descarga
            $invoiceController = new InvoiceController();
            $invoiceController->generate($order);
            
            return redirect()->route('admin.invoices.download', $order->id)
                             ->with('success', 'Venta registrada con éxito!');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Ocurrió un error al procesar la venta: ' . $e->getMessage());
        }
    }
}