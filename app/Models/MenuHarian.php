<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MenuHarian extends Model
{
    use HasFactory;

    protected $table = 'menu_harians';

    protected $fillable = [
        'laporan_id',
        'tanggal',
        'nama_item',
        'takaran',
        'energi',
        'protein',
        'lemak',
        'karbo',
        'serat',
        'urutan',
    ];

    public function laporan(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Laporan::class, 'laporan_id');
    }

    protected $casts = [
        'tanggal' => 'date',
        'energi'  => 'float',
        'protein' => 'float',
        'lemak'   => 'float',
        'karbo'   => 'float',
        'serat'   => 'float',
        'urutan'  => 'integer',
    ];

    /**
     * Scope: ambil semua item untuk tanggal tertentu, urut by urutan.
     */
    public function scopeUntukTanggal($query, $tanggal)
    {
        return $query->whereDate('tanggal', $tanggal)->orderBy('urutan');
    }
}
