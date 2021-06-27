<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category; // importamos el modelo
use Carbon\Carbon;

class CategoryController extends Controller
{
    // TRAER LAS CATEGORIAS
    public function getCategories(){

        $count = Category::where('cat_estate', 1)->count();
        $result = Category::select( 'cat_id', 'cat_name','cat_img', 'usr_name', 'usr_surname', 'usr_img' )
                            ->join('users', 'usr_id', '=', 'cat_idUser')
                            ->where( 'cat_estate',1)
                            ->get();

        return response()->json(
            [
                'status' => 'success',
                'total' => $count,
                'categories'  =>  $result
            ],200);
    }



    // TRAER LAS CATEGORIAS POR ID
    public function getByIdCategory( Request $request ){

        $id = $request->id;
        $getIdCategory = new \getIdCategory();  // instanciar el helper que contiene la consulta
        $result = $getIdCategory->getId( $id, 'cat_id');

        return response()->json(
            [
                'status' => 'success',
                'total' => $result
            ],200);
    }



    // TRAER LAS CATEGORIAS POR ID DE USARIO
    public function getCategoryIdUser( Request $request){

        $id = $request->id;
        $getIdCategory = new \getIdCategory();  // instanciar el helper que contiene la consulta
        $result = $getIdCategory->getId( $id, 'cat_idUser');

        if(  sizeof($result) > 0 ){
            return response()->json(
                [
                    'status' => 'success',
                    'total' => $result
                ],200);
        }
        return response()->json([
                'mensaje' => ' Usuario sin categorias para mostrar'
            ],400);
    }



    // TRAER CATEGORIAS POR USUARIO LOGEADO
    public function getCategoryUserRegister( Request $request){

        $user = $request->user; // obtengo el id del usuario logeado, que se a agregado al validar el JWT
        $idUser = $user['usr_id'];
        $getIdCategory = new \getIdCategory();  // instanciar el helper que contiene la consulta
        $result = $getIdCategory->getId( $idUser, 'cat_idUser');

        if(  sizeof($result) > 0 ){
            return response()->json(
                [
                    'status' => 'success',
                    'total' => $result
                ],200);
        }
        return response()->json([
                'mensaje' => ' Usuario sin categorias para mostrar'
            ],400);
    }




    // AGREGAR CATEGORIAS
    public function addCategory( Request $request ){

        $data = $request->json()->all();
        $user = $request->user; // obtengo el id del usuario logeado, que se a agregado al validar el JWT
        $idUser = $user['usr_id'];

        $category = new Category();
        $category->cat_name = strtoupper($data['cat_name']);
        $category->cat_idUser = $idUser;
        $category->save();

        return response()->json(
            [
                'status' => 'success',
                'total' => $category
            ],200);
    }

    // EDITAR CATEGORIAS
    public function updateCategory( Request $request ){

        $data = $request->json()->all();
        $user = $request->user; // obtengo el id del usuario logeado, que se a agregado al validar el JWT
        $idUser = $user['usr_id'];
        $id = $request->id;

        $result = Category::where('cat_id', $id)->first();
        $idUserCategory = $result['cat_idUser'];

        // verificar que el usuario que quiere editar la categoria es el que la creo
        if ( $idUser != $idUserCategory) {
            return response()->json( [
                'mensaje' => 'El usuario logiado, no es el que creo la categoria'
            ], 400);
        }

        $user_update = Category::where( 'cat_id',$id )->update( [ 'cat_name' => $data['cat_name'] ] );
        $result = Category::where('cat_id', $id)->first();

        return response()->json(
            [
                'status' => 'success',
                'data' => $result,
            ],200);
    }

    // ELIMINAR CATEGORIAS
    public function deleteCategory( Request $request ){

        $id = $request->id;

          $user_update = Category::where( 'cat_id',$id )->update( ['cat_estate' => 2] );
          $result = Category::where('cat_id', $id)->first();

        return response()->json(
            [
                'status' => 'success',
                'data' => $result,
            ],200);
    }


}
