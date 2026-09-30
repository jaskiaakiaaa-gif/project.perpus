@extends('layouts.app')

@section('title', 'Tambah Data Kategori')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card shadow-sm">
            <div class="card-header bg-white py-3">
                <h5 class="mb-0 fw-bold text-primary"><i class="bi bi-person-plus me-2"></i>Tambah Data Kategori</h5>
            </div>
            <div class="card-body p-4">
                <form action="{{ route('kategori.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    
                    <div class="row">
                    <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold">Nama Kategori <span class="text-danger">*</span></label>
                            <input type="text" 
                                   name="nama_kategori" 
                                   class="form-control @error('nama_kategori') is-invalid @enderror" 
                                   value="{{ old('nama_kategori') }}" 
                                   placeholder="Contoh: Fiksi" 
                                   required>
                            @error('nama_kategori')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    <!-- Tombol Aksi -->
                    <div class="d-flex justify-content-between pt-3 border-top mt-3">
                        <a href="{{ route('kategori.index') }}" class="btn btn-light px-4">Batal</a>
                        <button type="submit" class="btn btn-primary px-4"><i class="bi bi-save me-1"></i> Simpan Data</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection