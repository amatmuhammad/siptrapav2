<?php

namespace App\Models;

use App\Models\pangan;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class namaPangan extends Model
{
    use HasFactory;

    protected $table = 'tbl_nama_pangan';
    
    protected $fillable = ['nama_pangan'];

    public function pangan()
    {
        return $this->hasMany(pangan::class, 'nama_pangan_id');
    }
}
