<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Purchase;
use App\Models\PurchaseItem;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class PurchaseController extends Controller
{
    /**
     * Menampilkan daftar pembelian.
     */
    public function index(Request $request): View
    {
        $search = $request->query('search');
        $status = $request->query('status');

        $purchases = Purchase::with(['supplier', 'user'])
            ->when($search, function ($query, $search) {
                $query->where(function ($subQuery) use ($search) {
                    $subQuery
                        ->where(
                            'purchase_number',
                            'like',
                            "%{$search}%"
                        )
                        ->orWhereHas('supplier', function ($supplierQuery) use ($search) {
                            $supplierQuery->where(
                                'name',
                                'like',
                                "%{$search}%"
                            );
                        });
                });
            })
            ->when($status, function ($query, $status) {
                $query->where('status', $status);
            })
            ->latest('purchase_date')
            ->latest('id')
            ->paginate(10)
            ->withQueryString();

        return view(
            'purchases.index',
            compact('purchases', 'search', 'status')
        );
    }

    /**
     * Menampilkan form pembelian.
     */
    public function create(): View
    {
        $suppliers = Supplier::orderBy('name')->get();
        $products = Product::orderBy('name')->get();

        return view(
            'purchases.create',
            compact('suppliers', 'products')
        );
    }

    /**
     * Menyimpan transaksi pembelian dan menambah stok.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'supplier_id' => [
                'required',
                'exists:suppliers,id',
            ],
            'purchase_date' => [
                'required',
                'date',
            ],
            'notes' => [
                'nullable',
                'string',
                'max:2000',
            ],
            'items' => [
                'required',
                'array',
                'min:1',
            ],
            'items.*.product_id' => [
                'required',
                'distinct',
                'exists:products,id',
            ],
            'items.*.quantity' => [
                'required',
                'integer',
                'min:1',
            ],
            'items.*.unit_price' => [
                'required',
                'numeric',
                'min:0',
            ],
        ]);

        $purchase = DB::transaction(function () use ($validated) {
            $total = 0;
            $preparedItems = [];

            foreach ($validated['items'] as $item) {
                $product = Product::whereKey($item['product_id'])
                    ->lockForUpdate()
                    ->firstOrFail();

                $quantity = (int) $item['quantity'];
                $unitPrice = (float) $item['unit_price'];

                $subtotal = round(
                    $quantity * $unitPrice,
                    2
                );

                $preparedItems[] = [
                    'product' => $product,
                    'quantity' => $quantity,
                    'unit_price' => $unitPrice,
                    'subtotal' => $subtotal,
                ];

                $total += $subtotal;
            }

            $purchase = Purchase::create([
                'purchase_number' => $this->generatePurchaseNumber(),
                'supplier_id' => $validated['supplier_id'],
                'user_id' => auth()->id(),
                'purchase_date' => $validated['purchase_date'],
                'total_amount' => round($total, 2),
                'status' => 'completed',
                'notes' => $validated['notes'] ?? null,
            ]);

            foreach ($preparedItems as $item) {
                PurchaseItem::create([
                    'purchase_id' => $purchase->id,
                    'product_id' => $item['product']->id,
                    'quantity' => $item['quantity'],
                    'unit_price' => $item['unit_price'],
                    'subtotal' => $item['subtotal'],
                ]);

                $item['product']->increment(
                    'stock',
                    $item['quantity']
                );
            }

            return $purchase;
        }, 3);

        return redirect()
            ->route('purchases.show', $purchase)
            ->with(
                'success',
                'Pembelian berhasil disimpan dan stok telah diperbarui.'
            );
    }

    /**
     * Menampilkan detail pembelian.
     */
    public function show(Purchase $purchase): View
    {
        $purchase->load([
            'supplier',
            'user',
            'items.product',
        ]);

        return view(
            'purchases.show',
            compact('purchase')
        );
    }

    /**
     * Membatalkan pembelian dan mengurangi stok kembali.
     *
     * Route pembatalan juga harus dilindungi middleware role:admin.
     */
    public function cancel(Purchase $purchase): RedirectResponse
    {
        DB::transaction(function () use ($purchase) {
            $purchase = Purchase::whereKey($purchase->id)
                ->lockForUpdate()
                ->firstOrFail();

            if ($purchase->status !== 'completed') {
                throw ValidationException::withMessages([
                    'purchase' => 'Transaksi ini sudah dibatalkan sebelumnya.',
                ]);
            }

            $purchase->load('items');

            $products = [];

            // Periksa semua stok sebelum melakukan perubahan.
            foreach ($purchase->items as $item) {
                $product = Product::whereKey($item->product_id)
                    ->lockForUpdate()
                    ->first();

                if (
                    !$product ||
                    $product->stock < $item->quantity
                ) {
                    throw ValidationException::withMessages([
                        'purchase' => 'Pembelian tidak dapat dibatalkan karena stok salah satu produk sudah tidak mencukupi.',
                    ]);
                }

                $products[$item->product_id] = $product;
            }

            // Kurangi stok sesuai jumlah pada transaksi pembelian.
            foreach ($purchase->items as $item) {
                $products[$item->product_id]->decrement(
                    'stock',
                    $item->quantity
                );
            }

            // Ubah status agar transaksi tidak bisa dibatalkan lagi.
            $purchase->update([
                'status' => 'cancelled',
            ]);
        }, 3);

        return redirect()
            ->route('purchases.show', $purchase)
            ->with(
                'success',
                'Pembelian berhasil dibatalkan dan stok telah disesuaikan.'
            );
    }

    /**
     * Membuat nomor pembelian unik.
     */
    private function generatePurchaseNumber(): string
    {
        do {
            $number = 'PB-'
                . now()->format('YmdHis')
                . '-'
                . strtoupper(
                    substr(bin2hex(random_bytes(3)), 0, 6)
                );
        } while (
            Purchase::where('purchase_number', $number)->exists()
        );

        return $number;
    }
}