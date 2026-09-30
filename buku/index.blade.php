@extends('layouts.app')

@section('title', 'Daftar Buku')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-11">
    

        <div class="card border-0 shadow-sm rounded-3">
            <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center border-bottom">
                <h5 class="mb-0 fw-bold text-primary">
                    <i class="bi bi-book-fill me-2"></i>Daftar Data Buku
                </h5>
                <a href="{{ route('buku.create') }}" class="btn btn-primary btn-sm rounded-pill px-3 shadow-sm">
                    <i class="bi bi-plus-lg me-1"></i> Tambah Buku
                </a>
            </div>

            @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm mb-3" role="alert">
                <i class="bi bi-exclamation-triangle-fill me-2"></i>{{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th class="text-center" style="width: 5%;">No</th>
                                <th style="width: 15%;">ISBN</th>
                                <th class="text-center" style="width: 10%;">Foto Buku</th>
                                <th style="width: 25%;">Nama Buku</th>
                                <th class="text-center" style="width: 10%;">Stok</th>
                                <th style="width: 20%;">Kategori Buku</th>
                                <th class="text-center" style="width: 15%;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($buku as $index => $b)
                            <tr>
                                <td class="text-center text-muted fw-bold">{{ $index + 1 }}</td>
                                <td><code class="text-dark fw-bold">{{ $b->isbn }}</code></td>
                                <td class="text-center">
                                    @if($b->foto_buku)
                                    <img src="{{ Storage::url($b->foto_buku) }}" alt="Cover" class="rounded shadow-sm border" style="width: 45px; height: 55px; object-fit: cover;">
                                    @else
                                        <div class="bg-light text-secondary rounded border d-inline-flex align-items-center justify-content-center mx-auto" style="width: 45px; height: 55px;">
                                            <i class="bi bi-book fs-4"></i>
                                        </div>
                                    @endif
                                </td>
                                <td><span class="fw-bold text-dark">{{ $b->nama_buku }}</span></td>
                                
                                <!-- STOK TEKS JELAS -->
                                <td class="text-center">
                                    <span class="badge bg-success-subtle text-success border border-success fw-bold px-3 py-2">
                                        {{ $b->stok }}
                                    </span>
                                </td>

                                <!-- KATEGORI TEKS JELAS -->
                                <td>
                                    <span class="badge bg-info-subtle text-dark border border-info fw-bold px-3 py-2">
                                        {{ $b->kategori->nama_kategori ?? '-' }}
                                    </span>
                                </td>

                                <td class="text-center">
                                    <div class="d-inline-flex gap-1">
                                        <a href="{{ route('buku.edit', $b->id) }}" class="btn btn-sm btn-outline-warning" title="Edit">
                                            <i class="bi bi-pencil-square"></i>
                                        </a>
                                        <form action="{{ route('buku.destroy', $b->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus buku ini?')" title="Hapus">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="7" class="text-center py-5 text-muted">
                                    <i class="bi bi-inbox fs-1 d-block mb-2 text-secondary"></i>
                                    Belum ada data buku.
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection