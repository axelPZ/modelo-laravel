<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

use App\Models\User; // importamos el modelo

class checkId
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
        $result = User::where('usr_id', $id)->first();

        if( isset( $result ) && is_object( $result ) && $result->usr_estate === 1 ){

            return $next($request);
        }else{

            $data = array(
                'code'    => 400,
                'message' => 'No existe el usuario con el id: ' . $id
            );
            return response()-> json($data, $data['code']);
        }
    }
}
