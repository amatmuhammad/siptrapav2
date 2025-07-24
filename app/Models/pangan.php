<?php

namespace App\Models;

use App\Models\produsen;
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
        'asal_pangan', 
        'tujuan_pangan', 
        'tanggal_pengiriman', 
        'estimasi_kadaluarsa'
    ];

    public function produsen(): BelongsTo {
        return $this->belongsTo(produsen::class, 'produsen_id');
    }
}
