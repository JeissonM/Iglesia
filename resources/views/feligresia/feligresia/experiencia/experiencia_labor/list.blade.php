@extends('layouts.admin')
@section('breadcrumb')
<ol class="breadcrumb breadcrumb-bg-blue-grey" style="margin-bottom: 30px;">
    <li><a href="{{route('inicio')}}">Inicio</a></li>
    <li><a href="{{route('admin.feligresia')}}">Feligresía</a></li>
    <li><a href="{{route('admin.feligresia')}}">Feligresía</a></li>
    <li><a href="{{route('admin.feligresia')}}">Experiencia</a></li>
    <li><a href="{{route('experiencialabor.index2',$feligres->id)}}">Trabajo/Labor</a></li>
</ol>
@endsection
@section('content')
<div class="row clearfix">
    <div class="col-md-12">
        <div class="card">
            <div class="header">
                <h2>
                    DATOS DEL FELIGRES CONSULTADO
                </h2>
            </div>
            <div class="body">
                <table class="table table-hover">
                    <tbody>
                        <tr class="read">
                            <td class="contact"><b>Tipo y Número de Documento</b></td>
                            <td class="subject">{{$feligres->personanatural->persona->tipodocumento->abreviatura." - ".$feligres->personanatural->persona->numero_documento}}</td>
                        </tr>
                        <tr class="read">
                            <td class="contact"><b>Nombre</b></td>
                            <td class="subject">{{$feligres->personanatural->primer_apellido." ".$feligres->personanatural->segundo_apellido." ".$feligres->personanatural->primer_nombre." ".$feligres->personanatural->segundo_nombre}}</td>
                        </tr>
                        <tr class="read">
                            <td class="contact"><b>Estado Civil</b></td>
                            <td class="subject">{{$feligres->personanatural->estadocivil->descripcion}}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<div class="row clearfix">
    <div class="col-md-12">
        <div class="card">
            <div class="header">
                <h2>
                    EXPERIENCIA LABOR<small>Haga clic en el botón de 3 puntos de la derecha de este título para obtener ayuda.</small>
                </h2>
                <ul class="header-dropdown m-r--5">
                    <li class="dropdown">
                        <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                            <i class="material-icons">more_vert</i>
                        </a>
                        <ul class="dropdown-menu pull-right">
                            <li><a href="{{ route('experiencialabor.create2',$feligres->id)}}">Agregar Nueva Experiencia</a></li>
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
                                <th>CATEGORIA</th>
                                <th>LABOR</th>
                                <th>FECHA INICIO</th>
                                <th>FECHA FIN</th>
                                <th>CREADO</th>
                                <th>MODIFICADO</th>
                                <th>ACCIONES</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($experiencias as $f)
                            <tr>
                                <td>{{$f->id}}</td>
                                <td>{{$f->labor->categorialabor->nombre}}</td>
                                <td>{{$f->labor->nombre}}</td>
                                <td>{{$f->fechainicio}}</td>
                                <td>{{$f->fechafin}}</td>
                                <td>{{$f->created_at}}</td>
                                <td>{{$f->updated_at}}</td>
                                <td>
                                    <a href="{{ route('experiencialabor.edit',$f->id)}}" class="btn bg-indigo waves-effect btn-xs" data-toggle="tooltip" data-placement="top" title="Editar Experiencia"><i class="material-icons">mode_edit</i></a>
                                    <a href="{{ route('experiencialabor.delete',$f->id)}}" class="btn bg-red waves-effect btn-xs" data-toggle="tooltip" data-placement="top" title="Eliminar Experiencia"><i class="material-icons">delete</i></a>
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
        <div class="modal-content modal-col-orange">
            <div class="modal-header">
                <h4 class="modal-title" id="defaultModalLabel">SOBRE LA EXPERIENCIA</h4>
            </div>
            <div class="modal-body">
                <strong>Gestione la experiencia laboral,</strong> son las actividades económicas o profesiones que desempeña o ha desempeñado el feligrés consultado.
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-link waves-effect" data-dismiss="modal">ACEPTAR</button>
            </div>
        </div>
    </div>
</div>
@endsection