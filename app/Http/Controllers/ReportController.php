<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ReportController extends Controller
{
    public function index()
    {
        return view('admin.reports.index');
    }

    public function exportSalesCSV(Request $request)
    {
        $startDate = $request->input('start_date', now()->startOfMonth()->toDateString());
        $endDate = $request->input('end_date', now()->toDateString());

        $transactions = Transaction::with(['user', 'items.product'])
            ->whereIn('status', ['completed', 'shipped', 'paid'])
            ->whereDate('created_at', '>=', $startDate)
            ->whereDate('created_at', '<=', $endDate)
            ->orderBy('created_at', 'desc')
            ->get();

        $filename = 'laporan_penjualan_' . $startDate . '_' . $endDate . '.csv';

        $headers = [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        $callback = function () use ($transactions) {
            $handle = fopen('php://output', 'w');
            
            // BOM for UTF-8 Excel compatibility
            fprintf($handle, chr(0xEF) . chr(0xBB) . chr(0xBF));

            // Header row
            fputcsv($handle, [
                'No',
                'Kode Transaksi',
                'Tanggal',
                'Pelanggan',
                'Email',
                'Telepon',
                'Produk',
                'Jumlah Item',
                'Total',
                'Metode Pembayaran',
                'Status'
            ], ';');

            $no = 1;
            foreach ($transactions as $transaction) {
                $products = $transaction->items->map(function ($item) {
                    return $item->product->name . ' (' . $item->quantity . ')';
                })->implode(', ');

                $totalItems = $transaction->items->sum('quantity');

                fputcsv($handle, [
                    $no++,
                    $transaction->transaction_code,
                    $transaction->created_at->format('d/m/Y H:i'),
                    $transaction->user->full_name ?? '-',
                    $transaction->user->email ?? '-',
                    $transaction->user->phone ?? '-',
                    $products,
                    $totalItems,
                    $transaction->total_amount,
                    $transaction->payment_method === 'transfer' ? 'Transfer Bank' : 'COD',
                    ucfirst($transaction->status)
                ], ';');
            }

            fclose($handle);
        };

        return new StreamedResponse($callback, 200, $headers);
    }

    public function exportProductsCSV(Request $request)
    {
        $products = \App\Models\Product::with('category')->get();

        $filename = 'laporan_produk_' . now()->format('Y-m-d') . '.csv';

        $headers = [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        $callback = function () use ($products) {
            $handle = fopen('php://output', 'w');
            
            fprintf($handle, chr(0xEF) . chr(0xBB) . chr(0xBF));

            fputcsv($handle, [
                'No',
                'Nama Produk',
                'Kategori',
                'Harga',
                'Stok',
                'Ukuran',
                'Warna',
                'Status'
            ], ';');

            $no = 1;
            foreach ($products as $product) {
                fputcsv($handle, [
                    $no++,
                    $product->name,
                    $product->category->name ?? '-',
                    $product->price,
                    $product->stock,
                    $product->size,
                    $product->color,
                    $product->is_active ? 'Aktif' : 'Nonaktif'
                ], ';');
            }

            fclose($handle);
        };

        return new StreamedResponse($callback, 200, $headers);
    }

    public function summary(Request $request)
    {
        $startDate = $request->input('start_date', now()->startOfMonth()->toDateString());
        $endDate = $request->input('end_date', now()->toDateString());

        $transactions = Transaction::whereIn('status', ['completed', 'shipped', 'paid'])
            ->whereDate('created_at', '>=', $startDate)
            ->whereDate('created_at', '<=', $endDate);

        $summary = [
            'total_revenue' => (clone $transactions)->sum('total_amount'),
            'total_transactions' => (clone $transactions)->count(),
            'avg_order_value' => (clone $transactions)->count() > 0 
                ? (clone $transactions)->sum('total_amount') / (clone $transactions)->count() 
                : 0,
        ];

        return view('admin.reports.index', compact('summary', 'startDate', 'endDate'));
    }
}
