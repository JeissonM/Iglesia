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
    $anun = \DB::select("SELECT * FROM anuncios WHERE imagen<>'NO' AND estado='VIGENTE'");
    $anuncios = null;
    if ($anun != null) {
        foreach ($anun as $a) {
            $data = null;
            $data['anuncio'] = $a;
            if ($a->tipo == 'LOCAL') {
                $data['relacion'] = \DB::select("SELECT * FROM iglesias WHERE id=" . $a->iglesia_id);
            }
            if ($a->tipo == 'DISTRITO') {
                $data['relacion'] = \DB::select("SELECT * FROM distritos WHERE id=" . $a->distrito_id);
            }
            if ($a->tipo == 'ASOCIACION') {
                $data['relacion'] = \DB::select("SELECT * FROM asociacions WHERE id=" . $a->asociacion_id);
            }
            $anuncios[] = $data;
        }
    }
    $iglesias = \DB::select("SELECT * FROM iglesias");
    foreach ($iglesias as $i) {
        $p = \DB::select("SELECT * FROM pastors WHERE distrito_id='" . $i->distrito_id . "'");
        $pastor = null;
        if ($p != null) {
            $pn = \DB::select("SELECT * FROM personanaturals WHERE id='" . $p[0]->personanatural_id . "'");
            $pastor = $pn[0]->primer_nombre . " " . $pn[0]->segundo_nombre . " " . $pn[0]->primer_apellido . " " . $pn[0]->segundo_apellido;
        }
        $i->pastor = $pastor;
        $i->ciudad=\DB::select("SELECT * FROM ciudads WHERE id='" . $i->ciudad_id . "'");
        $i->distrito=\DB::select("SELECT * FROM distritos WHERE id='" . $i->distrito_id . "'");
    }
    $ministerios=\DB::select("SELECT * FROM ministerioextras LIMIT 6");
    $ministerios2=\DB::select("SELECT * FROM ministerioextras");
    $agendas=\DB::select("SELECT * FROM agendaasociacions WHERE estado='ACTIVA'");
    foreach ($agendas as $a) {
        $a->asociacion=\DB::select("SELECT * FROM asociacions WHERE id='" . $a->asociacion_id . "'");
        $a->periodo=\DB::select("SELECT * FROM periodos WHERE id='" . $a->periodo_id . "'");
    }
    $ciudades=\DB::select("SELECT * FROM ciudads");
    foreach ($ciudades as $c) {
        $estado=\DB::select("SELECT * FROM estados WHERE id='" . $c->estado_id . "'");
        $c->pais=\DB::select("SELECT * FROM pais WHERE id='" . $estado[0]->pais_id . "'");
    }
    return view('welcome')
                    ->with('anuncios', $anuncios)
                    ->with('iglesias', $iglesias)
                    ->with('ministerios', $ministerios)
                    ->with('ministerios2', $ministerios2)
                    ->with('agendas', $agendas)
                    ->with('ciudades', $ciudades);
});

Route::get('anuncios/{id}/ver', 'PublicController@anuncio')->name('anuncio');
Route::get('creencias/ver', 'PublicController@creencias')->name('creencias');
Route::get('institucional/ver', 'PublicController@institucional')->name('institucionalp');
Route::post('pedidos/oracion/crear', 'PublicController@hacerpedido')->name('hacerpedido');
Route::post('pedidos/oracion/consultar/rastrear', 'PublicController@consultarpedido')->name('consultarpedido');
Route::get('ministeriosextra/{id}/ver', 'PublicController@minextraver')->name('minextraver');
Route::get('ciudadp/{id}/iglesia', 'PublicController@iglesia')->name('public.iglesia');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

//TODOS LOS MENUS
//GRUPO DE RUTAS PARA LA ADMINISTRACIÓN
Route::group(['middleware' => 'auth', 'prefix' => 'admin'], function() {
    Route::get('usuarios', 'MenuController@usuarios')->name('admin.usuarios');
    Route::get('feligresia', 'MenuController@feligresia')->name('admin.feligresia');
    Route::get('situacion', 'MenuController@situacion')->name('admin.situacion');
    Route::post('menuexperiencia/operaciones/consultar/traer', 'MenuController@operaciones')->name('admin.operaciones');
    Route::get('experienciafeligres/cosultar/ir', 'MenuController@experienciafeligres')->name('admin.experienciafeligres');
    Route::post('acceso', 'HomeController@confirmaRol')->name('rol');
    Route::get('inicio', 'HomeController@inicio')->name('inicio');
    Route::get('gestiondocumental', 'MenuController@gestiondocumental')->name('admin.gestiondocumental');
    Route::get('comunicacion', 'MenuController@comunicacion')->name('admin.comunicacion');
    Route::get('editorial', 'MenuController@editorial')->name('admin.editorial');
    Route::get('institucional', 'MenuController@institucional')->name('admin.institucional');
    Route::get('auditoria', 'MenuController@auditoria')->name('admin.auditoria');
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
    Route::get('usuario/gestion/crear/automatico', 'UsuarioController@automatico')->name('usuario.automatico');
    Route::post('usuario/gestion/crear/automatico/store', 'UsuarioController@automaticostore')->name('usuario.automaticostore');
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
    Route::get('ministerioextra/{id}/miembros', 'MinisterioextraController@miembros')->name('ministerioextra.miembros');
    Route::get('ministerioextra/{ministerio}/{miembro}/delete', 'MinisterioextraController@destroy2')->name('ministerioextra.delete2');
    Route::post('ministerioextra/miembros/crear', 'MinisterioextraController@miembroscrear')->name('ministerioextra.miembroscrear');
    //MINISTERIOS EXTRAOFICIALES DE LA IGLESIA CREACIÓN Y ADMINISTRACIÓN
    Route::resource('ministerionooficial', 'MinisterionooficialController');
    Route::get('ministerionooficial/{id}/delete', 'MinisterionooficialController@destroy')->name('ministerionooficial.delete');
    //PERIODO
    Route::resource('periodo', 'PeriodoController');
    Route::get('periodo/{id}/delete', 'PeriodoController@destroy')->name('periodo.delete');
    //CARGO IGLESIA
    Route::resource('cargogeneral', 'CargogeneralController');
    Route::get('cargogeneral/{id}/delete', 'CargogeneralController@destroy')->name('cargogeneral.delete');
    //CATEGORÍA DE LABOR
    Route::resource('categorialabor', 'CategorialaborController');
    Route::get('categorialabor/{id}/delete', 'CategorialaborController@destroy')->name('categorialabor.delete');
    Route::get('categorialabor/{id}/categoria/labores', 'CategorialaborController@labores')->name('categorialabor.labores');
    //LABOR
    Route::resource('labor', 'LaborController');
    Route::get('labor/{id}/delete', 'LaborController@destroy')->name('labor.delete');
    Route::get('labor/{id}/feligreses/listar', 'LaborController@feligreses')->name('labor.feligreses');
    //ESTADO CIVIL
    Route::resource('estadocivil', 'EstadocivilController');
    Route::get('estadocivil/{id}/delete', 'EstadocivilController@destroy')->name('estadocivil.delete');
    //TIPO DE DOCUMENTO
    Route::resource('tipodoc', 'TipodocumentoController');
    Route::get('tipodoc/{id}/delete', 'TipodocumentoController@destroy')->name('tipodoc.delete');
    //FELIGRESES
    Route::resource('feligres', 'FeligresController');
    Route::get('feligres/{id}/delete', 'FeligresController@destroy')->name('feligres.delete');
    Route::get('feligres/{identificacion}/listar/consultar', 'FeligresController@getFeligres')->name('feligres.feligres');
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
    Route::get('junta/menu/{feligres}/periodo/{periodo}/continuar', 'JuntaController@continuar')->name('junta.continuar');
    Route::get('junta/{id}/cerrarjunta', 'JuntaController@cerrarJunta')->name('junta.cerrarjunta');
    //MIEMBROS DE JUNTA
    Route::get('junta/menu/periodo/continuar/menu/{feligres}/{periodo}/{junta}/miembros', 'JuntaController@miembros')->name('junta.miembros');
    Route::get('junta/menu/periodo/continuar/menu/{feligres}/{periodo}/{junta}/miembros/crear/miembro', 'JuntaController@crearmiembro')->name('junta.crearmiembro');
    Route::post('junta/menu/periodo/continuar/menu/miembros/agregar/miembro', 'JuntaController@agregarmiembro')->name('junta.agregarmiembro');
    Route::get('junta/menu/periodo/continuar/menu/{feligres}/{periodo}/{junta}/miembros/{miembro}/eliminar/miembro/cargo', 'JuntaController@eliminarmiembro')->name('junta.eliminarmiembro');
    //AGENDA DE REUNIÓN DE JUNTA
    Route::get('junta/menu/periodo/continuar/menu/{feligres}/{periodo}/{junta}/agenda/junta', 'JuntaController@agendajuntaindex')->name('junta.agendajuntaindex');
    Route::post('junta/menu/periodo/continuar/menu/agenda/junta/crearagendajunta', 'JuntaController@crearagendajunta')->name('junta.crearagendajunta');
    Route::get('junta/menu/periodo/continuar/menu/{feligres}/{periodo}/{junta}/agenda/junta/{agendajunta}/eliminaragendajunta', 'JuntaController@eliminaragendajunta')->name('junta.eliminaragendajunta');
    Route::get('junta/menu/periodo/continuar/menu/{feligres}/{periodo}/{junta}/agenda/junta/{agendajunta}/puntosagendajunta/index', 'JuntaController@puntosagendajuntaindex')->name('junta.puntosagendajuntaindex');
    Route::post('junta/menu/periodo/continuar/menu/agenda/junta/puntosagendajunta/index/crearpunto', 'JuntaController@puntosagendajuntacrear')->name('junta.puntosagendajuntacrear');
    Route::get('junta/menu/periodo/continuar/menu/{feligres}/{periodo}/{junta}/agenda/junta/{agendajunta}/puntosagendajunta/{punto}/eliminarpunto', 'JuntaController@puntosagendajuntaeliminarpunto')->name('junta.puntosagendajuntaeliminarpunto');
    //REUNIONES DE JUNTA Y ACTAS
    Route::get('junta/menu/periodo/continuar/menu/{feligres}/{periodo}/{junta}/reuniones/junta', 'JuntaController@reunionjuntaindex')->name('junta.reunionjuntaindex');
    Route::post('junta/menu/periodo/continuar/menu/reuniones/junta/agregar/reunion', 'JuntaController@reunionjuntaagregar')->name('junta.reunionjuntaagregar');
    Route::get('junta/menu/periodo/continuar/menu/{feligres}/{periodo}/{junta}/reuniones/{reunion}/junta/ver', 'JuntaController@reunionjuntaver')->name('junta.reunionjuntaver');
    Route::get('junta/menu/periodo/continuar/menu/{feligres}/{periodo}/{junta}/reuniones/junta/{reunion}/delete', 'JuntaController@reunionjuntadelete')->name('junta.reunionjuntadelete');
    Route::get('junta/menu/periodo/continuar/menu/{feligres}/{periodo}/reuniones/obtenerreunion', 'JuntaController@getReunion')->name('junta.getreunion');
    //TRASLADOS DE FELIGRESIA
    Route::resource('solicitud', 'SolicitudtrasladoController');
    Route::get('solicitud/{id}/delete', 'SolicitudtrasladoController@destroy')->name('solicitud.delete');
    Route::get('solicitud/get/{identificacion}/feligres', 'SolicitudtrasladoController@getfeligres')->name('solicitud.getfeligres');
    Route::get('solicitud/{periodo}/{iglesia}/getactas', 'SolicitudtrasladoController@getactas')->name('solicitud.getactas');
    Route::get('solicitud/{id}/procesar', 'SolicitudtrasladoController@procesar')->name('solicitud.procesar');
    Route::put('solicitud/{id}/finalizar/solicitud', 'SolicitudtrasladoController@finalizar')->name('solicitud.finalizar');
    //APLICAR DISCIPLINA
    Route::resource('disciplina', 'DisciplinaController');
    Route::get('disciplina/{id}/inicio', 'DisciplinaController@inicio')->name('disciplina.inicio');
    Route::get('disciplina/{id}/delete', 'DisciplinaController@destroy')->name('disciplina.delete');
    //SITUACIÓN
    Route::resource('situacion', 'SituacionfeligresController');
    Route::get('situacion/{id}/delete', 'SituacionfeligresController@destroy')->name('situacion.delete');
    Route::get('situacion/list/index2', 'SituacionfeligresController@index2')->name('situacion.index2');
    Route::post('situacion/actualizar/operaciones/consultar/traer', 'SituacionfeligresController@getfeligres')->name('situacion.getfeligres');
    Route::post('situacion/actualizar/situacion/estado', 'SituacionfeligresController@actualizar')->name('situacion.actualizar');
    //SEGUIMIENTO DE UBICACION DE LOS MIEMBROS
    Route::resource('seguimientoubucacion', 'SeguimientoubucacionController');
    Route::get('seguimientoubucacion/{id}/delete', 'SeguimientoubucacionController@destroy')->name('seguimientoubucacion.delete');
    Route::get('seguimientoubucacion/{id}/consultar/seguimiento', 'SeguimientoubucacionController@index')->name('seguimientoubucacion.index');
});

//GRUPO DE RUTAS PARA LA GESTIÓN DOCUMENTAL
Route::group(['middleware' => 'auth', 'prefix' => 'gestiondocumental'], function() {
    //LISTA DE PREDICACION
    Route::resource('listapredicacion', 'ListapredicacionController');
    Route::get('listapredicacion/{id}/crear/lista', 'ListapredicacionController@create')->name('listapredicacion.crear');
    Route::get('listapredicacion/{id}/delete', 'ListapredicacionController@destroy')->name('listapredicacion.delete');
    Route::post('listapredicacion/store/configurar', 'ListapredicacionController@store2')->name('listapredicacion.store2');
    Route::get('listapredicacion/{id}/crear/lista/items', 'ListapredicacionController@create2')->name('listapredicacion.crear2');
    Route::get('listapredicacion/{id}/crear/lista/items/{iditem}/delete', 'ListapredicacionController@delete2')->name('listapredicacion.delete2');
    //ITINERARIO DE CULTO
    Route::resource('itinerario', 'ItinerarioController');
    Route::get('itinerario/{id}/delete', 'ItinerarioController@destroy')->name('itinerario.delete');
    Route::get('itinerario/{asosciacion}/consultar/getdistritos', 'ItinerarioController@getDistritos')->name('itinerario.getdistritos');
    //ITINERARIO DETALLES
    Route::resource('itinerariodetalle', 'ItinerariodetalleController');
    Route::get('itinerariodetalle/{id}/delete', 'ItinerariodetalleController@destroy')->name('itinerariodetalle.delete');
    Route::get('itinerariodetalle/{id}/inicio', 'ItinerariodetalleController@index')->name('itinerariodetalle.inicio');
    //ACTAS DE JUNTA
    Route::get('junta/actas', 'JuntaController@indexActa')->name('junta.indexacta');
    Route::get('junta/actas/{feligres}/{periodo}/reuniones', 'JuntaController@reunionesActa')->name('junta.reunionesacta');
    Route::get('junta/actas/{feligres}/{periodo}/{junta}/reuniones/{reunion}/junta/ver/gd', 'JuntaController@reunionjuntaveracta')->name('junta.reunionjuntaveracta');
    //RECURSOS MINISTERIALES
    Route::resource('recursosministeriales', 'RecursosministerialController');
    Route::get('recursosministeriales/{id}/delete', 'RecursosministerialController@destroy')->name('recursosministeriales.delete');
    Route::get('recursosministeriales/{periodo}/create', 'RecursosministerialController@create')->name('recursosministeriales.create2');
    Route::post('recursosministeriales/create/edit/items', 'RecursosministerialController@store2')->name('recursosministeriales.store2');
    Route::get('recursosministeriales/items/{recurso}/{id}/delete', 'RecursosministerialController@destroy2')->name('recursosministeriales.delete2');
    Route::get('recursosministeriales/lista/recursos/visualizacion/index', 'RecursosministerialController@visualizacionindex')->name('recursosministeriales.visualizacionindex');
    Route::get('recursosministeriales/lista/recursos/visualizacion/index/{id}/ver', 'RecursosministerialController@visualizacionver')->name('recursosministeriales.visualizacionver');
    //MULTIMEDIA MINISTERIAL
    Route::resource('multimediaministerial', 'MultimediaministerialController');
    Route::get('multimediaministerial/{id}/lista/multimedia', 'MultimediaministerialController@lista')->name('multimediaministerial.lista');
    Route::get('multimediaministerial/{id}/delete', 'MultimediaministerialController@destroy')->name('multimediaministerial.delete');
    Route::get('multimediaministerial/{ministerio}/create', 'MultimediaministerialController@create')->name('multimediaministerial.create2');
    Route::post('multimediaministerial/create/edit/items', 'MultimediaministerialController@store2')->name('multimediaministerial.store2');
    Route::get('multimediaministerial/items/{recurso}/{id}/delete', 'MultimediaministerialController@destroy2')->name('multimediaministerial.delete2');
    Route::get('multimediaministerial/lista/multimedia/visualizacion/index', 'MultimediaministerialController@visualizacionindex')->name('multimediaministerial.visualizacionindex');
    Route::get('multimediaministerial/lista/multimedia/visualizacion/index/{id}/ver', 'MultimediaministerialController@visualizacionver')->name('multimediaministerial.visualizacionver');
    //CATEGORIA LIBRO
    Route::resource('categorialibro', 'CategorialibroController');
    Route::get('categorialibro/{id}/delete', 'CategorialibroController@destroy')->name('categorialibro.delete');
    //LIBRO
    Route::resource('libro', 'LibroController');
    Route::get('libro/{id}/delete', 'LibroController@destroy')->name('libro.delete');
    Route::get('libro/{id}/cambiar/documento', 'LibroController@edit_doc')->name('libro.editdoc');
    Route::put('libro/{id}/documento', 'LibroController@documento')->name('libro.documento');
    Route::get('libro/cambiar/{id}/imagen', 'LibroController@edit_img')->name('libro.editimg');
    Route::put('libro/{id}/imagen', 'LibroController@imagen')->name('libro.imagen');
    //SERMONES
    Route::resource('sermon', 'SermonController');
    Route::get('sermon/{id}/delete', 'SermonController@destroy')->name('sermon.delete');
});

//GRUPO DE RUTAS PARA LA COMUNICACIÓN
Route::group(['middleware' => 'auth', 'prefix' => 'comunicacion'], function() {
    //AGENDA ASOCIACIÓN
    Route::resource('agendaasociacion', 'AgendaasociacionController');
    Route::get('agendaasociacion/{id}/delete', 'AgendaasociacionController@destroy')->name('agendaasociacion.delete');
    Route::get('agendaasociacion/{id}/estado/cambiar', 'AgendaasociacionController@estado')->name('agendaasociacion.estado');
    //DIRECTORIO IGLESIA
    Route::get('iglesia/directorio/listar', 'IglesiaController@directorioiglesia')->name('iglesia.directorio');
    Route::get('iglesia/{id}/{tipo}/directorio/getiglesias', 'IglesiaController@iglesias')->name('iglesia.getiglesias');
    //DIRECTORIO FELIGRES
    Route::get('feligres/directorio/feligres/listar', 'FeligresController@directoriofeligres')->name('feligres.directorio');
    Route::get('feligres/{id}/{tipo}/directorio/feligres/getfeligres', 'FeligresController@feligres')->name('feligres.getifeligres');
    Route::get('feligres/{id}/directorio/feligres/ver', 'FeligresController@ver')->name('feligres.ver');
    //PEDIOS DE ORACIÓN
    Route::resource('pedidosoracion', 'PedidosoracionController');
    Route::get('pedidosoracion/{id}/delete', 'PedidosoracionController@destroy')->name('pedidosoracion.delete');
    Route::post('pedidosoracion/store/configurar', 'PedidosoracionController@cambiarestado')->name('pedidosoracion.store2');
    //ANUNCIOS
    Route::resource('anuncios', 'AnuncioController');
    Route::get('anuncios/{id}/delete', 'AnuncioController@destroy')->name('anuncios.delete');
    Route::get('anuncios/{id}/estado/cambiar/estado', 'AnuncioController@estado')->name('anuncios.estado');
    Route::get('anuncios/proyector/visualizar/index', 'AnuncioController@visualizar')->name('anuncios.visualizar');
    //ENCONTRAR UNA IGLESIA
    Route::resource('iglesiamapa', 'IglesiamapaController');
    Route::get('iglesiamapa/{id}/delete', 'IglesiamapaController@destroy')->name('iglesiamapa.delete');
    //DIRECTORIO CONTRACTUAL
    Route::get('directoriocontractual', 'DirectoriocontractualController@index')->name('directoriocontractual.index');
    Route::get('directoriocontractual/{id}/show', 'DirectoriocontractualController@show')->name('directoriocontractual.ver');
    //NOTIFICACIONES
    Route::resource('notificaciones', 'NotificacionController');
    Route::get('notificaciones/{id}/change', 'NotificacionController@change')->name('notificaciones.change');
    //MISION
    Route::resource('mision', 'MisionController');
    Route::get('mision/{id}/delete', 'MisionController@destroy')->name('mision.delete');
    //VISION
    Route::resource('vision', 'VisionController');
    Route::get('vision/{id}/delete', 'VisionController@destroy')->name('vision.delete');
    //VALORES
    Route::resource('valor', 'ValorController');
    Route::get('valor/{id}/delete', 'ValorController@destroy')->name('valor.delete');
    //HISTORIA
    Route::resource('historia', 'HistoriaController');
    Route::get('historia/{id}/delete', 'HistoriaController@destroy')->name('historia.delete');
    //CONTACTO
    Route::resource('contacto', 'ContactoController');
    Route::get('contacto/{id}/delete', 'ContactoController@destroy')->name('contacto.delete');
    //CHAT
    Route::resource('chat', 'ChatController');
    Route::get('chat/{id}/delete', 'ChatController@destroy')->name('chat.delete');
    Route::get('chat/{id}/delete/chat', 'ChatController@destroyChat')->name('chat.chatdelete');
    Route::get('chat/{contacto}/{chat}/show/chat', 'ChatController@show')->name('chat.chatshow');
});

//GRUPO DE RUTAS PARA LA AUDITORÍA
Route::group(['middleware' => 'auth', 'prefix' => 'auditoria'], function() {
    //RUTA GENÉRICA
    Route::get('menu/{modulo}/index', 'AuditoriaController@index')->name('auditoria.index');
    Route::post('menu/index/filtro/consultar', 'AuditoriaController@filtro')->name('auditoria.filtro');
    Route::get('menu/index/filtro/consultar/{modulo}/{fecha1}/{fecha2}/txt', 'AuditoriaController@txt')->name('auditoria.txt');
});
