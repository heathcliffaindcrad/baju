{{-- resources/views/cart/index.blade.php --}}
@extends('layouts.app')

@section('title', 'Keranjang Belanja')

@section('content')
<h2 class="mb-4"><i class="bi bi-cart"></i> Keranjang Belanja</h2>

@if(count($cart) > 0)
<div class="row">
    <div class="col-md-8">
        <div class="card shadow mb-4">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Produk</th>
                                <th>Harga</th>
                                <th>Jumlah</th>
                                <th>Subtotal</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($cart as $id => $item)
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <img src="{{ asset('storage/products/' . $item['image']) }}" 
                                                 alt="{{ $item['name'] }}" style="width: 60px; height: 60px; object-fit: cover;" class="rounded me-3">
                                            <span>{{ $item['name'] }}</span>
                                        </div>
                                    </td>
                                    <td>Rp {{ number_format($item['price'], 0, ',', '.') }}</td>
                                    <td>
                                        <form action="{{ route('cart.update', $id) }}" method="POST" class="d-flex align-items-center">
                                            @csrf
                                            @method('PUT')
                                            <input type="number" name="quantity" value="{{ $item['quantity'] }}" 
                                                   min="1" max="{{ $item['stock'] }}" class="form-control" style="width: 70px;">
                                            <button type="submit" class="btn btn-sm btn-outline-primary ms-2">
                                                <i class="bi bi-arrow-clockwise"></i>
                                            </button>
                                        </form>
                                    </td>
                                    <td>Rp {{ number_format($item['price'] * $item['quantity'], 0, ',', '.') }}</td>
                                    <td>
                                        <form action="{{ route('cart.remove', $id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                
                <form action="{{ route('cart.clear') }}" method="POST" class="text-end">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-outline-danger" onclick="return confirm('Yakin ingin mengosongkan keranjang?')">
                        <i class="bi bi-trash"></i> Kosongkan Keranjang
                    </button>
                </form>
            </div>
        </div>
    </div>
    
    <div class="col-md-4">
        <div class="card shadow">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0"><i class="bi bi-receipt"></i> Checkout</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('transactions.checkout') }}" method="POST">
                    @csrf
                    
                    <div class="mb-3">
                        <label for="payment_method" class="form-label">Metode Pembayaran *</label>
                        <select class="form-select" id="payment_method" name="payment_method" required>
                            <option value="">-- Pilih --</option>
                            <option value="transfer">Transfer Bank</option>
                            <option value="cod">COD (Bayar di Tempat)</option>
                        </select>
                    </div>
                    
                    <div class="mb-3">
                        <label for="shipping_address" class="form-label">Alamat Pengiriman *</label>
                        <textarea class="form-control" id="shipping_address" name="shipping_address" rows="3" required>{{ auth()->user()->address }}</textarea>
                    </div>
                    
                    <div class="mb-3">
                        <label for="notes" class="form-label">Catatan (Opsional)</label>
                        <textarea class="form-control" id="notes" name="notes" rows="2"></textarea>
                    </div>
                    
                    <hr>
                    
                    <div class="d-flex justify-content-between mb-3">
                        <strong>Total:</strong>
                        <strong class="text-success">Rp {{ number_format($total, 0, ',', '.') }}</strong>
                    </div>
                    
                    <div class="d-grid">
                        <button type="submit" class="btn btn-success btn-lg">
                            <i class="bi bi-check-lg"></i> Checkout
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@else
<div class="text-center py-5">
    <i class="bi bi-cart-x" style="font-size: 5rem; color: #ccc;"></i>
    <h4 class="mt-3">Keranjang Anda Kosong</h4>
    <p class="text-muted">Belum ada produk di keranjang belanja Anda.</p>
    <a href="{{ route('products.index') }}" class="btn btn-primary">
        <i class="bi bi-grid"></i> Lihat Produk
    </a>
</div>
@endif
@endsection
