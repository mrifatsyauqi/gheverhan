<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $today = Carbon::today();
        
        $totalRevenue = Order::whereIn('status', ['completed', 'delivered', 'shipped'])->sum('total');
        $todayOrders = Order::whereDate('created_at', $today)->count();
        $activeProducts = Product::active()->count();
        $totalCustomers = User::where('role', 'customer')->count();

        // Recent Orders
        $recentOrders = Order::with('user')->latest()->take(5)->get();

        // Sales Chart Data (Last 7 days)
        $chartDates = [];
        $chartData = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::today()->subDays($i);
            $chartDates[] = $date->format('d M');
            $chartData[] = Order::whereDate('created_at', $date)
                ->whereIn('status', ['completed', 'delivered', 'shipped', 'processing', 'confirmed', 'pending'])
                ->sum('total');
        }

        return view('admin.dashboard', compact(
            'totalRevenue',
            'todayOrders',
            'activeProducts',
            'totalCustomers',
            'recentOrders',
            'chartDates',
            'chartData'
        ));
    }
}
