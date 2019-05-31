@extends('layouts.admin')
@section('breadcrumb')
<ol class="breadcrumb breadcrumb-bg-blue-grey" style="margin-bottom: 30px;">
    <li><a href="{{route('inicio')}}">Inicio</a></li>
    <li><a href="{{route('admin.comunicacion')}}">Comunicaciones</a></li>
    <li class="active"><a>Directorio de Feligreses</a></li>
</ol>
@endsection
@section('content')
<div class="row clearfix">
    <div class="col-md-12">
        <div class="card">
            <div class="header">
                <h2>
                    DIRECTORIO DE FELIGRESES<small>Haga clic en el botón de 3 puntos de la derecha de este título para agregar un nuevo registro.</small>
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
                <h4>CONSULTAR POR:</h4>
                <div class="button-demo">
                    <a data-toggle="modal" data-target="#mDistrito" class="btn bg-green waves-effect">
                        <div><span>DISTRIO</span><span class="ink animate"></span></div>
                    </a>
                    <a data-toggle="modal" data-target="#mAsociacion" class="btn bg-green waves-effect">
                        <div><span>ASOCIACIÓN</span><span class="ink animate"></span></div>
                    </a>
                    <a data-toggle="modal" data-target="#mCiudad" class="btn bg-green waves-effect">
                        <div><span>CIUDAD</span><span class="ink animate"></span></div>
                    </a>
                    <a data-toggle="modal" data-target="#mIglesia" class="btn bg-green waves-effect">
                        <div><span>IGLESIA</span><span class="ink animate"></span></div>
                    </a>
                    <a data-toggle="modal" data-target="#mLabor" class="btn bg-green waves-effect">
                        <div><span>LABOR</span><span class="ink animate"></span></div>
                    </a>
                </div>
            </div>
            <div class="body">
                <div class="table-responsive">
                    <table id="tabla" class="table table-bordered table-striped table-hover table-responsive table-condensed dataTable js-exportable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>TIPO Y # DE DOC.</th>
                                <th>FELIGRÉS</th>
                                <th>IGLESIA ACTUAL</th>
                                <th>ESTADO ACTUAL</th>
                                <th>SITUACIÓN ACTUAL</th>
                                <th>OCUPACIÓN</th>
                                <th>PROFESIÓN</th>
                                <th>ACCIONES</th>
                            </tr>
                        </thead>
                        <tbody id='tb2'>
                            @foreach($feligreses as $f)
                            <tr>
                                <td>{{$f->personanatural->persona->tipodocumento->abreviatura." - ".$f->personanatural->persona->numero_documento}}</td>
                                <td>{{$f->personanatural->primer_apellido." ".$f->personanatural->segundo_apellido." ".$f->personanatural->primer_nombre." ".$f->personanatural->segundo_nombre}}</td>
                                <td>{{$f->iglesia->nombre}}</td>
                                <td>{{$f->estado_actual}}</td>
                                <td>{{$f->situacionfeligres->nombre}}</td>
                                <td>{{$f->ocupacion}}</td>
                                <td>{{$f->profesion}}</td>
                                <td>
                                    <a href="{{ route('feligres.ver',$f->id)}}" class="btn bg-green waves-effect btn-xs" data-toggle="tooltip" data-placement="top" title="Ver Feligrés"><i class="material-icons">remove_red_eye</i></a>
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
<!-- Modal Ciudad -->
<div class="modal fade" id="mCiudad" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="defaultModalLabel">CONSULTA POR CIUDADES</h4>
            </div>
            <div class="modal-body">
                    <div class="col-md-12">
                        <div class="form-group">
                            <div class="form-line">
                                <label class="control-label">Ciudad de Ubicación</label>
                                <select class="form-control"  style="width: 100%;" id="ciudad_id" name="ciudad_id" onchange="getIglesiasd('CIUDAD')"/>
                                <option value="">--Seleccione una opción--</option>
                                @foreach($ciudades as $key=>$value)
                                <option value="{{$key}}">{{$value}}</option>
                                @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-link waves-effect" data-dismiss="modal">ACEPTAR</button>
            </div>
        </div>
    </div>
</div>
<!-- Modal Distrito -->
<div class="modal fade" id="mDistrito" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="defaultModalLabel">CONSULTA POR DISTRITO</h4>
            </div>
            <div class="modal-body">
                <div class="col-md-12">
                    <div class="form-group">
                        <div class="form-line">
                            <label class="control-label">Distrito</label>
                            <select class="form-control select2"  style="width: 100%;" id="distrito_id" name="distrito_id" onchange="getIglesiasd('DISTRITO')"/>
                            <option value="">--Seleccione una opción--</option>
                            @foreach($distritos as $key=>$value)
                            <option value="{{$key}}">{{$value}}</option>
                            @endforeach
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-link waves-effect" data-dismiss="modal" >ACEPTAR</button>
            </div>
        </div>
    </div>
</div>
<!-- Modal Union -->
<div class="modal fade" id="mIglesia" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="defaultModalLabel">CONSULTA POR IGLESIA</h4>
            </div>
            <div class="modal-body">
                <div class="col-md-12">
                    <div class="form-group">
                        <div class="form-line">
                            <label class="control-label">Iglesia</label>
                            <select class="form-control"  style="width: 100%;" id="iglesia_id" name="iglesia_id" onchange="getIglesiasd('IGLESIA')"/>
                            <option value="">--Seleccione una opción--</option>
                            @foreach($iglesias as $key=>$value)
                            <option value="{{$key}}">{{$value}}</option>
                            @endforeach
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-link waves-effect" data-dismiss="modal" >ACEPTAR</button>
            </div>
        </div>
    </div>
</div>
<!-- Modal Asociación -->
<div class="modal fade" id="mAsociacion" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="defaultModalLabel">CONSULTA POR ASOCIACIÓN</h4>
            </div>
            <div class="modal-body">
                <div class="col-md-12">
                    <div class="form-group">
                        <div class="form-line">
                            <label class="control-label">Asociación</label>
                            <select class="form-control"  style="width: 100%;" id="asociacion_id" name="union_id" onchange="getIglesiasd('ASOCIACION')"/>
                            <option value="">--Seleccione una opción--</option>
                            @foreach($asociaciones as $key=>$value)
                            <option value="{{$key}}">{{$value}}</option>
                            @endforeach
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-link waves-effect" data-dismiss="modal" >ACEPTAR</button>
            </div>
        </div>
    </div>
</div>
<!-- Modal Asociación -->
<div class="modal fade" id="mLabor" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="defaultModalLabel">CONSULTA POR LABOR</h4>
            </div>
            <div class="modal-body">
                <div class="col-md-12">
                    <div class="form-group">
                        <div class="form-line">
                            <label class="control-label">Labor</label>
                            <select class="form-control"  style="width: 100%;" id="asociacion_id" name="labor_id" onchange="getIglesiasd('LABOR')"/>
                            <option value="">--Seleccione una opción--</option>
                            @foreach($labor as $key=>$value)
                            <option value="{{$key}}">{{$value}}</option>
                            @endforeach
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-link waves-effect" data-dismiss="modal" >ACEPTAR</button>
            </div>
        </div>
    </div>
</div>
<!-- Modal -->
<div class="modal fade" id="mdModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content modal-col-green">
            <div class="modal-header">
                <h4 class="modal-title" id="defaultModalLabel">SOBRE EL DIRECTORIO</h4>
            </div>
            <div class="modal-body">
                <strong>Detalles: </strong> Consulte los feligreses por iglesia, labor, ciudad, entre otros.
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
    $('.select2').select2();

    function getIglesiasd(tipo) {
        if (tipo == 'DISTRITO') {
            var id = $("#distrito_id").val();
        }
        if (tipo == 'IGLESIA') {
            var id = $("#iglesia_id").val();
        }
        if (tipo == 'ASOCIACION') {
            var id = $("#asociacion_id").val();
        }
        if (tipo == 'CIUDAD') {
            var id = $("#ciudad_id").val();
        }
        if (tipo == 'LABOR') {
            var id = $("#labor_id").val();
        }
        $.ajax({
            type: 'GET',
            url: url + "comunicacion/feligres/" + id + "/" + tipo + "/directorio/feligres/getfeligres",
            data: {},
        }).done(function (msg) {
            if (msg !== "null") {
                var m = JSON.parse(msg);
                var html = "";
                $.each(m, function (index, item) {
                    html = html + "<tr><td>" + item.documento + "</td>";
                    html = html + "<td>" + item.nombre + "</td>";
                    html = html + "<td>" + item.iglesia + "</td>";
                    html = html + "<td>" + item.estado + "</td>";
                    html = html + "<td>" + item.situacion + "</td>";
                    html = html + "<td>" + item.ocupacion + "</td>";
                    html = html + "<td>" + item.profesion + "</td>";
                    html = html + "<td><a href='" + url + "comunicacion/feligres/" + item.id + "/directorio/feligres/ver' class='btn bg-green waves-effect btn-xs' data-toggle='tooltip' data-placement='top' title='Ver Feligrés'><i class='material-icons'>remove_red_eye</i></a></td>";
                    +"</tr>";
                });
                $("#tb2").html(html);
            } else {
                notify('Atención', 'No hay iglesias para el parametro seleccionado.', 'error');
            }
        });
    }

</script>
@endsection