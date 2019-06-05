@extends('layouts.admin')
@section('breadcrumb')
<ol class="breadcrumb breadcrumb-bg-blue-grey" style="margin-bottom: 30px;">
    <li><a href="{{route('inicio')}}">Inicio</a></li>
    <li><a href="{{route('admin.gestiondocumental')}}">Gestión Documental</a></li>
    <li><a href="{{route('recursosministeriales.index')}}">Recursos Ministeriales</a></li>
    <li class="active"><a>Crear Recurso</a></li>
</ol>
@endsection
@section('content')
<div class="row clearfix">
    <div class="col-md-12">
        <div class="card">
            <div class="header">
                <h2>
                    RECURSOS MINISTERIALES<small>Haga clic en el botón de 3 puntos de la derecha de este título para obtener ayuda.</small>
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
                <h1 class="card-inside-title">DATOS DEL RECURSO</h1>
                <div class="row clearfix">
                    <div class="col-md-12">
                        <form class="form-horizontal" role='form' method="POST" action="{{route('recursosministeriales.store')}}" enctype="multipart/form-data">
                            @csrf 
                            <input type="hidden" name="user_id" value="{{$u->id}}" />
                            <div class="col-md-4">
                                <div class="form-group">
                                    <div class="form-line">
                                        <label>Ministerio</label>
                                        <select class="form-control show-tick select2" name="ministerio_id" required="">
                                            @foreach($ministerios as $key=>$value)
                                            <option value="{{$key}}">{{$value}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <div class="form-line">
                                        <label>Nombre Recurso</label>
                                        <input class="form-control" type="text" required="required" name="nombre">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <div class="form-line">
                                        <label>Descripción Recurso</label>
                                        <input class="form-control" type="text" name="descripcion">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12" id="rr">

                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <a href="{{route('recursosministeriales.index')}}" class="btn btn-danger waves-effect">CANCELAR</a>
                                    <button class="btn bg-blue waves-effect" onclick="add()">AGREGAR CAMPO PARA RECURSO</button>
                                    <button class="btn bg-green waves-effect" type="submit">GUARDAR</button>
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
                <h4 class="modal-title" id="defaultModalLabel">SOBRE LOS RECURSOS MINISTERIALES</h4>
            </div>
            <div class="modal-body">
                <strong>Detalles: </strong>Cree y administre los recursos ministeriales, todo miembro de junta directiva que tenga un ministerio a cargo podrá colgar recursos y materiales para el trabajo en dicho ministerio. Estos materiales serán visibles y descargables desde la web pública.
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
    $('.select2').select2();

    function add() {
        var html = $("#rr").html();
        $("#rr").html(html + "<div class='col-md-4'>"
                + "<div class='form-group'>"
                + "<div class='form-line'>"
                + "<label>Archivo de Recurso</label>"
                + "<input class='form-control' type='file' name='recurso[]' required multiple>"
                + "</div>"
                + "</div>"
                + "</div>");
    }
</script>
@endsection