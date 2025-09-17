<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\User;
use Illuminate\Http\Request;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        // Obtener el inicio y fin del mes actual
        $startOfMonth = Carbon::now()->startOfMonth();
        $endOfMonth = Carbon::now()->endOfMonth();

        // Métricas de órdenes y productos
        $totalUsers = User::count();
        $totalProducts = Product::count();
        $totalOrders = Order::whereBetween('created_at', [$startOfMonth, $endOfMonth])->count();
        
        // Ganancias totales solo de órdenes con transacción 'approved'
        $totalRevenue = Order::whereBetween('created_at', [$startOfMonth, $endOfMonth])
            ->whereHas('transaction', function ($query) {
                $query->where('status', 'approved');
            })
            ->sum('total');

        // Conteo de órdenes según su estado
        $pendingOrdersCount = Order::whereBetween('created_at', [$startOfMonth, $endOfMonth])->where('status', 'pending')->count();
        $pendingOrdersAmount = Order::whereBetween('created_at', [$startOfMonth, $endOfMonth])->where('status', 'pending')->sum('total');
        $deliveredOrdersCount = Order::whereBetween('created_at', [$startOfMonth, $endOfMonth])->where('status', 'delivered')->count();
        $deliveredOrdersAmount = Order::whereBetween('created_at', [$startOfMonth, $endOfMonth])->where('status', 'delivered')->sum('total');
        $cancelledOrdersCount = Order::whereBetween('created_at', [$startOfMonth, $endOfMonth])->where('status', 'canceled')->count();
        $cancelledOrdersAmount = Order::whereBetween('created_at', [$startOfMonth, $endOfMonth])->where('status', 'canceled')->sum('total');

        // Métricas de Productos (Nuevas)
        // 1. Producto más vendido (con pedidos pagados)
        $mostSoldProduct = Product::withCount(['orderItems as total_sold_quantity' => function($query) {
            $query->whereHas('order.transaction', function($q) {
                $q->where('status', 'approved');
            });
        }])
        ->orderByDesc('total_sold_quantity')
        ->first();

        // 2. Producto menos vendido (con pedidos pagados)
        $leastSoldProduct = Product::withCount(['orderItems as total_sold_quantity' => function($query) {
            $query->whereHas('order.transaction', function($q) {
                $q->where('status', 'approved');
            });
        }])
        ->orderBy('total_sold_quantity')
        ->first();
        
        // 3. Conteo de productos sin stock (con o sin variantes)
        $outOfStockCount = ProductVariant::where('quantity', 0)->count();

        // Órdenes recientes
        $recentOrders = Order::orderBy('created_at', 'DESC')->take(10)->get();

        return view('admin.index', compact(
            'totalUsers',
            'totalProducts',
            'totalOrders', 
            'totalRevenue', 
            'pendingOrdersCount', 
            'pendingOrdersAmount',
            'deliveredOrdersCount',
            'deliveredOrdersAmount',
            'cancelledOrdersCount',
            'cancelledOrdersAmount',
            'recentOrders',
            'mostSoldProduct', // Ahora es un producto directamente
            'leastSoldProduct', // Y este también
            'outOfStockCount'
        ));
    }
}