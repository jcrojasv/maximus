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
Route::get('propietario/index', 'PropietarioController@index');
Route::resource('/propietario','PropietarioController');

//Rutas para mascotas
Route::get('mascota/listado','MascotaController@listado')->name('mascota.listado');
Route::resource('/mascota','MascotaController');


//Rutas para ejecutar peticiones de carga de select depediente a traves de ajax

Route::get('selectRazas', 'PropietarioController@cargarRazasJquery');
Route::get('selectAlimentos', 'PropietarioController@cargarAlimentosJquery');

//Rutas para ordenes de trabajo
Route::get('orden/listAcumulado','OrdenController@listAcumulado')->name('orden.listAcumulado');
Route::get('orden/showAcumulado','OrdenController@showAcumulado')->name('orden.showAcumulado');
Route::get('orden/createFromMascota/{mascota}','OrdenController@createFromMascota')->name('orden.createFromMascota')->where('mascota', '[0-9]+');
Route::get('orden/buscarMascota', 'OrdenController@buscarMascota')->name('orden.buscarMascota');
Route::get('orden/selectMascota', 'OrdenController@SelectMascota')->name('orden.selectMascota');
Route::get('orden/esp', 'OrdenController@esp')->name('orden.esp');
Route::get('orden/index', 'OrdenController@index');
Route::resource('/orden','OrdenController');
