{{-- resources/views/user/home.blade.php --}}
@extends('layouts.app')

@section('title', 'Home')

@section('content')
{{-- Welcome Banner --}}
<div class="row mb-4">
    <div class="col-12">
        <div class="card-modern p-4" style="background: var(--primary-gradient); color: white;">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h2 class="mb-1"><i class="bi bi-bag-heart"></i> Katalog Produk</h2>
                    <p class="mb-0 opacity-75">Temukan produk fashion terbaik untuk Anda</p>
                </div>
                <div class="d-none d-md-block">
                    <a href="{{ route('user.dashboard') }}" class="btn btn-light btn-lg">
                        <i class="bi bi-speedometer2"></i> Dashboard Saya
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Filter & Search --}}
<div class="row mb-4">
    <div class="col-12">
        <div class="card-modern p-3">
            <form action="{{ route('home') }}" method="GET" class="row g-3 align-items-center">
                <div class="col-md-3">
                    <select name="category" class="form-select" style="border-radius: 12px;" onchange="this.form.submit()">
                        <option value="">Semua Kategori</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                                {{ $category->name }} ({{ $category->products_count }})
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-7">
                    <div class="input-group">
                        <input type="text" name="search" class="form-control" style="border-radius: 12px 0 0 12px;" placeholder="Cari produk..." value="{{ request('search') }}">
                        <button class="btn btn-modern btn-modern-primary" type="submit" style="border-radius: 0 12px 12px 0;">
                            <i class="bi bi-search"></i> Cari
                        </button>
                    </div>
                </div>
                <div class="col-md-2">
                    @if(request('category') || request('search'))
                        <a href="{{ route('home') }}" class="btn btn-outline-secondary w-100" style="border-radius: 12px;">
                            <i class="bi bi-x-circle"></i> Reset
                        </a>
                    @endif
                </div>
            </form>
        </div>
    </div>
</div>

{{-- Product Catalog --}}
<div class="row">
    @forelse($products as $product)
        <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
            <div class="product-card h-100 animate-fadeInUp" style="animation-delay: {{ $loop->index * 0.05 }}s">
                <div class="overflow-hidden">
                    <img src="{{ $product->image_url }}" class="card-img-top product-img" alt="{{ $product->name }}">
                </div>
                <div class="card-body d-flex flex-column">
                    <div class="mb-2">
                        @if($product->category)
                            <span class="badge bg-primary badge-modern">{{ $product->category->name }}</span>
                        @endif
                        <span class="badge bg-secondary badge-modern">{{ $product->size }}</span>
                    </div>
                    <h5 class="fw-bold mb-2">{{ $product->name }}</h5>
                    <p class="text-muted small mb-3">{{ Str::limit($product->description, 60) }}</p>
                    
                    <div class="mt-auto">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <span class="price-tag">Rp {{ number_format($product->price, 0, ',', '.') }}</span>
                            <small class="text-{{ $product->stock > 0 ? 'success' : 'danger' }} fw-bold">
                                <i class="bi bi-box"></i> {{ $product->stock }}
                            </small>
                        </div>
                        
                        @if($product->stock > 0)
                            <form action="{{ route('cart.add', $product->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-modern btn-modern-primary w-100">
                                    <i class="bi bi-cart-plus"></i> Tambah ke Keranjang
                                </button>
                            </form>
                        @else
                            <button class="btn btn-secondary w-100" disabled style="border-radius: 12px;">
                                <i class="bi bi-x-circle"></i> Stok Habis
                            </button>
                        @endif
                    </div>
                </div>
                <div class="card-footer bg-transparent border-0 text-center pb-3">
                    <a href="{{ route('products.show', $product) }}" class="btn btn-sm btn-outline-secondary" style="border-radius: 20px;">
                        <i class="bi bi-eye"></i> Lihat Detail
                    </a>
                </div>
            </div>
        </div>
    @empty
        <div class="col-12">
            <div class="card-modern text-center py-5">
                <i class="bi bi-inbox fs-1 text-muted"></i>
                <h5 class="mt-3">Tidak ada produk ditemukan</h5>
                <p class="text-muted">Coba ubah filter pencarian Anda</p>
            </div>
        </div>
    @endforelse
</div>

@if($products->hasPages())
    <div class="d-flex justify-content-center mt-4">
        {{ $products->links() }}
    </div>
@endif
@endsection
