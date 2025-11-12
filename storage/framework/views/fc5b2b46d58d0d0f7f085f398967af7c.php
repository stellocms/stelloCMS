<?php $__env->startSection('title', 'Daftar Kategori - ' . cms_name()); ?>
<?php $__env->startSection('page_title', 'Daftar Kategori'); ?>

<?php $__env->startSection('content'); ?>
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Kategori Berita</h3>
                    <div class="card-tools">
                        <a href="<?php echo e(in_array('panel.kategori.create', array_keys(app('router')->getRoutes()->getRoutesByName())) ? route('panel.kategori.create') : url('/panel/kategori/create')); ?>" class="btn btn-primary">Tambah Kategori</a>
                    </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body table-responsive p-0">
                    <table class="table table-hover text-nowrap">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nama Kategori</th>
                                <th>Deskripsi</th>
                                <th>Warna</th>
                                <th>Aktif</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__empty_1 = true; $__currentLoopData = $kategori; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr>
                                <td><?php echo e($item->id); ?></td>
                                <td><?php echo e($item->nama_kategori); ?></td>
                                <td><?php echo e(Str::limit(strip_tags($item->deskripsi), 50)); ?></td>
                                <td>
                                    <span class="badge" style="background-color: <?php echo e($item->warna); ?>;"><?php echo e($item->warna); ?></span>
                                </td>
                                <td>
                                    <span class="badge <?php echo e($item->aktif ? 'badge-success' : 'badge-warning'); ?>">
                                        <?php echo e($item->aktif ? 'Aktif' : 'Tidak Aktif'); ?>

                                    </span>
                                </td>
                                <td>
                                    <a href="<?php echo e(in_array('panel.kategori.show', array_keys(app('router')->getRoutes()->getRoutesByName())) ? route('panel.kategori.show', $item->id) : url('/panel/kategori/' . $item->id)); ?>" class="btn btn-sm btn-info">Lihat</a>
                                    <a href="<?php echo e(in_array('panel.kategori.edit', array_keys(app('router')->getRoutes()->getRoutesByName())) ? route('panel.kategori.edit', $item->id) : url('/panel/kategori/' . $item->id . '/edit')); ?>" class="btn btn-sm btn-primary">Edit</a>
                                    <form action="<?php echo e(in_array('panel.kategori.destroy', array_keys(app('router')->getRoutes()->getRoutesByName())) ? route('panel.kategori.destroy', $item->id) : url('/panel/kategori/' . $item->id)); ?>" method="POST" class="d-inline">
                                        <?php echo csrf_field(); ?>
                                        <?php echo method_field('DELETE'); ?>
                                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Yakin ingin menghapus kategori ini?')">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr>
                                <td colspan="6" class="text-center">Tidak ada kategori ditemukan</td>
                            </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
                <!-- /.card-body -->
                <div class="card-footer clearfix">
                    <?php echo e($kategori->links()); ?>

                </div>
            </div>
            <!-- /.card -->
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('theme.admin.' . config('themes.admin') . '::layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\htdocs\stelloCMS\app\Plugins/Kategori/Views/index.blade.php ENDPATH**/ ?>