@extends('theme.admin.adminlte::layouts.app')

@section('title', 'Tambah Pengaturan - ' . cms_name())
@section('page_title', 'Tambah Pengaturan')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Form Tambah Pengaturan</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <form action="{{ route('setting.store') }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="pengaturan">Nama Pengaturan *</label>
                                    <input type="text" class="form-control @error('pengaturan') is-invalid @enderror" 
                                           id="pengaturan" name="pengaturan" value="{{ old('pengaturan') }}" required>
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
                                        <option value="aktif" {{ old('status', 'aktif') == 'aktif' ? 'selected' : '' }}>Aktif</option>
                                        <option value="nonaktif" {{ old('status') == 'nonaktif' ? 'selected' : '' }}>Nonaktif</option>
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
                                              id="nilai" name="nilai" rows="5" required>{{ old('nilai') }}</textarea>
                                    @error('nilai')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                    <small class="form-text text-muted">Masukkan nilai untuk pengaturan ini</small>
                                </div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-12">
                                <button type="submit" class="btn btn-success float-right">
                                    <i class="fas fa-save"></i> Simpan Pengaturan
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