@extends('layouts.admin')
@section('breadcrumb')
<ol class="breadcrumb breadcrumb-bg-blue-grey" style="margin-bottom: 30px;">
    <li><a href="{{route('inicio')}}">Inicio</a></li>
    <li><a href="{{route('admin.feligresia')}}">Feligresía</a></li>
    <li><a href="{{route('admin.feligresia')}}">Ministerios</a></li>
    <li><a href="{{route('junta.index')}}">Junta de Iglesia</a></li>
    <li class="active"><a>Continuar</a></li>
</ol>
@endsection
@section('content')
<div class="row clearfix">
    <div class="col-md-12">
        <div class="card">
            <div class="header">
                <h2>
                    JUNTA DE IGLESIA<small>Haga clic en el botón de 3 puntos de la derecha de este título para agregar un nuevo registro.</small>
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
                <div class="row clearfix">
                    @if($junta!==null)
                    <div class="col-md-12">
                        <table class="table table-hover">
                            <tbody>
                                <tr class="read">
                                    <td class="contact"><b>JUNTA DIRECTIVA</b></td>
                                    <td class="contact"><b>PERÍODO</b></td>
                                </tr>
                                <tr class="read">
                                    <td class="contact">{{$junta->etiqueta}}</td>
                                    <td class="subject">{{$p->etiqueta." - DESDE: ".$p->fechainicio." - HASTA: ".$p->fechafin}}</td>
                                </tr>
                                <tr class="read">
                                    <td class="contact"><b>PASTOR</b></td>
                                    <td class="contact"><b>IGLESIA</b></td>
                                </tr>
                                <tr class="read">
                                    <td class="contact">{{$junta->pastor->personanatural->primer_nombre." ".$junta->pastor->personanatural->segundo_nombre." ".$junta->pastor->personanatural->primer_apellido." ".$junta->pastor->personanatural->segundo_apellido}}</td>
                                    <td class="subject">{{$junta->iglesia->nombre." - ".$junta->iglesia->distrito->nombre}}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="col-md-12">
                        <div class="button-demo">
                            <a href="{{route('junta.miembros',[$f->id,$p->id,$junta->id])}}" class="btn bg-blue-grey waves-effect">
                                <div><span>MIEMBROS DE LA JUNTA</span><span class="ink animate"></span></div>
                            </a>
                            <a disabled="disabled" class="btn bg-blue-grey waves-effect">
                                <div><span>REUNIONES DE LA JUNTA (GENERACIÓN DE ACTAS)</span><span class="ink animate"></span></div>
                            </a>
                            <a disabled="disabled" class="btn bg-blue-grey waves-effect">
                                <div><span>AGENDA DE JUNTA DIRECTIVA</span><span class="ink animate"></span></div>
                            </a>
                            <a disabled="disabled" class="btn bg-blue-grey waves-effect">
                                <div><span>CIERRE DE PERÍODO DE JUNTA</span><span class="ink animate"></span></div>
                            </a>
                            <a href="{{route('junta.delete',$junta->id)}}" class="btn bg-red waves-effect">
                                <div><span>ELIMINAR ÉSTA JUNTA</span><span class="ink animate"></span></div>
                            </a>
                        </div>
                    </div>
                    @else
                    <!-- CREAR JUNTA -->
                    <div class="col-md-12">
                        <form class="form-horizontal" method="POST" action="{{route('junta.store')}}">
                            @csrf
                            <input type="hidden" name="feligres_id" value="{{$f->id}}" />
                            <input type="hidden" name="periodo_id" value="{{$p->id}}" />
                            <h3>No hay junta directiva activa en el período indicado, ¿Desea crearla?</h3>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <div class="form-line">
                                        <br/><input type="text" name="etiqueta" required="" class="form-control" placeholder="Escriba la etiqueta o nombre de la junta directiva, ejemplo: JUNTA DIRECTIVA PERÍODO 2018-2019" />
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <button class="btn bg-green waves-effect" type="submit">Crear junta directiva para el período indicado.</button>
                                </div>
                            </div>
                        </form>
                    </div>
                    @endif
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
                <h4 class="modal-title" id="defaultModalLabel">SOBRE LA JUNTA DIRECTIVA</h4>
            </div>
            <div class="modal-body">
                <strong>Detalles: </strong> La junta directiva es la máxima autoridad de la iglesia local y es precedida por el pastor del distrito. En éste apartado puede crear o gestionar la información de la junta directiva de su iglesia para un período ecleciástico vigente.
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
        //$('#tabla').DataTable();
    });
</script>
@endsection