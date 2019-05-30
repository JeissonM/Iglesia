@extends('layouts.admin')
@section('breadcrumb')
<ol class="breadcrumb breadcrumb-bg-blue-grey" style="margin-bottom: 30px;">
    <li><a href="{{route('inicio')}}">Inicio</a></li>
    <li><a href="{{route('admin.gestiondocumental')}}">Gestión Documental</a></li>
    <li><a href="{{route('junta.indexacta')}}">Actas de Reuniones de Junta de Iglesia</a></li>
    <li class="active"><a>Reuniones</a></li>
</ol>
@endsection
@section('content')
<div class="row clearfix">
    <div class="col-md-12">
        <div class="card">
            <div class="header">
                <h2>
                    ACTAS DE REUNIONES DE LA JUNTA DE IGLESIA
                </h2>
            </div>
            <div class="body">
                <div class="row clearfix">
                    @if($junta!==null)
                    <div class="col-md-12">
                        <table class="table table-hover">
                            <tbody>
                                <tr class="read">
                                    <td class="contact"><b>JUNTA DIRECTIVA</b></td>
                                    <td class="contact"><b>PERÍODO</b></td>
                                </tr>
                                <tr class="read">
                                    <td class="contact">{{$junta->etiqueta}}</td>
                                    <td class="subject">{{$p->etiqueta." - DESDE: ".$p->fechainicio." - HASTA: ".$p->fechafin}}</td>
                                </tr>
                                <tr class="read">
                                    <td class="contact"><b>PASTOR</b></td>
                                    <td class="contact"><b>IGLESIA</b></td>
                                </tr>
                                <tr class="read">
                                    <td class="contact">{{$junta->pastor->personanatural->primer_nombre." ".$junta->pastor->personanatural->segundo_nombre." ".$junta->pastor->personanatural->primer_apellido." ".$junta->pastor->personanatural->segundo_apellido}}</td>
                                    <td class="subject">{{$junta->iglesia->nombre." - ".$junta->iglesia->distrito->nombre}}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="col-md-12">
                        <h4>LISTADO DE REUNIONES REALIZADAS POR LA JUNTA PARA EL PERÍODO INDICADO</h4>
                        <div class="table-responsive">
                            <table id="tabla" class="table table-bordered table-striped table-hover table-responsive table-condensed dataTable js-exportable" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>TÍTULO</th>
                                        <th>FECHA DE REUNIÓN</th>
                                        <th>CREADO</th>
                                        <th>MODIFICADO</th>
                                        <th>ACCIONES</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($reuniones as $r)
                                    <tr>
                                        <td>{{$r->titulo}}</td>
                                        <td>{{$r->fecha}}</td>
                                        <td>{{$r->created_at}}</td>
                                        <td>{{$r->updated_at}}</td>
                                        <td>
                                            <a href="{{ route('junta.reunionjuntaveracta',[$f->id,$p->id,$junta->id,$r->id])}}" class="btn bg-green waves-effect btn-xs" data-toggle="tooltip" data-placement="top" title="Ver Reunión"><i class="material-icons">remove_red_eye</i></a>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    @else
                    <div class="alert alert-danger alert-dismissible fade in" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
                        <p>No hay junta directiva creada para el período indicado.</p>
                    </div>
                    @endif
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