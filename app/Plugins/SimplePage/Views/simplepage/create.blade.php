@extends('theme.admin.adminlte::layouts.app')

@section('title', 'Create Page - Simple Page - ' . cms_name())
@section('page_title', 'Create New Page')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Create New Page</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <form action="{{ route('simplepage.store') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="title">Title</label>
                            <input type="text" class="form-control" id="title" name="title" required>
                        </div>
                        <div class="form-group">
                            <label for="content">Content</label>
                            <textarea class="form-control" id="content" name="content" rows="5" required></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">Save Page</button>
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