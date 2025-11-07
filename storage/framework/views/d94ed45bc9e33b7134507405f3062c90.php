<?php $__env->startSection('title', 'Manajemen Menu - ' . cms_name()); ?>
<?php $__env->startSection('page_title', 'Manajemen Menu'); ?>

<?php $__env->startSection('content'); ?>
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Daftar Menu</h3>
                    
                    <div class="card-tools">
                        <a href="<?php echo e(route('menus.create')); ?>" class="btn btn-sm btn-primary">
                            Tambah Menu
                        </a>
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

                    <?php if(session('error')): ?>
                        <div class="alert alert-danger alert-dismissible">
                            <?php echo e(session('error')); ?>

                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                        </div>
                    <?php endif; ?>
                    
                    <table class="table table-hover text-nowrap">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nama</th>
                                <th>Judul</th>
                                <th>Rute/URL</th>
                                <th>Induk</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $menus; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $menu): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td><?php echo e($menu->id); ?></td>
                                <td><?php echo e($menu->name); ?></td>
                                <td><?php echo e($menu->title); ?></td>
                                <td>
                                    <?php if($menu->route): ?>
                                        <span class="badge badge-info">Route: <?php echo e($menu->route); ?></span>
                                    <?php endif; ?>
                                    <?php if($menu->url): ?>
                                        <span class="badge badge-warning">URL: <?php echo e($menu->url); ?></span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <?php echo e($menu->parent ? $menu->parent->title : '-'); ?>

                                </td>
                                <td>
                                    <?php if($menu->is_active): ?>
                                        <span class="badge badge-success">Aktif</span>
                                    <?php else: ?>
                                        <span class="badge badge-secondary">Tidak Aktif</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <a href="<?php echo e(route('menus.edit', $menu->id)); ?>" class="btn btn-sm btn-primary">Edit</a>
                                    <form action="<?php echo e(route('menus.destroy', $menu->id)); ?>" method="POST" class="d-inline">
                                        <?php echo csrf_field(); ?>
                                        <?php echo method_field('DELETE'); ?>
                                        <button type="submit" class="btn btn-sm btn-danger" 
                                                onclick="return confirm('Yakin ingin menghapus menu ini?')">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('theme.admin.adminlte::layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\htdocs\stelloCMS\app\Themes/admin/adminlte/menus/index.blade.php ENDPATH**/ ?>