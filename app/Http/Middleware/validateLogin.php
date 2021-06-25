<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\User; // importamos el modelo

class validateLogin
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

        if( !empty( $data ) ){

            $validate = \Validator::make(
                $data,
                [
                    'email'      => 'required|email', //le deimos que el nombre sea requerido y que sea de tipo alpha numerico
                    'password'   => 'required'
                ]);

                // verificar las validaciones
            if ($validate->fails()) {

                return response()->json(
                    [
                        'status' => 'error',
                        'message'  =>  $validate->errors()
                    ],400);
            }




            $password= hash( 'sha256', $data['password']);
            $email = $data['email'];

            $user = User::where('usr_email', $email)
                    ->where('usr_password', $password)
                    ->first();

            if( isset( $user ) && is_object( $user ) && $user->usr_estate === 1  ){

                $request->user = $user; // agrego el usuario a la request
                return $next($request);
            }



            return response()->json(
                [
                    'code'    => 400,
                    'message' => 'ningun usuario coincide con los datos enviados',
                ],400);
        }
    }
}
