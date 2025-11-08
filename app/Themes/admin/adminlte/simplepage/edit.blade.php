@extends('theme.admin.adminlte::layouts.app')

@section('title', 'Edit Simple Page - Simple Page Management - ' . cms_name())
@section('page_title', 'Edit Simple Page')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Edit Simple Page</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <form action="{{ route('simplepage.update', $id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <label for="title">Page Title</label>
                            <input type="text" class="form-control" id="title" name="title" placeholder="Enter page title" required>
                        </div>
                        <div class="form-group">
                            <label for="content">Content</label>
                            <textarea class="form-control" id="content" name="content" rows="10" placeholder="Enter page content" required></textarea>
                        </div>
                        <div class="form-group">
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" id="is_active" name="is_active" value="1" checked>
                                <label class="form-check-label" for="is_active">Active</label>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary">Update Page</button>
                        <a href="{{ route('simplepage.index') }}" class="btn btn-secondary">Cancel</a>
                    </form>
                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->
        </div>
    </div>
</div>
@endsection