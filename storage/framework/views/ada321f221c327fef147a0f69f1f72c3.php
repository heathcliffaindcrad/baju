


<?php $__env->startSection('title', 'Produk'); ?>

<?php $__env->startSection('content'); ?>
<div class="row mb-4 animate-fadeInUp">
    <div class="col-md-6">
        <h2 class="fw-bold"><i class="bi bi-grid-3x3-gap"></i> Koleksi Produk</h2>
        <p class="text-muted">Temukan produk fashion terbaik untuk Anda</p>
    </div>
    <div class="col-md-6">
        <form action="<?php echo e(route('products.index')); ?>" method="GET" class="d-flex gap-2">
            <select name="category" class="form-select" style="border-radius: 12px;" onchange="this.form.submit()">
                <option value="">Semua Kategori</option>
                <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($category->id); ?>" <?php echo e(request('category') == $category->id ? 'selected' : ''); ?>>
                        <?php echo e($category->name); ?>

                    </option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
            <div class="input-group">
                <input type="text" name="search" class="form-control" style="border-radius: 12px 0 0 12px;" placeholder="Cari produk..." value="<?php echo e(request('search')); ?>">
                <button class="btn btn-modern btn-modern-primary" type="submit" style="border-radius: 0 12px 12px 0;">
                    <i class="bi bi-search"></i>
                </button>
            </div>
        </form>
    </div>
</div>

<div class="row">
    <?php $__empty_1 = true; $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
        <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
            <div class="product-card h-100 animate-fadeInUp" style="animation-delay: <?php echo e($loop->index * 0.05); ?>s">
                <div class="overflow-hidden">
                    <img src="<?php echo e($product->image_url); ?>" class="card-img-top product-img" alt="<?php echo e($product->name); ?>">
                </div>
                <div class="card-body d-flex flex-column">
                    <div class="mb-2">
                        <?php if($product->category): ?>
                            <span class="badge bg-primary badge-modern"><?php echo e($product->category->name); ?></span>
                        <?php endif; ?>
                        <span class="badge bg-secondary badge-modern"><?php echo e($product->size); ?></span>
                    </div>
                    <h5 class="fw-bold mb-2"><?php echo e($product->name); ?></h5>
                    <p class="text-muted small mb-3"><?php echo e(Str::limit($product->description, 60)); ?></p>
                    
                    <div class="mt-auto">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <span class="price-tag">Rp <?php echo e(number_format($product->price, 0, ',', '.')); ?></span>
                            <small class="text-<?php echo e($product->stock > 0 ? 'success' : 'danger'); ?> fw-bold">
                                <i class="bi bi-box"></i> <?php echo e($product->stock); ?>

                            </small>
                        </div>
                        
                        <?php if(auth()->guard()->check()): ?>
                            <?php if(!auth()->user()->isAdmin()): ?>
                                <?php if($product->stock > 0): ?>
                                    <form action="<?php echo e(route('cart.add', $product->id)); ?>" method="POST">
                                        <?php echo csrf_field(); ?>
                                        <button type="submit" class="btn btn-modern btn-modern-primary w-100">
                                            <i class="bi bi-cart-plus"></i> Tambah ke Keranjang
                                        </button>
                                    </form>
                                <?php else: ?>
                                    <button class="btn btn-secondary w-100" disabled style="border-radius: 12px;">
                                        <i class="bi bi-x-circle"></i> Stok Habis
                                    </button>
                                <?php endif; ?>
                            <?php endif; ?>
                        <?php else: ?>
                            <a href="<?php echo e(route('login')); ?>" class="btn btn-outline-primary w-100" style="border-radius: 12px;">
                                <i class="bi bi-box-arrow-in-right"></i> Login untuk Beli
                            </a>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="card-footer bg-transparent border-0 text-center pb-3">
                    <a href="<?php echo e(route('products.show', $product)); ?>" class="btn btn-sm btn-outline-secondary" style="border-radius: 20px;">
                        <i class="bi bi-eye"></i> Lihat Detail
                    </a>
                </div>
            </div>
        </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
        <div class="col-12">
            <div class="card-modern text-center py-5">
                <i class="bi bi-inbox fs-1 text-muted"></i>
                <h5 class="mt-3">Tidak ada produk ditemukan</h5>
                <p class="text-muted">Coba ubah filter pencarian Anda</p>
            </div>
        </div>
    <?php endif; ?>
</div>

<div class="d-flex justify-content-center mt-4">
    <?php echo e($products->links()); ?>

</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\akari-store\resources\views/products/index.blade.php ENDPATH**/ ?>