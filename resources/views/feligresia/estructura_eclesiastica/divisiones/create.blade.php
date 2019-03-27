@extends('layouts.admin')
@section('breadcrumb')
<ol class="breadcrumb breadcrumb-bg-blue-grey" style="margin-bottom: 30px;">
    <li><a href="{{route('inicio')}}">Inicio</a></li>
    <li><a href="{{route('admin.feligresia')}}">Feligresía</a></li>
    <li><a href="{{route('admin.feligresia')}}">Estructura Eclesiástica</a></li>
    <li><a href="{{route('division.index')}}">Divisiones</a></li>
    <li class="active"><a>Crear Divisiones</a></li>
</ol>
@endsection
@section('content')
<div class="row clearfix">
    <div class="col-md-12">
        <div class="card">
            <div class="header">
                <h2>
                    GESTIÓN DE LAS DIVISIONES - CREAR UNA NUEVA DIVISIÓN
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
                <h1 class="card-inside-title">DATOS DE LA DIVISIÓN</h1>
                <div class="row clearfix">
                    <div class="col-md-12">
                        <form class="form-horizontal" method="POST" action="{{route('division.store')}}">
                            @csrf
                            <div class="col-md-6">
                                <div class="form-group">
                                    <div class="form-line">
                                        <label class="control-label">Nombre de la División</label>
                                        {!! Form::text('nombre',null,['class'=>'form-control','placeholder'=>'Nombre oficial de la división','required']) !!}
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="form-line">
                                        <label class="control-label">Descripción</label>
                                        {!! Form::text('descripcion',null,['class'=>'form-control','placeholder'=>'Descripción de la división']) !!}
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="form-line">
                                        <label class="control-label">Ciudad de Ubicación</label>
                                        {!! Form::select('ciudad_id',$ciudades,null,['class'=>'form-control chosen-select','placeholder'=>'-- Seleccione una opción --']) !!}
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <div class="form-line">
                                        <label class="control-label">Dirección de Ubicación</label>
                                        {!! Form::text('ubicacion',null,['class'=>'form-control','placeholder'=>'Dirección de ubicación de la división']) !!}
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="form-line">
                                        <label class="control-label">Dirección de Correo Electrónico</label>
                                        {!! Form::email('email',null,['class'=>'form-control','placeholder'=>'Dirección de correo de la división']) !!}
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="form-line">
                                        <label class="control-label">Sitio Web de la División</label>
                                        {!! Form::text('sitioweb',null,['class'=>'form-control','placeholder'=>'Sitio web oficial de la división']) !!}
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <br/><br/><a href="{{route('division.index')}}" class="btn bg-red waves-effect">Cancelar</a>
                                    <button class="btn bg-indigo waves-effect" type="reset">Limpiar Formulario</button>
                                    {!! Form::submit('Guardar',['class'=>'btn bg-green waves-effect']) !!}
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
                <h4 class="modal-title" id="defaultModalLabel">SOBRE LAS DIVISIONES</h4>
            </div>
            <div class="modal-body">
                <strong>Agregue nuevas divisiones.</strong> Gestione la información de las divisiones de los adventistas de todo el mundo. Usted puede crear tantas divisiones como existan en la Iglesia mundial.
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
</script>
@endsection