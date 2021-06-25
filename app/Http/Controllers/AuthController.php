<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User; // importamos el modelo

class AuthController extends Controller
{

    public function login( Request $request ){

        $newJwt = new \generateJWT(); // llamamos el helper que genera el JWT
        $user = $request->user; // extraigo el usuario de la request que e ingresado en el middleware
        $jwt = $newJwt->createJwt( $user );

        return response()->json(
            [
                'status' => 'success',
                'user'  =>  $user,
                'token' => $jwt
            ], 200);
    }
}
