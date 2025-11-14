<?php $__env->startSection('title', 'Pembaruan Sistem - ' . cms_name()); ?>
<?php $__env->startSection('page_title', 'Pembaruan Sistem'); ?>

<?php $__env->startSection('content'); ?>
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Pembaruan Sistem stelloCMS</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="info-box mb-4">
                                <span class="info-box-icon bg-primary elevation-1"><i class="fas fa-code-branch"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text">Versi Saat Ini</span>
                                    <span class="info-box-number"><?php echo e(config('app.version')); ?></span>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="info-box mb-4">
                                <span class="info-box-icon bg-info elevation-1"><i class="fas fa-cloud-download-alt"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text">Versi Terbaru</span>
                                    <span class="info-box-number" id="latest-version">Memeriksa...</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-12">
                            <div class="alert alert-info" id="checking-alert">
                                <h5><i class="icon fas fa-info"></i> Memeriksa Pembaruan!</h5>
                                Sedang memeriksa versi terbaru dari GitHub...
                            </div>
                            
                            <div class="alert alert-success d-none" id="up-to-date-alert">
                                <h5><i class="icon fas fa-check"></i> Sistem Sudah Terbaru!</h5>
                                Tidak ada pembaruan tersedia. Sistem Anda menggunakan versi terbaru.
                            </div>
                            
                            <div class="alert alert-warning d-none" id="update-available-alert">
                                <h5><i class="icon fas fa-exclamation-triangle"></i> Pembaruan Tersedia!</h5>
                                Versi baru tersedia. Klik tombol di bawah untuk memperbarui sistem.
                                <div class="mt-3">
                                    <button class="btn btn-primary" id="show-changelog-btn">Lihat Catatan Pembaruan</button>
                                    <button class="btn btn-success ml-2" id="update-btn" style="display: none;">Update ke Versi Terbaru</button>
                                </div>
                            </div>
                            
                            <div class="d-none" id="changelog-modal">
                                <div class="card card-default">
                                    <div class="card-header">
                                        <h3 class="card-title">Catatan Pembaruan (Changelog)</h3>
                                        <div class="card-tools">
                                            <button type="button" class="btn btn-tool" id="close-changelog">
                                                <i class="fas fa-times"></i>
                                            </button>
                                        </div>
                                    </div>
                                    <div class="card-body" id="changelog-content">
                                        <div class="text-center">
                                            <i class="fas fa-spinner fa-spin"></i> Memuat catatan pembaruan...
                                        </div>
                                    </div>
                                    <div class="card-footer">
                                        <button class="btn btn-success float-right" id="confirm-update">Ya, Saya Ingin Memperbarui</button>
                                        <button class="btn btn-secondary" id="cancel-update">Batal</button>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="d-none" id="progress-container">
                                <div class="card">
                                    <div class="card-header">
                                        <h3 class="card-title">Proses Pembaruan</h3>
                                    </div>
                                    <div class="card-body">
                                        <div class="alert alert-warning">
                                            <h5><i class="icon fas fa-exclamation-triangle"></i> Penting!</h5>
                                            Jangan meninggalkan halaman ini sampai proses pembaruan selesai!
                                        </div>
                                        
                                        <div class="progress mb-3">
                                            <div id="progress-bar" class="progress-bar progress-bar-striped progress-bar-animated bg-success" role="progressbar" style="width: 0%">
                                                0%
                                            </div>
                                        </div>
                                        
                                        <div id="progress-status">Memulai proses pembaruan...</div>
                                    </div>
                                </div>
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

<script>
document.addEventListener('DOMContentLoaded', function() {
    const currentVersion = '<?php echo e(config("app.version")); ?>';
    
    // Check for latest version
    fetch('<?php echo e(route("api.check_version")); ?>')
        .then(response => response.json())
        .then(data => {
            if (data.error) {
                document.getElementById('latest-version').textContent = 'Gagal dicek';
                document.getElementById('checking-alert').innerHTML = `
                    <h5><i class="icon fas fa-exclamation-triangle"></i> Gagal Memeriksa Versi!</h5>
                    <p>` + (data.message || 'Tidak dapat menghubungi server GitHub') + `</p>
                `;
            } else {
                document.getElementById('latest-version').textContent = data.latest_version || 'Tidak dapat dicek';
                
                if (data.has_update) {
                    document.getElementById('checking-alert').classList.add('d-none');
                    document.getElementById('up-to-date-alert').classList.add('d-none');
                    document.getElementById('update-available-alert').classList.remove('d-none');
                    document.getElementById('update-btn').style.display = 'inline-block';
                } else if (data.current_version === data.latest_version) {
                    document.getElementById('checking-alert').classList.add('d-none');
                    document.getElementById('update-available-alert').classList.add('d-none');
                    document.getElementById('up-to-date-alert').classList.remove('d-none');
                } else {
                    document.getElementById('checking-alert').classList.add('d-none');
                    document.getElementById('update-available-alert').classList.add('d-none');
                    document.getElementById('up-to-date-alert').classList.remove('d-none');
                }
            }
        })
        .catch(error => {
            console.error('Error checking version:', error);
            document.getElementById('latest-version').textContent = 'Gagal dicek';
            document.getElementById('checking-alert').innerHTML = `
                <h5><i class="icon fas fa-exclamation-triangle"></i> Gagal Memeriksa Versi!</h5>
                <p>Tidak dapat menghubungi server GitHub</p>
            `;
        });
    
    // Show changelog
    document.getElementById('show-changelog-btn').addEventListener('click', function() {
        fetch('<?php echo e(route("api.changelog")); ?>')
            .then(response => response.text())
            .then(markdown => {
                // Simple conversion from markdown to HTML for basic formatting
                let html = markdown
                    .replace(/^# (.*$)/gim, '<h1>$1</h1>')  // Headers
                    .replace(/^## (.*$)/gim, '<h2>$1</h2>')
                    .replace(/^### (.*$)/gim, '<h3>$1</h3>')
                    .replace(/^\- (.*$)/gim, '<li>$1</li>')  // List items
                    .replace(/\n\n/gim, '</p><p>')  // Paragraphs
                    .replace(/\n/gim, '<br>');  // Line breaks
                    
                // Wrap in paragraph tags
                html = '<p>' + html + '</p>';
                html = html.replace('<p></p>', ''); // Clean up empty paragraphs
                
                document.getElementById('changelog-content').innerHTML = html;
                document.getElementById('changelog-modal').classList.remove('d-none');
            })
            .catch(error => {
                document.getElementById('changelog-content').innerHTML = `
                    <div class="alert alert-danger">
                        <h5><i class="icon fas fa-ban"></i> Gagal Memuat Catatan Pembaruan!</h5>
                        <p>` + (error.message || 'Tidak dapat mengambil catatan pembaruan dari GitHub') + `</p>
                    </div>
                `;
                document.getElementById('changelog-modal').classList.remove('d-none');
            });
    });
    
    // Close changelog modal
    document.getElementById('close-changelog').addEventListener('click', function() {
        document.getElementById('changelog-modal').classList.add('d-none');
    });
    
    document.getElementById('cancel-update').addEventListener('click', function() {
        document.getElementById('changelog-modal').classList.add('d-none');
    });
    
    // Update button click
    document.getElementById('update-btn').addEventListener('click', function() {
        fetch('<?php echo e(route("api.changelog")); ?>')
            .then(response => response.text())
            .then(markdown => {
                // Simple conversion from markdown to HTML for basic formatting
                let html = markdown
                    .replace(/^# (.*$)/gim, '<h1>$1</h1>')  // Headers
                    .replace(/^## (.*$)/gim, '<h2>$1</h2>')
                    .replace(/^### (.*$)/gim, '<h3>$1</h3>')
                    .replace(/^\- (.*$)/gim, '<li>$1</li>')  // List items
                    .replace(/\n\n/gim, '</p><p>')  // Paragraphs
                    .replace(/\n/gim, '<br>');  // Line breaks
                    
                // Wrap in paragraph tags
                html = '<p>' + html + '</p>';
                html = html.replace('<p></p>', ''); // Clean up empty paragraphs
                
                document.getElementById('changelog-content').innerHTML = html;
                document.getElementById('changelog-modal').classList.remove('d-none');
            })
            .catch(error => {
                document.getElementById('changelog-content').innerHTML = `
                    <div class="alert alert-danger">
                        <h5><i class="icon fas fa-ban"></i> Gagal Memuat Catatan Pembaruan!</h5>
                        <p>` + (error.message || 'Tidak dapat mengambil catatan pembaruan dari GitHub') + `</p>
                    </div>
                `;
                document.getElementById('changelog-modal').classList.remove('d-none');
            });
    });
    
    // Confirm update
    document.getElementById('confirm-update').addEventListener('click', function() {
        if (confirm('Apakah Anda yakin ingin memperbarui sistem? Pastikan untuk membuat cadangan data terlebih dahulu.')) {
            document.getElementById('changelog-modal').classList.add('d-none');
            document.getElementById('progress-container').classList.remove('d-none');
            
            // Start update process via API
            fetch('<?php echo e(route("api.update")); ?>', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({})
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    document.getElementById('progress-status').innerHTML = data.message;
                    document.getElementById('progress-bar').style.width = '100%';
                    document.getElementById('progress-bar').textContent = '100%';
                    
                    setTimeout(function() {
                        alert('Pembaruan berhasil. Sistem akan reload otomatis.');
                        location.reload();
                    }, 1500);
                } else {
                    alert('Gagal memperbarui: ' + data.message);
                    location.reload();
                }
            })
            .catch(error => {
                alert('Error saat proses pembaruan: ' + error.message);
                location.reload();
            });
        }
    });
});
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('theme.admin.adminlte::layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\htdocs\stelloCMS\app\Themes\admin\adminlte\update\index.blade.php ENDPATH**/ ?>