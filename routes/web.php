<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\PruebaController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// ruta principal
Route::get('/', function () {
    return view('welcome');
});

// RUTAS DE PRUEBA

// devolver un texto
Route::get('/prueba', function(){
    $texto = '<h1> Ruta de prueba </h1>';
    return ( $texto );
});


// recibir parametro obligatorio
Route::get('/prueba2/{nombre}', function($nombre){
    $texto = '<h1> Bienvenido a laravel: '.$nombre.' </h1>';
    return  $texto;
});

// recibir parametro opcional
Route::get('/prueba3/{nombre?}', function($nombre=null){
    $texto = '<h1> Bienvenido a laravel: '.$nombre.' </h1>';
    return  $texto;
});

// recibir y mandar parametros a una vista
Route::get('/prueba4/{nombre?}', function($nombre=null){
    $texto = 'Bienvenido a laravel: ';

    // envio un array a la vista
    return view('prueba', array(
        'texto' => $texto,
        'nombre' => $nombre
    ));
});

// trabajando con el controlador
Route::get('/control/{nombre?}',[PruebaController::class,'index']);


Route::get('/token', function () {
    return csrf_token();
});

// API REST

    // USUARIOS
    Route::get('/api/user', [UserController::class,'getUser']);
    Route::get('/api/user/{id}', [UserController::class,'getByIdUser'])->middleware('validateIdUser');
    Route::post('/api/user', [UserController::class,'addUser'])->middleware('validateInputs');

    Route::put('/api/user/{id}', [UserController::class,'updateUser'])->middleware('validateJWT','validateIdUser', 'validateInputs');
    Route::delete('/api/user/{id}', [UserController::class,'deleteUser'])->middleware('validateJWT','isAdminRole','validateIdUser');

    // LOGIN
    Route::post('/api/auth', [AuthController::class, 'login'])->middleware('validateLogin');

