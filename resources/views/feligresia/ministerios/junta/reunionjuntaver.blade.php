@extends('layouts.admin')
@section('breadcrumb')
<ol class="breadcrumb breadcrumb-bg-blue-grey" style="margin-bottom: 30px;">
    <li><a href="{{route('inicio')}}">Inicio</a></li>
    <li><a href="{{route('admin.feligresia')}}">Feligresía</a></li>
    <li><a href="{{route('admin.feligresia')}}">Ministerios</a></li>
    <li><a href="{{route('junta.index')}}">Junta de Iglesia</a></li>
    <li><a href="{{route('junta.index')}}">Continuar</a></li>
    <li><a href="{{route('junta.reunionjuntaindex',[$f->id,$p->id,$j->id])}}">Reuniones de la Junta</a></li>
    <li class="active"><a>Ver Reunión</a></li>
</ol>
@endsection
@section('content')
<div class="row clearfix">
    <div class="col-md-12">
        <div class="card">
            <div class="header">
                <h2>
                    JUNTA DE IGLESIA - REUNIONES DE LA JUNTA<small>Haga clic en el botón de 3 puntos de la derecha de este título para agregar un nuevo registro.</small>
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
                            </tbody>
                        </table>
                    </div>
                    <div class="col-md-12">
                        
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