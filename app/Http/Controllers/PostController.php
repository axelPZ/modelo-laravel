<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;

class PostController extends Controller
{

    // TRAER TODOS LOS POST
    public function getPost(){
        $result = Post::select( 'pst_id', 'pst_title', 'pst_img', 'pst_content', 'post.created_at','usr_id', 'usr_name', 'usr_surname', 'usr_img', 'cat_name', 'cat_img' )
                        ->join( 'users', 'usr_id', '=', 'pst_idUser')
                        ->join( 'category', 'cat_id', '=', 'pst_idCategory')
                        ->where( 'pst_estate', 1)
                        ->get();

        $count = Post::where('pst_estate', 1)->count();

        return response()->json(
            [
                'total' => $count,
                'post'  =>  $result
            ],200);
    }


    // TRAER POST POR ID
    public function getByIdPost( Request $request ){

        $id = $request->id;
        $getIdPost = new \getIdPost();
        $result = $getIdPost->getId( $id, 'pst_id');

        return response()->json([
            'post'  =>  $result
        ],200);
    }


    // TRAER POST POS ID DEL USUARIO
    public function getPostIdUser( Request $request ){

        $id = $request->id;
        $getIdPost = new \getIdPost();
        $result = $getIdPost->getId( $id, 'pst_idUser');

        if(  sizeof($result) > 0 ){

            $total = sizeof( $result );
            return response()->json([
                    'status' => 'success',
                    'total' => $total,
                    'post' => $result
                ],200);
        }
        return response()->json([
                'mensaje' => ' Usuario sin posts para mostrar'
            ],400);
    }



    // TRAER POST POR ID DE CATEGORIA
    public function getPostIdCategory( Request $request ){

        $id = $request->id;
        $getIdPost = new \getIdPost();
        $result = $getIdPost->getId( $id, 'pst_idCategory');

        if(  sizeof($result) > 0 ){

            $total = sizeof( $result );
            return response()->json( [
                    'status' => 'success',
                    'total' => $total,
                    'post' => $result
                ],200);
        }
        return response()->json([
                'mensaje' => ' Categoria si post para mostrar'
            ],400);
    }



    // TRAER POST POR USUARIO REGISTRADO
    public function getPostUserRegister( Request $request ){

        $user = $request->user; // obtengo el id del usuario logeado, que se a agregado al validar el JWT
        $idUser = $user['usr_id'];

        $getIdPost = new \getIdPost();
        $result = $getIdPost->getId( $idUser, 'pst_idUser');

        if(  sizeof($result) > 0 ){

            $total = sizeof( $result );
            return response()->json([
                    'status' => 'success',
                    'total' => $total,
                    'post' => $result
                ],200);
        }
        return response()->json([
                'mensaje' => ' Usuario sin posts para mostrar'
            ],400);
    }


    // AGREGAR POST
    public function addPost( Request $request ){

        $data = $request->json()->all();
        $user = $request->user;
        $idUser = $user['usr_id'];
        $idCategory = $request ->id;

        $newPost = new Post();
        $newPost->pst_idUser = $idUser;
        $newPost->pst_idCategory = $idCategory;
        $newPost->pst_title = strtoupper( $data['pst_title'] );
        $newPost->pst_content = $data['pst_content'];
        $newPost->save();

        return response()->json([
            'mensaje' => $newPost
        ],200);
    }


    // EDITAR POST
    public function updatePost(){

    }

    // ELIMAR POST
    public function deletePost( Request $request ){

        $id = $request->id;

        $user_update = POST::where( 'pst_id',$id )->update( ['pst_estate' => 2] );
        $result = POST::where('pst_id', $id)->first();

      return response()->json(
          [
              'status' => 'success',
              'data' => $result,
          ],200);

    }
}
