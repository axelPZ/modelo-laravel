<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class validateInputPost
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
                    'pst_title'      => 'required|unique:post',
                    'pst_content' => 'required'
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
