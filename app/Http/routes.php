<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

/*Route::get('/', function () {
    return view('ficha/index');
});*/

/*Route::controllers([
    'auth'      => 'Auth\AuthController',
    'password'  => 'Auth\PasswordController'
]);
*/

Route::get('/', 'HomeController@index');
Route::get('/home', 'HomeController@index');

//Route::auth();

Route::resource('/login','LoginController');
Route::get('/logout','LoginController@logout');

//Rutas para la ficha tecnica
Route::resource('/propietario','PropietarioController');

//Rutas para mascotas
Route::resource('/mascota','MascotaController');


//Rutas para ejecutar peticiones de carga de select depediente a traves de ajax
Route::get('selectRazas', 'PropietarioController@cargarRazasJquery');
Route::get('selectAlimentos', 'PropietarioController@cargarAlimentosJquery');

//Rutas para ordenes de trabajo
Route::get('orden/buscarMascota', 'OrdenController@buscarMascota')->name('orden.buscarMascota');
Route::get('orden/selectMascota', 'OrdenController@SelectMascota')->name('orden.selectMascota');
Route::get('orden/esp', 'OrdenController@esp')->name('orden.esp');
Route::resource('/orden','OrdenController');
