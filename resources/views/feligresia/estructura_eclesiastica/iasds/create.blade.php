@extends('layouts.admin')
@section('breadcrumb')
<ol class="breadcrumb breadcrumb-bg-blue-grey" style="margin-bottom: 30px;">
    <li><a href="{{route('inicio')}}">Inicio</a></li>
    <li><a href="{{route('admin.feligresia')}}">Feligresía</a></li>
    <li><a href="{{route('admin.feligresia')}}">Estructura Eclesiástica</a></li>
    <li><a href="{{route('iasd.index')}}">Asociación General</a></li>
    <li class="active"><a>Crear Asociación General</a></li>
</ol>
@endsection
@section('content')
<div class="row clearfix">
    <div class="col-md-12">
        <div class="card">
            <div class="header">
                <h2>
                    GESTIÓN DE LA ASOCIACIÓN GENERAL - CREAR UNA NUEVA ASOCIACIÓN GENERAL<small>Haga clic en el botón de 3 puntos de la derecha de este título para obtener ayuda.</small>
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
                <h1 class="card-inside-title">DATOS DE LA ASOCIACIÓN</h1>
                <div class="row clearfix">
                    <div class="col-md-12">
                        <form class="form" role='form' method="POST" action="{{route('iasd.store')}}">
                            @csrf 
                            <div class="col-md-12">
                                <div class="form-group">
                                    <div class="col-md-6">
                                        <div class="form-line">
                                            <label class="control-label">Nombre Asociación General</label>
                                            <input class="form-control" type="text" placeholder="Nombre oficial de la conferencia general" required="required" name="nombre">    
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-line">
                                            <label class="control-label">Descripción</label>
                                            <input class="form-control" type="text" placeholder="Descripción de la asociación" name="descripcion">    
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-md-6">
                                        <div class="form-line">
                                            <label class="control-label">País de Ubicación</label>
                                            <select class="form-control"  style="width: 100%;" name="pais_id" id="pais_id" onchange="getEstados()">
                                                <option value="0">-- Seleccione una opción --</option>
                                                @foreach($paises as $key=>$value)
                                                <option value="{{$key}}">{{$value}}</option>
                                                @endforeach
                                            </select> 
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-line">
                                            <label class="control-label">Departamento/Estado</label>
                                            <select class="form-control"  style="width: 100%;" name="ciudad_id" id="departamento_id" onchange="getCiudades()">
                                            </select> 
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-md-6">
                                        <div class="form-line">
                                            <label class="control-label">Ciudad de Ubicación</label>
                                            <select class="form-control"  style="width: 100%;" name="ciudad_id" id="ciudad_id">
                                            </select> 
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-line">
                                            <label class="control-label">Dirección de Ubicación</label>
                                            <input class="form-control" type="text" placeholder="Dirección de ubicación de la asociación" name="direccion">    
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-md-6">
                                        <div class="form-line">
                                            <label class="control-label">Definir la Asociación General Como Actual (Todas las demás deben estar señaladas como NO en su campo Actual)</label>
                                            <select class="form-control"  style="width: 100%;" name="actual">
                                                <option>-- Seleccione una opción --</option>
                                                <option value="1">SI</option>
                                                <option value="0">NO</option>
                                            </select> 
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-line">
                                            <label class="control-label">Sitio Web de la Asociación</label>
                                            <input class="form-control" type="text" placeholder="Sitio web oficial de la asociación" name="sitioweb">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <br/><br/><a href="{{route('iasd.index')}}" class="btn bg-red waves-effect">Cancelar</a>
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
        <div class="modal-content modal-col-green">
            <div class="modal-header">
                <h4 class="modal-title" id="defaultModalLabel">SOBRE LA ASOCIACIÓN GENERAL</h4>
            </div>
            <div class="modal-body">
                <strong>Agregue nuevas asociaciones.</strong> Gestione la información de la asociación general de los adventistas de todo el mundo. Usted puede crear varios registros de asociación general, pero solo uno debe estar marcado como actual; recuerdelo!
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

    function getEstados() {
        var id = $("#pais_id").val();
        $.ajax({
            type: 'GET',
            url: url + "feligresia/pais/" + id + "/estados",
            data: {},
        }).done(function (msg) {
            $('#departamento_id option').each(function () {
                $(this).remove();
            });
            $('#ciudad_id option').each(function () {
                $(this).remove();
            });
            if (msg !== "null") {
                var m = JSON.parse(msg);
                $.each(m, function (index, item) {
                    $("#departamento_id").append("<option value='" + item.id + "'>" + item.value + "</option>");
                });
            } else {
                notify('Atención', 'El País seleccionado no posee información de estados.', 'error');
            }
        });
    }

    function getCiudades() {
        var id = $("#departamento_id").val();
        $.ajax({
            type: 'GET',
            url: url + "feligresia/estado/" + id + "/ciudades",
            data: {},
        }).done(function (msg) {
            $('#ciudad_id option').each(function () {
                $(this).remove();
            });
            if (msg !== "null") {
                var m = JSON.parse(msg);
                $.each(m, function (index, item) {
                    $("#ciudad_id").append("<option value='" + item.id + "'>" + item.value + "</option>");
                });
            } else {
                notify('Atención', 'El Estado seleccionado no posee información de ciudades.', 'error');
            }
        });
    }
</script>
@endsection