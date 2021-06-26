<?php

namespace App\helpers;

use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Category;

class saveImg
{
    public function saveImgDB( $id, $coleccion, $archivo ){

        $img = '';
        $model = '';

        // se guarda la imagen en el servidor
        $archivo_name = time().$archivo->getClientOriginalName(); // nombre crear el nombre del arhivo
        $path = $archivo->storeAs($coleccion, $archivo_name, 'images');// 'coleccion' contiene el nombre de la carpeta dentro del disco.  'images' nombre del disco

        // se guarda la ruta de img en la DB dependiendo de la coleccion
        switch ($coleccion) {

            case 'users':

                $result = User::where('usr_id', $id)->first('usr_img');
                $updateModel = User::where( 'usr_id',$id )->update( ['usr_img' => $path ]  );
                $img = $result['usr_img'];

                $model = User::where('usr_id', $id)->first();
                break;

            case 'categories':

                $result = Category::where('cat_id', $id)->first('cat_img');
                $updateModel = Category::where( 'cat_id',$id )->update( ['cat_img' => $path ]  );
                $img = $result['cat_img'];

                $model = Category::where('cat_id', $id)->first();
                break;

            default:
                $result = [];
                break;
        }

        // se borra la img que se habia guardado anteriomente
        $isset = \Storage::disk('images')->exists($img);
        if( $isset ){
            unlink( storage_path( 'app/images/'.$img ) );
        }

        return $model;

    }
}
