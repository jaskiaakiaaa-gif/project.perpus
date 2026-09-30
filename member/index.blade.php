@extends('layouts.app')

@section('title', 'Member')

@section('content')
<div class="card shadow-sm">
    <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
        <h5 class="mb-0 fw-bold text-primary"><i class="bi bi-tags me-2"></i>Daftar Data Member</h5>
        <a href="{{ route('member.create') }}" class="btn btn-primary btn-sm rounded-pill px-3">
            <i class="bi bi-plus-lg me-1"></i> Tambah Member
        </a>
    </div>
    
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th class="ps-4">No</th>
                        <th>Nama Member</th>
                        <th>Foto Member</th>
                        <th>Email</th>
                        <th>Jenis Kelamin</th>
                        <th>Tanggal Lahir</th>
                        <th>No Telepon</th>
                        <th>Nama Buku</th>
                        <th class="text-center">Status</th> <!-- TAMBAHAN KOLOM STATUS -->
                        <th class="text-center" width="160">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($member as $index => $g)
                    <tr>
                        <td class="ps-4 text-muted">{{ $index + 1 }}</td>
                        <td>
                            <div class="d-flex align-items-center">
                                <div class="avatar-sm bg-primary text-white rounded-circle me-2 d-flex align-items-center justify-content-center" style="width:34px; height:34px; font-size:13px; font-weight:bold;">
                                    {{ strtoupper(substr($g->nama_member, 0, 1)) }}
                                </div>
                                <span class="fw-semibold">{{ $g->nama_member }}</span>
                            </div>
                        </td>
                        <td class="text-center">
                            @if($g->foto_member)
                                <img src="{{ Storage::url($g->foto_member) }}" alt="Cover" class="rounded shadow-sm border" style="width: 45px; height: 55px; object-fit: cover;">
                            @else
                                <div class="bg-light text-secondary rounded border d-inline-flex align-items-center justify-content-center mx-auto" style="width: 45px; height: 55px;">
                                    <i class="bi bi-book fs-4"></i>
                                </div>
                            @endif
                        </td>
                        <td>
                            <span class="text-dark">{{ $g->email ?? '-' }}</span>
                        </td>
                        <td>
                            @if($g->jenis_kelamin == 'Pria')
                                <span class="badge bg-primary-subtle text-primary"><i class="bi bi-gender-male me-1"></i>Pria</span>
                            @else
                                <span class="badge bg-danger-subtle text-danger"><i class="bi bi-gender-female me-1"></i>Wanita</span>
                            @endif
                        </td>
                        <td>{{ \Carbon\Carbon::parse($g->tanggal_lahir)->format('d M Y') }}</td>
                        <td>
                            <span class="text-dark">{{ $g->no_telepon ?? '-' }}</span>
                        </td>
                        <td>
                            <div class="d-flex align-items-center">
                                <div class="avatar-sm bg-primary text-white rounded-circle me-2 d-flex align-items-center justify-content-center" style="width:34px; height:34px; font-size:13px; font-weight:bold;">
                                    {{ strtoupper(substr($g->nama_buku, 0, 1)) }}
                                </div>
                                <span class="fw-semibold">{{ $g->nama_buku }}</span>
                            </div>
                        </td>

                        <!-- BADGE STATUS -->
                        <td class="text-center">
                            @if($g->status == 'Dipinjam')
                                <span class="badge bg-warning text-dark">Dipinjam</span>
                            @else
                                <span class="badge bg-success">Dikembalikan</span>
                            @endif
                        </td>

                        <!-- AKSI & TOMBOL KEMBALIKAN -->
                        <td class="text-center">
                            @if($g->status == 'Dipinjam')
                                <form action="{{ route('member.kembalikan', $g->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('PUT')
                                    <button type="submit" class="btn btn-outline-success btn-sm me-1" onclick="return confirm('Kembalikan buku ini? Stok buku akan otomatis bertambah 1.')" title="Kembalikan Buku">
                                        <i class="bi bi-box-arrow-in-left"></i>
                                    </button>
                                </form>
                            @endif
                            <a href="{{ route('member.edit', $g->id) }}" class="btn btn-outline-warning btn-sm me-1" title="Edit">
                                <i class="bi bi-pencil-square"></i>
                            </a>
                            <form action="{{ route('member.destroy', $g->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-outline-danger btn-sm" onclick="return confirm('Apakah Anda yakin ingin menghapus data Member ini?')" title="Hapus">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="10" class="text-center py-4 text-muted">
                            <i class="bi bi-inbox fs-3 d-block mb-2 text-secondary"></i>
                            Belum ada data member.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection