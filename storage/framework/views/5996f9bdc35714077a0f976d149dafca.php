


<?php $__env->startSection('title', 'Keranjang Belanja'); ?>

<?php $__env->startSection('content'); ?>
<h2 class="mb-4"><i class="bi bi-cart"></i> Keranjang Belanja</h2>

<?php if(count($cart) > 0): ?>
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
                            <?php $__currentLoopData = $cart; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $id => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <img src="<?php echo e(asset('storage/products/' . $item['image'])); ?>" 
                                                 alt="<?php echo e($item['name']); ?>" style="width: 60px; height: 60px; object-fit: cover;" class="rounded me-3">
                                            <span><?php echo e($item['name']); ?></span>
                                        </div>
                                    </td>
                                    <td>Rp <?php echo e(number_format($item['price'], 0, ',', '.')); ?></td>
                                    <td>
                                        <form action="<?php echo e(route('cart.update', $id)); ?>" method="POST" class="d-flex align-items-center">
                                            <?php echo csrf_field(); ?>
                                            <?php echo method_field('PUT'); ?>
                                            <input type="number" name="quantity" value="<?php echo e($item['quantity']); ?>" 
                                                   min="1" max="<?php echo e($item['stock']); ?>" class="form-control" style="width: 70px;">
                                            <button type="submit" class="btn btn-sm btn-outline-primary ms-2">
                                                <i class="bi bi-arrow-clockwise"></i>
                                            </button>
                                        </form>
                                    </td>
                                    <td>Rp <?php echo e(number_format($item['price'] * $item['quantity'], 0, ',', '.')); ?></td>
                                    <td>
                                        <form action="<?php echo e(route('cart.remove', $id)); ?>" method="POST">
                                            <?php echo csrf_field(); ?>
                                            <?php echo method_field('DELETE'); ?>
                                            <button type="submit" class="btn btn-sm btn-danger">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                </div>
                
                <form action="<?php echo e(route('cart.clear')); ?>" method="POST" class="text-end">
                    <?php echo csrf_field(); ?>
                    <?php echo method_field('DELETE'); ?>
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
                <form action="<?php echo e(route('transactions.checkout')); ?>" method="POST">
                    <?php echo csrf_field(); ?>
                    
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
                        <textarea class="form-control" id="shipping_address" name="shipping_address" rows="3" required><?php echo e(auth()->user()->address); ?></textarea>
                    </div>
                    
                    <div class="mb-3">
                        <label for="notes" class="form-label">Catatan (Opsional)</label>
                        <textarea class="form-control" id="notes" name="notes" rows="2"></textarea>
                    </div>
                    
                    <hr>
                    
                    <div class="d-flex justify-content-between mb-3">
                        <strong>Total:</strong>
                        <strong class="text-success">Rp <?php echo e(number_format($total, 0, ',', '.')); ?></strong>
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
<?php else: ?>
<div class="text-center py-5">
    <i class="bi bi-cart-x" style="font-size: 5rem; color: #ccc;"></i>
    <h4 class="mt-3">Keranjang Anda Kosong</h4>
    <p class="text-muted">Belum ada produk di keranjang belanja Anda.</p>
    <a href="<?php echo e(route('products.index')); ?>" class="btn btn-primary">
        <i class="bi bi-grid"></i> Lihat Produk
    </a>
</div>
<?php endif; ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\akari-store\resources\views/cart/index.blade.php ENDPATH**/ ?>