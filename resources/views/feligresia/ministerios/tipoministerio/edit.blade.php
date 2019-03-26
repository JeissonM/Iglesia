@extends('layouts.admin')
@section('breadcrumb')
<ol class="breadcrumb breadcrumb-bg-blue-grey" style="margin-bottom: 30px;">
    <li><a href="{{route('inicio')}}">Inicio</a></li>
    <li><a href="{{route('admin.feligresia')}}">Feligresía</a></li>
    <li><a href="{{route('admin.feligresia')}}">Ministerios</a></li>
    <li><a href="{{route('tipoministerio.index')}}">Categorías de Ministerios</a></li>
    <li class="active"><a>Editar Categoría</a></li>
</ol>
@endsection
@section('content')
<div class="row clearfix">
    <div class="col-md-12">
        <div class="card">
            <div class="header">
                <h2>
                    CATEGORÍAS DE MINISTERIOS - EDITAR CATEGORÍA
                </h2>
            </div>
            <div class="body">
                <div class="alert bg-deep-orange alert-dismissible" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
                    <strong>Edite los datos de las categorías, </strong> Las categorías de ministerios o tipos de ministerios son única y exclusivamente para el funcionamiento de los ministerios extraoficiales de la iglesia y describen el grupo al cual pertenece el ministerio que puede ser: ministerios musicales, ministerios evangelísticos, ministerios de ayuda humanitaria, ministerios de servicio, ministerios de publicaciones, clubes juveniles, entre otros.
                </div>
                <div class="col-md-12">
                    @component('layouts.errors')
                    @endcomponent
                </div>
                <h1 class="card-inside-title">EDITAR DATOS DE LA CATEGORÍA: {{$tipo->nombre}}</h1>
                <div class="row clearfix">
                    <div class="col-md-12">
                        {!! Form::open(['route'=>['tipoministerio.update',$tipo],'method'=>'PUT','class'=>'form-horizontal'])!!}
                        <div class="col-md-12">
                            <div class="form-group">
                                <div class="form-line">
                                    <br/>{!! Form::text('nombre',$tipo->nombre,['class'=>'form-control','placeholder'=>'Escriba el nombre de la categoría','required']) !!}
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="form-line">
                                    <br/>{!! Form::text('descripcion',$tipo->descripcion,['class'=>'form-control','placeholder'=>'Descripción de la categoría (Opcional)']) !!}
                                </div>
                            </div>
                            <div class="form-group">
                                <br/><br/><a href="{{route('tipoministerio.index')}}" class="btn bg-red waves-effect">Cancelar</a>
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