<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\TransactionItem;
use App\Models\Product;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class TransactionController extends Controller
{
    public function index(Request $request)
    {
        if (auth()->user()->isAdmin()) {
            $query = Transaction::with('user');
            
            // Filter by status
            if ($request->has('status') && $request->status) {
                $query->where('status', $request->status);
            }
            
            // Filter by payment method
            if ($request->has('payment_method') && $request->payment_method) {
                $query->where('payment_method', $request->payment_method);
            }
            
            // Search by transaction code or username
            if ($request->has('search') && $request->search) {
                $search = $request->search;
                $query->where(function($q) use ($search) {
                    $q->where('transaction_code', 'like', "%{$search}%")
                      ->orWhereHas('user', function($q) use ($search) {
                          $q->where('username', 'like', "%{$search}%")
                            ->orWhere('full_name', 'like', "%{$search}%");
                      });
                });
            }
            
            $transactions = $query->latest()->paginate(15);
            
            // Get status counts for summary
            $statusCounts = [
                'pending' => Transaction::where('status', 'pending')->count(),
                'processing' => Transaction::where('status', 'processing')->count(),
                'paid' => Transaction::where('status', 'paid')->count(),
                'shipped' => Transaction::where('status', 'shipped')->count(),
                'completed' => Transaction::where('status', 'completed')->count(),
                'cancelled' => Transaction::where('status', 'cancelled')->count(),
            ];
            
            return view('admin.transactions.index', compact('transactions', 'statusCounts'));
        }

        $transactions = auth()->user()->transactions()->latest()->paginate(10);
        return view('user.transactions.index', compact('transactions'));
    }

    public function show(Transaction $transaction)
    {
        // Manual authorization: user can only view their own transactions, admin can view all
        if (!auth()->user()->isAdmin() && $transaction->user_id !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }
        
        $transaction->load(['items.product', 'user']);
        
        // Return admin view if user is admin
        if (auth()->user()->isAdmin()) {
            return view('admin.transactions.show', compact('transaction'));
        }
        
        return view('transactions.show', compact('transaction'));
    }

    public function checkout(Request $request)
    {
        $request->validate([
            'payment_method' => 'required|in:transfer,cod',
            'shipping_address' => 'required|string',
            'notes' => 'nullable|string'
        ]);

        $cart = session()->get('cart', []);
        
        if (empty($cart)) {
            return redirect()->route('cart.index')->with('error', 'Keranjang belanja kosong.');
        }

        DB::beginTransaction();

        try {
            $total = 0;
            $transaction = Transaction::create([
                'user_id' => auth()->id(),
                'transaction_code' => Transaction::generateTransactionCode(),
                'total_amount' => 0,
                'payment_method' => $request->payment_method,
                'shipping_address' => $request->shipping_address,
                'notes' => $request->notes,
                'status' => $request->payment_method === 'cod' ? 'pending' : 'pending'
            ]);

            foreach ($cart as $item) {
                $product = Product::find($item['id']);
                
                if (!$product || $product->stock < $item['quantity']) {
                    throw new \Exception('Produk ' . $item['name'] . ' stok tidak mencukupi.');
                }

                TransactionItem::create([
                    'transaction_id' => $transaction->id,
                    'product_id' => $product->id,
                    'quantity' => $item['quantity'],
                    'price' => $item['price']
                ]);

                $product->decrement('stock', $item['quantity']);
                $total += $item['price'] * $item['quantity'];
            }

            $transaction->update(['total_amount' => $total]);
            
            session()->forget('cart');
            
            DB::commit();

            return redirect()->route('transactions.show', $transaction)
                ->with('success', 'Pesanan berhasil dibuat. Silakan lakukan pembayaran.');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function updateStatus(Request $request, Transaction $transaction)
    {
        // Only admin can update transaction status
        if (!auth()->user()->isAdmin()) {
            abort(403, 'Unauthorized action.');
        }

        $request->validate([
            'status' => 'required|in:pending,paid,processing,ready_pickup,shipped,completed,cancelled'
        ]);

        $oldStatus = $transaction->status;
        $transaction->update(['status' => $request->status]);

        if ($request->status === 'cancelled' && $oldStatus !== 'cancelled') {
            foreach ($transaction->items as $item) {
                if ($item->product) {
                    $item->product->increment('stock', $item->quantity);
                }
            }
        }

        if ($transaction->user_id) {
            // Label status sesuai dengan halaman kelola transaksi admin
            $statusLabels = [
                'pending' => 'Menunggu Pembayaran',
                'processing' => 'Menunggu Konfirmasi',
                'paid' => 'Dibayar',
                'ready_pickup' => 'Siap Diambil',
                'shipped' => 'Dikirim',
                'completed' => 'Selesai',
                'cancelled' => 'Dibatalkan'
            ];
            
            $statusLabel = $statusLabels[$request->status] ?? $request->status;
            
            // Pesan notifikasi natural dalam bahasa Indonesia
            $notificationMessages = [
                'pending' => 'Pesanan #' . $transaction->transaction_code . ' menunggu pembayaran. Silakan segera lakukan pembayaran.',
                'processing' => 'Bukti pembayaran pesanan #' . $transaction->transaction_code . ' sedang menunggu konfirmasi dari admin.',
                'paid' => 'Pembayaran pesanan #' . $transaction->transaction_code . ' telah dikonfirmasi! Pesanan akan segera diproses.',
                'ready_pickup' => 'Pesanan #' . $transaction->transaction_code . ' sudah siap diambil! Silakan ambil pesanan Anda di toko.',
                'shipped' => 'Pesanan #' . $transaction->transaction_code . ' sudah dikirim! Pesanan akan segera sampai ke alamat Anda.',
                'completed' => 'Pesanan #' . $transaction->transaction_code . ' sudah selesai. Terima kasih telah berbelanja di toko kami!',
                'cancelled' => 'Pesanan #' . $transaction->transaction_code . ' telah dibatalkan. Stok produk telah dikembalikan.'
            ];
            
            // Judul notifikasi sesuai status
            $notificationTitles = [
                'pending' => 'Menunggu Pembayaran',
                'processing' => 'Pembayaran Sedang Dicek',
                'paid' => 'Pembayaran Dikonfirmasi',
                'ready_pickup' => 'Pesanan Siap Diambil',
                'shipped' => 'Pesanan Dikirim',
                'completed' => 'Pesanan Selesai',
                'cancelled' => 'Pesanan Dibatalkan'
            ];
            
            $notificationTypes = [
                'pending' => 'warning',
                'paid' => 'success',
                'processing' => 'info',
                'ready_pickup' => 'success',
                'shipped' => 'info',
                'completed' => 'success',
                'cancelled' => 'danger'
            ];
            
            Notification::create([
                'user_id' => $transaction->user_id,
                'title' => $notificationTitles[$request->status] ?? 'Update Pesanan',
                'message' => $notificationMessages[$request->status] ?? 'Status pesanan #' . $transaction->transaction_code . ' diperbarui menjadi ' . $statusLabel . '.',
                'type' => $notificationTypes[$request->status] ?? 'info'
            ]);
        }

        return redirect()->back()->with('success', 'Status transaksi berhasil diperbarui.');
    }

    public function uploadPaymentProof(Request $request, Transaction $transaction)
    {
        // User can only upload payment proof for their own transactions
        if ($transaction->user_id !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }

        $request->validate([
            'payment_proof' => 'required|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        if ($transaction->payment_proof) {
            Storage::disk('public')->delete('payments/' . $transaction->payment_proof);
        }

        $image = $request->file('payment_proof');
        $imageName = 'payment_proof_' . $transaction->transaction_code . '_' . time() . '.' . $image->getClientOriginalExtension();
        $image->storeAs('payments', $imageName, 'public');

        $transaction->update([
            'payment_proof' => $imageName,
            'status' => 'processing',
            'paid_at' => now()
        ]);

        return redirect()->back()->with('success', 'Bukti pembayaran berhasil diupload.');
    }
}