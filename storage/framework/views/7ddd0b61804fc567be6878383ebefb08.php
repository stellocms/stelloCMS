<?php if($latestNews && $latestNews->count() > 0): ?>
<div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm p-6 border border-gray-200 dark:border-gray-700">
    <h4 class="text-lg font-semibold text-gray-900 dark:text-white mb-4 flex items-center">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z" />
        </svg>
        Berita Terbaru
    </h4>
    
    <div class="space-y-4">
        <?php $__currentLoopData = $latestNews; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $news): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <a href="<?php echo e(in_array('berita.show', array_keys(app('router')->getRoutes()->getRoutesByName())) ? route('berita.show', $news->slug) : url('/berita/' . $news->slug)); ?>" class="block group">
                <div class="flex items-start p-3 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors duration-200">
                    <?php if($news->gambar): ?>
                        <img src="<?php echo e(asset('storage/' . $news->gambar)); ?>" 
                             class="w-16 h-16 rounded-md object-cover mr-4 flex-shrink-0"
                             alt="<?php echo e($news->judul); ?>">
                    <?php else: ?>
                        <div class="bg-gray-200 border-2 border-dashed rounded-xl w-16 h-16 mr-4 flex-shrink-0" />
                    <?php endif; ?>
                    <div class="flex-1 min-w-0">
                        <h5 class="text-sm font-medium text-gray-900 dark:text-white group-hover:text-indigo-600 dark:group-hover:text-indigo-400 line-clamp-2">
                            <?php echo e(Str::limit(strip_tags($news->judul), 50)); ?>

                        </h5>
                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                            <?php echo e($news->tanggal_publikasi->format('d M Y')); ?>

                        </p>
                    </div>
                </div>
            </a>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>
</div>
<?php else: ?>
<div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm p-6 border border-gray-200 dark:border-gray-700">
    <div class="text-center py-4">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 mx-auto text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z" />
        </svg>
        <h5 class="mt-2 text-sm font-medium text-gray-900 dark:text-white">Tidak ada berita</h5>
        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
            Belum ada berita yang diterbitkan.
        </p>
    </div>
</div>
<?php endif; ?>

<style>
.line-clamp-2 {
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}
</style><?php /**PATH D:\htdocs\stelloCMS\app\Plugins\Berita\Views\widget\latest-news.blade.php ENDPATH**/ ?>