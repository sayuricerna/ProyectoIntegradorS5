@extends('layouts.admin')

@section('content')
<div class="main-content-inner">
    <div class="main-content-wrap">
        {{-- Sección A: Tarjetas de métricas --}}
        <div class="tf-section-2 mb-30">
            <div class="flex gap20 flex-wrap-mobile">
                <div class="w-half">
                    <div class="wg-chart-default mb-20">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap14">
                                <div class="image ic-bg">
                                    <i class="icon-shopping-bag"></i>
                                </div>
                                <div>
                                    <div class="body-text mb-2">Total de Órdenes</div>
                                    <h4>{{ $totalOrders }}</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="wg-chart-default mb-20">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap14">
                                <div class="image ic-bg">
                                    <i class="icon-dollar-sign"></i>
                                </div>
                                <div>
                                    <div class="body-text mb-2">Monto Total</div>
                                    <h4>${{ number_format($totalRevenue, 2) }}</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="wg-chart-default mb-20">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap14">
                                <div class="image ic-bg">
                                    <i class="icon-shopping-bag"></i>
                                </div>
                                <div>
                                    <div class="body-text mb-2">Pedidos pendientes</div>
                                    <h4>{{ $pendingOrdersCount }}</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="wg-chart-default">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap14">
                                <div class="image ic-bg">
                                    <i class="icon-dollar-sign"></i>
                                </div>
                                <div>
                                    <div class="body-text mb-2">Monto de pedidos pendientes</div>
                                    <h4>${{ number_format($pendingOrdersAmount, 2) }}</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="w-half">
                    <div class="wg-chart-default mb-20">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap14">
                                <div class="image ic-bg">
                                    <i class="icon-shopping-bag"></i>
                                </div>
                                <div>
                                    <div class="body-text mb-2">Pedidos entregados</div>
                                    <h4>{{ $deliveredOrdersCount }}</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="wg-chart-default mb-20">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap14">
                                <div class="image ic-bg">
                                    <i class="icon-dollar-sign"></i>
                                </div>
                                <div>
                                    <div class="body-text mb-2">Monto de pedidos entregados</div>
                                    <h4>${{ number_format($deliveredOrdersAmount, 2) }}</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="wg-chart-default mb-20">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap14">
                                <div class="image ic-bg">
                                    <i class="icon-shopping-bag"></i>
                                </div>
                                <div>
                                    <div class="body-text mb-2">Órdenes canceladas</div>
                                    <h4>{{ $cancelledOrdersCount }}</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="wg-chart-default">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap14">
                                <div class="image ic-bg">
                                    <i class="icon-dollar-sign"></i>
                                </div>
                                <div>
                                    <div class="body-text mb-2">Monto de órdenes canceladas</div>
                                    <h4>${{ number_format($cancelledOrdersAmount, 2) }}</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="flex gap20 flex-wrap-mobile mb-30">
                <div class="w-half">
                    <div class="wg-chart-default mb-20">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap14">
                                <div class="image ic-bg">
                                    <i class="icon-box"></i>
                                </div>
                                <div>
                                    <div class="body-text mb-2">Producto más vendido</div>
                                    <h4>{{ $mostSoldProduct->name ?? 'N/A' }}</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="wg-chart-default">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap14">
                                <div class="image ic-bg">
                                    <i class="icon-box"></i>
                                </div>
                                <div>
                                    <div class="body-text mb-2">Producto menos vendido</div>
                                    <h4>{{ $leastSoldProduct->name ?? 'N/A' }}</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="w-half">
                    <div class="wg-chart-default mb-20">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap14">
                                <div class="image ic-bg">
                                    <i class="icon-shopping-bag"></i>
                                </div>
                                <div>
                                    <div class="body-text mb-2">Productos sin stock</div>
                                    <h4>{{ $outOfStockCount }}</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="wg-chart-default">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap14">
                                <div class="image ic-bg">
                                    <i class="icon-package"></i>
                                </div>
                                <div>
                                    <div class="body-text mb-2">Total de productos</div>
                                    <h4>{{ $totalProducts }}</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Sección B: Tabla de órdenes recientes --}}
        <div class="tf-section mb-30">
            <div class="wg-box">
                <div class="flex items-center justify-between">
                    <h5>Órdenes recientes</h5>
                    <div class="dropdown default">
                        <a class="btn btn-secondary dropdown-toggle" href="{{ route('admin.orders') }}">
                            <span class="view-all">Ver todo</span>
                        </a>
                    </div>
                </div>
                <div class="wg-table table-all-user">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th style="width: 80px">Orden #</th>
                                    <th>Nombre</th>
                                    <th class="text-center">Teléfono</th>
                                    <th class="text-center">Subtotal</th>
                                    <th class="text-center">IVA</th>
                                    <th class="text-center">Total</th>
                                    <th class="text-center">Estado</th>
                                    <th class="text-center">Fecha de pedido</th>
                                    <th class="text-center"># de Artículos</th>
                                    <th class="text-center">Entregado en</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($recentOrders as $order)
                                <tr>
                                    <td class="text-center">{{ $order->id }}</td>
                                    <td class="text-center">{{ $order->name }}</td>
                                    <td class="text-center">{{ $order->phone }}</td>
                                    <td class="text-center">${{ number_format($order->subtotal, 2) }}</td>
                                    <td class="text-center">${{ number_format($order->tax, 2) }}</td>
                                    <td class="text-center">${{ number_format($order->total, 2) }}</td>
                                    <td class="text-center">
                                        @if($order->status == 'delivered')
                                            <span class="badge bg-success">Entregado</span>
                                        @elseif($order->status == 'canceled')
                                            <span class="badge bg-danger">Cancelado</span>
                                        @else
                                            <span class="badge bg-warning">Pendiente</span>
                                        @endif
                                    </td>
                                    <td class="text-center">{{ $order->created_at->format('Y-m-d H:i') }}</td>
                                    <td class="text-center">{{ $order->orderItems->count() }}</td>
                                    <td class="text-center">{{ $order->delivered_date ? \Carbon\Carbon::parse($order->delivered_date)->format('Y-m-d H:i') : 'N/A' }}</td>
                                    <td class="text-center">
                                        <a href="{{ route('admin.order.details', ['id' => $order->id]) }}">
                                            <div class="list-icon-function view-icon">
                                                <div class="item eye">
                                                    <i class="icon-eye"></i>
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
            </div>
        </div>
    </div>
</div>
@endsection