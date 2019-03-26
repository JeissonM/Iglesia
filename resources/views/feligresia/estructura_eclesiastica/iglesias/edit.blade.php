@extends('layouts.admin')
@section('breadcrumb')
<ol class="breadcrumb breadcrumb-bg-blue-grey" style="margin-bottom: 30px;">
    <li><a href="{{route('inicio')}}">Inicio</a></li>
    <li><a href="{{route('admin.feligresia')}}">Feligresía</a></li>
    <li><a href="{{route('admin.feligresia')}}">Estructura Eclesiástica</a></li>
    <li><a href="{{route('iglesia.index')}}">Iglesias</a></li>
    <li class="active"><a>Editar Iglesias</a></li>
</ol>
@endsection
@section('content')
<div class="row clearfix">
    <div class="col-md-12">
        <div class="card">
            <div class="header">
                <h2>
                    GESTIÓN DE LAS IGLESIAS - EDITAR UNA IGLESIA
                </h2>
            </div>
            <div class="body">
                <div class="alert bg-deep-orange alert-dismissible" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
                    <strong>Edite los datos de la iglesia.</strong> Las iglesias representan las congregaciones locales de miembros y sus templos. Las iglesias están clasificadas en IGLESIA si es capaz de auto sostenerse en liderazgo, logística, etc. Y en GRUPO que son pequeñas congregaciones asistidas por un distrito y que en materia de sostenibilidad dependen de la asociación/misión a la que pertenece.
                </div>
                <div class="col-md-12">
                    @component('layouts.errors')
                    @endcomponent
                </div>
                <h1 class="card-inside-title">DATOS DE LA IGLESIA: {{$iglesia->nombre}}</h1>
                <div class="row clearfix">
                    <div class="col-md-12">
                        {!! Form::open(['route'=>['iglesia.update',$iglesia],'method'=>'PUT','class'=>'form-horizontal'])!!}
                        <div class="col-md-12">
                            <div class="form-group">
                                <div class="col-md-6">
                                    <div class="form-line">
                                        <label class="control-label">Nombre de la Iglesia</label>
                                        {!! Form::text('nombre',$iglesia->nombre,['class'=>'form-control','placeholder'=>'Nombre oficial de la iglesia','required']) !!}
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-line">
                                        <label class="control-label">Descripción</label>
                                        {!! Form::text('descripcion',$iglesia->descripcion,['class'=>'form-control','placeholder'=>'Descripción de la iglesia']) !!}
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-md-6">
                                    <div class="form-line">
                                        <label class="control-label">Ciudad de Ubicación</label>
                                        {!! Form::select('ciudad_id',$ciudades,$iglesia->ciudad_id,['class'=>'form-control chosen-select','placeholder'=>'-- Seleccione una opción --']) !!}
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-line">
                                        <label class="control-label">Dirección de Ubicación</label>
                                        {!! Form::text('ubicacion',$iglesia->ubicacion,['class'=>'form-control','placeholder'=>'Dirección de ubicación de la iglesia']) !!}
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-md-6">
                                    <div class="form-line">
                                        <label class="control-label">Dirección de Correo Electrónico</label>
                                        {!! Form::email('email',$iglesia->email,['class'=>'form-control','placeholder'=>'Dirección de correo de la iglesia']) !!}
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-line">
                                        <label class="control-label">Sitio Web de la Iglesia</label>
                                        {!! Form::text('sitioweb',$iglesia->sitioweb,['class'=>'form-control','placeholder'=>'Sitio web oficial de la iglesia']) !!}
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-md-6">
                                    <div class="form-line">
                                        <label class="control-label">Fecha de Fundación</label>
                                        <input type="date" name="fundacion" class="form-control" value="{{$iglesia->fundacion}}" />
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-line">
                                        <label class="control-label">Tipo</label>
                                        {!! Form::select('tipo',['IGLESIA'=>'IGLESIA','GRUPO'=>'GRUPO DE IGLESIA'],$iglesia->tipo,['class'=>'form-control','placeholder'=>'-- Seleccione una opción --']) !!}
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-md-6">
                                    <div class="form-line">
                                        <label class="control-label">Estado Actual la Iglesia</label>
                                        {!! Form::select('activa',['1'=>'ACTIVA','0'=>'INACTIVA'],$iglesia->activa,['class'=>'form-control','placeholder'=>'-- Seleccione una opción --']) !!}
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-line">
                                        <label class="control-label">Zona</label>
                                        {!! Form::select('zona_id',$zonas,$iglesia->zona_id,['class'=>'form-control chosen-select','placeholder'=>'-- Seleccione una opción --']) !!}
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-md-12">
                                    <div class="form-line">
                                        <label class="control-label">Distrito</label>
                                        {!! Form::select('distrito_id',$distritos,$iglesia->distrito_id,['class'=>'form-control chosen-select','placeholder'=>'-- Seleccione una opción --']) !!}
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <br/><br/><a href="{{route('iglesia.index')}}" class="btn bg-red waves-effect">Cancelar</a>
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