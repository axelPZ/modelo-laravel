<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class validateImg
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
        $archivo = $request->file('archivo');

         // validar el archivo
         if ( $archivo == null || !$archivo->isValid() ) {
            return response()->json( [
                'method'  =>  " error al subir el archivo"
            ], 400);
        }

        // validar el tipo de archivo
        $validate = \Validator::make(
            $request->all(),
            [
                'archivo' => 'required|image|mimes:jpg,jpeg,png,gif'//con el mimes le decimos que tipos de imagenes se reciviran
            ]);

        if( $validate->fails() ){
            return response()->json( [
                'method'  =>  "Tipo de imagen no soportada"
            ], 400);
        }

        return $next($request);
    }
}
