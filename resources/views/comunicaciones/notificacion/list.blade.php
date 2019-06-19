@extends('layouts.admin')
@section('breadcrumb')
<ol class="breadcrumb breadcrumb-bg-blue-grey" style="margin-bottom: 30px;">
    <li><a href="{{route('inicio')}}">Inicio</a></li>
    <li><a href="{{route('admin.comunicacion')}}">Comunicaciones</a></li>
    <li class="active"><a>Notificaciones</a></li>
</ol>
@endsection
@section('content')
<div class="row clearfix">
    <div class="col-md-12">
        <div class="card">
            <div class="header">
                <h2>
                    NOTIFICACIONES
                </h2>
            </div>
            <div class="body">
                <ul class="list-group">
                    @if(session()->get('total')>0)
                    @foreach(session()->get('notificaciones') as $n)
                    <li class="list-group-item">
                        <a onclick="changeState(this.id)" id="{{$n->id}}" href="{{$n->action}}">
                            <div class="menu-info">
                                <h4><i class="material-icons">{{$n->icono}}</i> {{$n->titulo}} <i class="material-icons">access_time</i> {{$n->fecha}}</h4>
                            </div>
                        </a>
                    </li>
                    @endforeach
                    @endif
                </ul>
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