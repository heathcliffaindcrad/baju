{{-- resources/views/admin/products/create.blade.php --}}
@extends('layouts.app')

@section('title', 'Tambah Produk')

@section('content')
<div class="row justify-content-center animate-fadeInUp">
    <div class="col-md-10">
        <div class="card-modern">
            <div class="card-header" style="background: var(--primary-gradient); color: white; padding: 1.5rem;">
                <h5 class="mb-0"><i class="bi bi-plus-lg"></i> Tambah Produk Baru</h5>
            </div>
            <div class="card-body p-4">
                <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    
                    <div class="row">
                        <div class="col-md-8">
                            <div class="mb-3">
                                <label for="name" class="form-label fw-bold">Nama Produk *</label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                       id="name" name="name" value="{{ old('name') }}" required
                                       style="border-radius: 10px; padding: 12px;">
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="mb-3">
                                <label for="category_id" class="form-label fw-bold">Kategori</label>
                                <select class="form-select @error('category_id') is-invalid @enderror" id="category_id" name="category_id"
                                        style="border-radius: 10px; padding: 12px;">
                                    <option value="">-- Pilih Kategori --</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                            {{ $category->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('category_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="mb-3">
                                <label for="description" class="form-label fw-bold">Deskripsi</label>
                                <textarea class="form-control @error('description') is-invalid @enderror" 
                                          id="description" name="description" rows="4"
                                          style="border-radius: 10px; padding: 12px;">{{ old('description') }}</textarea>
                                @error('description')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <label for="size" class="form-label fw-bold">Ukuran *</label>
                                    <select class="form-select @error('size') is-invalid @enderror" id="size" name="size" required
                                            style="border-radius: 10px; padding: 12px;">
                                        <option value="">-- Pilih --</option>
                                        @foreach(['S', 'M', 'L', 'XL', 'XXL'] as $size)
                                            <option value="{{ $size }}" {{ old('size') == $size ? 'selected' : '' }}>{{ $size }}</option>
                                        @endforeach
                                    </select>
                                    @error('size')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <div class="col-md-4 mb-3">
                                    <label for="color" class="form-label fw-bold">Warna *</label>
                                    <input type="text" class="form-control @error('color') is-invalid @enderror" 
                                           id="color" name="color" value="{{ old('color') }}" required
                                           style="border-radius: 10px; padding: 12px;">
                                    @error('color')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <div class="col-md-4 mb-3">
                                    <label for="stock" class="form-label fw-bold">Stok *</label>
                                    <input type="number" class="form-control @error('stock') is-invalid @enderror" 
                                           id="stock" name="stock" value="{{ old('stock', 0) }}" min="0" required
                                           style="border-radius: 10px; padding: 12px;">
                                    @error('stock')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="mb-3">
                                <label for="price" class="form-label fw-bold">Harga (Rp) *</label>
                                <input type="number" class="form-control @error('price') is-invalid @enderror" 
                                       id="price" name="price" value="{{ old('price') }}" min="0" required
                                       style="border-radius: 10px; padding: 12px;">
                                @error('price')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="mb-3 form-check">
                                <input type="checkbox" class="form-check-input" id="is_active" name="is_active" value="1" 
                                       {{ old('is_active', true) ? 'checked' : '' }} style="width: 20px; height: 20px;">
                                <label class="form-check-label fw-bold ms-2" for="is_active">Produk Aktif</label>
                            </div>
                        </div>
                        
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label class="form-label fw-bold">Gambar Produk</label>
                                <div class="image-upload-wrapper">
                                    <div id="imagePreview" class="image-preview mb-3" style="
                                        width: 100%;
                                        height: 250px;
                                        border: 2px dashed #ddd;
                                        border-radius: 15px;
                                        display: flex;
                                        align-items: center;
                                        justify-content: center;
                                        background: #f8f9fa;
                                        overflow: hidden;
                                        cursor: pointer;
                                    " onclick="document.getElementById('image').click()">
                                        <div class="text-center text-muted" id="uploadPlaceholder">
                                            <i class="bi bi-cloud-arrow-up" style="font-size: 3rem;"></i>
                                            <p class="mb-0 mt-2">Klik untuk upload gambar</p>
                                            <small>JPG, PNG, GIF, WEBP (Max 5MB)</small>
                                        </div>
                                        <img id="previewImg" src="" alt="Preview" style="
                                            max-width: 100%;
                                            max-height: 100%;
                                            object-fit: contain;
                                            display: none;
                                        ">
                                    </div>
                                    <input type="file" class="form-control d-none @error('image') is-invalid @enderror" 
                                           id="image" name="image" accept="image/jpeg,image/png,image/gif,image/webp"
                                           onchange="previewImage(this)">
                                    @error('image')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                    <button type="button" class="btn btn-outline-secondary btn-sm w-100 mt-2" onclick="document.getElementById('image').click()">
                                        <i class="bi bi-upload"></i> Pilih Gambar
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <hr class="my-4">
                    
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-modern btn-modern-primary">
                            <i class="bi bi-save"></i> Simpan Produk
                        </button>
                        <a href="{{ route('admin.products.index') }}" class="btn btn-modern btn-modern-secondary">
                            <i class="bi bi-arrow-left"></i> Kembali
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
function previewImage(input) {
    const preview = document.getElementById('previewImg');
    const placeholder = document.getElementById('uploadPlaceholder');
    
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        
        reader.onload = function(e) {
            preview.src = e.target.result;
            preview.style.display = 'block';
            placeholder.style.display = 'none';
        }
        
        reader.readAsDataURL(input.files[0]);
    } else {
        preview.style.display = 'none';
        placeholder.style.display = 'block';
    }
}
</script>
@endsection
