<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DataPenerima extends Model
{
    protected $table = 'data_penerima';

    protected $fillable = [
        'nama_sekolah',
        'alamat',
        'jumlah_penerima',
        'tanggal_distribusi',
    ];
}
