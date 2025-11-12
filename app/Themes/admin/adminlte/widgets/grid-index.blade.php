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
                                            <span class="badge badge-primary">{{ $headerWidgets->count() }} widgets</span>
                                        </div>
                                        <div id="header-widgets-container" class="position-widgets-container" data-position="header">
                                            @if($headerWidgets->count() > 0)
                                                @foreach($headerWidgets as $widget)
                                                <div class="position-widget card mb-2" data-id="{{ $widget->id }}">
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
                                                                    <small>Order: {{ $widget->order }}</small>
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
                                                <div class="alert alert-secondary text-center mb-0">
                                                    Tidak ada widget di posisi Header
                                                </div>
                                            @endif
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
                                            <span class="badge badge-primary">{{ $sidebarLeftWidgets->count() }} widgets</span>
                                        </div>
                                        <div id="sidebar-left-widgets-container" class="position-widgets-container" data-position="sidebar-left">
                                            @if($sidebarLeftWidgets->count() > 0)
                                                @foreach($sidebarLeftWidgets as $widget)
                                                <div class="position-widget card mb-2" data-id="{{ $widget->id }}">
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
                                                                    <small>Order: {{ $widget->order }}</small>
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
                                                <div class="alert alert-secondary text-center mb-0">
                                                    Tidak ada widget di posisi Sidebar Kiri
                                                </div>
                                            @endif
                                        </div>
                                    </td>
                                    
                                    <!-- Home -->
                                    <td class="position-home bg-gray-light">
                                        <div class="d-flex justify-content-between align-items-center mb-2">
                                            <h4 class="position-title mb-0">
                                                <i class="fas fa-home"></i> Home
                                            </h4>
                                            <span class="badge badge-primary">{{ $homeWidgets->count() }} widgets</span>
                                        </div>
                                        <div id="home-widgets-container" class="position-widgets-container" data-position="home">
                                            @if($homeWidgets->count() > 0)
                                                @foreach($homeWidgets as $widget)
                                                <div class="position-widget card mb-2" data-id="{{ $widget->id }}">
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
                                                                    <small>Order: {{ $widget->order }}</small>
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
                                                <div class="alert alert-secondary text-center mb-0">
                                                    Tidak ada widget di posisi Home
                                                </div>
                                            @endif
                                        </div>
                                    </td>
                                    
                                    <!-- Sidebar Right -->
                                    <td class="position-sidebar-right bg-gray-light">
                                        <div class="d-flex justify-content-between align-items-center mb-2">
                                            <h4 class="position-title mb-0">
                                                <i class="fas fa-align-right"></i> Sidebar Kanan
                                            </h4>
                                            <span class="badge badge-primary">{{ $sidebarRightWidgets->count() }} widgets</span>
                                        </div>
                                        <div id="sidebar-right-widgets-container" class="position-widgets-container" data-position="sidebar-right">
                                            @if($sidebarRightWidgets->count() > 0)
                                                @foreach($sidebarRightWidgets as $widget)
                                                <div class="position-widget card mb-2" data-id="{{ $widget->id }}">
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
                                                                    <small>Order: {{ $widget->order }}</small>
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
                                                <div class="alert alert-secondary text-center mb-0">
                                                    Tidak ada widget di posisi Sidebar Kanan
                                                </div>
                                            @endif
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
                                            <span class="badge badge-primary">{{ $footerWidgets->count() }} widgets</span>
                                        </div>
                                        <div id="footer-widgets-container" class="position-widgets-container" data-position="footer">
                                            @if($footerWidgets->count() > 0)
                                                @foreach($footerWidgets as $widget)
                                                <div class="position-widget card mb-2" data-id="{{ $widget->id }}">
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
                                                                    <small>Order: {{ $widget->order }}</small>
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
                                                <div class="alert alert-secondary text-center mb-0">
                                                    Tidak ada widget di posisi Footer
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

<script src="https://code.jquery.com/ui/1.13.2/jquery-ui.min.js"></script>
<link rel="stylesheet" href="https://code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Enable sortable untuk setiap container posisi
    $('.position-widgets-container').each(function() {
        const $container = $(this);
        const position = $container.data('position');
        
        $container.sortable({
            animation: 150,
            ghostClass: 'bg-light',
            dragClass: 'sortable-drag',
            onSort: function(evt) {
                updateWidgetOrder(position);
            },
            onUpdate: function(evt) {
                updateWidgetOrder(position);
            },
            onEnd: function(evt) {
                updateWidgetOrder(position);
            }
        });
    });
    
    // Fungsi untuk memperbarui urutan widget via AJAX
    function updateWidgetOrder(position) {
        const widgetIds = [];
        $(`div[data-position="${position}"]`).find('.position-widget').each(function(index) {
            widgetIds.push({
                id: $(this).data('id'),
                order: index + 1
            });
        });
        
        if (widgetIds.length > 0) {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            
            $.ajax({
                url: '{{ route("panel.widgets.update-order") }}',
                method: 'POST',
                data: {
                    position: position,
                    widget_ids: widgetIds
                },
                success: function(response) {
                    console.log('Order updated successfully for ' + position + ':', response);
                    
                    // Update order numbers in the UI for this position
                    $(`div[data-position="${position}"]`).find('.position-widget').each(function(index) {
                        $(this).find('small:last').text('Order: ' + (index + 1));
                    });
                },
                error: function(xhr, status, error) {
                    console.error('Error updating order for ' + position + ':', error);
                    alert('Gagal memperbarui urutan widget. Silakan coba lagi.');
                    
                    // Reload page to revert changes in case of error
                    location.reload();
                }
            });
        }
    }
});
</script>
@endsection