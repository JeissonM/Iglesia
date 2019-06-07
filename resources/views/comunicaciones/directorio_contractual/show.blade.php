@extends('layouts.admin')
@section('breadcrumb')
<ol class="breadcrumb breadcrumb-bg-blue-grey" style="margin-bottom: 30px;">
    <li><a href="{{route('inicio')}}">Inicio</a></li>
    <li><a href="{{route('admin.comunicacion')}}">Comunicaciones</a></li>
    <li><a href="{{route('directoriocontractual.index')}}">Directorio Contractual</a></li>
    <li><a class="active">Ver Feligrés</a></li>
</ol>
@endsection
@section('content')
<div class="row clearfix">
    <div class="col-md-12">
        <div class="card">
            <div class="header">
                <h2>
                    DIRECTORIO CONTRACTUAL
                </h2>
            </div>
            <div class="body">
                <h1 class="card-inside-title">DATOS DEL FELIGRÉS SELECCIONADO</h1>
                <div class="row clearfix">
                    <div class="col-md-12">
                        <table class="table table-hover">
                            <tbody>
                                <tr class="read">
                                    <td class="contact"><b>Tipo de Identificación</b></td>
                                    <td class="contact"><b>Número de Identificación</b></td>
                                    <td class="contact"><b>Lugar de Expedición</b></td>
                                    <td class="contact"><b>Fecha de Expedición</b></td>
                                </tr>
                                <tr class="read">
                                    <td class="subject">{{$f->personanatural->persona->tipodocumento->descripcion}}</td>
                                    <td class="subject">{{$f->personanatural->persona->numero_documento}}</td>
                                    <td class="subject">{{$f->personanatural->persona->lugar_expedicion}}</td>
                                    <td class="subject">{{$f->personanatural->persona->fecha_expedicion}}</td>
                                </tr>
                                <tr class="read">
                                    <td class="contact"><b>Nombres</b></td>
                                    <td class="contact"><b>Apellidos</b></td>
                                    <td class="contact"><b>Sexo</b></td>
                                    <td class="contact"><b>Grupo Sanguíneo y Factor RH</b></td>
                                </tr>
                                <tr class="read">
                                    <td class="subject">{{$f->personanatural->primer_nombre." ".$f->personanatural->segundo_nombre}}</td>
                                    <td class="subject">{{$f->personanatural->primer_apellido." ".$f->personanatural->segundo_apellido}}</td>
                                    <td class="subject">{{$f->personanatural->sexo}}</td>
                                    <td class="subject">{{$f->personanatural->rh}}</td>
                                </tr>
                                <tr class="read">
                                    <td class="contact"><b>Otra Nacionalidad</b></td>
                                    <td class="contact"><b>Pasaporte</b></td>
                                    <td class="contact"><b>Lugar de Residencia</b></td>
                                    <td class="contact"><b>Dirección</b></td>
                                </tr>
                                <tr class="read">
                                    <td class="subject">{{$f->personanatural->otra_nacionalidad}}</td>
                                    <td class="subject">{{$f->personanatural->numero_pasaporte}}</td>
                                    <td class="subject">{{$f->personanatural->persona->ciudad->nombre." - ".$f->personanatural->persona->estado->nombre." - ".$f->personanatural->persona->pais->nombre}}</td>
                                    <td class="subject">{{$f->personanatural->persona->direccion}}</td>
                                </tr>
                                <tr class="read">
                                    <td class="contact"><b>Correo Electrónico</b></td>
                                    <td class="contact"><b>Teléfono Fijo</b></td>
                                    <td class="contact"><b>Teléfono Celular</b></td>
                                    <td class="contact"><b>Padre</b></td>
                                </tr>
                                <tr class="read">
                                    <td class="subject">{{$f->personanatural->persona->mail}}</td>
                                    <td class="subject">{{$f->personanatural->persona->telefono}}</td>
                                    <td class="subject">{{$f->personanatural->persona->celular}}</td>
                                    <td class="subject">{{$f->personanatural->padre}}</td>
                                </tr>
                                <tr class="read">
                                    <td class="contact"><b>Profesión</b></td>
                                    <td class="contact"><b>Ocupación</b></td>
                                    <td class="contact"><b>Nivel Estudio</b></td>
                                    <td class="contact"><b>Último Grado Cursado</b></td>
                                </tr>
                                <tr class="read">
                                    <td class="subject">{{$f->personanatural->profesion}}</td>
                                    <td class="subject">{{$f->personanatural->ocupacion}}</td>
                                    <td class="subject">{{$f->personanatural->nivel_estudio}}</td>
                                    <td class="subject">{{$f->personanatural->ultimo_grado}}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <h1 class="card-inside-title">EXPERIENCIA PROFESIONAL</h1>
                <div class="row clearfix">
                    <div class="col-md-12">
                        <table class="table table-hover">
                            <tbody>
                                <tr class="read">
                                    <td class="contact"><b>Labor</b></td>
                                    <td class="contact"><b>Fecha de Inicio</b></td>
                                    <td class="contact"><b>Fecha Fin</b></td>
                                </tr>
                                @foreach($experiencia as $e)
                                <tr class="read">
                                    <td class="subject">{{$e->labor->nombre}}</td>
                                    <td class="subject">{{$e->fechainicio}}</td>
                                    <td class="subject">{{$e->fechafin}}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <h1 class="card-inside-title">EXPERIENCIA EMPÍRICA</h1>
                <div class="row clearfix">
                    <div class="col-md-12">
                        <table class="table table-hover">
                            <tbody>
                                <tr class="read">
                                    <td class="contact"><b>Conocimiento</b></td>
                                    <td class="contact"><b>Descripción</b></td>
                                </tr>
                                @foreach($conocimientos as $e)
                                <tr class="read">
                                    <td class="subject">{{$e->nombre}}</td>
                                    <td class="subject">{{$e->descripcion}}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection