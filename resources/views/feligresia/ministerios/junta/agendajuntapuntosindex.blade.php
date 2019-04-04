@extends('layouts.admin')
@section('breadcrumb')
<ol class="breadcrumb breadcrumb-bg-blue-grey" style="margin-bottom: 30px;">
    <li><a href="{{route('inicio')}}">Inicio</a></li>
    <li><a href="{{route('admin.feligresia')}}">Feligresía</a></li>
    <li><a href="{{route('admin.feligresia')}}">Ministerios</a></li>
    <li><a href="{{route('junta.index')}}">Junta de Iglesia</a></li>
    <li><a href="{{route('junta.index')}}">Continuar</a></li>
    <li><a href="{{route('junta.agendajuntaindex',[$f->id,$p->id,$j->id])}}">Agendas Para las Reuniones de la Junta</a></li>
    <li class="active"><a>Puntos de la Agenda</a></li>
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
                            <li><a data-toggle="modal" data-target="#mdModal2">Agregar Nuevo Punto</a></li>
                            <li><a data-toggle="modal" data-target="#mdModal">Ayuda</a></li>
                            <li><a onclick="imprSelec('imprimir')">Imprimir Agenda</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
            <div class="body">
                <div class="row clearfix">
                    <div class="col-md-12">
                        <div class="card" id="imprimir">
                            <div class="body bg-white">
                                <h3 style="text-align: center;">{{$j->iglesia->nombre." - ".$j->iglesia->distrito->nombre}}</h3>
                                <h4 style="text-align: center;">{{$j->etiqueta." | ".$p->etiqueta}}</h4>
                                <h4 style="margin-top: 30px">{{$agenda->titulo." | FECHA DE REUNIÓN: ".$agenda->fecha_reunion}}</h4>
                                <h4>PASTOR: {{$j->pastor->personanatural->primer_nombre." ".$j->pastor->personanatural->segundo_nombre." ".$j->pastor->personanatural->primer_apellido." ".$j->pastor->personanatural->segundo_apellido}}</h4>
                                <h4 style="margin-top: 30px">LISTADO DE PUNTOS A TRATAR</h4>
                                <ol>
                                    @foreach($agenda->agendajuntapuntos as $pu)
                                    <li>{{$pu->punto." - (".$pu->feligres->personanatural->primer_nombre." ".$pu->feligres->personanatural->segundo_nombre." ".$pu->feligres->personanatural->primer_apellido." ".$pu->feligres->personanatural->segundo_apellido.") (".$pu->ministerio.")"}} <a class="pull-right" name="eliminara" href="{{route('junta.puntosagendajuntaeliminarpunto',[$f->id,$p->id,$j->id,$agenda->id,$pu->id])}}" style="color: red"> Eliminar Punto</a></li>
                                    @endforeach
                                </ol>
                            </div>
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
                <p>Agregue y elimine puntos para la agenda de las reuniones de la junta directiva de su iglesia.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-link waves-effect" data-dismiss="modal">ACEPTAR</button>
            </div>
        </div>
    </div>
</div>
<!-- Modal -->
<div class="modal fade" id="mdModal2" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="defaultModalLabel">CREAR PUNTO PARA LA AGENDA DE JUNTA</h4>
            </div>
            <div class="modal-body">
                <div class="clearfix">
                    <div class="col-md-12">
                        <form class="form-horizontal" method="POST" action="{{route('junta.puntosagendajuntacrear')}}">
                            @csrf
                            <input type="hidden" name="secretario_id" value="{{$f->id}}" />
                            <input type="hidden" name="periodo_id" value="{{$p->id}}" />
                            <input type="hidden" name="junta_id" value="{{$j->id}}" />
                            <input type="hidden" name="agendajunta_id" value="{{$agenda->id}}" />
                            <div class="col-md-12">
                                <div class="form-group">
                                    <div class="form-line">
                                        <br/><input type="text" class="form-control" placeholder="Escriba el punto para la agenda" name="punto" required="required" />
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="form-line">
                                        <br/><label>Seleccione el Miembro</label>
                                        <select class="form-control show-tick" name="feligres_id" required="">
                                            @foreach($j->miembrojuntas as $f)
                                            <option value="{{$f->feligres_id.";".$f->cargogeneral_id}}">{{$f->feligres->personanatural->primer_nombre." ".$f->feligres->personanatural->segundo_nombre." ".$f->feligres->personanatural->primer_apellido." ".$f->feligres->personanatural->segundo_apellido." - ".$f->cargogeneral->nombre." - ".$f->cargogeneral->ministerio->nombre}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <br/><button type="button" class="btn btn-link waves-effect" data-dismiss="modal">CANCELAR</button>
                                    <button type="submit" class="btn btn-link waves-effect">GUARDAR</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
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
        $('.select2').select2();
    });

    function imprSelec(div) {
        var eliminar = document.getElementsByName("eliminara");
        eliminar.forEach(function (i) {
            i.style.display = 'none';
        });
        var ficha = document.getElementById(div);
        var ventimp = window.open(' ', 'agenda');
        ventimp.document.write(ficha.innerHTML);
        ventimp.document.close();
        ventimp.print();
        ventimp.close();
    }

</script>
@endsection