<?php

namespace App\Models;

use App\Models\edges;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class nodes extends Model
{
    use HasFactory;
    

    protected $table = 'nodes';

    protected $primarykey = 'id'; 

    protected $fillable = [ 'name', 
                            'latitude', 
                            'longitude', 
                            'category', 
                            'roadname'];
                            
    protected static function booted()
    {
        static::creating(function ($node) {
            if (empty($node->category)) {
                $node->category = 'land';
            }
        });
    }

    // Definisikan relasi ke Edge sebagai sumber
    public function sourceEdges()
    {
        return $this->hasMany(edges::class, 'source', 'name');
        //  return $this->hasMany(edges::class, 'source_id');
    }

    // Definisikan relasi ke Edge sebagai target
    public function targetEdges()
    {
        return $this->hasMany(edges::class, 'target', 'name');
        // return $this->hasMany(edges::class, 'target_id');
    }



}
