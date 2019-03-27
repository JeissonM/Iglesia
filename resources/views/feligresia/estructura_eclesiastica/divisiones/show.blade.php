@extends('layouts.admin')
@section('breadcrumb')
<ol class="breadcrumb breadcrumb-bg-blue-grey" style="margin-bottom: 30px;">
    <li><a href="{{route('inicio')}}">Inicio</a></li>
    <li><a href="{{route('admin.feligresia')}}">Feligresía</a></li>
    <li><a href="{{route('admin.feligresia')}}">Estructura Eclesiástica</a></li>
    <li><a href="{{route('division.index')}}">Divisiones</a></li>
    <li class="active"><a>Ver División</a></li>
</ol>
@endsection
@section('content')
<div class="row clearfix">
    <div class="col-md-12">
        <div class="card">
            <div class="header">
                <h2>
                    GESTIÓN DE LAS DIVISIONES - DATOS DE UNA DIVISIÓN
                </h2>
            </div>
            <div class="body">
                <div class="col-md-12">
                    @component('layouts.errors')
                    @endcomponent
                </div>
                <h1 class="card-inside-title">DATOS DE LA DIVISIÓN SELECCIONADA</h1>
                <div class="row clearfix">
                    <div class="col-md-12">
                        <table class="table table-hover">
                            <tbody>
                                <tr class="read">
                                    <td class="contact"><b>Id de la División</b></td>
                                    <td class="subject">{{$division->id}}</td>
                                </tr>
                                <tr class="read">
                                    <td class="contact"><b>Nombre</b></td>
                                    <td class="subject">{{$division->nombre}}</td>
                                </tr>
                                <tr class="read">
                                    <td class="contact"><b>Descripción</b></td>
                                    <td class="subject">{{$division->descripcion}}</td>
                                </tr>
                                <tr class="read">
                                    <td class="contact"><b>Ubicación</b></td>
                                    <td class="subject">{{$division->ubicacion}}</td>
                                </tr>
                                <tr class="read">
                                    <td class="contact"><b>Correo Electrónico</b></td>
                                    <td class="subject">{{$division->email}}</td>
                                </tr>
                                <tr class="read">
                                    <td class="contact"><b>Sitio Web</b></td>
                                    <td class="subject">{{$division->sitioweb}}</td>
                                </tr>
                                <tr class="read">
                                    <td class="contact"><b>Ciudad</b></td>
                                    <td class="subject">{{$division->ciudad->nombre}}</td>
                                </tr>
                                <tr class="read">
                                    <td class="contact"><b>Creado</b></td>
                                    <td class="subject">{{$division->created_at}}</td>
                                </tr>
                                <tr class="read">
                                    <td class="contact"><b>Modificado</b></td>
                                    <td class="subject">{{$division->updated_at}}</td>
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