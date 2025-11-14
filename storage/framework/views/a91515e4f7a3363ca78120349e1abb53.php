<?php $__env->startSection('title', 'Simple Page - ' . cms_name()); ?>
<?php $__env->startSection('page_title', 'Simple Page Management'); ?>

<?php $__env->startSection('content'); ?>
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Simple Page Management</h3>
                    
                    <div class="card-tools">
                        <a href="<?php echo e(route('simplepage.create')); ?>" class="btn btn-sm btn-primary">
                            <i class="fas fa-plus"></i> Create Page
                        </a>
                    </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <p>This is the Simple Page management interface.</p>
                    <p>Here you can manage your simple pages.</p>
                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('theme.admin.adminlte::layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\htdocs\stelloCMS\app\Themes\admin\adminlte\simplepage\index.blade.php ENDPATH**/ ?>