<?php $__env->startSection('title', 'Edit Peran - Manajemen Peran - ' . cms_name()); ?>
<?php $__env->startSection('page_title', 'Edit Peran'); ?>

<?php $__env->startSection('content'); ?>
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Edit Peran: <?php echo e($role->name); ?></h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <form action="<?php echo e(route('roles.update', $role->id)); ?>" method="POST">
                        <?php echo csrf_field(); ?>
                        <?php echo method_field('PUT'); ?>
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="name">Nama Peran *</label>
                                    <input type="text" class="form-control <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                           id="name" name="name" value="<?php echo e(old('name', $role->name)); ?>" required>
                                    <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <div class="invalid-feedback"><?php echo e($message); ?></div>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                    <small class="form-text text-muted">Gunakan huruf, angka, dan garis bawah saja</small>
                                </div>
                                
                                <div class="form-group">
                                    <label for="description">Deskripsi</label>
                                    <textarea class="form-control <?php $__errorArgs = ['description'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                              id="description" name="description" rows="3"><?php echo e(old('description', $role->description)); ?></textarea>
                                    <?php $__errorArgs = ['description'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <div class="invalid-feedback"><?php echo e($message); ?></div>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="permissions">Izin Akses</label>
                                    <select multiple class="form-control <?php $__errorArgs = ['permissions'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                            id="permissions" name="permissions[]">
                                        <option value="read" <?php echo e(in_array('read', old('permissions', $role->permissions ?? [])) ? 'selected' : ''); ?>>Baca</option>
                                        <option value="create" <?php echo e(in_array('create', old('permissions', $role->permissions ?? [])) ? 'selected' : ''); ?>>Buat</option>
                                        <option value="update" <?php echo e(in_array('update', old('permissions', $role->permissions ?? [])) ? 'selected' : ''); ?>>Ubah</option>
                                        <option value="delete" <?php echo e(in_array('delete', old('permissions', $role->permissions ?? [])) ? 'selected' : ''); ?>>Hapus</option>
                                        <option value="manage_users" <?php echo e(in_array('manage_users', old('permissions', $role->permissions ?? [])) ? 'selected' : ''); ?>>Kelola Pengguna</option>
                                        <option value="manage_content" <?php echo e(in_array('manage_content', old('permissions', $role->permissions ?? [])) ? 'selected' : ''); ?>>Kelola Konten</option>
                                        <option value="manage_settings" <?php echo e(in_array('manage_settings', old('permissions', $role->permissions ?? [])) ? 'selected' : ''); ?>>Kelola Pengaturan</option>
                                        <option value="access_panel" <?php echo e(in_array('access_panel', old('permissions', $role->permissions ?? [])) ? 'selected' : ''); ?>>Akses Panel</option>
                                        <option value="manage_plugins" <?php echo e(in_array('manage_plugins', old('permissions', $role->permissions ?? [])) ? 'selected' : ''); ?>>Kelola Plugin</option>
                                        <option value="manage_themes" <?php echo e(in_array('manage_themes', old('permissions', $role->permissions ?? [])) ? 'selected' : ''); ?>>Kelola Tema</option>
                                    </select>
                                    <?php $__errorArgs = ['permissions'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <div class="invalid-feedback"><?php echo e($message); ?></div>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                    <small class="form-text text-muted">Pilih izin akses yang diperlukan (boleh lebih dari satu)</small>
                                </div>
                            </div>
                        </div>
                        
                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary">Update Peran</button>
                            <a href="<?php echo e(route('roles.index')); ?>" class="btn btn-secondary">Batal</a>
                        </div>
                    </form>
                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
<script>
$(document).ready(function() {
    // Initialize select2 or similar for better UX if needed
    $('#permissions').select2({
        placeholder: "Pilih izin akses...",
        allowClear: true
    });
});
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('theme.admin.adminlte::layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\htdocs\stelloCMS\app\Themes\admin\adminlte\roles\edit.blade.php ENDPATH**/ ?>