<?php $__env->startSection('title', 'Manajemen Contoh Plugin - ' . cms_name()); ?>
<?php $__env->startSection('page_title', 'Manajemen Contoh Plugin'); ?>

<?php $__env->startSection('content'); ?>
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Daftar Contoh Plugin</h3>
                    <div class="card-tools">
                        <a href="<?php echo e(in_array('panel.contohplugin.create', array_keys(app('router')->getRoutes()->getRoutesByName())) ? route('panel.contohplugin.create') : url('/panel/contohplugin/create')); ?>" class="btn btn-primary">Tambah Contoh Plugin</a>
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
                                <th>Judul</th>
                                <th>Deskripsi Singkat</th>
                                <th>Tanggal Dibuat</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__empty_1 = true; $__currentLoopData = $contohPlugins; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr>
                                <td><?php echo e($item->id); ?></td>
                                <td><?php echo e($item->judul); ?></td>
                                <td><?php echo e(Str::limit(strip_tags($item->deskripsi), 100)); ?></td>
                                <td><?php echo e($item->tanggal_dibuat ? $item->tanggal_dibuat->format('d M Y') : '-'); ?></td>
                                <td>
                                    <span class="badge <?php echo e($item->aktif ? 'badge-success' : 'badge-warning'); ?>">
                                        <?php echo e($item->aktif ? 'Aktif' : 'Tidak Aktif'); ?>

                                    </span>
                                </td>
                                <td>
                                    <a href="<?php echo e(in_array('panel.contohplugin.show', array_keys(app('router')->getRoutes()->getRoutesByName())) ? route('panel.contohplugin.show', $item->id) : url('/panel/contohplugin/' . $item->id)); ?>" class="btn btn-sm btn-info">Lihat</a>
                                    <a href="<?php echo e(in_array('panel.contohplugin.edit', array_keys(app('router')->getRoutes()->getRoutesByName())) ? route('panel.contohplugin.edit', $item->id) : url('/panel/contohplugin/' . $item->id . '/edit')); ?>" class="btn btn-sm btn-primary">Edit</a>
                                    <form action="<?php echo e(in_array('panel.contohplugin.destroy', array_keys(app('router')->getRoutes()->getRoutesByName())) ? route('panel.contohplugin.destroy', $item->id) : url('/panel/contohplugin/' . $item->id)); ?>" method="POST" class="d-inline">
                                        <?php echo csrf_field(); ?>
                                        <?php echo method_field('DELETE'); ?>
                                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Yakin ingin menghapus contoh plugin ini?')">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr>
                                <td colspan="6" class="text-center">Tidak ada contoh plugin ditemukan</td>
                            </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
                <!-- /.card-body -->
                <div class="card-footer clearfix">
                    <?php echo e($contohPlugins->links()); ?>

                </div>
            </div>
            <!-- /.card -->
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('theme.admin.' . config('themes.admin') . '::layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\htdocs\stelloCMS\app\Plugins/ContohPlugin/Views/index.blade.php ENDPATH**/ ?>