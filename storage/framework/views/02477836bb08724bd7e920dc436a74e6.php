<?php $__env->startSection('title', 'Edit Berita - ' . cms_name()); ?>
<?php $__env->startSection('page_title', 'Edit Berita'); ?>

<?php $__env->startSection('content'); ?>
<style>
	.note-group-select-from-files {
        display: none;
    }
</style>
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Edit Berita</h3>
                </div>
                <!-- /.card-header -->
                <form action="<?php echo e(in_array('panel.berita.update', array_keys(app('router')->getRoutes()->getRoutesByName())) ? route('panel.berita.update', $berita->id) : url('/panel/berita/' . $berita->id)); ?>" method="POST" enctype="multipart/form-data">
                    <?php echo csrf_field(); ?>
                    <?php echo method_field('PUT'); ?>
                    <div class="card-body">
                        <div class="form-group">
                            <label for="judul">Judul</label>
                            <input type="text" class="form-control <?php $__errorArgs = ['judul'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="judul" name="judul" value="<?php echo e(old('judul', $berita->judul)); ?>" required>
                            <?php $__errorArgs = ['judul'];
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
                            <label for="isi">Isi Berita</label>
                            <textarea class="form-control <?php $__errorArgs = ['isi'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?> summernote" id="isi" name="isi" rows="10" required><?php echo e(old('isi', $berita->isi)); ?></textarea>
                            <?php $__errorArgs = ['isi'];
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
                            <label for="meta_description">Meta Description (opsional)</label>
                            <textarea class="form-control <?php $__errorArgs = ['meta_description'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="meta_description" name="meta_description" rows="3" placeholder="Deskripsi singkat berita untuk SEO (maksimal 160 karakter)"><?php echo e(old('meta_description', $berita->meta_description ?? '')); ?></textarea>
                            <?php $__errorArgs = ['meta_description'];
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
                            <label for="meta_keywords">Meta Keywords (opsional)</label>
                            <input type="text" class="form-control <?php $__errorArgs = ['meta_keywords'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="meta_keywords" name="meta_keywords" value="<?php echo e(old('meta_keywords', $berita->meta_keywords ?? '')); ?>" placeholder="Kata kunci berita dipisahkan dengan koma">
                            <?php $__errorArgs = ['meta_keywords'];
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
                        
                        <!-- Hidden field for slug -->
                        <input type="hidden" name="slug" value="<?php echo e(old('slug', $berita->slug ?? '')); ?>">
                        <input type="hidden" name="unsplash_image_url" id="hidden_unsplash_image_url" value="">
                        
                        <div class="form-group">
                            <label for="gambar">Gambar (opsional)</label>
                            <div class="input-group">
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input <?php $__errorArgs = ['gambar'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="gambar" name="gambar">
                                    <label class="custom-file-label" for="gambar">Pilih gambar baru (kosongkan jika tidak ingin mengganti)</label>
                                </div>
                                <div class="input-group-append">
                                    <!-- Tombol untuk memilih gambar dari Unsplash -->
                                    <button type="button" class="btn btn-outline-secondary" id="btn-unsplash" style="display: none;">Gunakan dari Unsplash</button>
                                </div>
                            </div>
                            
                            <?php if($berita->gambar): ?>
                                <div id="gambar-sekarang" class="mt-2">
                                    <label>Gambar saat ini:</label><br>
                                    <img src="<?php echo e(asset('storage/' . $berita->gambar)); ?>" alt="Gambar Berita" class="img-thumbnail" style="max-width: 200px;">
                                </div>
                            <?php endif; ?>
                            
                            <!-- Preview gambar -->
                            <div id="gambar-preview" class="mt-2" style="display: none;">
                                <label>Preview Gambar:</label>
                                <img id="preview-image" src="#" alt="Preview Gambar" class="img-thumbnail" style="max-width: 200px; max-height: 200px;">
                            </div>

                            <?php $__errorArgs = ['gambar'];
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
                            <div class="icheck-primary d-inline">
                                <input type="checkbox" id="aktif" name="aktif" value="1" <?php echo e(old('aktif', $berita->aktif) ? 'checked' : ''); ?>>
                                <label for="aktif">Aktifkan Berita</label>
                            </div>
                        </div>
                    </div>
                    <!-- /.card-body -->
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">Update</button>
                        <a href="<?php echo e(in_array('panel.berita.index', array_keys(app('router')->getRoutes()->getRoutesByName())) ? route('panel.berita.index') : url('/panel/berita')); ?>" class="btn btn-default">Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal Unsplash -->
<div class="modal fade" id="unsplashModal" tabindex="-1" role="dialog" aria-labelledby="unsplashModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="unsplashModalLabel">Pilih Gambar dari Unsplash</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="input-group mb-3">
                    <input type="text" class="form-control" id="unsplash-search" placeholder="Cari gambar...">
                    <div class="input-group-append">
                        <button class="btn btn-outline-secondary" type="button" id="search-btn">Cari</button>
                    </div>
                </div>
                
                <div id="unsplash-loading" class="text-center" style="display: none;">
                    <div class="spinner-border" role="status">
                        <span class="sr-only">Loading...</span>
                    </div>
                </div>
                
                <div id="unsplash-results" class="row">
                    <!-- Gambar-gambar dari Unsplash akan ditampilkan di sini -->
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('styles'); ?>
<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.css" rel="stylesheet">
<style>
    .note-editor.note-frame {
        border: 1px solid #ced4da !important;
        border-radius: 0.25rem !important;
    }
    .note-toolbar {
        background-color: #f8f9fa !important;
        border-bottom: 1px solid #ced4da !important;
        border-radius: 0.25rem 0.25rem 0 0 !important;
    }
    .form-group .invalid-feedback {
        display: block;
        margin-top: 0.25rem;
    }
</style>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.js"></script>
<script>
// Inisialisasi Summernote
$(document).ready(function() {
    $('.summernote').summernote({
        height: 300,
        minHeight: null,
        maxHeight: null,
        focus: true,
        toolbar: [
            ['style', ['style']],
            ['font', ['bold', 'underline', 'clear']],
            ['color', ['color']],
            ['para', ['ul', 'ol', 'paragraph']],
            ['table', ['table']],
            ['insert', ['link', 'picture', 'video']],
            ['view', ['fullscreen', 'codeview', 'help']]
        ]
    });
});

// Add file input label update
document.getElementById('gambar').addEventListener('change', function(e) {
    var fileName = e.target.files[0] ? e.target.files[0].name : 'Pilih gambar';
    document.getElementById('gambar').nextElementSibling.innerHTML = fileName;
    
    // Jika file dipilih, hapus preview Unsplash dan reset field Unsplash
    document.getElementById('gambar-preview').style.display = 'none';
    
    // Reset field Unsplash jika ada
    const unsplashField = document.getElementById('hidden_unsplash_image_url');
    if (unsplashField) {
        unsplashField.value = '';
    }
    
    // Jika file dipilih, sembunyikan gambar saat ini dan tampilkan preview jika diinginkan
    if (e.target.files.length > 0) {
        const gambarSekarang = document.getElementById('gambar-sekarang');
        if (gambarSekarang) {
            gambarSekarang.style.display = 'none';
        }
    }
});

// Check if Unsplash API keys are available
fetch('<?php echo e(route("panel.berita.unsplash.check_keys")); ?>')
    .then(response => response.json())
    .then(data => {
        if (data.hasKeys) {
            // Initially check if title is filled
            const judul = document.getElementById('judul').value.trim();
            if (judul !== '') {
                document.getElementById('btn-unsplash').style.display = 'inline-block';
            } else {
                document.getElementById('btn-unsplash').style.display = 'none';
            }

            // Watch for changes in the title field
            document.getElementById('judul').addEventListener('input', function() {
                const judulValue = this.value.trim();
                if (judulValue !== '') {
                    document.getElementById('btn-unsplash').style.display = 'inline-block';
                } else {
                    document.getElementById('btn-unsplash').style.display = 'none';
                }
            });
        }
    })
    .catch(error => {
        console.error('Error checking Unsplash keys:', error);
    });

// Event listener for Unsplash button
document.getElementById('btn-unsplash').addEventListener('click', function() {
    // Fill search field with title
    const judul = document.getElementById('judul').value;
    if (judul) {
        document.getElementById('unsplash-search').value = judul;
        searchUnsplash(judul);
    } else {
        searchUnsplash('random');
    }
    $('#unsplashModal').modal('show');
});

// Event listener for search button
document.getElementById('search-btn').addEventListener('click', function() {
    const query = document.getElementById('unsplash-search').value || 'random';
    searchUnsplash(query);
});

// Event listener for enter in search input
document.getElementById('unsplash-search').addEventListener('keypress', function(e) {
    if (e.key === 'Enter') {
        const query = document.getElementById('unsplash-search').value || 'random';
        searchUnsplash(query);
    }
});

function searchUnsplash(query) {
    document.getElementById('unsplash-loading').style.display = 'block';
    document.getElementById('unsplash-results').innerHTML = '';

    fetch('<?php echo e(route("panel.berita.unsplash.search")); ?>?query=' + encodeURIComponent(query) + '&per_page=12')
        .then(response => response.json())
        .then(data => {
            document.getElementById('unsplash-loading').style.display = 'none';

            if (data.results && data.results.length > 0) {
                data.results.forEach(photo => {
                    const col = document.createElement('div');
                    col.className = 'col-md-4 mb-3';

                    col.innerHTML = `
                        <div class="card" style="cursor: pointer;" onclick="selectUnsplashImage('${photo.urls.regular}', '${photo.alt_description || 'Unsplash Image'}')">
                            <img src="${photo.urls.small}" class="card-img-top" alt="${photo.alt_description || 'Unsplash image'}" style="height: 150px; object-fit: cover;">
                            <div class="card-body p-2">
                                <small class="text-muted">Oleh: ${photo.user.name}</small>
                            </div>
                        </div>
                    `;

                    document.getElementById('unsplash-results').appendChild(col);
                });
            } else {
                document.getElementById('unsplash-results').innerHTML = '<div class="col-12"><p class="text-center">Gambar tidak ditemukan</p></div>';
            }
        })
        .catch(error => {
            document.getElementById('unsplash-loading').style.display = 'none';
            console.error('Error:', error);
            document.getElementById('unsplash-results').innerHTML = '<div class="col-12"><p class="text-center">Terjadi kesalahan saat mengambil gambar</p></div>';
        });
}

function selectUnsplashImage(imageUrl, judul) {
    console.log('selectUnsplashImage called with URL:', imageUrl);

    // Sembunyikan gambar saat ini jika ada
    const gambarSekarang = document.getElementById('gambar-sekarang');
    if (gambarSekarang) {
        gambarSekarang.style.display = 'none';
    }

    // Tampilkan preview langsung dari URL Unsplash
    document.getElementById('preview-image').src = imageUrl;
    document.getElementById('gambar-preview').style.display = 'block';

    // Sembunyikan modal
    $('#unsplashModal').modal('hide');

    // Kosongkan field file upload agar tidak terjadi konflik
    const fileField = document.getElementById('gambar');
    if (fileField) {
        fileField.value = ''; // Kosongkan field file
    }
    
    // Set value dari hidden field yang sudah ada
    const unsplashField = document.getElementById('hidden_unsplash_image_url');
    if (unsplashField) {
        unsplashField.value = imageUrl;
        console.log('Set unsplash_image_url field with value:', imageUrl);
    } else {
        console.error('Hidden unsplash field not found!');
    }

    console.log('All operations completed in selectUnsplashImage');
}

// Tambahkan event listener untuk submit form
document.addEventListener('DOMContentLoaded', function() {
    const form = document.querySelector('form');
    if (form) {
        form.addEventListener('submit', function(e) {
            const unsplashField = document.querySelector('input[name="unsplash_image_url"]');
            if (unsplashField && unsplashField.value) {
                console.log('unsplash_image_url field found in form with value:', unsplashField.value);
            } else {
                console.log('unsplash_image_url field NOT FOUND in form or is empty');
            }
        });
    }
});
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('theme.admin.' . config('themes.admin') . '::layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\htdocs\stelloCMS\app\Plugins/Berita/Views/edit.blade.php ENDPATH**/ ?>