<?php $__env->startSection('title', 'Tambah Menu - Manajemen Menu - ' . cms_name()); ?>
<?php $__env->startSection('page_title', 'Tambah Menu Baru'); ?>

<?php $__env->startSection('content'); ?>
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Tambah Menu Baru</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <form action="<?php echo e(route('menus.store')); ?>" method="POST">
                        <?php echo csrf_field(); ?>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="name">Nama Menu *</label>
                                    <input type="text" class="form-control <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                           id="name" name="name" value="<?php echo e(old('name')); ?>" required>
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
                                </div>
                                
                                <div class="form-group">
                                    <label for="title">Judul Menu *</label>
                                    <input type="text" class="form-control <?php $__errorArgs = ['title'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                           id="title" name="title" value="<?php echo e(old('title')); ?>" required>
                                    <?php $__errorArgs = ['title'];
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
                                
                                <div class="form-group">
                                    <label for="route">Route</label>
                                    <input type="text" class="form-control <?php $__errorArgs = ['route'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                           id="route" name="route" value="<?php echo e(old('route')); ?>" placeholder="Contoh: berita.index">
                                    <?php $__errorArgs = ['route'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <div class="invalid-feedback"><?php echo e($message); ?></div>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                    <small class="form-text text-muted">Gunakan salah satu dari route atau URL</small>
                                </div>
                                
                                <div class="form-group">
                                    <label for="url">URL</label>
                                    <input type="text" class="form-control <?php $__errorArgs = ['url'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                           id="url" name="url" value="<?php echo e(old('url')); ?>" placeholder="Contoh: https://example.com">
                                    <?php $__errorArgs = ['url'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <div class="invalid-feedback"><?php echo e($message); ?></div>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                    <small class="form-text text-muted">Gunakan salah satu dari route atau URL</small>
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="icon">Icon</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control <?php $__errorArgs = ['icon'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                               id="icon" name="icon" value="<?php echo e(old('icon')); ?>" placeholder="Contoh: fas fa-home">
                                        <div class="input-group-append">
                                            <button type="button" class="btn btn-outline-secondary" id="iconPickerBtn">Pilih</button>
                                        </div>
                                    </div>
                                    <div id="iconPreview" style="margin-top: 5px;">
                                        <?php if(old('icon')): ?>
                                            <i class="<?php echo e(old('icon')); ?>" style="font-size: 20px;"></i> Icon saat ini
                                        <?php endif; ?>
                                    </div>
                                    <?php $__errorArgs = ['icon'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <div class="invalid-feedback"><?php echo e($message); ?></div>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                    <small class="form-text text-muted">Gunakan Font Awesome icon (opsional)</small>
                                </div>
                                
                                <!-- Modal for icon selection -->
                                <div class="modal fade" id="iconPickerModal" tabindex="-1" role="dialog">
                                    <div class="modal-dialog modal-lg" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Pilih Icon</h5>
                                                <button type="button" class="close" data-dismiss="modal">
                                                    <span>&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="row" id="iconList">
                                                    <!-- Icons will be populated by JavaScript -->
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="form-group">
                                    <label for="parent_id">Menu Induk</label>
                                    <select class="form-control <?php $__errorArgs = ['parent_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                            id="parent_id" name="parent_id">
                                        <option value="">-- Tidak ada induk --</option>
                                        <?php $__currentLoopData = $parents; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $parent): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($parent->id); ?>" <?php echo e(old('parent_id') == $parent->id ? 'selected' : ''); ?>>
                                                <?php echo e($parent->title); ?>

                                            </option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                    <?php $__errorArgs = ['parent_id'];
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
                                
                                <div class="form-group">
                                    <label for="order">Urutan</label>
                                    <input type="number" class="form-control <?php $__errorArgs = ['order'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                           id="order" name="order" value="<?php echo e(old('order', 0)); ?>" min="0">
                                    <?php $__errorArgs = ['order'];
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
                                
                                <div class="form-group">
                                    <label for="plugin_name">Nama Plugin (Opsional)</label>
                                    <input type="text" class="form-control <?php $__errorArgs = ['plugin_name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                           id="plugin_name" name="plugin_name" value="<?php echo e(old('plugin_name')); ?>" 
                                           placeholder="Contoh: Berita">
                                    <?php $__errorArgs = ['plugin_name'];
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
                                
                                <div class="form-group">
                                    <div class="form-check">
                                        <input type="checkbox" class="form-check-input <?php $__errorArgs = ['is_active'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                               id="is_active" name="is_active" value="1" <?php echo e(old('is_active') ? 'checked' : ''); ?>>
                                        <label class="form-check-label" for="is_active">Aktif</label>
                                    </div>
                                    <?php $__errorArgs = ['is_active'];
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
                                
                                <div class="form-group">
                                    <label>Peran yang Diizinkan (Opsional)</label><br>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="checkbox" id="role_admin" name="roles[]" value="admin" <?php echo e(in_array('admin', old('roles', [])) ? 'checked' : ''); ?>>
                                        <label class="form-check-label" for="role_admin">Admin</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="checkbox" id="role_kepala_desa" name="roles[]" value="kepala-desa" <?php echo e(in_array('kepala-desa', old('roles', [])) ? 'checked' : ''); ?>>
                                        <label class="form-check-label" for="role_kepala_desa">Kepala Desa</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="checkbox" id="role_sekdes" name="roles[]" value="sekdes" <?php echo e(in_array('sekdes', old('roles', [])) ? 'checked' : ''); ?>>
                                        <label class="form-check-label" for="role_sekdes">Sekdes</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="checkbox" id="role_kaur" name="roles[]" value="kaur" <?php echo e(in_array('kaur', old('roles', [])) ? 'checked' : ''); ?>>
                                        <label class="form-check-label" for="role_kaur">Kaur</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="checkbox" id="role_kadus" name="roles[]" value="kadus" <?php echo e(in_array('kadus', old('roles', [])) ? 'checked' : ''); ?>>
                                        <label class="form-check-label" for="role_kadus">Kadus</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="checkbox" id="role_rw" name="roles[]" value="rw" <?php echo e(in_array('rw', old('roles', [])) ? 'checked' : ''); ?>>
                                        <label class="form-check-label" for="role_rw">RW</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="checkbox" id="role_rt" name="roles[]" value="rt" <?php echo e(in_array('rt', old('roles', [])) ? 'checked' : ''); ?>>
                                        <label class="form-check-label" for="role_rt">RT</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary">Simpan Menu</button>
                            <a href="<?php echo e(route('menus.index')); ?>" class="btn btn-secondary">Batal</a>
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
    // Show icon picker modal
    $('#iconPickerBtn').click(function(e) {
        e.preventDefault();
        $('#iconPickerModal').modal('show');
        loadIconList();
    });
    
    // Function to load icon list
    function loadIconList() {
        // Clear previous icons
        $('#iconList').empty();
        
        // Comprehensive list of icons
        const icons = [
            'fas fa-home', 'fas fa-cog', 'fas fa-users', 'fas fa-chart-bar', 'fas fa-table', 
            'fas fa-edit', 'fas fa-trash', 'fas fa-plus', 'fas fa-search', 'fas fa-download',
            'fas fa-upload', 'fas fa-file', 'fas fa-folder', 'fas fa-image', 'fas fa-video',
            'fas fa-music', 'fas fa-bell', 'fas fa-envelope', 'fas fa-comments', 'fas fa-calendar',
            'fas fa-map', 'fas fa-phone', 'fas fa-star', 'fas fa-heart', 'fas fa-thumbs-up',
            'fas fa-lock', 'fas fa-unlock', 'fas fa-user', 'fas fa-sign-out-alt', 'fas fa-shopping-cart',
            'fas fa-globe', 'fas fa-wifi', 'fas fa-battery-full', 'fas fa-volume-up', 'fas fa-print',
            'fas fa-cut', 'fas fa-copy', 'fas fa-paste', 'fas fa-font', 'fas fa-bold',
            'fas fa-italic', 'fas fa-underline', 'fas fa-align-left', 'fas fa-align-center', 'fas fa-align-right',
            
            // Additional icons
            'fas fa-asterisk', 'fas fa-ban', 'fas fa-barcode', 'fas fa-bars', 'fas fa-beer',
            'fas fa-bell-slash', 'fas fa-bicycle', 'fas fa-binoculars', 'fas fa-birthday-cake', 'fas fa-bolt',
            'fas fa-bomb', 'fas fa-book', 'fas fa-bookmark', 'fas fa-briefcase', 'fas fa-bug',
            'fas fa-building', 'fas fa-bullhorn', 'fas fa-bullseye', 'fas fa-calculator', 'fas fa-camera',
            'fas fa-camera-retro', 'fas fa-car', 'fas fa-caret-square-down', 'fas fa-cart-arrow-down', 'fas fa-certificate',
            'fas fa-check', 'fas fa-check-circle', 'fas fa-child', 'fas fa-circle', 'fas fa-cloud',
            'fas fa-cloud-download-alt', 'fas fa-coffee', 'fas fa-cog', 'fas fa-cogs', 'fas fa-columns',
            'fas fa-comment', 'fas fa-comment-o', 'fas fa-comments', 'fas fa-compass', 'fas fa-copyright',
            'fas fa-credit-card', 'fas fa-crop', 'fas fa-crosshairs', 'fas fa-cube', 'fas fa-cubes',
            'fas fa-cutlery', 'fas fa-dashboard', 'fas fa-database', 'fas fa-desktop', 'fas fa-diamond',
            'fas fa-dot-circle-o', 'fas fa-download', 'fas fa-edit', 'fas fa-ellipsis-h', 'fas fa-envelope',
            'fas fa-envelope-o', 'fas fa-eraser', 'fas fa-exclamation', 'fas fa-exclamation-circle', 'fas fa-exclamation-triangle',
            'fas fa-eye', 'fas fa-eyedropper', 'fas fa-fax', 'fas fa-female', 'fas fa-fighter-jet',
            'fas fa-file-archive-o', 'fas fa-file-audio-o', 'fas fa-file-code-o', 'fas fa-file-excel-o', 'fas fa-file-image-o',
            'fas fa-file-pdf-o', 'fas fa-film', 'fas fa-filter', 'fas fa-fire', 'fas fa-flag',
            'fas fa-flask', 'fas fa-folder', 'fas fa-folder-o', 'fas fa-frown-o', 'fas fa-gamepad',
            'fas fa-gavel', 'fas fa-gear', 'fas fa-gears', 'fas fa-gift', 'fas fa-glass',
            'fas fa-globe', 'fas fa-graduation-cap', 'fas fa-group', 'fas fa-hdd-o', 'fas fa-headphones',
            'fas fa-heart', 'fas fa-heart-o', 'fas fa-history', 'fas fa-home', 'fas fa-i-cursor',
            'fas fa-inbox', 'fas fa-info', 'fas fa-info-circle', 'fas fa-key', 'fas fa-keyboard-o',
            
            // Even more icons added
            'fas fa-language', 'fas fa-laptop', 'fas fa-leaf', 'fas fa-lemon', 'fas fa-level-down-alt',
            'fas fa-level-up-alt', 'fas fa-life-ring', 'fas fa-lightbulb', 'fas fa-link', 'fas fa-list',
            'fas fa-list-alt', 'fas fa-list-ol', 'fas fa-list-ul', 'fas fa-location-arrow', 'fas fa-lock-open',
            'fas fa-long-arrow-alt-down', 'fas fa-long-arrow-alt-left', 'fas fa-long-arrow-alt-right', 'fas fa-long-arrow-alt-up', 'fas fa-low-vision',
            'fas fa-magic', 'fas fa-magnet', 'fas fa-male', 'fas fa-map-marker', 'fas fa-map-marker-alt',
            'fas fa-mars', 'fas fa-mars-double', 'fas fa-mars-stroke', 'fas fa-mars-stroke-h', 'fas fa-mars-stroke-v',
            'fas fa-medkit', 'fas fa-meh', 'fas fa-memory', 'fas fa-mercury', 'fas fa-microchip',
            'fas fa-microphone', 'fas fa-microphone-alt', 'fas fa-microphone-slash', 'fas fa-minus', 'fas fa-minus-circle',
            'fas fa-minus-square', 'fas fa-mobile', 'fas fa-mobile-alt', 'fas fa-money-bill', 'fas fa-money-bill-alt',
            'fas fa-moon', 'fas fa-motorcycle', 'fas fa-mouse-pointer', 'fas fa-music', 'fas fa-neuter',
            'fas fa-newspaper', 'fas fa-not-equal', 'fas fa-notes-medical', 'fas fa-object-group', 'fas fa-object-ungroup',
            'fas fa-outdent', 'fas fa-paint-brush', 'fas fa-palette', 'fas fa-pallet', 'fas fa-paper-plane',
            'fas fa-paperclip', 'fas fa-paragraph', 'fas fa-paste', 'fas fa-pause', 'fas fa-pause-circle',
            'fas fa-paw', 'fas fa-pen', 'fas fa-pen-alt', 'fas fa-pen-fancy', 'fas fa-pen-nib',
            'fas fa-pen-square', 'fas fa-pencil-alt', 'fas fa-people-carry', 'fas fa-percent', 'fas fa-percentage',
            'fas fa-phone-slash', 'fas fa-phone-square', 'fas fa-phone-volume', 'fas fa-piggy-bank', 'fas fa-pills',
            'fas fa-place-of-worship', 'fas fa-plane', 'fas fa-play', 'fas fa-play-circle', 'fas fa-plug',
            'fas fa-plus', 'fas fa-plus-circle', 'fas fa-plus-square', 'fas fa-podcast', 'fas fa-poll',
            'fas fa-poll-h', 'fas fa-poo', 'fas fa-portrait', 'fas fa-pound-sign', 'fas fa-power-off',
            'fas fa-prescription', 'fas fa-prescription-bottle', 'fas fa-prescription-bottle-alt', 'fas fa-print', 'fas fa-procedures',
            'fas fa-project-diagram', 'fas fa-puzzle-piece', 'fas fa-qrcode', 'fas fa-question', 'fas fa-question-circle',
            'fas fa-quidditch', 'fas fa-quote-left', 'fas fa-quote-right', 'fas fa-quran', 'fas fa-random',
            'fas fa-receipt', 'fas fa-recycle', 'fas fa-redo', 'fas fa-redo-alt', 'fas fa-registered',
            'fas fa-reply', 'fas fa-reply-all', 'fas fa-retweet', 'fas fa-ribbon', 'fas fa-road',
            'fas fa-robot', 'fas fa-rocket', 'fas fa-route', 'fas fa-rss', 'fas fa-rss-square',
            'fas fa-ruble-sign', 'fas fa-ruler', 'fas fa-ruler-combined', 'fas fa-ruler-horizontal', 'fas fa-ruler-vertical',
            'fas fa-rupee-sign', 'fas fa-sad-cry', 'fas fa-sad-tear', 'fas fa-save', 'fas fa-school',
            'fas fa-screwdriver', 'fas fa-search', 'fas fa-search-minus', 'fas fa-search-plus', 'fas fa-seedling',
            'fas fa-server', 'fas fa-shapes', 'fas fa-share', 'fas fa-share-alt', 'fas fa-share-alt-square'
        ];
        
        // Create icon grid
        icons.forEach(function(icon) {
            const iconHtml = `
                <div class="col-2 mb-3 text-center">
                    <i class="${icon}" style="font-size: 24px; cursor: pointer;" title="${icon}" 
                       onclick="selectIcon('${icon}')"></i>
                    <div style="font-size: 10px; margin-top: 3px;">${icon.split(' ')[1]}</div>
                </div>
            `;
            $('#iconList').append(iconHtml);
        });
    }
    
    // Function to select an icon
    window.selectIcon = function(iconClass) {
        $('#icon').val(iconClass);
        updateIconPreview(iconClass);
        $('#iconPickerModal').modal('hide');
    };
    
    // Update icon preview
    function updateIconPreview(iconClass) {
        $('#iconPreview').html(`<i class="${iconClass}" style="font-size: 20px;"></i> Icon terpilih`);
    }
    
    // Preview when user types in the icon field
    $('#icon').on('input', function() {
        const iconValue = $(this).val();
        if (iconValue) {
            updateIconPreview(iconValue);
        } else {
            $('#iconPreview').html('');
        }
    });
});
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('theme.admin.adminlte::layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\htdocs\stelloCMS\app\Themes/admin/adminlte/menus/create.blade.php ENDPATH**/ ?>