@extends('layouts.admin')
@section('breadcrumb')
<ol class="breadcrumb breadcrumb-bg-blue-grey" style="margin-bottom: 30px;">
    <li><a href="{{route('inicio')}}">Inicio</a></li>
    <li><a href="{{route('admin.feligresia')}}">Feligresía</a></li>
    <li><a href="{{route('admin.feligresia')}}">Feligresía</a></li>
    <li><a href="{{route('pastor.index')}}">Pastores</a></li>
    <li class="active"><a>Editar Pastor</a></li>
</ol>
@endsection
@section('content')
<div class="row clearfix">
    <div class="col-md-12">
        <div class="card">
            <div class="header">
                <h2>
                    PASTOR - EDITAR PASTOR<small>Haga clic en el botón de 3 puntos de la derecha de este título para obtener ayuda.</small>
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
                <h2> DATOS DEL FELIGRES CONSULTADO</h2>
                <div class="row clearfix">
                    <div class="col-md-12">
                        <table class="table table-hover">
                            <tbody>
                                <tr class="read">
                                    <td class="contact"><b>Tipo y Número de Documento</b></td>
                                    <td class="subject">{{$pastor->personanatural->persona->tipodocumento->abreviatura." - ".$pastor->personanatural->persona->numero_documento}}</td>
                                </tr>
                                <tr class="read">
                                    <td class="contact"><b>Nombre</b></td>
                                    <td class="subject">{{$pastor->personanatural->primer_apellido." ".$pastor->personanatural->segundo_apellido." ".$pastor->personanatural->primer_nombre." ".$pastor->personanatural->segundo_nombre}}</td>
                                </tr>
                                <tr class="read">
                                    <td class="contact"><b>Estado Civil</b></td>
                                    <td class="subject">{{$pastor->personanatural->estadocivil->descripcion}}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <h1 class="card-inside-title">EDITAR DATOS DEl PASTOR: {{$pastor->personanatural->primer_nombre."".$pastor->personanatural->primer_apellido}}</h1>
                <div class="row clearfix">
                    <div class="col-md-12">
                        <form class="form-horizontal" role='form' method="POST" action="{{route('pastor.update',$pastor->id)}}">
                            @csrf 
                            <input name="_method" type="hidden" value="PUT" /> 
                            <input name="personanatural_id" type="hidden" value="{{$pastor->personanatural_id}}">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <div class="form-line">
                                        <label class="control-label">Fecha de Ordenamiento</label>
                                        <br/><input class="form-control" type="date"  required="required" name="pastor_desde" value="{{$pastor->pastor_desde}}">    
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="form-line">
                                        <label class="control-label">Jubilado</label>
                                        <select class="form-control"  style="width: 100%;" required="required" name="jubilado">
                                            @if($pastor->jubilado == 'SI')
                                            <option value="SI" selected>SI</option>
                                            <option value="NO">NO</option>
                                            @else
                                            <option value="SI">SI</option>
                                            <option value="NO" selected>NO</option>
                                            @endif
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="form-line">
                                        <label class="control-label">Fecha de Jubilación</label>
                                        <br/><input class="form-control" type="date"  name="fecha_jubilacion" value="{{$pastor->fecha_jubilacion}}">    
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="form-line">
                                        <br/><input class="form-control" type="text" placeholder="Situación del pastor" name="situacion" value="{{$pastor->situacion}}">    
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <div class="form-line">
                                        <br/><input class="form-control" type="text" placeholder="Distritos o zonas a cargo del pastor" name="pastor_sobre" value="{{$pastor->pastor_sobre}}">    
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="form-line">
                                        <label class="control-label">Asociación</label>
                                        <select class="form-control"  style="width: 100%;" id="asociacion" name="asociacion" onchange="getDistritos()">
                                            <option value="">-- Seleccione una opción --</option>
                                            @foreach($asociaciones as $key=>$value)
                                            <option value="{{$key}}">{{$value}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="form-line">
                                        <label class="control-label">Distrito (Actual - {{$pastor->distrito->nombre}})</label>
                                        <select class="form-control"  style="width: 100%;" name="distrito_id" id="distrito_id" onchange="getIglesias()">
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="form-line">
                                        <label class="control-label">Iglesia/Grupo (Actual - {{$pastor->iglesia->nombre}})</label>
                                        <select class="form-control"  style="width: 100%;" id="iglesia_id" name="iglesia_id">
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <br/><br/><a href="{{route('pastor.index')}}" class="btn bg-red waves-effect">Cancelar</a>
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
                <h4 class="modal-title" id="defaultModalLabel">SOBRE LOS PASTORES</h4>
            </div>
            <div class="modal-body">
                <strong>Edite los datos del pastor,</strong> tenga en cuenta que si no desea editar los campos distrito e iglesia no debe seleccionar el campo asociación.
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
    function getDistritos() {
        var id = $("#asociacion").val();
        $.ajax({
            type: 'GET',
            url: url + "feligresia/asociacion/" + id + "/distritos",
            data: {},
        }).done(function (msg) {
            $('#distrito_id option').each(function () {
                $(this).remove();
            });
            $('#iglesia_id option').each(function () {
                $(this).remove();
            });
            if (msg !== "null") {
                var m = JSON.parse(msg);
                $("#distrito_id").append("<option value=''>-- Seleccione una opción --</option>");
                $.each(m, function (index, item) {
                    $("#distrito_id").append("<option value='" + item.id + "'>" + item.value + "</option>");
                });
            } else {
                notify('Atención', 'La asociación seleccionada no posee información de distritos.', 'error');
            }
        });
    }

    function getIglesias() {
        var id = $("#distrito_id").val();
        $.ajax({
            type: 'GET',
            url: url + "feligresia/distrito/" + id + "/iglesias",
            data: {},
        }).done(function (msg) {
            $('#iglesia_id option').each(function () {
                $(this).remove();
            });
            if (msg !== "null") {
                var m = JSON.parse(msg);
                $("#iglesia_id").append("<option value=''>-- Seleccione una opción --</option>");
                $.each(m, function (index, item) {
                    $("#iglesia_id").append("<option value='" + item.id + "'>" + item.value + "</option>");
                });
            } else {
                notify('Atención', 'El distrito seleccionado no posee información de iglesias.', 'error');
            }
        });
    }
</script>
@endsection