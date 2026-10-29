<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Sale;
use App\Models\SaleItem;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class SaleController extends Controller
{
    public function index(Request $request): View
    {
        $search = $request->query('search');
        $status = $request->query('status');

        $sales = Sale::with('user')
            ->withCount('items')
            ->when($search, function ($query, $search) {
                $query->where(function ($subQuery) use ($search) {
                    $subQuery->where('sale_number', 'like', "%{$search}%")
                        ->orWhereHas('user', function ($userQuery) use ($search) {
                            $userQuery->where('name', 'like', "%{$search}%");
                        });
                });
            })
            ->when($status, fn ($query) => $query->where('status', $status))
            ->latest('sale_date')
            ->latest('id')
            ->paginate(10)
            ->withQueryString();

        return view('sales.index', compact('sales', 'search', 'status'));
    }

    public function create(): View
    {
        $products = Product::orderBy('name')->get();

        return view('sales.create', compact('products'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'sale_date' => ['required', 'date'],
            'notes' => ['nullable', 'string', 'max:2000'],
            'items' => ['required', 'array', 'min:1'],
            'items.*.product_id' => [
                'required',
                'distinct',
                'exists:products,id',
            ],
            'items.*.quantity' => ['required', 'integer', 'min:1'],
        ]);

        $sale = DB::transaction(function () use ($validated) {
            $preparedItems = [];
            $total = 0;

            foreach ($validated['items'] as $item) {
                $product = Product::whereKey($item['product_id'])
                    ->lockForUpdate()
                    ->firstOrFail();

                $quantity = (int) $item['quantity'];

                if ($product->stock < $quantity) {
                    throw ValidationException::withMessages([
                        'items' => "Stok {$product->name} tidak mencukupi. Stok tersedia: {$product->stock} {$product->unit}.",
                    ]);
                }

                $unitPrice = (float) $product->selling_price;
                $subtotal = round($quantity * $unitPrice, 2);

                $preparedItems[] = [
                    'product' => $product,
                    'quantity' => $quantity,
                    'unit_price' => $unitPrice,
                    'subtotal' => $subtotal,
                ];

                $total += $subtotal;
            }

            $sale = Sale::create([
                'sale_number' => $this->generateSaleNumber(),
                'user_id' => auth()->id(),
                'sale_date' => $validated['sale_date'],
                'total_amount' => round($total, 2),
                'status' => 'completed',
                'notes' => $validated['notes'] ?? null,
            ]);

            foreach ($preparedItems as $item) {
                SaleItem::create([
                    'sale_id' => $sale->id,
                    'product_id' => $item['product']->id,
                    'quantity' => $item['quantity'],
                    'unit_price' => $item['unit_price'],
                    'subtotal' => $item['subtotal'],
                ]);

                $item['product']->decrement('stock', $item['quantity']);
            }

            return $sale;
        }, 3);

        return redirect()
            ->route('sales.show', $sale)
            ->with('success', 'Transaksi penjualan berhasil disimpan dan stok telah diperbarui.');
    }

    public function show(Sale $sale): View
    {
        $sale->load(['user', 'items.product']);

        return view('sales.show', compact('sale'));
    }

    public function cancel(Sale $sale): RedirectResponse
    {
        $result = DB::transaction(function () use ($sale) {
            $sale = Sale::whereKey($sale->id)
                ->lockForUpdate()
                ->firstOrFail();

            if ($sale->status !== 'completed') {
                return 'Transaksi ini sudah dibatalkan sebelumnya.';
            }

            $sale->load('items');

            foreach ($sale->items as $item) {
                $product = Product::whereKey($item->product_id)
                    ->lockForUpdate()
                    ->first();

                if ($product) {
                    $product->increment('stock', $item->quantity);
                }
            }

            $sale->update(['status' => 'cancelled']);

            return null;
        }, 3);

        if ($result !== null) {
            return redirect()
                ->route('sales.show', $sale)
                ->with('error', $result);
        }

        return redirect()
            ->route('sales.show', $sale)
            ->with('success', 'Penjualan berhasil dibatalkan. Stok produk telah dikembalikan.');
    }

    private function generateSaleNumber(): string
    {
        do {
            $number = 'PJ-' . now()->format('YmdHis') . '-'
                . strtoupper(substr(bin2hex(random_bytes(3)), 0, 6));
        } while (Sale::where('sale_number', $number)->exists());

        return $number;
    }
}