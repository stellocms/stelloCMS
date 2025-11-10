<?php $__env->startSection('title', $berita->judul . ' - ' . cms_name()); ?>
<?php $__env->startSection('description', Str::limit(strip_tags($berita->isi), 160)); ?>

<?php $__env->startSection('content'); ?>
<style>
.navbar-light .navbar-nav .nav-link, .sticky-top.navbar-light .navbar-nav .nav-link {
        padding: 10px 0;
        margin-left: 0;
        color: var(--bs-dark);
    }
</style>
<br>
<div class="container mt-5">
    <div class="row">
        <div class="col-12">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?php echo e(in_array('home', array_keys(app('router')->getRoutes()->getRoutesByName())) ? route('home') : url('/')); ?>">Beranda</a></li>
                    <li class="breadcrumb-item"><a href="<?php echo e(in_array('berita.index', array_keys(app('router')->getRoutes()->getRoutesByName())) ? route('berita.index') : url('/berita')); ?>">Berita</a></li>
                    <li class="breadcrumb-item active"><?php echo e($berita->judul); ?></li>
                </ol>
            </nav>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <article>
                <h1><?php echo e($berita->judul); ?></h1>

                <div class="meta mb-3">
                    <small class="text-muted">
                        Dipublikasikan: <?php echo e($berita->tanggal_publikasi ? $berita->tanggal_publikasi->format('d M Y') : '-'); ?>

                        <?php if($berita->user): ?>
                            oleh <?php echo e($berita->user->name); ?>

                        <?php endif; ?>
                    </small>
                </div>

                <?php if($berita->gambar): ?>
                    <div class="mb-4">
                        <img src="<?php echo e(asset('storage/' . $berita->gambar)); ?>"
                             class="img-fluid"
                             alt="<?php echo e($berita->judul); ?>">
                    </div>
                <?php endif; ?>

                <div class="content">
                    <?php echo $berita->isi; ?>

                </div>
            </article>

            <div class="mt-4">
                <a href="<?php echo e(in_array('berita.index', array_keys(app('router')->getRoutes()->getRoutesByName())) ? route('berita.index') : url('/berita')); ?>" class="btn btn-secondary">
                    &laquo; Kembali ke Daftar Berita
                </a>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card">
                <div class="card-header">
                    <h5>Info Berita</h5>
                </div>
                <div class="card-body">
                    <p class="card-text">
                        Ini adalah halaman detail berita yang ditampilkan
                        di sisi frontend.
                    </p>

                    <h6>Status:</h6>
                    <span class="badge
                        <?php echo e($berita->aktif ? 'badge-success' : 'badge-warning'); ?>">
                        <?php echo e($berita->aktif ? 'Aktif' : 'Tidak Aktif'); ?>

                    </span>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('theme.frontend.' . config('themes.frontend') . '::layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\htdocs\stelloCMS\app\Plugins/Berita/Views/frontend/show.blade.php ENDPATH**/ ?>