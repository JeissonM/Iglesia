@extends('layouts.admin')
@section('breadcrumb')
<ol class="breadcrumb breadcrumb-bg-blue-grey" style="margin-bottom: 30px;">
    <li><a href="{{route('inicio')}}">Inicio</a></li>
    <li><a href="{{route('admin.comunicacion')}}">Comunicaciones</a></li>
    <li class="active"><a href="{{route('anuncios.index')}}">Anuncios</a></li>
</ol>
@endsection
@section('content')
<div class="row clearfix">
    <div class="col-md-12">
        <div class="card">
            <div class="header">
                <h2>
                    ANUNCIOS<small>Haga clic en el botón de 3 puntos de la derecha de este título para agregar un nuevo registro.</small>
                </h2>
                <ul class="header-dropdown m-r--5">
                    <li class="dropdown">
                        <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                            <i class="material-icons">more_vert</i>
                        </a>
                        <ul class="dropdown-menu pull-right">
                            <li><a href="{{ route('anuncios.create') }}">Agregar Nuevo Anuncio</a></li>
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
                                <th>TIPO</th>
                                <th>TÍTULO</th>
                                <th>ESTADO</th>
                                <th>AUTOR</th>
                                <th>CREADO</th>
                                <th>MODIFICADO</th>
                                <th>ACCIONES</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($anuncios as $a)
                            <tr>
                                <td>{{$a->tipo}}</td>
                                <td>{{$a->titulo}}</td>
                                <td>
                                @if($a->estado=='VIGENTE')
                                <label class="label label-success">{{$a->estado}}</label>
                                @else
                                <label class="label label-danger">{{$a->estado}}</label>
                                @endif
                                </td>
                                <td>{{$a->autor}}</td>
                                <td>{{$a->created_at}}</td>
                                <td>{{$a->updated_at}}</td>
                                <td>
                                    <a href="{{ route('anuncios.estado',$a->id)}}" class="btn bg-green waves-effect btn-xs" data-toggle="tooltip" data-placement="top" title="Cambiar Estado"><i class="material-icons">arrow_forward</i></a>
                                    <a href="{{ route('anuncios.edit',$a->id)}}" class="btn bg-indigo waves-effect btn-xs" data-toggle="tooltip" data-placement="top" title="Editar Anuncio"><i class="material-icons">mode_edit</i></a>
                                    <a href="{{ route('anuncios.delete',$a->id)}}" class="btn bg-red waves-effect btn-xs" data-toggle="tooltip" data-placement="top" title="Eliminar Anuncio"><i class="material-icons">delete</i></a>
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
        <div class="modal-content modal-col-green">
            <div class="modal-header">
                <h4 class="modal-title" id="defaultModalLabel">SOBRE LOS ANUNCIOS</h4>
            </div>
            <div class="modal-body">
                <strong>Detalles: </strong>Administre el boletín de anuncios para cada sábado o semana, cambie los estados o elimine un anuncio cuando no quiera que aparezca en el proyector.
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