@extends('layouts.admin')
@section('breadcrumb')
<ol class="breadcrumb breadcrumb-bg-blue-grey" style="margin-bottom: 30px;">
    <li><a href="{{route('inicio')}}">Inicio</a></li>
    <li><a href="{{route('admin.feligresia')}}">Feligresía</a></li>
    <li><a href="{{route('admin.feligresia')}}">Estructura Eclesiástica</a></li>
    <li class="active"><a href="{{route('zona.index')}}">Zonas</a></li>
</ol>
@endsection
@section('content')
<div class="row clearfix">
    <div class="col-md-12">
        <div class="card">
            <div class="header">
                <h2>
                    GESTIÓN DE LAS ZONAS<small>Haga clic en el botón de 3 puntos de la derecha de este título para agregar un nuevo registro.</small>
                </h2>
                <ul class="header-dropdown m-r--5">
                    <li class="dropdown">
                        <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                            <i class="material-icons">more_vert</i>
                        </a>
                        <ul class="dropdown-menu pull-right">
                            <li><a href="{{ route('zona.create') }}">Agregar Nueva Zona</a></li>
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
                                <th>NOMBRE</th>
                                <th>DESCRIPCIÓN</th>
                                <th>DIRECCIÓN</th>
                                <th>E-MAIL</th>
                                <th>SITIO WEB</th>
                                <th>CIUDAD</th>
                                <th>ASOCIACIÓN</th>
                                <th>ACCIONES</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($zonas as $d)
                            <tr>
                                <td>{{$d->nombre}}</td>
                                <td>{{$d->descripcion}}</td>
                                <td>{{$d->ubicacion}}</td>
                                <td>{{$d->email}}</td>
                                <td>{{$d->sitioweb}}</td>
                                <td>{{$d->ciudad->nombre}}</td>
                                <td>{{$d->asociacion->nombre}}</td>
                                <td>
                                    <a href="{{ route('zona.edit',$d->id)}}" class="btn bg-indigo waves-effect btn-xs" data-toggle="tooltip" data-placement="top" title="Editar Zona"><i class="material-icons">mode_edit</i></a>
                                    <a href="{{ route('zona.delete',$d->id)}}" class="btn bg-red waves-effect btn-xs" data-toggle="tooltip" data-placement="top" title="Eliminar Zona"><i class="material-icons">delete</i></a>
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
                <h4 class="modal-title" id="defaultModalLabel">SOBRE LAS ZONAS</h4>
            </div>
            <div class="modal-body">
                <strong>Detalles: </strong> Las zonas son campos que componen a las asociaciones o misiones y que comprenden parte de uno o varios estados, provincias o departamentos de un país. Las zonas contienen distritos.
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