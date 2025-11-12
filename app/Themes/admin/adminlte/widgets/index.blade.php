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

                <!-- Tabs untuk widget berdasarkan posisi -->
                <div class="card-header p-0 border-bottom-0">
                    <ul class="nav nav-tabs" id="widgetsTab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="header-widgets-tab" data-toggle="tab" href="#header-widgets" role="tab" aria-controls="header-widgets" aria-selected="true">
                                <i class="fas fa-heading"></i> Header Widgets
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="sidebar-left-tab" data-toggle="tab" href="#left-widgets" role="tab" aria-controls="left-widgets" aria-selected="false">
                                <i class="fas fa-align-left"></i> Sidebar Left
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="sidebar-right-tab" data-toggle="tab" href="#right-widgets" role="tab" aria-controls="right-widgets" aria-selected="false">
                                <i class="fas fa-align-right"></i> Sidebar Right
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="footer-widgets-tab" data-toggle="tab" href="#footer-widgets" role="tab" aria-controls="footer-widgets" aria-selected="false">
                                <i class="fas fa-file-alt"></i> Footer Widgets
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="home-widgets-tab" data-toggle="tab" href="#home-widgets" role="tab" aria-controls="home-widgets" aria-selected="false">
                                <i class="fas fa-home"></i> Home Widgets
                            </a>
                        </li>
                    </ul>
                </div>

                <div class="card-body">
                    <div class="tab-content" id="widgetsTabContent">
                        <!-- Header Widgets Tab -->
                        <div class="tab-pane fade show active" id="header-widgets" role="tabpanel" aria-labelledby="header-widgets-tab">
                            @if(isset($headerWidgets) && $headerWidgets->count() > 0)
                                <div class="list-group" id="header-widgets-list">
                                    @foreach($headerWidgets as $widget)
                                    <div class="list-group-item" data-widget-id="{{ $widget->id }}">
                                        <div class="d-flex w-100 justify-content-between">
                                            <div>
                                                <h5 class="mb-1">{{ $widget->name }}</h5>
                                                <small class="text-muted">Order: {{ $widget->order }}</small>
                                            </div>
                                            <div>
                                                <span class="badge badge-{{ $widget->type === 'plugin' ? 'info' : ($widget->type === 'text' ? 'warning' : 'success') }}">
                                                    {{ ucfirst($widget->type) }}
                                                </span>
                                                <span class="badge {{ $widget->status === 'aktif' ? 'badge-success' : 'badge-danger' }}">
                                                    {{ $widget->status }}
                                                </span>
                                            </div>
                                        </div>
                                        <p class="mb-1">{{ Str::limit(strip_tags($widget->content ?? ''), 80, '...') }}</p>
                                        <small class="text-muted">{{ $widget->plugin_name ?: 'Tidak ada plugin' }}</small>
                                        <div class="mt-2">
                                            <a href="{{ route('panel.widgets.show', $widget->id) }}" class="btn btn-sm btn-info">Lihat</a>
                                            <a href="{{ route('panel.widgets.edit', $widget->id) }}" class="btn btn-sm btn-primary">Edit</a>
                                            <form action="{{ route('panel.widgets.destroy', $widget->id) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Yakin ingin menghapus widget ini?')">Hapus</button>
                                            </form>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                            @else
                                <div class="alert alert-info">
                                    Belum ada widget di posisi Header.
                                </div>
                            @endif
                        </div>

                        <!-- Sidebar Left Widgets Tab -->
                        <div class="tab-pane fade" id="left-widgets" role="tabpanel" aria-labelledby="sidebar-left-tab">
                            @if(isset($sidebarLeftWidgets) && $sidebarLeftWidgets->count() > 0)
                                <div class="list-group" id="sidebar-left-widgets-list">
                                    @foreach($sidebarLeftWidgets as $widget)
                                    <div class="list-group-item" data-widget-id="{{ $widget->id }}">
                                        <div class="d-flex w-100 justify-content-between">
                                            <div>
                                                <h5 class="mb-1">{{ $widget->name }}</h5>
                                                <small class="text-muted">Order: {{ $widget->order }}</small>
                                            </div>
                                            <div>
                                                <span class="badge badge-{{ $widget->type === 'plugin' ? 'info' : ($widget->type === 'text' ? 'warning' : 'success') }}">
                                                    {{ ucfirst($widget->type) }}
                                                </span>
                                                <span class="badge {{ $widget->status === 'aktif' ? 'badge-success' : 'badge-danger' }}">
                                                    {{ $widget->status }}
                                                </span>
                                            </div>
                                        </div>
                                        <p class="mb-1">{{ Str::limit(strip_tags($widget->content ?? ''), 80, '...') }}</p>
                                        <small class="text-muted">{{ $widget->plugin_name ?: 'Tidak ada plugin' }}</small>
                                        <div class="mt-2">
                                            <a href="{{ route('panel.widgets.show', $widget->id) }}" class="btn btn-sm btn-info">Lihat</a>
                                            <a href="{{ route('panel.widgets.edit', $widget->id) }}" class="btn btn-sm btn-primary">Edit</a>
                                            <form action="{{ route('panel.widgets.destroy', $widget->id) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Yakin ingin menghapus widget ini?')">Hapus</button>
                                            </form>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                            @else
                                <div class="alert alert-info">
                                    Belum ada widget di posisi Sidebar Kiri.
                                </div>
                            @endif
                        </div>

                        <!-- Sidebar Right Widgets Tab -->
                        <div class="tab-pane fade" id="right-widgets" role="tabpanel" aria-labelledby="sidebar-right-tab">
                            @if(isset($sidebarRightWidgets) && $sidebarRightWidgets->count() > 0)
                                <div class="list-group" id="sidebar-right-widgets-list">
                                    @foreach($sidebarRightWidgets as $widget)
                                    <div class="list-group-item" data-widget-id="{{ $widget->id }}">
                                        <div class="d-flex w-100 justify-content-between">
                                            <div>
                                                <h5 class="mb-1">{{ $widget->name }}</h5>
                                                <small class="text-muted">Order: {{ $widget->order }}</small>
                                            </div>
                                            <div>
                                                <span class="badge badge-{{ $widget->type === 'plugin' ? 'info' : ($widget->type === 'text' ? 'warning' : 'success') }}">
                                                    {{ ucfirst($widget->type) }}
                                                </span>
                                                <span class="badge {{ $widget->status === 'aktif' ? 'badge-success' : 'badge-danger' }}">
                                                    {{ $widget->status }}
                                                </span>
                                            </div>
                                        </div>
                                        <p class="mb-1">{{ Str::limit(strip_tags($widget->content ?? ''), 80, '...') }}</p>
                                        <small class="text-muted">{{ $widget->plugin_name ?: 'Tidak ada plugin' }}</small>
                                        <div class="mt-2">
                                            <a href="{{ route('panel.widgets.show', $widget->id) }}" class="btn btn-sm btn-info">Lihat</a>
                                            <a href="{{ route('panel.widgets.edit', $widget->id) }}" class="btn btn-sm btn-primary">Edit</a>
                                            <form action="{{ route('panel.widgets.destroy', $widget->id) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Yakin ingin menghapus widget ini?')">Hapus</button>
                                            </form>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                            @else
                                <div class="alert alert-info">
                                    Belum ada widget di posisi Sidebar Kanan.
                                </div>
                            @endif
                        </div>

                        <!-- Footer Widgets Tab -->
                        <div class="tab-pane fade" id="footer-widgets" role="tabpanel" aria-labelledby="footer-widgets-tab">
                            @if(isset($footerWidgets) && $footerWidgets->count() > 0)
                                <div class="list-group" id="footer-widgets-list">
                                    @foreach($footerWidgets as $widget)
                                    <div class="list-group-item" data-widget-id="{{ $widget->id }}">
                                        <div class="d-flex w-100 justify-content-between">
                                            <div>
                                                <h5 class="mb-1">{{ $widget->name }}</h5>
                                                <small class="text-muted">Order: {{ $widget->order }}</small>
                                            </div>
                                            <div>
                                                <span class="badge badge-{{ $widget->type === 'plugin' ? 'info' : ($widget->type === 'text' ? 'warning' : 'success') }}">
                                                    {{ ucfirst($widget->type) }}
                                                </span>
                                                <span class="badge {{ $widget->status === 'aktif' ? 'badge-success' : 'badge-danger' }}">
                                                    {{ $widget->status }}
                                                </span>
                                            </div>
                                        </div>
                                        <p class="mb-1">{{ Str::limit(strip_tags($widget->content ?? ''), 80, '...') }}</p>
                                        <small class="text-muted">{{ $widget->plugin_name ?: 'Tidak ada plugin' }}</small>
                                        <div class="mt-2">
                                            <a href="{{ route('panel.widgets.show', $widget->id) }}" class="btn btn-sm btn-info">Lihat</a>
                                            <a href="{{ route('panel.widgets.edit', $widget->id) }}" class="btn btn-sm btn-primary">Edit</a>
                                            <form action="{{ route('panel.widgets.destroy', $widget->id) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Yakin ingin menghapus widget ini?')">Hapus</button>
                                            </form>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                            @else
                                <div class="alert alert-info">
                                    Belum ada widget di posisi Footer.
                                </div>
                            @endif
                        </div>

                        <!-- Home Widgets Tab -->
                        <div class="tab-pane fade" id="home-widgets" role="tabpanel" aria-labelledby="home-widgets-tab">
                            @if(isset($homeWidgets) && $homeWidgets->count() > 0)
                                <div class="list-group" id="home-widgets-list">
                                    @foreach($homeWidgets as $widget)
                                    <div class="list-group-item" data-widget-id="{{ $widget->id }}">
                                        <div class="d-flex w-100 justify-content-between">
                                            <div>
                                                <h5 class="mb-1">{{ $widget->name }}</h5>
                                                <small class="text-muted">Order: {{ $widget->order }}</small>
                                            </div>
                                            <div>
                                                <span class="badge badge-{{ $widget->type === 'plugin' ? 'info' : ($widget->type === 'text' ? 'warning' : 'success') }}">
                                                    {{ ucfirst($widget->type) }}
                                                </span>
                                                <span class="badge {{ $widget->status === 'aktif' ? 'badge-success' : 'badge-danger' }}">
                                                    {{ $widget->status }}
                                                </span>
                                            </div>
                                        </div>
                                        <p class="mb-1">{{ Str::limit(strip_tags($widget->content ?? ''), 80, '...') }}</p>
                                        <small class="text-muted">{{ $widget->plugin_name ?: 'Tidak ada plugin' }}</small>
                                        <div class="mt-2">
                                            <a href="{{ route('panel.widgets.show', $widget->id) }}" class="btn btn-sm btn-info">Lihat</a>
                                            <a href="{{ route('panel.widgets.edit', $widget->id) }}" class="btn btn-sm btn-primary">Edit</a>
                                            <form action="{{ route('panel.widgets.destroy', $widget->id) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Yakin ingin menghapus widget ini?')">Hapus</button>
                                            </form>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                            @else
                                <div class="alert alert-info">
                                    Belum ada widget di posisi Home.
                                </div>
                            @endif
                        </div>
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
document.addEventListener('DOMContentLoaded', function() {
    // Enable sortable for each widget list - header, sidebar-left, sidebar-right, footer, home
    $('#header-widgets-list').sortable({
        placeholder: 'ui-sortable-placeholder',
        cursor: 'move',
        opacity: 0.7,
        update: function(event, ui) {
            updateWidgetOrder('header');
        }
    });
    
    $('#sidebar-left-widgets-list').sortable({
        placeholder: 'ui-sortable-placeholder',
        cursor: 'move',
        opacity: 0.7,
        update: function(event, ui) {
            updateWidgetOrder('sidebar-left');
        }
    });
    
    $('#sidebar-right-widgets-list').sortable({
        placeholder: 'ui-sortable-placeholder',
        cursor: 'move',
        opacity: 0.7,
        update: function(event, ui) {
            updateWidgetOrder('sidebar-right');
        }
    });
    
    $('#footer-widgets-list').sortable({
        placeholder: 'ui-sortable-placeholder',
        cursor: 'move',
        opacity: 0.7,
        update: function(event, ui) {
            updateWidgetOrder('footer');
        }
    });
    
    $('#home-widgets-list').sortable({
        placeholder: 'ui-sortable-placeholder',
        cursor: 'move',
        opacity: 0.7,
        update: function(event, ui) {
            updateWidgetOrder('home');
        }
    });

    // Function to update widget order via AJAX
    function updateWidgetOrder(position) {
        const widgetIds = [];
        
        // Ambil semua widget ID dari container yang sesuai
        switch(position) {
            case 'header':
                $('#header-widgets-list').find('[data-widget-id]').each(function(index) {
                    widgetIds.push({
                        id: $(this).data('widget-id'),
                        order: index + 1
                    });
                });
                break;
            case 'sidebar-left':
                $('#sidebar-left-widgets-list').find('[data-widget-id]').each(function(index) {
                    widgetIds.push({
                        id: $(this).data('widget-id'),
                        order: index + 1
                    });
                });
                break;
            case 'sidebar-right':
                $('#sidebar-right-widgets-list').find('[data-widget-id]').each(function(index) {
                    widgetIds.push({
                        id: $(this).data('widget-id'),
                        order: index + 1
                    });
                });
                break;
            case 'footer':
                $('#footer-widgets-list').find('[data-widget-id]').each(function(index) {
                    widgetIds.push({
                        id: $(this).data('widget-id'),
                        order: index + 1
                    });
                });
                break;
            case 'home':
                $('#home-widgets-list').find('[data-widget-id]').each(function(index) {
                    widgetIds.push({
                        id: $(this).data('widget-id'),
                        order: index + 1
                    });
                });
                break;
        }
        
        if (widgetIds.length > 0) {
            $.ajax({
                url: '{{ route("panel.widgets.update-order") }}',
                method: 'POST',
                data: {
                    _token: $('meta[name="csrf-token"]').attr('content'),
                    position: position,
                    widget_ids: widgetIds
                },
                success: function(response) {
                    console.log('Order updated successfully for ' + position);
                    // Tampilkan pesan sukses ke pengguna
                    showSuccessMessage('Urutan widget di posisi ' + capitalizeFirstLetter(position.replace('-', ' ')) + ' berhasil diperbarui.');
                },
                error: function(xhr, status, error) {
                    console.error('Error updating order for ' + position + ':', error);
                    showErrorMessage('Gagal memperbarui urutan widget di posisi ' + capitalizeFirstLetter(position.replace('-', ' ')));
                }
            });
        }
    }
    
    // Helper function to show success message
    function showSuccessMessage(message) {
        // Tambahkan elemen pesan jika belum ada
        if ($('#flash-message').length === 0) {
            $('body').append('<div id="flash-message" class="position-fixed top-0 right-0 p-3" style="z-index: 9999; right: 10px; top: 10px;"></div>');
        }
        
        $('#flash-message').html(`
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                ${message}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        `);
        
        // Hilangkan pesan setelah 5 detik
        setTimeout(function() {
            $('#flash-message').fadeOut();
        }, 5000);
    }
    
    // Helper function to show error message
    function showErrorMessage(message) {
        // Tambahkan elemen pesan jika belum ada
        if ($('#flash-message').length === 0) {
            $('body').append('<div id="flash-message" class="position-fixed top-0 right-0 p-3" style="z-index: 9999; right: 10px; top: 10px;"></div>');
        }
        
        $('#flash-message').html(`
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                ${message}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        `);
        
        // Hilangkan pesan setelah 5 detik
        setTimeout(function() {
            $('#flash-message').fadeOut();
        }, 5000);
    }
    
    // Helper function to capitalize first letter
    function capitalizeFirstLetter(string) {
        return string.charAt(0).toUpperCase() + string.slice(1);
    }
});
</script>

<style>
    .ui-sortable-placeholder {
        height: 50px;
        background: #f39c12 !important;
        border: 1px dashed #ccc !important;
        visibility: visible !important;
        margin-bottom: 10px;
        border-radius: 5px;
    }
    
    .list-group-item {
        cursor: move;
        transition: all 0.2s ease;
        border: 1px solid #e2e8f0;
        border-radius: 0.5rem;
        margin-bottom: 0.5rem;
    }
    
    .list-group-item:hover {
        background-color: #f8f9fa;
        transform: translateX(2px);
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }
    
    /* Tab styling */
    .nav-tabs .nav-link.active {
        background-color: #f8f9fa;
        border-bottom: 1px solid transparent;
    }
    
    /* Badge styling */
    .badge {
        font-size: 0.75em;
    }
    
    /* Card styling */
    .card {
        box-shadow: 0 1px 3px rgba(0,0,0,0.12), 0 1px 2px rgba(0,0,0,0.24);
        transition: all 0.2s ease;
    }
    
    .card:hover {
        box-shadow: 0 3px 6px rgba(0,0,0,0.16), 0 3px 6px rgba(0,0,0,0.23);
    }
</style>
@endsection