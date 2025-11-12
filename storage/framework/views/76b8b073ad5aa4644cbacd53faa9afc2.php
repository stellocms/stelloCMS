<?php $__env->startSection('page_title', 'Manajemen Tema'); ?>

<?php $__env->startSection('content'); ?>
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Manajemen Tema</h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-sm btn-success" data-toggle="modal" data-target="#uploadThemeModal">
                            <i class="fas fa-upload"></i> Upload Tema
                        </button>
                        <a href="<?php echo e(route('themes.scan.get')); ?>" class="btn btn-sm btn-primary">
                            <i class="fas fa-sync"></i> Scan Tema
                        </a>
                    </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <h4>Tema Frontend</h4>
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Nama</th>
                                <th>Versi</th>
                                <th>Deskripsi</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__empty_1 = true; $__currentLoopData = $frontendThemes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $theme): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr>
                                <td><?php echo e($theme->name); ?></td>
                                <td><?php echo e($theme->version ?? 'N/A'); ?></td>
                                <td><?php echo e($theme->description ?? 'No description'); ?></td>
                                <td>
                                    <?php if($theme->is_default): ?>
                                        <span class="badge badge-primary">Default</span>
                                    <?php elseif($theme->is_active): ?>
                                        <span class="badge badge-success">Active</span>
                                    <?php else: ?>
                                        <span class="badge badge-secondary">Inactive</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <?php if($theme->is_installed): ?>
                                        <?php if(!$theme->is_default): ?>
                                            <form method="POST" action="<?php echo e(route('themes.set_default', ['type' => 'frontend', 'name' => $theme->name])); ?>" style="display: inline;">
                                                <?php echo csrf_field(); ?>
                                                <button type="submit" class="btn btn-sm btn-outline-primary" onclick="return confirm('Yakin ingin menjadikan tema ini sebagai default?')">Jadikan Default</button>
                                            </form>
                                        <?php endif; ?>
                                        <?php if($theme->is_active): ?>
                                            <form method="POST" action="<?php echo e(route('themes.deactivate', ['type' => 'frontend', 'name' => $theme->name])); ?>" style="display: inline;">
                                                <?php echo csrf_field(); ?>
                                                <button type="submit" class="btn btn-sm btn-outline-warning" onclick="return confirm('Yakin ingin menonaktifkan tema ini?')">Nonaktifkan</button>
                                            </form>
                                        <?php else: ?>
                                            <form method="POST" action="<?php echo e(route('themes.activate', ['type' => 'frontend', 'name' => $theme->name])); ?>" style="display: inline;">
                                                <?php echo csrf_field(); ?>
                                                <button type="submit" class="btn btn-sm btn-outline-success" onclick="return confirm('Yakin ingin mengaktifkan tema ini?')">Aktifkan</button>
                                            </form>
                                        <?php endif; ?>
                                        <form method="POST" action="<?php echo e(route('themes.uninstall', ['type' => 'frontend', 'name' => $theme->name])); ?>" style="display: inline;">
                                            <?php echo csrf_field(); ?>
                                            <?php echo method_field('DELETE'); ?>
                                            <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Yakin ingin menghapus tema ini?')">Uninstall</button>
                                        </form>
                                    <?php else: ?>
                                        <form method="POST" action="<?php echo e(route('themes.install', ['type' => 'frontend', 'name' => $theme->name])); ?>" style="display: inline;">
                                            <?php echo csrf_field(); ?>
                                            <button type="submit" class="btn btn-sm btn-outline-info" onclick="return confirm('Yakin ingin menginstal tema ini?')">Install</button>
                                        </form>
                                    <?php endif; ?>
                                </td>
                            </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr>
                                <td colspan="5" class="text-center">Tidak ada tema frontend ditemukan</td>
                            </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>

                    <h4 class="mt-4">Tema Admin</h4>
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Nama</th>
                                <th>Versi</th>
                                <th>Deskripsi</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__empty_1 = true; $__currentLoopData = $adminThemes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $theme): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr>
                                <td><?php echo e($theme->name); ?></td>
                                <td><?php echo e($theme->version ?? 'N/A'); ?></td>
                                <td><?php echo e($theme->description ?? 'No description'); ?></td>
                                <td>
                                    <?php if($theme->is_default): ?>
                                        <span class="badge badge-primary">Default</span>
                                    <?php elseif($theme->is_active): ?>
                                        <span class="badge badge-success">Active</span>
                                    <?php else: ?>
                                        <span class="badge badge-secondary">Inactive</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <?php if($theme->is_installed): ?>
                                        <?php if(!$theme->is_default): ?>
                                            <form method="POST" action="<?php echo e(route('themes.set_default', ['type' => 'admin', 'name' => $theme->name])); ?>" style="display: inline;">
                                                <?php echo csrf_field(); ?>
                                                <button type="submit" class="btn btn-sm btn-outline-primary" onclick="return confirm('Yakin ingin menjadikan tema ini sebagai default?')">Jadikan Default</button>
                                            </form>
                                        <?php endif; ?>
                                        <?php if($theme->is_active): ?>
                                            <form method="POST" action="<?php echo e(route('themes.deactivate', ['type' => 'admin', 'name' => $theme->name])); ?>" style="display: inline;">
                                                <?php echo csrf_field(); ?>
                                                <button type="submit" class="btn btn-sm btn-outline-warning" onclick="return confirm('Yakin ingin menonaktifkan tema ini?')">Nonaktifkan</button>
                                            </form>
                                        <?php else: ?>
                                            <form method="POST" action="<?php echo e(route('themes.activate', ['type' => 'admin', 'name' => $theme->name])); ?>" style="display: inline;">
                                                <?php echo csrf_field(); ?>
                                                <button type="submit" class="btn btn-sm btn-outline-success" onclick="return confirm('Yakin ingin mengaktifkan tema ini?')">Aktifkan</button>
                                            </form>
                                        <?php endif; ?>
                                        <form method="POST" action="<?php echo e(route('themes.uninstall', ['type' => 'admin', 'name' => $theme->name])); ?>" style="display: inline;">
                                            <?php echo csrf_field(); ?>
                                            <?php echo method_field('DELETE'); ?>
                                            <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Yakin ingin menghapus tema ini?')">Uninstall</button>
                                        </form>
                                    <?php else: ?>
                                        <form method="POST" action="<?php echo e(route('themes.install', ['type' => 'admin', 'name' => $theme->name])); ?>" style="display: inline;">
                                            <?php echo csrf_field(); ?>
                                            <button type="submit" class="btn btn-sm btn-outline-info" onclick="return confirm('Yakin ingin menginstal tema ini?')">Install</button>
                                        </form>
                                    <?php endif; ?>
                                </td>
                            </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr>
                                <td colspan="5" class="text-center">Tidak ada tema admin ditemukan</td>
                            </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->
        </div>
    </div>
</div>

<!-- Upload Theme Modal -->
<div class="modal fade" id="uploadThemeModal" tabindex="-1" role="dialog" aria-labelledby="uploadThemeModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="<?php echo e(route('themes.upload')); ?>" method="POST" enctype="multipart/form-data">
                <?php echo csrf_field(); ?>
                <div class="modal-header">
                    <h5 class="modal-title" id="uploadThemeModalLabel">Upload Tema Baru</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="theme_file">Pilih File ZIP Tema</label>
                        <div class="input-group">
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" id="theme_file" name="theme_file" accept=".zip" required>
                                <label class="custom-file-label" for="theme_file">Pilih file...</label>
                            </div>
                        </div>
                        <small class="form-text text-muted">
                            File harus berupa ZIP yang berisi struktur tema yang benar.<br>
                            Format: nama_tema.zip/nama_tema/{files}<br>
                            Contoh: therapy.zip/therapy/{files}
                        </small>
                    </div>
                    <div class="form-group">
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" id="extract_public" name="extract_public" checked>
                            <label class="form-check-label" for="extract_public">Ekstrak file public juga (CSS, JS, gambar)</label>
                        </div>
                        <small class="form-text text-muted">
                            Centang ini jika tema Anda memiliki file aset (CSS, JS, gambar) yang perlu diekstrak ke public/themes/
                        </small>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-success">
                        <i class="fas fa-upload"></i> Upload Tema
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Update file label saat memilih file -->
<script>
document.querySelector('.custom-file-input').addEventListener('change', function(e) {
    var fileName = e.target.files[0].name;
    var nextSibling = e.target.nextElementSibling;
    nextSibling.innerText = fileName;
});
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('theme.admin.adminlte::layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\htdocs\stelloCMS\app\Themes/admin/adminlte/themes/index.blade.php ENDPATH**/ ?>