@extends('layouts.admin')
@section('breadcrumb')
<ol class="breadcrumb breadcrumb-bg-blue-grey" style="margin-bottom: 30px;">
    <li><a href="{{route('inicio')}}">Inicio</a></li>
    <li><a href="{{route('admin.feligresia')}}">Feligresía</a></li>
    <li><a href="{{route('admin.feligresia')}}">Feligresía</a></li>
    <li><a href="{{route('feligres.index')}}">Miembros de Iglesia</a></li>
    <li class="active"><a>Ver Feligrés</a></li>
</ol>
@endsection
@section('content')
<div class="row clearfix">
    <div class="col-md-12">
        <div class="card">
            <div class="header">
                <h2>
                    MIEMBROS DE IGLESIA - VER FELIGRÉS
                </h2>
            </div>
            <div class="body">
                <div class="col-md-12">
                    @component('layouts.errors')
                    @endcomponent
                </div>
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
                                    <td class="contact"><b>Estado Civil</b></td>
                                    <td class="contact"><b>Edad</b></td>
                                    <td class="contact"><b>Fecha de Nacimiento</b></td>
                                    <td class="contact"><b>Lugar de Nacimiento</b></td>
                                </tr>
                                <tr class="read">
                                    <td class="subject">{{$f->personanatural->estadocivil->descripcion}}</td>
                                    <td class="subject">{{$f->personanatural->edad}}</td>
                                    <td class="subject">{{$f->personanatural->fecha_nacimiento}}</td>
                                    <td class="subject">{{$f->personanatural->ciudad->nombre." - ".$f->personanatural->estado->nombre." - ".$f->personanatural->pais->nombre}}</td>
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
                                    <td class="contact"><b>Madre</b></td>
                                    <td class="contact"><b>Clase Libreta Militar</b></td>
                                    <td class="contact"><b>Número</b></td>
                                    <td class="contact"><b>Distrito</b></td>
                                </tr>
                                <tr class="read">
                                    <td class="subject">{{$f->personanatural->madre}}</td>
                                    <td class="subject">{{$f->personanatural->clase_libreta}}</td>
                                    <td class="subject">{{$f->personanatural->libreta_militar}}</td>
                                    <td class="subject">{{$f->personanatural->distrito_militar}}</td>
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
                                <tr class="read">
                                    <td class="contact"><b>Religión Anterior</b></td>
                                    <td class="contact"><b>Pastor Oficiante</b></td>
                                    <td class="contact"><b>Estado Actual</b></td>
                                    <td class="contact"><b>Fecha de Bautismo</b></td>
                                </tr>
                                <tr class="read">
                                    <td class="subject">{{$f->personanatural->religion_anterior}}</td>
                                    <td class="subject">{{$f->pastor_oficiante}}</td>
                                    <td class="subject">{{$f->estado_actual}}</td>
                                    <td class="subject">{{$f->fecha_bautismo}}</td>
                                </tr>
                                <tr class="read">
                                    <td class="contact"><b>Aceptado Por</b></td>
                                    <td class="contact"><b>Procedencia</b></td>
                                    <td class="contact"><b>Aceptado En</b></td>
                                    <td class="contact"><b>Creado</b></td>
                                </tr>
                                <tr class="read">
                                    <td class="subject">{{$f->aceptado_por}}</td>
                                    <td class="subject">{{$io->nombre." - ".$io->distrito->nombre." - ".$io->distrito->asociacion->nombre}}</td>
                                    <td class="subject">{{$id->nombre." - ".$id->distrito->nombre." - ".$id->distrito->asociacion->nombre}}</td>
                                    <td class="subject">{{$f->created_at}}</td>
                                </tr>
                                <tr class="read">
                                    <td class="contact"><b>Modificado</b></td>
                                    <td class="contact"><b>Id Persona General</b></td>
                                    <td class="contact"><b>Id Persona Natural</b></td>
                                    <td class="contact"><b>Id Feligrés</b></td>
                                </tr>
                                <tr class="read">
                                    <td class="subject">{{$f->updated_at}}</td>
                                    <td class="subject">{{$f->personanatural->persona->id}}</td>
                                    <td class="subject">{{$f->personanatural->id}}</td>
                                    <td class="subject">{{$f->id}}</td>
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