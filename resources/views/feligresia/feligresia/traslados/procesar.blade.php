@extends('layouts.admin')
@section('breadcrumb')
<ol class="breadcrumb breadcrumb-bg-blue-grey" style="margin-bottom: 30px;">
    <li><a href="{{route('inicio')}}">Inicio</a></li>
    <li><a href="{{route('admin.feligresia')}}">Feligresía</a></li>
    <li><a href="{{route('admin.feligresia')}}">Feligresía</a></li>
    <li><a href="{{route('solicitud.index')}}">Traslados</a></li>
    <li class="active"><a>Procesar Solicitud</a></li>
</ol>
@endsection
@section('content')
<div class="row clearfix">
    <div class="col-md-12">
        <div class="card">
            <div class="header">
                <h2>
                    TRASLADO - PROCESAR SOLICITUD<small>Haga clic en el botón de 3 puntos de la derecha de este título para obtener ayuda.</small>
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
                        <h3 class="card-inside-title">DATOS DEL FELIGRÉS SELECCIONADO</h3>
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
                        <h3 class="card-inside-title">CARGOS DESEMPEÑADOS</h3>
                        <div class="row clearfix">
                            <div class="col-md-12">
                                <table class="table table-hover">
                                    <thead>
                                        <tr class="read">
                                            <td class="contact"><b>Cargo</b></td>
                                            <td class="contact"><b>Ministerio</b></td>
                                            <td class="contact"><b>Iglesia</b></td>
                                            <td class="contact"><b>Periodo</b></td>
                                            <td class="contact"><b>Junta</b></td>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($miembrojunta as $m)
                                        <tr class="read">
                                            <td class="subject">{{$m->cargogeneral->nombre}}</td>
                                            <td class="subject">{{$m->junta->cargogeneral->ministerio->nombre}}</td>
                                            <td class="subject">{{$m->junta->iglesia->nombre}}</td>
                                            <td class="subject">{{$m->periodo->etiqueta}}</td>
                                            <td class="subject">{{$m->junta->etiqueta}}</td>
                                        </tr>
                                        @endforeach
                                    </tbody>  
                                </table>
                            </div>
                        </div>
                        <h3 class="card-inside-title">HISTORIAL DE SOLICITUDES</h3>
                        <div class="row clearfix">
                            <div class="col-md-12">
                                <table class="table table-hover">
                                    <thead>
                                        <tr class="read">
                                            <td class="contact"><b>Fecha de Solicitud</b></td>
                                            <td class="contact"><b>Estado</b></td>
                                            <td class="contact"><b>Iglesia Origen</b></td>
                                            <td class="contact"><b>Iglesia Destino</b></td>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($historialsoli as $hs)
                                        <tr class="read">
                                            <td class="subject">{{$hs->fechasolicitud}}</td>
                                            <td class="subject">{{$hs->estado}}</td>
                                            <td class="subject">{{$hs->io}}</td>
                                            <td class="subject">{{$hs->ide}}</td>
                                        </tr>
                                        @endforeach
                                    </tbody>  
                                </table>
                            </div>
                        </div>
                        <h3 class="card-inside-title">DATOS DE LA IGLESIA DESTINO</h3>
                        <div class="row clearfix">
                            <div class="col-md-12">
                                <table class="table table-hover">
                                    <tbody>
                                        <tr class="read">
                                            <td class="contact"><b>Distrito</b></td>
                                            <td class="contact"><b>Iglesia</b></td>
                                            <td class="contact"><b>Ciudad</b></td>
                                            <td class="contact"><b>E-mail</b></td>
                                            <td class="contact"><b>Pastor</b></td>
                                            <td class="contact"><b>Telefono</b></td>
                                        </tr>
                                        <tr class="read">
                                            <td class="subject">{{$iglesiadestino->distrito->nombre}}</td>
                                            <td class="subject">{{$iglesiadestino->nombre}}</td>
                                            <td class="subject">{{$iglesiadestino->ciudad->nombre}}</td>
                                            <td class="subject">{{$iglesiadestino->email}}</td>
                                            @if($pastord != null)
                                            <td class="subject">{{$pastord->personanatural->primer_nombre." ".$pastord->personanatural->segundo_nombre." ".$pastord->personanatural->primer_apellido." ".$pastord->personanatural->segundo_apellido}}</td>
                                            <td class="subject">{{$pastord->personanatural->persona->telefono}}</td>
                                            @else
                                            <td class="subject">NO TIENE PASTOR ASIGNADO</td>
                                            <td class="subject"> -- </td>
                                            @endif
                                        </tr>
                                    </tbody>  
                                </table>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="button-demo">
                                <a data-toggle="modal" data-target="#aceptar" class="btn bg-orange waves-effect">
                                    <div><span>ACEPTAR</span><span class="ink animate"></span></div>
                                </a>
                                <a data-toggle="modal" data-target="#rechazar" class="btn bg-orange waves-effect">
                                    <div><span>RECHAZAR</span><span class="ink animate"></span></div>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
<!-- ModalAceptar -->
<div class="modal fade" id="aceptar" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="defaultModalLabel">ACEPTAR SOLICITUD</h4>
            </div>
            <div class="modal-body">
                <form class="form-horizontal" role='form' method="POST" action="{{route('solicitud.update',$solicitud->id)}}">
                    @csrf 
                    <input name="_method" type="hidden" value="PUT" />
                    <input type="hidden" name="iglesia_origen" id="iglesia_origen" value="{{$solicitud->iglesia_origen}}"/>
                    <input type="hidden" name="estado" id="estado" value="ACEPTADA"/>
                    <div class="col-md-12">
                        <div class="form-group">
                            <div class="form-line">
                                <label class="control-label">Periodo</label>
                                <select class="form-control"  style="width: 100%;" id="periodo_origen" name="periodo_origen" onchange="getActas(this.id, 'iglesia_origen', 'acta_origen')">
                                    <option value="">-- Seleccione una opción --</option>
                                    @foreach($periodos as $key=>$value)
                                    <option value="{{$key}}">{{$value}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="form-line">
                                <label class="control-label">Actas</label>
                                <select class="form-control"  style="width: 100%;" id="acta_origen" name="acta_origen" required="required">
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <div class="form-line">
                                <br/><input class="form-control" type="text" id="observacion" placeholder="Observación" name="observacion_origen">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <br/><br/><a data-dismiss="modal" class="btn bg-red waves-effect">Cancelar</a>
                            <button class="btn bg-indigo waves-effect" type="reset">Limpiar Formulario</button>
                            <button class="btn bg-green waves-effect" type="submit">Guardar</button>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
            </div>
        </div>
    </div>
</div>
<!-- Modal Rechazar -->
<div class="modal fade" id="rechazar" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="defaultModalLabel">RECHAZAR SOLICITUD</h4>
            </div>
            <div class="modal-body">
                <form class="form-horizontal" role='form' method="POST" action="{{route('solicitud.update',$solicitud->id)}}">
                    @csrf 
                    <input name="_method" type="hidden" value="PUT" />
                    <input type="hidden" name="iglesia_origen" id="iglesia_destino" value="{{$solicitud->iglesia_origen}}"/>
                    <input type="hidden" name="estado" id="esatdo" value="RECHAZADA"/>
                    <div class="col-md-12">
                        <div class="form-group">
                            <div class="form-line">
                                <label class="control-label">Periodo</label>
                                <select class="form-control"  style="width: 100%;" id="periodo_destino" name="periodo_origen" onchange="getActas(this.id, 'iglesia_destino', 'acta_destino')">
                                    <option value="">-- Seleccione una opción --</option>
                                    @foreach($periodos as $key=>$value)
                                    <option value="{{$key}}">{{$value}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="form-line">
                                <label class="control-label">Actas</label>
                                <select class="form-control"  style="width: 100%;" id="acta_destino" name="acta_origen" required="required">
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <div class="form-line">
                                <br/><input class="form-control" type="text" id="observacion" placeholder="Observación" name="observacion_origen">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <br/><br/><a data-dismiss="modal" class="btn bg-red waves-effect">Cancelar</a>
                            <button class="btn bg-indigo waves-effect" type="reset">Limpiar Formulario</button>
                            <button class="btn bg-green waves-effect" type="submit">Guardar</button>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
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
                <strong>Rechace o acepte, </strong> las solicitudes de traslados.
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
        alert(igl);
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
