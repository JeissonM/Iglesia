@extends('layouts.admin')
@section('breadcrumb')
<ol class="breadcrumb breadcrumb-bg-blue-grey" style="margin-bottom: 30px;">
    <li><a href="{{route('inicio')}}">Inicio</a></li>
    <li><a href="{{route('admin.feligresia')}}">Feligresía</a></li>
    <li><a href="{{route('admin.feligresia')}}">Datos Geográficos</a></li>
    <li><a href="{{route('ciudad.index')}}">Ciudades</a></li>
    <li class="active"><a>Editar Ciudad</a></li>
</ol>
@endsection
@section('content')
<div class="row clearfix">
    <div class="col-md-12">
        <div class="card">
            <div class="header">
                <h2>
                    GESTIÓN DE CIUDADES - EDITAR UNA CIUDAD
                </h2>
            </div>
            <div class="body">
                <div class="alert bg-deep-orange alert-dismissible" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
                    <strong>Edite los datos de las Ciudades.</strong> Las ciudades son usadas en el registro de feligreses, iglesias y diferentes procesos del aplicativo.
                </div>
                <div class="col-md-12">
                    @component('layouts.errors')
                    @endcomponent
                </div>
                <h1 class="card-inside-title">DATOS DE LA CIUDAD: {{$ciudad->nombre}}</h1>
                <div class="row clearfix">
                    <div class="col-md-12">
                        {!! Form::open(['route'=>['ciudad.update',$ciudad],'method'=>'PUT','class'=>'form-horizontal'])!!}
                        <div class="col-md-12">
                            <div class="form-group">
                                <div class="form-line">
                                    <label class="control-label">Código Ciudad</label>
                                    {!! Form::text('codigo_dane',$ciudad->codigo_dane,['class'=>'form-control','placeholder'=>'Código de la ciudad (en el caso de colombia equivale al código que el DANE asigna a la ciudad)']) !!}
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="form-line">
                                    <label class="control-label">Nombre Ciudad</label>
                                    {!! Form::text('nombre',$ciudad->nombre,['class'=>'form-control','placeholder'=>'Nombre oficial de la ciudad','required']) !!}
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="form-line">
                                    <label class="control-label">Departamento/Estado</label>
                                    {!! Form::select('departamento_id',$estados,$ciudad->departamento_id,['class'=>'form-control chosen-select','placeholder'=>'-- Seleccione una opción --','required']) !!}
                                </div>
                            </div>
                            <div class="form-group">
                                <br/><br/><a href="{{route('ciudad.index')}}" class="btn bg-red waves-effect">Cancelar</a>
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