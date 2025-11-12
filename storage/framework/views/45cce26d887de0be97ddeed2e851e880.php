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
                                    <td colspan="3" class="position-header bg-gray-light">
                                        <div class="d-flex justify-content-between align-items-center mb-2">
                                            <h4 class="position-title mb-0">
                                                <i class="fas fa-header"></i> Header Widgets
                                            </h4>
                                            <span class="badge badge-primary"><?php echo e($headerWidgets->count()); ?> widgets</span>
                                        </div>
                                        <div id="header-widgets-container" class="position-widgets-container" data-position="header">
                                            <?php if($headerWidgets->count() > 0): ?>
                                                <?php $__currentLoopData = $headerWidgets; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $widget): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <div class="position-widget card mb-2" data-id="<?php echo e($widget->id); ?>">
                                                    <div class="card-body p-2">
                                                        <div class="d-flex justify-content-between">
                                                            <div class="flex-grow-1">
                                                                <h6 class="card-title mb-1"><?php echo e(Str::limit($widget->name, 30)); ?></h6>
                                                                <div class="small text-muted">
                                                                    <span class="badge badge-<?php echo e($widget->type === 'plugin' ? 'info' : ($widget->type === 'text' ? 'warning' : 'success')); ?>">
                                                                        <?php echo e(ucfirst($widget->type)); ?>

                                                                    </span>
                                                                    <span class="badge <?php echo e($widget->status === 'aktif' ? 'badge-success' : 'badge-danger'); ?>">
                                                                        <?php echo e($widget->status); ?>

                                                                    </span>
                                                                    <small>Order: <?php echo e($widget->order); ?></small>
                                                                </div>
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
                                                <div class="alert alert-secondary text-center mb-0">
                                                    Tidak ada widget di posisi Header
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                    </td>
                                </tr>
                                
                                <!-- Baris 2: Sidebar Left (kolom 1), Home (kolom 2), Sidebar Right (kolom 3) -->
                                <tr>
                                    <!-- Sidebar Left -->
                                    <td class="position-sidebar-left bg-gray-light">
                                        <div class="d-flex justify-content-between align-items-center mb-2">
                                            <h4 class="position-title mb-0">
                                                <i class="fas fa-align-left"></i> Sidebar Kiri
                                            </h4>
                                            <span class="badge badge-primary"><?php echo e($sidebarLeftWidgets->count()); ?> widgets</span>
                                        </div>
                                        <div id="sidebar-left-widgets-container" class="position-widgets-container" data-position="sidebar-left">
                                            <?php if($sidebarLeftWidgets->count() > 0): ?>
                                                <?php $__currentLoopData = $sidebarLeftWidgets; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $widget): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <div class="position-widget card mb-2" data-id="<?php echo e($widget->id); ?>">
                                                    <div class="card-body p-2">
                                                        <div class="d-flex justify-content-between">
                                                            <div class="flex-grow-1">
                                                                <h6 class="card-title mb-1"><?php echo e(Str::limit($widget->name, 25)); ?></h6>
                                                                <div class="small text-muted">
                                                                    <span class="badge badge-<?php echo e($widget->type === 'plugin' ? 'info' : ($widget->type === 'text' ? 'warning' : 'success')); ?>">
                                                                        <?php echo e(ucfirst($widget->type)); ?>

                                                                    </span>
                                                                    <span class="badge <?php echo e($widget->status === 'aktif' ? 'badge-success' : 'badge-danger'); ?>">
                                                                        <?php echo e($widget->status); ?>

                                                                    </span>
                                                                    <small>Order: <?php echo e($widget->order); ?></small>
                                                                </div>
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
                                                <div class="alert alert-secondary text-center mb-0">
                                                    Tidak ada widget di posisi Sidebar Kiri
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                    </td>
                                    
                                    <!-- Home -->
                                    <td class="position-home bg-gray-light">
                                        <div class="d-flex justify-content-between align-items-center mb-2">
                                            <h4 class="position-title mb-0">
                                                <i class="fas fa-home"></i> Home
                                            </h4>
                                            <span class="badge badge-primary"><?php echo e($homeWidgets->count()); ?> widgets</span>
                                        </div>
                                        <div id="home-widgets-container" class="position-widgets-container" data-position="home">
                                            <?php if($homeWidgets->count() > 0): ?>
                                                <?php $__currentLoopData = $homeWidgets; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $widget): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <div class="position-widget card mb-2" data-id="<?php echo e($widget->id); ?>">
                                                    <div class="card-body p-2">
                                                        <div class="d-flex justify-content-between">
                                                            <div class="flex-grow-1">
                                                                <h6 class="card-title mb-1"><?php echo e(Str::limit($widget->name, 25)); ?></h6>
                                                                <div class="small text-muted">
                                                                    <span class="badge badge-<?php echo e($widget->type === 'plugin' ? 'info' : ($widget->type === 'text' ? 'warning' : 'success')); ?>">
                                                                        <?php echo e(ucfirst($widget->type)); ?>

                                                                    </span>
                                                                    <span class="badge <?php echo e($widget->status === 'aktif' ? 'badge-success' : 'badge-danger'); ?>">
                                                                        <?php echo e($widget->status); ?>

                                                                    </span>
                                                                    <small>Order: <?php echo e($widget->order); ?></small>
                                                                </div>
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
                                                <div class="alert alert-secondary text-center mb-0">
                                                    Tidak ada widget di posisi Home
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                    </td>
                                    
                                    <!-- Sidebar Right -->
                                    <td class="position-sidebar-right bg-gray-light">
                                        <div class="d-flex justify-content-between align-items-center mb-2">
                                            <h4 class="position-title mb-0">
                                                <i class="fas fa-align-right"></i> Sidebar Kanan
                                            </h4>
                                            <span class="badge badge-primary"><?php echo e($sidebarRightWidgets->count()); ?> widgets</span>
                                        </div>
                                        <div id="sidebar-right-widgets-container" class="position-widgets-container" data-position="sidebar-right">
                                            <?php if($sidebarRightWidgets->count() > 0): ?>
                                                <?php $__currentLoopData = $sidebarRightWidgets; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $widget): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <div class="position-widget card mb-2" data-id="<?php echo e($widget->id); ?>">
                                                    <div class="card-body p-2">
                                                        <div class="d-flex justify-content-between">
                                                            <div class="flex-grow-1">
                                                                <h6 class="card-title mb-1"><?php echo e(Str::limit($widget->name, 25)); ?></h6>
                                                                <div class="small text-muted">
                                                                    <span class="badge badge-<?php echo e($widget->type === 'plugin' ? 'info' : ($widget->type === 'text' ? 'warning' : 'success')); ?>">
                                                                        <?php echo e(ucfirst($widget->type)); ?>

                                                                    </span>
                                                                    <span class="badge <?php echo e($widget->status === 'aktif' ? 'badge-success' : 'badge-danger'); ?>">
                                                                        <?php echo e($widget->status); ?>

                                                                    </span>
                                                                    <small>Order: <?php echo e($widget->order); ?></small>
                                                                </div>
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
                                                <div class="alert alert-secondary text-center mb-0">
                                                    Tidak ada widget di posisi Sidebar Kanan
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                    </td>
                                </tr>
                                
                                <!-- Baris 3: Footer (span 3 kolom) -->
                                <tr>
                                    <td colspan="3" class="position-footer bg-gray-light">
                                        <div class="d-flex justify-content-between align-items-center mb-2">
                                            <h4 class="position-title mb-0">
                                                <i class="fas fa-file-alt"></i> Footer Widgets
                                            </h4>
                                            <span class="badge badge-primary"><?php echo e($footerWidgets->count()); ?> widgets</span>
                                        </div>
                                        <div id="footer-widgets-container" class="position-widgets-container" data-position="footer">
                                            <?php if($footerWidgets->count() > 0): ?>
                                                <?php $__currentLoopData = $footerWidgets; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $widget): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <div class="position-widget card mb-2" data-id="<?php echo e($widget->id); ?>">
                                                    <div class="card-body p-2">
                                                        <div class="d-flex justify-content-between">
                                                            <div class="flex-grow-1">
                                                                <h6 class="card-title mb-1"><?php echo e(Str::limit($widget->name, 30)); ?></h6>
                                                                <div class="small text-muted">
                                                                    <span class="badge badge-<?php echo e($widget->type === 'plugin' ? 'info' : ($widget->type === 'text' ? 'warning' : 'success')); ?>">
                                                                        <?php echo e(ucfirst($widget->type)); ?>

                                                                    </span>
                                                                    <span class="badge <?php echo e($widget->status === 'aktif' ? 'badge-success' : 'badge-danger'); ?>">
                                                                        <?php echo e($widget->status); ?>

                                                                    </span>
                                                                    <small>Order: <?php echo e($widget->order); ?></small>
                                                                </div>
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
                                                <div class="alert alert-secondary text-center mb-0">
                                                    Tidak ada widget di posisi Footer
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

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://code.jquery.com/ui/1.13.2/jquery-ui.min.js"></script>
<link rel="stylesheet" href="https://code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">

<script>
$(document).ready(function() {
    // Enable sortable for all position containers - allow connections between containers
    $('[id$="-widgets-container"]').each(function() {
        const $container = $(this);
        const position = $container.data('position');
        
        $container.sortable({
            placeholder: 'ui-sortable-placeholder',
            cursor: 'move',
            opacity: 0.7,
            tolerance: 'pointer',
            connectWith: '[id$="-widgets-container"]', // Allow dragging between containers
            update: function(event, ui) {
                // Update order when widget is moved within same container or between containers
                const newPosition = $(this).data('position');
                updateWidgetPositionsAndOrders();
            },
            stop: function(event, ui) {
                // Update all positions and orders after movement
                updateWidgetPositionsAndOrders();
            }
        });
    });
    
    // Function to update all widget positions and orders via AJAX
    function updateWidgetPositionsAndOrders() {
        // Collect all widget data from all containers
        const allWidgetData = [];
        
        $('[id$="-widgets-container"]').each(function() {
            const containerPosition = $(this).data('position');
            $(this).find('[data-id]').each(function(index) {
                allWidgetData.push({
                    id: $(this).data('id'),
                    position: containerPosition,
                    order: index + 1
                });
            });
        });
        
        if (allWidgetData.length > 0) {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            
            $.ajax({
                url: '<?php echo e(route("panel.widgets.update-order")); ?>',
                method: 'POST',
                data: {
                    all_widgets: allWidgetData
                },
                success: function(response) {
                    console.log('All positions and orders updated successfully:', response);
                    
                    // Update order numbers in the UI for all positions
                    $('[id$="-widgets-container"]').each(function() {
                        const containerPosition = $(this).data('position');
                        $(this).find('[data-id]').each(function(index) {
                            $(this).find('small:last').text('Order: ' + (index + 1));
                        });
                    });
                },
                error: function(xhr, status, error) {
                    console.error('Error updating positions and orders:', error);
                    alert('Gagal memperbarui posisi dan urutan widget. Silakan coba lagi.');
                    
                    // Reload page to revert changes in case of error
                    location.reload();
                }
            });
        }
    }
    
    // Function to update widget position when moved between containers
    function updateWidgetPosition(widgetId, newPosition) {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        
        $.ajax({
            url: '<?php echo e(route("panel.widgets.update-position")); ?>',
            method: 'POST',
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
    
    // Add CSS for sortable placeholder
    $('<style>.ui-sortable-placeholder{background:#f39c12!important;border:1px dashed #ccc!important;visibility:visible!important;height:50px!important;width:100%!important;max-width:100%!important;margin-bottom:2px!important}.ui-sortable-helper{box-shadow: 0 2px 10px rgba(0,0,0,0.3)!important;}</style>').appendTo('head');
});
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('theme.admin.adminlte::layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\htdocs\stelloCMS\app\Themes/admin/adminlte/widgets/index.blade.php ENDPATH**/ ?>