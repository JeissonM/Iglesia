@extends('layouts.admin')
@section('breadcrumb')
<ol class="breadcrumb breadcrumb-bg-blue-grey" style="margin-bottom: 30px;">
    <li><a href="{{route('inicio')}}">Inicio</a></li>
    <li><a href="{{route('admin.comunicacion')}}">Comunicaciones</a></li>
    <li class="active"><a href="{{route('iglesiamapa.index')}}">Encuentre una Iglesia - Gestión</a></li>
    <li class="active"><a>Ver Mapa</a></li>
</ol>
@endsection
@section('content')
<div class="row clearfix">
    <div class="col-md-12">
        <div class="card">
            <div class="header">
                <h2>
                    ENCUENTRE UNA IGLESIA - GESTIÓN
                </h2>
            </div>
            <div class="body">
                <div class="col-md-12">
                    @component('layouts.errors')
                    @endcomponent
                </div>
                <h1 class="card-inside-title">DATOS DEL MAPA</h1>
                <div class="row clearfix">
                    <div class="col-md-12">
                        <table class="table table-hover">
                            <tbody>
                                <tr class="read">
                                    <td class="contact"><b>Iglesia</b></td>
                                    <td class="contact"><b>Distrito</b></td>
                                    <td class="contact"><b>Asociación</b></td>
                                    <td class="contact"><b>Ciudad</b></td>
                                </tr>
                                <tr class="read">
                                    <td class="subject">{{$mapa->iglesia->nombre}}</td>
                                    <td class="subject">{{$mapa->iglesia->distrito->nombre}}</td>
                                    <td class="subject">{{$mapa->iglesia->distrito->asociacion->nombre}}</td>
                                    <td class="subject">{{$mapa->iglesia->ciudad->nombre}}</td>
                                </tr>
                                <tr class="read">
                                    <td class="contact"><b>Dirección</b></td>
                                    <td class="contact"><b>Teléfono</b></td>
                                    <td class="contact"><b>Correo</b></td>
                                    <td class="contact"><b>Sitio Web</b></td>
                                </tr>
                                <tr class="read">
                                    <td class="subject">{{$mapa->iglesia->ubicacion}}</td>
                                    <td class="subject">{{$mapa->telefonocontacto}}</td>
                                    <td class="subject">{{$mapa->iglesia->email}}</td>
                                    <td class="subject">{{$mapa->iglesia->sitioweb}}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="col-md-12">
                        <h4>Ubicación en el mapa</h4>
                        {!!$mapa->mapa!!}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('script')
<script>
    $('.select2').select2();
</script>
@endsection