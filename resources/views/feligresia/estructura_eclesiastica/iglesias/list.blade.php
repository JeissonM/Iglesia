@extends('layouts.admin')
@section('breadcrumb')
<ol class="breadcrumb breadcrumb-bg-blue-grey" style="margin-bottom: 30px;">
    <li><a href="{{route('inicio')}}">Inicio</a></li>
    <li><a href="{{route('admin.feligresia')}}">Feligresía</a></li>
    <li><a href="{{route('admin.feligresia')}}">Estructura Eclesiástica</a></li>
    <li class="active"><a href="{{route('iglesia.index')}}">Iglesias</a></li>
</ol>
@endsection
@section('content')
<div class="row clearfix">
    <div class="col-md-12">
        <div class="card">
            <div class="header">
                <h2>
                    GESTIÓN DE LAS IGLESIAS<small>Haga clic en el botón de 3 puntos de la derecha de este título para agregar un nuevo registro.</small>
                </h2>
                <ul class="header-dropdown m-r--5">
                    <li class="dropdown">
                        <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                            <i class="material-icons">more_vert</i>
                        </a>
                        <ul class="dropdown-menu pull-right">
                            <li><a href="{{ route('iglesia.create') }}">Agregar Nueva Iglesia</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
            <div class="body">
                <div class="alert bg-teal alert-dismissible" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
                    <strong>Detalles: </strong> Las iglesias representan las congregaciones locales de miembros y sus templos. Las iglesias están clasificadas en IGLESIA si es capaz de auto sostenerse en liderazgo, logística, etc. Y en GRUPO que son pequeñas congregaciones asistidas por un distrito y que en materia de sostenibilidad dependen de la asociación/misión a la que pertenece.
                </div>
                <div class="responsive-table">
                    <table id="tabla" class="table table-bordered table-striped table-hover table-responsive table-condensed" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>Nombre</th>
                                <th>Estado</th>
                                <th>Tipo</th>
                                <th>Ciudad</th>
                                <th>Zona</th>
                                <th>Distrito</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($iglesias as $d)
                            <tr>
                                <td>{{$d->nombre}}</td>
                                <td>
                                    @if($d->activa=='1')
                                    <label class="label label-success">ACTIVA</label>
                                    @else
                                    <label class="label label-danger">INACTIVA</label>
                                    @endif
                                </td>
                                <td>{{$d->tipo}}</td>
                                <td>{{$d->ciudad->nombre}}</td>
                                <td>{{$d->zona->nombre}}</td>
                                <td>{{$d->distrito->nombre}}</td>
                                <td>
                                    <a href="{{ route('iglesia.edit',$d->id)}}" class="btn bg-indigo waves-effect btn-xs" data-toggle="tooltip" data-placement="top" title="Editar Iglesia"><i class="material-icons">mode_edit</i></a>
                                    <a href="{{ route('iglesia.show',$d->id)}}" class="btn bg-teal waves-effect btn-xs" data-toggle="tooltip" data-placement="top" title="Ver Iglesia"><i class="material-icons">more</i></a>
                                    <a href="{{ route('iglesia.delete',$d->id)}}" class="btn bg-red waves-effect btn-xs" data-toggle="tooltip" data-placement="top" title="Eliminar Iglesia"><i class="material-icons">delete</i></a>
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