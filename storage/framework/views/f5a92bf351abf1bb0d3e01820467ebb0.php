


<?php $__env->startSection('title', 'Detail Transaksi'); ?>

<?php $__env->startSection('content'); ?>
<div class="row justify-content-center">
    <div class="col-md-10">
        <div class="card shadow">
            <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                <h5 class="mb-0"><i class="bi bi-receipt"></i> Detail Transaksi #<?php echo e($transaction->transaction_code); ?></h5>
                <?php echo $transaction->status_badge; ?>

            </div>
            <div class="card-body">
                <div class="row mb-4">
                    <div class="col-md-6">
                        <h6><i class="bi bi-person"></i> Informasi Pelanggan</h6>
                        <table class="table table-sm">
                            <tr>
                                <td>Nama</td>
                                <td>: <?php echo e($transaction->user->full_name ?? $transaction->user->username); ?></td>
                            </tr>
                            <tr>
                                <td>Email</td>
                                <td>: <?php echo e($transaction->user->email); ?></td>
                            </tr>
                            <tr>
                                <td>Telepon</td>
                                <td>: <?php echo e($transaction->user->phone ?? '-'); ?></td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-md-6">
                        <h6><i class="bi bi-info-circle"></i> Informasi Pesanan</h6>
                        <table class="table table-sm">
                            <tr>
                                <td>Tanggal</td>
                                <td>: <?php echo e($transaction->created_at->format('d M Y H:i')); ?></td>
                            </tr>
                            <tr>
                                <td>Metode Bayar</td>
                                <td>: <?php echo e(ucfirst($transaction->payment_method)); ?></td>
                            </tr>
                            <tr>
                                <td>Alamat</td>
                                <td>: <?php echo e($transaction->shipping_address); ?></td>
                            </tr>
                        </table>
                    </div>
                </div>
                
                <h6><i class="bi bi-box"></i> Item Pesanan</h6>
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Produk</th>
                                <th>Harga</th>
                                <th>Jumlah</th>
                                <th>Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $transaction->items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td><?php echo e($item->product->name ?? 'Produk tidak tersedia'); ?></td>
                                    <td>Rp <?php echo e(number_format($item->price, 0, ',', '.')); ?></td>
                                    <td><?php echo e($item->quantity); ?></td>
                                    <td>Rp <?php echo e(number_format($item->price * $item->quantity, 0, ',', '.')); ?></td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                        <tfoot>
                            <tr class="table-dark">
                                <th colspan="3" class="text-end">Total:</th>
                                <th>Rp <?php echo e(number_format($transaction->total_amount, 0, ',', '.')); ?></th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
                
                <?php if($transaction->notes): ?>
                    <div class="alert alert-info">
                        <strong><i class="bi bi-chat-text"></i> Catatan:</strong> <?php echo e($transaction->notes); ?>

                    </div>
                <?php endif; ?>
                
                <?php if($transaction->status == 'pending' && $transaction->payment_method == 'transfer'): ?>
                    <div class="card bg-light mt-4">
                        <div class="card-body">
                            <h6><i class="bi bi-upload"></i> Upload Bukti Pembayaran</h6>
                            <form action="<?php echo e(route('transactions.upload-payment', $transaction)); ?>" method="POST" enctype="multipart/form-data">
                                <?php echo csrf_field(); ?>
                                <div class="row">
                                    <div class="col-md-8">
                                        <input type="file" name="payment_proof" class="form-control" accept="image/*" required>
                                    </div>
                                    <div class="col-md-4">
                                        <button type="submit" class="btn btn-success w-100">
                                            <i class="bi bi-upload"></i> Upload
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                <?php endif; ?>
                
                <?php if($transaction->payment_proof_url): ?>
                    <div class="mt-4">
                        <h6><i class="bi bi-image"></i> Bukti Pembayaran</h6>
                        <img src="<?php echo e($transaction->payment_proof_url); ?>" 
                             alt="Bukti Pembayaran" class="img-thumbnail" style="max-width: 300px;">
                    </div>
                <?php endif; ?>
            </div>
            <div class="card-footer">
                <a href="<?php echo e(route('transactions.index')); ?>" class="btn btn-secondary">
                    <i class="bi bi-arrow-left"></i> Kembali
                </a>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\akari-store\resources\views/transactions/show.blade.php ENDPATH**/ ?>