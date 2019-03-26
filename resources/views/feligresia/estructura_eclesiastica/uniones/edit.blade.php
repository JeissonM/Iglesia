@extends('layouts.admin')
@section('breadcrumb')
<ol class="breadcrumb breadcrumb-bg-blue-grey" style="margin-bottom: 30px;">
    <li><a href="{{route('inicio')}}">Inicio</a></li>
    <li><a href="{{route('admin.feligresia')}}">Feligresía</a></li>
    <li><a href="{{route('admin.feligresia')}}">Estructura Eclesiástica</a></li>
    <li><a href="{{route('union.index')}}">Uniones</a></li>
    <li class="active"><a>Editar Uniones</a></li>
</ol>
@endsection
@section('content')
<div class="row clearfix">
    <div class="col-md-12">
        <div class="card">
            <div class="header">
                <h2>
                    GESTIÓN DE LAS UNIONES - EDITAR UNA UNIÓN
                </h2>
            </div>
            <div class="body">
                <div class="alert bg-deep-orange alert-dismissible" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
                    <strong>Edite los datos de la unión.</strong> Gestione la información de las uniones de los adventistas de todo el mundo; las uniones son dependencias de las divisiones. Usted puede crear tantas uniones como existan en la Iglesia mundial.
                </div>
                <div class="col-md-12">
                    @component('layouts.errors')
                    @endcomponent
                </div>
                <h1 class="card-inside-title">DATOS DE LA UNIÓN: {{$union->nombre}}</h1>
                <div class="row clearfix">
                    <div class="col-md-12">
                        {!! Form::open(['route'=>['union.update',$union],'method'=>'PUT','class'=>'form-horizontal'])!!}
                        <div class="col-md-12">
                            <div class="form-group">
                                <div class="col-md-6">
                                    <div class="form-line">
                                        <label class="control-label">Nombre de la Unión</label>
                                        {!! Form::text('nombre',$union->nombre,['class'=>'form-control','placeholder'=>'Nombre oficial de la unión','required']) !!}
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-line">
                                        <label class="control-label">Descripción</label>
                                        {!! Form::text('descripcion',$union->descripcion,['class'=>'form-control','placeholder'=>'Descripción de la unión']) !!}
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-md-6">
                                    <div class="form-line">
                                        <label class="control-label">Ciudad de Ubicación</label>
                                        {!! Form::select('ciudad_id',$ciudades,$union->ciudad_id,['class'=>'form-control chosen-select','placeholder'=>'-- Seleccione una opción --']) !!}
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-line">
                                        <label class="control-label">Dirección de Ubicación</label>
                                        {!! Form::text('ubicacion',$union->ubicacion,['class'=>'form-control','placeholder'=>'Dirección de ubicación de la unión']) !!}
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-md-6">
                                    <div class="form-line">
                                        <label class="control-label">Dirección de Correo Electrónico</label>
                                        {!! Form::email('email',$union->email,['class'=>'form-control','placeholder'=>'Dirección de correo de la unión']) !!}
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-line">
                                        <label class="control-label">Sitio Web de la Unión</label>
                                        {!! Form::text('sitioweb',$union->sitioweb,['class'=>'form-control','placeholder'=>'Sitio web oficial de la unión']) !!}
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-md-12">
                                    <div class="form-line">
                                        <label class="control-label">División</label>
                                        {!! Form::select('division_id',$divisiones,$union->division_id,['class'=>'form-control chosen-select','placeholder'=>'-- Seleccione una opción --']) !!}
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <br/><br/><a href="{{route('union.index')}}" class="btn bg-red waves-effect">Cancelar</a>
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