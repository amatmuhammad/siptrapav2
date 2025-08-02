<?php

namespace App\Models;

use App\Models\pangan;
use App\Models\kabupaten;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class produsen extends Model
{
    use HasFactory;
    
    protected $table = 'tbl_produsen_distributor';


    protected $fillable = [
        'user_id', 
        'nama_distributor', 
        'no_hp', 
        'nama_pemilik', 
        'jenis_pangan',
        'jenis_distributor', 
        'asal', 
        'tujuan_distribusi', 
        'alamat_distributor',
        'wilayah_cakupan', 
        'latitude', 
        'longitude'
    ];

    // Relasi ke kabupaten asal
    public function asalKabupaten()
    {
        return $this->belongsTo(kabupaten::class, 'asal');
    }

    // Relasi ke data pangan yang dikirim oleh produsen ini
    public function pangan()
    {
        return $this->hasMany(pangan::class, 'produsen_id');
    }
}
