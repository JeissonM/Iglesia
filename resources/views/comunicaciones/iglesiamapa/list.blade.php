@extends('layouts.admin')
@section('breadcrumb')
<ol class="breadcrumb breadcrumb-bg-blue-grey" style="margin-bottom: 30px;">
    <li><a href="{{route('inicio')}}">Inicio</a></li>
    <li><a href="{{route('admin.comunicacion')}}">Comunicaciones</a></li>
    <li class="active"><a>Encuentre una Iglesia - Gestión</a></li>
</ol>
@endsection
@section('content')
<div class="row clearfix">
    <div class="col-md-12">
        <div class="card">
            <div class="header">
                <h2>
                    ENCUENTRE UNA IGLESIA - GESTIÓN<small>Haga clic en el botón de 3 puntos de la derecha de este título para agregar un nuevo registro.</small>
                </h2>
                <ul class="header-dropdown m-r--5">
                    <li class="dropdown">
                        <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                            <i class="material-icons">more_vert</i>
                        </a>
                        <ul class="dropdown-menu pull-right">
                            <li><a href="{{ route('iglesiamapa.create') }}">Agregar Nuevo Mapa</a></li>
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
                                <th>IGLESIA</th>
                                <th>DIRECCIÓN</th>
                                <th>TELÉFONO</th>
                                <th>CORREO</th>
                                <th>CIUDAD</th>
                                <th>SITIO WEB</th>
                                <th>ACCIONES</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($iglesias as $i)
                            <tr>
                                <td>{{$i->iglesia->nombre}}</td>
                                <td>{{$i->iglesia->ubicacion}}</td>
                                <td>{{$i->telefonocontacto}}</td>
                                <td>{{$i->iglesia->email}}</td>
                                <td>{{$i->iglesia->ciudad->nombre}}</td>
                                <td>{{$i->iglesia->sitioweb}}</td>
                                <td>
                                    <a href="{{ route('iglesiamapa.show',$i->id)}}" class="btn bg-green waves-effect btn-xs" data-toggle="tooltip" data-placement="top" title="Ver Mapa"><i class="material-icons">remove_red_eye</i></a>
                                    <a href="{{ route('iglesiamapa.delete',$i->id)}}" class="btn bg-red waves-effect btn-xs" data-toggle="tooltip" data-placement="top" title="Eliminar Mapa"><i class="material-icons">delete</i></a>
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
                <h4 class="modal-title" id="defaultModalLabel">SOBRE ENCUENTRE UNA IGLESIA</h4>
            </div>
            <div class="modal-body">
                <strong>Detalles: </strong>Las personas y feligreses deben poder encontrar una iglesia en el sitio web público a partir de una ciudad determinada. En este módulo se debe configurar la ubicación en el mapa y teléfono de contácto de cada iglesia para permitir la busqueda. 
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