@extends('layouts.admin')
@section('breadcrumb')
<ol class="breadcrumb breadcrumb-bg-blue-grey" style="margin-bottom: 30px;">
    <li><a href="{{route('inicio')}}">Inicio</a></li>
    <li><a href="{{route('admin.comunicacion')}}">Comunicaciones</a></li>
    <li class="active"><a>Directorio Contractual</a></li>
</ol>
@endsection
@section('content')
<div class="row clearfix">
    <div class="col-md-12">
        <div class="card">
            <div class="header">
                <h2>
                    DIRECTORIO CONTRACTUAL<small>Haga clic en el botón de 3 puntos de la derecha de este título para obtener ayuda.</small>
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
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <div class="form-line">
                                <label class="control-label">Categoría de Labor</label>
                                <select class="form-control"  style="width: 100%;" id="categoria" onchange="getLabores()"/>
                                <option value="0">--Seleccione una opción--</option>
                                @foreach($categorias as $key=>$value)
                                <option value="{{$key}}">{{$value}}</option>
                                @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-5">
                        <div class="form-group">
                            <div class="form-line">
                                <label class="control-label">Labor/Profesión/Actividad Económica</label>
                                <select class="form-control"  style="width: 100%;" id="labor" onchange="getFeligreses()"/></select>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <a href="{{route('directoriocontractual.index')}}" class="btn btn-primary  btn-block btn-lg waves-effect">
                                <div><span>ACTUALIZAR LISTADO</span><span class="ink animate"></span></div>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="table-responsive">
                    <table id="tabla" class="table table-bordered table-striped table-hover table-responsive table-condensed dataTable js-exportable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>TIPO Y # DE DOC.</th>
                                <th>FELIGRÉS</th>
                                <th>IGLESIA ACTUAL</th>
                                <th>ESTADO ACTUAL</th>
                                <th>TELÉFONO CONTÁCTO</th>
                                <th>OCUPACIÓN</th>
                                <th>PROFESIÓN</th>
                                <th>ACCIONES</th>
                            </tr>
                        </thead>
                        <tbody id='tb2'>
                            @foreach($feligreses as $f)
                            <tr>
                                <td>{{$f->personanatural->persona->tipodocumento->abreviatura." - ".$f->personanatural->persona->numero_documento}}</td>
                                <td>{{$f->pn}}</td>
                                <td>{{$f->iglesia->nombre}}</td>
                                <td>{{$f->estado_actual}}</td>
                                <td>{{$f->personanatural->persona->telefono." - ".$f->personanatural->persona->celular}}</td>
                                <td>{{$f->personanatural->ocupacion}}</td>
                                <td>{{$f->personanatural->profesion}}</td>
                                <td>
                                    <a href="{{ route('directoriocontractual.ver',$f->id)}}" class="btn bg-green waves-effect btn-xs" data-toggle="tooltip" data-placement="top" title="Ver Feligrés"><i class="material-icons">remove_red_eye</i></a>
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
                <h4 class="modal-title" id="defaultModalLabel">SOBRE EL DIRECTORIO CONTRACTUAL</h4>
            </div>
            <div class="modal-body">
                <strong>Detalles: </strong> En este apartado podrá consultar las profesiones y conocimientos empíricos de los miembros de iglesia, esto con el fin de que usted como feligrés contrate para sus labores a miembros de iglesia en primera medida.
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


    function getLabores() {
        var id = $("#categoria").val();
        $.ajax({
            type: 'GET',
            url: url + "feligresia/categorialabor/" + id + "/categoria/labores",
            data: {},
        }).done(function (msg) {
            $("#labor option").each(function () {
                $(this).remove();
            });
            if (msg !== "null") {
                var m = JSON.parse(msg);
                $("#labor").append("<option value='0'>--Seleccione una opción--</option>");
                $.each(m, function (index, item) {
                    $("#labor").append("<option value='" + item.id + "'>" + item.value + "</option>");
                });
            } else {
                notify('Atención', 'La categoría seleccionada no posee información de labores.', 'error');
            }
        });
    }

    function getFeligreses() {
        var id = $("#labor").val();
        $.ajax({
            type: 'GET',
            url: url + "feligresia/labor/" + id + "/feligreses/listar",
            data: {},
        }).done(function (msg) {
            if (msg !== "null") {
                var m = JSON.parse(msg);
                var html = "";
                $.each(m, function (index, item) {
                    html = html + "<tr><td>" + item.d + "</td><td>" + item.f + "</td><td>" + item.i + "</td><td>" + item.e + "</td><td>" + item.t + "</td><td>" + item.o + "</td><td>" + item.p + "</td>"
                            + "<td><a href='" + url + "comunicacion/directoriocontractual/" + item.id + "/show' class='btn bg-green waves-effect btn-xs' data-toggle='tooltip' data-placement='top' title='Ver Feligrés'><i class='material-icons'>remove_red_eye</i></a></td></tr>";
                });
                $("#tb2").html("");
                $("#tb2").html(html);
            } else {
                notify('Atención', 'La labor seleccionada no posee información de feligreses.', 'error');
            }
        });
    }

</script>
@endsection