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
    Route::post('menuexperiencia/operaciones/consultar/traer', 'MenuController@operaciones')->name('admin.operaciones');
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
    Route::post('usuario/contrasenia/cambiar/admin/finalizar', 'UsuarioController@cambiarPass')->name('usuario.cambiarPass');
});

//GRUPO DE RUTAS PARA LA ADMINISTRACIÓN DEL MÓDULO DE FELIGRESÍA
Route::group(['middleware' => 'auth', 'prefix' => 'feligresia'], function() {
    //PAISES
    Route::resource('pais', 'PaisController');
    Route::get('pais/{id}/delete', 'PaisController@destroy')->name('pais.delete');
    Route::get('pais/{id}/estados', 'PaisController@estados')->name('pais.estados');
    //ESTADOS
    Route::resource('estado', 'EstadoController');
    Route::get('estado/{id}/delete', 'EstadoController@destroy')->name('estado.delete');
    Route::get('estado/{id}/ciudades', 'EstadoController@ciudades')->name('estado.ciudades');
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
    Route::get('asociacion/{id}/distritos', 'AsociacionController@distritos')->name('asociacion.distritos');
    //ZONA
    Route::resource('zona', 'ZonaController');
    Route::get('zona/{id}/delete', 'ZonaController@destroy')->name('zona.delete');
    //DISTRITOS
    Route::resource('distrito', 'DistritoController');
    Route::get('distrito/{id}/delete', 'DistritoController@destroy')->name('distrito.delete');
    Route::get('distrito/{id}/iglesias', 'DistritoController@iglesias')->name('distrito.iglesias');
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
    //PERIODO
    Route::resource('periodo', 'PeriodoController');
    Route::get('periodo/{id}/delete', 'PeriodoController@destroy')->name('periodo.delete');
    //CARGO IGLESIA
    Route::resource('cargogeneral', 'CargogeneralController');
    Route::get('cargogeneral/{id}/delete', 'CargogeneralController@destroy')->name('cargogeneral.delete');
    //CATEGORÍA DE LABOR
    Route::resource('categorialabor', 'CategorialaborController');
    Route::get('categorialabor/{id}/delete', 'CategorialaborController@destroy')->name('categorialabor.delete');
    //LABOR
    Route::resource('labor', 'LaborController');
    Route::get('labor/{id}/delete', 'LaborController@destroy')->name('labor.delete');
    //ESTADO CIVIL
    Route::resource('estadocivil', 'EstadocivilController');
    Route::get('estadocivil/{id}/delete', 'EstadocivilController@destroy')->name('estadocivil.delete');
    //TIPO DE DOCUMENTO
    Route::resource('tipodoc', 'TipodocumentoController');
    Route::get('tipodoc/{id}/delete', 'TipodocumentoController@destroy')->name('tipodoc.delete');
    //FELIGRESES
    Route::resource('feligres', 'FeligresController');
    Route::get('feligres/{id}/delete', 'FeligresController@destroy')->name('feligres.delete');
    //PASTORES
    Route::resource('pastor', 'PastorController');
    Route::get('pastor/{id}/delete', 'PastorController@destroy')->name('pastor.delete');
    Route::get('pastor/operaciones/consultar/{identificacion}/traer', 'PastorController@operaciones')->name('pastor.operaciones');
    //EXPERIENCIA LABOR
    Route::resource('experiencialabor', 'ExperiencialaborController');
    Route::get('experiencialabor/{id}/index2', 'ExperiencialaborController@index')->name('experiencialabor.index2');
    Route::get('experiencialabor/{id}/create2', 'ExperiencialaborController@create')->name('experiencialabor.create2');
    Route::get('experiencialabor/{id}/get/labores', 'ExperiencialaborController@getlabores')->name('experiencialabor.getlabores');
    Route::get('experiencialabor/{id}/delete', 'ExperiencialaborController@destroy')->name('experiencialabor.delete');
    //CONOCIMIENTO
    Route::resource('conocimiento', 'ConocimientoController');
    Route::get('conocimiento/{id}/index2', 'ConocimientoController@index')->name('conocimiento.index2');
    Route::get('conocimiento/{id}/create2', 'ConocimientoController@create')->name('conocimiento.create2');
    Route::get('conocimiento/{id}/delete', 'ConocimientoController@destroy')->name('conocimiento.delete');
    //JUNTA DE IGLESIA
    Route::resource('junta', 'JuntaController');
    Route::get('junta/{id}/delete', 'JuntaController@destroy')->name('junta.delete');
    Route::post('junta/menu/periodo/continuar', 'JuntaController@continuar')->name('junta.continuar');
    //MIEMBROS DE JUNTA
    Route::get('junta/menu/periodo/continuar/menu/{feligres}/{periodo}/{junta}/miembros', 'JuntaController@miembros')->name('junta.miembros');
    Route::get('junta/menu/periodo/continuar/menu/{feligres}/{periodo}/{junta}/miembros/crear/miembro', 'JuntaController@crearmiembro')->name('junta.crearmiembro');
    Route::get('junta/menu/periodo/continuar/menu/{feligres}/{periodo}/{junta}/miembros/{cargo}/agregar/miembro', 'JuntaController@agregarmiembro')->name('junta.agregarmiembro');
    //TRASLADOS DE FELIGRESIA
    Route::resource('solicitud', 'SolicitudtrasladoController');
    Route::get('solicitud/{id}/delete', 'SolicitudtrasladoController@destroy')->name('solicitud.delete');
    Route::get('solicitud/get/{identificacion}/feligres', 'SolicitudtrasladoController@getfeligres')->name('solicitud.getfeligres');
});
