@extends('layouts.app')

@section('content')
<style>
.pt-90 {
    padding-top: 90px !important;
}

.pr-6px {
    padding-right: 6px;
    text-transform: uppercase;
}

.my-account .page-title {
    font-size: 1.5rem;
    font-weight: 700;
    text-transform: uppercase;
    margin-bottom: 40px;
    border-bottom: 1px solid;
    padding-bottom: 13px;
}

.my-account .wg-box {
    display: -webkit-box;
    display: -moz-box;
    display: -ms-flexbox;
    display: -webkit-flex;
    display: flex;
    padding: 24px;
    flex-direction: column;
    gap: 24px;
    border-radius: 12px;
    background: var(--White);
    box-shadow: 0px 4px 24px 2px rgba(20, 25, 38, 0.05);
}

.bg-success {
    background-color: #40c710 !important;
}

.bg-danger {
    background-color: #f44032 !important;
}

.bg-warning {
    background-color: #f5d700 !important;
    color: #000;
}

.table-transaction>tbody>tr:nth-of-type(odd) {
    --bs-table-accent-bg: #fff !important;

}

.table-transaction th,
.table-transaction td {
    padding: 0.625rem 1.5rem .25rem !important;
    color: #000 !important;
}

.table> :not(caption)>tr>th {
    padding: 0.625rem 1.5rem .25rem !important;
    background-color: #6a6e51 !important;
}

.table-bordered>:not(caption)>*>* {
    border-width: inherit;
    line-height: 32px;
    font-size: 14px;
    border: 1px solid #e1e1e1;
    vertical-align: middle;
}

.table-striped .image {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 50px;
    height: 50px;
    flex-shrink: 0;
    border-radius: 10px;
    overflow: hidden;
}

.table-striped td:nth-child(1) {
    min-width: 250px;
    padding-bottom: 7px;
}

.pname {
    display: flex;
    gap: 13px;
}

.table-bordered> :not(caption)>tr>th,
.table-bordered> :not(caption)>tr>td {
    border-width: 1px 1px;
    border-color: #6a6e51;
}
</style>
<main class="pt-90" style="padding-top: 0px;">
    <div class="mb-4 pb-4"></div>
    <section class="my-account container">
        <h2 class="page-title">Detalles del pedido</h2>
        <div class="row">
            <div class="col-lg-2">
            @include('user.account-nav')
            </div>
            <div class="col-lg-10">
                <div class="wg-box">
                    <div class="flex items-center justify-between gap10 flex-wrap">
                        <div class="row">
                            <div class="col-6">
                                <h5>Detalles del Pedido</h5>
                            </div>
                            <div class="col-6 text-right">
                                <a class="btn btn-sm btn-danger" href="{{ route('user.orders') }}">Back</a>
                            </div>
                        </div>
                    </div>
                    <div class="table-responsive">
                        @if (Session::has('status'))
                            <p class="alert alert-success">  {{ Session::get('status') }} </p> 
                        @endif
                        <table class="table  table-bordered table-striped table-transaction">
                            <tr>
                                <th>Pedido#</th>
                                <td>{{$order->id}}</td>
                                <th>Contacto</th>
                                <td>{{$order->phone}}</td>
                                <th>Código ZIP</th>
                                <td>{{$order->zip}}</td>
                            </tr>
                            <tr> 
                                <th>Fecha de pedido</th>
                                <td>{{ $order->created_at }}</td>
                                <th>Fecha de Envio</th>
                                <td>{{ $order->delivered_date }}</td>
                                <th>Fecha de cancelación</th>
                                <td>{{ $order->canceled_date  }}</td>
                            </tr>
                            <tr>
                                <th>Estado de Pedido</th>
                                <td colspan="5"> 
                                    @if($order->status == 'delivered')
                                    <span class="badge bg-success">Enviado</span>
                                    @elseif($order->status == 'canceled')
                                    <span class="badge bg-danger">Cancelado</span>
                                    @else
                                    <span class="badge bg-warning">Pendiente</span>
                                    @endif
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
                <div class="wg-box">
                    <div class="flex items-center justify-between gap10 flex-wrap">
                        <div class="wg-filter flex-grow">
                        <h5></h5>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered">
                            <thead>
                            <tr>
                            <th>Nombre</th>
                            <th class="text-center">Precio</th>
                            <th class="text-center">Cantidad</th>
                            <th class="text-center">link Interno</th>
                            <th class="text-center">Categoría</th>
                            <th class="text-center">Marca</th>
                            <th class="text-center">opción</th>
                            <th class="text-center">Estado de devolución</th>
                            <th class="text-center">__</th>
                            </tr>
                            </thead>
                            <tbody>
                                @foreach ($orderItems as $item)
                                <tr>
                                    <td class="pname">
                                        <div class="image">
                                            <img src="{{ asset('uploads/products/thumbnails') }}/{{ $item->product->image }}" alt="{{ $item->product->name }}" class="image">
                                        </div>
                                        <div class="name">
                                            <a href="{{ route('shop.product.details',['product_slug'=>$item->product->slug]) }}" target="_blank" class="body-title-2">{{ $item->product->name }}</a>
                                        </div>
                                    </td>
                                    <td class="text-center">${{$item->price}}</td>
                                    <td class="text-center">{{ $item->quantity }}</td>
                                    <td class="text-center">{{ $item->product->sku }}</td>
                                    <td class="text-center">{{ $item->product->category->name }}</td>
                                    <td class="text-center">{{ $item->product->brand->name }}</td>
                                    <td class="text-center">{{ $item->options }}</td>
                                    <td class="text-center">{{ $item->status == 0 ? "No":"Yes" }}</td>
                                    <td class="text-center">
                                        <div class="list-icon-function view-icon">
                                            <div class="item eye">
                                                <i class="icon-eye"></i>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                </div>

                <div class="divider"></div>
                <div class="flex items-center justify-between flex-wrap gap10 wgp-pagination">
                {{ $orderItems->links('pagination::bootstrap-5') }}
                </div>
                </div>
                <div class="wg-box mt-5">
                    <h5>Dirección de Envío</h5>
                    <div class="my-account__address-item col-md-6">
                        <div class="my-account__address-item__detail">
                            <p>{{ $order->name }}</p>
                            <p>{{ $order->address }}</p>
                            <p>{{ $order->province }}</p>
                            <p>{{ $order->city }},{{$order->country}}</p>
                            <p>{{ $order->reference }}</p>
                            <p>{{ $order->zip }}</p>
                            <br>
                            <p>Teléfono celular : {{ $order->phone }}</p>
                        </div>
                    </div>
                </div>
                <div class="wg-box mt-5">
                    <h5>Detalles de Pago</h5>
                    <table class="table table-striped table-bordered table-transaction">
                        <tbody>
                            <tr>
                                <th>Subtotal</th>
                                <td> {{ $order->subtotal }}</td>
                                <th>IVA</th>
                                <td> {{ $order->tax }}</td>
                            </tr>
                            <tr>
                                <th>Total</th>
                                <td> {{ $order->total }}</td>
                                <th>Modo de Pago</th>
                                <td> {{ $transaction->mode }}</td>
                                <th>Estado</th>
                                <td>  
                                    @if ($transaction->status == 'approved')
                                    <span class="badge bg-success">Aprovado</span>
                                    @elseif ($transaction->status == 'declined')
                                    <span class="badge bg-danger">Rechazado</span>
                                    @elseif ($transaction->status == 'declined')
                                    <span class="badge bg-danger">Reembolso</span>
                                    @else 
                                    <span class="badge bg-warning">Pendiente</span> 
                                    @endif
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                {{-- <div class="wg-box mt-5 ">
                    <form action="{{ route('user.order.invoice', ['order_id' => $order->id]) }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-primary">Descargar Factura</button>
                    </form>
                </div> --}}

                @if ($order->status == 'ordered' || $order->status == 'pending')
                {{-- CANCELACION DE PEDIDO --}}
                <div class="wg-box mt-5 text-right">
                    <form action="{{ route('user.order.cancel') }}" method="POST">
                        @csrf
                        @method('PUT') 
                        <input type="hidden" name="order_id" value="{{ $order->id }}">
                        <button type="button" class="btn btn-danger cancel-order">Cancelar Pedido</button>
                    </form>
                </div>                    
                @endif


            </div>
        </div>
    </section>
</main>
@endsection


@push('scripts')
<script>
    $(function(){
        $('.cancel-order').on('click',function(e){
            e.preventDefault();
            var form = $(this).closest('form');
            swal({
                title: "Esta seguro de Cancelar el Pedido",
                text: "Una vez cancelado no se podrá recuperar",
                type: "advertencia",
                buttons: ["No","Si"],
                confirmButtonColor: '#dc3545'
            }).then(function(result){
                if(result)
                {
                    form.submit();
                }
            });
        });
    });
</script>
    
@endpush