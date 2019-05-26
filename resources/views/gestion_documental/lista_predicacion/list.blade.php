@extends('layouts.admin')
@section('breadcrumb')
<ol class="breadcrumb breadcrumb-bg-blue-grey" style="margin-bottom: 30px;">
    <li><a href="{{route('inicio')}}">Inicio</a></li>
    <li><a href="{{route('admin.gestiondocumental')}}">Gestión Documental</a></li>
    <li class="active"><a>Lista de Predicación</a></li>
</ol>
@endsection
@section('content')
<div class="row clearfix">
    <div class="col-md-12">
        <div class="card">
            <div class="header">
                <h2>
                    LISTA DE PREDICACIÓN<small>Haga clic en el botón de 3 puntos de la derecha de este título para agregar un nuevo registro.</small>
                </h2>
                <ul class="header-dropdown m-r--5">
                    <li class="dropdown">
                        <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                            <i class="material-icons">more_vert</i>
                        </a>
                        <ul class="dropdown-menu pull-right">
                            <li><a href="{{ route('listapredicacion.crear',$f->iglesia->distrito_id) }}">Agregar Nueva Lista</a></li>
                            <li><a data-toggle="modal" data-target="#mdModal">Ayuda</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
            <div class="body">
                <div class="table-responsive">
                    <table id="tabla" class="table table-bordered table-striped table-hover table-responsive table-condensed dataTable js-exportable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>PERÍODO ESPECÍFICO</th>
                                <th>PERÍODO</th>
                                <th>DISTRITO</th>
                                <th>CREADO</th>
                                <th>ACCIONES</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($listas as $l)
                            <tr>
                                <td>{{$l->id}}</td>
                                <td>{{$l->periodoespecifico}}</td>
                                <td>{{$l->periodo->etiqueta}}</td>
                                <td>{{$l->distrito->nombre}}</td>
                                <td>{{$l->created_at}}</td>
                                <td>
                                    <a href="{{ route('listapredicacion.edit',$l->id)}}" class="btn bg-indigo waves-effect btn-xs" data-toggle="tooltip" data-placement="top" title="Configurar Lista"><i class="material-icons">mode_edit</i></a>
                                    <a href="{{ route('listapredicacion.delete',$l->id)}}" class="btn bg-red waves-effect btn-xs" data-toggle="tooltip" data-placement="top" title="Eliminar Lista"><i class="material-icons">delete</i></a>
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
        <div class="modal-content modal-col-blue">
            <div class="modal-header">
                <h4 class="modal-title" id="defaultModalLabel">SOBRE LAS LISTAS DE PREDICACIÓN</h4>
            </div>
            <div class="modal-body">
                <strong>Detalles: </strong>Cree y administre las listas de predicación a nivel distrital.
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
    });
</script>
@endsection