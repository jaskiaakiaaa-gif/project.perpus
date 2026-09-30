<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Buku extends Model
{
    //

    use HasFactory;
    
    protected $table = 'buku';

    protected $fillable = [
        'isbn',
        'foto_buku',
        'nama_buku',
        'stok',
        'kategori_id',
    ];

    public function  kategori(): BelongsTo
    {
        return $this->belongsTo(Kategori::class, 'kategori_id');
    }

    public function peminjaman(): HasMany
    {
        return $this->hasMany(Peminjaman::class, 'buku_id');
    }

    public function member(): BelongsToMany
    {
        return $this->belongsToMany(Member::class, 'peminjaman', 'member_id', 'buku_id')->withPivot('tanggal_pinjam', 'tanggal_kembali', 'status')->withTimestamps;
    }
}
