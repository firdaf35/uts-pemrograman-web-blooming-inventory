<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\Purchase;
use App\Models\Sale;
use App\Models\Supplier;
use Illuminate\Support\Carbon;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $today = Carbon::today();
        $monthStart = Carbon::now()->startOfMonth();
        $monthEnd = Carbon::now()->endOfMonth();

        $totalProducts = Product::count();
        $totalStock = (int) Product::sum('stock');
        $totalCategories = Category::count();
        $totalSuppliers = Supplier::count();

        $salesToday = Sale::where('status', 'completed')
            ->whereDate('sale_date', $today)
            ->sum('total_amount');

        $purchasesToday = Purchase::where('status', 'completed')
            ->whereDate('purchase_date', $today)
            ->sum('total_amount');

        $salesThisMonth = Sale::where('status', 'completed')
            ->whereBetween('sale_date', [$monthStart, $monthEnd])
            ->sum('total_amount');

        $salesCountToday = Sale::where('status', 'completed')
            ->whereDate('sale_date', $today)
            ->count();

        $lowStockCount = Product::whereColumn('stock', '<=', 'minimum_stock')
            ->count();

        $lowStockProducts = Product::with('category')
            ->whereColumn('stock', '<=', 'minimum_stock')
            ->orderBy('stock')
            ->orderBy('name')
            ->limit(6)
            ->get();

        $recentSales = Sale::with('user')
            ->withCount('items')
            ->latest('sale_date')
            ->latest('id')
            ->limit(6)
            ->get();

        $recentPurchases = Purchase::with(['supplier', 'user'])
            ->latest('purchase_date')
            ->latest('id')
            ->limit(5)
            ->get();

        return view('dashboard', compact(
            'totalProducts',
            'totalStock',
            'totalCategories',
            'totalSuppliers',
            'salesToday',
            'purchasesToday',
            'salesThisMonth',
            'salesCountToday',
            'lowStockCount',
            'lowStockProducts',
            'recentSales',
            'recentPurchases'
        ));
    }
}