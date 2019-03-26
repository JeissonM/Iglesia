@extends('layouts.admin')
@section('breadcrumb')
<ol class="breadcrumb breadcrumb-bg-blue-grey" style="margin-bottom: 30px;">
    <li><a href="{{route('inicio')}}">Inicio</a></li>
    <li><a href="{{route('admin.feligresia')}}">Feligresía</a></li>
    <li><a href="{{route('admin.feligresia')}}">Datos Geográficos</a></li>
    <li><a href="{{route('estado.index')}}">Departamentos/Estados</a></li>
    <li class="active"><a>Editar Departamento/Estado</a></li>
</ol>
@endsection
@section('content')
<div class="row clearfix">
    <div class="col-md-12">
        <div class="card">
            <div class="header">
                <h2>
                    ESTADOS/DEPARTAMENTOS - EDITAR UN DEPARTAMENTO/ESTADO
                </h2>
            </div>
            <div class="body">
                <div class="alert bg-deep-orange alert-dismissible" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
                    <strong>Edite los datos de los Departamentos/Estados.</strong> Los Departamentos/Estados son usados en el registro de feligreses, iglesias y diferentes procesos del aplicativo.
                </div>
                <div class="col-md-12">
                    @component('layouts.errors')
                    @endcomponent
                </div>
                <h1 class="card-inside-title">DATOS DEL DEPARTAMENTO/ESTADO: {{$estado->nombre}}</h1>
                <div class="row clearfix">
                    <div class="col-md-12">
                        {!! Form::open(['route'=>['estado.update',$estado],'method'=>'PUT','class'=>'form-horizontal'])!!}
                        <div class="col-md-12">
                            <div class="form-group">
                                <div class="form-line">
                                    <label class="control-label">Código Estado/Departamento</label>
                                    {!! Form::text('codigo_dane',$estado->codigo_dane,['class'=>'form-control','placeholder'=>'Código del estado (en el caso de colombia equivale al código que el DANE asigna al Estado)']) !!}
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="form-line">
                                    <label class="control-label">Nombre Estado/Departamento</label>
                                    {!! Form::text('nombre',$estado->nombre,['class'=>'form-control','placeholder'=>'Nombre oficial del Estado/Departamento','required']) !!}
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="form-line">
                                    <label class="control-label">País</label>
                                    {!! Form::select('pais_id',$paises,$estado->pais_id,['class'=>'form-control chosen-select','placeholder'=>'-- Seleccione una opción --','required']) !!}
                                </div>
                            </div>
                            <div class="form-group">
                                <br/><br/><a href="{{route('estado.index')}}" class="btn bg-red waves-effect">Cancelar</a>
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