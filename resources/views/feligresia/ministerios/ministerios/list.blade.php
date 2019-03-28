@extends('layouts.admin')
@section('breadcrumb')
<ol class="breadcrumb breadcrumb-bg-blue-grey" style="margin-bottom: 30px;">
    <li><a href="{{route('inicio')}}">Inicio</a></li>
    <li><a href="{{route('admin.feligresia')}}">Feligresía</a></li>
    <li><a href="{{route('admin.feligresia')}}">Ministerios</a></li>
    <li class="active"><a href="{{route('ministerio.index')}}"> Ministerios Oficiales</a></li>
</ol>
@endsection
@section('content')
<div class="row clearfix">
    <div class="col-md-12">
        <div class="card">
            <div class="header">
                <h2>
                    MINISTERIOS OFICIALES<small>Haga clic en el botón de 3 puntos de la derecha de este título para agregar un nuevo registro.</small>
                </h2>
                <ul class="header-dropdown m-r--5">
                    <li class="dropdown">
                        <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                            <i class="material-icons">more_vert</i>
                        </a>
                        <ul class="dropdown-menu pull-right">
                            <li><a href="{{ route('ministerio.create') }}">Agregar Nuevo Ministerio</a></li>
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
                                <th>ID</th>
                                <th>NOMBRE</th>
                                <th>DESCRIPCIÓN</th>
                                <th>CREADO</th>
                                <th>MODIFICADO</th>
                                <th>ACCIONES</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($ministerios as $ministerio)
                            <tr>
                                <td>{{$ministerio->id}}</td>
                                <td>{{$ministerio->nombre}}</td>
                                <td>{{$ministerio->descripcion}}</td>
                                <td>{{$ministerio->created_at}}</td>
                                <td>{{$ministerio->updated_at}}</td>
                                <td>
                                    <a href="{{ route('ministerio.edit',$ministerio->id)}}" class="btn bg-indigo waves-effect btn-xs" data-toggle="tooltip" data-placement="top" title="Editar Ministerio"><i class="material-icons">mode_edit</i></a>
                                    <a href="{{ route('ministerio.delete',$ministerio->id)}}" class="btn bg-red waves-effect btn-xs" data-toggle="tooltip" data-placement="top" title="Eliminar Ministerio"><i class="material-icons">delete</i></a>
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
        <div class="modal-content modal-col-grey">
            <div class="modal-header">
                <h4 class="modal-title" id="defaultModalLabel">SOBRE LOS MINISTERIOS OFICIALES DE LA IGLESIA(DEPARTAMENTOS)</h4>
            </div>
            <div class="modal-body">
                <strong>Detalles: </strong>Los ministerios oficiales de la iglesia son los departamentos ministeriales que trabajan en la misión de la iglesia y que hacen parte de su estructura organizacional. Ente ellos están: ministerio musical, ministerio de mayordomía, ministerio de educación, ministerio juvenil, etc. 
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
        //$('#tabla').DataTable();
    });
</script>
@endsection