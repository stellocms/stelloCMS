@extends('theme.admin.adminlte::layouts.app')

@section('title', 'Edit Pengaturan - ' . cms_name())
@section('page_title', 'Edit Pengaturan')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Form Edit Pengaturan: {{ $setting->pengaturan }}</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <form action="{{ route('setting.update', $setting->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="pengaturan">Nama Pengaturan *</label>
                                    <input type="text" class="form-control @error('pengaturan') is-invalid @enderror" 
                                           id="pengaturan" name="pengaturan" 
                                           value="{{ old('pengaturan', $setting->pengaturan) }}" required>
                                    @error('pengaturan')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                    <small class="form-text text-muted">Contoh: nama-web, judul-beranda, dll</small>
                                </div>
                                
                                <div class="form-group">
                                    <label for="status">Status *</label>
                                    <select class="form-control @error('status') is-invalid @enderror" 
                                            id="status" name="status" required>
                                        <option value="aktif" {{ old('status', $setting->status) == 'aktif' ? 'selected' : '' }}>Aktif</option>
                                        <option value="nonaktif" {{ old('status', $setting->status) == 'nonaktif' ? 'selected' : '' }}>Nonaktif</option>
                                    </select>
                                    @error('status')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="nilai">Nilai Pengaturan *</label>
                                    <textarea class="form-control @error('nilai') is-invalid @enderror" 
                                              id="nilai" name="nilai" rows="5" required>{{ old('nilai', $setting->nilai) }}</textarea>
                                    @error('nilai')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                    <small class="form-text text-muted">Ubah nilai untuk pengaturan ini</small>
                                </div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-12">
                                <button type="submit" class="btn btn-primary float-right">
                                    <i class="fas fa-save"></i> Update Pengaturan
                                </button>
                                <a href="{{ route('setting.index') }}" class="btn btn-secondary float-left">
                                    <i class="fas fa-arrow-left"></i> Kembali
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->
        </div>
    </div>
</div>
@endsection