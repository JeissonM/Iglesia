@extends('layouts.admin')
@section('breadcrumb')
<ol class="breadcrumb breadcrumb-bg-blue-grey" style="margin-bottom: 30px;">
    <li><a href="{{route('inicio')}}">Inicio</a></li>
    <li><a href="{{route('admin.comunicacion')}}">Comunicaciones</a></li>
    <li class="active"><a href="{{route('pedidosoracion.index')}}">Jardin de Oración</a></li>
</ol>
@endsection
@section('content')
<div class="row clearfix">
    <div class="col-md-12">
        <div class="card">
            <div class="header">
                <h2>
                    JARDIN DE ORACIÓN<small>Haga clic en el botón de 3 puntos de la derecha de este título para agregar un nuevo registro.</small>
                </h2>
                <ul class="header-dropdown m-r--5">
                    <li class="dropdown">
                        <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                            <i class="material-icons">more_vert</i>
                        </a>
                        <ul class="dropdown-menu pull-right">
                            <li><a href="{{ route('agendaasociacion.create') }}">Agregar Nuevo Pedido</a></li>
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
                                <th>PERSONA</th>
                                <th>PEDIDO</th>
                                <th>CORREO</th>
                                <th>CIUDAD</th>
                                <th>ESTADO</th>
                                <th>MODIFICADO</th>
                                <th>ACCIONES</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($pedidos as $i)
                            <tr>
                                @if($i->persona == null)
                                <td>{{$i->feligres->personanatrual->primer_nombre." "$i->feligres->personanatural->segundo_nombre." ".$i->feligres->personanatural->primer_apellido." "$i->feligres->personanatural->segundo_apellido}}</td>
                                @else
                                <td>{{$i->persona}}</td>
                                @endif
                                <td>{{$i->pedido}}</td>
                                <td>{{$i->correo}}</td>
                                <td>{{$i->ciudad->nombre}}</td>
                                <td>{{$i->estado}}</td>
                                <td>{{$i->created_at}}</td>
                                <td>{{$i->updated_at}}</td>
                                <td>
                                    @if($i->feligres->identificacion == $id)
                                    <a href="{{ route('agendaasociacion.edit',$i->id)}}" class="btn bg-indigo waves-effect btn-xs" data-toggle="tooltip" data-placement="top" title="Editar Itinerario"><i class="material-icons">mode_edit</i></a>
                                    @endif
                                    <a href="{{ route('agendaasociacion.delete',$i->id)}}" class="btn bg-red waves-effect btn-xs" data-toggle="tooltip" data-placement="top" title="Eliminar Itinerario"><i class="material-icons">delete</i></a>
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
                <h4 class="modal-title" id="defaultModalLabel">SOBRE LAS AGENDAS</h4>
            </div>
            <div class="modal-body">
                <strong>Detalles: </strong>Administre los documentos para una asociación y un período.
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