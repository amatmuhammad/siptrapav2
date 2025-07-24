<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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

}
