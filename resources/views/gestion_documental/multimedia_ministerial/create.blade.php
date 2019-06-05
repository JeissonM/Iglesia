@extends('layouts.admin')
@section('breadcrumb')
<ol class="breadcrumb breadcrumb-bg-blue-grey" style="margin-bottom: 30px;">
    <li><a href="{{route('inicio')}}">Inicio</a></li>
    <li><a href="{{route('admin.gestiondocumental')}}">Gestión Documental</a></li>
    <li><a href="{{route('multimediaministerial.index')}}">Multimedia Ministerial</a></li>
    <li><a href="{{route('multimediaministerial.lista',$m->id)}}">Multimedia</a></li>
    <li class="active"><a>Crear</a></li>
</ol>
@endsection
@section('content')
<div class="row clearfix">
    <div class="col-md-12">
        <div class="card">
            <div class="header">
                <h2>
                    MULTIMEDIA MINISTERIAL
                </h2>
            </div>
            <div class="body">
                <div class="col-md-12">
                    @component('layouts.errors')
                    @endcomponent
                </div>
                <div class="row clearfix">
                    <div class="col-md-12">
                        <h1 class="card-inside-title">DATOS DEL MINISTERIO</h1>
                        <table class="table table-hover">
                            <tbody>
                                <tr class="read">
                                    <td class="contact"><b>MINISTERIO</b></td>
                                    <td class="contact"><b>TIPO MINISTERIO</b></td>
                                </tr>
                                <tr class="read">
                                    <td class="contact">{{$m->nombre}}</td>
                                    <td class="subject">{{$m->tipoministerio->nombre}}</td>
                                </tr>
                                <tr class="read">
                                    <td class="contact"><b>DESCRIPCIÓN</b></td>
                                    <td class="contact"><b>CREACIÓN</b></td>
                                </tr>
                                <tr class="read">
                                    <td class="contact">{{$m->descripcion}}</td>
                                    <td class="subject">{{$m->created_at}}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div> 
                    <div class="col-md-12">
                        <h1 class="card-inside-title">DATOS DEL RECURSO MULTIMEDIA</h1>
                        <form class="form-horizontal" role='form' method="POST" action="{{route('multimediaministerial.store')}}" enctype="multipart/form-data">
                            @csrf 
                            <input type="hidden" name="user_id" value="{{$u->id}}" />
                            <input type="hidden" name="ministerioextra_id" value="{{$m->id}}" />
                            <div class="col-md-4">
                                <div class="form-group">
                                    <div class="form-line">
                                        <label>Nombre Recurso Multimedia</label>
                                        <input class="form-control" type="text" required="required" name="nombre">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-8">
                                <div class="form-group">
                                    <div class="form-line">
                                        <label>Descripción Recurso Multimedia (Opcional)</label>
                                        <input class="form-control" type="text" name="descripcion">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12" id="rr">

                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <a href="{{route('multimediaministerial.lista',$m->id)}}" class="btn btn-danger waves-effect">CANCELAR</a>
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