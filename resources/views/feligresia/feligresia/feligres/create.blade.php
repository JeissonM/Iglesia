@extends('layouts.admin')
@section('breadcrumb')
<ol class="breadcrumb breadcrumb-bg-blue-grey" style="margin-bottom: 30px;">
    <li><a href="{{route('inicio')}}">Inicio</a></li>
    <li><a href="{{route('admin.feligresia')}}">Feligresía</a></li>
    <li><a href="{{route('admin.feligresia')}}">Feligresía</a></li>
    <li><a href="{{route('feligres.index')}}">Miembros de Iglesia</a></li>
    <li class="active"><a>Crear Feligrés</a></li>
</ol>
@endsection
@section('content')
<div class="row clearfix">
    <div class="col-md-12">
        <div class="card">
            <div class="header">
                <h2>
                    MIEMBROS DE IGLESIA - CREAR FELIGRÉS<small>Haga clic en el botón de 3 puntos de la derecha de este título para obtener ayuda.</small>
                </h2>
                <ul class="header-dropdown m-r--5">
                    <li class="dropdown">
                        <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                            <i class="material-icons">more_vert</i>
                        </a>
                        <ul class="dropdown-menu pull-right">
                            <li><a data-toggle="modal" data-target="#mdModal">Ayuda</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
            <div class="body">
                <div class="col-md-12">
                    @component('layouts.errors')
                    @endcomponent
                </div>
                <h1 class="card-inside-title">DATOS DEL MIEMBRO</h1>
                <h4 style="color: red;">Los campos con asterísco (*) son obligatorios</h4>
                <div class="row clearfix">
                    <div class="col-md-12">
                        <form class="form-horizontal" role='form' method="POST" action="{{route('feligres.store')}}">
                            @csrf
                            <div id="wizard_vertical">
                                <h2>Información Personal</h2>
                                <section>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <div class="form-line">
                                                <label class="control-label">Tipo Documento*</label>
                                                <select class="form-control"  style="width: 100%;" required="required" name="tipodocumento_id">
                                                    @foreach($tipodoc as $key=>$value)
                                                    <option value="{{$key}}">{{$value}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="form-line">
                                                <br/><input class="form-control" type="text" placeholder="Lugar de Expedición" name="lugar_expedicion">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="form-line">
                                                <br/><input class="form-control" type="text" placeholder="Primer Nombre*" required="required" name="primer_nombre">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="form-line">
                                                <br/><input class="form-control" type="text" placeholder="Primer Apellido*" required="required" name="primer_apellido">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="form-line">
                                                <label class="control-label">Sexo*</label>
                                                <select class="form-control"  style="width: 100%;" required="required" name="sexo">
                                                    <option value="M">MASCULINO</option>
                                                    <option value="F">FEMENINO</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="form-line">
                                                <label class="control-label">Estado Civil</label>
                                                <select class="form-control"  style="width: 100%;" name="estadocivil_id">
                                                    @foreach($estadosc as $key=>$value)
                                                    <option value="{{$key}}">{{$value}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <div class="form-line">
                                                <br/><input class="form-control" type="text" placeholder="Escriba el número del documento de identidad*" required="required" name="numero_documento">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="form-line">
                                                <br/><label>Fecha de Expedición</label>
                                                <input class="form-control" type="date" placeholder="Fecha de Expedición" name="fecha_expedicion">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="form-line">
                                                <br/><input class="form-control" type="text" placeholder="Segundo Nombre" name="segundo_nombre">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="form-line">
                                                <br/><input class="form-control" type="text" placeholder="Segundo Apellido" name="segundo_apellido">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="form-line">
                                                <label class="control-label">Tipo Sanguíneo y RH</label>
                                                <select class="form-control"  style="width: 100%;" name="rh">
                                                    <option value="A+">A +</option>
                                                    <option value="A-">A -</option>
                                                    <option value="O+">O +</option>
                                                    <option value="O-">O -</option>
                                                    <option value="B-">B -</option>
                                                    <option value="B+">B +</option>
                                                    <option value="AB+">AB +</option>
                                                    <option value="AB-">AB -</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="form-line">
                                                <br/><input class="form-control" type="text" placeholder="Edad" name="edad">
                                            </div>
                                        </div>
                                    </div>
                                </section>
                                <h2>Información De Procedencia</h2>
                                <section>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <div class="form-line">
                                                <label>Fecha de Nacimiento</label>
                                                <input class="form-control" type="date" name="fecha_nacimiento">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="form-line">
                                                <label class="control-label">Estado/Dpto de Nacimiento</label>
                                                <select class="form-control"  style="width: 100%;" id="estado_id" name="estado_id" onchange="getCiudades(this.id, 'ciudad_id')"></select>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="form-line">
                                                </br><input class="form-control" type="text" placeholder="Otra Nacionalidad" maxlength="30" name="otra_nacionalidad">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <div class="form-line">
                                                <label class="control-label">País de Nacimiento</label>
                                                <select class="form-control"  style="width: 100%;" id="pais_id" name="pais_id" onchange="getEstados(this.id, 'estado_id', 'ciudad_id')">
                                                    @foreach($paises as $key=>$value)
                                                    <option value="{{$key}}">{{$value}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="form-line">
                                                <label class="control-label">Ciudad de Nacimiento</label>
                                                <select class="form-control"  style="width: 100%;" id="ciudad_id" name="ciudad_id"></select>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="form-line">
                                                </br><input class="form-control" type="text" placeholder="Número de Pasaporte Para Otra Nacionalidad" maxlength="50" name="numero_pasaporte">
                                            </div>
                                        </div>
                                    </div>
                                </section>
                                <h2>Información de Residencia y Ubicación</h2>
                                <section>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <div class="form-line">
                                                <label class="control-label">País de Residencia</label>
                                                <select class="form-control"  style="width: 100%;" id="paisr_id" name="paisr_id" onchange="getEstados(this.id, 'estador_id', 'ciudadr_id')">
                                                    @foreach($paises as $key=>$value)
                                                    <option value="{{$key}}">{{$value}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="form-line">
                                                <label class="control-label">Ciudad de Residencia</label>
                                                <select class="form-control"  style="width: 100%;" id="ciudadr_id" name="ciudadr_id"></select>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="form-line">
                                                </br><input class="form-control" type="email" name="email" placeholder="Correo Electrónico">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="form-line">
                                                </br><input class="form-control" type="text" name="celular" placeholder="Teléfono Celular">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <div class="form-line">
                                                <label class="control-label">Estado/Dpto de Residencia</label>
                                                <select class="form-control"  style="width: 100%;" id="estador_id" name="estador_id" onchange="getCiudades(this.id, 'ciudadr_id')"></select>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="form-line">
                                                </br><input class="form-control" type="text" name="direccion" placeholder="Dirección de Residencia">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="form-line">
                                                </br><input class="form-control" type="text" name="telefono" placeholder="Teléfono Fijo">
                                            </div>
                                        </div>
                                    </div>
                                </section>
                                <h2>Información Familiar</h2>
                                <section>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <div class="form-line">
                                                </br><input class="form-control" type="text" maxlength="250" name="padre" placeholder="Nombres y Apellidos del Padre" />
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="form-line">
                                                </br><input class="form-control" type="text" maxlength="250" name="madre" placeholder="Nombres y Apellidos de la Madre" />
                                            </div>
                                        </div>
                                    </div>
                                </section>
                                <h2>Información Académica y Profesional</h2>
                                <section>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <div class="form-line">
                                                <label class="control-label">Clase Libreta Militar</label>
                                                <select class="form-control"  style="width: 100%;" name="clase_libreta">
                                                    <option value="DE PRIMERA">DE PRIMERA</option>
                                                    <option value="DE SEGUNDA">DE SEGUNDA</option>
                                                    <option value="OTRA">OTRA</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="form-line">
                                                </br><input class="form-control" type="text" maxlength="10" name="distrito_militar" placeholder="Distrito militar (10 caracteres)" />
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="form-line">
                                                </br><input class="form-control" type="text" maxlength="250" name="ocupacion" placeholder="Ocupación del miembro" />
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="form-line">
                                                </br><input class="form-control" type="text" maxlength="250" name="ultimo_grado" placeholder="Último grado cursado" />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <div class="form-line">
                                                </br><input class="form-control" type="text" maxlength="15" name="libreta_militar" placeholder="Número de la libreta militar" />
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="form-line">
                                                </br><input class="form-control" type="text" maxlength="250" name="profesion" placeholder="Profesión del miembro" />
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="form-line">
                                                <label class="control-label">Nivel Estudio</label>
                                                <select class="form-control"  style="width: 100%;" name="nivel_estudio">
                                                    <option value="PRIMARIA">PRIMARIA</option>
                                                    <option value="SECUNDARIA">SECUNDARIA</option>
                                                    <option value="BACHILLERATO">BACHILLERATO</option>
                                                    <option value="TECNICO">TÉCNICO</option>
                                                    <option value="TECNOLOGO">TECNÓLOGO</option>
                                                    <option value="PROFESIONAL">PROFESIONAL</option>
                                                    <option value="ESPECIALISTA">ESPECIALISTA</option>
                                                    <option value="MAGISTER">MAGISTER</option>
                                                    <option value="DOCTOR">DOCTOR</option>
                                                    <option value="OTRO">OTRO</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </section>
                                <h2>Información de Bautismo</h2>
                                <section>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <div class="form-line">
                                                </br><input class="form-control" type="text" maxlength="250" name="religion_anterior" placeholder="Religión Anterior" />
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="form-line">
                                                <label class="control-label">Estado Actual*</label>
                                                <select class="form-control"  style="width: 100%;" name="estado_actual" required="">
                                                    <option value="ACTIVO">ACTIVO</option>
                                                    <option value="INACTIVO">INACTIVO</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="form-line">
                                                <label class="control-label">Aceptado Por*</label>
                                                <select class="form-control"  style="width: 100%;" name="aceptado_por" required="">
                                                    <option value="BAUTISMO">BAUTISMO</option>
                                                    <option value="PROFESION DE FE">PROFESIÓN DE FÉ</option>
                                                    <option value="TRASLADO">TRASLADO</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <div class="form-line">
                                                </br><input class="form-control" type="text" maxlength="250" name="pastor_oficiante" placeholder="Pastor Oficiante" />
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="form-line">
                                                </br><label>Fecha Bautismo*</label>
                                                <input class="form-control" type="date" name="fecha_bautismo" required="" />
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="form-line">
                                                <label class="control-label">Situación Actual</label>
                                                <select class="form-control"  style="width: 100%;" id="situacionfeligres_id" name="situacionfeligres_id">
                                                    <option value="">-- Seleccione una opción --</option>
                                                    @foreach($situacion as $key=>$value)
                                                    <option value="{{$key}}">{{$value}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <h4>PROCEDENCIA</h4>
                                        <div class="form-group">
                                            <div class="form-line">
                                                <label class="control-label">Asociación</label>
                                                <select class="form-control"  style="width: 100%;" id="asociacion_origen" name="asociacion_origen" onchange="getDistritos(this.id, 'distrito_origen', 'iglesia_origen')">
                                                    <option value="">-- Seleccione una opción --</option>
                                                    @foreach($asociaciones as $key=>$value)
                                                    <option value="{{$key}}">{{$value}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="form-line">
                                                <label class="control-label">Distrito</label>
                                                <select class="form-control"  style="width: 100%;" id="distrito_origen" name="distrito_origen" onchange="getIglesias(this.id, 'iglesia_origen')"></select>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="form-line">
                                                <label class="control-label">Iglesia/Grupo</label>
                                                <select class="form-control"  style="width: 100%;" id="iglesia_origen" name="iglesia_origen"></select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <h4>ACEPTADO EN</h4>
                                        <div class="form-group">
                                            <div class="form-line">
                                                <label class="control-label">Asociación</label>
                                                <select class="form-control"  style="width: 100%;" id="asociacion_destino" name="asociacion_destino" onchange="getDistritos(this.id, 'distrito_destino', 'iglesia_destino')">
                                                    <option value="">-- Seleccione una opción --</option>
                                                    @foreach($asociaciones as $key=>$value)
                                                    <option value="{{$key}}">{{$value}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="form-line">
                                                <label class="control-label">Distrito</label>
                                                <select class="form-control"  style="width: 100%;" id="distrito_destino" name="distrito_destino" onchange="getIglesias(this.id, 'iglesia_destino')"></select>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="form-line">
                                                <label class="control-label">Iglesia/Grupo</label>
                                                <select class="form-control"  style="width: 100%;" id="iglesia_destino" name="iglesia_destino"></select>
                                            </div>
                                        </div>
                                    </div>
                                </section>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <br/><br/><a href="{{route('feligres.index')}}" class="btn bg-red waves-effect">Cancelar</a>
                                    <button class="btn bg-indigo waves-effect" type="reset">Limpiar Formulario</button>
                                    <button class="btn bg-green waves-effect" type="submit">Guardar</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Modal -->
<div class="modal fade" id="mdModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content modal-col-orange">
            <div class="modal-header">
                <h4 class="modal-title" id="defaultModalLabel">SOBRE LOS MIEMBROS DE IGLESIA</h4>
            </div>
            <div class="modal-body">
                <strong>Agregue nuevos feligreses,</strong> son todos los miembros bautizados y registrados en el libro de secretaría de iglesia.
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-link waves-effect" data-dismiss="modal">ACEPTAR</button>
            </div>
        </div>
    </div>
</div>
@endsection
@section('script')
<script>
    $('.select2').select2();

    function getEstados(name, dpto, ciudad) {
        var id = $("#" + name).val();
        $.ajax({
            type: 'GET',
            url: url + "feligresia/pais/" + id + "/estados",
            data: {},
        }).done(function (msg) {
            $('#' + dpto + ' option').each(function () {
                $(this).remove();
            });
            $('#' + ciudad + ' option').each(function () {
                $(this).remove();
            });
            if (msg !== "null") {
                var m = JSON.parse(msg);
                $.each(m, function (index, item) {
                    $("#" + dpto).append("<option value='" + item.id + "'>" + item.value + "</option>");
                });
            } else {
                notify('Atención', 'El País seleccionado no posee información de estados.', 'error');
            }
        });
    }

    function getCiudades(name, ciudad) {
        var id = $("#" + name).val();
        $.ajax({
            type: 'GET',
            url: url + "feligresia/estado/" + id + "/ciudades",
            data: {},
        }).done(function (msg) {
            $('#' + ciudad + ' option').each(function () {
                $(this).remove();
            });
            if (msg !== "null") {
                var m = JSON.parse(msg);
                $.each(m, function (index, item) {
                    $("#" + ciudad).append("<option value='" + item.id + "'>" + item.value + "</option>");
                });
            } else {
                notify('Atención', 'El Estado seleccionado no posee información de ciudades.', 'error');
            }
        });
    }

    function getDistritos(name, distrito, iglesia) {
        var id = $("#" + name).val();
        $.ajax({
            type: 'GET',
            url: url + "feligresia/asociacion/" + id + "/distritos",
            data: {},
        }).done(function (msg) {
            $('#' + distrito + ' option').each(function () {
                $(this).remove();
            });
            $('#' + iglesia + ' option').each(function () {
                $(this).remove();
            });
            if (msg !== "null") {
                var m = JSON.parse(msg);
                $("#" + distrito).append("<option value=''>-- Seleccione una opción --</option>");
                $.each(m, function (index, item) {
                    $("#" + distrito).append("<option value='" + item.id + "'>" + item.value + "</option>");
                });
            } else {
                notify('Atención', 'La asociación seleccionada no posee información de distritos.', 'error');
            }
        });
    }

    function getIglesias(name, iglesia) {
        var id = $("#" + name).val();
        $.ajax({
            type: 'GET',
            url: url + "feligresia/distrito/" + id + "/iglesias",
            data: {},
        }).done(function (msg) {
            $('#' + iglesia + ' option').each(function () {
                $(this).remove();
            });
            if (msg !== "null") {
                var m = JSON.parse(msg);
                $("#" + iglesia).append("<option value=''>-- Seleccione una opción --</option>");
                $.each(m, function (index, item) {
                    $("#" + iglesia).append("<option value='" + item.id + "'>" + item.value + "</option>");
                });
            } else {
                notify('Atención', 'El distrito seleccionado no posee información de iglesias.', 'error');
            }
        });
    }
</script>
@endsection