@extends('theme.admin.adminlte::layouts.app')

@section('title', 'Simple Page Management - ' . cms_name())
@section('page_title', 'Simple Page Management')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Simple Page Management</h3>
                    
                    <div class="card-tools">
                        <a href="{{ route('simplepage.create') }}" class="btn btn-sm btn-primary">
                            <i class="fas fa-plus"></i> Create New Page
                        </a>
                    </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <p>Welcome to Simple Page management.</p>
                    <p>Here you can create and manage simple pages.</p>
                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->
        </div>
    </div>
</div>
@endsection