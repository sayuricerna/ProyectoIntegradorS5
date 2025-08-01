@extends('layouts.admin')
@section('content')
{{-- DASHBOARD --}}
    {{-- <div class="main-content-inner">
        <div class="main-content-wrap">
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
                                <div class="body-text mb-2">Total de Ordenes</div>
                                <h4>3</h4>
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
                                <h4>481.34</h4>
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
                                <h4>3</h4>
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
                                <h4>481.34</h4>
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
                                <div class="body-text mb-2">Pedidos entrgados</div>
                                <h4>0</h4>
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
                                <h4>0.00</h4>
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
                                <div class="body-text mb-2">Ordenes canceladas</div>
                                <h4>0</h4>
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
                                <div class="body-text mb-2">Monto de ordenes canceladas</div>
                                <h4>0.00</h4>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            </div>

            <div class="wg-box">
            <div class="flex items-center justify-between">
                <h5>Earnings revenue</h5>
                <div class="dropdown default">
                    <button class="btn btn-secondary dropdown-toggle" type="button"
                        data-bs-toggle="dropdown" aria-haspopup="true"
                        aria-expanded="false">
                        <span class="icon-more"><i class="icon-more-horizontal"></i></span>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li>
                            <a href="javascript:void(0);">Esta semana</a>
                        </li>
                        <li>
                            <a href="javascript:void(0);">semana pasada</a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="flex flex-wrap gap40">
                <div>
                    <div class="mb-2">
                        <div class="block-legend">
                            <div class="dot t1"></div>
                            <div class="text-tiny">Revenue</div>
                        </div>
                    </div>
                    <div class="flex items-center gap10">
                        <h4>$37,802</h4>
                        <div class="box-icon-trending up">
                            <i class="icon-trending-up"></i>
                            <div class="body-title number">0.56%</div>
                        </div>
                    </div>
                </div>
                <div>
                    <div class="mb-2">
                        <div class="block-legend">
                            <div class="dot t2"></div>
                            <div class="text-tiny">Orden</div>
                        </div>
                    </div>
                    <div class="flex items-center gap10">
                        <h4>$28,305</h4>
                        <div class="box-icon-trending up">
                            <i class="icon-trending-up"></i>
                            <div class="body-title number">0.56%</div>
                        </div>
                    </div>
                </div>
            </div>
            <div id="line-chart-8"></div>
            </div>

            </div>
            <div class="tf-section mb-30">

            <div class="wg-box">
            <div class="flex items-center justify-between">
                <h5>Recent orders</h5>
                <div class="dropdown default">
                    <a class="btn btn-secondary dropdown-toggle" href="#">
                        <span class="view-all">Ver todo</span>
                    </a>
                </div>
            </div>
            <div class="wg-table table-all-user">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th style="width: 80px">OrdenNo</th>
                                <th>Nombre</th>
                                <th class="text-center">Telefono</th>
                                <th class="text-center">Subtotal</th>
                                <th class="text-center">IVA</th>
                                <th class="text-center">Total</th>

                                <th class="text-center">Estado</th>
                                <th class="text-center">Fecha de pedido</th>
                                <th class="text-center">Total de Artículos</th>
                                <th class="text-center">Entregado en</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="text-center">1</td>
                                <td class="text-center">Sayuri Melina</td>
                                <td class="text-center">17590026535</td>
                                <td class="text-center">$172.00</td>
                                <td class="text-center">$36.12</td>
                                <td class="text-center">$208.12</td>

                                <td class="text-center">pedido</td>
                                <td class="text-center">2025-02-11 00:54:14</td>
                                <td class="text-center">2</td>
                                <td></td>
                                <td class="text-center">
                                    <a href="#">
                                        <div class="list-icon-function view-icon">
                                            <div class="item eye">
                                                <i class="icon-eye"></i>
                                            </div>
                                        </div>
                                    </a>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            </div>

            </div>
        </div>
    </div> --}}
@endsection
