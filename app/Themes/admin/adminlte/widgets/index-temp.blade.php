@extends('theme.admin.adminlte::layouts.app')

@section('title', 'Manajemen Widgets - ' . cms_name())
@section('page_title', 'Manajemen Widgets')

@section('content')
<meta name="csrf-token" content="{{ csrf_token() }}">

<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Manajemen Widgets</h3>
                    <div class="card-tools">
                        <a href="{{ route('panel.widgets.create') }}" class="btn btn-primary">Tambah Widget</a>
                    </div>
                </div>
                <!-- /.card-header -->

                <div class="card-body">
                    <!-- Grid 3x3 untuk widget berdasarkan posisi -->
                    <div class="grid-container">
                        <table class="table table-bordered">
                            <tbody>
                                <!-- Baris 1: Header (span 3 kolom) -->
                                <tr>
                                    <td colspan="3" class="p-3 position-header bg-gray-100">
                                        <div class="d-flex justify-content-between align-items-center mb-2">
                                            <h4 class="position-title mb-0">
                                                <i class="fas fa-header mr-2"></i> Header Widgets
                                            </h4>
                                            <span class="badge badge-primary">{{ $headerWidgets->count() }} widgets</span>
                                        </div>
                                        <div class="position-widgets-container sortable-widget" data-position="header" id="header-widgets-container">
                                            @if($headerWidgets->count() > 0)
                                                @foreach($headerWidgets as $widget)
                                                <div class="position-widget card mb-2" data-id="{{ $widget->id }}" data-position="{{ $widget->position }}">
                                                    <div class="card-body p-2">
                                                        <div class="d-flex justify-content-between">
                                                            <div class="flex-grow-1">
                                                                <h6 class="card-title mb-1">{{ Str::limit($widget->name, 30) }}</h6>
                                                                <div class="small text-muted">
                                                                    <span class="badge badge-{{ $widget->type === 'plugin' ? 'info' : ($widget->type === 'text' ? 'warning' : 'success') }}">
                                                                        {{ ucfirst($widget->type) }}
                                                                    </span>
                                                                    <span class="badge {{ $widget->status === 'aktif' ? 'badge-success' : 'badge-danger' }}">
                                                                        {{ $widget->status }}
                                                                    </span>
                                                                    <small>Urutan: {{ $widget->order }}</small>
                                                                </div>
                                                            </div>
                                                            <div class="btn-group btn-group-sm ml-2">
                                                                <a href="{{ route('panel.widgets.show', $widget->id) }}" class="btn btn-info" title="Lihat">
                                                                    <i class="fas fa-eye"></i>
                                                                </a>
                                                                <a href="{{ route('panel.widgets.edit', $widget->id) }}" class="btn btn-primary" title="Edit">
                                                                    <i class="fas fa-edit"></i>
                                                                </a>
                                                                <form action="{{ route('panel.widgets.destroy', $widget->id) }}" method="POST" class="d-inline">
                                                                    @csrf
                                                                    @method('DELETE')
                                                                    <button type="submit" class="btn btn-danger" title="Hapus" onclick="return confirm('Yakin ingin menghapus widget ini?')">
                                                                        <i class="fas fa-trash"></i>
                                                                    </button>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                @endforeach
                                            @else
                                                <div class="alert alert-secondary text-center mb-0 py-4">
                                                    <i class="fas fa-info-circle mb-2"></i>
                                                    <p class="mb-0">Tidak ada widget di posisi Header</p>
                                                </div>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                                
                                <!-- Baris 2: Sidebar Left (kolom 1), Home (kolom 2), Sidebar Right (kolom 3) -->
                                <tr>
                                    <!-- Sidebar Left -->
                                    <td class="p-3 position-sidebar-left bg-gray-100">
                                        <div class="d-flex justify-content-between align-items-center mb-2">
                                            <h4 class="position-title mb-0">
                                                <i class="fas fa-align-left mr-2"></i> Sidebar Kiri
                                            </h4>
                                            <span class="badge badge-primary">{{ $sidebarLeftWidgets->count() }} widgets</span>
                                        </div>
                                        <div class="position-widgets-container sortable-widget" data-position="sidebar-left" id="sidebar-left-widgets-container">
                                            @if($sidebarLeftWidgets->count() > 0)
                                                @foreach($sidebarLeftWidgets as $widget)
                                                <div class="position-widget card mb-2" data-id="{{ $widget->id }}" data-position="{{ $widget->position }}">
                                                    <div class="card-body p-2">
                                                        <div class="d-flex justify-content-between">
                                                            <div class="flex-grow-1">
                                                                <h6 class="card-title mb-1">{{ Str::limit($widget->name, 25) }}</h6>
                                                                <div class="small text-muted">
                                                                    <span class="badge badge-{{ $widget->type === 'plugin' ? 'info' : ($widget->type === 'text' ? 'warning' : 'success') }}">
                                                                        {{ ucfirst($widget->type) }}
                                                                    </span>
                                                                    <span class="badge {{ $widget->status === 'aktif' ? 'badge-success' : 'badge-danger' }}">
                                                                        {{ $widget->status }}
                                                                    </span>
                                                                    <small>Urutan: {{ $widget->order }}</small>
                                                                </div>
                                                            </div>
                                                            <div class="btn-group btn-group-sm ml-2">
                                                                <a href="{{ route('panel.widgets.show', $widget->id) }}" class="btn btn-info" title="Lihat">
                                                                    <i class="fas fa-eye"></i>
                                                                </a>
                                                                <a href="{{ route('panel.widgets.edit', $widget->id) }}" class="btn btn-primary" title="Edit">
                                                                    <i class="fas fa-edit"></i>
                                                                </a>
                                                                <form action="{{ route('panel.widgets.destroy', $widget->id) }}" method="POST" class="d-inline">
                                                                    @csrf
                                                                    @method('DELETE')
                                                                    <button type="submit" class="btn btn-danger" title="Hapus" onclick="return confirm('Yakin ingin menghapus widget ini?')">
                                                                        <i class="fas fa-trash"></i>
                                                                    </button>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                @endforeach
                                            @else
                                                <div class="alert alert-secondary text-center mb-0 py-4">
                                                    <i class="fas fa-info-circle mb-2"></i>
                                                    <p class="mb-0">Tidak ada widget di posisi Sidebar Kiri</p>
                                                </div>
                                            @endif
                                        </div>
                                    </td>
                                    
                                    <!-- Home -->
                                    <td class="p-3 position-home bg-gray-100">
                                        <div class="d-flex justify-content-between align-items-center mb-2">
                                            <h4 class="position-title mb-0">
                                                <i class="fas fa-home mr-2"></i> Home
                                            </h4>
                                            <span class="badge badge-primary">{{ $homeWidgets->count() }} widgets</span>
                                        </div>
                                        <div class="position-widgets-container sortable-widget" data-position="home" id="home-widgets-container">
                                            @if($homeWidgets->count() > 0)
                                                @foreach($homeWidgets as $widget)
                                                <div class="position-widget card mb-2" data-id="{{ $widget->id }}" data-position="{{ $widget->position }}">
                                                    <div class="card-body p-2">
                                                        <div class="d-flex justify-content-between">
                                                            <div class="flex-grow-1">
                                                                <h6 class="card-title mb-1">{{ Str::limit($widget->name, 25) }}</h6>
                                                                <div class="small text-muted">
                                                                    <span class="badge badge-{{ $widget->type === 'plugin' ? 'info' : ($widget->type === 'text' ? 'warning' : 'success') }}">
                                                                        {{ ucfirst($widget->type) }}
                                                                    </span>
                                                                    <span class="badge {{ $widget->status === 'aktif' ? 'badge-success' : 'badge-danger' }}">
                                                                        {{ $widget->status }}
                                                                    </span>
                                                                    <small>Urutan: {{ $widget->order }}</small>
                                                                </div>
                                                            </div>
                                                            <div class="btn-group btn-group-sm ml-2">
                                                                <a href="{{ route('panel.widgets.show', $widget->id) }}" class="btn btn-info" title="Lihat">
                                                                    <i class="fas fa-eye"></i>
                                                                </a>
                                                                <a href="{{ route('panel.widgets.edit', $widget->id) }}" class="btn btn-primary" title="Edit">
                                                                    <i class="fas fa-edit"></i>
                                                                </a>
                                                                <form action="{{ route('panel.widgets.destroy', $widget->id) }}" method="POST" class="d-inline">
                                                                    @csrf
                                                                    @method('DELETE')
                                                                    <button type="submit" class="btn btn-danger" title="Hapus" onclick="return confirm('Yakin ingin menghapus widget ini?')">
                                                                        <i class="fas fa-trash"></i>
                                                                    </button>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                @endforeach
                                            @else
                                                <div class="alert alert-secondary text-center mb-0 py-4">
                                                    <i class="fas fa-info-circle mb-2"></i>
                                                    <p class="mb-0">Tidak ada widget di posisi Home</p>
                                                </div>
                                            @endif
                                        </div>
                                    </td>
                                    
                                    <!-- Sidebar Right -->
                                    <td class="p-3 position-sidebar-right bg-gray-100">
                                        <div class="d-flex justify-content-between align-items-center mb-2">
                                            <h4 class="position-title mb-0">
                                                <i class="fas fa-align-right mr-2"></i> Sidebar Kanan
                                            </h4>
                                            <span class="badge badge-primary">{{ $sidebarRightWidgets->count() }} widgets</span>
                                        </div>
                                        <div class="position-widgets-container sortable-widget" data-position="sidebar-right" id="sidebar-right-widgets-container">
                                            @if($sidebarRightWidgets->count() > 0)
                                                @foreach($sidebarRightWidgets as $widget)
                                                <div class="position-widget card mb-2" data-id="{{ $widget->id }}" data-position="{{ $widget->position }}">
                                                    <div class="card-body p-2">
                                                        <div class="d-flex justify-content-between">
                                                            <div class="flex-grow-1">
                                                                <h6 class="card-title mb-1">{{ Str::limit($widget->name, 25) }}</h6>
                                                                <div class="small text-muted">
                                                                    <span class="badge badge-{{ $widget->type === 'plugin' ? 'info' : ($widget->type === 'text' ? 'warning' : 'success') }}">
                                                                        {{ ucfirst($widget->type) }}
                                                                    </span>
                                                                    <span class="badge {{ $widget->status === 'aktif' ? 'badge-success' : 'badge-danger' }}">
                                                                        {{ $widget->status }}
                                                                    </span>
                                                                    <small>Urutan: {{ $widget->order }}</small>
                                                                </div>
                                                            </div>
                                                            <div class="btn-group btn-group-sm ml-2">
                                                                <a href="{{ route('panel.widgets.show', $widget->id) }}" class="btn btn-info" title="Lihat">
                                                                    <i class="fas fa-eye"></i>
                                                                </a>
                                                                <a href="{{ route('panel.widgets.edit', $widget->id) }}" class="btn btn-primary" title="Edit">
                                                                    <i class="fas fa-edit"></i>
                                                                </a>
                                                                <form action="{{ route('panel.widgets.destroy', $widget->id) }}" method="POST" class="d-inline">
                                                                    @csrf
                                                                    @method('DELETE')
                                                                    <button type="submit" class="btn btn-danger" title="Hapus" onclick="return confirm('Yakin ingin menghapus widget ini?')">
                                                                        <i class="fas fa-trash"></i>
                                                                    </button>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                @endforeach
                                            @else
                                                <div class="alert alert-secondary text-center mb-0 py-4">
                                                    <i class="fas fa-info-circle mb-2"></i>
                                                    <p class="mb-0">Tidak ada widget di posisi Sidebar Kanan</p>
                                                </div>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                                
                                <!-- Baris 3: Footer (span 3 kolom) -->
                                <tr>
                                    <td colspan="3" class="p-3 position-footer bg-gray-100">
                                        <div class="d-flex justify-content-between align-items-center mb-2">
                                            <h4 class="position-title mb-0">
                                                <i class="fas fa-file-alt mr-2"></i> Footer Widgets
                                            </h4>
                                            <span class="badge badge-primary">{{ $footerWidgets->count() }} widgets</span>
                                        </div>
                                        <div class="position-widgets-container sortable-widget" data-position="footer" id="footer-widgets-container">
                                            @if($footerWidgets->count() > 0)
                                                @foreach($footerWidgets as $widget)
                                                <div class="position-widget card mb-2" data-id="{{ $widget->id }}" data-position="{{ $widget->position }}">
                                                    <div class="card-body p-2">
                                                        <div class="d-flex justify-content-between">
                                                            <div class="flex-grow-1">
                                                                <h6 class="card-title mb-1">{{ Str::limit($widget->name, 30) }}</h6>
                                                                <div class="small text-muted">
                                                                    <span class="badge badge-{{ $widget->type === 'plugin' ? 'info' : ($widget->type === 'text' ? 'warning' : 'success') }}">
                                                                        {{ ucfirst($widget->type) }}
                                                                    </span>
                                                                    <span class="badge {{ $widget->status === 'aktif' ? 'badge-success' : 'badge-danger' }}">
                                                                        {{ $widget->status }}
                                                                    </span>
                                                                    <small>Urutan: {{ $widget->order }}</small>
                                                                </div>
                                                            </div>
                                                            <div class="btn-group btn-group-sm ml-2">
                                                                <a href="{{ route('panel.widgets.show', $widget->id) }}" class="btn btn-info" title="Lihat">
                                                                    <i class="fas fa-eye"></i>
                                                                </a>
                                                                <a href="{{ route('panel.widgets.edit', $widget->id) }}" class="btn btn-primary" title="Edit">
                                                                    <i class="fas fa-edit"></i>
                                                                </a>
                                                                <form action="{{ route('panel.widgets.destroy', $widget->id) }}" method="POST" class="d-inline">
                                                                    @csrf
                                                                    @method('DELETE')
                                                                    <button type="submit" class="btn btn-danger" title="Hapus" onclick="return confirm('Yakin ingin menghapus widget ini?')">
                                                                        <i class="fas fa-trash"></i>
                                                                    </button>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                @endforeach
                                            @else
                                                <div class="alert alert-secondary text-center mb-0 py-4">
                                                    <i class="fas fa-info-circle mb-2"></i>
                                                    <p class="mb-0">Tidak ada widget di posisi Footer</p>
                                                </div>
                                            @endif
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

<!-- Tambahkan script untuk drag-and-drop -->
<script src="https://code.jquery.com/ui/1.13.2/jquery-ui.min.js"></script>
<link rel="stylesheet" href="https://code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">

<script>
$(document).ready(function() {
    // Enable sortable untuk semua container widget dengan koneksi antar container
    $('.sortable-widget').each(function() {
        const $container = $(this);
        const position = $container.data('position');
        
        $container.sortable({
            placeholder: 'ui-sortable-placeholder',
            cursor: 'move',
            opacity: 0.7,
            connectWith: '.sortable-widget', // Izinkan drag antar posisi
            update: function(event, ui) {
                // Update order saat widget dipindahkan di dalam posisi yang sama atau berbeda
                updateWidgetOrder();
            },
            stop: function(event, ui) {
                // Dapatkan posisi baru setelah dipindahkan 
                const newPosition = $(ui.item).closest('.sortable-widget').data('position');
                const oldPosition = position; // Position saat inisialisasi container
                
                // Jika widget dipindahkan ke posisi berbeda, update posisi di database
                if (oldPosition !== newPosition) {
                    const widgetId = ui.item.data('id');
                    updateWidgetPosition(widgetId, newPosition);
                }
                
                // Update order untuk semua posisi setelah perubahan selesai
                updateWidgetOrder();
            }
        });
    });
    
    // Function untuk update urutan dan posisi semua widget
    function updateWidgetOrder() {
        // Kumpulkan semua widget dari semua posisi
        const allWidgetsData = [];
        
        $('.sortable-widget').each(function() {
            const position = $(this).data('position');
            $(this).find('[data-id]').each(function(index) {
                allWidgetsData.push({
                    id: $(this).data('id'),
                    position: position,
                    order: index + 1
                });
            });
        });
        
        if (allWidgetsData.length > 0) {
            $.ajax({
                url: '{{ route("panel.widgets.update-order") }}',
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {
                    all_widgets: allWidgetsData  // Kirim semua widget beserta posisi dan urutan
                },
                success: function(response) {
                    console.log('Order and position updated successfully:', response);
                    
                    // Update nomor urutan di UI untuk semua posisi
                    $('.sortable-widget').each(function() {
                        const position = $(this).data('position');
                        $(this).find('[data-id]').each(function(index) {
                            $(this).find('small:last').text('Urutan: ' + (index + 1));
                        });
                    });
                },
                error: function(xhr, status, error) {
                    console.error('Error updating order and position:', error);
                    alert('Gagal memperbarui urutan dan posisi widget. Silakan coba lagi.');
                    location.reload(); // Reload untuk kembalikan ke urutan sebelum error
                }
            });
        }
    }
    
    // Function untuk update posisi widget
    function updateWidgetPosition(widgetId, newPosition) {
        // Fungsi ini tetap diperlukan untuk update posisi ke database
        $.ajax({
            url: '{{ route("panel.widgets.update-position") }}',
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: {
                id: widgetId,
                position: newPosition
            },
            success: function(response) {
                console.log('Position updated successfully for widget ' + widgetId + ' to ' + newPosition);
                
                // Update posisi di data attribute DOM
                $(`[data-id="${widgetId}"]`).attr('data-position', newPosition);
            },
            error: function(xhr, status, error) {
                console.error('Error updating position for widget ' + widgetId + ':', error);
                alert('Gagal memperbarui posisi widget. Silakan coba lagi.');
                location.reload(); // Reload untuk kembalikan ke posisi sebelum error
            }
        });
    }
});

// Tambahkan CSS untuk placeholder sortable
$('head').append('<style> .ui-sortable-placeholder { height: 60px; background: #f39c12 !important; border: 1px dashed #ccc !important; visibility: visible !important; margin-bottom: 10px; border-radius: 0.25rem; }</style>');

// CSS tambahan untuk interaktivitas
$('head').append(`<style>
    .position-widget {
        cursor: move;
        transition: all 0.2s ease;
    }
    
    .position-widget:hover {
        background-color: #f8f9fa;
        transform: translateX(2px);
    }
    
    .position-header, .position-footer {
        vertical-align: top;
    }
    
    .position-widgets-container {
        min-height: 100px;
        padding: 10px;
    }
    
    .position-title {
        display: flex;
        align-items: center;
    }
    
    .position-title i {
        margin-right: 8px;
    }
    
    .bg-gray-100 {
        background-color: #f8f9fa;
    }
</style>`);

// Ambil tag meta CSRF sebelum menggunakannya di AJAX
$.ajaxSetup({
    headers: {
