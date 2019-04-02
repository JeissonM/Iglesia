@extends('layouts.admin')
@section('breadcrumb')
<ol class="breadcrumb breadcrumb-bg-blue-grey" style="margin-bottom: 30px;">
    <li><a href="{{route('inicio')}}">Inicio</a></li>
    <li><a href="{{route('admin.feligresia')}}">Feligresía</a></li>
    <li><a href="{{route('admin.feligresia')}}">Feligresía</a></li>
    <li><a href="{{route('admin.feligresia')}}">Experiencia</a></li>
    <li><a href="{{route('conocimiento.index2',$conocimiento->feligres_id)}}">Conocimiento</a></li>
    <li class="active"><a>Editar Conocimiento</a></li>
</ol>
@endsection
@section('content')
<div class="row clearfix">
    <div class="col-md-12">
        <div class="card">
            <div class="header">
                <h2>
                    DATOS DEL FELIGRES CONSULTADO
                </h2>
            </div>
            <div class="body">
                <table class="table table-hover">
                    <tbody>
                        <tr class="read">
                            <td class="contact"><b>Tipo y Número de Documento</b></td>
                            <td class="subject">{{$conocimiento->feligres->personanatural->persona->tipodocumento->abreviatura." - ".$conocimiento->feligres->personanatural->persona->numero_documento}}</td>
                        </tr>
                        <tr class="read">
                            <td class="contact"><b>Nombre</b></td>
                            <td class="subject">{{$conocimiento->feligres->personanatural->primer_apellido." ".$conocimiento->feligres->personanatural->segundo_apellido." ".$conocimiento->feligres->personanatural->primer_nombre." ".$conocimiento->feligres->personanatural->segundo_nombre}}</td>
                        </tr>
                        <tr class="read">
                            <td class="contact"><b>Estado Civil</b></td>
                            <td class="subject">{{$conocimiento->feligres->personanatural->estadocivil->descripcion}}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<div class="row clearfix">
    <div class="col-md-12">
        <div class="card">
            <div class="header">
                <h2>
                    CONOCIMIENTO - EDITAR CONOCIMIENTO<small> Haga clic en el botón de 3 puntos de la derecha de este título para obtener ayuda.</small>
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
                <h1 class="card-inside-title">EDITAR DATOS DEL CONOCIMIENTO: {{$conocimiento->nombre}}</h1>
                <div class="row clearfix">
                    <div class="col-md-12">
                        <form class="form-horizontal" role='form' method="POST" action="{{route('conocimiento.update',$conocimiento->id)}}">
                            @csrf 
                            <input name="_method" type="hidden" value="PUT" /> 
                            <input type="hidden" name="feligres_id" value="{{$conocimiento->feligres_id}}">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <div class="form-line">
                                        <br/><input class="form-control" type="text" name="nombre" required="required" placeholder="Nombre del trabajo" value="{{$conocimiento->nombre}}">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <div class="form-line">
                                        <br/><input class="form-control" type="text" name="descripcion" placeholder="Descripcion del trabajo" value="{{$conocimiento->descripcion}}">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <br/><br/><a href="{{route('conocimiento.index2',$conocimiento->feligres_id)}}" class="btn bg-red waves-effect">Cancelar</a>
                                    <button class="btn bg-indigo waves-effect" type="reset">Limpiar Formulario</button>
                                    <button class="btn bg-green waves-effect" type="submit">Guardar</button>
                                </div>
                            </div>
                        </form>
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
                <h4 class="modal-title" id="defaultModalLabel">SOBRE LOS CONOCIMIENTO</h4>
            </div>
            <div class="modal-body">
                <strong>Actualice el conocimiento,</strong> son las actividades económicas o profesiones que desempeña o a desempeñado el feligres consultado.
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-link waves-effect" data-dismiss="modal">ACEPTAR</button>
            </div>
        </div>
    </div>
</div>
@endsection