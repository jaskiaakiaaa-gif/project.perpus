@extends('layouts.app')

@section('title', 'Edit Data Member')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card shadow-sm border-0">
            <div class="card-header bg-white py-3">
                <h5 class="mb-0 fw-bold text-warning"><i class="bi bi-pencil-square me-2"></i>Edit Data Member</h5>
            </div>
            <div class="card-body p-4">
                <form action="{{ route('member.update', $member->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="row g-3">
                    <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold">Nama Member <span class="text-danger">*</span></label>
                            <input type="text" 
                                   name="nama_member" 
                                   class="form-control @error('nama_member') is-invalid @enderror" 
                                   value="{{ old('nama_member', $member->nama_member) }}"
                                   placeholder="Contoh: Axel Rayan Mahardika" 
                                   required>
                            @error('nama_member')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-semibold text-dark">Foto Member</label>
                            <input type="file" name="foto_member" class="form-control text-dark @error('foto_member') is-invalid @enderror" accept="image/*">
                            <div class="form-text text-muted">Format: JPG, PNG, JPEG.</div>
                            @error('foto_member')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold">Email <span class="text-danger">*</span></label>
                            <input type="email" 
                                   name="email" 
                                   class="form-control @error('email') is-invalid @enderror" 
                                   value="{{ old('email', $member->email) }}" 
                                   placeholder="Masukan email"
                                   required>
                            @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold">Jenis Kelamin <span class="text-danger">*</span></label>
                            <select name="jenis_kelamin" class="form-select @error('jenis_kelamin') is-invalid @enderror" required>
                                <option value="">-- Pilih Jenis Kelamin --</option>
                                <option value="Pria" {{ old('jenis_kelamin', $member->jenis_kelamin) == 'Pria' ? 'selected' : '' }}>Pria</option>
                                <option value="Wanita" {{ old('jenis_kelamin', $member->jenis_kelamin) == 'Wanita' ? 'selected' : '' }}>Wanita</option>
                            </select>
                            @error('jenis_kelamin')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold">Tanggal Lahir <span class="text-danger">*</span></label>
                            <input type="date" 
                                   name="tanggal_lahir" 
                                   class="form-control @error('tanggal_lahir') is-invalid @enderror" 
                                   value="{{ old('tanggal_lahir', $member->tanggal_lahir) }}"                                   placeholder="Masukan Tanggal"
                                   required>
                            @error('tanggal_lahir')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold">No. Telepon <span class="text-danger">*</span></label>
                            <input type="text" 
                                   name="no_telepon" 
                                   class="form-control @error('no_telepon') is-invalid @enderror" 
                                   value="{{ old('no_telepon', $member->no_telepon) }}"                                   placeholder="Masukan No. Telepon"
                                   required>
                            @error('no_telepon')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-semibold">Nama Buku <span class="text-danger">*</span></label>
                        
                        @if($member->status == 'Dikembalikan')
                            <!-- Jika sudah dikembalikan, kunci pilihan buku -->
                            <input type="text" class="form-control" value="{{ $member->nama_buku }}" readonly disabled>
                            <input type="hidden" name="nama_buku" value="{{ $member->nama_buku }}">
                            <small class="text-muted">*Buku tidak dapat diubah karena status sudah dikembalikan.</small>
                        @else
                            <!-- Jika masih dipinjam, buku masih bisa diganti -->
                            <select name="nama_buku" class="form-select @error('nama_buku') is-invalid @enderror" required>
                                <option value="" class="text-muted">-- Pilih Buku --</option>
                                @foreach($buku as $b)
                                    @if($b->stok > 0 || $member->nama_buku == $b->nama_buku)
                                        <option value="{{ $b->nama_buku }}" {{ old('nama_buku', $member->nama_buku) == $b->nama_buku ? 'selected' : '' }}>
                                            {{ $b->nama_buku }}
                                        </option>
                                    @endif
                                @endforeach
                            </select>
                            @error('nama_buku')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        @endif
                    </div>
                    <!-- Tombol Aksi -->
                    <div class="d-flex justify-content-between pt-3 border-top mt-4">
                        <a href="{{ route('member.index') }}" class="btn btn-light px-4">Batal</a>
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