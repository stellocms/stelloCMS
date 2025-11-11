<?php $__env->startSection('title', 'Manajemen Pengaturan - ' . cms_name()); ?>
<?php $__env->startSection('page_title', 'Manajemen Pengaturan'); ?>

<?php $__env->startSection('content'); ?>
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Daftar Pengaturan</h3>
                    <div class="card-tools">
                        <form action="<?php echo e(route('setting.clear_cache')); ?>" method="POST" class="d-inline">
                            <?php echo csrf_field(); ?>
                            <button type="submit" class="btn btn-warning mr-2">
                                <i class="fas fa-broom"></i> Clear Cache
                            </button>
                        </form>
                        <a href="<?php echo e(route('setting.create')); ?>" class="btn btn-primary">Tambah Pengaturan</a>
                    </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body table-responsive p-0">
                    <?php if(session('success')): ?>
                        <div class="alert alert-success alert-dismissible">
                            <?php echo e(session('success')); ?>

                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                        </div>
                    <?php endif; ?>
                    
                    <table class="table table-hover text-nowrap">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nama Pengaturan</th>
                                <th>Nilai</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__empty_1 = true; $__currentLoopData = $settings; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $setting): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr>
                                <td><?php echo e($setting->id); ?></td>
                                <td><?php echo e($setting->pengaturan); ?></td>
                                <td><?php echo e(Str::limit(strip_tags($setting->nilai), 100)); ?></td>
                                <td>
                                    <span class="badge <?php echo e($setting->status === 'aktif' ? 'badge-success' : 'badge-danger'); ?>">
                                        <?php echo e($setting->status === 'aktif' ? 'Aktif' : 'Nonaktif'); ?>

                                    </span>
                                </td>
                                <td>
                                    <a href="<?php echo e(route('setting.edit', $setting->id)); ?>" class="btn btn-xs btn-primary">Edit</a>
                                    <form action="<?php echo e(route('setting.destroy', $setting->id)); ?>" method="POST" class="d-inline">
                                        <?php echo csrf_field(); ?>
                                        <?php echo method_field('DELETE'); ?>
                                        <button type="submit" class="btn btn-xs btn-danger" onclick="return confirm('Yakin ingin menghapus pengaturan ini?')">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr>
                                <td colspan="5" class="text-center">Tidak ada pengaturan ditemukan</td>
                            </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('theme.admin.adminlte::layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\htdocs\stelloCMS\resources\views/theme/admin/adminlte/settings/index.blade.php ENDPATH**/ ?>