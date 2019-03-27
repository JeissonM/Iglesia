@extends('layouts.admin')
@section('breadcrumb')
<ol class="breadcrumb breadcrumb-bg-blue-grey" style="margin-bottom: 30px;">
    <li><a href="{{route('inicio')}}">Inicio</a></li>
    <li><a href="{{route('admin.feligresia')}}">Feligresía</a></li>
    <li><a href="{{route('admin.feligresia')}}">Datos Geográficos</a></li>
    <li><a href="{{route('ciudad.index')}}">Ciudades</a></li>
    <li class="active"><a>Crear Ciudad</a></li>
</ol>
@endsection
@section('content')
<div class="row clearfix">
    <div class="col-md-12">
        <div class="card">
            <div class="header">
                <h2>
                    GESTIÓN DE CIUDADES - CREAR UNA NUEVA CIUDAD<small>Haga clic en el botón de 3 puntos de la derecha de este título para obtener ayuda.</small>
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
                <h1 class="card-inside-title">DATOS DE LA CIUDAD</h1>
                <div class="row clearfix">
                    <div class="col-md-12">
                        <form class="form-horizontal" role='form' method="POST" action="{{route('ciudad.store')}}">
                            @csrf
                            <div class="col-md-12">
                                <div class="form-group">
                                    <div class="form-line">
                                        <label class="control-label">Código Ciudad</label>
                                        <input class="form-control" type="text" placeholder="Código de la ciudad (en el caso de colombia equivale al código que el DANE asigna a la ciudad)" name="codigo_dane">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="form-line">
                                        <label class="control-label">Nombre Ciudad</label>
                                        <input class="form-control" type="text" required="required" name="nombre">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="form-line">
                                        <label class="control-label">Departamento/Estado</label>
                                        <select class="form-control"  style="width: 100%;" name="estado_id" required="required">
                                            <option value="0">-- Seleccione una opción --</option>
                                            @foreach($estados as $key=>$value)
                                            <option value="{{$key}}">{{$value}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <br/><br/><a href="{{route('ciudad.index')}}" class="btn bg-red waves-effect">Cancelar</a>
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
        <div class="modal-content modal-col-indigo">
            <div class="modal-header">
                <h4 class="modal-title" id="defaultModalLabel">SOBRE LAS CIUDADES</h4>
            </div>
            <div class="modal-body">
                <strong>Detalles: </strong>Agregue nuevas ciudades. Las ciudades son usadas en el registro de feligreses, iglesias y diferentes procesos del aplicativo.
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