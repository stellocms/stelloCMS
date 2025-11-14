<?php if($popularNews && $popularNews->count() > 0): ?>
<div class="widget widget-popular-news">
    <div class="card">
        <div class="card-header">
            <h4 class="card-title mb-0">Berita Populer</h4>
        </div>
        <div class="card-body p-0">
            <div class="list-unstyled mb-0">
                <?php $__currentLoopData = $popularNews; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $news): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="border-bottom p-2 <?php echo e($index == 0 ? 'bg-light' : ''); ?>">
                        <a href="<?php echo e(route('panel.berita.show', $news->id)); ?>" class="d-block text-decoration-none">
                            <small class="text-muted float-right">
                                <i class="fas fa-eye mr-1"></i> <?php echo e(number_format($news->viewer)); ?>

                            </small>
                            <strong><?php echo e(Str::limit(strip_tags($news->judul), 60)); ?></strong>
                        </a>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        </div>
    </div>
</div>
<?php else: ?>
<div class="alert alert-info">
    <h5><i class="icon fas fa-info"></i> Informasi!</h5>
    <p>Belum ada berita populer.</p>
</div>
<?php endif; ?><?php /**PATH D:\htdocs\stelloCMS\app\Plugins\Berita\Views\widget\popular-news.blade.php ENDPATH**/ ?>