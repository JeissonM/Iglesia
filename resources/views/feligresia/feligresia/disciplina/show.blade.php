@extends('layouts.admin')
@section('breadcrumb')
<ol class="breadcrumb breadcrumb-bg-blue-grey" style="margin-bottom: 30px;">
    <li><a href="{{route('inicio')}}">Inicio</a></li>
    <li><a href="{{route('admin.feligresia')}}">Feligresía</a></li>
    <li><a href="{{route('admin.feligresia')}}">Feligresía</a></li>
    <li><a href="{{route('disciplina.inicio',$d->feligres->personanatural->persona->numero_documento)}}">Disciplina</a></li>
    <li class="active"><a>Ver Disciplina</a></li>
</ol>
@endsection
@section('content')
<div class="row clearfix">
    <div class="col-md-12">
        <div class="card">
            <div class="header">
                <h2>
                    DISCIPLINA
                </h2>
            </div>
            <div class="body">
                <h2> DATOS DEL FELIGRÉS CONSULTADO</h2>
                </br><div class="row clearfix">
                    <div class="col-md-12">
                        <table class="table table-hover">
                            <tbody>
                                <tr class="read">
                                    <td class="contact"><b>Tipo y Número de Documento</b></td>
                                    <td class="subject">{{$d->feligres->personanatural->persona->tipodocumento->abreviatura." - ".$d->feligres->personanatural->persona->numero_documento}}</td>
                                </tr>
                                <tr class="read">
                                    <td class="contact"><b>Nombre</b></td>
                                    <td class="subject">{{$d->feligres->personanatural->primer_apellido." ".$d->feligres->personanatural->segundo_apellido." ".$d->feligres->personanatural->primer_nombre." ".$d->feligres->personanatural->segundo_nombre}}</td>
                                </tr>
                                <tr class="read">
                                    <td class="contact"><b>Estado Civil</b></td>
                                    <td class="subject">{{$d->feligres->personanatural->estadocivil->descripcion}}</td>
                                </tr>
                                <tr class="read">
                                    <td class="contact"><b>Iglesia Actual</b></td>
                                    <td class="subject">{{$d->feligres->iglesia->nombre}}</td>
                                </tr>
                                <tr class="read">
                                    <td class="contact"><b>Estado Actual</b></td>
                                    <td class="subject">{{$d->feligres->estado_actual}}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <h2> DATOS DE LA JUNTA Y LA REUNIÓN DECISORIA</h2>
                </br><div class="row clearfix">
                    <div class="col-md-12">
                        <table class="table table-hover">
                            <tbody>
                                <tr class="read">
                                    <td class="contact"><b>Junta Directiva</b></td>
                                    <td class="subject">{{$d->reunionjunta->junta->etiqueta}}</td>
                                </tr>
                                <tr class="read">
                                    <td class="contact"><b>Pastor</b></td>
                                    <td class="subject">{{$d->reunionjunta->junta->pastor->personanatural->primer_nombre." ".$d->reunionjunta->junta->pastor->personanatural->segundo_nombre." ".$d->reunionjunta->junta->pastor->personanatural->primer_apellido." ".$d->reunionjunta->junta->pastor->personanatural->segundo_apellido}}</td>
                                </tr>
                                <tr class="read">
                                    <td class="contact"><b>Reunión de Junta</b></td>
                                    <td class="subject">{{$d->reunionjunta->titulo}}</td>
                                </tr>
                                <tr class="read">
                                    <td class="contact"><b>Fecha Reunión de Junta</b></td>
                                    <td class="subject">{{$d->reunionjunta->fecha}}</td>
                                </tr>
                                <tr class="read">
                                    <td class="contact"><b>Acta de Junta</b></td>
                                    <td class="subject"><a href="{{asset('docs/actas/'.$d->reunionjunta->actajunta->documento)}}" target="_blank">Ver Acta</a></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <h2> DATOS DE LA DISCIPLINA</h2>
                </br><div class="row clearfix">
                    <div class="col-md-12">
                        <table class="table table-hover">
                            <tbody>
                                <tr class="read">
                                    <td class="contact"><b>Disciplina</b></td>
                                    <td class="subject">{{$d->descripcion}}</td>
                                </tr>
                                <tr class="read">
                                    <td class="contact"><b>Inicio</b></td>
                                    <td class="subject">{{$d->fechainicio}}</td>
                                </tr>
                                <tr class="read">
                                    <td class="contact"><b>Fin</b></td>
                                    <td class="subject">{{$d->fechafin}}</td>
                                </tr>
                                <tr class="read">
                                    <td class="contact"><b>Período</b></td>
                                    <td class="subject">{{$d->periodo->etiqueta}}</td>
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
@section('script')
<script type="text/javascript">
    $(document).ready(function () {
    });
</script>
@endsection