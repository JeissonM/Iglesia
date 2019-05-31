@extends('layouts.admin')
@section('breadcrumb')
<ol class="breadcrumb breadcrumb-bg-blue-grey" style="margin-bottom: 30px;">
    <li><a href="{{route('inicio')}}">Inicio</a></li>
    <li><a href="{{route('admin.gestiondocumental')}}">Gestión Documental</a></li>
    <li><a href="{{route('multimediaministerial.index')}}">Multimedia Ministerial</a></li>
    <li><a href="{{route('multimediaministerial.lista',$r->ministerioextra_id)}}">Multimedia</a></li>
    <li class="active"><a>Editar</a></li>
</ol>
@endsection
@section('content')
<div class="row clearfix">
    <div class="col-md-12">
        <div class="card">
            <div class="header">
                <h2>
                    MULTIMEDIA MINISTERIAL<small>Haga clic en el botón de 3 puntos de la derecha de este título para obtener ayuda.</small>
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
                <h1 class="card-inside-title">DATOS DEL RECURSO MULTIMEDIA</h1>
                <div class="row clearfix">
                    <div class="col-md-12">
                        <table class="table table-hover">
                            <tbody>
                                <tr class="read">
                                    <td class="contact"><b>RECURSO MULTIMEDIA</b></td>
                                    <td class="contact"><b>DESCRIPCIÓN</b></td>
                                </tr>
                                <tr class="read">
                                    <td class="contact">{{$r->nombre}}</td>
                                    <td class="subject">{{$r->descripcion}}</td>
                                </tr>
                                <tr class="read">
                                    <td class="contact"><b>MINISTERIO</b></td>
                                    <td class="contact"><b>AUTOR</b></td>
                                </tr>
                                <tr class="read">
                                    <td class="contact">{{$r->ministerioextra->nombre}}</td>
                                    <td class="subject">{{$r->user->nombres." ".$r->user->apellidos}}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="col-md-12">
                        <h3 class="card-inside-title">AGREGAR ARCHIVO</h3>
                        <form class="form-horizontal" role='form' method="POST" action="{{route('multimediaministerial.store2')}}" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="multimediaministerial_id" value="{{$r->id}}" />
                            <div class='col-md-4'>
                                <div class='form-group'>
                                    <div class='form-line'>
                                        <label>Archivo de Recurso</label>
                                        <input class='form-control' type='file' name='recurso' required>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <button class="btn bg-green waves-effect" type="submit">GUARDAR</button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="col-md-12">
                        <h3 class="card-inside-title">LISTA DE ARCHIVOS EN EL RECURSO MULTIMEDIA</h3>
                        <div class="table-responsive">
                            <table id="tabla" class="table table-bordered table-striped table-hover table-responsive table-condensed dataTable js-exportable" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>RECURSO</th>
                                        <th>RETIRAR</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if(count($r->multimediaministerialitems)>0)
                                    @foreach($r->multimediaministerialitems as $l)
                                    <tr>
                                        <td><a href="{{asset('docs/multimedia/'.$l->recurso)}}" target="_blank">{{$l->recurso}}</a></td>
                                        <td>
                                            <a href="{{ route('multimediaministerial.delete2',[$r->id,$l->id])}}" class="btn bg-red waves-effect btn-xs" data-toggle="tooltip" data-placement="top" title="Eliminar Archivo"><i class="material-icons">delete</i></a>
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
    </div>
</div>
<!-- Modal -->
<div class="modal fade" id="mdModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content modal-col-blue">
            <div class="modal-header">
                <h4 class="modal-title" id="defaultModalLabel">SOBRE LOS RECURSOS MULTIMEDIA MINISTERIALES</h4>
            </div>
            <div class="modal-body">
                <strong>Detalles: </strong>Cree y administre los recursos multimedia ministeriales
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

</script>
@endsection