<?php $__env->startSection('title', 'Manajemen Plugin - ' . cms_name()); ?>
<?php $__env->startSection('page_title', 'Manajemen Plugin'); ?>

<?php $__env->startSection('content'); ?>
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Manajemen Plugin</h3>

                    <div class="card-tools">
                        <button type="button" class="btn btn-sm btn-success" data-toggle="modal" data-target="#uploadPluginModal">
                            <i class="fas fa-upload"></i> Upload Plugin
                        </button>
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
                                <th>Nama</th>
                                <th>Deskripsi</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $plugins; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $plugin): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td>
                                    <strong>
                                        <?php if(!empty($plugin['metadata']['name'])): ?>
                                            <?php echo e($plugin['metadata']['name']); ?>

                                        <?php else: ?>
                                            <?php echo e($plugin['title'] ?? $plugin['name']); ?>

                                        <?php endif; ?>
                                    </strong>
                                    <?php if(!empty($plugin['metadata']['version'])): ?>
                                        <br><small class="text-muted">v<?php echo e($plugin['metadata']['version']); ?></small>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <?php if(!empty($plugin['metadata']['description'])): ?>
                                        <?php echo e($plugin['metadata']['description']); ?>

                                    <?php elseif(!empty($plugin['title'])): ?>
                                        <?php echo e($plugin['title']); ?>

                                    <?php else: ?>
                                        -
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <?php if($plugin['installed']): ?>
                                        <span class="badge <?php echo e($plugin['active'] ? 'badge-success' : 'badge-warning'); ?>">
                                            <?php echo e($plugin['active'] ? 'Aktif' : 'Nonaktif'); ?>

                                        </span>
                                    <?php else: ?>
                                        <span class="badge badge-secondary">Belum terinstal</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <?php if($plugin['installed']): ?>
                                        <?php if($plugin['active']): ?>
                                            <form action="<?php echo e(route('plugins.deactivate', $plugin['name'])); ?>" method="POST" class="d-inline">
                                                <?php echo csrf_field(); ?>
                                                <button type="submit" class="btn btn-sm btn-warning" 
                                                        onclick="return confirm('Yakin ingin menonaktifkan plugin ini?')">Nonaktifkan</button>
                                            </form>
                                        <?php else: ?>
                                            <form action="<?php echo e(route('plugins.activate', $plugin['name'])); ?>" method="POST" class="d-inline">
                                                <?php echo csrf_field(); ?>
                                                <button type="submit" class="btn btn-sm btn-success">Aktifkan</button>
                                            </form>
                                        <?php endif; ?>
                                        <form action="<?php echo e(route('plugins.uninstall', $plugin['name'])); ?>" method="POST" class="d-inline">
                                            <?php echo csrf_field(); ?>
                                            <?php echo method_field('DELETE'); ?>
                                            <button type="submit" class="btn btn-sm btn-danger" 
                                                    onclick="return confirm('Yakin ingin menghapus plugin ini?')">Hapus</button>
                                        </form>
                                    <?php else: ?>
                                        <form action="<?php echo e(route('plugins.install', $plugin['name'])); ?>" method="POST" class="d-inline">
                                            <?php echo csrf_field(); ?>
                                            <button type="submit" class="btn btn-sm btn-primary">Instal</button>
                                        </form>
                                    <?php endif; ?>
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

<!-- Upload Plugin Modal -->
<div class="modal fade" id="uploadPluginModal" tabindex="-1" role="dialog" aria-labelledby="uploadPluginModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="<?php echo e(route('plugins.upload')); ?>" method="POST" enctype="multipart/form-data">
                <?php echo csrf_field(); ?>
                <div class="modal-header">
                    <h5 class="modal-title" id="uploadPluginModalLabel">Upload Plugin Baru</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="plugin_file">Pilih File ZIP Plugin</label>
                        <div class="input-group">
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" id="plugin_file" name="plugin_file" accept=".zip" required>
                                <label class="custom-file-label" for="plugin_file">Pilih file...</label>
                            </div>
                        </div>
                        <small class="form-text text-muted">
                            File harus berupa ZIP yang berisi struktur plugin yang benar.<br>
                            Format: nama_plugin.zip/nama_plugin/{files}<br>
                            Contoh: berita.zip/Berita/{files}
                        </small>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-success">
                        <i class="fas fa-upload"></i> Upload Plugin
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Update file label saat memilih file -->
<script>
document.querySelector('#plugin_file').addEventListener('change', function(e) {
    var fileName = e.target.files[0].name;
    var nextSibling = e.target.nextElementSibling;
    nextSibling.innerText = fileName;
});
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('theme.admin.adminlte::layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\htdocs\stelloCMS\app\Themes/admin/adminlte/plugins/index.blade.php ENDPATH**/ ?>