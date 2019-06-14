@extends('layouts.admin')
@section('breadcrumb')
<ol class="breadcrumb breadcrumb-bg-blue-grey" style="margin-bottom: 30px;">
    <li><a href="{{route('inicio')}}">Inicio</a></li>
    <li><a href="{{route('admin.comunicacion')}}">Comunicaciones</a></li>
    <li class="active"><a href="{{route('contacto.index')}}">Chat</a></li>
</ol>
@endsection
@section('content')
<div class="row clearfix">
    <div class="col-md-12">
        <div class="card">
            <div class="header">
                <h2>
                    CONTACTOS<small>Haga clic en el botón de 3 puntos de la derecha de este título para agregar un nuevo registro.</small>
                </h2>
                <ul class="header-dropdown m-r--5">
                    <li class="dropdown">
                        <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                            <i class="material-icons">more_vert</i>
                        </a>
                        <ul class="dropdown-menu pull-right">
                            <li><a href="{{ route('contacto.create') }}">Agregar Nuevo Contacto</a></li>
                            <li><a href="{{ route('chat.index') }}">Chats</a></li>
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
                                <th>NOMBRE</th>
                                <th>IGLESIA</th>
                                <th>DISTRITO</th>
                                <th>ASOCIACIÓN</th>
                                <th>CIUDAD</th>
                                <th>TELEFONO</th>
                                <th>CORREO</th>
                                <th>ACCIONES</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($contactos as $a)
                            <tr>
                                <td>{{$a->name}}</td>
                                <td>{{$a->igle}}</td>
                                <td>{{$a->dist}}</td>
                                <td>{{$a->asoci}}</td>
                                <td>{{$a->ciu}}</td>
                                <td>{{$a->feligres->personanatural->persona->celular}}</td>
                                <td>{{$a->feligres->personanatural->persona->mail}}</td>
                                <td>
                                    <a href="{{ route('chat.chatshow',[$a->id,'NULL'])}}" class="btn bg-green waves-effect btn-xs" data-toggle="tooltip" data-placement="top" title="Cambiar Estado"><i class="material-icons">arrow_forward</i></a>
                                    <a href="{{ route('contacto.delete',$a->id)}}" class="btn bg-red waves-effect btn-xs" data-toggle="tooltip" data-placement="top" title="Eliminar Contacto"><i class="material-icons">delete</i></a>
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
                <h4 class="modal-title" id="defaultModalLabel">SOBRE LOS CONTACTOS</h4>
            </div>
            <div class="modal-body">
                <strong>Detalles: </strong>Administre su lista de contactos con los cuales usted podrá chatear. Para iniciar un nuevo chat seleccione al contacto y haga clic en iniciar chat.
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