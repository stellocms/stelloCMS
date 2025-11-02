<?php $__env->startSection('title', 'Manajemen Tema - ' . cms_name()); ?>
<?php $__env->startSection('page_title', 'Manajemen Tema'); ?>

<?php $__env->startSection('content'); ?>
<div class="container-fluid">
    <!-- Admin Themes Row -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Tema Admin</h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <?php if(session('success')): ?>
                        <div class="alert alert-success alert-dismissible">
                            <?php echo e(session('success')); ?>

                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                        </div>
                    <?php endif; ?>

                    <?php if(session('error')): ?>
                        <div class="alert alert-danger alert-dismissible">
                            <?php echo e(session('error')); ?>

                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                        </div>
                    <?php endif; ?>
                    
                    <div class="row">
                        <?php $__currentLoopData = $adminThemes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $theme): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="col-md-6 col-lg-4 col-xl-3">
                            <div class="card card-primary">
                                <div class="card-header">
                                    <h3 class="card-title"><?php echo e(ucfirst(str_replace(['-', '_'], ' ', $theme['name']))); ?></h3>
                                </div>
                                <div class="card-body">
                                    <p class="card-text">Tema admin untuk panel kontrol</p>
                                    <?php if($theme['active']): ?>
                                        <span class="badge badge-success">Aktif</span>
                                    <?php else: ?>
                                        <form action="<?php echo e(route('themes.admin.switch')); ?>" method="POST" class="mt-2">
                                            <?php echo csrf_field(); ?>
                                            <input type="hidden" name="theme" value="<?php echo e($theme['name']); ?>">
                                            <button type="submit" class="btn btn-primary btn-block">Gunakan</button>
                                        </form>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Frontend Themes Row -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Tema Frontend</h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <?php $__currentLoopData = $frontendThemes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $theme): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="col-md-6 col-lg-4 col-xl-3">
                            <div class="card card-info">
                                <div class="card-header">
                                    <h3 class="card-title"><?php echo e(ucfirst(str_replace(['-', '_'], ' ', $theme['name']))); ?></h3>
                                </div>
                                <div class="card-body">
                                    <p class="card-text">Tema untuk tampilan pengunjung</p>
                                    <?php if($theme['active']): ?>
                                        <span class="badge badge-success">Aktif</span>
                                    <?php else: ?>
                                        <form action="<?php echo e(route('themes.frontend.switch')); ?>" method="POST" class="mt-2">
                                            <?php echo csrf_field(); ?>
                                            <input type="hidden" name="theme" value="<?php echo e($theme['name']); ?>">
                                            <button type="submit" class="btn btn-info btn-block">Gunakan</button>
                                        </form>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('theme.admin.adminlte::layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\htdocs\stelloCMS\app\Themes/admin/adminlte/themes/index.blade.php ENDPATH**/ ?>