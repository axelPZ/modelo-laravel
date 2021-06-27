<?php
namespace App\helpers;

use App\Models\Category;

class getIdCategory{

    public function getId( $id, $columna ){

        $result = Category::select( 'cat_id', 'cat_name','cat_img', 'usr_name', 'usr_surname', 'usr_img' )
        ->join('users', 'usr_id', '=', 'cat_idUser')
        ->where( $columna, $id)
        ->where( 'cat_estate', 1)
        ->get();

        return $result;
    }

}
