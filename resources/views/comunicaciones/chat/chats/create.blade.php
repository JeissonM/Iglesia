@extends('layouts.admin')
@section('style')
<style type="text/css">
    .direct-chat-messages, .direct-chat-contacts {
        -webkit-transition: -webkit-transform .5s ease-in-out;
        -moz-transition: -moz-transform .5s ease-in-out;
        -o-transition: -o-transform .5s ease-in-out;
        transition: transform .5s ease-in-out;
    }
    .direct-chat-messages {
        -webkit-transform: translate(0, 0);
        -ms-transform: translate(0, 0);
        -o-transform: translate(0, 0);
        transform: translate(0, 0);
        padding: 10px;
        height: 500px;
        overflow: auto;
    }
    .direct-chat-msg {
        margin-bottom: 10px;
    }
    .direct-chat-msg, .direct-chat-text {
        display: block;
    }
    .direct-chat-info {
        display: block;
        margin-bottom: 2px;
        font-size: 12px;
    }
    .direct-chat-name {
        font-weight: 600;
    }
    .pull-left {
        float: left!important;
    }
    .direct-chat-info {
        display: block;
        margin-bottom: 2px;
        font-size: 12px;
    }
    .direct-chat-timestamp {
        color: #999;
    }
    .pull-right {
        float: right!important;
    }
    .direct-chat-img {
        border-radius: 50%;
        float: left;
        width: 40px;
        height: 40px;
    }
    img {
        vertical-align: middle;
        border: 0;
    }
    .direct-chat-text {
        border-radius: 5px;
        position: relative;
        padding: 5px 10px;
        background: #d2d6de;
        border: 1px solid #d2d6de;
        margin: 5px 0 0 50px;
        color: #444;
    }
    .direct-chat-name {
        font-weight: 600;
    }
    .direct-chat-danger .right>.direct-chat-text {
        background: #dd4b39;
        border-color: #dd4b39;
        color: #fff;
    }
    .right .direct-chat-text {
        margin-right: 50px;
        margin-left: 0;
        float: none !important;
    }
    .direct-chat-text {
        border-radius: 5px;
        position: relative;
        padding: 5px 10px;
        background: #d2d6de;
        border: 1px solid #d2d6de;
        margin: 5px 0 0 50px;
        color: #444;
    }
    .direct-chat-msg:before, .direct-chat-msg:after {
        content: " ";
        display: table;
    }
    .right .direct-chat-img {
        float: right;
    }
    .direct-chat-text:after {
        border-width: 5px;
        margin-top: -5px;
    }
    .direct-chat-text:after, .direct-chat-text:before {
        position: absolute;
        right: 100%;
        top: 15px;
        border: solid transparent;
        border-right-color: #d2d6de;
        content: ' ';
        height: 0;
        width: 0;
        pointer-events: none;
    }
    .right .direct-chat-text:after, .right .direct-chat-text:before {
        right: auto;
        left: 100%;
        border-right-color: transparent;
        border-left-color: #d2d6de;
    }
    .direct-chat-danger .right>.direct-chat-text:after, .direct-chat-danger .right>.direct-chat-text:before {
        border-left-color: #dd4b39;
    }
    .direct-chat-text:before {
        border-width: 6px;
        margin-top: -6px;
    }
</style>
@endsection
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
                            @if($t->user_id==Auth::user()->id)
                            <div class="direct-chat-msg right" style="float: none !important;">
                                <div class="direct-chat-info clearfix">
                                    <span class="direct-chat-name pull-right">{{$usuario}}</span>
                                    <span class="direct-chat-timestamp pull-left">{{$t->created_at}}</span>
                                </div>
                                <img class="direct-chat-img" src="{{ asset('img/user.png')}}" alt="Message User Image"><!-- /.direct-chat-img -->
                                <div class="direct-chat-text">
                                    {{$t->mensaje}}
                                </div>
                            </div>
                            @else
                            <div class="direct-chat-msg">
                                <div class="direct-chat-info clearfix">
                                    <span class="direct-chat-name pull-left">{{$cont}}</span>
                                    <span class="direct-chat-timestamp pull-right">{{$t->created_at}}</span>
                                </div>
                                <img class="direct-chat-img" src="{{ asset('img/user.png')}}" alt="Message User Image">
                                <div class="direct-chat-text">
                                    {{$t->mensaje}}
                                </div>
                            </div>
                            @endif
                            @endforeach
                        </div>
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