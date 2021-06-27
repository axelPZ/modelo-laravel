<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    // indicamos la tabla que va hacer referencia
    protected $table = 'category';

    // relacion de muchos a uno
    public function user(){
        return $this->belongsTo('App\Models\User', 'cat_idUser');
    }


    protected $hidden = [
        'cat_estate'
    ];



}
