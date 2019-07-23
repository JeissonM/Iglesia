@extends('layouts.admin')
@section('breadcrumb')
<ol class="breadcrumb breadcrumb-bg-blue-grey" style="margin-bottom: 30px;">
    <li><a href="{{route('inicio')}}">Inicio</a></li>
    <li><a href="{{route('admin.feligresia')}}">Feligresía</a></li>
    <li><a href="{{route('admin.feligresia')}}">Estructura Eclesiástica</a></li>
    <li><a href="{{route('iglesia.index')}}">Iglesias</a></li>
    <li class="active"><a>Ver Iglesia</a></li>
</ol>
@endsection
@section('content')
<div class="row clearfix">
    <div class="col-md-12">
        <div class="card">
            <div class="header">
                <h2>
                    GESTIÓN DE LAS IGLESIAS - VER UNA IGLESIA
                </h2>
            </div>
            <div class="body">
                <div class="col-md-12">
                    @component('layouts.errors')
                    @endcomponent
                </div>
                <h1 class="card-inside-title">DATOS DE LA IGLESIA SELECCIONADA</h1>
                <div class="row clearfix">
                    <div class="col-md-12">
                        <table class="table table-hover">
                            <tbody>
                                <tr class="read">
                                    <td class="contact"><b>Id de la Iglesia</b></td>
                                    <td class="subject">{{$iglesia->id}}</td>
                                </tr>
                                <tr class="read">
                                    <td class="contact"><b>Nombre</b></td>
                                    <td class="subject">{{$iglesia->nombre}}</td>
                                </tr>
                                <tr class="read">
                                    <td class="contact"><b>Descripción</b></td>
                                    <td class="subject">{{$iglesia->descripcion}}</td>
                                </tr>
                                <tr class="read">
                                    <td class="contact"><b>Dirección de Ubicación</b></td>
                                    <td class="subject">{{$iglesia->ubicacion}}</td>
                                </tr>
                                <tr class="read">
                                    <td class="contact"><b>Correo Electrónico</b></td>
                                    <td class="subject">{{$iglesia->email}}</td>
                                </tr>
                                <tr class="read">
                                    <td class="contact"><b>Fecha de Fundación</b></td>
                                    <td class="subject">{{$iglesia->fundacion}}</td>
                                </tr>
                                <tr class="read">
                                    <td class="contact"><b>Estado Actual de la Iglesia</b></td>
                                    <td class="subject">
                                        @if($iglesia->activa=='1')
                                        <label class="label label-success">ACTIVA</label>
                                        @else
                                        <label class="label label-danger">INACTIVA</label>
                                        @endif
                                    </td>
                                </tr>
                                <tr class="read">
                                    <td class="contact"><b>Sitio Web</b></td>
                                    <td class="subject">{{$iglesia->sitioweb}}</td>
                                </tr>
                                <tr class="read">
                                    <td class="contact"><b>Tipo de Congregación</b></td>
                                    <td class="subject">{{$iglesia->tipo}}</td>
                                </tr>
                                <tr class="read">
                                    <td class="contact"><b>Ciudad de Ubicación</b></td>
                                    <td class="subject">{{$iglesia->ciudad->nombre}}</td>
                                </tr>
                                <tr class="read">
                                    <td class="contact"><b>Distrito</b></td>
                                    <td class="subject">{{$iglesia->distrito->nombre}}</td>
                                </tr>
                                <tr class="read">
                                    <td class="contact"><b>Zona</b></td>
                                    <td class="subject">@if($iglesia->zona!=null){{$iglesia->zona->nombre}}@endif</td>
                                </tr>
                                <tr class="read">
                                    <td class="contact"><b>Creado</b></td>
                                    <td class="subject">{{$iglesia->created_at}}</td>
                                </tr>
                                <tr class="read">
                                    <td class="contact"><b>Modificado</b></td>
                                    <td class="subject">{{$iglesia->updated_at}}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection