<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class validateInputCategory
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

        $data = $request->json()->all();

        // valido si nos envian los datos
        if( empty($data) ){
            return response()->json( [
                'message'  =>  "Datos no validos"
            ],400);
        }

        // validar si son correctos los datos recividos
        $validate = \Validator::make(
            $data, [
                    'cat_name'      => 'required|alpha|unique:category'
                ]);


        // verificamos si los datos pasaron las validaciones
        if ( $validate->fails() ) {
            return response()->json( [
                    'message'  =>  $validate->errors()
                ],400);
        }

        return $next($request);
    }
}
