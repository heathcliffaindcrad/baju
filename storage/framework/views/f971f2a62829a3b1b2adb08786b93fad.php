


<?php $__env->startSection('title', 'Laporan Penjualan'); ?>

<?php $__env->startSection('content'); ?>
<div class="row mb-4 animate-fadeInUp">
    <div class="col-12">
        <h2 class="fw-bold"><i class="bi bi-file-earmark-bar-graph"></i> Laporan Penjualan</h2>
        <p class="text-muted">Export data penjualan dan produk ke format CSV</p>
    </div>
</div>


<div class="card-modern mb-4 animate-fadeInUp">
    <div class="card-body">
        <form action="<?php echo e(route('admin.reports.index')); ?>" method="GET" class="row g-3 align-items-end">
            <div class="col-md-4">
                <label class="form-label fw-bold">Tanggal Mulai</label>
                <input type="date" name="start_date" class="form-control" style="border-radius: 10px;"
                       value="<?php echo e($startDate ?? now()->startOfMonth()->format('Y-m-d')); ?>">
            </div>
            <div class="col-md-4">
                <label class="form-label fw-bold">Tanggal Akhir</label>
                <input type="date" name="end_date" class="form-control" style="border-radius: 10px;"
                       value="<?php echo e($endDate ?? now()->format('Y-m-d')); ?>">
            </div>
            <div class="col-md-4">
                <button type="submit" class="btn btn-modern btn-modern-primary">
                    <i class="bi bi-search"></i> Tampilkan
                </button>
            </div>
        </form>
    </div>
</div>


<?php if(isset($summary)): ?>
<div class="row mb-4">
    <div class="col-md-4 mb-3">
        <div class="stat-card-modern gradient-1 animate-fadeInUp">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <p class="mb-1 opacity-75">Total Pendapatan</p>
                    <h4 class="mb-0 fw-bold">Rp <?php echo e(number_format($summary['total_revenue'], 0, ',', '.')); ?></h4>
                </div>
                <i class="bi bi-wallet2 fs-1 opacity-50"></i>
            </div>
        </div>
    </div>
    <div class="col-md-4 mb-3">
        <div class="stat-card-modern gradient-2 animate-fadeInUp" style="animation-delay: 0.1s">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <p class="mb-1 opacity-75">Total Transaksi</p>
                    <h4 class="mb-0 fw-bold"><?php echo e($summary['total_transactions']); ?></h4>
                </div>
                <i class="bi bi-receipt fs-1 opacity-50"></i>
            </div>
        </div>
    </div>
    <div class="col-md-4 mb-3">
        <div class="stat-card-modern gradient-3 animate-fadeInUp" style="animation-delay: 0.2s">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <p class="mb-1 opacity-75">Rata-rata Order</p>
                    <h4 class="mb-0 fw-bold">Rp <?php echo e(number_format($summary['avg_order_value'], 0, ',', '.')); ?></h4>
                </div>
                <i class="bi bi-graph-up fs-1 opacity-50"></i>
            </div>
        </div>
    </div>
</div>
<?php endif; ?>


<div class="row">
    <div class="col-md-6 mb-4">
        <div class="card-modern h-100 animate-fadeInUp">
            <div class="card-body text-center py-5">
                <i class="bi bi-file-earmark-spreadsheet text-success" style="font-size: 4rem;"></i>
                <h4 class="mt-3 fw-bold">Export Laporan Penjualan</h4>
                <p class="text-muted">Download data transaksi yang sudah selesai dalam format CSV</p>
                <a href="<?php echo e(route('admin.reports.export-sales')); ?>?start_date=<?php echo e($startDate ?? now()->startOfMonth()->format('Y-m-d')); ?>&end_date=<?php echo e($endDate ?? now()->format('Y-m-d')); ?>" 
                   class="btn btn-modern btn-modern-success btn-lg">
                    <i class="bi bi-download"></i> Download CSV Penjualan
                </a>
            </div>
        </div>
    </div>
    <div class="col-md-6 mb-4">
        <div class="card-modern h-100 animate-fadeInUp" style="animation-delay: 0.1s">
            <div class="card-body text-center py-5">
                <i class="bi bi-box-seam text-primary" style="font-size: 4rem;"></i>
                <h4 class="mt-3 fw-bold">Export Data Produk</h4>
                <p class="text-muted">Download daftar semua produk beserta stok dalam format CSV</p>
                <a href="<?php echo e(route('admin.reports.export-products')); ?>" 
                   class="btn btn-modern btn-modern-primary btn-lg">
                    <i class="bi bi-download"></i> Download CSV Produk
                </a>
            </div>
        </div>
    </div>
</div>


<div class="card-modern animate-fadeInUp">
    <div class="card-body">
        <h5 class="fw-bold"><i class="bi bi-info-circle text-info"></i> Informasi</h5>
        <ul class="mb-0">
            <li>File CSV menggunakan separator <strong>titik koma (;)</strong> untuk kompatibilitas dengan Excel Indonesia</li>
            <li>Laporan penjualan hanya mencakup transaksi dengan status <strong>Completed, Shipped, atau Paid</strong></li>
            <li>Gunakan filter tanggal untuk memilih rentang waktu laporan</li>
        </ul>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\akari-store\resources\views/admin/reports/index.blade.php ENDPATH**/ ?>