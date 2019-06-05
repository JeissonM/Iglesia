@extends('layouts.admin')
@section('breadcrumb')
<ol class="breadcrumb breadcrumb-bg-blue-grey" style="margin-bottom: 30px;">
    <li><a href="{{route('inicio')}}">Inicio</a></li>
    <li><a href="{{route('admin.gestiondocumental')}}">Gestión Documental</a></li>
    <li><a href="{{route('multimediaministerial.index')}}">Multimedia Ministerial</a></li>
    <li class="active"><a>Multimedia</a></li>
</ol>
@endsection
@section('content')
<div class="row clearfix">
    <div class="col-md-12">
        <div class="card">
            <div class="header">
                <h2>
                    MULTIMEDIA MINISTERIAL<small>Haga clic en el botón de 3 puntos de la derecha de este título para agregar un nuevo registro.</small>
                </h2>
                <ul class="header-dropdown m-r--5">
                    <li class="dropdown">
                        <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                            <i class="material-icons">more_vert</i>
                        </a>
                        <ul class="dropdown-menu pull-right">
                            <li><a href="{{route('multimediaministerial.create2',$m->id)}}">Agregar Nuevo Recurso Multimedia</a></li>
                            <li><a data-toggle="modal" data-target="#mdModal">Ayuda</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
            <div class="body">
                <h1 class="card-inside-title">DATOS DEL MINISTERIO</h1>
                <div class="col-md-12">
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
                <h1 class="card-inside-title">LISTADO DE RECURSOS MULTIMEDIA</h1>
                <div class="table-responsive">
                    <table id="tabla" class="table table-bordered table-striped table-hover table-responsive table-condensed dataTable js-exportable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>MULTIMEDIA</th>
                                <th>DESCRIPCIÓN</th>
                                <th>RECURSOS</th>
                                <th>CONTINUAR</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(count($m->multimediaministerials)>0)
                            @foreach($m->multimediaministerials as $r)
                            <tr>
                                <td>{{$r->nombre}}</td>
                                <td>{{$r->descripcion}}</td>
                                <td>
                                    @if(count($r->multimediaministerialitems)>0)
                                    <ul>
                                        @foreach($r->multimediaministerialitems as $i)
                                        <li><a href="{{asset('docs/multimedia/'.$i->recurso)}}" target="_blank">{{$i->recurso}}</a></li>
                                        @endforeach
                                    </ul>
                                    @else
                                    ---
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('multimediaministerial.edit',$r->id)}}" class="btn bg-indigo waves-effect btn-xs" data-toggle="tooltip" data-placement="top" title="Editar Documentos"><i class="material-icons">mode_edit</i></a>
                                    <a href="{{ route('multimediaministerial.delete',$r->id)}}" class="btn bg-red waves-effect btn-xs" data-toggle="tooltip" data-placement="top" title="Eliminar Recurso Multimedia"><i class="material-icons">delete</i></a>
                                </td>
                            </tr>
                            @endforeach
                            @endif
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
</script>
@endsection