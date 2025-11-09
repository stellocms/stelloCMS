<?php $__env->startSection('title', $contohPlugin->judul . ' - Contoh Plugin - ' . cms_name()); ?>
<?php $__env->startSection('description', Str::limit(strip_tags($contohPlugin->deskripsi), 160)); ?>

<?php $__env->startSection('content'); ?>
<div class="container mt-5">
    <div class="row">
        <div class="col-12">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/">Beranda</a></li>
                    <li class="breadcrumb-item"><a href="<?php echo e(route('contohplugin.frontpage.index')); ?>">Contoh Plugin</a></li>
                    <li class="breadcrumb-item active"><?php echo e($contohPlugin->judul); ?></li>
                </ol>
            </nav>
        </div>
    </div>
    
    <div class="row">
        <div class="col-lg-8">
            <article>
                <h1><?php echo e($contohPlugin->judul); ?></h1>
                
                <div class="meta mb-3">
                    <small class="text-muted">
                        Dipublikasikan: <?php echo e($contohPlugin->tanggal_dibuat ? $contohPlugin->tanggal_dibuat->format('d M Y') : '-'); ?>

                    </small>
                </div>
                
                <?php if($contohPlugin->gambar): ?>
                    <div class="mb-4">
                        <img src="<?php echo e(asset('storage/' . $contohPlugin->gambar)); ?>" 
                             class="img-fluid" 
                             alt="<?php echo e($contohPlugin->judul); ?>">
                    </div>
                <?php endif; ?>
                
                <div class="content">
                    <?php echo $contohPlugin->deskripsi; ?>

                </div>
            </article>
            
            <div class="mt-4">
                <a href="<?php echo e(route('contohplugin.frontpage.index')); ?>" class="btn btn-secondary">
                    &laquo; Kembali ke Daftar
                </a>
            </div>
        </div>
        
        <div class="col-lg-4">
            <div class="card">
                <div class="card-header">
                    <h5>Info Plugin</h5>
                </div>
                <div class="card-body">
                    <p class="card-text">
                        Ini adalah halaman detail dari Contoh Plugin yang ditampilkan 
                        di sisi frontend.
                    </p>
                    
                    <h6>Status:</h6>
                    <span class="badge 
                        <?php echo e($contohPlugin->aktif ? 'badge-success' : 'badge-warning'); ?>">
                        <?php echo e($contohPlugin->aktif ? 'Aktif' : 'Tidak Aktif'); ?>

                    </span>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('theme.frontend.' . config('themes.frontend') . '::layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\htdocs\stelloCMS\app\Plugins/ContohPlugin/Views/frontpage/show.blade.php ENDPATH**/ ?>