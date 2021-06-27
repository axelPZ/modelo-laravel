<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\Category; // importamos el modelo

class validateIdCategory
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $id = $request->idCategory;

        $result = Category::where('cat_id', $id)->first();

        if( isset( $result ) && is_object( $result ) && $result->cat_estate === 1 ){

            return $next($request);
        }else{

            return response()->json([
                    'message'  =>  'No se encontro, ninguna categoria con el id '. $id
                ],400);
        }

        return $next($request);
    }
}
