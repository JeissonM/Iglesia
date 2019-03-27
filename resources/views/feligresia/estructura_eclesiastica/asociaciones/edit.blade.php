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
                    GESTIÓN DE LAS ASOCIACIONES - EDITAR UNA ASOCIACIÓN<small>Haga clic en el botón de 3 puntos de la derecha de este título para obtener ayuda.</small>
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
                <h1 class="card-inside-title">DATOS DE LA ASOCIACIÓN: {{$asociacion->nombre}}</h1>
                <div class="row clearfix">
                    <div class="col-md-12">
                        <form class="form-horizontal" role='form' method="POST" action="{{route('asociacion.update',$asociacion->id)}}">
                            @csrf
                            <input name="_method" type="hidden" value="PUT" />
                            <div class="col-md-6">
                                <div class="form-group">
                                    <div class="form-line">
                                        <label class="control-label">Nombre de la Asociación</label>
                                        <input class="form-control" type="text" placeholder="Nombre oficial de la asociación" required="required" name="nombre" value="{{$asociacion->nombre}}">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="form-line">
                                        <label class="control-label">Descripción</label>
                                        <input class="form-control" type="text" placeholder="Descripción de la asociación" name="descripcion" value="{{$asociacion->descripcion}}">  
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="form-line">
                                        <label class="control-label">Ciudad de Ubicación</label>
                                        <select class="form-control"  style="width: 100%;" name="ciudad_id" required="required">
                                            <option value="0">-- Seleccione una opción --</option>
                                            @foreach($ciudades as $key=>$value)
                                            @if($asociacion->ciudad_id == $key)
                                            <option value="{{$key}}" selected>{{$value}}</option>
                                            @else
                                            <option value="{{$key}}">{{$value}}</option>
                                            @endif
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="form-line">
                                        <label class="control-label">Dirección de Ubicación</label>
                                        <input class="form-control" type="text" placeholder="Dirección de ubicación de la asociación" name="ubicacion" value="{{$asociacion->ubicacion}}">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <div class="form-line">
                                        <label class="control-label">Dirección de Correo Electrónico</label>
                                        <input class="form-control" type="email" placeholder="Dirección de correo de la asociación" name="email" value="{{$asociacion->email}}">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="form-line">
                                        <label class="control-label">Sitio Web de la Asociación</label>
                                        <input class="form-control" type="text" placeholder="Sitio web oficial de la asociación" name="sitioweb" value="{{$asociacion->sitioweb}}">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="form-line">
                                        <label class="control-label">Unión</label>
                                        <select class="form-control"  style="width: 100%;" name="union_id" required="required">
                                            <option value="0">-- Seleccione una opción --</option>
                                            @foreach($uniones as $key=>$value)
                                            @if($asociacion->union_id == $key)
                                            <option value="{{$key}}" selected>{{$value}}</option>
                                            @else
                                            <option value="{{$key}}">{{$value}}</option>
                                            @endif
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <br/><br/><a href="{{route('asociacion.index')}}" class="btn bg-red waves-effect">Cancelar</a>
                                    <button class="btn bg-indigo waves-effect" type="reset">Limpiar Formulario</button>
                                    <button class="btn bg-green waves-effect" type="submit">Guardar</button>
                                </div>
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
                <h4 class="modal-title" id="defaultModalLabel">SOBRE LA ASOCIACIÓN</h4>
            </div>
            <div class="modal-body">
                <strong>Edite los datos de la asociación.</strong> Gestione la información de las asociaciones de los adventista            s de todo el mundo. Las asociaciones o misiones son campos que componen a las uniones y que comprenden varios estados, provincias o departamentos de un país. Es Asociación cuando su administración es autosostenible y misión cuando no lo es; en ese caso su sostenibilidad depende de la unión a la que pertenece.
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