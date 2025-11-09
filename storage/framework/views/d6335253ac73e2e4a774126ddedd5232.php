<?php $__env->startSection('title', 'Contoh Plugin - ' . cms_name()); ?>
<?php $__env->startSection('description', 'Halaman publik untuk plugin Contoh Plugin'); ?>

<?php $__env->startSection('content'); ?>
<div class="container mt-5">
    <div class="row">
        <div class="col-12">
            <h1 class="mb-4">Contoh Plugin</h1>
            
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Daftar Item dari Contoh Plugin</h5>
                    
                    <?php if($contohPlugins && $contohPlugins->count() > 0): ?>
                        <div class="row">
                            <?php $__currentLoopData = $contohPlugins; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div class="col-md-4 mb-4">
                                    <div class="card h-100">
                                        <?php if($item->gambar): ?>
                                            <img src="<?php echo e(asset('storage/' . $item->gambar)); ?>" 
                                                 class="card-img-top" 
                                                 alt="<?php echo e($item->judul); ?>"
                                                 style="height: 200px; object-fit: cover;">
                                        <?php endif; ?>
                                        <div class="card-body">
                                            <h5 class="card-title"><?php echo e($item->judul); ?></h5>
                                            <p class="card-text">
                                                <?php echo Str::limit(strip_tags($item->deskripsi), 100); ?>

                                            </p>
                                            <p class="text-muted">
                                                <small>Dipublikasikan: <?php echo e($item->tanggal_dibuat ? $item->tanggal_dibuat->format('d M Y') : '-'); ?></small>
                                            </p>
                                        </div>
                                        <div class="card-footer">
                                            <a href="<?php echo e(route('contohplugin.frontpage.show', $item->slug)); ?>" 
                                               class="btn btn-primary btn-sm">Lihat Detail</a>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                        
                        <div class="d-flex justify-content-center">
                            <?php echo e($contohPlugins->links()); ?>

                        </div>
                    <?php else: ?>
                        <div class="alert alert-info">
                            <p>Belum ada data dalam Contoh Plugin.</p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('theme.frontend.' . config('themes.frontend') . '::layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\htdocs\stelloCMS\app\Plugins/ContohPlugin/Views/frontpage/index.blade.php ENDPATH**/ ?>