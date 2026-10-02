<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Laporan extends Model
{
    protected $table = 'laporan';

    protected $fillable = [
        'judul',
        'isi',
        'foto',
        'tanggal',
        'penulis_id',
    ];

    public function penulis(): BelongsTo
    {
        return $this->belongsTo(User::class, 'penulis_id');
    }

    public function galeri(): HasMany
    {
        return $this->hasMany(Galeri::class, 'laporan_id');
    }

    public function menuHarians(): HasMany
    {
        return $this->hasMany(MenuHarian::class, 'laporan_id')->orderBy('urutan');
    }
}
