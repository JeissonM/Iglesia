@extends('layouts.admin')
@section('breadcrumb')
<ol class="breadcrumb breadcrumb-bg-blue-grey" style="margin-bottom: 30px;">
    <li><a href="{{route('inicio')}}">Inicio</a></li>
    <li><a href="{{route('admin.gestiondocumental')}}">Gestión Documental</a></li>
    <li class="active"><a>Multimedia Ministerial</a></li>
</ol>
@endsection
@section('content')
<div class="row clearfix">
    <div class="col-md-12">
        <div class="card">
            <div class="header">
                <h2>
                    MULTIMEDIA MINISTERIAL - LISTA DE SUS MINISTERIOS<small>Haga clic en el botón de 3 puntos de la derecha de este título para agregar un nuevo registro.</small>
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
                <div class="table-responsive">
                    <table id="tabla" class="table table-bordered table-striped table-hover table-responsive table-condensed dataTable js-exportable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>MINISTERIO</th>
                                <th>DESCRIPCIÓN</th>
                                <th>FUNCIÓN</th>
                                <th>CONTINUAR</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($min as $m)
                            <tr>
                                <td>{{$m->ministerioextra->nombre}}</td>
                                <td>{{$m->ministerioextra->descripcion}}</td>
                                <td>{{$m->funcion}}</td>
                                <td>
                                    <a href="{{ route('multimediaministerial.lista',$m->ministerioextra_id)}}" class="btn bg-indigo waves-effect btn-xs" data-toggle="tooltip" data-placement="top" title="Continuar"><i class="material-icons">arrow_forward</i></a>
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
        <div class="modal-content modal-col-blue">
            <div class="modal-header">
                <h4 class="modal-title" id="defaultModalLabel">SOBRE LA MULTIMEDIA MINISTERIAL</h4>
            </div>
            <div class="modal-body">
                <strong>Detalles: </strong>Cree y administre los recursos multimedia ministerial, todo miembro de igleisa que esté presente en un ministerio podrá colgar recursos multimedia y materiales para el trabajo en dicho ministerio.
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

    function continuar() {
        location.href = url + "gestiondocumental/recursosministeriales/" + $("#p").val() + "/create";
    }
</script>
@endsection