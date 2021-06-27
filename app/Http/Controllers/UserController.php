<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User; // importamos el modelo

class UserController extends Controller
{
    // funcion de prueba
    // Request para recivir datos desde la url
    public function prueba(Request $request){
        return ' probando el controlador';
    }


    // LISTAR USUARIOS
    public function getUser(){

        $result = User::where('usr_estate', 1)->get();
        $count = User::where('usr_estate', 1)->count();

        return response()->json(
            [
                'code'   => 200,
                'status' => 'success',
                'total' => $count,
                'posts'  =>  $result
            ],200);
    }



    // LLAMAR USUARIO POR ID
    public function getByIdUser( $idUser ){

        $user = new User();
        $result = $user->where('usr_id', $idUser)->first();

        return response()->json(
            [
                'status' => 'success',
                'method'  =>  $result
            ], 200);
    }



    // AGREGAR USUARIO
    public function addUser( Request $request ){

        $data = $request->user; // extraigo el usuario de la request que e ingresado en el middleware

        $user = new User();
        $user->usr_name = strtoupper($data['usr_name']);
        $user->usr_surname = strtoupper($data['usr_surname']);
        $user->usr_email = strtoupper($data['usr_email']);
        $user->usr_password = $data['usr_password'];
        $user->usr_role = strtoupper($data['usr_role']);
        $user->save(); //guardar usuario en la base de datos

        return response()->json(
            [
                'code'   => 200,
                'status' => 'success',
                'method'  =>  $user
            ], 200);
    }

     // EDITAR USUARIO
     public function updateUser( Request $request, $idUser ){

        $data = $request->user; // extraigo el usuario de la request que e ingresado en el middleware

        // quitar los datas que no se van a actualizar
        unset($data['usr_id']);
        unset($data['usr_estate']);
        unset($data['usr_email']);
        unset($data['usr_img']);

        $user_update = User::where( 'usr_id',$idUser )->update( $data );
        $result = User::where( 'usr_id', $idUser )->first();

        return response()->json(
            [
                'status' => 'success',
                'method'  =>  $result
            ], 200);
    }

     // ELIMINAR USUARIO
     public function deleteUser( $idUser ){

        // solo cambiar el estado del usuario
        $user_update = User::where( 'usr_id',$idUser )->update( ['usr_estate' => 2] );
        $result = User::where('usr_id', $idUser )->first();

        return response()->json(
            [
                'status' => 'success',
                'message' => 'se a borrado el usaurio correctamente',
                'method'  =>  $result
            ], 200);
    }
}
