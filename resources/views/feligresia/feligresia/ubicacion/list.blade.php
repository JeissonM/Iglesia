@extends('layouts.admin')
@section('breadcrumb')
<ol class="breadcrumb breadcrumb-bg-blue-grey" style="margin-bottom: 30px;">
    <li><a href="{{route('inicio')}}">Inicio</a></li>
    <li><a href="{{route('admin.feligresia')}}">Feligresía</a></li>
    <li><a href="{{route('admin.feligresia')}}">Feligresía</a></li>
    <li class="active"><a>Seguimiento de Ubicación</a></li>
</ol>
@endsection
@section('content')
<div class="row clearfix">
    <div class="col-md-12">
        <div class="card">
            <div class="header">
                <h2>
                    SEGUIMIENTO DE UBICACIÓN DEL FELIGRÉS<small>Haga clic en el botón de 3 puntos de la derecha de este título para agregar un nuevo registro.</small>
                </h2>
                <ul class="header-dropdown m-r--5">
                    <li class="dropdown">
                        <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                            <i class="material-icons">more_vert</i>
                        </a>
                        <ul class="dropdown-menu pull-right">
                            <li><a data-toggle="modal" data-target="#mdModal">Ayuda</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
            <div class="body">
                <h3 class="card-inside-title">DATOS DEL FELIGRES</h3>
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
                <h3 class="card-inside-title">UBICACIÓN Y SITUACIÓN ACTUAL</h3>
                <div class="row clearfix">
                    <div class="col-md-12">
                        <table class="table table-hover">
                            <tbody>
                                <tr class="read">
                                    <td class="contact"><b>Ciudad</b></td>
                                    <td class="contact"><b>Iglesia</b></td>
                                    <td class="contact"><b>Estado</b></td>
                                    <td class="contact"><b>Situación</b></td>
                                </tr>
                                <tr class="read">
                                    <td class="subject">{{$f->iglesia->ciudad->nombre}}</td>
                                    <td class="subject">{{$f->iglesia->nombre}}</td>
                                    <td class="subject">{{$f->estado_actual}}</td>
                                    <td class="subject">{{$f->situacionfeligres->nombre}}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <h3 class="card-inside-title">HISTORIAL DE TRASLADOS</h3>
                <div class="row clearfix">
                    <div class="col-md-12">
                        <table class="table table-hover">
                            <tbody>
                                <tr class="read">
                                    <td class="contact"><b>Fecha</b></td>
                                    <td class="contact"><b>Iglesia Origen</b></td>
                                    <td class="contact"><b>Iglesia Destino</b></td>
                                    <td class="contact"><b>Estado</b></td>
                                    <td class="contact"><b>Observaciones</b></td>
                                </tr>
                                @if(count($tras)>0)
                                @foreach($tras as $t)
                                <tr class="read">
                                    <td class="subject">{{$t->fechasolicitud}}</td>
                                    <td class="subject">{{$t->origen->nombre." - ".$t->origen->ciudad->nombre}}</td>
                                    <td class="subject">{{$t->destino->nombre." - ".$t->destino->ciudad->nombre}}</td>
                                    <td class="subject">{{$t->estado}}</td>
                                    <td class="subject">
                                        OBSERVACIÓN ORIGEN: {{$t->observacion_origen}} <br>
                                        OBSERVACIÓN DESTINO: {{$t->observacion_destino}}
                                    </td>
                                </tr>
                                @endforeach
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Modal -->
<div class="modal fade" id="mdModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content modal-col-orange">
            <div class="modal-header">
                <h4 class="modal-title" id="defaultModalLabel">SOBRE EL SEGUIMIENTO DE UBICACIÓN DE UN FELIGRÉS</h4>
            </div>
            <div class="modal-body">
                <strong>Detalles: </strong>Éste módulo permite realizar un seguimiento del estado, situación y recorrido de un feligrés a través de su historia en la iglesia.
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-link waves-effect" data-dismiss="modal">ACEPTAR</button>
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