@extends('layouts.admin')
@section('breadcrumb')
<ol class="breadcrumb breadcrumb-bg-blue-grey" style="margin-bottom: 30px;">
    <li><a href="{{route('inicio')}}">Inicio</a></li>
    <li><a href="{{route('admin.feligresia')}}">Feligresía</a></li>
    <li><a href="{{route('admin.feligresia')}}">Feligresía</a></li>
    <li><a href="{{route('pastor.index')}}">Pastores</a></li>
    <li class="active"><a>Ver Pastor</a></li>
</ol>
@endsection
@section('content')
<div class="row clearfix">
    <div class="col-md-12">
        <div class="card">
            <div class="header">
                <h2>
                    GESTIÓN DE LOS PASTORES - VER UN PASTOR
                </h2>
            </div>
            <div class="body">
                <div class="col-md-12">
                    @component('layouts.errors')
                    @endcomponent
                </div>
                <h1 class="card-inside-title">DATOS DEL PASTOR SELECCIONADO</h1>
                <div class="row clearfix">
                    <div class="col-md-12">
                        <table class="table table-hover">
                            <tbody>
                                <tr class="read">
                                    <td class="contact"><b>Tipo y Número de Documento</b></td>
                                    <td class="subject">{{$pastor->personanatural->persona->tipodocumento->abreviatura." - ".$pastor->personanatural->persona->numero_documento}}</td>
                                </tr>
                                <tr class="read">
                                    <td class="contact"><b>Nombre</b></td>
                                    <td class="subject">{{$pastor->personanatural->primer_apellido." ".$pastor->personanatural->segundo_apellido." ".$pastor->personanatural->primer_nombre." ".$pastor->personanatural->segundo_nombre}}</td>
                                </tr>
                                <tr class="read">
                                    <td class="contact"><b>Estado Civil</b></td>
                                    <td class="subject">{{$pastor->personanatural->estadocivil->descripcion}}</td>
                                </tr>
                                <tr class="read">
                                    <td class="contact"><b>Jubilado</b></td>
                                    <td class="subject">{{$pastor->jubilado}}</td>
                                </tr>
                                <tr class="read">
                                    <td class="contact"><b>Fecha de Jubilación</b></td>
                                    <td class="subject">{{$pastor->fecha_jubilacion}}</td>
                                </tr>
                                <tr class="read">
                                    <td class="contact"><b>Fecha de Ordenamiento</b></td>
                                    <td class="subject">{{$pastor->pastor_desde}}</td>
                                </tr>
                                <tr class="read">
                                    <td class="contact"><b>Situación</b></td>
                                    <td class="subject">{{$pastor->situacion}}</td>
                                </tr>
                                <tr class="read">
                                    <td class="contact"><b>Zonas o Distritos a Cargo</b></td>
                                    <td class="subject">{{$pastor->pastor_sobre}}</td>
                                </tr>
                                <tr class="read">
                                    <td class="contact"><b>Distrito</b></td>
                                    <td class="subject">{{$pastor->distrito->nombre}}</td>
                                </tr>
                                <tr class="read">
                                    <td class="contact"><b>Iglesia</b></td>
                                    <td class="subject">{{$pastor->iglesia->nombre}}</td>
                                </tr>
                                <tr class="read">
                                    <td class="contact"><b>Creado</b></td>
                                    <td class="subject">{{$pastor->created_at}}</td>
                                </tr>
                                <tr class="read">
                                    <td class="contact"><b>Modificado</b></td>
                                    <td class="subject">{{$pastor->updated_at}}</td>
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