@extends('layouts.admin')
@section('breadcrumb')
<ol class="breadcrumb breadcrumb-bg-blue-grey" style="margin-bottom: 30px;">
    <li><a href="{{route('inicio')}}">Inicio</a></li>
    <li><a href="{{route('admin.feligresia')}}">Feligresía</a></li>
    <li><a href="{{route('admin.feligresia')}}">Feligresía</a></li>
    <li class="active"><a>Pastores</a></li>
</ol>
@endsection
@section('content')
<div class="row clearfix">
    <div class="col-md-12">
        <div class="card">
            <div class="header">
                <h2>
                    PASTORES<small>Haga clic en el botón de 3 puntos de la derecha de este título para agregar un nuevo registro.</small>
                </h2>
                <ul class="header-dropdown m-r--5">
                    <li class="dropdown">
                        <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                            <i class="material-icons">more_vert</i>
                        </a>
                        <ul class="dropdown-menu pull-right">
                            <li><a data-toggle="modal" data-target="#crear">Agregar Nuevo Pastor</a></li>
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
                                <th>TIPO Y NÚMERO DE DOCUMENTO.</th>
                                <th>PASTOR</th>
                                <th>SITUACIÓN</th>
                                <th>PASTOR DESDE</th>
                                <th>PASTOR SOBRE</th>
                                <th>IGLESIA ACTUAL</th>
                                <th>DISTRITO ACTUAL</th>
                                <th>CREADO</th>
                                <th>MODIFICADO</th>
                                <th>ACCIONES</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($pastores as $f)
                            <tr>
                                <td>{{$f->personanatural->persona->tipodocumento->abreviatura." - ".$f->personanatural->persona->numero_documento}}</td>
                                <td>{{$f->personanatural->primer_apellido." ".$f->personanatural->segundo_apellido." ".$f->personanatural->primer_nombre." ".$f->personanatural->segundo_nombre}}</td>
                                <td>{{$f->situacion}}</td>
                                <td>{{$f->pastor_desde}}</td>
                                <td>{{$f->pastor_sobre}}</td>
                                <td>{{$f->iglesia->nombre}}</td>
                                <td>{{$f->distrito->nombre}}</td>
                                <td>{{$f->created_at}}</td>
                                <td>{{$f->updated_at}}</td>
                                <td>
                                    <a href="{{ route('pastor.edit',$f->id)}}" class="btn bg-indigo waves-effect btn-xs" data-toggle="tooltip" data-placement="top" title="Editar Pastor"><i class="material-icons">mode_edit</i></a>
                                    <a href="{{ route('pastor.show',$f->id)}}" class="btn bg-green waves-effect btn-xs" data-toggle="tooltip" data-placement="top" title="Ver Pastor"><i class="material-icons">remove_red_eye</i></a>
                                    <a href="{{ route('pastor.delete',$f->id)}}" class="btn bg-red waves-effect btn-xs" data-toggle="tooltip" data-placement="top" title="Eliminar Pastor"><i class="material-icons">delete</i></a>
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
<!-- Modal Crear -->
<div class="modal fade" id="crear" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="defaultModalLabel">AGREGAR NUEVO PASTOR</h4>
            </div>
            <div class="modal-body">
                <div class="row clearfix">
                    <form class="form-horizontal" method="POST" action="{{route('pastor.operaciones')}}" name="form-privilegios" id="form-privilegios">
                        @csrf
                        <div class="col-md-12">
                            <div class="col-sm-8">
                                <div class="form-group">
                                    <div class="form-line">
                                        <input type="text" id="id" class="form-control" placeholder="Escriba la identificación a consultar" name="id"/>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <button type="submit" class="btn bg-orange waves-effect btn-block">CONSULTAR FELIGRES</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-link waves-effect" data-dismiss="modal">CANCELAR</button>
            </div>
        </div>
    </div>
</div>
<!-- Modal -->
<div class="modal fade" id="mdModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content modal-col-orange">
            <div class="modal-header">
                <h4 class="modal-title" id="defaultModalLabel">SOBRE LOS PASTORES</h4>
            </div>
            <div class="modal-body">
                <strong>Administre la información de los pastores,</strong> son todos los miembros bautizados y registrados en el libro de secretaría de iglesia.
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