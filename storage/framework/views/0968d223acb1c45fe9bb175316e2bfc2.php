<?php $__env->startSection('title', 'Manajemen Berita - ' . cms_name()); ?>
<?php $__env->startSection('page_title', 'Manajemen Berita'); ?>

<?php $__env->startSection('content'); ?>
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Daftar Berita</h3>
                    <div class="card-tools">
                        <a href="<?php echo e(route('berita.create')); ?>" class="btn btn-primary">Tambah Berita</a>
                    </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body table-responsive p-0">
                    <table class="table table-hover text-nowrap">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Judul</th>
                                <th>Ringkasan</th>
                                <th>Tanggal Publikasi</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__empty_1 = true; $__currentLoopData = $berita; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr>
                                <td><?php echo e($item->id); ?></td>
                                <td><?php echo e($item->judul); ?></td>
                                <td><?php echo e(Str::limit(strip_tags($item->isi), 100)); ?></td>
                                <td><?php echo e($item->tanggal_publikasi->format('d M Y')); ?></td>
                                <td>
                                    <span class="badge <?php echo e($item->aktif ? 'badge-success' : 'badge-warning'); ?>">
                                        <?php echo e($item->aktif ? 'Aktif' : 'Tidak Aktif'); ?>

                                    </span>
                                </td>
                                <td>
                                    <a href="<?php echo e(route('berita.show', $item->id)); ?>" class="btn btn-sm btn-info">Lihat</a>
                                    <a href="<?php echo e(route('berita.edit', $item->id)); ?>" class="btn btn-sm btn-primary">Edit</a>
                                    <form action="<?php echo e(route('berita.destroy', $item->id)); ?>" method="POST" class="d-inline">
                                        <?php echo csrf_field(); ?>
                                        <?php echo method_field('DELETE'); ?>
                                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Yakin ingin menghapus berita ini?')">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr>
                                <td colspan="6" class="text-center">Tidak ada berita ditemukan</td>
                            </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
                <!-- /.card-body -->
                <div class="card-footer clearfix">
                    <?php echo e($berita->links()); ?>

                </div>
            </div>
            <!-- /.card -->
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('theme.admin.' . config('themes.admin') . '::layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\htdocs\stelloCMS\app\Plugins/Berita/Views/index.blade.php ENDPATH**/ ?>