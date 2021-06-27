<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class validateColeccion
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
        $coleccion = $request->coleccion;

        $coleccionesPermitidas = array(
            'users',
            'posts',
            'categories'
        );

        // validar colleccion
        if( !in_array( $coleccion, $coleccionesPermitidas) ) {
            return response()->json( [
                    'message' => 'coleccion no valida. colecciones validas: '.implode( ',', $coleccionesPermitidas)
                ],400);
        }

        return $next($request);
    }
}
