@extends('layouts.admin')
@section('breadcrumb')
<ol class="breadcrumb breadcrumb-bg-blue-grey" style="margin-bottom: 30px;">
    <li><a href="{{route('inicio')}}">Inicio</a></li>
    <li><a href="{{route('admin.feligresia')}}">Feligresía</a></li>
    <li><a href="{{route('admin.feligresia')}}">Ministerios</a></li>
    <li><a href="{{route('ministerio.index')}}"> Ministerios Oficiales</a></li>
    <li class="active"><a>Editar Ministerio</a></li>
</ol>
@endsection
@section('content')
<div class="row clearfix">
    <div class="col-md-12">
        <div class="card">
            <div class="header">
                <h2>
                    GESTIÓN DE MINISTERIOS - EDITAR MINISTERIO
                </h2>
            </div>
            <div class="body">
                <div class="alert bg-deep-orange alert-dismissible" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
                    <strong>Edite los datos de los ministerios, </strong> Los ministerios oficiales de la iglesia son los departamentos ministeriales que trabajan en la misión de la iglesia y que hacen parte de su estructura organizacional. Ente ellos están: ministerio musical, ministerio de mayordomía, ministerio de educación, ministerio juvenil, etc. 
                </div>
                <div class="col-md-12">
                    @component('layouts.errors')
                    @endcomponent
                </div>
                <h1 class="card-inside-title">EDITAR DATOS DEL MINISTERIO: {{$ministerio->nombre}}</h1>
                <div class="row clearfix">
                    <div class="col-md-12">
                        {!! Form::open(['route'=>['ministerio.update',$ministerio],'method'=>'PUT','class'=>'form-horizontal'])!!}
                        <div class="col-md-12">
                            <div class="form-group">
                                <div class="form-line">
                                    <br/>{!! Form::text('nombre',$ministerio->nombre,['class'=>'form-control','placeholder'=>'Escriba el nombre del ministerio','required']) !!}
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="form-line">
                                    <br/>{!! Form::text('descripcion',$ministerio->descripcion,['class'=>'form-control','placeholder'=>'Descripción del ministerio (Opcional)']) !!}
                                </div>
                            </div>
                            <div class="form-group">
                                <br/><br/><a href="{{route('ministerio.index')}}" class="btn bg-red waves-effect">Cancelar</a>
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