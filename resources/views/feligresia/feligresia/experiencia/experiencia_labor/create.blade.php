@extends('layouts.admin')
@section('breadcrumb')
<ol class="breadcrumb breadcrumb-bg-blue-grey" style="margin-bottom: 30px;">
    <li><a href="{{route('inicio')}}">Inicio</a></li>
    <li><a href="{{route('admin.feligresia')}}">Feligresía</a></li>
    <li><a href="{{route('admin.feligresia')}}">Feligresía</a></li>
    <li><a href="{{route('admin.feligresia')}}">Experiencia</a></li>
    <li><a href="{{route('experiencialabor.index2',$feligres->id)}}">Trabajo/Labor</a></li>
    <li class="active"><a>Crear Experiencia</a></li>
</ol>
@endsection
@section('content')
<div class="row clearfix">
    <div class="col-md-12">
        <div class="card">
            <div class="header">
                <h2>
                    DATOS DEL FELIGRES CONSULTADO
                </h2>
            </div>
            <div class="body">
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
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<div class="row clearfix">
    <div class="col-md-12">
        <div class="card">
            <div class="header">
                <h2>
                    EXPERIENCIA LABOR - CREAR NUEVA EXPERIENCIA<small> Haga clic en el botón de 3 puntos de la derecha de este título para obtener ayuda.</small>
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
                <div class="col-md-12">
                    @component('layouts.errors')
                    @endcomponent
                </div>
                <h1 class="card-inside-title">DATOS DE LA EXPERIENCIA</h1>
                <div class="row clearfix">
                    <div class="col-md-12">
                        <form class="form-horizontal" role='form' method="POST" action="{{route('experiencialabor.store')}}">
                            @csrf 
                            <input type="hidden" name="feligres_id" value="{{$feligres->id}}">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <div class="form-line">
                                        <label class="control-label">Categoría</label>
                                        <select class="form-control"  style="width: 100%;" name="categorialabor_id" id="categorialabor_id" onchange="getLabores()">
                                            <option value="">--Seleccione una opción--</option>
                                            @foreach($categorias as $key=>$value)
                                            <option value="{{$key}}">{{$value}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="form-line">
                                        <label class="control-label">Fecha Inicio</label>
                                        <br/><input class="form-control" type="date" name="fechainicio">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <div class="form-line">
                                        <label class="control-label">Labor</label>
                                        <select class="form-control"  style="width: 100%;" required="required" name="labor_id" id="labor_id">
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="form-line">
                                        <label class="control-label">Fecha Fin</label>
                                        <br/><input class="form-control" type="date" name="fechafin">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <br/><br/><a href="{{route('experiencialabor.index2',$feligres->id)}}" class="btn bg-red waves-effect">Cancelar</a>
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
        <div class="modal-content modal-col-orange">
            <div class="modal-header">
                <h4 class="modal-title" id="defaultModalLabel">SOBRE LAS EXPERIENCIAS</h4>
            </div>
            <div class="modal-body">
                <strong>Agregue nuevas experiencias,</strong> son las actividades económicas o profesiones que desempeña o a desempeñado el feligres consultado.
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-link waves-effect" data-dismiss="modal">ACEPTAR</button>
            </div>
        </div>
    </div>
</div>
@endsection
@section('script')
<script>

    function getLabores() {
        var id = $("#categorialabor_id").val();
        $.ajax({
            type: 'GET',
            url: url + "feligresia/experiencialabor/" + id + "/get/labores",
            data: {},
        }).done(function (msg) {
            $('#labor_id option').each(function () {
                $(this).remove();
            });
            if (msg !== "null") {
                var m = JSON.parse(msg);
                $("#labor_id").append("<option value=''>-- Seleccione una opción --</option>");
                $.each(m, function (index, item) {
                    $("#labor_id").append("<option value='" + item.id + "'>" + item.value + "</option>");
                });
            } else {
                notify('Atención', 'No hay labores para la categoria seleccionada.', 'error');
            }
        });
    }

</script>
@endsection