<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User; // importamos el modelo
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

            default:
            break;
        }

        return response()->json(
            [
                'message' => 'resultados',
                'total' => $results[1],
                'result' => $results[0]
            ],400);

    }

    public function searchUser( $termino = '' ){


        // trae los usuarios que coinciden con la busqueda pero omite los eliminados
        // $comp = User::where('usr_email','LIKE', "%$termino%")
        //             ->orWhere('usr_surname','LIKE', "%$termino%")
        //             ->orWhere('usr_email','LIKE', "%$termino%")
        //             ->get();


        // trae a los usuarios omitiendo a los que estan eliminados
        $results = User::where(function ( $query ) use ( $termino ){

                $query->where( 'usr_estate', '=', 1 )
                ->where('usr_email','LIKE', "%$termino%");

            })->orWhere(function ($query) use ( $termino ) {

                $query->where( 'usr_estate', '=', 1 )
                ->where('usr_name','LIKE', "%$termino%");

            })->orWhere(function ($query) use ( $termino ) {

                $query->where( 'usr_estate', '=', 1 )
                ->where('usr_surname','LIKE', "%$termino%");

            })->get();

        $count = sizeof( $results );
        return array( $results, $count );
    }
}
