<?php $__env->startSection('title', 'Detail Widget - ' . cms_name()); ?>
<?php $__env->startSection('page_title', 'Detail Widget'); ?>

<?php $__env->startSection('content'); ?>
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Detail Widget</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <div class="form-group">
                        <label>ID:</label>
                        <p class="form-control-plaintext"><?php echo e($widget->id); ?></p>
                    </div>

                    <div class="form-group">
                        <label>Nama:</label>
                        <p class="form-control-plaintext"><?php echo e($widget->name); ?></p>
                    </div>

                    <div class="form-group">
                        <label>Tipe:</label>
                        <p class="form-control-plaintext">
                            <span class="badge badge-<?php echo e($widget->type === 'plugin' ? 'info' : ($widget->type === 'text' ? 'warning' : 'success')); ?>">
                                <?php echo e(ucfirst($widget->type)); ?>

                            </span>
                        </p>
                    </div>

                    <div class="form-group">
                        <label>Posisi:</label>
                        <p class="form-control-plaintext"><span class="badge badge-secondary"><?php echo e($widget->position); ?></span></p>
                    </div>

                    <div class="form-group">
                        <label>Status:</label>
                        <p class="form-control-plaintext">
                            <span class="badge <?php echo e($widget->status === 'aktif' ? 'badge-success' : 'badge-danger'); ?>">
                                <?php echo e($widget->status); ?>

                            </span>
                        </p>
                    </div>

                    <div class="form-group">
                        <label>Nama Plugin:</label>
                        <p class="form-control-plaintext"><?php echo e($widget->plugin_name ?: '-'); ?></p>
                    </div>

                    <div class="form-group">
                        <label>Urutan:</label>
                        <p class="form-control-plaintext"><?php echo e($widget->order); ?></p>
                    </div>

                    <?php if($widget->content): ?>
                    <div class="form-group">
                        <label>Konten:</label>
                        <div class="form-control-plaintext" style="white-space: pre-wrap;"><?php echo e($widget->content); ?></div>
                    </div>
                    <?php endif; ?>

                    <?php if($widget->settings): ?>
                    <div class="form-group">
                        <label>Pengaturan:</label>
                        <pre class="form-control-plaintext"><?php echo e(json_encode($widget->settings, JSON_PRETTY_PRINT)); ?></pre>
                    </div>
                    <?php endif; ?>

                    <div class="form-group">
                        <label>Dibuat pada:</label>
                        <p class="form-control-plaintext"><?php echo e($widget->created_at->format('d-m-Y H:i:s')); ?></p>
                    </div>

                    <div class="form-group">
                        <label>Diupdate pada:</label>
                        <p class="form-control-plaintext"><?php echo e($widget->updated_at->format('d-m-Y H:i:s')); ?></p>
                    </div>
                </div>
                <!-- /.card-body -->
                <div class="card-footer">
                    <a href="<?php echo e(route('panel.widgets.edit', $widget->id)); ?>" class="btn btn-primary">Edit</a>
                    <a href="<?php echo e(route('panel.widgets.index')); ?>" class="btn btn-default">Kembali</a>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('theme.admin.adminlte::layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\htdocs\stelloCMS\app\Themes\admin\adminlte\widgets\show.blade.php ENDPATH**/ ?>