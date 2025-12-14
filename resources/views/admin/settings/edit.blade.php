{{-- resources/views/admin/settings/edit.blade.php --}}
@extends('layouts.app')

@section('title', 'Pengaturan Toko')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card shadow">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0"><i class="bi bi-gear"></i> Pengaturan Toko</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.settings.update') }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="mb-3">
                        <label for="store_name" class="form-label">Nama Toko *</label>
                        <input type="text" class="form-control @error('store_name') is-invalid @enderror" 
                               id="store_name" name="store_name" value="{{ old('store_name', $settings->store_name ?? 'Toko Baju') }}" required>
                        @error('store_name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="mb-3">
                        <label for="store_address" class="form-label">Alamat Toko</label>
                        <textarea class="form-control @error('store_address') is-invalid @enderror" 
                                  id="store_address" name="store_address" rows="2">{{ old('store_address', $settings->store_address ?? '') }}</textarea>
                        @error('store_address')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="store_phone" class="form-label">Telepon Toko</label>
                            <input type="text" class="form-control @error('store_phone') is-invalid @enderror" 
                                   id="store_phone" name="store_phone" value="{{ old('store_phone', $settings->store_phone ?? '') }}">
                            @error('store_phone')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label for="store_email" class="form-label">Email Toko</label>
                            <input type="email" class="form-control @error('store_email') is-invalid @enderror" 
                                   id="store_email" name="store_email" value="{{ old('store_email', $settings->store_email ?? '') }}">
                            @error('store_email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="promo_text" class="form-label">Teks Promo</label>
                        <input type="text" class="form-control @error('promo_text') is-invalid @enderror" 
                               id="promo_text" name="promo_text" value="{{ old('promo_text', $settings->promo_text ?? '') }}">
                        <small class="text-muted">Ditampilkan di footer website.</small>
                        @error('promo_text')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="mb-3">
                        <label for="low_stock_threshold" class="form-label">Batas Stok Rendah</label>
                        <input type="number" class="form-control @error('low_stock_threshold') is-invalid @enderror" 
                               id="low_stock_threshold" name="low_stock_threshold" 
                               value="{{ old('low_stock_threshold', $settings->low_stock_threshold ?? 10) }}" min="1">
                        <small class="text-muted">Produk dengan stok di bawah angka ini akan ditandai sebagai stok rendah.</small>
                        @error('low_stock_threshold')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-save"></i> Simpan Pengaturan
                        </button>
                        <a href="{{ route('admin.dashboard') }}" class="btn btn-secondary">
                            <i class="bi bi-arrow-left"></i> Kembali
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
