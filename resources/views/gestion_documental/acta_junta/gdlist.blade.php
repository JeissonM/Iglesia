@extends('layouts.admin')
@section('breadcrumb')
<ol class="breadcrumb breadcrumb-bg-blue-grey" style="margin-bottom: 30px;">
    <li><a href="{{route('inicio')}}">Inicio</a></li>
    <li><a href="{{route('admin.gestiondocumental')}}">Gestión Documental</a></li>
    <li class="active"><a>Actas de Reuniones de Junta de Iglesia</a></li>
</ol>
@endsection
@section('content')
<div class="row clearfix">
    <div class="col-md-12">
        <div class="card">
            <div class="header">
                <h2>
                    ACTAS DE REUNIONES DE JUNTA DE IGLESIA<small>Haga clic en el botón de 3 puntos de la derecha de este título para agregar un nuevo registro.</small>
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
                        <form class="form-horizontal" method="POST">
                            @csrf
                            <input type="hidden" name="feligres_id" id="feligres_id" value="{{$f->id}}" />
                            <div class="col-md-12">
                                <div class="form-group">
                                    <div class="form-line">
                                        <label>Período Ecleciástico</label>
                                        <br/><select class="form-control show-tick select2" name="periodo_id" id="periodo_id" required="">
                                            @foreach($periodos as $key=>$value)
                                            <option value="{{$key}}">{{$value}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <button class="btn bg-green waves-effect" type="button" onclick="enviar()">Continuar</button>
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
        <div class="modal-content modal-col-blue">
            <div class="modal-header">
                <h4 class="modal-title" id="defaultModalLabel">SOBRE LAS ACTAS DE LA JUNTA DIRECTIVA</h4>
            </div>
            <div class="modal-body">
                <strong>Detalles: </strong> La junta directiva es la máxima autoridad de la iglesia local y es precedida por el pastor del distrito. En éste apartado puede consultar las actas generadas en las reuniones de dicho órgano administrativo.
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

    function enviar() {
        location.href = url + "gestiondocumental/junta/actas/" + $("#feligres_id").val() + "/" + $("#periodo_id").val() + "/reuniones";
    }
</script>
@endsection