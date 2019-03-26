<?php

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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');


//TODOS LOS MENUS
//GRUPO DE RUTAS PARA LA ADMINISTRACIÓN
Route::group(['middleware' => 'auth', 'prefix' => 'admin'], function() {
    Route::get('usuarios', 'MenuController@usuarios')->name('admin.usuarios');
    Route::get('feligresia', 'MenuController@feligresia')->name('admin.feligresia');
    Route::post('acceso', 'HomeController@confirmaRol')->name('rol');
    Route::get('inicio', 'HomeController@inicio')->name('inicio');
});

//GRUPO DE RUTAS PARA LA ADMINISTRACIÓN DE USUARIOS
Route::group(['middleware' => 'auth', 'prefix' => 'usuarios'], function() {
    //MODULOS
    Route::resource('modulo', 'ModuloController');
    //PAGINAS O ITEMS DE LOS MODULOS
    Route::resource('pagina', 'PaginaController');
    //GRUPOS DE USUARIOS
    Route::resource('grupousuario', 'GrupousuarioController');
    Route::get('grupousuario/{id}/delete', 'GrupousuarioController@destroy')->name('grupousuario.delete');
    Route::get('privilegios', 'GrupousuarioController@privilegios')->name('grupousuario.privilegios');
    Route::get('grupousuario/{id}/privilegios', 'GrupousuarioController@getPrivilegios');
    Route::post('grupousuario/privilegios', 'GrupousuarioController@setPrivilegios')->name('grupousuario.guardar');
    //USUARIOS
    Route::resource('usuario', 'UsuarioController');
    Route::get('usuario/{id}/delete', 'UsuarioController@destroy')->name('usuario.delete');
    Route::post('operaciones', 'UsuarioController@operaciones')->name('usuario.operaciones');
});

//GRUPO DE RUTAS PARA LA ADMINISTRACIÓN DEL MÓDULO DE FELIGRESÍA
Route::group(['middleware' => 'auth', 'prefix' => 'feligresia'], function() {
    //PAISES
    Route::resource('pais', 'PaisController');
    Route::get('pais/{id}/delete', 'PaisController@destroy')->name('pais.delete');
    Route::get('pais/{id}/estados', 'PaisController@estados')->name('pais.estados');
    //ESTADOS
    Route::resource('estado', 'DepartamentoController');
    Route::get('estado/{id}/delete', 'DepartamentoController@destroy')->name('estado.delete');
    Route::get('estado/{id}/ciudades', 'DepartamentoController@ciudades')->name('estado.ciudades');
    //CIUDADES  
    Route::resource('ciudad', 'CiudadController');
    Route::get('ciudad/{id}/delete', 'CiudadController@destroy')->name('ciudad.delete');
    //ASOCIACIÓN GENERAL 
    Route::resource('iasd', 'IasdController');
    Route::get('iasd/{id}/delete', 'IasdController@destroy')->name('iasd.delete');
    //DIVISIÓN 
    Route::resource('division', 'DivisionController');
    Route::get('division/{id}/delete', 'DivisionController@destroy')->name('division.delete');
    //UNIÓN 
    Route::resource('union', 'UnionController');
    Route::get('union/{id}/delete', 'UnionController@destroy')->name('union.delete');
    //ASOCIACIÓN
    Route::resource('asociacion', 'AsociacionController');
    Route::get('asociacion/{id}/delete', 'AsociacionController@destroy')->name('asociacion.delete');
    //ZONA
    Route::resource('zona', 'ZonaController');
    Route::get('zona/{id}/delete', 'ZonaController@destroy')->name('zona.delete');
    //DISTRITOS
    Route::resource('distrito', 'DistritoController');
    Route::get('distrito/{id}/delete', 'DistritoController@destroy')->name('distrito.delete');
    //IGLESIAS Y GRUPOS
    Route::resource('iglesia', 'IglesiaController');
    Route::get('iglesia/{id}/delete', 'IglesiaController@destroy')->name('iglesia.delete');
    //TIPO DE MINISTERIO EXTRA-OFICIAL
    Route::resource('tipoministerio', 'TipoministerioController');
    Route::get('tipoministerio/{id}/delete', 'TipoministerioController@destroy')->name('tipoministerio.delete');
    //MINISTERIOS OFICIALES DE LA IGLESIA
    Route::resource('ministerio', 'MinisterioController');
    Route::get('ministerio/{id}/delete', 'MinisterioController@destroy')->name('ministerio.delete');
    //MINISTERIOS EXTRAOFICIALES DE LA IGLESIA
    Route::resource('ministerioextra', 'MinisterioextraController');
    Route::get('ministerioextra/{id}/delete', 'MinisterioextraController@destroy')->name('ministerioextra.delete');
});
