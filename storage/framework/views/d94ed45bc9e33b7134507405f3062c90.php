<?php $__env->startSection('title', 'Manajemen Menu - ' . cms_name()); ?>
<?php $__env->startSection('page_title', 'Manajemen Menu'); ?>

<?php $__env->startSection('content'); ?>
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <!-- Tabs untuk menu -->
            <div class="card card-primary card-outline card-tabs">
                <div class="card-header p-0 pt-1 border-bottom-0">
                    <ul class="nav nav-tabs" id="custom-tabs-two-tab" role="tablist">
                        <li class="pt-2 px-3"><h3 class="card-title">Manajemen Menu</h3></li>
                        <li class="nav-item">
                            <a class="nav-link active" id="admin-menu-tab" data-toggle="pill" href="#admin-menu" role="tab" aria-controls="admin-menu" aria-selected="true">Menu Admin</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="frontend-menu-tab" data-toggle="pill" href="#frontend-menu" role="tab" aria-controls="frontend-menu" aria-selected="false">Menu Frontend</a>
                        </li>
                        <li class="ml-auto pr-3">
                            <a href="<?php echo e(route('menus.create')); ?>" class="btn btn-sm btn-primary">
                                Tambah Menu
                            </a>
                        </li>
                    </ul>
                </div>
                <div class="card-body">
                    <div class="tab-content" id="custom-tabs-two-tabContent">
                        <!-- Tab Menu Admin -->
                        <div class="tab-pane fade active show" id="admin-menu" role="tabpanel" aria-labelledby="admin-menu-tab">
                            <?php if(session('success') && session('menu_type') == 'admin'): ?>
                                <div class="alert alert-success alert-dismissible">
                                    <?php echo e(session('success')); ?>

                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                </div>
                            <?php endif; ?>

                            <?php if(session('error') && session('menu_type') == 'admin'): ?>
                                <div class="alert alert-danger alert-dismissible">
                                    <?php echo e(session('error')); ?>

                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                </div>
                            <?php endif; ?>

                            <div class="table-responsive">
                                <table class="table table-hover text-nowrap" id="admin-menu-table">
                                    <thead>
                                        <tr>
                                            <th>Urut</th>
                                            <th>ID</th>
                                            <th>Nama</th>
                                            <th>Judul</th>
                                            <th>Rute/URL</th>
                                            <th>Induk</th>
                                            <th>Posisi</th>
                                            <th>Status</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $__empty_1 = true; $__currentLoopData = $adminMenus ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $menu): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                        <tr data-id="<?php echo e($menu->id); ?>">
                                            <td><i class="fas fa-sort"></i></td>
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
                                            <td><?php echo e(ucfirst(str_replace('-', ' ', $menu->position))); ?></td>
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
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                        <tr>
                                            <td colspan="9" class="text-center">Belum ada menu admin.</td>
                                        </tr>
                                        <?php endif; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        
                        <!-- Tab Menu Frontend -->
                        <div class="tab-pane fade" id="frontend-menu" role="tabpanel" aria-labelledby="frontend-menu-tab">
                            <?php if(session('success') && session('menu_type') == 'frontend'): ?>
                                <div class="alert alert-success alert-dismissible">
                                    <?php echo e(session('success')); ?>

                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                </div>
                            <?php endif; ?>

                            <?php if(session('error') && session('menu_type') == 'frontend'): ?>
                                <div class="alert alert-danger alert-dismissible">
                                    <?php echo e(session('error')); ?>

                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                </div>
                            <?php endif; ?>

                            <div class="table-responsive">
                                <table class="table table-hover text-nowrap" id="frontend-menu-table">
                                    <thead>
                                        <tr>
                                            <th>Urut</th>
                                            <th>ID</th>
                                            <th>Nama</th>
                                            <th>Judul</th>
                                            <th>Rute/URL</th>
                                            <th>Induk</th>
                                            <th>Posisi</th>
                                            <th>Status</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $__empty_1 = true; $__currentLoopData = $frontendMenus ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $menu): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                        <tr data-id="<?php echo e($menu->id); ?>">
                                            <td><i class="fas fa-sort"></i></td>
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
                                            <td><?php echo e(ucfirst(str_replace('-', ' ', $menu->position))); ?></td>
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
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                        <tr>
                                            <td colspan="9" class="text-center">Belum ada menu frontend.</td>
                                        </tr>
                                        <?php endif; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script>
$(document).ready(function() {
    // Enable drag and drop for admin menu
    $("#admin-menu-table tbody").sortable({
        items: "tr",
        cursor: "move",
        opacity: 0.6,
        helper: function(e, ui) {
            ui.children().each(function() {
                $(this).width($(this).width());
            });
            return ui;
        },
        update: function(event, ui) {
            var ids = $(this).sortable('serialize', {
                attribute: 'data-id',
                expression: /(.+)-(.+)/
            });
            
            var menuIds = $(this).sortable('toArray', {
                attribute: 'data-id'
            });
            
            updateMenuOrder(menuIds, 'admin');
        }
    }).disableSelection();

    // Enable drag and drop for frontend menu
    $("#frontend-menu-table tbody").sortable({
        items: "tr",
        cursor: "move",
        opacity: 0.6,
        helper: function(e, ui) {
            ui.children().each(function() {
                $(this).width($(this).width());
            });
            return ui;
        },
        update: function(event, ui) {
            var ids = $(this).sortable('serialize', {
                attribute: 'data-id',
                expression: /(.+)-(.+)/
            });
            
            var menuIds = $(this).sortable('toArray', {
                attribute: 'data-id'
            });
            
            updateMenuOrder(menuIds, 'frontend');
        }
    }).disableSelection();
});

function updateMenuOrder(menuIds, type) {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    
    $.ajax({
        url: '<?php echo e(route('menus.update-order')); ?>',
        type: 'POST',
        data: {
            menu_ids: menuIds,
            type: type,
            _token: '<?php echo e(csrf_token()); ?>' // Menambahkan token CSRF secara eksplisit
        },
        success: function(response) {
            if(response.success) {
                // Tampilkan notifikasi sukses
                alert(response.message);
            }
        },
        error: function(xhr, status, error) {
            console.log('Error: ' + error);
            console.log('Response: ', xhr.responseJSON);
            // Tampilkan notifikasi error
            alert('Gagal memperbarui urutan menu: ' + error);
        }
    });
}
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('theme.admin.adminlte::layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\htdocs\stelloCMS\app\Themes/admin/adminlte/menus/index.blade.php ENDPATH**/ ?>