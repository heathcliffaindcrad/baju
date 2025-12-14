{{-- resources/views/admin/dashboard.blade.php --}}
@extends('layouts.app')

@section('title', 'Dashboard Admin')

@section('content')
<div class="row mb-4 animate-fadeInUp">
    <div class="col-12">
        <h2 class="fw-bold"><i class="bi bi-speedometer2"></i> Dashboard Admin</h2>
        <p class="text-muted">Selamat datang, {{ auth()->user()->full_name }}!</p>
    </div>
</div>

{{-- Revenue Stats --}}
<div class="row mb-4">
    <div class="col-md-3 mb-3">
        <div class="stat-card-modern gradient-1 animate-fadeInUp">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <p class="mb-1 opacity-75">Total Pendapatan</p>
                    <h4 class="mb-0 fw-bold">Rp {{ number_format($stats['total_revenue'], 0, ',', '.') }}</h4>
                </div>
                <i class="bi bi-wallet2 fs-1 opacity-50"></i>
            </div>
        </div>
    </div>
    <div class="col-md-3 mb-3">
        <div class="stat-card-modern gradient-2 animate-fadeInUp" style="animation-delay: 0.1s">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <p class="mb-1 opacity-75">Hari Ini</p>
                    <h4 class="mb-0 fw-bold">Rp {{ number_format($stats['today_revenue'], 0, ',', '.') }}</h4>
                </div>
                <i class="bi bi-graph-up-arrow fs-1 opacity-50"></i>
            </div>
        </div>
    </div>
    <div class="col-md-3 mb-3">
        <div class="stat-card-modern gradient-3 animate-fadeInUp" style="animation-delay: 0.2s">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <p class="mb-1 opacity-75">Transaksi Selesai</p>
                    <h4 class="mb-0 fw-bold">{{ $stats['completed_transactions'] }}</h4>
                </div>
                <i class="bi bi-check-circle fs-1 opacity-50"></i>
            </div>
        </div>
    </div>
    <div class="col-md-3 mb-3">
        <div class="stat-card-modern gradient-4 animate-fadeInUp" style="animation-delay: 0.3s">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <p class="mb-1 opacity-75">Total Transaksi</p>
                    <h4 class="mb-0 fw-bold">{{ $stats['total_transactions'] }}</h4>
                </div>
                <i class="bi bi-receipt fs-1 opacity-50"></i>
            </div>
        </div>
    </div>
</div>

{{-- Quick Actions --}}
<div class="row mb-4">
    <div class="col-12">
        <div class="card-modern animate-fadeInUp">
            <div class="card-body">
                <h5 class="fw-bold mb-3"><i class="bi bi-lightning-charge"></i> Aksi Cepat</h5>
                <div class="d-flex flex-wrap gap-2">
                    <a href="{{ route('admin.products.create') }}" class="btn btn-modern btn-modern-primary">
                        <i class="bi bi-plus-circle"></i> Tambah Produk
                    </a>
                    <a href="{{ route('admin.categories.create') }}" class="btn btn-modern btn-modern-success">
                        <i class="bi bi-folder-plus"></i> Tambah Kategori
                    </a>
                    <a href="{{ route('admin.transactions.index') }}" class="btn btn-outline-primary btn-modern">
                        <i class="bi bi-list-check"></i> Kelola Transaksi
                    </a>
                    <a href="{{ route('admin.users.index') }}" class="btn btn-outline-secondary btn-modern">
                        <i class="bi bi-people"></i> Kelola Pengguna
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Transactions Pending --}}
<div class="row">
    <div class="col-md-6 mb-4">
        <div class="card-modern animate-fadeInUp">
            <div class="card-header d-flex justify-content-between align-items-center">
                <span><i class="bi bi-clock text-warning"></i> Menunggu Pembayaran ({{ $stats['pending_payments'] }})</span>
                <a href="{{ route('admin.transactions.index') }}?status=pending" class="btn btn-sm btn-outline-warning">Lihat Semua</a>
            </div>
            <div class="card-body" style="max-height: 300px; overflow-y: auto;">
                @if($stats['pending_transactions']->count() > 0)
                    @foreach($stats['pending_transactions']->take(5) as $transaction)
                        <div class="d-flex justify-content-between align-items-center py-2 border-bottom">
                            <div>
                                <strong>{{ $transaction->transaction_code }}</strong>
                                <small class="text-muted d-block">{{ $transaction->user->username ?? 'Guest' }}</small>
                            </div>
                            <div class="text-end">
                                <span class="text-success fw-bold">Rp {{ number_format($transaction->total_amount, 0, ',', '.') }}</span>
                                <a href="{{ route('admin.transactions.show', $transaction) }}" class="btn btn-sm btn-outline-primary ms-2">
                                    <i class="bi bi-eye"></i>
                                </a>
                            </div>
                        </div>
                    @endforeach
                @else
                    <p class="text-muted text-center mb-0 py-3">Tidak ada transaksi menunggu.</p>
                @endif
            </div>
        </div>
    </div>
    
    <div class="col-md-6 mb-4">
        <div class="card-modern animate-fadeInUp" style="animation-delay: 0.1s">
            <div class="card-header d-flex justify-content-between align-items-center">
                <span><i class="bi bi-hourglass-split text-info"></i> Konfirmasi Pembayaran ({{ $stats['processing_payments'] }})</span>
                <a href="{{ route('admin.transactions.index') }}?status=processing" class="btn btn-sm btn-outline-info">Lihat Semua</a>
            </div>
            <div class="card-body" style="max-height: 300px; overflow-y: auto;">
                @if($stats['awaiting_confirmation']->count() > 0)
                    @foreach($stats['awaiting_confirmation']->take(5) as $transaction)
                        <div class="d-flex justify-content-between align-items-center py-2 border-bottom">
                            <div>
                                <strong>{{ $transaction->transaction_code }}</strong>
                                <small class="text-muted d-block">{{ $transaction->user->username ?? 'Guest' }}</small>
                            </div>
                            <div class="text-end">
                                <span class="text-success fw-bold">Rp {{ number_format($transaction->total_amount, 0, ',', '.') }}</span>
                                <a href="{{ route('admin.transactions.show', $transaction) }}" class="btn btn-sm btn-success ms-2">
                                    <i class="bi bi-check-lg"></i>
                                </a>
                            </div>
                        </div>
                    @endforeach
                @else
                    <p class="text-muted text-center mb-0 py-3">Tidak ada transaksi menunggu konfirmasi.</p>
                @endif
            </div>
        </div>
    </div>
</div>

{{-- Summary Row --}}
<div class="row">
    <div class="col-md-4 mb-4">
        <div class="card-modern animate-fadeInUp text-center py-4">
            <i class="bi bi-box-seam fs-1 text-primary"></i>
            <h3 class="fw-bold mt-2 mb-0">{{ $stats['total_products'] }}</h3>
            <p class="text-muted mb-0">Produk</p>
        </div>
    </div>
    <div class="col-md-4 mb-4">
        <div class="card-modern animate-fadeInUp text-center py-4" style="animation-delay: 0.1s">
            <i class="bi bi-tags fs-1 text-success"></i>
            <h3 class="fw-bold mt-2 mb-0">{{ $stats['total_categories'] }}</h3>
            <p class="text-muted mb-0">Kategori</p>
        </div>
    </div>
    <div class="col-md-4 mb-4">
        <div class="card-modern animate-fadeInUp text-center py-4" style="animation-delay: 0.2s">
            <i class="bi bi-people fs-1 text-warning"></i>
            <h3 class="fw-bold mt-2 mb-0">{{ $stats['total_users'] }}</h3>
            <p class="text-muted mb-0">Pengguna</p>
        </div>
    </div>
</div>

@if($stats['low_stock_products']->count() > 0)
<div class="row">
    <div class="col-12">
        <div class="card-modern border-danger animate-fadeInUp">
            <div class="card-header text-danger">
                <i class="bi bi-exclamation-triangle"></i> Produk Stok Rendah ({{ $stats['low_stock_products']->count() }})
            </div>
            <div class="card-body">
                <div class="d-flex flex-wrap gap-2">
                    @foreach($stats['low_stock_products']->take(5) as $product)
                        <span class="badge bg-danger">{{ $product->name }} ({{ $product->stock }})</span>
                    @endforeach
                    @if($stats['low_stock_products']->count() > 5)
                        <a href="{{ route('admin.products.index') }}" class="badge bg-secondary">+{{ $stats['low_stock_products']->count() - 5 }} lainnya</a>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endif
@endsection