<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PruebaController extends Controller
{
    // metodo que recibi un parametro de las rutas y envia una arreglo a la vista
    public function index( $nombre = null){

        $users = [
            [ 'id'=> 1, 'nombre' => 'axel', 'apellido' => 'paez', 'edad' => 26, 'estado' => true],
            [ 'id'=> 2, 'nombre' => 'leidi', 'apellido' => 'morales', 'edad' => 20, 'estado' => true],
            [ 'id'=> 3, 'nombre' => 'carlos', 'apellido' => 'gonzales', 'edad' => 13, 'estado' => true],
            [ 'id'=> 4, 'nombre' => 'estuardo', 'apellido' => 'barillas', 'edad' => 33, 'estado' => true],
            [ 'id'=> 5, 'nombre' => 'kevin', 'apellido' => 'pineda', 'edad' => 53, 'estado' => true ]
        ];

        // enviarmos el array a la vista
        return view('pruebaControlador', array(
            'users' => $users,
            'nombre' => $nombre
        ));
    }


}
