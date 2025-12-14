


<?php $__env->startSection('title', 'Dashboard'); ?>

<?php $__env->startSection('content'); ?>

<div class="row mb-4">
    <div class="col-12">
        <div class="card-modern p-4" style="background: var(--primary-gradient); color: white;">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h2 class="mb-1"><i class="bi bi-speedometer2"></i> Dashboard</h2>
                    <p class="mb-0 opacity-75">Selamat datang kembali, <?php echo e($user->full_name ?? $user->username); ?>!</p>
                </div>
                <div class="d-none d-md-block">
                    <a href="<?php echo e(route('home')); ?>" class="btn btn-light btn-lg">
                        <i class="bi bi-bag-heart"></i> Lihat Produk
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="row mb-4">
    <div class="col-md-3 col-6">
        <div class="stat-card-modern gradient-1">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h6 class="mb-1 opacity-75">Total Transaksi</h6>
                    <h3 class="mb-0"><?php echo e($user->transactions->count()); ?></h3>
                </div>
                <i class="bi bi-receipt" style="font-size: 2rem; opacity: 0.5;"></i>
            </div>
        </div>
    </div>
    <div class="col-md-3 col-6">
        <div class="stat-card-modern gradient-2">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h6 class="mb-1 opacity-75">Selesai</h6>
                    <h3 class="mb-0"><?php echo e($user->transactions->where('status', 'completed')->count()); ?></h3>
                </div>
                <i class="bi bi-check-circle" style="font-size: 2rem; opacity: 0.5;"></i>
            </div>
        </div>
    </div>
    <div class="col-md-3 col-6">
        <div class="stat-card-modern gradient-3">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h6 class="mb-1 opacity-75">Notifikasi</h6>
                    <h3 class="mb-0"><?php echo e($unread_notifications); ?></h3>
                </div>
                <i class="bi bi-bell" style="font-size: 2rem; opacity: 0.5;"></i>
            </div>
        </div>
    </div>
    <div class="col-md-3 col-6">
        <div class="stat-card-modern gradient-4">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h6 class="mb-1 opacity-75">Keranjang</h6>
                    <h3 class="mb-0"><?php echo e(count(session('cart', []))); ?></h3>
                </div>
                <i class="bi bi-cart3" style="font-size: 2rem; opacity: 0.5;"></i>
            </div>
        </div>
    </div>
</div>


<div class="row mb-4">
    <div class="col-12">
        <div class="card-modern">
            <div class="card-header">
                <h5 class="mb-0"><i class="bi bi-lightning-charge"></i> Menu Cepat</h5>
            </div>
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-md-3 col-6">
                        <a href="<?php echo e(route('home')); ?>" class="btn btn-modern btn-modern-primary w-100 py-3">
                            <i class="bi bi-bag-heart fs-4 d-block mb-1"></i>
                            Katalog Produk
                        </a>
                    </div>
                    <div class="col-md-3 col-6">
                        <a href="<?php echo e(route('cart.index')); ?>" class="btn btn-outline-primary w-100 py-3" style="border-radius: 12px;">
                            <i class="bi bi-cart3 fs-4 d-block mb-1"></i>
                            Keranjang
                            <?php if(count(session('cart', [])) > 0): ?>
                                <span class="badge bg-danger"><?php echo e(count(session('cart', []))); ?></span>
                            <?php endif; ?>
                        </a>
                    </div>
                    <div class="col-md-3 col-6">
                        <a href="<?php echo e(route('transactions.index')); ?>" class="btn btn-outline-success w-100 py-3" style="border-radius: 12px;">
                            <i class="bi bi-receipt fs-4 d-block mb-1"></i>
                            Pesanan Saya
                        </a>
                    </div>
                    <div class="col-md-3 col-6">
                        <a href="<?php echo e(route('notifications.index')); ?>" class="btn btn-outline-warning w-100 py-3" style="border-radius: 12px;">
                            <i class="bi bi-bell fs-4 d-block mb-1"></i>
                            Notifikasi
                            <?php if($unread_notifications > 0): ?>
                                <span class="badge bg-danger"><?php echo e($unread_notifications); ?></span>
                            <?php endif; ?>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="row">
    <div class="col-md-8">
        <div class="card-modern">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0"><i class="bi bi-clock-history"></i> Transaksi Terbaru</h5>
                <a href="<?php echo e(route('transactions.index')); ?>" class="btn btn-sm btn-outline-primary" style="border-radius: 20px;">
                    Lihat Semua
                </a>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-modern">
                        <thead>
                            <tr>
                                <th>Kode</th>
                                <th>Tanggal</th>
                                <th>Total</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__empty_1 = true; $__currentLoopData = $recent_transactions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $transaction): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                <tr>
                                    <td>
                                        <span class="fw-bold"><?php echo e($transaction->transaction_code); ?></span>
                                    </td>
                                    <td><?php echo e($transaction->created_at->format('d M Y')); ?></td>
                                    <td>Rp <?php echo e(number_format($transaction->total_amount, 0, ',', '.')); ?></td>
                                    <td><?php echo $transaction->status_badge; ?></td>
                                    <td>
                                        <a href="<?php echo e(route('transactions.show', $transaction)); ?>" class="btn btn-sm btn-outline-primary" style="border-radius: 8px;">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                <tr>
                                    <td colspan="5" class="text-center text-muted py-4">
                                        <i class="bi bi-inbox fs-3 d-block mb-2"></i>
                                        Belum ada transaksi
                                    </td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card-modern">
            <div class="card-header">
                <h5 class="mb-0"><i class="bi bi-person"></i> Profil Saya</h5>
            </div>
            <div class="card-body">
                <div class="text-center mb-3">
                    <div class="rounded-circle mx-auto d-flex align-items-center justify-content-center mb-3" style="width: 80px; height: 80px; background: var(--primary-gradient);">
                        <i class="bi bi-person-fill text-white" style="font-size: 2.5rem;"></i>
                    </div>
                    <h5 class="mb-1"><?php echo e($user->full_name ?? $user->username); ?></h5>
                    <p class="text-muted small mb-0"><?php echo e($user->email); ?></p>
                </div>
                <hr>
                <table class="table table-sm table-borderless mb-3">
                    <tr>
                        <td class="text-muted"><i class="bi bi-person"></i> Username</td>
                        <td class="fw-bold text-end"><?php echo e($user->username); ?></td>
                    </tr>
                    <tr>
                        <td class="text-muted"><i class="bi bi-telephone"></i> Telepon</td>
                        <td class="fw-bold text-end"><?php echo e($user->phone ?? '-'); ?></td>
                    </tr>
                    <tr>
                        <td class="text-muted"><i class="bi bi-geo-alt"></i> Alamat</td>
                        <td class="fw-bold text-end"><?php echo e(Str::limit($user->address ?? '-', 20)); ?></td>
                    </tr>
                    <tr>
                        <td class="text-muted"><i class="bi bi-calendar"></i> Bergabung</td>
                        <td class="fw-bold text-end"><?php echo e($user->created_at->format('d M Y')); ?></td>
                    </tr>
                </table>
                <a href="<?php echo e(route('profile')); ?>" class="btn btn-modern btn-modern-primary w-100">
                    <i class="bi bi-pencil"></i> Edit Profil
                </a>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\akari-store\resources\views/user/dashboard.blade.php ENDPATH**/ ?>