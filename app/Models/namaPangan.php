<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class namaPangan extends Model
{
    use HasFactory;

    protected $table = 'tbl_nama_pangan';
    
    protected $fillable = ['nama_pangan'];
}
