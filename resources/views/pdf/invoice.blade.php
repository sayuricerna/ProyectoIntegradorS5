
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Factura {{ $invoice->invoice_number }}</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 12px; }
        .invoice-container { max-width: 800px; margin: 0 auto; padding: 20px; }
        .header { display: flex; justify-content: space-between; margin-bottom: 20px; }
        .company-info, .invoice-info { width: 45%; }
        .company-name { font-size: 18px; font-weight: bold; }
        .invoice-title { text-align: center; font-size: 20px; margin: 20px 0; }
        .client-info { margin-bottom: 30px; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        th, td { padding: 8px; border: 1px solid #ddd; }
        th { background-color: #f2f2f2; }
        .text-right { text-align: right; }
        .totals { width: 50%; margin-left: auto; }
        .footer { margin-top: 50px; text-align: center; font-size: 10px; }
    </style>
</head>
<body>
    <div class="invoice-container">
        <div class="header">
            <div class="company-info">
                <div class="company-name"> SwimRoom</div>
                <div>Dirección:Ecuador, Santo Domingo de Los Colorados 230150 </div>
                <div>Teléfono: 0995712907</div>
                <div>Email: emial@swinroom.com</div>
                <div>RUC: 1759026535</div>
            </div>
            
            <div class="invoice-info">
                <div><strong>Factura N°:</strong> {{ $invoice->invoice_number }}</div>
                <div><strong>Fecha:</strong> {{ $invoice->issue_date->format('d/m/Y') }}</div>
                <div><strong>Pedido N°:</strong> {{ $order->id }}</div>
                <div><strong>Método de Pago:</strong> {{ ucfirst($invoice->payment_method) }}</div>
            </div>
        </div>
        
        <div class="invoice-title">FACTURA</div>
        
        <div class="client-info">
            <div><strong>Cliente:</strong> {{ $invoice->client_name }}</div>
            <div><strong>Cedula:</strong> {{ $invoice->client_cedula }}</div>
            <div><strong>Email:</strong> {{ $invoice->client_email }}</div>
            <div><strong>Teléfono:</strong> {{ $invoice->client_phone }}</div>
            <div><strong>Dirección:</strong> {{ $invoice->client_address }}</div>
            <div><strong>País/Provincia/Ciudad:</strong>{{ $invoice->client_country }}, {{ $invoice->client_province }}, {{ $invoice->client_city }}</div>
        </div>
        
        <table>
            <thead>
                <tr>
                    <th>Producto</th>
                    <th>Cantidad</th>
                    <th>P. Unitario</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach($items as $item)
                <tr>
                    <td>{{ $item['name'] }}<br><small>{{ $item['description'] }}</small></td>
                    <td>{{ $item['quantity'] }}</td>
                    <td class="text-right">${{ number_format($item['unit_price'], 2) }}</td>
                    <td class="text-right">${{ number_format($item['price'], 2) }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
        
        <div class="totals">
            <table>
                <tr>
                    <td><strong>Subtotal:</strong></td>
                    <td class="text-right">${{ number_format($invoice->subtotal, 2) }}</td>
                </tr>
                <tr>
                    <td><strong>IVA (15%):</strong></td>
                    <td class="text-right">${{ number_format($invoice->tax_amount, 2) }}</td>
                </tr>
                <tr>
                    <td><strong>Total:</strong></td>
                    <td class="text-right">${{ number_format($invoice->total_amount, 2) }}</td>
                </tr>
            </table>
        </div>
        
        <div class="footer">
            <p>Gracias por su compra</p>
            <p>SwimRoom - Ecuador</p>
            {{-- icono --}}
            <i class="icon-shopping-bag"></i>
        </div>
    </div>
</body>
</html>