@extends('layouts.admin')
@section('breadcrumb')
<ol class="breadcrumb breadcrumb-bg-blue-grey" style="margin-bottom: 30px;">
    <li><a href="{{route('inicio')}}">Inicio</a></li>
    <li><a href="{{route('admin.comunicacion')}}">Comunicaciones</a></li>
    <li><a href="{{route('chat.index')}}">Chats</a></li>
    <li class="active">Nuevo Chat</li>
</ol>
@endsection
@section('content')
<div class="row clearfix">
    <div class="col-md-12">
        <div class="card">
            <div class="header">
                <h2>
                    {{$cont}}<small>Haga clic en el botón de 3 puntos de la derecha de este título para agregar un nuevo registro.</small>
                </h2>
                <ul class="header-dropdown m-r--5">
                    <li class="dropdown">
                        <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                            <i class="material-icons">more_vert</i>
                        </a>
                        <ul class="dropdown-menu pull-right">
                            <li><a href="{{ route('chat.index') }}">Chats</a></li>
                            <li><a data-toggle="modal" data-target="#mdModal">Ayuda</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
            <div class="body">
                <!-- Chat DANGER -->
                <div class="box box-danger direct-chat direct-chat-danger">
                    <div class="box-header with-border">
                        <h3 class="box-title">Chat</h3>

                        <div class="box-tools pull-right">
                            <button type="button" class="btn btn-box-tool" data-widget="Minimizar"><i class="fa fa-minus"></i>
                            </button>
                            <button type="button" class="btn btn-box-tool" data-widget="Cerrar"><i class="fa fa-times"></i></button>
                        </div>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <!-- Conversations are loaded here -->
                        <div class="direct-chat-messages">
                            <!-- Message. Default to the left -->
                            @foreach($chat->chatmensajes as $t)
                            @if($t->tipo=='AUTOR')
                            <!-- /.direct-chat-msg -->
                            <!-- Message to the right -->
                            <div class="direct-chat-msg right">
                                <div class="direct-chat-info clearfix">
                                    <span class="direct-chat-name pull-right">{{$usuario}}</span>
                                    <span class="direct-chat-timestamp pull-left">{{$t->created_at}}</span>
                                </div>
                                <!-- /.direct-chat-info -->
                                <div class="direct-chat-text">
                                    {{$t->mensaje}}
                                </div>
                                <!-- /.direct-chat-text -->
                            </div>
                            <!-- /.direct-chat-msg -->
                            @else
                            <div class="direct-chat-msg">
                                <div class="direct-chat-info clearfix">
                                    <span class="direct-chat-name pull-left">{{$cont}}</span>
                                    <span class="direct-chat-timestamp pull-right">{{$t->created_at}}</span>
                                </div>
                                <!-- /.direct-chat-info -->
                                <div class="direct-chat-text">
                                    {{$t->mensaje}}
                                </div>
                                <!-- /.direct-chat-text -->
                            </div>
                            @endif
                            @endforeach
                        </div>
                        <!--/.direct-chat-messages-->
                    </div>
                    <!-- /.box-body -->
                    <div class="box-footer">
                        <form id="form" class="form-horizontal" role='form' method="POST" action="{{route('chat.store')}}" enctype= "multipart/form-data">
                            @csrf 
                            <input type="hidden" name="contacto_id" id="pqr_id" value="{{$contacto->id}}"/>
                            <input type="hidden" name="chat_id" id="pqr_id" value="{{$chat->id}}"/>
                            <input type="hidden" name="user_id" id="res_id" value="{{Auth::user()->id}}"/>
                            <div class="input-group">
                                <input type="text" name="mensaje" placeholder="Mensaje ..." class="form-control">
                                <span class="input-group-btn">
                                    <button type="submit" class="btn btn-danger btn-flat">Enviar</button>
                                </span>
                            </div>
                        </form>
                    </div>
                    <!-- /.box-footer-->
                </div>
                <!--/.direct-chat -->
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