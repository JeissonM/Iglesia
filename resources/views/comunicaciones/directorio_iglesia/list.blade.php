@extends('layouts.admin')
@section('breadcrumb')
<ol class="breadcrumb breadcrumb-bg-blue-grey" style="margin-bottom: 30px;">
    <li><a href="{{route('inicio')}}">Inicio</a></li>
    <li><a href="{{route('admin.comunicacion')}}">Comunicaciones</a></li>
    <li class="active"><a>Directorio de Iglesias</a></li>
</ol>
@endsection
@section('content')
<div class="row clearfix">
    <div class="col-md-12">
        <div class="card">
            <div class="header">
                <h2>
                    DIRECTORIO DE IGLESIAS<small>Haga clic en el botón de 3 puntos de la derecha de este título para agregar un nuevo registro.</small>
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
                    <a data-toggle="modal" data-target="#mUnion" class="btn bg-green waves-effect">
                        <div><span>UNIÓN</span><span class="ink animate"></span></div>
                    </a>
                </div>
            </div>
            <div class="body">
                <div class="table-responsive">
                    <table id="tabla" class="table table-bordered table-striped table-hover table-responsive table-condensed dataTable js-exportable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>NOMBRE</th>
                                <th>CIUDAD</th>
                                <th>DISTRITO</th>
                                <th>TIPO</th>
                                <th>CORREO</th>
                                <th>SITIO WEB</th>
                                <th>PASTOR</th>
                                <th>ESTADO</th>
                            </tr>
                        </thead>
                        <tbody id='tb2'>
                            @foreach($iglesias as $d)
                            <tr>
                                <td>{{$d->nombre}}</td>
                                <td>{{$d->ciudad->nombre}}</td>
                                <td>{{$d->distrito->nombre}}</td>
                                <td>{{$d->tipo}}</td>
                                <td>{{$d->email}}</td>
                                <td>{{$d->sitioweb}}</td>
                                <td>{{$d->pastor}}</td>
                                <td>
                                    @if($d->activa=='1')
                                    <label class="label label-success">ACTIVA</label>
                                    @else
                                    <label class="label label-danger">INACTIVA</label>
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
                            <select class="form-control select2"  style="width: 100%;" id="ciudad_id" name="ciudad_id" onchange="getIglesiasd('CIUDAD')"/>
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
<div class="modal fade" id="mUnion" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="defaultModalLabel">CONSULTA POR UNIÓN</h4>
            </div>
            <div class="modal-body">
                <div class="col-md-12">
                    <div class="form-group">
                        <div class="form-line">
                            <label class="control-label">Unión</label>
                            <select class="form-control select2"  style="width: 100%;" id="union_id" name="union_id" onchange="getIglesiasd('UNION')"/>
                            <option value="">--Seleccione una opción--</option>
                            @foreach($uniones as $key=>$value)
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
                            <select class="form-control select2"  style="width: 100%;" id="asociacion_id" name="union_id" onchange="getIglesiasd('ASOCIACION')"/>
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
<!-- Modal -->
<div class="modal fade" id="mdModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content modal-col-green">
            <div class="modal-header">
                <h4 class="modal-title" id="defaultModalLabel">SOBRE LAS IGLESIAS</h4>
            </div>
            <div class="modal-body">
                <strong>Detalles: </strong> Las iglesias representan las congregaciones locales de miembros y sus templos. Las iglesias están clasificadas en IGLESIA si es capaz de auto sostenerse en liderazgo, logística, etc. Y en GRUPO que son pequeñas congregaciones asistidas por un distrito y que en materia de sostenibilidad dependen de la asociación/misión a la que pertenece.
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
    $('.select2').select2();

    function getIglesiasd(tipo) {
        if (tipo == 'DISTRITO') {
            var id = $("#distrito_id").val();
        }
        if (tipo == 'UNION') {
            var id = $("#union_id").val();
        }
        if (tipo == 'ASOCIACION') {
            var id = $("#asociacion_id").val();
        }
        if (tipo == 'CIUDAD') {
            var id = $("#ciudad_id").val();
        }
        $.ajax({
            type: 'GET',
            url: url + "comunicacion/iglesia/" + id + "/" + tipo + "/directorio/getiglesias",
            data: {},
        }).done(function (msg) {
            if (msg !== "null") {
                var m = JSON.parse(msg);
                var html = "";
                $.each(m, function (index, item) {
                    html = html + "<tr><td>" + item.value + "</td>";
                    html = html + "<td>" + item.ciudad + "</td>";
                    html = html + "<td>" + item.distrito + "</td>";
                    html = html + "<td>" + item.tipo+ "</td>";
                    html = html + "<td>" + item.correo + "</td>";
                    html = html + "<td>" + item.sitio + "</td>";
                    html = html + "<td>" + item.pastor + "</td>";
                    html = html + "<td>" + item.estado + "</td>";
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