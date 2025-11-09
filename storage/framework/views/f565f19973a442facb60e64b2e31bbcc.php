<?php $__env->startSection('title', 'Detail Contoh Plugin - ' . cms_name()); ?>
<?php $__env->startSection('page_title', 'Detail Contoh Plugin'); ?>

<?php $__env->startSection('content'); ?>
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Detail: <?php echo e($contohPlugin->judul); ?></h3>
                    <div class="card-tools">
                        <a href="<?php echo e(route('contohplugin.index')); ?>" class="btn btn-secondary">Kembali</a>
                    </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>ID</label>
                                <p><?php echo e($contohPlugin->id); ?></p>
                            </div>
                            
                            <div class="form-group">
                                <label>Judul</label>
                                <p><?php echo e($contohPlugin->judul); ?></p>
                            </div>
                            
                            <div class="form-group">
                                <label>Tanggal Dibuat</label>
                                <p><?php echo e($contohPlugin->tanggal_dibuat ? $contohPlugin->tanggal_dibuat->format('d M Y H:i') : '-'); ?></p>
                            </div>
                            
                            <div class="form-group">
                                <label>Status</label>
                                <p>
                                    <span class="badge <?php echo e($contohPlugin->aktif ? 'badge-success' : 'badge-warning'); ?>">
                                        <?php echo e($contohPlugin->aktif ? 'Aktif' : 'Tidak Aktif'); ?>

                                    </span>
                                </p>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Gambar</label>
                                <?php if($contohPlugin->gambar): ?>
                                    <div>
                                        <img src="<?php echo e(asset('storage/' . $contohPlugin->gambar)); ?>" alt="Gambar" class="img-fluid" style="max-height: 200px;">
                                    </div>
                                <?php else: ?>
                                    <p>Tidak ada gambar</p>
                                <?php endif; ?>
                            </div>
                            
                            <div class="form-group">
                                <label>Deskripsi</label>
                                <div class="card">
                                    <div class="card-body">
                                        <?php echo $contohPlugin->deskripsi; ?>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.card-body -->
                <div class="card-footer">
                    <a href="<?php echo e(route('contohplugin.index')); ?>" class="btn btn-secondary">Kembali ke Daftar</a>
                    <a href="<?php echo e(route('contohplugin.edit', $contohPlugin->id)); ?>" class="btn btn-primary">Edit</a>
                </div>
            </div>
            <!-- /.card -->
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('theme.admin.' . config('themes.admin') . '::layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\htdocs\stelloCMS\app\Plugins/ContohPlugin/Views/show.blade.php ENDPATH**/ ?>