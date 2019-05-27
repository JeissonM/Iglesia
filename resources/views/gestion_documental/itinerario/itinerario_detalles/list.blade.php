@extends('layouts.admin')
@section('breadcrumb')
<ol class="breadcrumb breadcrumb-bg-blue-grey" style="margin-bottom: 30px;">
    <li><a href="{{route('inicio')}}">Inicio</a></li>
    <li><a href="{{route('admin.gestiondocumental')}}">Gestión Documental</a></li>
    <li><a href="{{route('itinerario.index')}}">Itinerario</a></li>
    <li class="active"><a href="{{route('itinerariodetalle.inicio',$itinerario->id)}}">Detalles</a></li>
</ol>
@endsection
@section('content')
<div class="row clearfix">
    <div class="col-md-12">
        <div class="card">
            <div class="header">
                <h2>
                    DETALLES DEL ITINERARIO<small>Haga clic en el botón de 3 puntos de la derecha de este título para agregar un nuevo registro.</small>
                </h2>
                <ul class="header-dropdown m-r--5">
                    <li class="dropdown">
                        <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                            <i class="material-icons">more_vert</i>
                        </a>
                        <ul class="dropdown-menu pull-right">
                            <li><a href="{{ route('itinerariodetalle.show',$itinerario->id) }}">Agregar Nuevo Detalle</a></li>
                            <li><a data-toggle="modal" data-target="#mdModal">Ayuda</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
            <div class="body">
                <h2> DATOS DEL ITINERARIO</h2>
                </br><div class="row clearfix">
                    <div class="col-md-12">
                        <table class="table table-hover">
                            <tbody>
                                <tr class="read">
                                    <td class="contact"><b>Titulo</b></td>
                                    <td class="subject">{{$itinerario->titulo}}</td>
                                </tr>
                                <tr class="read">
                                    <td class="contact"><b>Fecha del Evento</b></td>
                                    <td class="subject">{{$itinerario->fecha}}</td>
                                </tr>
                                <tr class="read">
                                    <td class="contact"><b>Iglesia</b></td>
                                    <td class="subject">{{$itinerario->iglesia->nombre}}</td>
                                </tr>
                                <tr class="read">
                                    <td class="contact"><b>Período</b></td>
                                    <td class="subject">{{$itinerario->periodo->etiqueta}}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="table-responsive">
                    <table id="tabla" class="table table-bordered table-striped table-hover table-responsive table-condensed dataTable js-exportable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>ORDEN</th>
                                <th>DESCRIPCIÓN</th>
                                <th>HORA INICIO</th>
                                <th>HORA FIN</th>
                                <th>CREADO</th>
                                <th>MODIFICADO</th>
                                <th>ACCIONES</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($detalles as $i)
                            <tr>
                                <td>{{$i->orden}}</td>
                                <td>{{$i->descripcion}}</td>
                                <td>{{$i->horainicial[0].$i->horainicial[1].":".$i->horainicial[2].$i->horainicial[3]}}</td>
                                <td>{{$i->horafinal[0].$i->horafinal[1].":".$i->horafinal[2].$i->horafinal[3]}}</td>
                                <td>{{$i->created_at}}</td>
                                <td>{{$i->updated_at}}</td>
                                <td>
                                    <a href="{{ route('itinerariodetalle.delete',$i->id)}}" class="btn bg-red waves-effect btn-xs" data-toggle="tooltip" data-placement="top" title="Eliminar Detalle"><i class="material-icons">delete</i></a>
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
                <h4 class="modal-title" id="defaultModalLabel">SOBRE LOS DETALLES DE ITINERARIOS</h4>
            </div>
            <div class="modal-body">
                <strong>Detalles: </strong>Administre los momentos del itinerario o evento seleccionado.
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