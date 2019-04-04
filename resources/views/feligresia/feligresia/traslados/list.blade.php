@extends('layouts.admin')
@section('breadcrumb')
<ol class="breadcrumb breadcrumb-bg-blue-grey" style="margin-bottom: 30px;">
    <li><a href="{{route('inicio')}}">Inicio</a></li>
    <li><a href="{{route('admin.feligresia')}}">Feligresía</a></li>
    <li><a href="{{route('admin.feligresia')}}">Feligresía</a></li>
    <li class="active"><a href="{{route('solicitud.index')}}">Traslados</a></li>
</ol>
@endsection
@section('content')
<div class="row clearfix">
    <div class="col-md-12">
        <div class="card">
            <div class="header">
                <h2>
                    TRASLADOS<small>Haga clic en el botón de 3 puntos de la derecha de este título para agregar un nuevo registro.</small>
                </h2>
                </br><label class="control-label" style="background-color: #02cdba; color: #ffffff; font-weight: bold; width: 100%; padding: 10px;">Solicitudes de traslado realizadas por mi iglesia</label> 
                </br><label class="control-label" style="background-color: #99e4ee; color: #ffffff; font-weight: bold; width: 100%; padding: 10px;">Solicitudes de traslado realizadas a mi iglesia</label>
                <ul class="header-dropdown m-r--5">
                    <li class="dropdown">
                        <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                            <i class="material-icons">more_vert</i>
                        </a>
                        <ul class="dropdown-menu pull-right">
                            <li><a href="{{ route('solicitud.create') }}">Agregar Nueva Solicitud</a></li>
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
                                <th>IDENTIFICACIÓN</th>
                                <th>NOMBRE</th>
                                <th>TIPO</th>
                                <th>ESTADO</th>
                                <th>FECHA DE SOLICITUD</th>
                                <th>IGLESIA ORIGEN</th>
                                <th>IGLESIA DESTINO</th>
                                <th>ACTA ORIGEN</th>
                                <th>ACTA DESTINO</th>
                                <th>ACCIONES</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($solicitudes as $s)
                            @if($s->iglesia_destino == $secretario->iglesia_id)
                            <tr style="background-color: #99e4ee;">
                                @else
                            <tr style="background-color: #02cdba;">
                                @endif
                                <td>{{$s->feligres->personanatural->persona->tipodocumento->abreviatura." - ".$s->feligres->personanatural->persona->numero_documento}}</td>
                                <td>{{$s->feligres->personanatural->primer_apellido." ".$s->feligres->personanatural->segundo_apellido." ".$s->feligres->personanatural->primer_nombre." ".$s->feligres->personanatural->segundo_nombre}}</td>
                                <td>{{$s->tiposolicitud}}</td>
                                <td>{{$s->estado}}</td>
                                <td>{{$s->fechasolicitud}}</td>
                                @if($s->io != null)
                                <td>{{$s->io}}</td>
                                @else
                                <td> -- </td>
                                @endif
                                @if($s->ide != null)
                                <td>{{$s->ide}}</td>
                                @else
                                <td> -- </td>
                                @endif
                                @if($s->ao == 'NO')
                                <td>Sin Acta</td>
                                @else
                                <td><a target="_blank" href="{{asset('docs/actas/'.$s->ao)}}">{{$s->ao}}</a></td>
                                @endif
                                @if($s->ad == 'NO')
                                <td>Sin Acta</td>
                                @else
                                <td><a target="_blank" href="{{asset('docs/actas/'.$s->ad)}}">{{$s->ad}}</a></td>
                                @endif
                                <td>
                                    @if($s->iglesia_destino == $secretario->iglesia_id)   
                                    <a href="{{ route('solicitud.delete',$s->id)}}" class="btn bg-red waves-effect btn-xs" data-toggle="tooltip" data-placement="top" title="Eliminar"><i class="material-icons">delete</i></a>
                                    <a href="{{ route('solicitud.show',$s->id)}}" class="btn bg-pink waves-effect btn-xs" data-toggle="tooltip" data-placement="top" title="Ver Solicitud"><i class="material-icons">remove_red_eye</i></a>             
                                    @if($s->estado == 'ACEPTADA')
                                    <a href="{{ route('solicitud.edit',$s->id)}}" class="btn bg-blue waves-effect btn-xs" data-toggle="tooltip" data-placement="top" title="Finalizar Solicitud"><i class="material-icons">assignment_ind</i></a>
                                    @endif
                                    @else
                                    @if($s->estado != 'ACEPTADA' && $s->estado != 'RECHAZADA')
                                    <a href="{{ route('solicitud.procesar',$s->id)}}" class="btn bg-green waves-effect btn-xs" data-toggle="tooltip" data-placement="top" title="Procesar Solicitud"><i class="material-icons">assignment</i></a>
                                    @endif 
                                    <a href="{{ route('solicitud.show',$s->id)}}" class="btn bg-pink waves-effect btn-xs" data-toggle="tooltip" data-placement="top" title="Ver Solicitud"><i class="material-icons">remove_red_eye</i></a>      
                                    @endif  
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
        <div class="modal-content modal-col-orange">
            <div class="modal-header">
                <h4 class="modal-title" id="defaultModalLabel">SOBRE LOS TRASLADOS</h4>
            </div>
            <div class="modal-body">
                <strong>Detalles: </strong>Administre las solicitudes de traslados de los feligreses.
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