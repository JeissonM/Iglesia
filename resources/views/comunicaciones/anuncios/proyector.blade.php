@extends('layouts.admin')
@section('breadcrumb')
<ol class="breadcrumb breadcrumb-bg-blue-grey" style="margin-bottom: 30px;">
    <li><a href="{{route('inicio')}}">Inicio</a></li>
    <li><a href="{{route('admin.comunicacion')}}">Comunicaciones</a></li>
    <li class="active"><a>Ver Anuncios</a></li>
</ol>
@endsection
@section('content')
<div class="row clearfix">
    <div class="col-md-12">
        <div class="card">
            <div class="header">
                <h2>
                    ANUNCIOS - VER ANUNCIOS
                </h2>
            </div>
            <div class="body">
                <div class="row" id="imprimir">
                    <div class="col-md-12">
                        <h3 style="text-align: center">IGLESIA ADVENTISTA DEL SÉPTIMO DÍA<br>DISTRITO: {{$f->iglesia->distrito->nombre}}<br>IGLESIA: {{$f->iglesia->nombre}}</h3>
                        <?php $i = 1; ?>
                        <h1 class="card-inside-title">ANUNCIOS LOCALES</h1>
                        @if($anuncios['LOCAL']!=null)
                        <div class="list-group">
                            @foreach($anuncios['LOCAL'] as $a)
                            <button type="button" class="list-group-item">
                                <b>{{$i.". ".$a->titulo}}</b><br>{!!$a->contenido!!}<br><b>AUTOR:{{$a->autor}}</b>
                                @if($a->imagen!='NO')
                                <br>
                                <div class="col-xs-12 col-md-6">
                                    <a href="javascript:void(0);" class="thumbnail">
                                        <img src="{{asset('docs/anuncios/'.$a->imagen)}}" class="img-responsive">
                                    </a>
                                </div>
                                @endif
                            </button>
                            <?php $i = $i + 1; ?>
                            @endforeach
                        </div>
                        @else
                        <label class="label label-danger">No hay anuncios para la sección!</label>
                        @endif
                        <h1 class="card-inside-title">ANUNCIOS DISTRITALES</h1>
                        @if($anuncios['DISTRITO']!=null)
                        <div class="list-group">
                            @foreach($anuncios['DISTRITO'] as $a)
                            <button type="button" class="list-group-item">
                                <b>{{$i.". ".$a->titulo}}</b><br>{!!$a->contenido!!}<br><b>AUTOR:{{$a->autor}}</b>
                                @if($a->imagen!='NO')
                                <br>
                                <div class="col-xs-12 col-md-6">
                                    <a href="javascript:void(0);" class="thumbnail">
                                        <img src="{{asset('docs/anuncios/'.$a->imagen)}}" class="img-responsive">
                                    </a>
                                </div>
                                @endif
                            </button>
                            <?php $i = $i + 1; ?>
                            @endforeach
                        </div>
                        @else
                        <label class="label label-danger">No hay anuncios para la sección!</label>
                        @endif
                        <h1 class="card-inside-title">ANUNCIOS GENERALES</h1>
                        @if($anuncios['ASOCIACION']!=null)
                        <div class="list-group">
                            @foreach($anuncios['ASOCIACION'] as $a)
                            <button type="button" class="list-group-item">
                                <b>{{$i.". ".$a->titulo}}</b><br>{!!$a->contenido!!}<br><b>ASOCIACIÓN:{{$a->asociacion->nombre}}</b><br><b>AUTOR:{{$a->autor}}</b>
                                @if($a->imagen!='NO')
                                <br>
                                <div class="col-xs-12 col-md-6">
                                    <a href="javascript:void(0);" class="thumbnail">
                                        <img src="{{asset('docs/anuncios/'.$a->imagen)}}" class="img-responsive">
                                    </a>
                                </div>
                                @endif
                            </button>
                            <?php $i = $i + 1; ?>
                            @endforeach
                        </div>
                        @else
                        <label class="label label-danger">No hay anuncios para la sección!</label>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('script')
<script>
    $(".chosen-select").chosen({});

    function imprSelec(div) {
        var ficha = document.getElementById(div);
        var ventimp = window.open(' ', 'anuncios');
        ventimp.document.write(ficha.innerHTML);
        ventimp.document.close();
        ventimp.print();
        ventimp.close();
    }
</script>
@endsection