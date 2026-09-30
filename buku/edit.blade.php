@extends('layouts.app')

@section('title', 'Edit Data Buku')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card shadow-sm border-0">
            <div class="card-header bg-white py-3">
                <h5 class="mb-0 fw-bold text-warning"><i class="bi bi-pencil-square me-2"></i>Edit Data Buku</h5>
            </div>
            <div class="card-body p-4">
                <form action="{{ route('buku.update', $buku->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="row g-3">
                        <!-- ISBN -->
                        <div class="col-md-6">
                            <label class="form-label fw-semibold text-dark">ISBN <span class="text-danger">*</span></label>
                            <input type="text" 
                                   name="isbn" 
                                   class="form-control text-dark @error('isbn') is-invalid @enderror" 
                                   value="{{ old('isbn', $buku->isbn) }}" 
                                   placeholder="Masukkan nomor ISBN"
                                   required>
                            @error('isbn')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <!-- Nama Buku -->
                        <div class="col-md-6">
                            <label class="form-label fw-semibold text-dark">Nama Buku <span class="text-danger">*</span></label>
                            <input type="text" 
                                   name="nama_buku" 
                                   class="form-control text-dark @error('nama_buku') is-invalid @enderror" 
                                   value="{{ old('nama_buku', $buku->nama_buku) }}" 
                                   placeholder="Contoh: One Piece" 
                                   required>
                            @error('nama_buku')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <!-- Kategori -->
                        <div class="col-md-6">
                            <label class="form-label fw-semibold text-dark">Kategori <span class="text-danger">*</span></label>
                            <select name="kategori_id" class="form-select text-dark @error('kategori_id') is-invalid @enderror" required>
                                <option value="" class="text-muted">-- Pilih Kategori --</option>
                                @foreach($kategori as $item)
                                    <option value="{{ $item->id }}" {{ old('kategori_id', $buku->kategori_id) == $item->id ? 'selected' : '' }}>
                                        {{ $item->nama_kategori }}
                                    </option>
                                @endforeach
                            </select>
                            @error('kategori_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Jumlah Stok -->
                        <div class="col-md-6">
                            <label class="form-label fw-semibold text-dark">Jumlah Stok <span class="text-danger">*</span></label>
                            <input type="number" 
                                   name="stok" 
                                   class="form-control text-dark @error('stok') is-invalid @enderror" 
                                   value="{{ old('stok', $buku->stok) }}" 
                                   min="0" 
                                   required>
                            @error('stok')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Foto Buku -->
                        <div class="col-12">
                            <label class="form-label fw-semibold text-dark">Foto Buku</label>
                            
                            {{-- Pratinjau Foto Lama --}}
                            @if($buku->foto_buku && Storage::disk('public')->exists($buku->foto_buku))
                                <div class="mb-2">
                                    <img src="{{ asset('storage/' . $buku->foto_buku) }}" alt="Foto Saat Ini" class="img-thumbnail rounded" style="max-height: 120px;">
                                    <div class="form-text text-muted">Foto saat ini. Biarkan kosong jika tidak ingin mengganti.</div>
                                </div>
                            @endif

                            <input type="file" name="foto_buku" class="form-control text-dark @error('foto_buku') is-invalid @enderror" accept="image/*">
                            <div class="form-text text-muted">Format: JPG, PNG, JPEG.</div>
                            @error('foto_buku')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Tombol Aksi -->
                    <div class="d-flex justify-content-between pt-3 border-top mt-4">
                        <a href="{{ route('buku.index') }}" class="btn btn-light px-4">Batal</a>
                        <button type="submit" class="btn btn-warning text-white px-4">
                            <i class="bi bi-save me-1"></i> Perbarui Data
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection