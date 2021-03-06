@extends('layouts.admin')
@section('breadcrumb')
<ol class="breadcrumb breadcrumb-bg-blue-grey" style="margin-bottom: 30px;">
    <li><a href="{{route('inicio')}}">Inicio</a></li>
    <li><a href="{{route('admin.comunicacion')}}">Comunicaciones</a></li>
    <li><a href="{{route('contacto.index')}}">Contactos</a></li>
    <li class="active"><a href="{{route('chat.index')}}">Chats</a></li>
</ol>
@endsection
@section('content')
<div class="row clearfix">
    <div class="col-md-12">
        <div class="card">
            <div class="header">
                <h2>
                    CHATS<small>Haga clic en el botón de 3 puntos de la derecha de este título para agregar un nuevo registro.</small>
                </h2>
            </div>
            <div class="body">
                <ul class="list-group">
                    @foreach($chats as $i)
                    <li class="list-group-item">{{$i->name}}<a class="badge btn-danger waves-effect " href="{{route('chat.chatdelete',$i->id)}}"  data-toggle="tooltip" data-placement="top" title="Eliminar Chat"><i class="material-icons" style="font-size: 15px;">delete</i></a><a class="badge bg-teal waves-effect " href="{{route('chat.chatshow',["NULL",$i->id])}}"  data-toggle="tooltip" data-placement="top" title="chat"><i class="material-icons" style="font-size: 15px;">forum</i></a></li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
</div>
<!-- Modal -->
<div class="modal fade" id="mdModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content modal-col-green">
            <div class="modal-header">
                <h4 class="modal-title" id="defaultModalLabel">SOBRE LOS CHATS</h4>
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