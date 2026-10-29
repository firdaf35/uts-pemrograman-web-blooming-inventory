<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Purchase;
use App\Models\Sale;
use App\Models\Supplier;
use App\Models\SaleItem;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Carbon;

class ReportController extends Controller
{
    public function index(Request $request): View
    {
        $startDate = $request->input('start_date', now()->startOfMonth()->toDateString());
        $endDate = $request->input('end_date', now()->toDateString());

        $validated = validator(
            ['start_date' => $startDate, 'end_date' => $endDate],
            [
                'start_date' => ['required', 'date'],
                'end_date' => ['required', 'date', 'after_or_equal:start_date'],
            ]
        )->validate();

        $start = Carbon::parse($validated['start_date'])->startOfDay();
        $end = Carbon::parse($validated['end_date'])->endOfDay();

        $purchasesQuery = Purchase::whereBetween('purchase_date', [$start, $end]);
        $salesQuery = Sale::whereBetween('sale_date', [$start, $end]);

        $totalProducts = Product::count();
        $totalSuppliers = Supplier::count();

        $totalPurchases = (clone $purchasesQuery)
            ->where('status', 'completed')
            ->count();

        $totalSales = (clone $salesQuery)
            ->where('status', 'completed')
            ->count();

        $purchaseValue = (clone $purchasesQuery)
            ->where('status', 'completed')
            ->sum('total_amount');

        $salesValue = (clone $salesQuery)
            ->where('status', 'completed')
            ->sum('total_amount');

        $lowStockProducts = Product::with('category')
            ->whereColumn('stock', '<=', 'minimum_stock')
            ->orderBy('stock')
            ->orderBy('name')
            ->paginate(8, ['*'], 'stock_page')
            ->withQueryString();

        $bestSellingProducts = SaleItem::query()
            ->join('sales', 'sales.id', '=', 'sale_items.sale_id')
            ->join('products', 'products.id', '=', 'sale_items.product_id')
            ->where('sales.status', 'completed')
            ->whereBetween('sales.sale_date', [$start, $end])
            ->selectRaw('products.id, products.name, products.sku, SUM(sale_items.quantity) as total_quantity, SUM(sale_items.subtotal) as total_revenue')
            ->groupBy('products.id', 'products.name', 'products.sku')
            ->orderByDesc('total_quantity')
            ->limit(10)
            ->get();

        $recentPurchases = (clone $purchasesQuery)
            ->with(['supplier', 'user'])
            ->latest('purchase_date')
            ->latest('id')
            ->limit(5)
            ->get();

        $recentSales = (clone $salesQuery)
            ->with('user')
            ->latest('sale_date')
            ->latest('id')
            ->limit(5)
            ->get();

        return view('reports.index', compact(
            'startDate',
            'endDate',
            'totalProducts',
            'totalSuppliers',
            'totalPurchases',
            'totalSales',
            'purchaseValue',
            'salesValue',
            'lowStockProducts',
            'bestSellingProducts',
            'recentPurchases',
            'recentSales'
        ));
    }
}