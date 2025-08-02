<?php

namespace App\Models;

use App\Models\pangan;
use App\Models\produsen;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class kabupaten extends Model
{
    use HasFactory;

    protected $table = 'tbl_kabupaten';

    protected $fillable = [
        'nama_kabupaten',
        'latitude',
        'longitude',
        'gambar',
    ];

    // Relasi ke produsen distributor berdasarkan asal kabupaten
    public function produsen()
    {
        return $this->hasMany(produsen::class, 'asal');
    }

    // Relasi ke pangan sebagai kabupaten asal
    public function panganAsal()
    {
        return $this->hasMany(pangan::class, 'asal_pangan');
    }

    // Relasi ke pangan sebagai kabupaten tujuan
    public function panganTujuan()
    {
        return $this->hasMany(pangan::class, 'tujuan_pangan');
    }

}
