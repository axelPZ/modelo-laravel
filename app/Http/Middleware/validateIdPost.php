<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\Post;

class validateIdPost
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
        $id = $request->id;
        $result = Post::where('pst_id', $id)->first();

        if( isset( $result ) && is_object( $result ) && $result->pst_estate === 1 ){

            return $next($request);
        }else{

            return response()->json([
                    'message'  =>  'No se encontro, ningun post con el id '. $id
                ],400);
        }

        return $next($request);

    }
}
