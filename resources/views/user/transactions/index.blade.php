{{-- resources/views/user/transactions/index.blade.php --}}
@extends('layouts.app')

@section('title', 'Transaksi Saya')

@section('content')
<h2 class="mb-4"><i class="bi bi-receipt"></i> Transaksi Saya</h2>

<div class="card shadow">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped table-hover">
                <thead class="table-dark">
                    <tr>
                        <th>Kode Transaksi</th>
                        <th>Tanggal</th>
                        <th>Total</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($transactions as $transaction)
                        <tr>
                            <td><strong>{{ $transaction->transaction_code }}</strong></td>
                            <td>{{ $transaction->created_at->format('d M Y H:i') }}</td>
                            <td>Rp {{ number_format($transaction->total_amount, 0, ',', '.') }}</td>
                            <td>{!! $transaction->status_badge !!}</td>
                            <td>
                                <a href="{{ route('transactions.show', $transaction) }}" class="btn btn-sm btn-info">
                                    <i class="bi bi-eye"></i> Detail
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center">
                                <div class="py-4">
                                    <i class="bi bi-receipt" style="font-size: 3rem; color: #ccc;"></i>
                                    <p class="mt-2">Belum ada transaksi.</p>
                                    <a href="{{ route('products.index') }}" class="btn btn-primary btn-sm">
                                        <i class="bi bi-grid"></i> Mulai Belanja
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        {{ $transactions->links() }}
    </div>
</div>
@endsection
