


<?php $__env->startSection('title', 'Transaksi Saya'); ?>

<?php $__env->startSection('content'); ?>
<h2 class="mb-4"><i class="bi bi-receipt"></i> Transaksi Saya</h2>

<div class="card shadow">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped table-hover">
                <thead class="table-dark">
                    <tr>
                        <th>Kode Transaksi</th>
                        <th>Tanggal</th>
                        <th>Total</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__empty_1 = true; $__currentLoopData = $transactions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $transaction): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr>
                            <td><strong><?php echo e($transaction->transaction_code); ?></strong></td>
                            <td><?php echo e($transaction->created_at->format('d M Y H:i')); ?></td>
                            <td>Rp <?php echo e(number_format($transaction->total_amount, 0, ',', '.')); ?></td>
                            <td><?php echo $transaction->status_badge; ?></td>
                            <td>
                                <a href="<?php echo e(route('transactions.show', $transaction)); ?>" class="btn btn-sm btn-info">
                                    <i class="bi bi-eye"></i> Detail
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr>
                            <td colspan="5" class="text-center">
                                <div class="py-4">
                                    <i class="bi bi-receipt" style="font-size: 3rem; color: #ccc;"></i>
                                    <p class="mt-2">Belum ada transaksi.</p>
                                    <a href="<?php echo e(route('products.index')); ?>" class="btn btn-primary btn-sm">
                                        <i class="bi bi-grid"></i> Mulai Belanja
                                    </a>
                                </div>
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
        
        <?php echo e($transactions->links()); ?>

    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\akari-store\resources\views/user/transactions/index.blade.php ENDPATH**/ ?>