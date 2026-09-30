@extends('layouts.app')

@section('title', 'Tambah Data Buku')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card border-0 shadow-sm rounded-3">
            <div class="card-header bg-white py-3 border-bottom">
                <h5 class="mb-0 fw-bold text-primary">
                    <i class="bi bi-book me-2"></i>Tambah Data Buku
                </h5>
            </div>
            <div class="card-body p-4 text-dark">
                <form action="{{ route('buku.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    
                    <div class="row g-3">
                       
                        <div class="col-md-6">
                            <label class="form-label fw-semibold text-dark">ISBN <span class="text-danger">*</span></label>
                            <input type="text" 
                                   name="isbn" 
                                   class="form-control text-dark @error('isbn') is-invalid @enderror" 
                                   value="{{ old('isbn') }}" 
                                   placeholder="Masukkan nomor ISBN"
                                   required>
                            @error('isbn')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                         <div class="col-12">
                            <label class="form-label fw-semibold text-dark">Foto Buku</label>
                            <input type="file" name="foto_buku" class="form-control text-dark @error('foto_buku') is-invalid @enderror" accept="image/*">
                            <div class="form-text text-muted">Format: JPG, PNG, JPEG.</div>
                            @error('foto_buku')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                        <div class="col-md-6">
                            <label class="form-label fw-semibold text-dark">Nama Buku <span class="text-danger">*</span></label>
                            <input type="text" 
                                   name="nama_buku" 
                                   class="form-control text-dark @error('nama_buku') is-invalid @enderror" 
                                   value="{{ old('nama_buku') }}" 
                                   placeholder="Contoh: One Piece" 
                                   required>
                            @error('nama_buku')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                       
                        <div class="col-md-6">
                            <label class="form-label fw-semibold text-dark">Kategori <span class="text-danger">*</span></label>
                            <select name="kategori_id" class="form-select text-dark @error('kategori_id') is-invalid @enderror" required>
                                <option value="" class="text-muted">-- Pilih Kategori --</option>
                                @foreach($kategori as $g)
                                    <option value="{{ $g->id }}" {{ old('kategori_id') == $g->id ? 'selected' : '' }}>
                                        {{ $g->nama_kategori }}
                                    </option>
                                @endforeach
                            </select>
                            @error('kategori_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                     
                        <div class="col-md-6">
                            <label class="form-label fw-semibold text-dark">Jumlah Stok <span class="text-danger">*</span></label>
                            <input type="number" 
                                   name="stok" 
                                   class="form-control text-dark @error('stok') is-invalid @enderror" 
                                   value="{{ old('stok', 1) }}" 
                                   min="0" 
                                   required>
                            @error('stok')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                
                    <!-- Tombol Aksi -->
                    <div class="d-flex justify-content-between pt-3 border-top mt-4">
                        <a href="{{ route('buku.index') }}" class="btn btn-light px-4 border text-dark">Batal</a>
                        <button type="submit" class="btn btn-primary px-4"><i class="bi bi-save me-1"></i> Simpan Data</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection