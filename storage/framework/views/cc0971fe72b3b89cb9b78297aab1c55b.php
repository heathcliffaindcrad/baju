


<?php $__env->startSection('title', 'Notifikasi'); ?>

<?php $__env->startSection('content'); ?>
<div class="row">
    <div class="col-lg-10 mx-auto">
        <!-- Header -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h3 class="mb-1">
                    <i class="bi bi-bell-fill" style="background: var(--primary-gradient); -webkit-background-clip: text; -webkit-text-fill-color: transparent;"></i>
                    Notifikasi
                </h3>
                <p class="text-muted mb-0">
                    <?php if($notifications->where('is_read', false)->count() > 0): ?>
                        Anda memiliki <?php echo e($notifications->where('is_read', false)->count()); ?> notifikasi belum dibaca
                    <?php else: ?>
                        Semua notifikasi telah dibaca
                    <?php endif; ?>
                </p>
            </div>
            <?php if($notifications->where('is_read', false)->count() > 0): ?>
                <form action="<?php echo e(route('notifications.read-all')); ?>" method="POST">
                    <?php echo csrf_field(); ?>
                    <button type="submit" class="btn btn-modern-primary">
                        <i class="bi bi-check-all me-1"></i> Tandai Semua Dibaca
                    </button>
                </form>
            <?php endif; ?>
        </div>
        
        <!-- Notifications List -->
        <div class="card-modern">
            <div class="card-body p-0">
                <?php $__empty_1 = true; $__currentLoopData = $notifications; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $notification): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <div class="notification-item d-flex justify-content-between align-items-start p-4 <?php echo e(!$loop->last ? 'border-bottom' : ''); ?> <?php echo e(!$notification->is_read ? 'notification-unread' : ''); ?>">
                        <div class="d-flex flex-grow-1">
                            <!-- Icon -->
                            <div class="notification-icon me-3">
                                <?php if($notification->type == 'success'): ?>
                                    <div class="icon-circle bg-success-soft text-success">
                                        <i class="bi bi-check-circle-fill"></i>
                                    </div>
                                <?php elseif($notification->type == 'warning'): ?>
                                    <div class="icon-circle bg-warning-soft text-warning">
                                        <i class="bi bi-exclamation-triangle-fill"></i>
                                    </div>
                                <?php elseif($notification->type == 'danger'): ?>
                                    <div class="icon-circle bg-danger-soft text-danger">
                                        <i class="bi bi-x-circle-fill"></i>
                                    </div>
                                <?php else: ?>
                                    <div class="icon-circle bg-info-soft text-info">
                                        <i class="bi bi-info-circle-fill"></i>
                                    </div>
                                <?php endif; ?>
                            </div>
                            
                            <!-- Content -->
                            <div class="notification-content flex-grow-1">
                                <div class="d-flex justify-content-between align-items-start">
                                    <h6 class="mb-1 <?php echo e(!$notification->is_read ? 'fw-bold' : 'text-muted'); ?>">
                                        <?php echo e($notification->title); ?>

                                    </h6>
                                    <?php if(!$notification->is_read): ?>
                                        <span class="badge bg-primary rounded-pill ms-2">Baru</span>
                                    <?php endif; ?>
                                </div>
                                <p class="mb-2 <?php echo e($notification->is_read ? 'text-muted' : ''); ?>">
                                    <?php echo e($notification->message); ?>

                                </p>
                                <div class="d-flex align-items-center">
                                    <small class="text-muted">
                                        <i class="bi bi-clock me-1"></i>
                                        <?php echo e($notification->created_at->diffForHumans()); ?>

                                    </small>
                                    <small class="text-muted ms-3">
                                        <i class="bi bi-calendar me-1"></i>
                                        <?php echo e($notification->created_at->format('d M Y, H:i')); ?>

                                    </small>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Actions -->
                        <div class="notification-actions d-flex gap-2 ms-3">
                            <?php if(!$notification->is_read): ?>
                                <form action="<?php echo e(route('notifications.read', $notification->id)); ?>" method="POST">
                                    <?php echo csrf_field(); ?>
                                    <button type="submit" class="btn btn-sm btn-outline-success rounded-circle" title="Tandai dibaca">
                                        <i class="bi bi-check"></i>
                                    </button>
                                </form>
                            <?php endif; ?>
                            <form action="<?php echo e(route('notifications.destroy', $notification->id)); ?>" method="POST" 
                                  onsubmit="return confirm('Yakin ingin menghapus notifikasi ini?')">
                                <?php echo csrf_field(); ?>
                                <?php echo method_field('DELETE'); ?>
                                <button type="submit" class="btn btn-sm btn-outline-danger rounded-circle" title="Hapus">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <div class="text-center py-5">
                        <div class="empty-state">
                            <div class="empty-icon mb-4">
                                <i class="bi bi-bell-slash"></i>
                            </div>
                            <h5 class="text-muted">Tidak ada notifikasi</h5>
                            <p class="text-muted mb-0">Notifikasi baru akan muncul di sini</p>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
        
        <!-- Pagination -->
        <div class="mt-4">
            <?php echo e($notifications->links()); ?>

        </div>
    </div>
</div>

<?php $__env->startPush('styles'); ?>
<style>
    .notification-item {
        transition: all 0.3s ease;
    }
    
    .notification-item:hover {
        background: rgba(102, 126, 234, 0.03);
    }
    
    .notification-unread {
        background: linear-gradient(135deg, rgba(102, 126, 234, 0.05) 0%, rgba(118, 75, 162, 0.05) 100%);
        border-left: 4px solid #667eea !important;
    }
    
    .icon-circle {
        width: 48px;
        height: 48px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.25rem;
    }
    
    .bg-success-soft {
        background: rgba(17, 153, 142, 0.1);
    }
    
    .bg-warning-soft {
        background: rgba(255, 193, 7, 0.1);
    }
    
    .bg-danger-soft {
        background: rgba(220, 53, 69, 0.1);
    }
    
    .bg-info-soft {
        background: rgba(102, 126, 234, 0.1);
    }
    
    .empty-state {
        padding: 3rem;
    }
    
    .empty-icon {
        width: 100px;
        height: 100px;
        background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto;
    }
    
    .empty-icon i {
        font-size: 3rem;
        background: var(--primary-gradient);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
    }
    
    .notification-actions .btn {
        width: 36px;
        height: 36px;
        padding: 0;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    
    .btn-modern-primary {
        background: var(--primary-gradient);
        color: white;
        border: none;
        padding: 0.75rem 1.5rem;
        border-radius: 12px;
        font-weight: 600;
        transition: all 0.3s ease;
    }
    
    .btn-modern-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(102, 126, 234, 0.4);
        color: white;
    }
</style>
<?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\akari-store\resources\views/notifications/index.blade.php ENDPATH**/ ?>