@extends('layouts.admin')
@section('breadcrumb')
<ol class="breadcrumb breadcrumb-bg-blue-grey" style="margin-bottom: 30px;">
    <li><a href="{{route('inicio')}}">Inicio</a></li>
    <li><a href="{{route('admin.feligresia')}}">Feligresía</a></li>
    <li><a href="{{route('admin.feligresia')}}">Feligresía</a></li>
    <li><a href="{{route('solicitud.index')}}">Traslados</a></li>
    <li class="active"><a>Ver Solicitud</a></li>
</ol>
@endsection
@section('content')
<div class="row clearfix">
    <div class="col-md-12">
        <div class="card">
            <div class="header">
                <h2>
                    TRASLADO - VER SOLICITUD<small>Haga clic en el botón de 3 puntos de la derecha de este título para obtener ayuda.</small>
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
                <div class="col-md-12">
                    @component('layouts.errors')
                    @endcomponent
                </div>
                <!--                <h1 class="card-inside-title">ESTUDIAR SOLICITUD DE TRASLADO: {{$f->personanatural->primer_nombre." ".$f->personanatural->primer_apellido}}</h1>-->
                <div class="row clearfix">
                    <div class="col-md-12">
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
                        <h3 class="card-inside-title">DATOS DE LA SOLICITUD</h3>
                        <div class="row clearfix">
                            <div class="col-md-12">
                                <table class="table table-hover">
                                    <tbody>
                                        <tr class="read">
                                            <td class="contact"><b>Estado</b></td>
                                            <td class="contact"><b>Distrito Origen</b></td>
                                            <td class="contact"><b>Iglesia Origen</b></td>
                                            <td class="contact"><b>Observación Origen</b></td>
                                            <td class="contact"><b>Acta Origen</b></td>
                                        </tr>
                                        <tr class="read">
                                            <td class="subject">{{$solicitud->estado}}</td>
                                            <td class="subject">{{$iglesiaorigen->distrito->nombre}}</td>
                                            <td class="subject">{{$iglesiaorigen->nombre}}</td>
                                            <td class="subject">{{$solicitud->observacion_origen}}</td>
                                            @if($solicitud->ao == 'NO')
                                            <td>Sin Acta</td>
                                            @else
                                            <td><a target="_blank" href="{{asset('docs/actas/'.$solicitud->ao)}}">{{$solicitud->ao}}</a></td>
                                            @endif
                                        </tr>
                                        <tr class="read">
                                            <td class="contact"><b>Distrito Destino</b></td>
                                            <td class="contact"><b>Iglesia Destino</b></td>
                                            <td class="contact"><b>Observación Destino</b></td>
                                            <td class="contact"><b>Acta Destino</b></td>
                                            <td class="contact"><b>Fecha de la solicitud</b></td>
                                        </tr>
                                        <tr class="read">
                                            <td class="subject">{{$iglesiadestino->distrito->nombre}}</td>
                                            <td class="subject">{{$iglesiadestino->nombre}}</td>
                                            <td class="subject">{{$solicitud->observacion_destino}}</td>
                                            @if($solicitud->ad == 'NO')
                                            <td>Sin Acta</td>
                                            @else
                                            <td><a target="_blank" href="{{asset('docs/actas/'.$solicitud->ad)}}">{{$solicitud->ad}}</a></td>
                                            @endif
                                            <td class="subject">{{$solicitud->fechasolicitud}}</td>
                                        </tr>
                                    </tbody>  
                                </table>
                            </div>
                        </div>
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
                <h4 class="modal-title" id="defaultModalLabel">SOBRE LOS TRASLADOS</h4>
            </div>
            <div class="modal-body">
                <strong>Finalice, </strong> las solicitudes de traslados que usted ha realizado.
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-link waves-effect" data-dismiss="modal">ACEPTAR</button>
            </div>
        </div>
    </div>
</div>
@endsection
@section('script')
<script>

    function getActas(name, iglesia, acta) {
        var id = $("#" + name).val();
        var igl = $("#" + iglesia).val();
        $.ajax({
            type: 'GET',
            url: url + "feligresia/solicitud/" + id + "/" + igl + "/getactas",
            data: {},
        }).done(function (msg) {
            $('#' + acta + ' option').each(function () {
                $(this).remove();
            });
            if (msg !== "null") {
                var m = JSON.parse(msg);
                $("#" + acta).append("<option value=''>-- Seleccione una opción --</option>");
                $.each(m, function (index, item) {
                    $("#" + acta).append("<option value='" + item.id + "'>" + item.value + "</option>");
                });
            } else {
                notify('Atención', 'El periodo seleccionado no posee información de actas de juntas.', 'error');
            }
        });
    }
</script>
@endsection
