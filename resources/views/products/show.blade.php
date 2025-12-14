{{-- resources/views/products/show.blade.php --}}
@extends('layouts.app')

@section('title', $product->name)

@section('content')
<div class="row">
    <div class="col-md-5">
        <div class="card shadow">
            <img src="{{ $product->image_url }}" class="card-img-top" alt="{{ $product->name }}" style="max-height: 400px; object-fit: cover;">
        </div>
    </div>
    <div class="col-md-7">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('products.index') }}">Produk</a></li>
                <li class="breadcrumb-item active">{{ $product->name }}</li>
            </ol>
        </nav>
        
        <h2>{{ $product->name }}</h2>
        
        <div class="mb-3">
            @if($product->category)
                <span class="badge bg-primary">{{ $product->category->name }}</span>
            @endif
            <span class="badge bg-info">{{ $product->size }}</span>
            <span class="badge bg-secondary">{{ $product->color }}</span>
        </div>
        
        <h3 class="text-success mb-3">Rp {{ number_format($product->price, 0, ',', '.') }}</h3>
        
        <div class="mb-3">
            <span class="text-{{ $product->stock > 0 ? 'success' : 'danger' }} fw-bold">
                <i class="bi bi-box"></i> Stok: {{ $product->stock }}
            </span>
        </div>
        
        <div class="mb-4">
            <h5>Deskripsi</h5>
            <p class="text-muted">{{ $product->description ?: 'Tidak ada deskripsi.' }}</p>
        </div>
        
        @auth
            @if($product->stock > 0)
                <form action="{{ route('cart.add', $product->id) }}" method="POST" class="d-flex gap-2">
                    @csrf
                    <button type="submit" class="btn btn-primary btn-lg">
                        <i class="bi bi-cart-plus"></i> Tambah ke Keranjang
                    </button>
                </form>
            @else
                <button class="btn btn-secondary btn-lg" disabled>
                    <i class="bi bi-x-circle"></i> Stok Habis
                </button>
            @endif
        @else
            <a href="{{ route('login') }}" class="btn btn-primary btn-lg">
                <i class="bi bi-box-arrow-in-right"></i> Login untuk Membeli
            </a>
        @endauth
    </div>
</div>

@if($relatedProducts->count() > 0)
<div class="mt-5">
    <h4><i class="bi bi-grid"></i> Produk Terkait</h4>
    <hr>
    <div class="row">
        @foreach($relatedProducts as $related)
            <div class="col-md-3 mb-4">
                <div class="card h-100 shadow-sm">
                    <img src="{{ $related->image_url }}" class="card-img-top product-img" alt="{{ $related->name }}">
                    <div class="card-body">
                        <h6 class="card-title">{{ $related->name }}</h6>
                        <p class="text-success fw-bold">Rp {{ number_format($related->price, 0, ',', '.') }}</p>
                        <a href="{{ route('products.show', $related) }}" class="btn btn-outline-primary btn-sm">
                            <i class="bi bi-eye"></i> Lihat Detail
                        </a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endif
@endsection
