@extends('layouts.admin')
@section('breadcrumb')
<ol class="breadcrumb breadcrumb-bg-blue-grey" style="margin-bottom: 30px;">
    <li><a href="{{route('inicio')}}">Inicio</a></li>
    <li><a href="{{route('admin.feligresia')}}">Feligresía</a></li>
    <li><a href="{{route('admin.feligresia')}}">Ministerios</a></li>
    <li><a href="{{route('junta.index')}}">Junta de Iglesia</a></li>
    <li><a href="{{route('junta.index')}}">Continuar</a></li>
    <li><a href="{{route('junta.miembros',[$f->id,$p->id,$j->id])}}">Miembros de la Junta</a></li>
    <li class="active"><a>Crear Miembro</a></li>
</ol>
@endsection
@section('content')
<div class="row clearfix">
    <div class="col-md-12">
        <div class="card">
            <div class="header">
                <h2>
                    JUNTA DE IGLESIA - MIEMBROS DE LA JUNTA - CREAR MIEMBRO<small>Haga clic en el botón de 3 puntos de la derecha de este título para agregar un nuevo registro.</small>
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
                        <form class="form-horizontal" method="POST" action="{{route('junta.agregarmiembro')}}">
                            @csrf
                            <input type="hidden" name="secretario_id" value="{{$f->id}}" />
                            <input type="hidden" name="periodo_id" value="{{$p->id}}" />
                            <input type="hidden" name="junta_id" value="{{$j->id}}" />
                            <div class="col-md-12">
                                <div class="form-group">
                                    <div class="form-line">
                                        <br/><label>Seleccione el Cargo Para el Miembro</label>
                                        <select class="form-control show-tick select2" name="cargogeneral_id" required="">
                                            @foreach($cargos as $key=>$value)
                                            <option value="{{$key}}">{{$value}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="form-line">
                                        <br/><label>Seleccione el Miembro</label>
                                        <select class="form-control show-tick select2" name="feligres_id" required="">
                                            @foreach($feligreses as $f)
                                            <option value="{{$f->id}}">{{$f->personanatural->primer_nombre." ".$f->personanatural->segundo_nombre." ".$f->personanatural->primer_apellido." ".$f->personanatural->segundo_apellido}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <br/><br/><a href="{{route('junta.miembros',[$f->id,$p->id,$j->id])}}" class="btn bg-red waves-effect">Cancelar</a>
                                    <button class="btn bg-indigo waves-effect" type="reset">Limpiar Formulario</button>
                                    <button class="btn bg-green waves-effect" type="submit">Guardar</button>
                                </div>
                            </div>
                        </form>
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
                <h4 class="modal-title" id="defaultModalLabel">SOBRE LA JUNTA DIRECTIVA - GESTIÓN DE MIEMBROS</h4>
            </div>
            <div class="modal-body">
                <strong>Detalles: </strong> La junta directiva es la máxima autoridad de la iglesia local y es precedida por el pastor del distrito. En éste apartado puede crear o gestionar la información de la junta directiva de su iglesia para un período ecleciástico vigente.<br/>
                <p>Agregue y elimine los miembros que hacen parte de la junta directiva de su iglesia como considere sea necesario.</p>
                <p>Agregue un miembro indicando el cargo que va a desempeñar.</p>
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
        $('.select2').select2();
    });
</script>
@endsection