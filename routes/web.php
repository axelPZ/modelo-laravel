<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\PruebaController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UploadsController;
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
    Route::get('/api/user',             [ UserController::class,'getUser']);
    Route::get('/api/user/{idUser}',    [ UserController::class,'getByIdUser'])->middleware('validateIdUser');
    Route::post('/api/user',            [ UserController::class,'addUser'])    ->middleware('validateInputs');
    Route::put('/api/user/{idUser}',    [ UserController::class,'updateUser']) ->middleware('validateJWT','validateIdUser', 'validateInputs');
    Route::delete('/api/user/{idUser}', [ UserController::class,'deleteUser']) ->middleware('validateJWT','isAdminRole','validateIdUser');


    // LOGIN
    Route::post('/api/auth', [AuthController::class, 'login'])->middleware('validateLogin');

    // BUSCAR
    Route::get('/api/search/{coleccion}/{termino}',[SearchController::class, 'search'])->middleware('validateColeccion');

    //SUBIR O ACTUALIZAR IMAGEN SERVIDOR LOCAL
    Route::post('/api/uploads/{coleccion}/{id}',[UploadsController::class, 'upload'])->middleware('validateColeccion','validateImg');

    // DEVOLVER LA IMAGEN SERVIDOR LOCAL
    Route::get('/api/uploads/{coleccion}/{id}', [UploadsController::class, 'getImg'])->middleware('validateColeccion');

    // SUBIR O ACTUALIZAR IMAGEN A CLOUDINARY (pendiente)


    // CATEGORIAS
    Route::get('/api/categories',                 [ CategoryController::class, 'getCategories']);
    Route::get('/api/categories/{idCategory}',    [ CategoryController::class, 'getByIdCategory'])        ->middleware( 'validateIdCategory' );
    Route::get('/api/categories/user/{idUser}',   [ CategoryController::class, 'getCategoryIdUser'])      ->middleware( 'validateIdUser' );
    Route::patch('/api/categories/user/register', [ CategoryController::class, 'getCategoryUserRegister'])->middleware( 'validateJWT' );
    Route::post('/api/categories',                [ CategoryController::class, 'addCategory'])            ->middleware( 'validateJWT', 'validateInputCategory' );
    Route::put('/api/categories/{idCategory}',    [ CategoryController::class, 'updateCategory'])         ->middleware( 'validateJWT', 'validateIdCategory', 'validateInputCategory' );
    Route::delete('/api/categories/{idCategory}', [ CategoryController::class, 'deleteCategory'])         ->middleware( 'validateJWT', 'isAdminRole', 'validateIdCategory' );


    // POSTS
    Route::get('/api/post',                       [ PostController::class, 'getPost' ]);
    Route::get('/api/post/{idPost}',              [ PostController::class, 'getByIdPost' ])        ->middleware( 'validateIdPost' );
    Route::get('/api/post/user/{idUser}',         [ PostController::class, 'getPostIdUser' ])      ->middleware( 'validateIdUser' );
    Route::get('/api/post/category/{idCategory}', [ PostController::class, 'getPostIdCategory' ])  ->middleware( 'validateIdCategory' );
    Route::patch('/api/post/user/register',       [ PostController::class, 'getPostUserRegister' ])->middleware( 'validateJWT' );
    Route::post('/api/post/{idCategory}',         [ PostController::class, 'addPost' ])            ->middleware( 'validateJWT', 'validateIdCategory', 'validateInputPost' );
    Route::put('/api/post/{idPost}/{idCategory}', [ PostController::class, 'updatePost' ])         ->middleware( 'validateJWT', 'validateIdPost', 'validateIdCategory', 'validateInputPost');
    Route::delete('/api/post/{idPost}',           [ PostController::class, 'deletePost' ])         ->middleware( 'validateJWT', 'validateIdPost', 'isAdminRole' );






