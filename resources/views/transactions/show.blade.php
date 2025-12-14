{{-- resources/views/transactions/show.blade.php --}}
@extends('layouts.app')

@section('title', 'Detail Transaksi')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-10">
        <div class="card shadow">
            <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                <h5 class="mb-0"><i class="bi bi-receipt"></i> Detail Transaksi #{{ $transaction->transaction_code }}</h5>
                {!! $transaction->status_badge !!}
            </div>
            <div class="card-body">
                <div class="row mb-4">
                    <div class="col-md-6">
                        <h6><i class="bi bi-person"></i> Informasi Pelanggan</h6>
                        <table class="table table-sm">
                            <tr>
                                <td>Nama</td>
                                <td>: {{ $transaction->user->full_name ?? $transaction->user->username }}</td>
                            </tr>
                            <tr>
                                <td>Email</td>
                                <td>: {{ $transaction->user->email }}</td>
                            </tr>
                            <tr>
                                <td>Telepon</td>
                                <td>: {{ $transaction->user->phone ?? '-' }}</td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-md-6">
                        <h6><i class="bi bi-info-circle"></i> Informasi Pesanan</h6>
                        <table class="table table-sm">
                            <tr>
                                <td>Tanggal</td>
                                <td>: {{ $transaction->created_at->format('d M Y H:i') }}</td>
                            </tr>
                            <tr>
                                <td>Metode Bayar</td>
                                <td>: {{ ucfirst($transaction->payment_method) }}</td>
                            </tr>
                            <tr>
                                <td>Alamat</td>
                                <td>: {{ $transaction->shipping_address }}</td>
                            </tr>
                        </table>
                    </div>
                </div>
                
                <h6><i class="bi bi-box"></i> Item Pesanan</h6>
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Produk</th>
                                <th>Harga</th>
                                <th>Jumlah</th>
                                <th>Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($transaction->items as $item)
                                <tr>
                                    <td>{{ $item->product->name ?? 'Produk tidak tersedia' }}</td>
                                    <td>Rp {{ number_format($item->price, 0, ',', '.') }}</td>
                                    <td>{{ $item->quantity }}</td>
                                    <td>Rp {{ number_format($item->price * $item->quantity, 0, ',', '.') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr class="table-dark">
                                <th colspan="3" class="text-end">Total:</th>
                                <th>Rp {{ number_format($transaction->total_amount, 0, ',', '.') }}</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
                
                @if($transaction->notes)
                    <div class="alert alert-info">
                        <strong><i class="bi bi-chat-text"></i> Catatan:</strong> {{ $transaction->notes }}
                    </div>
                @endif
                
                @if($transaction->status == 'pending' && $transaction->payment_method == 'transfer')
                    <div class="card bg-light mt-4">
                        <div class="card-body">
                            <h6><i class="bi bi-upload"></i> Upload Bukti Pembayaran</h6>
                            <form action="{{ route('transactions.upload-payment', $transaction) }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <div class="col-md-8">
                                        <input type="file" name="payment_proof" class="form-control" accept="image/*" required>
                                    </div>
                                    <div class="col-md-4">
                                        <button type="submit" class="btn btn-success w-100">
                                            <i class="bi bi-upload"></i> Upload
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                @endif
                
                @if($transaction->payment_proof_url)
                    <div class="mt-4">
                        <h6><i class="bi bi-image"></i> Bukti Pembayaran</h6>
                        <img src="{{ $transaction->payment_proof_url }}" 
                             alt="Bukti Pembayaran" class="img-thumbnail" style="max-width: 300px;">
                    </div>
                @endif
            </div>
            <div class="card-footer">
                <a href="{{ route('transactions.index') }}" class="btn btn-secondary">
                    <i class="bi bi-arrow-left"></i> Kembali
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
