<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Member extends Model
{
    //

    use HasFactory;
    
    protected $table = 'member';

    protected $fillable = [
      'nama_member',
      'foto_member',
      'email',
      'jenis_kelamin',
      'tanggal_lahir',
      'no_telepon',
      'nama_buku',
      'status',
    ];

    public function peminjaman(): HasMany
    {
        return $this->hasMany(Peminjaman::class, 'member_id');
    }

    public function buku(): BelongsToMany
    {
        return $this->belongsToMany(Buku::class, 'peminjaman', 'member_id', 'buku_id')->withPivot('tanggal_pinjam', 'tanggal_kembali', 'status')->withTimestamps;
    }
}
