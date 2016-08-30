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
Route::get('/home', 'HomeController@index')->name('home');
/*Route::get('/home', [
	'as' => 'home',
	'middleware' => 'role:admin',
	'uses' => 'HomeController@index',
]);
*/

//Route::auth();

Route::resource('/login','LoginController');
Route::get('/logout','LoginController@logout');

//Rutas para la ficha tecnica
Route::get('propietario/index', 'PropietarioController@index');
Route::resource('/propietario','PropietarioController');

//Rutas para mascotas
Route::get('mascota/buscar', 'MascotaController@buscar')->name('mascota.buscar');
Route::get('mascota/seleccionar', 'MascotaController@seleccionar')->name('mascota.seleccionar');
Route::get('mascota/listado','MascotaController@listado')->name('mascota.listado');
Route::resource('/mascota','MascotaController');


//Rutas para ejecutar peticiones de carga de select depediente a traves de ajax

Route::get('selectRazas', 'PropietarioController@cargarRazasJquery');
Route::get('selectAlimentos', 'PropietarioController@cargarAlimentosJquery');

//Rutas para ordenes de trabajo
Route::get('orden/showHistorial/{mascota}','OrdenController@showHistorial')->name('orden.showHistorial')->where('mascota','[0-9]+');
Route::get('orden/historial/{mascota?}','OrdenController@historial')->name('orden.historial')
->where('mascota','[0-9]+');
Route::get('orden/listAcumulado','OrdenController@listAcumulado')->name('orden.listAcumulado');
Route::get('orden/showAcumulado','OrdenController@showAcumulado')->name('orden.showAcumulado');
Route::get('orden/createFromMascota/{mascota}','OrdenController@createFromMascota')->name('orden.createFromMascota')->where('mascota', '[0-9]+');

Route::get('orden/esp', 'OrdenController@esp')->name('orden.esp');
Route::get('orden/index', 'OrdenController@index');
Route::resource('/orden','OrdenController');

//Rutas para Color
Route::get('colors/listado','ColorController@listado');
Route::resource('/colors','ColorController');

//Rutas para Razas
Route::get('razas/listado','RazaController@listado');
Route::resource('/razas','RazaController');

//Rutas para Alimentos
Route::get('alimentos/listado','AlimentoController@listado');
Route::resource('/alimentos','AlimentoController');

//Rutas para Reportes
Route::get('reportes/ordenesDiarias','ReportesController@ordenesDiarias')->name('reportes.ordenesDiarias');

