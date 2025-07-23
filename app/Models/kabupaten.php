<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class kabupaten extends Model
{
    use HasFactory;

    protected $fillable = [
        'username', 'email', 'password', 'is_admin'
    ];

    protected $casts = [
        'is_admin' => 'boolean',
    ];

}
