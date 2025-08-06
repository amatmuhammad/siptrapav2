<?php

namespace App\Models;

use App\Models\nodes;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class edges extends Model
{
    use HasFactory;

    protected $table = 'edges';

    protected $fillable = ['source', 'target', 'distance'];
    // protected $fillable = ['source_id', 'target_id', 'distance'];
    // Definisikan relasi ke Node sebagai sumber
    public function sourceNode()
    {
        return $this->belongsTo(nodes::class, 'source', 'name');
    }

    // Definisikan relasi ke Node sebagai target
    public function targetNode()
    {
        return $this->belongsTo(nodes::class, 'target', 'name');
    }
}
