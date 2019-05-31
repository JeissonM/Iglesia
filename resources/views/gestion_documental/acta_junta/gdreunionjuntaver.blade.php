@extends('layouts.admin')
@section('breadcrumb')
<ol class="breadcrumb breadcrumb-bg-blue-grey" style="margin-bottom: 30px;">
    <li><a href="{{route('inicio')}}">Inicio</a></li>
    <li><a href="{{route('admin.gestiondocumental')}}">Gestión Documental</a></li>
    <li><a href="{{route('junta.indexacta')}}">Actas de Reuniones de Junta de Iglesia</a></li>
    <li><a href="{{route('junta.reunionesacta',[$f->id,$p->id])}}">Reuniones de la Junta</a></li>
    <li class="active"><a>Ver Reunión</a></li>
</ol>
@endsection
@section('content')
<div class="row clearfix">
    <div class="col-md-12">
        <div class="card">
            <div class="header">
                <h2>
                    JUNTA DE IGLESIA - REUNIONES DE LA JUNTA
                </h2>
            </div>
            <div class="body">
                <div class="row clearfix">
                    <div class="col-md-12">
                        <table class="table table-hover">
                            <tbody>
                                <tr class="read">
                                    <td class="contact"><b>JUNTA DIRECTIVA</b></td>
                                    <td class="contact"><b>PERÍODO</b></td>
                                </tr>
                                <tr class="read">
                                    <td class="contact">{{$j->etiqueta}}</td>
                                    <td class="subject">{{$p->etiqueta." - DESDE: ".$p->fechainicio." - HASTA: ".$p->fechafin}}</td>
                                </tr>
                                <tr class="read">
                                    <td class="contact"><b>PASTOR</b></td>
                                    <td class="contact"><b>IGLESIA</b></td>
                                </tr>
                                <tr class="read">
                                    <td class="contact">{{$j->pastor->personanatural->primer_nombre." ".$j->pastor->personanatural->segundo_nombre." ".$j->pastor->personanatural->primer_apellido." ".$j->pastor->personanatural->segundo_apellido}}</td>
                                    <td class="subject">{{$j->iglesia->nombre." - ".$j->iglesia->distrito->nombre}}</td>
                                </tr>
                                <tr class="read">
                                    <td class="contact"><b>JUNTA</b></td>
                                    <td class="contact"><b>VIGENTE</b></td>
                                </tr>
                                <tr class="read">
                                    <td class="contact">{{$j->etiqueta}}</td>
                                    <td class="subject">{{$j->vigente}}</td>
                                </tr>
                                <tr class="read">
                                    <td class="contact"><b>AGENDA</b></td>
                                    <td class="contact"><b>PUNTOS AGENDA</b></td>
                                </tr>
                                <tr class="read">
                                    <td class="contact">{{$r->agendajunta->titulo}}</td>
                                    <td class="subject">
                                        <ul>
                                            @foreach($r->agendajunta->agendajuntapuntos as $ajp)
                                            <li>{{$ajp->punto." - ".$ajp->ministerio." (".$ajp->feligres->personanatural->primer_nombre." ".$ajp->feligres->personanatural->segundo_nombre." ".$ajp->feligres->personanatural->primer_apellido." ".$ajp->feligres->personanatural->segundo_apellido.")"}}</li>
                                            @endforeach
                                        </ul>
                                    </td>
                                </tr>
                                <tr class="read">
                                    <td class="contact"><b>REUNIÓN</b></td>
                                    <td class="contact"><b>FECHA</b></td>
                                </tr>
                                <tr class="read">
                                    <td class="contact">{{$r->titulo}}</td>
                                    <td class="subject">{{$r->fecha}}</td>
                                </tr>
                                <tr class="read">
                                    <td class="contact"><b>ASISTENTES</b></td>
                                    <td class="contact"><b>CONCLUSIONES</b></td>
                                </tr>
                                <tr class="read">
                                    <td class="contact">{{$r->asistentes}}</td>
                                    <td class="subject">{{$r->conclusiones}}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="col-md-12">
                        <h3>ACTA DE REUNIÓN DE LA JUNTA</h3>
                        @if($r->actajunta->documento!='')
                        <iframe src="{{asset('docs/actas/'.$r->actajunta->documento)}}" width="100%" height="800px"></iframe>
                        @endif
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
        //$('#tabla').DataTable();
    });
</script>
@endsection