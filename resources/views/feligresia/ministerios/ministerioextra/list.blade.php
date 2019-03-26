@extends('layouts.admin')
@section('breadcrumb')
<ol class="breadcrumb breadcrumb-bg-blue-grey" style="margin-bottom: 30px;">
    <li><a href="{{route('inicio')}}">Inicio</a></li>
    <li><a href="{{route('admin.feligresia')}}">Feligresía</a></li>
    <li><a href="{{route('admin.feligresia')}}">Ministerios</a></li>
    <li class="active"><a href="{{route('ministerioextra.index')}}"> Ministerios Extra-Oficiales</a></li>
</ol>
@endsection
@section('content')
<div class="row clearfix">
    <div class="col-md-12">
        <div class="card">
            <div class="header">
                <h2>
                    MINISTERIOS EXTRA-OFICIALES<small>Haga clic en el botón de 3 puntos de la derecha de este título para agregar un nuevo registro.</small>
                </h2>
                <ul class="header-dropdown m-r--5">
                    <li class="dropdown">
                        <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                            <i class="material-icons">more_vert</i>
                        </a>
                        <ul class="dropdown-menu pull-right">
                            <li><a href="{{ route('ministerioextra.create') }}">Agregar Nuevo Ministerio Extra-Oficial</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
            <div class="body">
                <div class="alert bg-teal alert-dismissible" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
                    <strong>Detalles: </strong>Los ministerios extra-oficiales de la iglesia son los departamentos ministeriales que trabajan en la misión de la iglesia pero que no hacen parte de su estructura organizacional ni responden legalmente a nombre de la iglesia. Ente ellos están: ministerio musical, ministerio de mayordomía, ministerio de educación, ministerio juvenil, clubes (los clubes si responden legalmente a la iglesia y son ministerios oficiales de la organización), etc. 
                </div>
                <div class="responsive-table">
                    <table id="tabla" class="table table-bordered table-striped table-hover table-responsive table-condensed" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>Id</th>
                                <th>Nombre</th>
                                <th>Descripción</th>
                                <th>Creado</th>
                                <th>Modificado</th>
                                <th>Acciones</th>
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
                                    <a href="{{ route('ministerioextra.edit',$ministerio->id)}}" class="btn bg-indigo waves-effect btn-xs" data-toggle="tooltip" data-placement="top" title="Editar Ministerio"><i class="material-icons">mode_edit</i></a>
                                    <a href="{{ route('ministerioextra.delete',$ministerio->id)}}" class="btn bg-red waves-effect btn-xs" data-toggle="tooltip" data-placement="top" title="Eliminar Ministerio"><i class="material-icons">delete</i></a>
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
@endsection
@section('script')
<script type="text/javascript">
    $(document).ready(function () {
        $('#tabla').DataTable();
    });
</script>
@endsection