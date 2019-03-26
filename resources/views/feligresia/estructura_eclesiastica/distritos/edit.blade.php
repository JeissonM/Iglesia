@extends('layouts.admin')
@section('breadcrumb')
<ol class="breadcrumb breadcrumb-bg-blue-grey" style="margin-bottom: 30px;">
    <li><a href="{{route('inicio')}}">Inicio</a></li>
    <li><a href="{{route('admin.feligresia')}}">Feligresía</a></li>
    <li><a href="{{route('admin.feligresia')}}">Estructura Eclesiástica</a></li>
    <li><a href="{{route('distrito.index')}}">Distritos</a></li>
    <li class="active"><a>Editar Distritos</a></li>
</ol>
@endsection
@section('content')
<div class="row clearfix">
    <div class="col-md-12">
        <div class="card">
            <div class="header">
                <h2>
                    GESTIÓN DE LOS DISTRITOS - EDITAR UN DISTRITO
                </h2>
            </div>
            <div class="body">
                <div class="alert bg-deep-orange alert-dismissible" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
                    <strong>Edite los datos del distrito.</strong> Los distritos son agrupaciones de iglesias dentro de una ciudad, municipio, pueblo, aldea o veredas.
                </div>
                <div class="col-md-12">
                    @component('layouts.errors')
                    @endcomponent
                </div>
                <h1 class="card-inside-title">DATOS DEL DISTRITO: {{$distrito->nombre}}</h1>
                <div class="row clearfix">
                    <div class="col-md-12">
                        {!! Form::open(['route'=>['distrito.update',$distrito],'method'=>'PUT','class'=>'form-horizontal'])!!}
                        <div class="col-md-12">
                            <div class="form-group">
                                <div class="col-md-6">
                                    <div class="form-line">
                                        <label class="control-label">Nombre del Distrito</label>
                                        {!! Form::text('nombre',$distrito->nombre,['class'=>'form-control','placeholder'=>'Nombre oficial del distrito','required']) !!}
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-line">
                                        <label class="control-label">Descripción</label>
                                        {!! Form::text('descripcion',$distrito->descripcion,['class'=>'form-control','placeholder'=>'Descripción del distrito']) !!}
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-md-6">
                                    <div class="form-line">
                                        <label class="control-label">Ciudad de Ubicación</label>
                                        {!! Form::select('ciudad_id',$ciudades,$distrito->ciudad_id,['class'=>'form-control chosen-select','placeholder'=>'-- Seleccione una opción --']) !!}
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-line">
                                        <label class="control-label">Dirección de Ubicación</label>
                                        {!! Form::text('ubicacion',$distrito->ubicacion,['class'=>'form-control','placeholder'=>'Dirección de ubicación del distrito']) !!}
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-md-6">
                                    <div class="form-line">
                                        <label class="control-label">Dirección de Correo Electrónico</label>
                                        {!! Form::email('email',$distrito->email,['class'=>'form-control','placeholder'=>'Dirección de correo del distrito']) !!}
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-line">
                                        <label class="control-label">Sitio Web del Distrito</label>
                                        {!! Form::text('sitioweb',$distrito->sitioweb,['class'=>'form-control','placeholder'=>'Sitio web oficial del distrito']) !!}
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-md-6">
                                    <div class="form-line">
                                        <label class="control-label">Zona</label>
                                        {!! Form::select('zona_id',$zonas,$distrito->zona_id,['class'=>'form-control chosen-select','placeholder'=>'-- Seleccione una opción --']) !!}
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-line">
                                        <label class="control-label">Asociación</label>
                                        {!! Form::select('asociacion_id',$asociaciones,$distrito->asociacion_id,['class'=>'form-control chosen-select','placeholder'=>'-- Seleccione una opción --']) !!}
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <br/><br/><a href="{{route('distrito.index')}}" class="btn bg-red waves-effect">Cancelar</a>
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
</script>
@endsection