


<?php $__env->startSection('title', 'Kelola Transaksi'); ?>

<?php $__env->startSection('content'); ?>
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2><i class="bi bi-receipt"></i> Kelola Transaksi</h2>
</div>


<div class="card mb-4">
    <div class="card-body">
        <form method="GET" action="<?php echo e(route('admin.transactions.index')); ?>" class="row g-3">
            <div class="col-md-3">
                <label class="form-label">Status</label>
                <select name="status" class="form-select">
                    <option value="">Semua Status</option>
                    <option value="pending" <?php echo e(request('status') == 'pending' ? 'selected' : ''); ?>>Menunggu Pembayaran</option>
                    <option value="processing" <?php echo e(request('status') == 'processing' ? 'selected' : ''); ?>>Menunggu Konfirmasi</option>
                    <option value="paid" <?php echo e(request('status') == 'paid' ? 'selected' : ''); ?>>Dibayar</option>
                    <option value="ready_pickup" <?php echo e(request('status') == 'ready_pickup' ? 'selected' : ''); ?>>Siap Diambil</option>
                    <option value="shipped" <?php echo e(request('status') == 'shipped' ? 'selected' : ''); ?>>Dikirim</option>
                    <option value="completed" <?php echo e(request('status') == 'completed' ? 'selected' : ''); ?>>Selesai</option>
                    <option value="cancelled" <?php echo e(request('status') == 'cancelled' ? 'selected' : ''); ?>>Dibatalkan</option>
                </select>
            </div>
            <div class="col-md-3">
                <label class="form-label">Metode Pembayaran</label>
                <select name="payment_method" class="form-select">
                    <option value="">Semua Metode</option>
                    <option value="transfer" <?php echo e(request('payment_method') == 'transfer' ? 'selected' : ''); ?>>Transfer</option>
                    <option value="cod" <?php echo e(request('payment_method') == 'cod' ? 'selected' : ''); ?>>COD</option>
                </select>
            </div>
            <div class="col-md-3">
                <label class="form-label">Cari Kode/Customer</label>
                <input type="text" name="search" class="form-control" placeholder="Cari..." value="<?php echo e(request('search')); ?>">
            </div>
            <div class="col-md-3 d-flex align-items-end">
                <button type="submit" class="btn btn-primary me-2"><i class="bi bi-search"></i> Filter</button>
                <a href="<?php echo e(route('admin.transactions.index')); ?>" class="btn btn-secondary"><i class="bi bi-x-circle"></i> Reset</a>
            </div>
        </form>
    </div>
</div>


<div class="row mb-4">
    <div class="col-md-2">
        <div class="card text-center border-warning">
            <div class="card-body py-2">
                <h5 class="text-warning mb-0"><?php echo e($statusCounts['pending'] ?? 0); ?></h5>
                <small class="text-muted">Menunggu</small>
            </div>
        </div>
    </div>
    <div class="col-md-2">
        <div class="card text-center border-info">
            <div class="card-body py-2">
                <h5 class="text-info mb-0"><?php echo e($statusCounts['processing'] ?? 0); ?></h5>
                <small class="text-muted">Konfirmasi</small>
            </div>
        </div>
    </div>
    <div class="col-md-2">
        <div class="card text-center border-primary">
            <div class="card-body py-2">
                <h5 class="text-primary mb-0"><?php echo e($statusCounts['paid'] ?? 0); ?></h5>
                <small class="text-muted">Dibayar</small>
            </div>
        </div>
    </div>
    <div class="col-md-2">
        <div class="card text-center border-secondary">
            <div class="card-body py-2">
                <h5 class="text-secondary mb-0"><?php echo e($statusCounts['shipped'] ?? 0); ?></h5>
                <small class="text-muted">Dikirim</small>
            </div>
        </div>
    </div>
    <div class="col-md-2">
        <div class="card text-center border-success">
            <div class="card-body py-2">
                <h5 class="text-success mb-0"><?php echo e($statusCounts['completed'] ?? 0); ?></h5>
                <small class="text-muted">Selesai</small>
            </div>
        </div>
    </div>
    <div class="col-md-2">
        <div class="card text-center border-danger">
            <div class="card-body py-2">
                <h5 class="text-danger mb-0"><?php echo e($statusCounts['cancelled'] ?? 0); ?></h5>
                <small class="text-muted">Batal</small>
            </div>
        </div>
    </div>
</div>

<div class="card shadow">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped table-hover">
                <thead class="table-dark">
                    <tr>
                        <th>Kode</th>
                        <th>Pelanggan</th>
                        <th>Tanggal</th>
                        <th>Total</th>
                        <th>Metode</th>
                        <th>Bukti</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__empty_1 = true; $__currentLoopData = $transactions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $transaction): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr>
                            <td><strong><?php echo e($transaction->transaction_code); ?></strong></td>
                            <td>
                                <a href="<?php echo e(route('admin.users.show', $transaction->user)); ?>">
                                    <?php echo e($transaction->user->username ?? 'Guest'); ?>

                                </a>
                            </td>
                            <td><?php echo e($transaction->created_at->format('d M Y H:i')); ?></td>
                            <td>Rp <?php echo e(number_format($transaction->total_amount, 0, ',', '.')); ?></td>
                            <td><span class="badge bg-info"><?php echo e(ucfirst($transaction->payment_method)); ?></span></td>
                            <td>
                                <?php if($transaction->payment_proof_url): ?>
                                    <div class="btn-group btn-group-sm" role="group">
                                        <button type="button" class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#paymentModal<?php echo e($transaction->id); ?>" title="Lihat Bukti">
                                            <i class="bi bi-eye"></i>
                                        </button>
                                        <a href="<?php echo e($transaction->payment_proof_url); ?>" download class="btn btn-primary btn-sm" title="Download">
                                            <i class="bi bi-download"></i>
                                        </a>
                                    </div>
                                <?php else: ?>
                                    <span class="badge bg-secondary">-</span>
                                <?php endif; ?>
                            </td>
                            <td><?php echo $transaction->status_badge; ?></td>
                            <td>
                                <div class="btn-group" role="group">
                                    
                                    <a href="<?php echo e(route('admin.transactions.show', $transaction)); ?>" class="btn btn-sm btn-info" title="Lihat Detail">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                    
                                    
                                    <?php if($transaction->status === 'pending'): ?>
                                        
                                        <?php if($transaction->payment_proof): ?>
                                            <form action="<?php echo e(route('admin.transactions.update-status', $transaction)); ?>" method="POST" class="d-inline">
                                                <?php echo csrf_field(); ?>
                                                <?php echo method_field('PUT'); ?>
                                                <input type="hidden" name="status" value="processing">
                                                <button type="submit" class="btn btn-sm btn-warning" title="Proses Pembayaran" onclick="return confirm('Proses pembayaran ini?')">
                                                    <i class="bi bi-hourglass-split"></i>
                                                </button>
                                            </form>
                                        <?php endif; ?>
                                        <form action="<?php echo e(route('admin.transactions.update-status', $transaction)); ?>" method="POST" class="d-inline">
                                            <?php echo csrf_field(); ?>
                                            <?php echo method_field('PUT'); ?>
                                            <input type="hidden" name="status" value="cancelled">
                                            <button type="submit" class="btn btn-sm btn-danger" title="Batalkan" onclick="return confirm('Batalkan transaksi ini? Stok akan dikembalikan.')">
                                                <i class="bi bi-x-lg"></i>
                                            </button>
                                        </form>
                                    
                                    <?php elseif($transaction->status === 'processing'): ?>
                                        
                                        <form action="<?php echo e(route('admin.transactions.update-status', $transaction)); ?>" method="POST" class="d-inline">
                                            <?php echo csrf_field(); ?>
                                            <?php echo method_field('PUT'); ?>
                                            <input type="hidden" name="status" value="paid">
                                            <button type="submit" class="btn btn-sm btn-success" title="Konfirmasi Pembayaran" onclick="return confirm('Konfirmasi pembayaran ini?')">
                                                <i class="bi bi-check-lg"></i>
                                            </button>
                                        </form>
                                        <form action="<?php echo e(route('admin.transactions.update-status', $transaction)); ?>" method="POST" class="d-inline">
                                            <?php echo csrf_field(); ?>
                                            <?php echo method_field('PUT'); ?>
                                            <input type="hidden" name="status" value="cancelled">
                                            <button type="submit" class="btn btn-sm btn-danger" title="Batalkan" onclick="return confirm('Batalkan transaksi ini?')">
                                                <i class="bi bi-x-lg"></i>
                                            </button>
                                        </form>
                                    
                                    <?php elseif($transaction->status === 'paid'): ?>
                                        
                                        <form action="<?php echo e(route('admin.transactions.update-status', $transaction)); ?>" method="POST" class="d-inline">
                                            <?php echo csrf_field(); ?>
                                            <?php echo method_field('PUT'); ?>
                                            <input type="hidden" name="status" value="shipped">
                                            <button type="submit" class="btn btn-sm btn-primary" title="Kirim Pesanan" onclick="return confirm('Kirim pesanan ini?')">
                                                <i class="bi bi-truck"></i>
                                            </button>
                                        </form>
                                        <form action="<?php echo e(route('admin.transactions.update-status', $transaction)); ?>" method="POST" class="d-inline">
                                            <?php echo csrf_field(); ?>
                                            <?php echo method_field('PUT'); ?>
                                            <input type="hidden" name="status" value="ready_pickup">
                                            <button type="submit" class="btn btn-sm btn-secondary" title="Siap Diambil" onclick="return confirm('Tandai siap diambil?')">
                                                <i class="bi bi-shop"></i>
                                            </button>
                                        </form>
                                    
                                    <?php elseif($transaction->status === 'shipped' || $transaction->status === 'ready_pickup'): ?>
                                        
                                        <form action="<?php echo e(route('admin.transactions.update-status', $transaction)); ?>" method="POST" class="d-inline">
                                            <?php echo csrf_field(); ?>
                                            <?php echo method_field('PUT'); ?>
                                            <input type="hidden" name="status" value="completed">
                                            <button type="submit" class="btn btn-sm btn-success" title="Selesaikan" onclick="return confirm('Selesaikan transaksi ini?')">
                                                <i class="bi bi-check-circle"></i>
                                            </button>
                                        </form>
                                    <?php endif; ?>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr>
                            <td colspan="8" class="text-center">Tidak ada transaksi.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
        
        <?php echo e($transactions->appends(request()->query())->links()); ?>

    </div>
</div>


<?php $__currentLoopData = $transactions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $transaction): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <?php if($transaction->payment_proof_url): ?>
        <div class="modal fade" id="paymentModal<?php echo e($transaction->id); ?>" tabindex="-1" aria-labelledby="paymentModalLabel<?php echo e($transaction->id); ?>" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header bg-primary text-white">
                        <h5 class="modal-title" id="paymentModalLabel<?php echo e($transaction->id); ?>">
                            <i class="bi bi-image"></i> Bukti Pembayaran - <?php echo e($transaction->transaction_code); ?>

                        </h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body text-center p-4">
                        <img src="<?php echo e($transaction->payment_proof_url); ?>" alt="Bukti Pembayaran" class="img-fluid rounded shadow" style="max-height: 500px;">
                        <div class="mt-3">
                            <p class="text-muted mb-1">
                                <strong>Pelanggan:</strong> <?php echo e($transaction->user->full_name ?? $transaction->user->username); ?>

                            </p>
                            <p class="text-muted mb-1">
                                <strong>Total:</strong> Rp <?php echo e(number_format($transaction->total_amount, 0, ',', '.')); ?>

                            </p>
                            <?php if($transaction->paid_at): ?>
                                <p class="text-muted mb-0">
                                    <strong>Tanggal Upload:</strong> <?php echo e($transaction->paid_at->format('d M Y H:i')); ?>

                                </p>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <a href="<?php echo e($transaction->payment_proof_url); ?>" download class="btn btn-primary">
                            <i class="bi bi-download"></i> Download
                        </a>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\akari-store\resources\views/admin/transactions/index.blade.php ENDPATH**/ ?>