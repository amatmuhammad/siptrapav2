<?php

namespace App\Models;

use App\Models\produsen;
use App\Models\kabupaten;
use App\Models\namaPangan;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class pangan extends Model
{
    use HasFactory;

    protected $table = 'tbl_pangan';

    protected $fillable = [
        'produsen_id', 
        'jenis_pangan', 
        'volume', 
        'nama_pangan_id',
        'asal_pangan', 
        'tujuan_pangan', 
        'tanggal_pengiriman', 
        'estimasi_kadaluarsa'
    ];

    public function produsen()
    {
        return $this->belongsTo(produsen::class, 'produsen_id');
    }

    public function namaPangan()
    {
        return $this->belongsTo(namaPangan::class, 'nama_pangan_id');
    }

    public function asalKabupaten()
    {
        return $this->belongsTo(kabupaten::class, 'asal_pangan');
    }

    public function tujuanKabupaten()
    {
        return $this->belongsTo(kabupaten::class, 'tujuan_pangan');
    }
}
