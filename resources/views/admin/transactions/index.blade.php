{{-- resources/views/admin/transactions/index.blade.php --}}
@extends('layouts.app')

@section('title', 'Kelola Transaksi')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2><i class="bi bi-receipt"></i> Kelola Transaksi</h2>
</div>

{{-- Filter Bar --}}
<div class="card mb-4">
    <div class="card-body">
        <form method="GET" action="{{ route('admin.transactions.index') }}" class="row g-3">
            <div class="col-md-3">
                <label class="form-label">Status</label>
                <select name="status" class="form-select">
                    <option value="">Semua Status</option>
                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Menunggu Pembayaran</option>
                    <option value="processing" {{ request('status') == 'processing' ? 'selected' : '' }}>Menunggu Konfirmasi</option>
                    <option value="paid" {{ request('status') == 'paid' ? 'selected' : '' }}>Dibayar</option>
                    <option value="ready_pickup" {{ request('status') == 'ready_pickup' ? 'selected' : '' }}>Siap Diambil</option>
                    <option value="shipped" {{ request('status') == 'shipped' ? 'selected' : '' }}>Dikirim</option>
                    <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Selesai</option>
                    <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Dibatalkan</option>
                </select>
            </div>
            <div class="col-md-3">
                <label class="form-label">Metode Pembayaran</label>
                <select name="payment_method" class="form-select">
                    <option value="">Semua Metode</option>
                    <option value="transfer" {{ request('payment_method') == 'transfer' ? 'selected' : '' }}>Transfer</option>
                    <option value="cod" {{ request('payment_method') == 'cod' ? 'selected' : '' }}>COD</option>
                </select>
            </div>
            <div class="col-md-3">
                <label class="form-label">Cari Kode/Customer</label>
                <input type="text" name="search" class="form-control" placeholder="Cari..." value="{{ request('search') }}">
            </div>
            <div class="col-md-3 d-flex align-items-end">
                <button type="submit" class="btn btn-primary me-2"><i class="bi bi-search"></i> Filter</button>
                <a href="{{ route('admin.transactions.index') }}" class="btn btn-secondary"><i class="bi bi-x-circle"></i> Reset</a>
            </div>
        </form>
    </div>
</div>

{{-- Status Summary Cards --}}
<div class="row mb-4">
    <div class="col-md-2">
        <div class="card text-center border-warning">
            <div class="card-body py-2">
                <h5 class="text-warning mb-0">{{ $statusCounts['pending'] ?? 0 }}</h5>
                <small class="text-muted">Menunggu</small>
            </div>
        </div>
    </div>
    <div class="col-md-2">
        <div class="card text-center border-info">
            <div class="card-body py-2">
                <h5 class="text-info mb-0">{{ $statusCounts['processing'] ?? 0 }}</h5>
                <small class="text-muted">Konfirmasi</small>
            </div>
        </div>
    </div>
    <div class="col-md-2">
        <div class="card text-center border-primary">
            <div class="card-body py-2">
                <h5 class="text-primary mb-0">{{ $statusCounts['paid'] ?? 0 }}</h5>
                <small class="text-muted">Dibayar</small>
            </div>
        </div>
    </div>
    <div class="col-md-2">
        <div class="card text-center border-secondary">
            <div class="card-body py-2">
                <h5 class="text-secondary mb-0">{{ $statusCounts['shipped'] ?? 0 }}</h5>
                <small class="text-muted">Dikirim</small>
            </div>
        </div>
    </div>
    <div class="col-md-2">
        <div class="card text-center border-success">
            <div class="card-body py-2">
                <h5 class="text-success mb-0">{{ $statusCounts['completed'] ?? 0 }}</h5>
                <small class="text-muted">Selesai</small>
            </div>
        </div>
    </div>
    <div class="col-md-2">
        <div class="card text-center border-danger">
            <div class="card-body py-2">
                <h5 class="text-danger mb-0">{{ $statusCounts['cancelled'] ?? 0 }}</h5>
                <small class="text-muted">Batal</small>
            </div>
        </div>
    </div>
</div>

<div class="card shadow">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped table-hover">
                <thead class="table-dark">
                    <tr>
                        <th>Kode</th>
                        <th>Pelanggan</th>
                        <th>Tanggal</th>
                        <th>Total</th>
                        <th>Metode</th>
                        <th>Bukti</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($transactions as $transaction)
                        <tr>
                            <td><strong>{{ $transaction->transaction_code }}</strong></td>
                            <td>
                                <a href="{{ route('admin.users.show', $transaction->user) }}">
                                    {{ $transaction->user->username ?? 'Guest' }}
                                </a>
                            </td>
                            <td>{{ $transaction->created_at->format('d M Y H:i') }}</td>
                            <td>Rp {{ number_format($transaction->total_amount, 0, ',', '.') }}</td>
                            <td><span class="badge bg-info">{{ ucfirst($transaction->payment_method) }}</span></td>
                            <td>
                                @if($transaction->payment_proof_url)
                                    <div class="btn-group btn-group-sm" role="group">
                                        <button type="button" class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#paymentModal{{ $transaction->id }}" title="Lihat Bukti">
                                            <i class="bi bi-eye"></i>
                                        </button>
                                        <a href="{{ $transaction->payment_proof_url }}" download class="btn btn-primary btn-sm" title="Download">
                                            <i class="bi bi-download"></i>
                                        </a>
                                    </div>
                                @else
                                    <span class="badge bg-secondary">-</span>
                                @endif
                            </td>
                            <td>{!! $transaction->status_badge !!}</td>
                            <td>
                                <div class="btn-group" role="group">
                                    {{-- View Detail --}}
                                    <a href="{{ route('admin.transactions.show', $transaction) }}" class="btn btn-sm btn-info" title="Lihat Detail">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                    
                                    {{-- Status Actions based on current status --}}
                                    @if($transaction->status === 'pending')
                                        {{-- Pending: Can mark as Processing (if payment proof exists) or Cancel --}}
                                        @if($transaction->payment_proof)
                                            <form action="{{ route('admin.transactions.update-status', $transaction) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('PUT')
                                                <input type="hidden" name="status" value="processing">
                                                <button type="submit" class="btn btn-sm btn-warning" title="Proses Pembayaran" onclick="return confirm('Proses pembayaran ini?')">
                                                    <i class="bi bi-hourglass-split"></i>
                                                </button>
                                            </form>
                                        @endif
                                        <form action="{{ route('admin.transactions.update-status', $transaction) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('PUT')
                                            <input type="hidden" name="status" value="cancelled">
                                            <button type="submit" class="btn btn-sm btn-danger" title="Batalkan" onclick="return confirm('Batalkan transaksi ini? Stok akan dikembalikan.')">
                                                <i class="bi bi-x-lg"></i>
                                            </button>
                                        </form>
                                    
                                    @elseif($transaction->status === 'processing')
                                        {{-- Processing: Can confirm payment (paid) or cancel --}}
                                        <form action="{{ route('admin.transactions.update-status', $transaction) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('PUT')
                                            <input type="hidden" name="status" value="paid">
                                            <button type="submit" class="btn btn-sm btn-success" title="Konfirmasi Pembayaran" onclick="return confirm('Konfirmasi pembayaran ini?')">
                                                <i class="bi bi-check-lg"></i>
                                            </button>
                                        </form>
                                        <form action="{{ route('admin.transactions.update-status', $transaction) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('PUT')
                                            <input type="hidden" name="status" value="cancelled">
                                            <button type="submit" class="btn btn-sm btn-danger" title="Batalkan" onclick="return confirm('Batalkan transaksi ini?')">
                                                <i class="bi bi-x-lg"></i>
                                            </button>
                                        </form>
                                    
                                    @elseif($transaction->status === 'paid')
                                        {{-- Paid: Can ship or mark ready for pickup --}}
                                        <form action="{{ route('admin.transactions.update-status', $transaction) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('PUT')
                                            <input type="hidden" name="status" value="shipped">
                                            <button type="submit" class="btn btn-sm btn-primary" title="Kirim Pesanan" onclick="return confirm('Kirim pesanan ini?')">
                                                <i class="bi bi-truck"></i>
                                            </button>
                                        </form>
                                        <form action="{{ route('admin.transactions.update-status', $transaction) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('PUT')
                                            <input type="hidden" name="status" value="ready_pickup">
                                            <button type="submit" class="btn btn-sm btn-secondary" title="Siap Diambil" onclick="return confirm('Tandai siap diambil?')">
                                                <i class="bi bi-shop"></i>
                                            </button>
                                        </form>
                                    
                                    @elseif($transaction->status === 'shipped' || $transaction->status === 'ready_pickup')
                                        {{-- Shipped/Ready: Can complete --}}
                                        <form action="{{ route('admin.transactions.update-status', $transaction) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('PUT')
                                            <input type="hidden" name="status" value="completed">
                                            <button type="submit" class="btn btn-sm btn-success" title="Selesaikan" onclick="return confirm('Selesaikan transaksi ini?')">
                                                <i class="bi bi-check-circle"></i>
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center">Tidak ada transaksi.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        {{ $transactions->appends(request()->query())->links() }}
    </div>
</div>

{{-- Payment Proof Modals --}}
@foreach($transactions as $transaction)
    @if($transaction->payment_proof_url)
        <div class="modal fade" id="paymentModal{{ $transaction->id }}" tabindex="-1" aria-labelledby="paymentModalLabel{{ $transaction->id }}" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header bg-primary text-white">
                        <h5 class="modal-title" id="paymentModalLabel{{ $transaction->id }}">
                            <i class="bi bi-image"></i> Bukti Pembayaran - {{ $transaction->transaction_code }}
                        </h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body text-center p-4">
                        <img src="{{ $transaction->payment_proof_url }}" alt="Bukti Pembayaran" class="img-fluid rounded shadow" style="max-height: 500px;">
                        <div class="mt-3">
                            <p class="text-muted mb-1">
                                <strong>Pelanggan:</strong> {{ $transaction->user->full_name ?? $transaction->user->username }}
                            </p>
                            <p class="text-muted mb-1">
                                <strong>Total:</strong> Rp {{ number_format($transaction->total_amount, 0, ',', '.') }}
                            </p>
                            @if($transaction->paid_at)
                                <p class="text-muted mb-0">
                                    <strong>Tanggal Upload:</strong> {{ $transaction->paid_at->format('d M Y H:i') }}
                                </p>
                            @endif
                        </div>
                    </div>
                    <div class="modal-footer">
                        <a href="{{ $transaction->payment_proof_url }}" download class="btn btn-primary">
                            <i class="bi bi-download"></i> Download
                        </a>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    </div>
                </div>
            </div>
        </div>
    @endif
@endforeach
@endsection
