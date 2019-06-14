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
        background: #f3f3f3;
        border: 1px solid #f3f3f3;
        margin: 5px 0 0 50px;
        color: #000000;
    }
    .direct-chat-name {
        font-weight: 600;
    }
    .direct-chat-danger .right>.direct-chat-text {
        background: #dcf8c6;
        border-color: #dcf8c6;
        color: #000000 !important;
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
        background: #f3f3f3;
        border: 1px solid #f3f3f3;
        margin: 5px 0 0 50px;
        color: #000000 !important;
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
        border-right-color: #f3f3f3;
        content: ' ';
        height: 0;
        width: 0;
        pointer-events: none;
    }
    .right .direct-chat-text:after, .right .direct-chat-text:before {
        right: auto;
        left: 100%;
        border-right-color: transparent;
        border-left-color: #f3f3f3;
    }
    .direct-chat-danger .right>.direct-chat-text:after, .direct-chat-danger .right>.direct-chat-text:before {
        border-left-color: #dcf8c6;
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
                    CONVERSACIÓN CON: {{$cont}}
                </h2>
            </div>
            <div class="body">
                <!-- Chat DANGER -->
                <div class="box box-danger direct-chat direct-chat-danger">
                    <div class="box-header with-border">
                        <h3 class="box-title">Chat</h3>
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
                                <div class="direct-chat-text" style="text-align: right;">
                                    {{$t->mensaje}}
                                    <a href="{{route('chat.delete',$t->id)}}" style="text-align: left !important"><i class="material-icons" style="font-size: 17px; color: red">delete</i></a>
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
                                    <a href="{{route('chat.delete',$t->id)}}" style="text-align: left !important"><i class="material-icons" style="font-size: 17px; color: red">delete</i></a>
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
                            <input type="hidden" name="contacto_id"  value="{{$contacto->id}}"/>
                            <input type="hidden" name="user2_id"  value="{{$contacto->user_id}}"/>
                            <input type="hidden" name="chat_id"  value="{{$chat->id}}"/>
                            <input type="hidden" name="user_id" id="res_id" value="{{Auth::user()->id}}"/>
                            <div class="input-group">
                                <div class="col-md-12" style="margin-top: 18px;">
                                    <div class="form-line">
                                        <input type="text" name="mensaje" placeholder="Mensaje ..." class="form-control">
                                    </div>
                                </div>
                                <span class="input-group-btn">
                                    <button type="submit" class="btn bg-teal btn-flat">Enviar</button>
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
@endsection
@section('script')
<script type="text/javascript">
    $(document).ready(function () {
    });
</script>
@endsection