<?php if($randomNews && $randomNews->count() > 0): ?>
<div class="widget widget-random-news">
    <div class="card">
        <div class="card-header">
            <h4 class="card-title mb-0">Berita Acak</h4>
        </div>
        <div class="card-body p-0">
            <?php $__currentLoopData = $randomNews; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $news): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="p-2">
                <?php if($news->gambar): ?>
                <div class="text-center mb-2">
                    <a href="<?php echo e(route('panel.berita.show', $news->id)); ?>">
                        <img src="<?php echo e(asset('storage/' . $news->gambar)); ?>" alt="<?php echo e($news->judul); ?>" class="img-fluid rounded" style="max-height: 150px; object-fit: cover;">
                    </a>
                </div>
                <?php endif; ?>
                <a href="<?php echo e(route('panel.berita.show', $news->id)); ?>" class="d-block text-decoration-none">
                    <h6 class="mb-1"><?php echo e(Str::limit(strip_tags($news->judul), 60)); ?></h6>
                    <small class="text-muted"><?php echo e($news->tanggal_publikasi->format('d M Y')); ?></small>
                </a>
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </div>
</div>
<?php else: ?>
<div class="alert alert-info">
    <h5><i class="icon fas fa-info"></i> Informasi!</h5>
    <p>Tidak ada berita dengan gambar tersedia.</p>
</div>
<?php endif; ?><?php /**PATH D:\htdocs\stelloCMS\app\Plugins\Berita\Views\widget\random-news.blade.php ENDPATH**/ ?>