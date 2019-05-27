@extends('layouts.admin')
@section('breadcrumb')
<ol class="breadcrumb breadcrumb-bg-blue-grey" style="margin-bottom: 30px;">
    <li><a href="{{route('inicio')}}">Inicio</a></li>
    <li><a href="{{route('admin.gestiondocumental')}}">Gestión Documental</a></li>
    <li><a href="{{route('itinerario.index')}}">Itinerario</a></li>
    <li class="active"><a>Crear Itinerario</a></li>
</ol>
@endsection
@section('content')
<div class="row clearfix">
    <div class="col-md-12">
        <div class="card">
            <div class="header">
                <h2>
                    ITINERARIO - CREAR ITINERARIO<small>Haga clic en el botón de 3 puntos de la derecha de este título para obtener ayuda.</small>
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
                <h1 class="card-inside-title">DATOS DEL ITINERARIO</h1>
                <div class="row clearfix">
                    <div class="col-md-12">
                        <form class="form-horizontal" role='form' method="POST" action="{{route('itinerario.store')}}">
                            @csrf 
                            <div class="col-md-6">
                                <div class="form-group">
                                    <div class="form-line">
                                        <label class="control-label">Asociación</label>
                                        <br/><select class="form-control show-tick select2" name="asociacion" onchange="getDistritos()" id="asociacion">
                                            <option value="">--Seleccione una opción--</option>
                                            @foreach($asociaciones as $key=>$value)
                                            <option value="{{$key}}">{{$value}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="form-line">
                                        <label class="control-label">Distrito</label>
                                        <br/><select class="form-control show-tick select2" name="distrito" id="distrito" onchange="getIglesias()">
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="form-line">
                                        <label class="control-label">Iglesia</label>
                                        <br/><select class="form-control show-tick select2" name="iglesia_id" id="iglesia_id" required="required">
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6" style="margin-top: 8px;">
                                <div class="form-group">
                                    <div class="form-line">
                                        <br/><input class="form-control" type="text" placeholder="Titulo" required="required" name="titulo">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="form-line">
                                        <label class="control-label">Fecha del Evento</label>
                                        <br/><input class="form-control" type="date" name="fecha">    
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="form-line">
                                        <label class="control-label">Periodo</label>
                                        <br/><select class="form-control show-tick select2" name="periodo_id">
                                            <option value="">--Seleccione una opción--</option>
                                            @foreach($periodos as $key=>$value)
                                            <option value="{{$key}}">{{$value}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <br/><br/><a href="{{route('itinerario.index')}}" class="btn bg-red waves-effect">Cancelar</a>
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
                <h4 class="modal-title" id="defaultModalLabel">SOBRE LOS ITINERARIOS</h4>
            </div>
            <div class="modal-body">
                <strong>Agregue nuevos itinerarios,</strong>Administre los eventos, reuniones, etc; para un período y una iglesia.
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
    $(".chosen-select").chosen({});

    function getDistritos() {
        var id = $("#asociacion").val();
        $.ajax({
            type: 'GET',
            url: url + "gestiondocumental/itinerario/" + id + "/consultar/getdistritos",
            data: {},
        }).done(function (msg) {
            $('#distrito option').each(function () {
                $(this).remove();
            });
            $('#iglesia_id option').each(function () {
                $(this).remove();
            });
            if (msg !== "null") {
                var m = JSON.parse(msg);
                $("#distrito").append("<option value=''>-- Seleccione una opción--</option>");
                $.each(m, function (index, item) {
                    $("#distrito").append("<option value='" + item.id + "'>" + item.value + "</option>");
                });
            } else {
                notify('Atención', 'La Asociación seleccionada no posee distritos asociados.', 'error');
            }
        });
    }


    function getIglesias() {
        var id = $("#distrito").val();
        $.ajax({
            type: 'GET',
            url: url + "feligresia/distrito/" + id + "/iglesias",
            data: {},
        }).done(function (msg) {
            $('#iglesia_id option').each(function () {
                $(this).remove();
            });
            if (msg !== "null") {
                var m = JSON.parse(msg);
                $.each(m, function (index, item) {
                    $("#iglesia_id").append("<option value='" + item.id + "'>" + item.value + "</option>");
                });
            } else {
                notify('Atención', 'El Distrito seleccionado no posee iglesias asociadas.', 'error');
            }
        });
    }
</script>
@endsection