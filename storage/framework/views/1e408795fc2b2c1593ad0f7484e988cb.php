


<?php $__env->startSection('title', $product->name); ?>

<?php $__env->startSection('content'); ?>
<div class="row">
    <div class="col-md-5">
        <div class="card shadow">
            <img src="<?php echo e($product->image_url); ?>" class="card-img-top" alt="<?php echo e($product->name); ?>" style="max-height: 400px; object-fit: cover;">
        </div>
    </div>
    <div class="col-md-7">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?php echo e(route('products.index')); ?>">Produk</a></li>
                <li class="breadcrumb-item active"><?php echo e($product->name); ?></li>
            </ol>
        </nav>
        
        <h2><?php echo e($product->name); ?></h2>
        
        <div class="mb-3">
            <?php if($product->category): ?>
                <span class="badge bg-primary"><?php echo e($product->category->name); ?></span>
            <?php endif; ?>
            <span class="badge bg-info"><?php echo e($product->size); ?></span>
            <span class="badge bg-secondary"><?php echo e($product->color); ?></span>
        </div>
        
        <h3 class="text-success mb-3">Rp <?php echo e(number_format($product->price, 0, ',', '.')); ?></h3>
        
        <div class="mb-3">
            <span class="text-<?php echo e($product->stock > 0 ? 'success' : 'danger'); ?> fw-bold">
                <i class="bi bi-box"></i> Stok: <?php echo e($product->stock); ?>

            </span>
        </div>
        
        <div class="mb-4">
            <h5>Deskripsi</h5>
            <p class="text-muted"><?php echo e($product->description ?: 'Tidak ada deskripsi.'); ?></p>
        </div>
        
        <?php if(auth()->guard()->check()): ?>
            <?php if($product->stock > 0): ?>
                <form action="<?php echo e(route('cart.add', $product->id)); ?>" method="POST" class="d-flex gap-2">
                    <?php echo csrf_field(); ?>
                    <button type="submit" class="btn btn-primary btn-lg">
                        <i class="bi bi-cart-plus"></i> Tambah ke Keranjang
                    </button>
                </form>
            <?php else: ?>
                <button class="btn btn-secondary btn-lg" disabled>
                    <i class="bi bi-x-circle"></i> Stok Habis
                </button>
            <?php endif; ?>
        <?php else: ?>
            <a href="<?php echo e(route('login')); ?>" class="btn btn-primary btn-lg">
                <i class="bi bi-box-arrow-in-right"></i> Login untuk Membeli
            </a>
        <?php endif; ?>
    </div>
</div>

<?php if($relatedProducts->count() > 0): ?>
<div class="mt-5">
    <h4><i class="bi bi-grid"></i> Produk Terkait</h4>
    <hr>
    <div class="row">
        <?php $__currentLoopData = $relatedProducts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $related): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="col-md-3 mb-4">
                <div class="card h-100 shadow-sm">
                    <img src="<?php echo e($related->image_url); ?>" class="card-img-top product-img" alt="<?php echo e($related->name); ?>">
                    <div class="card-body">
                        <h6 class="card-title"><?php echo e($related->name); ?></h6>
                        <p class="text-success fw-bold">Rp <?php echo e(number_format($related->price, 0, ',', '.')); ?></p>
                        <a href="<?php echo e(route('products.show', $related)); ?>" class="btn btn-outline-primary btn-sm">
                            <i class="bi bi-eye"></i> Lihat Detail
                        </a>
                    </div>
                </div>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>
</div>
<?php endif; ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\akari-store\resources\views/products/show.blade.php ENDPATH**/ ?>