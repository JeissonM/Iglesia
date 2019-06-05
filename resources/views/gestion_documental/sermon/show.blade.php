@extends('layouts.admin')
@section('breadcrumb')
<ol class="breadcrumb breadcrumb-bg-blue-grey" style="margin-bottom: 30px;">
    <li><a href="{{route('inicio')}}">Inicio</a></li>
    <li><a href="{{route('admin.gestiondocumental')}}">Gestión Documental</a></li>
    <li><a href="{{route('sermon.index')}}">Sermones</a></li>
    <li class="active"><a>Ver Sermón</a></li>
</ol>
@endsection
@section('content')
<div class="row clearfix">
    <div class="col-md-12">
        <div class="card">
            <div class="header">
                <h2>
                    SERMÓN - VER SERMÓN<small>Haga clic en el botón de 3 puntos de la derecha de este título para obtener ayuda.</small>
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
                <h2> DATOS DEL SERMÓN</h2>
                </br><div class="row clearfix">
                    <div class="col-md-12">
                        <table class="table table-hover">
                            <tbody>
                                <tr class="read">
                                    <td class="contact"><b>Titulo</b></td>
                                    <td class="subject">{{$sermon->titulo}}</td>
                                </tr>
                                <tr class="read">
                                    <td class="contact"><b>Descripción</b></td>
                                    <td class="subject">{{$sermon->descripcion}}</td>
                                </tr>
                                <tr class="read">
                                    <td class="contact"><b>Tipo</b></td>
                                    <td class="subject">{{$sermon->tipo}}</td>
                                </tr>
                                <tr class="read">
                                    <td class="contact"><b>Tipo de Autor</b></td>
                                    <td class="subject">{{$sermon->tipoautor}}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="row clearfix">
                    <div class="col-md-12">
                            @if($sermon->tipo == 'PDF')
                            <iframe src="{{asset('multimedia/sermones/'.$sermon->archivo)}}" width="100%" height="1200px"></iframe>
                            @elseif($sermon->tipo == 'AUDIO')
                            <audio controls src="{{asset('multimedia/sermones/'.$sermon->archivo)}}" width="100%"></audio>
                            @else
                            <video controls src="{{asset('multimedia/sermones/'.$sermon->archivo)}}" width="100%"></video>
                            @endif
                    </div>
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
                <h4 class="modal-title" id="defaultModalLabel">SOBRE LOS LIBROS</h4>
            </div>
            <div class="modal-body">
                <strong>Cambie los documento del libro,</strong> Administre los libros.
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
</script>
@endsection