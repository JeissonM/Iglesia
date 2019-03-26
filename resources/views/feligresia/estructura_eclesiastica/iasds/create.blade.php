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
                    GESTIÓN DE LA ASOCIACIÓN GENERAL - CREAR UNA NUEVA ASOCIACIÓN GENERAL
                </h2>
            </div>
            <div class="body">
                <div class="alert bg-teal alert-dismissible" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
                    <strong>Agregue nuevas asociaciones.</strong> Gestione la información de la asociación general de los adventistas de todo el mundo. Usted puede crear varios registros de asociación general, pero solo uno debe estar marcado como actual; recuerdelo!
                </div>
                <div class="col-md-12">
                    @component('layouts.errors')
                    @endcomponent
                </div>
                <h1 class="card-inside-title">DATOS DE LA ASOCIACIÓN</h1>
                <div class="row clearfix">
                    <div class="col-md-12">
                        {!! Form::open(['route'=>'iasd.store','method'=>'POST','class'=>'form-horizontal'])!!}
                        <div class="col-md-12">
                            <div class="form-group">
                                <div class="col-md-6">
                                    <div class="form-line">
                                        <label class="control-label">Nombre Asociación General</label>
                                        {!! Form::text('nombre',null,['class'=>'form-control','placeholder'=>'Nombre oficial de la conferencia general','required']) !!}
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-line">
                                        <label class="control-label">Descripción</label>
                                        {!! Form::text('descripcion',null,['class'=>'form-control','placeholder'=>'Descripción de la asociación']) !!}
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-md-6">
                                    <div class="form-line">
                                        <label class="control-label">País de Ubicación</label>
                                        {!! Form::select('pais_id',$paises,null,['class'=>'form-control','placeholder'=>'-- Seleccione una opción --','id'=>'pais_id','onchange'=>'getEstados()']) !!}
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-line">
                                        <label class="control-label">Departamento/Estado</label>
                                        {!! Form::select('departamento_id',[],null,['class'=>'form-control','placeholder'=>'-- Seleccione una opción --','id'=>'departamento_id','onchange'=>'getCiudades()']) !!}
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-md-6">
                                    <div class="form-line">
                                        <label class="control-label">Ciudad de Ubicación</label>
                                        {!! Form::select('ciudad_id',[],null,['class'=>'form-control','placeholder'=>'-- Seleccione una opción --','id'=>'ciudad_id']) !!}
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-line">
                                        <label class="control-label">Dirección de Ubicación</label>
                                        {!! Form::text('direccion',null,['class'=>'form-control','placeholder'=>'Dirección de ubicación de la asociación']) !!}
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-md-6">
                                    <div class="form-line">
                                        <label class="control-label">Definir la Asociación General Como Actual (Todas las demás deben estar señaladas como NO en su campo Actual)</label>
                                        {!! Form::select('actual',['1'=>'SI','0'=>'NO'],null,['class'=>'form-control','placeholder'=>'-- Seleccione una opción --']) !!}
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-line">
                                        <label class="control-label">Sitio Web de la Asociación</label>
                                        {!! Form::text('sitioweb',null,['class'=>'form-control','placeholder'=>'Sitio web oficial de la asociación']) !!}
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <br/><br/><a href="{{route('iasd.index')}}" class="btn bg-red waves-effect">Cancelar</a>
                                <button class="btn bg-indigo waves-effect" type="reset">Limpiar Formulario</button>
                                {!! Form::submit('Guardar',['class'=>'btn bg-green waves-effect']) !!}
                            </div>
                        </div>
                        {!! Form::close() !!}
                    </div>
                </div>
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