@extends('layouts.admin')
@section('breadcrumb')
<ol class="breadcrumb breadcrumb-bg-blue-grey" style="margin-bottom: 30px;">
    <li><a href="{{route('inicio')}}">Inicio</a></li>
    <li><a href="{{route('admin.gestiondocumental')}}">Gestión Documental</a></li>
    <li class="active"><a>Multimedia Ministerial</a></li>
</ol>
@endsection
@section('content')
<div class="row clearfix">
    <div class="col-md-12">
        <div class="card">
            <div class="header">
                <h2>
                    MULTIMEDIA MINISTERIAL 
                </h2>
            </div>
            <div class="body">
                <div class="row">
                    @foreach($ms as $m)
                    <div class="col-sm-6 col-md-3">
                        <div class="thumbnail">
                            <img src="{{asset('img/banner01.jpg')}}">
                            <div class="caption">
                                <h3>{{$m->nombre}}</h3>
                                <p>{{$m->descripcion}}</p>
                                <p><b>TIPO:</b> {{$m->tipoministerio->nombre}}</p>
                                <p>
                                    <a href="{{route('multimediaministerial.visualizacionver',$m->id)}}" class="btn btn-primary waves-effect" role="button">CONTINUAR</a>
                                </p>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
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