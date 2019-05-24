@extends('layouts.admin')
@section('breadcrumb')
<ol class="breadcrumb breadcrumb-bg-blue-grey" style="margin-bottom: 30px;">
    <li><a href="{{route('inicio')}}">Inicio</a></li>
    <li><a href="{{route('admin.feligresia')}}">Feligresía</a></li>
    <li><a href="{{route('admin.feligresia')}}">Feligresía</a></li>
    <li class="active"><a>Menu Experiencia</a></li>
</ol>
@endsection
@section('content')
<div class="row clearfix">
    <div class="col-md-12">
        <div class="card">
            <div class="header">
                <h2>
                    MENU EXPERIENCIA<small>Haga clic en el botón de 3 puntos de la derecha de este título para obtener ayuda.</small>
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
                <h2> DATOS DEL FELIGRES CONSULTADO</h2>
                </br><div class="row clearfix">
                    <div class="col-md-12">
                        <table class="table table-hover">
                            <tbody>
                                <tr class="read">
                                    <td class="contact"><b>Tipo y Número de Documento</b></td>
                                    <td class="subject">{{$feligres->personanatural->persona->tipodocumento->abreviatura." - ".$feligres->personanatural->persona->numero_documento}}</td>
                                </tr>
                                <tr class="read">
                                    <td class="contact"><b>Nombre</b></td>
                                    <td class="subject">{{$feligres->personanatural->primer_apellido." ".$feligres->personanatural->segundo_apellido." ".$feligres->personanatural->primer_nombre." ".$feligres->personanatural->segundo_nombre}}</td>
                                </tr>
                                <tr class="read">
                                    <td class="contact"><b>Estado Civil</b></td>
                                    <td class="subject">{{$feligres->personanatural->estadocivil->descripcion}}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <h1 class="card-inside-title">MENU</h1>
                <div class="row clearfix">
                    <div class="col-md-12">
                        <div class="button-demo">
                            <a href="{{route('experiencialabor.index2',$feligres->id)}}" class="btn bg-deep-orange waves-effect">
                                <div><span>TRABAJO/LABOR</span><span class="ink animate"></span></div>
                            </a>
                            <a href="{{route('conocimiento.index2',$feligres->id)}}" class="btn bg-deep-orange waves-effect">
                                <div><span>CONOCIMIENTOS</span><span class="ink animate"></span></div>
                            </a>
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
                <h4 class="modal-title" id="defaultModalLabel">SOBRE LA EXPERIENCIA</h4>
            </div>
            <div class="modal-body">
                <strong>Agregue nuevo pastor,</strong> A partir de los datos ya gestionado con anterioridad en el feligres agregue nuevo pastor; el campo distrito o zonas a cargos, sera llenado siempre y cuando el pastor tenga mas de un distrito o zona a cargo. 
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-link waves-effect" data-dismiss="modal">ACEPTAR</button>
            </div>
        </div>
    </div>
</div>
@endsection