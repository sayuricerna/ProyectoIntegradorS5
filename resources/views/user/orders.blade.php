@extends('layouts.app')

@section('content')
  <style>
    .table> :not(caption)>tr>th {
      padding: 0.625rem 1.5rem .625rem !important;
      background-color: #000000ff !important;
    }

    .table>tr>td {
      padding: 0.625rem 1.5rem .625rem !important;
    }

    .table-bordered> :not(caption)>tr>th,
    .table-bordered> :not(caption)>tr>td {
      border-width: 1px 1px;
      border-color: #000000ff;
    }

    .table> :not(caption)>tr>td {
      padding: .8rem 1rem !important;
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
  </style>
  <main class="pt-90" style="padding-top: 0px;">
    <div class="mb-4 pb-4"></div>
    <section class="my-account container">
        <h2 class="page-title">Orders</h2>
        <div class="row">
            <div class="col-lg-2">
                 @include('user.account-nav')
            </div>
            <div class="col-lg-10">
                <div class="wg-table table-all-user">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th style="width: 80px">PedidoNo</th>
                                    <th>Nombres y Apellidos</th>
                                    <th class="text-center">Teléfono</th>
                                    <th class="text-center">Subtotal</th>
                                    <th class="text-center">IVA(15%)</th>
                                    <th class="text-center">Total</th>
                                    
                                    <th class="text-center">Estado</th>
                                    <th class="text-center">Fecha de emisión</th>
                                    <th class="text-center">Productos</th>
                                    <th class="text-center">Fecha de entrega</th>
                                    <th></th>
                                </tr>
                            </thead> 
                            <tbody> 
                                @foreach ($orders as $order) 
                                <tr>
                                    <td class="text-center">{{ $order->id }}</td>  
                                    <td class="text-center">{{ $order->name }}</td>
                                    <td class="text-center">{{ $order->phone }}</td>
                                    <td class="text-center">{{ $order->subtotal }}</td>
                                    <td class="text-center">{{ $order->tax }}</td>
                                    <td class="text-center">{{ $order->total }}</td>
                                    
                                    <td class="text-center">
                                      
                                      @if($order->status == 'delivered')
                                      <span class="badge bg-success">Enviado</span>
                                      @elseif($order->status == 'canceled')
                                      <span class="badge bg-danger">Cancelado</span>
                                      @else
                                      <span class="badge bg-warning">Pendiente</span>
                                      @endif

                                    </td>
                                    <td class="text-center">{{ $order->created_at }}</td>
                                    <td class="text-center">{{ $order->orderItems->count() }}</td>
                                    <td class="text-center">{{ $order->delivered_date }}</td>
                                    <td class="text-center">
                                        <a href="{{ route('user.order.details', ['order_id'=>$order->id]) }}">
                                        <div class="list-icon-function view-icon">
                                            <div class="item eye">
                                                <i class="fa fa-eye"></i>
                                            </div>                                        
                                        </div>
                                        </a>
                                    </td>
                                </tr>
                                @endforeach
                                
                                                                   
                            </tbody>
                        </table>                
                    </div>
                </div>
                <div class="divider"></div>
                <div class="flex items-center justify-between flex-wrap gap10 wgp-pagination">                
                    {{ $orders->links('pagination::bootstrap-5') }}
                </div>
            </div>
            
        </div>
    </section>
</main>




@endsection