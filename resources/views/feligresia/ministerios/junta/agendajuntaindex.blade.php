@extends('layouts.admin')
@section('breadcrumb')
<ol class="breadcrumb breadcrumb-bg-blue-grey" style="margin-bottom: 30px;">
    <li><a href="{{route('inicio')}}">Inicio</a></li>
    <li><a href="{{route('admin.feligresia')}}">Feligresía</a></li>
    <li><a href="{{route('admin.feligresia')}}">Ministerios</a></li>
    <li><a href="{{route('junta.index')}}">Junta de Iglesia</a></li>
    <li><a href="{{route('junta.index')}}">Continuar</a></li>
    <li class="active"><a>Agendas Para las Reuniones de la Junta</a></li>
</ol>
@endsection
@section('content')
<div class="row clearfix">
    <div class="col-md-12">
        <div class="card">
            <div class="header">
                <h2>
                    JUNTA DE IGLESIA - AGENDA PARA LAS REUNIONES DE LA JUNTA<small>Haga clic en el botón de 3 puntos de la derecha de este título para agregar un nuevo registro.</small>
                </h2>
                <ul class="header-dropdown m-r--5">
                    <li class="dropdown">
                        <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                            <i class="material-icons">more_vert</i>
                        </a>
                        <ul class="dropdown-menu pull-right">
                            <li><a data-toggle="modal" data-target="#mdModal2">Agregar Nueva Agenda</a></li>
                            <li><a data-toggle="modal" data-target="#mdModal">Ayuda</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
            <div class="body">
                <div class="row clearfix">
                    <div class="col-md-12">
                        <table class="table table-hover">
                            <tbody>
                                <tr class="read">
                                    <td class="contact"><b>JUNTA DIRECTIVA</b></td>
                                    <td class="contact"><b>PERÍODO</b></td>
                                </tr>
                                <tr class="read">
                                    <td class="contact">{{$j->etiqueta}}</td>
                                    <td class="subject">{{$p->etiqueta." - DESDE: ".$p->fechainicio." - HASTA: ".$p->fechafin}}</td>
                                </tr>
                                <tr class="read">
                                    <td class="contact"><b>PASTOR</b></td>
                                    <td class="contact"><b>IGLESIA</b></td>
                                </tr>
                                <tr class="read">
                                    <td class="contact">{{$j->pastor->personanatural->primer_nombre." ".$j->pastor->personanatural->segundo_nombre." ".$j->pastor->personanatural->primer_apellido." ".$j->pastor->personanatural->segundo_apellido}}</td>
                                    <td class="subject">{{$j->iglesia->nombre." - ".$j->iglesia->distrito->nombre}}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="col-md-12">
                        <h4>LISTADO DE AGENDAS GENERADAS EN LA JUNTA PARA EL PERÍODO INDICADO</h4>
                        <div class="table-responsive">
                            <table id="tabla" class="table table-bordered table-striped table-hover table-responsive table-condensed dataTable js-exportable" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>TÍTULO</th>
                                        <th>FECHA DE REUNIÓN</th>
                                        <th>CREADO</th>
                                        <th>MODIFICADO</th>
                                        <th>ACCIONES</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($agendas as $a)
                                    <tr>
                                        <td>{{$a->titulo}}</td>
                                        <td>{{$a->fecha_reunion}}</td>
                                        <td>{{$a->created_at}}</td>
                                        <td>{{$a->updated_at}}</td>
                                        <td>
                                            <a href="{{ route('junta.puntosagendajuntaindex',[$f->id,$p->id,$j->id,$a->id])}}" class="btn bg-green waves-effect btn-xs" data-toggle="tooltip" data-placement="top" title="Gestionar Puntos"><i class="material-icons">remove_red_eye</i></a>
                                            <a href="{{ route('junta.eliminaragendajunta',[$f->id,$p->id,$j->id,$a->id])}}" class="btn bg-red waves-effect btn-xs" data-toggle="tooltip" data-placement="top" title="Eliminar Agenda"><i class="material-icons">delete</i></a>
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
    </div>
</div>
<!-- Modal -->
<div class="modal fade" id="mdModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content modal-col-blue-grey">
            <div class="modal-header">
                <h4 class="modal-title" id="defaultModalLabel">SOBRE LA JUNTA DIRECTIVA - GESTIÓN DE AGENDAS DE REUNIONES</h4>
            </div>
            <div class="modal-body">
                <strong>Detalles: </strong> La junta directiva es la máxima autoridad de la iglesia local y es precedida por el pastor del distrito. En éste apartado puede crear o gestionar la información de la junta directiva de su iglesia para un período ecleciástico vigente.
                <p>Agregue y elimine agendas para las reuniones de la junta directiva de su iglesia.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-link waves-effect" data-dismiss="modal">ACEPTAR</button>
            </div>
        </div>
    </div>
</div>
<!-- Modal -->
<div class="modal fade" id="mdModal2" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="defaultModalLabel">CREAR AGENDA DE JUNTA</h4>
            </div>
            <div class="modal-body">
                <form class="form-horizontal" method="POST" action="{{route('junta.crearagendajunta')}}">
                    @csrf
                    <input type="hidden" name="secretario_id" value="{{$f->id}}" />
                    <input type="hidden" name="periodo_id" value="{{$p->id}}" />
                    <input type="hidden" name="junta_id" value="{{$j->id}}" />
                    <div class="col-md-12">
                        <div class="form-group">
                            <div class="form-line">
                                <br/><input type="text" class="form-control" placeholder="Escriba el título para la agenda" name="titulo" required="required" />
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="form-line">
                                <br/><label>Fecha de Reunión</label>
                                <input type="date" class="form-control" name="fecha_reunion" required="required" />
                            </div>
                        </div>
                        <div class="form-group">
                            <br/><button type="button" class="btn btn-link waves-effect" data-dismiss="modal">CANCELAR</button>
                            <button type="submit" class="btn btn-link waves-effect">GUARDAR</button>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer"></div>
        </div>
    </div>
</div>
@endsection
@section('script')
<script type="text/javascript">
    $(document).ready(function () {
        //$('#tabla').DataTable();
    });
</script>
@endsection