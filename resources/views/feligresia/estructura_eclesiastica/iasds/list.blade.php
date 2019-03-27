@extends('layouts.admin')
@section('breadcrumb')
<ol class="breadcrumb breadcrumb-bg-blue-grey" style="margin-bottom: 30px;">
    <li><a href="{{route('inicio')}}">Inicio</a></li>
    <li><a href="{{route('admin.feligresia')}}">Feligresía</a></li>
    <li><a href="{{route('admin.feligresia')}}">Estructura Eclesiástica</a></li>
    <li class="active"><a href="{{route('iasd.index')}}">Asociación General</a></li>
</ol>
@endsection
@section('content')
<div class="row clearfix">
    <div class="col-md-12">
        <div class="card">
            <div class="header">
                <h2>
                    GESTIÓN DE LA ASOCIACIÓN GENERAL<small>Haga clic en el botón de 3 puntos de la derecha de este título para agregar un nuevo registro.</small>
                </h2>
                <ul class="header-dropdown m-r--5">
                    <li class="dropdown">
                        <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                            <i class="material-icons">more_vert</i>
                        </a>
                        <ul class="dropdown-menu pull-right">
                            <li><a href="{{ route('iasd.create') }}">Agregar Nueva Asociación General</a></li>
                            <li><a data-toggle="modal" data-target="#mdModal">Ayuda</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
            <div class="body">
                <div class="table-responsive">
                    <table id="tabla" class="table table-bordered table-striped table-hover table-responsive table-condensed" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>NOMBRE</th>
                                <th>DESCRIPCIÓN</th>
                                <th>DIRECCIÓN</th>
                                <th>ACTUAL</th>
                                <th>SITIO WEB</th>
                                <th>CREADO</th>
                                <th>MODIFICADO</th>
                                <th>ACCIONES</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($iasds as $d)
                            <tr>
                                <td>{{$d->id}}</td>
                                <td>{{$d->nombre}}</td>
                                <td>{{$d->descripcion}}</td>
                                <td>{{$d->ubicacion}}</td>
                                <td>
                                    @if($d->actual=='0')
                                    <label class="label label-danger">NO</label>
                                    @else
                                    <label class="label label-success">SI</label>
                                    @endif
                                </td>
                                <td>{{$d->sitioweb}}</td>
                                <td>{{$d->created_at}}</td>
                                <td>{{$d->updated_at}}</td>
                                <td>
                                    <a href="{{ route('iasd.edit',$d->id)}}" class="btn bg-indigo waves-effect btn-xs" data-toggle="tooltip" data-placement="top" title="Editar AG"><i class="material-icons">mode_edit</i></a>
                                    <a href="{{ route('iasd.delete',$d->id)}}" class="btn bg-red waves-effect btn-xs" data-toggle="tooltip" data-placement="top" title="Eliminar AG"><i class="material-icons">delete</i></a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
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
                <h4 class="modal-title" id="defaultModalLabel">SOBRE LA ASOCIACIÓN GENERAL</h4>
            </div>
            <div class="modal-body">
                <strong>Detalles: </strong>Gestione la información de la asociación general de los adventistas de todo el mundo. Usted puede crear varios registros de asociación general, pero solo uno debe estar marcado como actual.
                </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-link waves-effect" data-dismiss="modal">ACEPTAR</button>
            </div>
        </div>
    </div>
</div>
@endsection
@section('script')
<script type="text/javascript">
    $(document).ready(function () {
        $('#tabla').DataTable();
    });
</script>
@endsection