@extends('layouts.admin')
@section('breadcrumb')
<ol class="breadcrumb breadcrumb-bg-blue-grey" style="margin-bottom: 30px;">
    <li><a href="{{route('inicio')}}">Inicio</a></li>
    <li><a href="{{route('admin.feligresia')}}">Feligresía</a></li>
    <li><a href="{{route('admin.feligresia')}}">Feligresía</a></li>
    <li><a href="{{route('solicitud.index')}}">Traslados</a></li>
    <li class="active"><a>Crear Solicitud de Traslado</a></li>
</ol>
@endsection
@section('content')
<div class="row clearfix">
    <div class="col-md-12">
        <div class="card">
            <div class="header">
                <h2>
                    TRASLADO - CREAR SOLICITUD DE TRASLADO<small>Haga clic en el botón de 3 puntos de la derecha de este título para obtener ayuda.</small>
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
                <h1 class="card-inside-title">DATOS DE LA SOLICITUD</h1>
                <div class="row clearfix">
                    <div class="col-md-12">
                        <form class="form-horizontal" role='form' method="POST" action="{{route('solicitud.store')}}">
                            @csrf 
                            <input type="hidden" name="feligres_id" id="feligres_id"/>
                            <div class="col-sm-8">
                                <div class="form-group">
                                    <div class="form-line">
                                        <input type="text" id="identificacion" class="form-control" placeholder="Escriba la identificación a consultar" name="identificacion"/>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <button type="button" class="btn bg-orange waves-effect btn-block" onclick="consultar()">CONSULTAR FELIGRES</button>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <div class="form-line">
                                        <input class="form-control" type="text"  name="feligres" id="feligres" placeholder="Identificación del feligres" required="" />
                                    </div>
                                </div>
                                </br><h4>PROCEDENCIA</h4>
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
                                        <select class="form-control"  style="width: 100%;" id="iglesia_origen" name="iglesia_origen" required=""></select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <div class="form-line">
                                        <input class="form-control"  type="text" name="nombre" id="nombre" placeholder="Nombre del feligres" required="" />
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="form-line">
                                        </br><label>Fecha de Solicitud</label>
                                        <input class="form-control" type="date" name="fechasolicitud" required="" />
                                    </div>
                                </div>
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
                                        <select class="form-control"  style="width: 100%;" id="iglesia_destino" name="iglesia_destino" required=""></select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <br/><br/><a href="{{route('solicitud.index')}}" class="btn bg-red waves-effect">Cancelar</a>
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
                <h4 class="modal-title" id="defaultModalLabel">SOBRE LOS TRASLADOS</h4>
            </div>
            <div class="modal-body">
                <strong>Realice nueva solicitud de traslado,</strong> Administre las solicitudes de traslado de los feligreses.
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

    $(document).ready(function () {
        $("#nombre").attr('disabled', true);
        $("#feligres").attr('disabled', true);
    });
    function consultar() {
        var id = $("#identificacion").val();
        $.ajax({
            type: 'GET',
            url: url + "feligresia/solicitud/get/" + id + "/feligres",
            data: {},
        }).done(function (msg) {
            $('#feligres option').each(function () {
                $(this).remove();
            });
            $('#nombre option').each(function () {
                $(this).remove();
            });
            if (msg !== "null") {
                var m = JSON.parse(msg);
                $("#feligres_id").val(m.id);
                $("#feligres").val(m.identificacion);
                $("#nombre").val(m.nombre);
            } else {
                notify('Atención', 'No hay feligres registrado con la identificación ingresada.', 'error');
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