@extends('layouts.admin')
@section('breadcrumb')
<ol class="breadcrumb breadcrumb-bg-blue-grey" style="margin-bottom: 30px;">
    <li><a href="{{route('inicio')}}">Inicio</a></li>
    <li><a href="{{route('admin.feligresia')}}">Feligresía</a></li>
    <li><a href="{{route('admin.feligresia')}}">Feligresía</a></li>
    <li class="active"><a>Disciplina</a></li>
</ol>
@endsection
@section('content')
<div class="row clearfix">
    <div class="col-md-12">
        <div class="card">
            <div class="header">
                <h2>
                    DISCIPLINA<small>Haga clic en el botón de 3 puntos de la derecha de este título para agregar un nuevo registro.</small>
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
                <h2> DATOS DEL FELIGRÉS CONSULTADO</h2>
                </br><div class="row clearfix">
                    <div class="col-md-12">
                        <table class="table table-hover">
                            <tbody>
                                <tr class="read">
                                    <td class="contact"><b>Tipo y Número de Documento</b></td>
                                    <td class="subject">{{$feligres->personanatural->persona->tipodocumento->abreviatura." - ".$feligres->personanatural->persona->numero_documento}}</td>
                                </tr>
                                <tr class="read">
                                    <td class="contact"><b>Nombre</b></td>
                                    <td class="subject">{{$feligres->personanatural->primer_apellido." ".$feligres->personanatural->segundo_apellido." ".$feligres->personanatural->primer_nombre." ".$feligres->personanatural->segundo_nombre}}</td>
                                </tr>
                                <tr class="read">
                                    <td class="contact"><b>Estado Civil</b></td>
                                    <td class="subject">{{$feligres->personanatural->estadocivil->descripcion}}</td>
                                </tr>
                                <tr class="read">
                                    <td class="contact"><b>Iglesia Actual</b></td>
                                    <td class="subject">{{$feligres->iglesia->nombre}}</td>
                                </tr>
                                <tr class="read">
                                    <td class="contact"><b>Estado Actual</b></td>
                                    <td class="subject">{{$feligres->estado_actual}}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                </br><h2>APLICAR DISCIPLINA</h2></br>
                <div class="col-md-12">
                    <form class="form-horizontal" role='form' method="POST" action="{{route('disciplina.store')}}">
                        @csrf 
                        <input type="hidden" value="{{$feligres->id}}" name="feligres_id" id="feligres_id" />
                        <div class="col-md-12">
                            <div class="form-group">
                                <div class="form-line">
                                    <br/><input class="form-control" type="text" placeholder="Descripción dela disciplina" name="descripcion">    
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <div class="form-line">
                                    <br/><label>Fecha Inicio Disciplina</label>
                                    <input class="form-control" type="date" name="fechainicio">    
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <div class="form-line">
                                    <br/><label>Fecha Fin Disciplina</label>
                                    <input class="form-control" type="date" name="fechafin">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <div class="form-line">
                                    <br/><label>Período</label>
                                    <select class="form-control"  style="width: 100%;" id="periodo_id" name="periodo_id" onchange="getReuniones()">
                                        <option value="">-- Seleccione una opción --</option>
                                        @foreach($periodos as $key=>$value)
                                        <option value="{{$value->id}}">{{$value->etiqueta}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <div class="form-line">
                                    <br/><label>Reunión de la Junta dónde se aplicó la disciplina</label>
                                    <select class="form-control"  style="width: 100%;" id="reunionjunta_id" name="reunionjunta_id">
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <button class="btn bg-green waves-effect" type="submit">APLICAR DISCIPLINA</button></br></br>
                            </div>
                        </div>
                    </form>
                </div>
                </br><h2>HISTORIAL DE DISCIPLINAS APLICADAS</h2></br>
                <div class="table-responsive">
                    <table id="tabla" class="table table-bordered table-striped table-hover table-responsive table-condensed dataTable js-exportable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>FECHA APLICACIÓN</th>
                                <th>FECHA INICIO</th>
                                <th>FECHA FIN</th>
                                <th>PERÍODO</th>
                                <th>ACCIONES</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(count($feligres->disciplinas)>0)
                            @foreach($feligres->disciplinas as $d)
                            <tr>
                                <td>{{$d->created_at}}</td>
                                <td>{{$d->fechainicio}}</td>
                                <td>{{$d->fechafin}}</td>
                                <td>{{$d->reunionjunta->junta->periodo->etiqueta}}</td>
                                <td>
                                    <a href="{{ route('categorialabor.edit',$d->id)}}" class="btn bg-primary waves-effect btn-xs" data-toggle="tooltip" data-placement="top" title="Ver Disciplina"><i class="material-icons">eye</i></a>
                                    <a href="{{ route('categorialabor.delete',$d->id)}}" class="btn bg-red waves-effect btn-xs" data-toggle="tooltip" data-placement="top" title="Eliminar Disciplina"><i class="material-icons">delete</i></a>
                                </td>
                            </tr>
                            @endforeach
                            @endif
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
                <h4 class="modal-title" id="defaultModalLabel">SOBRE LAS DISCIPLINAS</h4>
            </div>
            <div class="modal-body">
                <strong>Detalles: </strong>Visualice las disciplinas que han sido aplicadas a un miembro de iglesia, también puede crear nuevas disciplinas.
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

    function getReuniones() {
        var p = $("#periodo_id").val();
        var f = $("#feligres_id").val();
        $.ajax({
            type: 'GET',
            url: url + "feligresia/junta/menu/periodo/continuar/menu/" + f + "/" + p + "/reuniones/obtenerreunion",
            data: {},
        }).done(function (msg) {
            $('#reunionjunta_id option').each(function () {
                $(this).remove();
            });
            var m = JSON.parse(msg);
            if (m.error == "NO") {
                $.each(m.data, function (index, item) {
                    $("#reunionjunta_id").append("<option value='" + index + "'>" + item + "</option>");
                });
            } else {
                notify('Atención', 'La junta del feligrés seleccionado no ha realizado reuniones para disciplinar.', 'error');
            }
        });
    }
</script>
@endsection