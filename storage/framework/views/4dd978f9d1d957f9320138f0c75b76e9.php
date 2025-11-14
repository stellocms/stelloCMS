<?php $__env->startSection('title', 'Manajemen Widgets - ' . cms_name()); ?>
<?php $__env->startSection('page_title', 'Manajemen Widgets'); ?>

<?php $__env->startSection('content'); ?>
<meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">

<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Manajemen Widgets</h3>
                    <div class="card-tools">
                        <a href="<?php echo e(route('panel.widgets.create')); ?>" class="btn btn-primary">Tambah Widget</a>
                    </div>
                </div>
                <!-- /.card-header -->

                <!-- Grid 3x3 untuk widget berdasarkan posisi -->
                <div class="card-body">
                    <div class="grid-container">
                        <table class="table table-bordered">
                            <tbody>
                                <!-- Baris 1: Header (span 3 kolom) -->
                                <tr>
                                    <td colspan="3" class="position-header bg-gray-light p-4">
                                        <div class="d-flex justify-content-between align-items-center mb-2">
                                            <h4 class="position-title mb-0">
                                                <i class="fas fa-heading mr-2"></i> Header Widgets
                                            </h4>
                                            <span class="badge badge-primary"><?php echo e($headerWidgets->count()); ?> widgets</span>
                                        </div>
                                        <div class="position-widgets-container sortable-widget" data-position="header" id="header-widgets-container">
                                            <?php if($headerWidgets->count() > 0): ?>
                                                <?php $__currentLoopData = $headerWidgets; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $widget): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <div class="position-widget card mb-2" data-id="<?php echo e($widget->id); ?>" data-position="<?php echo e($widget->position); ?>">
                                                    <div class="card-body p-2">
                                                        <div class="d-flex justify-content-between">
                                                            <div class="flex-grow-1">
                                                                <h6 class="mb-1"><?php echo e(Str::limit($widget->name, 30)); ?></h6>
                                                                <div class="small text-muted">
                                                                    <span class="badge badge-<?php echo e($widget->type === 'plugin' ? 'info' : ($widget->type === 'text' ? 'warning' : 'success')); ?>">
                                                                        <?php echo e(ucfirst($widget->type)); ?>

                                                                    </span>
                                                                    <span class="badge <?php echo e($widget->status === 'aktif' ? 'badge-success' : 'badge-danger'); ?>">
                                                                        <?php echo e($widget->status); ?>

                                                                    </span>
                                                                    <small>Urutan: <?php echo e($widget->order); ?></small>
                                                                </div>
                                                                <p class="mb-1 mt-1 text-truncate"><?php echo e(Str::limit(strip_tags($widget->content ?? ''), 60, '...')); ?></p>
                                                            </div>
                                                            <div class="btn-group btn-group-sm ml-2">
                                                                <a href="<?php echo e(route('panel.widgets.show', $widget->id)); ?>" class="btn btn-info" title="Lihat">
                                                                    <i class="fas fa-eye"></i>
                                                                </a>
                                                                <a href="<?php echo e(route('panel.widgets.edit', $widget->id)); ?>" class="btn btn-primary" title="Edit">
                                                                    <i class="fas fa-edit"></i>
                                                                </a>
                                                                <form action="<?php echo e(route('panel.widgets.destroy', $widget->id)); ?>" method="POST" class="d-inline">
                                                                    <?php echo csrf_field(); ?>
                                                                    <?php echo method_field('DELETE'); ?>
                                                                    <button type="submit" class="btn btn-danger" title="Hapus" onclick="return confirm('Yakin ingin menghapus widget ini?')">
                                                                        <i class="fas fa-trash"></i>
                                                                    </button>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            <?php else: ?>
                                                <div class="alert alert-info text-center mb-0">
                                                    <i class="fas fa-info-circle mb-2"></i>
                                                    <p class="mb-0">Tidak ada widget di posisi Header</p>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                    </td>
                                </tr>
                                
                                <!-- Baris 2: Sidebar Left (kolom 1), Home (kolom 2), Sidebar Right (kolom 3) -->
                                <tr>
                                    <!-- Sidebar Left -->
                                    <td class="position-sidebar-left bg-gray-light p-4">
                                        <div class="d-flex justify-content-between align-items-center mb-2">
                                            <h4 class="position-title mb-0">
                                                <i class="fas fa-align-left mr-2"></i> Sidebar Kiri
                                            </h4>
                                            <span class="badge badge-primary"><?php echo e($sidebarLeftWidgets->count()); ?> widgets</span>
                                        </div>
                                        <div class="position-widgets-container sortable-widget" data-position="sidebar-left" id="left-widgets-container">
                                            <?php if($sidebarLeftWidgets->count() > 0): ?>
                                                <?php $__currentLoopData = $sidebarLeftWidgets; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $widget): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <div class="position-widget card mb-2" data-id="<?php echo e($widget->id); ?>" data-position="<?php echo e($widget->position); ?>">
                                                    <div class="card-body p-2">
                                                        <div class="d-flex justify-content-between">
                                                            <div class="flex-grow-1">
                                                                <h6 class="mb-1"><?php echo e(Str::limit($widget->name, 25)); ?></h6>
                                                                <div class="small text-muted">
                                                                    <span class="badge badge-<?php echo e($widget->type === 'plugin' ? 'info' : ($widget->type === 'text' ? 'warning' : 'success')); ?>">
                                                                        <?php echo e(ucfirst($widget->type)); ?>

                                                                    </span>
                                                                    <span class="badge <?php echo e($widget->status === 'aktif' ? 'badge-success' : 'badge-danger'); ?>">
                                                                        <?php echo e($widget->status); ?>

                                                                    </span>
                                                                    <small>Urutan: <?php echo e($widget->order); ?></small>
                                                                </div>
                                                                <p class="mb-1 mt-1 text-truncate"><?php echo e(Str::limit(strip_tags($widget->content ?? ''), 40, '...')); ?></p>
                                                            </div>
                                                            <div class="btn-group btn-group-sm ml-2">
                                                                <a href="<?php echo e(route('panel.widgets.show', $widget->id)); ?>" class="btn btn-info" title="Lihat">
                                                                    <i class="fas fa-eye"></i>
                                                                </a>
                                                                <a href="<?php echo e(route('panel.widgets.edit', $widget->id)); ?>" class="btn btn-primary" title="Edit">
                                                                    <i class="fas fa-edit"></i>
                                                                </a>
                                                                <form action="<?php echo e(route('panel.widgets.destroy', $widget->id)); ?>" method="POST" class="d-inline">
                                                                    <?php echo csrf_field(); ?>
                                                                    <?php echo method_field('DELETE'); ?>
                                                                    <button type="submit" class="btn btn-danger" title="Hapus" onclick="return confirm('Yakin ingin menghapus widget ini?')">
                                                                        <i class="fas fa-trash"></i>
                                                                    </button>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            <?php else: ?>
                                                <div class="alert alert-info text-center">
                                                    <i class="fas fa-info-circle mb-2"></i>
                                                    <p class="mb-0">Tidak ada widget di posisi Sidebar Kiri</p>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                    </td>
                                    
                                    <!-- Home -->
                                    <td class="position-home bg-gray-light p-4">
                                        <div class="d-flex justify-content-between align-items-center mb-2">
                                            <h4 class="position-title mb-0">
                                                <i class="fas fa-home mr-2"></i> Home Widgets
                                            </h4>
                                            <span class="badge badge-primary"><?php echo e($homeWidgets->count()); ?> widgets</span>
                                        </div>
                                        <div class="position-widgets-container sortable-widget" data-position="home" id="home-widgets-container">
                                            <?php if($homeWidgets->count() > 0): ?>
                                                <?php $__currentLoopData = $homeWidgets; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $widget): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <div class="position-widget card mb-2" data-id="<?php echo e($widget->id); ?>" data-position="<?php echo e($widget->position); ?>">
                                                    <div class="card-body p-2">
                                                        <div class="d-flex justify-content-between">
                                                            <div class="flex-grow-1">
                                                                <h6 class="mb-1"><?php echo e(Str::limit($widget->name, 25)); ?></h6>
                                                                <div class="small text-muted">
                                                                    <span class="badge badge-<?php echo e($widget->type === 'plugin' ? 'info' : ($widget->type === 'text' ? 'warning' : 'success')); ?>">
                                                                        <?php echo e(ucfirst($widget->type)); ?>

                                                                    </span>
                                                                    <span class="badge <?php echo e($widget->status === 'aktif' ? 'badge-success' : 'badge-danger'); ?>">
                                                                        <?php echo e($widget->status); ?>

                                                                    </span>
                                                                    <small>Urutan: <?php echo e($widget->order); ?></small>
                                                                </div>
                                                                <p class="mb-1 mt-1 text-truncate"><?php echo e(Str::limit(strip_tags($widget->content ?? ''), 40, '...')); ?></p>
                                                            </div>
                                                            <div class="btn-group btn-group-sm ml-2">
                                                                <a href="<?php echo e(route('panel.widgets.show', $widget->id)); ?>" class="btn btn-info" title="Lihat">
                                                                    <i class="fas fa-eye"></i>
                                                                </a>
                                                                <a href="<?php echo e(route('panel.widgets.edit', $widget->id)); ?>" class="btn btn-primary" title="Edit">
                                                                    <i class="fas fa-edit"></i>
                                                                </a>
                                                                <form action="<?php echo e(route('panel.widgets.destroy', $widget->id)); ?>" method="POST" class="d-inline">
                                                                    <?php echo csrf_field(); ?>
                                                                    <?php echo method_field('DELETE'); ?>
                                                                    <button type="submit" class="btn btn-danger" title="Hapus" onclick="return confirm('Yakin ingin menghapus widget ini?')">
                                                                        <i class="fas fa-trash"></i>
                                                                    </button>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            <?php else: ?>
                                                <div class="alert alert-info text-center">
                                                    <i class="fas fa-info-circle mb-2"></i>
                                                    <p class="mb-0">Tidak ada widget di posisi Home</p>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                    </td>
                                    
                                    <!-- Sidebar Right -->
                                    <td class="position-sidebar-right bg-gray-light p-4">
                                        <div class="d-flex justify-content-between align-items-center mb-2">
                                            <h4 class="position-title mb-0">
                                                <i class="fas fa-align-right mr-2"></i> Sidebar Kanan
                                            </h4>
                                            <span class="badge badge-primary"><?php echo e($sidebarRightWidgets->count()); ?> widgets</span>
                                        </div>
                                        <div class="position-widgets-container sortable-widget" data-position="sidebar-right" id="right-widgets-container">
                                            <?php if($sidebarRightWidgets->count() > 0): ?>
                                                <?php $__currentLoopData = $sidebarRightWidgets; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $widget): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <div class="position-widget card mb-2" data-id="<?php echo e($widget->id); ?>" data-position="<?php echo e($widget->position); ?>">
                                                    <div class="card-body p-2">
                                                        <div class="d-flex justify-content-between">
                                                            <div class="flex-grow-1">
                                                                <h6 class="mb-1"><?php echo e(Str::limit($widget->name, 25)); ?></h6>
                                                                <div class="small text-muted">
                                                                    <span class="badge badge-<?php echo e($widget->type === 'plugin' ? 'info' : ($widget->type === 'text' ? 'warning' : 'success')); ?>">
                                                                        <?php echo e(ucfirst($widget->type)); ?>

                                                                    </span>
                                                                    <span class="badge <?php echo e($widget->status === 'aktif' ? 'badge-success' : 'badge-danger'); ?>">
                                                                        <?php echo e($widget->status); ?>

                                                                    </span>
                                                                    <small>Urutan: <?php echo e($widget->order); ?></small>
                                                                </div>
                                                                <p class="mb-1 mt-1 text-truncate"><?php echo e(Str::limit(strip_tags($widget->content ?? ''), 40, '...')); ?></p>
                                                            </div>
                                                            <div class="btn-group btn-group-sm ml-2">
                                                                <a href="<?php echo e(route('panel.widgets.show', $widget->id)); ?>" class="btn btn-info" title="Lihat">
                                                                    <i class="fas fa-eye"></i>
                                                                </a>
                                                                <a href="<?php echo e(route('panel.widgets.edit', $widget->id)); ?>" class="btn btn-primary" title="Edit">
                                                                    <i class="fas fa-edit"></i>
                                                                </a>
                                                                <form action="<?php echo e(route('panel.widgets.destroy', $widget->id)); ?>" method="POST" class="d-inline">
                                                                    <?php echo csrf_field(); ?>
                                                                    <?php echo method_field('DELETE'); ?>
                                                                    <button type="submit" class="btn btn-danger" title="Hapus" onclick="return confirm('Yakin ingin menghapus widget ini?')">
                                                                        <i class="fas fa-trash"></i>
                                                                    </button>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            <?php else: ?>
                                                <div class="alert alert-info text-center">
                                                    <i class="fas fa-info-circle mb-2"></i>
                                                    <p class="mb-0">Tidak ada widget di posisi Sidebar Kanan</p>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                    </td>
                                </tr>
                                
                                <!-- Baris 3: Footer (span 3 kolom) -->
                                <tr>
                                    <td colspan="3" class="position-footer bg-gray-light p-4">
                                        <div class="d-flex justify-content-between align-items-center mb-2">
                                            <h4 class="position-title mb-0">
                                                <i class="fas fa-file-alt mr-2"></i> Footer Widgets
                                            </h4>
                                            <span class="badge badge-primary"><?php echo e($footerWidgets->count()); ?> widgets</span>
                                        </div>
                                        <div class="position-widgets-container sortable-widget" data-position="footer" id="footer-widgets-container">
                                            <?php if($footerWidgets->count() > 0): ?>
                                                <?php $__currentLoopData = $footerWidgets; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $widget): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <div class="position-widget card mb-2" data-id="<?php echo e($widget->id); ?>" data-position="<?php echo e($widget->position); ?>">
                                                    <div class="card-body p-2">
                                                        <div class="d-flex justify-content-between">
                                                            <div class="flex-grow-1">
                                                                <h6 class="mb-1"><?php echo e(Str::limit($widget->name, 30)); ?></h6>
                                                                <div class="small text-muted">
                                                                    <span class="badge badge-<?php echo e($widget->type === 'plugin' ? 'info' : ($widget->type === 'text' ? 'warning' : 'success')); ?>">
                                                                        <?php echo e(ucfirst($widget->type)); ?>

                                                                    </span>
                                                                    <span class="badge <?php echo e($widget->status === 'aktif' ? 'badge-success' : 'badge-danger'); ?>">
                                                                        <?php echo e($widget->status); ?>

                                                                    </span>
                                                                    <small>Urutan: <?php echo e($widget->order); ?></small>
                                                                </div>
                                                                <p class="mb-1 mt-1 text-truncate"><?php echo e(Str::limit(strip_tags($widget->content ?? ''), 60, '...')); ?></p>
                                                            </div>
                                                            <div class="btn-group btn-group-sm ml-2">
                                                                <a href="<?php echo e(route('panel.widgets.show', $widget->id)); ?>" class="btn btn-info" title="Lihat">
                                                                    <i class="fas fa-eye"></i>
                                                                </a>
                                                                <a href="<?php echo e(route('panel.widgets.edit', $widget->id)); ?>" class="btn btn-primary" title="Edit">
                                                                    <i class="fas fa-edit"></i>
                                                                </a>
                                                                <form action="<?php echo e(route('panel.widgets.destroy', $widget->id)); ?>" method="POST" class="d-inline">
                                                                    <?php echo csrf_field(); ?>
                                                                    <?php echo method_field('DELETE'); ?>
                                                                    <button type="submit" class="btn btn-danger" title="Hapus" onclick="return confirm('Yakin ingin menghapus widget ini?')">
                                                                        <i class="fas fa-trash"></i>
                                                                    </button>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            <?php else: ?>
                                                <div class="alert alert-info text-center mb-0">
                                                    <i class="fas fa-info-circle mb-2"></i>
                                                    <p class="mb-0">Tidak ada widget di posisi Footer</p>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->
        </div>
    </div>
</div>

<style>
    .ui-sortable-placeholder {
        height: 50px;
        background: #f39c12 !important;
        border: 1px dashed #ccc !important;
        visibility: visible !important;
        margin-bottom: 10px;
        border-radius: 5px;
    }
    
    .position-widget {
        cursor: move;
    }
    
    .grid-container {
        width: 100%;
    }
    
    .grid-container table {
        border-collapse: separate;
        border-spacing: 10px;
    }
    
    .grid-container td {
        vertical-align: top;
        border: 1px solid #dee2e6;
        border-radius: 5px;
    }
    
    /* Gaya untuk tombol-tombol aksi dalam widget agar ukurannya konsisten */
    .position-widget .btn-icon {
        min-width: 36px;
        min-height: 36px;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 0.25rem 0.5rem !important;
    }
    
    .position-widget .btn-group-sm .btn-icon {
        min-width: 32px;
        min-height: 32px;
        padding: 0.125rem 0.25rem !important;
    }
</style>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
<script>
$(document).ready(function() {
    // Initialize sortable for all widget containers with cross-position dragging enabled
    $('.sortable-widget').each(function() {
        const $container = $(this);
        const position = $container.data('position');
        
        $container.sortable({
            placeholder: 'ui-sortable-placeholder',
            cursor: 'move',
            opacity: 0.7,
            connectWith: '.sortable-widget', // Enable dragging between different positions
            handle: '.card-body', // Use card body as handle to allow clicking links/buttons
            update: function(event, ui) {
                updateWidgetOrder(position);
            },
            stop: function(event, ui) {
                // Get the new position after move
                const newPosition = $(ui.item).closest('.sortable-widget').data('position');
                
                // If widget was moved to a different position, update its position in the database
                if (position !== newPosition) {
                    const widgetId = ui.item.attr('data-id');
                    updateWidgetPosition(widgetId, newPosition);
                }
                
                // Update the order in the new position
                updateWidgetOrder(newPosition);
            }
        });
    });
    
    // Function to update widget order via AJAX
    function updateWidgetOrder(position) {
        const widgetIds = [];
        $(`[data-position="${position}"]`).find('[data-id]').each(function(index) {
            const widgetId = parseInt($(this).attr('data-id'));
            widgetIds.push({
                id: widgetId,
                order: index + 1
            });
        });
        
        if (widgetIds.length > 0) {
            $.ajax({
                url: '<?php echo e(route("panel.widgets.update-order")); ?>',
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {
                    position: position,
                    widget_ids: widgetIds
                },
                success: function(response) {
                    console.log('Order updated successfully for ' + position + ':', response);
                    
                    // Update order numbers in the UI for this position
                    $(`[data-position="${position}"]`).find('[data-id]').each(function(index) {
                        const $smallElements = $(this).find('small');
                        const $smallElement = $smallElements.last(); // Get the last small element for order
                        $smallElement.text('Urutan: ' + (index + 1));
                    });
                },
                error: function(xhr, status, error) {
                    console.error('Error updating order for ' + position + ':', error);
                    alert('Gagal memperbarui urutan widget. Silakan coba lagi.');
                    location.reload(); // Reload page to revert changes in case of error
                }
            });
        }
    }
    
    // Function to update widget position when moved between containers
    function updateWidgetPosition(widgetId, newPosition) {
        $.ajax({
            url: '<?php echo e(route("panel.widgets.update-position")); ?>',
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: {
                id: widgetId,
                position: newPosition
            },
            success: function(response) {
                console.log('Position updated successfully for widget ' + widgetId + ' to ' + newPosition + ':', response);
                
                // Update the position attribute in the DOM
                $(`[data-id="${widgetId}"]`).attr('data-position', newPosition);
            },
            error: function(xhr, status, error) {
                console.error('Error updating position for widget ' + widgetId + ':', error);
                alert('Gagal memperbarui posisi widget. Silakan coba lagi.');
                
                // Reload page to revert changes in case of error
                location.reload();
            }
        });
    }
});
</script>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('theme.admin.adminlte::layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\htdocs\stelloCMS\app\Themes\admin\adminlte\widgets\index.blade.php ENDPATH**/ ?>