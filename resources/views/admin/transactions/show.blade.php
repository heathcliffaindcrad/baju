{{-- resources/views/admin/transactions/show.blade.php --}}
@extends('layouts.app')

@section('title', 'Detail Transaksi Admin')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-10">
        <div class="card shadow">
            <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                <h5 class="mb-0"><i class="bi bi-receipt"></i> Transaksi #{{ $transaction->transaction_code }}</h5>
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
                
                @if($transaction->payment_proof_url)
                    <div class="mb-4">
                        <h6><i class="bi bi-image"></i> Bukti Pembayaran</h6>
                        <div class="card">
                            <div class="card-body text-center">
                                <a href="{{ $transaction->payment_proof_url }}" target="_blank">
                                    <img src="{{ $transaction->payment_proof_url }}" 
                                         alt="Bukti Pembayaran" class="img-fluid rounded shadow" style="max-width: 400px; cursor: pointer;">
                                </a>
                                <p class="text-muted small mt-2 mb-0">Klik gambar untuk memperbesar</p>
                            </div>
                            <div class="card-footer bg-light">
                                <div class="d-flex justify-content-between align-items-center">
                                    @if($transaction->paid_at)
                                        <span class="text-muted"><i class="bi bi-calendar"></i> Diupload: {{ $transaction->paid_at->format('d M Y H:i') }}</span>
                                    @else
                                        <span></span>
                                    @endif
                                    <a href="{{ $transaction->payment_proof_url }}" download class="btn btn-primary btn-sm">
                                        <i class="bi bi-download"></i> Download Bukti
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
                
                <div class="card bg-light">
                    <div class="card-body">
                        <h6><i class="bi bi-gear"></i> Update Status</h6>
                        <form action="{{ route('admin.transactions.update-status', $transaction) }}" method="POST" class="row g-2">
                            @csrf
                            @method('PUT')
                            <div class="col-md-8">
                                <select name="status" class="form-select">
                                    @php
                                        $statusLabels = [
                                            'pending' => 'Menunggu Pembayaran',
                                            'processing' => 'Menunggu Konfirmasi',
                                            'paid' => 'Dibayar',
                                            'ready_pickup' => 'Siap Diambil',
                                            'shipped' => 'Dikirim',
                                            'completed' => 'Selesai',
                                            'cancelled' => 'Dibatalkan'
                                        ];
                                    @endphp
                                    @foreach(['pending', 'processing', 'paid', 'ready_pickup', 'shipped', 'completed', 'cancelled'] as $status)
                                        <option value="{{ $status }}" {{ $transaction->status == $status ? 'selected' : '' }}>
                                            {{ $statusLabels[$status] }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-4">
                                <button type="submit" class="btn btn-primary w-100">
                                    <i class="bi bi-save"></i> Update Status
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <a href="{{ route('admin.transactions.index') }}" class="btn btn-secondary">
                    <i class="bi bi-arrow-left"></i> Kembali
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
