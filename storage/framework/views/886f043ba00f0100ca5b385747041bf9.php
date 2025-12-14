


<?php $__env->startSection('title', 'Detail Transaksi Admin'); ?>

<?php $__env->startSection('content'); ?>
<div class="row justify-content-center">
    <div class="col-md-10">
        <div class="card shadow">
            <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                <h5 class="mb-0"><i class="bi bi-receipt"></i> Transaksi #<?php echo e($transaction->transaction_code); ?></h5>
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
                
                <?php if($transaction->payment_proof_url): ?>
                    <div class="mb-4">
                        <h6><i class="bi bi-image"></i> Bukti Pembayaran</h6>
                        <div class="card">
                            <div class="card-body text-center">
                                <a href="<?php echo e($transaction->payment_proof_url); ?>" target="_blank">
                                    <img src="<?php echo e($transaction->payment_proof_url); ?>" 
                                         alt="Bukti Pembayaran" class="img-fluid rounded shadow" style="max-width: 400px; cursor: pointer;">
                                </a>
                                <p class="text-muted small mt-2 mb-0">Klik gambar untuk memperbesar</p>
                            </div>
                            <div class="card-footer bg-light">
                                <div class="d-flex justify-content-between align-items-center">
                                    <?php if($transaction->paid_at): ?>
                                        <span class="text-muted"><i class="bi bi-calendar"></i> Diupload: <?php echo e($transaction->paid_at->format('d M Y H:i')); ?></span>
                                    <?php else: ?>
                                        <span></span>
                                    <?php endif; ?>
                                    <a href="<?php echo e($transaction->payment_proof_url); ?>" download class="btn btn-primary btn-sm">
                                        <i class="bi bi-download"></i> Download Bukti
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
                
                <div class="card bg-light">
                    <div class="card-body">
                        <h6><i class="bi bi-gear"></i> Update Status</h6>
                        <form action="<?php echo e(route('admin.transactions.update-status', $transaction)); ?>" method="POST" class="row g-2">
                            <?php echo csrf_field(); ?>
                            <?php echo method_field('PUT'); ?>
                            <div class="col-md-8">
                                <select name="status" class="form-select">
                                    <?php
                                        $statusLabels = [
                                            'pending' => 'Menunggu Pembayaran',
                                            'processing' => 'Menunggu Konfirmasi',
                                            'paid' => 'Dibayar',
                                            'ready_pickup' => 'Siap Diambil',
                                            'shipped' => 'Dikirim',
                                            'completed' => 'Selesai',
                                            'cancelled' => 'Dibatalkan'
                                        ];
                                    ?>
                                    <?php $__currentLoopData = ['pending', 'processing', 'paid', 'ready_pickup', 'shipped', 'completed', 'cancelled']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $status): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($status); ?>" <?php echo e($transaction->status == $status ? 'selected' : ''); ?>>
                                            <?php echo e($statusLabels[$status]); ?>

                                        </option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <button type="submit" class="btn btn-primary w-100">
                                    <i class="bi bi-save"></i> Update Status
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <a href="<?php echo e(route('admin.transactions.index')); ?>" class="btn btn-secondary">
                    <i class="bi bi-arrow-left"></i> Kembali
                </a>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\akari-store\resources\views/admin/transactions/show.blade.php ENDPATH**/ ?>