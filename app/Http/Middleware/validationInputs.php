<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class validationInputs
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

        if( !empty($data) ){

            $data = array_map('trim', $data); //quitamos los espacios al json

    // VALIDAR LOS CAMPOS
             //para mas informacion de las validaciones buscar en LaravelValidation
            if( !empty( $data['usr_password'] ) ) {

                $validate = \Validator::make(
                    $data,
                    [
                        'usr_name'      => 'required|alpha', //le deimos que el nombre sea requerido y que sea de tipo alpha numerico
                        'usr_surname'   => 'required|alpha',
                        'usr_email'     => 'required|email|unique:users', //COMPROBAR SI EL USUARIO EXISTE Y(DUPLICADO) con unique|users
                        'usr_password'  => 'required',
                        'usr_role'  => 'required'
                    ]);

                    $data['usr_password'] = hash( 'sha256', $data['usr_password']); // encriptar la password
            }else{

                $validate = \Validator::make(
                    $data,
                    [
                        'usr_name'      => 'required|alpha', //le deimos que el nombre sea requerido y que sea de tipo alpha numerico
                        'usr_surname'   => 'required|alpha',
                        'usr_email'     => 'required|email|unique:users', //COMPROBAR SI EL USUARIO EXISTE Y(DUPLICADO) con unique|users
                        'usr_role'  => 'required'
                    ]);
            }

            // verificar si los campos pasaron las validaciones
            if ( !$validate->fails() ) {

                // VALIDAR EL ROL
                $validateInputs = new \validateInputs(); // llamamos el helper que valida el rol
                $valRole = $validateInputs->validateRole( $data['usr_role'] ); // le enviamos el el a la funcion de la validacion del rol

                if( $valRole ){

                    $request->user = $data; // agrego el usuario a la request
                    return $next($request);

                }else{

                    return response()->json(
                        [
                            'status' => 'error',
                            'message'  =>  ' el Rol no es valido'
                        ],400);
                }
            }else{

                return response()->json(
                    [
                        'status' => 'error',
                        'message'  =>  $validate->errors()
                    ],400);
            }
        }else{
            return response()->json(
                [
                    'status' => 'error',
                    'message'  =>  'Datos invalidos'
                ],200);
        }
    }
}
