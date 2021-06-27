<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use CloudinaryLabs\CloudinaryLaravel\MediaAlly;

class UploadsController extends Controller
{

// SUBIR IMAGEN
    public function upload( Request $request ){

        // obtener datos de la request
        $archivo = $request->file('archivo');
        $coleccion = $request->coleccion;
        $id = $request->id;

        // validar el id
        $validateId = new \validateId();
        $result = $validateId->validateIdColeccion( $id, $coleccion );

        if( empty( $result ) ){
            return response()->json( [
                    'method'  =>  " $coleccion, con su id: $id, sin resultados"
                ], 400);
        }

        // guardar la img
        $saveImg =new \saveImg();
        $saveImgDB = $saveImg->saveImgDB( $id, $coleccion, $archivo);

        return response()->json(
            [
                'status' => 'success',
                'name' => $saveImgDB
            ], 200);
    }


// CARGAR IMAGEN
    public function getImg( Request $request ){

        $coleccion = $request->coleccion;
        $id = $request->id;

         // validar el id
         $validateId = new \validateId();
         $result = $validateId->validateIdColeccion( $id, $coleccion );
         if( empty( $result ) ){
             return response()->json( [
                     'method'  =>  " $coleccion, con su id: $id, sin resultados"
                 ], 400);
         }


         // obtenemos la imagen dependiendo de la coleccion
         switch ( $coleccion ) {
            case 'users':
                $img = $result['usr_img'];
                break;

            case 'categories':
                $img = $result['cat_img'];
                break;

            case 'posts':
                $img = $result['pst_img'];
                break;

            default:
                $result = [];
                break;
        }

         //verificar s existw la imagen
        $isset = \Storage::disk('images')->exists($img);
        if( $isset ){

            $file = \Storage::disk('images')->get($img);
            return new Response($file, 200);
        }

         return response()->json(
            [
                'message'=>'no se encontro la imagen'
            ], 404);
    }

    public function uploadCoudinary( Request $request ){

        // PENDIENTE
    }
}

