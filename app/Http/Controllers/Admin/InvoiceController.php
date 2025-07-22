<?php
namespace App\Http\Controllers\Admin;
use App\Models\Order;
use App\Models\Invoice;

use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
 use App\Http\Controllers\Controller;

class InvoiceController extends Controller
{
    public function generate(Order $order)
    {
        // Verificar si ya existe factura
        if ($order->invoice) {
            return $order->invoice;
        }

        // Obtener datos necesarios
        $user = $order->user;
        $transaction = $order->transaction;

        // items de factura
        $items = $order->orderItems->map(function ($item) {
            return [
                'name' => $item->product->name,
                'quantity' => $item->quantity,
                'price' => $item->price,
                'sku' => $item->product->sku,
                'description' => $item->product->short_description,
                'unit_price' => $item->price / $item->quantity
            ];
        });

        // Crear la factura
        $invoice = Invoice::create([
            'invoice_number' => $this->generateInvoiceNumber(),
            'issue_date' => now(),
            'order_id' => $order->id,
            'user_id' => $user->id,
            'client_name' => $order->name,
             'client_cedula' => $order->cedula,
            'client_email' => $user->email,
            'client_phone' => $order->phone,
            'client_address' => $order->address,
            'client_city' => $order->city,
            'client_province' => $order->province,
            'client_country' => $order->country,
            'client_zip' => $order->zip,
            'payment_method' => $transaction->mode,
            'subtotal' => $order->subtotal,
            'tax_amount' => $order->tax,
            'total_amount' => $order->total,
            'items' => $items,
            'pdf_path' => ''
        ]);

        // Generar PDF
        $this->generatePdf($invoice, $order);

        return $invoice;
    }

    protected function generateInvoiceNumber()
    {
        $prefix = 'FACT-';
        $date = now()->format('Ymd');
        $lastInvoice = Invoice::orderBy('id', 'desc')->first();
        
        $number = $lastInvoice ? (int)explode('-', $lastInvoice->invoice_number)[2] + 1 : 1;
        
        return $prefix . $date . '-' . str_pad($number, 5, '0', STR_PAD_LEFT);
    }

    protected function generatePdf(Invoice $invoice, Order $order)
    {
        $pdf = PDF::loadView('pdf.invoice', [
            'invoice' => $invoice,
            'order' => $order,
            'items' => $invoice->items
        ]);

        $filename = 'invoice_' . $invoice->invoice_number . '.pdf';
        $path = 'invoices/' . $filename;
        
        Storage::put($path, $pdf->output());
        $invoice->update(['pdf_path' => $path]);
    }

    public function download(Order $order)
    {
        // Verificar que la orden pertenece al usuario autenticado
        if (auth()->id() !== $order->user_id) {
            abort(403);
        }

        // Generar factura si no existe
        if (!$order->invoice) {
            $invoice = $this->generate($order);
        } else {
            $invoice = $order->invoice;
        }

        // Descargar el PDF
        return response()->download(
            Storage::path($invoice->pdf_path),
            'factura_'. $invoice->invoice_number . '.pdf'
        );
    }
}