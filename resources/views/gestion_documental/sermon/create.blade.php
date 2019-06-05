@extends('layouts.admin')
@section('breadcrumb')
<ol class="breadcrumb breadcrumb-bg-blue-grey" style="margin-bottom: 30px;">
    <li><a href="{{route('inicio')}}">Inicio</a></li>
    <li><a href="{{route('admin.gestiondocumental')}}">Gestión Documental</a></li>
    <li><a href="{{route('sermon.index')}}">Sermones</a></li>
    <li class="active"><a>Crear Sermon</a></li>
</ol>
@endsection
@section('content')
<div class="row clearfix">
    <div class="col-md-12">
        <div class="card">
            <div class="header">
                <h2>
                    SERMONES - CREAR SERMOR<small>Haga clic en el botón de 3 puntos de la derecha de este título para obtener ayuda.</small>
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
                <h1 class="card-inside-title">DATOS DEL SERMON</h1>
                <div class="row clearfix">
                    <div class="col-md-12">
                        <form class="form-horizontal" role='form' method="POST" action="{{route('sermon.store')}}" enctype= "multipart/form-data">
                            @csrf 
                            <div class="col-md-6">
                                <div class="form-group">
                                    <div class="form-line">
                                        <br/><input class="form-control" type="text" placeholder="Titulo del sermon" required="required" name="titulo">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="form-line">
                                        <label class="control-label">Tipo de Autor</label>
                                        <br/><select class="form-control show-tick select2" name="tipoautor" required="required" id="tipoautor" onchange="autor()">
                                            <option value="">--Seleccione una opción--</option>
                                            <option value="FELIGRES">FELIGRES</option>
                                            <option value="PASTOR">PASTOR</option>
                                            <option value="OTRO">OTRO</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="form-line">
                                        <label class="control-label">Feligres</label>
                                        <br/><select class="form-control show-tick select2" name="feligres_id" id="feligres_id" >
                                            <option value="">--Seleccione una opción--</option>
                                            @foreach($feligreses as $key=>$value)
                                            <option value="{{$key}}">{{$value}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="form-line">
                                        <br/><input class="form-control" type="text" placeholder="Nombre del autor del sermon"  name="otro" id="otro">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <div class="form-line">
                                        <br/><input class="form-control" type="text" placeholder="Descripción" required="required" name="descripcion">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="form-line">
                                        <label class="control-label">Tipo</label>
                                        <br/><select class="form-control show-tick select2" name="tipo" required="required">
                                            <option value="">--Seleccione una opción--</option>
                                            <option value="VIDEO">VIDEO</option>
                                            <option value="AUDIO">AUDIO</option>
                                            <option value="PDF">PDF</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="form-line">
                                        <label class="control-label">Pastor</label>
                                        <br/><select class="form-control show-tick select2" name="pastor_id" id="pastor_id" >
                                            <option value="">--Seleccione una opción--</option>
                                            @foreach($pastores as $key=>$value)
                                            <option value="{{$key}}">{{$value}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="form-line">
                                        <br/><input class="form-control" type="file" required="required" name="archivo">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <br/><br/><a href="{{route('sermon.index')}}" class="btn bg-red waves-effect">Cancelar</a>
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
        <div class="modal-content modal-col-blue">
            <div class="modal-header">
                <h4 class="modal-title" id="defaultModalLabel">SOBRE LOS SERMONES</h4>
            </div>
            <div class="modal-body">
                <strong>Agregue nuevos sermones,</strong> Administre los sermones, asegurese de que los formatos de audio sean MP3,WAV o OGG y los formatos de video sean MP4,WEBM o OGG.
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
    $(".chosen-select").chosen({});
    $(document).ready(function () {
        $("#feligres_id").attr('disabled', true);
        $("#pastor_id").attr('disabled', true);
        $("#otro").attr('disabled', true);
    });

    function limpiar() {
        $("#feligres_id").val("");
        $("#pastor_id").val("");
        $("#otro").val("");
    }
    function autor() {
        var tipo = $("#tipoautor").val();
        limpiar();
        if (tipo == 'FELIGRES') {
            $("#feligres_id").removeAttr('disabled');
            $("#pastor_id").attr('disabled', true);
            $("#otro").attr('disabled', true);
        } else if (tipo == 'PASTOR') {
            $("#pastor_id").removeAttr('disabled');
            $("#feligres_id").attr('disabled', true);
            $("#otro").attr('disabled', true);
        } else {
            $("#otro").removeAttr('disabled');
            $("#feligres_id").attr('disabled', true);
            $("#pastor_id").attr('disabled', true);
        }
    }
</script>
@endsection