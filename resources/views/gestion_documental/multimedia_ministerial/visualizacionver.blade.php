@extends('layouts.admin')
@section('breadcrumb')
<ol class="breadcrumb breadcrumb-bg-blue-grey" style="margin-bottom: 30px;">
    <li><a href="{{route('inicio')}}">Inicio</a></li>
    <li><a href="{{route('admin.gestiondocumental')}}">Gestión Documental</a></li>
    <li><a href="{{route('multimediaministerial.visualizacionindex')}}">Multimedia Ministerial</a></li>
    <li class="active"><a>Detalles</a></li>
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
                <h1 class="card-inside-title">DATOS DEL MINISTERIO</h1>
                <div class="col-md-12">
                    <table class="table table-hover">
                        <tbody>
                            <tr class="read">
                                <td class="contact"><b>MINISTERIO</b></td>
                                <td class="contact"><b>TIPO MINISTERIO</b></td>
                            </tr>
                            <tr class="read">
                                <td class="contact">{{$m->nombre}}</td>
                                <td class="subject">{{$m->tipoministerio->nombre}}</td>
                            </tr>
                            <tr class="read">
                                <td class="contact"><b>DESCRIPCIÓN</b></td>
                                <td class="contact"><b>CREACIÓN</b></td>
                            </tr>
                            <tr class="read">
                                <td class="contact">{{$m->descripcion}}</td>
                                <td class="subject">{{$m->created_at}}</td>
                            </tr>
                        </tbody>
                    </table>
                </div> 
                <h1 class="card-inside-title">PRESENTACIÓN</h1>
                <div class="col-md-12">
                    {!!$m->presentacion!!}
                </div>
                <h1 class="card-inside-title">LISTADO DE RECURSOS DEL MINISTERIO</h1>
                <div class="clearfix m-b-20">
                    <div class="dd">
                        <ol class="dd-list">
                            @if(count($m->multimediaministerials)>0)
                            @foreach($m->multimediaministerials as $r)
                            <li class="dd-item" data-id="{{$r->id}}">
                                <div class="dd-handle">{{$r->nombre." - ".$r->descripcion}}</div>
                                @if(count($r->multimediaministerialitems)>0)
                                <ol class="dd-list">
                                    @foreach($r->multimediaministerialitems as $i)
                                    <li class="dd-item" data-id="3">
                                        <div class="dd-handle">
                                            <a href="{{asset('docs/multimedia/'.$i->recurso)}}" target="_blank">{{$i->recurso}}</a>
                                        </div>
                                    </li>
                                    @endforeach
                                </ol>
                                @endif
                            </li>
                            @endforeach
                            @endif
                        </ol>
                    </div>
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