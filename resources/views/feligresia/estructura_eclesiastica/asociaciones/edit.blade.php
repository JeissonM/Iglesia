@extends('layouts.admin')
@section('breadcrumb')
<ol class="breadcrumb breadcrumb-bg-blue-grey" style="margin-bottom: 30px;">
    <li><a href="{{route('inicio')}}">Inicio</a></li>
    <li><a href="{{route('admin.feligresia')}}">Feligresía</a></li>
    <li><a href="{{route('admin.feligresia')}}">Estructura Eclesiástica</a></li>
    <li><a href="{{route('asociacion.index')}}">Asociaciones</a></li>
    <li class="active"><a>Editar Asociaciones</a></li>
</ol>
@endsection
@section('content')
<div class="row clearfix">
    <div class="col-md-12">
        <div class="card">
            <div class="header">
                <h2>
                    GESTIÓN DE LAS ASOCIACIONES - EDITAR UNA ASOCIACIÓN
                </h2>
            </div>
            <div class="body">
                <div class="alert bg-deep-orange alert-dismissible" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
                    <strong>Edite los datos de la asociación.</strong> Gestione la información de las asociaciones de los adventistas de todo el mundo. Las asociaciones o misiones son campos que componen a las uniones y que comprenden varios estados, provincias o departamentos de un país. Es Asociación cuando su administración es autosostenible y misión cuando no lo es; en ese caso su sostenibilidad depende de la unión a la que pertenece.
                </div>
                <div class="col-md-12">
                    @component('layouts.errors')
                    @endcomponent
                </div>
                <h1 class="card-inside-title">DATOS DE LA ASOCIACIÓN: {{$asociacion->nombre}}</h1>
                <div class="row clearfix">
                    <div class="col-md-12">
                        {!! Form::open(['route'=>['asociacion.update',$asociacion],'method'=>'PUT','class'=>'form-horizontal'])!!}
                        <div class="col-md-12">
                            <div class="form-group">
                                <div class="col-md-6">
                                    <div class="form-line">
                                        <label class="control-label">Nombre de la Asociación</label>
                                        {!! Form::text('nombre',$asociacion->nombre,['class'=>'form-control','placeholder'=>'Nombre oficial de la asociación','required']) !!}
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-line">
                                        <label class="control-label">Descripción</label>
                                        {!! Form::text('descripcion',$asociacion->descripcion,['class'=>'form-control','placeholder'=>'Descripción de la asociación']) !!}
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-md-6">
                                    <div class="form-line">
                                        <label class="control-label">Ciudad de Ubicación</label>
                                        {!! Form::select('ciudad_id',$ciudades,$asociacion->ciudad_id,['class'=>'form-control chosen-select','placeholder'=>'-- Seleccione una opción --']) !!}
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-line">
                                        <label class="control-label">Dirección de Ubicación</label>
                                        {!! Form::text('ubicacion',$asociacion->ubicacion,['class'=>'form-control','placeholder'=>'Dirección de ubicación de la asociación']) !!}
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-md-6">
                                    <div class="form-line">
                                        <label class="control-label">Dirección de Correo Electrónico</label>
                                        {!! Form::email('email',$asociacion->email,['class'=>'form-control','placeholder'=>'Dirección de correo de la asociación']) !!}
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-line">
                                        <label class="control-label">Sitio Web de la Asociación</label>
                                        {!! Form::text('sitioweb',$asociacion->sitioweb,['class'=>'form-control','placeholder'=>'Sitio web oficial de la asociación']) !!}
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-md-12">
                                    <div class="form-line">
                                        <label class="control-label">Unión</label>
                                        {!! Form::select('union_id',$uniones,$asociacion->union_id,['class'=>'form-control chosen-select','placeholder'=>'-- Seleccione una opción --']) !!}
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <br/><br/><a href="{{route('asociacion.index')}}" class="btn bg-red waves-effect">Cancelar</a>
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