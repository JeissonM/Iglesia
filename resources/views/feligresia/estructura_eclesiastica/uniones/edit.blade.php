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
                    GESTIÓN DE LAS UNIONES - EDITAR UNA UNIÓN<small>Haga clic en el botón de 3 puntos de la derecha de este título para obtener ayuda.</small>
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
                <h1 class="card-inside-title">DATOS DE LA UNIÓN: {{$union->nombre}}</h1>
                <div class="row clearfix">
                    <div class="col-md-12">
                        <form class="form-horizontal" role='form' method="POST" action="{{route('union.update',$union->id)}}">
                            @csrf
                            <input name="_method" type="hidden" value="PUT" />
                            <div class="col-md-6">
                                <div class="form-group">
                                    <div class="form-line">
                                        <br/><input class="form-control" type="text" placeholder="Nombre oficial de la unión" required="required" name="nombre" value="{{$union->nombre}}">    
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="form-line">
                                        <br/><input class="form-control" type="text" placeholder="Descripción de la unión" name="descripcion" value="{{$union->descripcion}}">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="form-line">
                                        <label class="control-label">Ciudad de Ubicación</label>
                                        <select class="form-control"  style="width: 100%;" required="required" name="ciudad_id">
                                            @foreach($ciudades as $key=>$value)
                                            @if($union->ciudad_id == $key)
                                            <option value="{{$key}}" selected>{{$value}}</option>
                                            @else
                                            <option value="{{$key}}">{{$value}}</option>
                                            @endif
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <div class="form-line">
                                        <br/><input class="form-control" type="text" placeholder="Dirección de ubicación de la unión" name="ubicacion" value="{{$union->ubicacion}}">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="form-line">
                                        <br/><input class="form-control" type="email" placeholder="Dirección de correo de la unión" name="email" value="{{$union->email}}">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="form-line">
                                        <br/><input class="form-control" type="text" placeholder="Sitio web oficial de la unión" name="sitioweb" value="{{$union->sitioweb}}">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <div class="form-line">
                                        <label class="control-label">División</label>
                                        <select class="form-control"  style="width: 100%;" required="required" name="division_id">
                                            @foreach($divisiones as $key=>$value)
                                            @if($union->division_id == $key)
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
                                    <br/><br/><a href="{{route('union.index')}}" class="btn bg-red waves-effect">Cancelar</a>
                                    <button class="btn bg-indigo waves-effect" type="reset">Limpiar Formulario</button>
                                    <button class="btn bg-green waves-effect" type="submit">Guardar</button>
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
                <h4 class="modal-title" id="defaultModalLabel">SOBRE LAS UNIONES</h4>
            </div>
            <div class="modal-body">
                <strong>Edite los datos de la unión.</strong> Gestione la información de las uniones de los adventistas de todo el mundo; las uniones son dependencias de las divisiones. Usted puede crear tantas uniones como existan en la Iglesia mundial.
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