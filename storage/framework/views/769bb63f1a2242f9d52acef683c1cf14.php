<?php $__env->startSection('title', 'Detail Berita - ' . cms_name()); ?>
<?php $__env->startSection('page_title', 'Detail Berita'); ?>

<?php $__env->startSection('content'); ?>
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Detail Berita</h3>
                    <div class="card-tools">
                        <a href="<?php echo e(in_array('panel.berita.edit', array_keys(app('router')->getRoutes()->getRoutesByName())) ? route('panel.berita.edit', $berita->id) : url('/panel/berita/' . $berita->id . '/edit')); ?>" class="btn btn-primary">Edit</a>
                        <form action="<?php echo e(in_array('panel.berita.destroy', array_keys(app('router')->getRoutes()->getRoutesByName())) ? route('panel.berita.destroy', $berita->id) : url('/panel/berita/' . $berita->id)); ?>" method="POST" class="d-inline">
                            <?php echo csrf_field(); ?>
                            <?php echo method_field('DELETE'); ?>
                            <button type="submit" class="btn btn-danger" onclick="return confirm('Yakin ingin menghapus berita ini?')">Hapus</button>
                        </form>
                        <a href="<?php echo e(in_array('panel.berita.index', array_keys(app('router')->getRoutes()->getRoutesByName())) ? route('panel.berita.index') : url('/panel/berita')); ?>" class="btn btn-default">Kembali</a>
                    </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <h4><?php echo e($berita->judul); ?></h4>
                    <p class="text-muted"><?php echo e($berita->tanggal_publikasi->format('d M Y')); ?></p>
                    
                    <?php if($berita->gambar): ?>
                        <div class="mb-4">
                            <img src="<?php echo e(asset('storage/' . $berita->gambar)); ?>" alt="Gambar Berita" class="img-fluid rounded">
                        </div>
                    <?php endif; ?>
                    
                    <div class="berita-content">
                        <?php echo $berita->isi; ?>

                    </div>
                    
                    <div class="mt-4">
                        <span class="badge <?php echo e($berita->aktif ? 'badge-success' : 'badge-warning'); ?>">
                            <?php echo e($berita->aktif ? 'Aktif' : 'Tidak Aktif'); ?>

                        </span>
                    </div>
                </div>
                <!-- /.card-body -->
                <div class="card-footer">
                    <small class="text-muted">Dipublikasikan oleh: <?php echo e($berita->user->name ?? 'Admin'); ?></small>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
<style>
.berita-content img {
    max-width: 100%;
    height: auto;
}
</style>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('theme.admin.' . config('themes.admin') . '::layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\htdocs\stelloCMS\app\Plugins\Berita\Views\show.blade.php ENDPATH**/ ?>