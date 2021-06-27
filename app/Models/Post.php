<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    // indicamos la tabla que va hacer referencia
    protected $table = 'post';

    protected $hidden = [
        'pst_estate'
    ];

    use HasFactory;
}
