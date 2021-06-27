<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Post;
use App\Models\Category;

use Illuminate\Support\Facades\DB; // trabajar con la BD
use PhpParser\Node\Expr\BinaryOp\Concat;

class SearchController extends Controller
{

    public function search( Request $request ){


        $coleccion = $request->coleccion;
        $termino = $request->termino;

        $results = [];

        switch( $coleccion ){

            case 'users':
                $results =  $this->searchUser( $termino  );
            break;

            case 'categories':
                $results =  $this->searchCategories( $termino  );
            break;

            case 'posts':
                $results =  $this->searchPost( $termino  );
            break;

            default:
                return response()->json( [
                    'mensaje' => ' coleccion no programada aun'
                ],500);
            break;
        }

        return response()->json(
            [
                'message' => 'resultados',
                'total' => $results[1],
                'result' => $results[0]
            ],400);

    }



    // BUSCAR USUARIO
    public function searchUser( $termino = '' ){

        // trae a los usuarios omitiendo a los que estan eliminados
        $result = User::where(function ( $query ) use ( $termino ){

                $query->where( 'usr_estate', '=', 1 )
                ->where('usr_email','LIKE', "%$termino%");

            })->orWhere(function ($query) use ( $termino ) {

                $query->where( 'usr_estate', '=', 1 )
                ->where('usr_name','LIKE', "%$termino%");

            })->orWhere(function ($query) use ( $termino ) {

                $query->where( 'usr_estate', '=', 1 )
                ->where('usr_surname','LIKE', "%$termino%");

            })->get();

        $count = sizeof( $result );
        return array( $result, $count );
    }



    // BUSCAR POST
    public function searchPost( $termino = '' ){

        $result = Post::where( 'pst_estate', '=', 1)
                        ->where( 'pst_title', 'LIKE', "%$termino%" )
                        ->get();

        $count = sizeof( $result );
        return array( $result, $count );
    }



    // BUSCAR CATEGORIA
    public function searchCategories( $termino = '' ){

        $result = Category::where( 'cat_estate', '=', 1)
        ->where( 'cat_name', 'LIKE', "%$termino%" )
        ->get();

        $count = sizeof( $result );
        return array( $result, $count );
    }
}
