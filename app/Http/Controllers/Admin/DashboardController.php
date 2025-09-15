<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
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

        // Métricas del mes actual
        $totalOrders = Order::whereBetween('created_at', [$startOfMonth, $endOfMonth])->count();
        $totalRevenue = Order::whereBetween('created_at', [$startOfMonth, $endOfMonth])->where('status', 'delivered')->sum('total');
        
        $pendingOrdersCount = Order::whereBetween('created_at', [$startOfMonth, $endOfMonth])->where('status', 'pending')->count();
        $pendingOrdersAmount = Order::whereBetween('created_at', [$startOfMonth, $endOfMonth])->where('status', 'pending')->sum('total');

        $deliveredOrdersCount = Order::whereBetween('created_at', [$startOfMonth, $endOfMonth])->where('status', 'delivered')->count();
        $deliveredOrdersAmount = Order::whereBetween('created_at', [$startOfMonth, $endOfMonth])->where('status', 'delivered')->sum('total');

        $cancelledOrdersCount = Order::whereBetween('created_at', [$startOfMonth, $endOfMonth])->where('status', 'canceled')->count();
        $cancelledOrdersAmount = Order::whereBetween('created_at', [$startOfMonth, $endOfMonth])->where('status', 'canceled')->sum('total');
        
        // Datos para la gráfica
        $salesData = Order::whereBetween('created_at', [$startOfMonth, $endOfMonth])
                        ->where('status', 'delivered')
                        ->orderBy('created_at')
                        ->get()
                        ->groupBy(function($date) {
                            return Carbon::parse($date->created_at)->format('d'); // Agrupa por día del mes
                        })
                        ->map(function ($group) {
                            return $group->sum('total');
                        });
        
        $daysInMonth = Carbon::now()->daysInMonth;
        $chartLabels = range(1, $daysInMonth);
        $chartData = array_fill_keys($chartLabels, 0);

        foreach ($salesData as $day => $total) {
            $chartData[(int)$day] = $total;
        }

        $chartData = array_values($chartData);
        
        // Órdenes recientes (para la tabla, las dejamos del mes completo o lo más reciente)
        $recentOrders = Order::orderBy('created_at', 'DESC')->take(10)->get();

        return view('admin.index', compact(
            'totalOrders', 
            'totalRevenue', 
            'pendingOrdersCount', 
            'pendingOrdersAmount',
            'deliveredOrdersCount',
            'deliveredOrdersAmount',
            'cancelledOrdersCount',
            'cancelledOrdersAmount',
            'recentOrders',
            'chartLabels',
            'chartData'
        ));
    }
}