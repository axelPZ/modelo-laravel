<?php
namespace App\helpers;

use App\Models\Post;

class getIdPost{

    public function getId( $id, $columna ){

        $result = Post::select( 'pst_id', 'pst_title', 'pst_img', 'pst_content', 'post.created_at','usr_id', 'usr_name', 'usr_surname', 'usr_img', 'cat_name', 'cat_img' )
        ->join( 'users', 'usr_id', '=', 'pst_idUser')
        ->join( 'category', 'cat_id', '=', 'pst_idCategory')
        ->where( 'pst_estate', 1)
        ->where( $columna, $id)
        ->get();

        return $result;
    }

}
