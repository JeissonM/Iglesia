@extends('layouts.admin')
@section('breadcrumb')
<ol class="breadcrumb breadcrumb-bg-blue-grey" style="margin-bottom: 30px;">
    <li><a href="{{route('inicio')}}">Inicio</a></li>
    <li><a href="{{route('admin.feligresia')}}">Feligresía</a></li>
    <li><a href="{{route('admin.feligresia')}}">Feligresía</a></li>
    <li class="active"><a>Menu Situación</a></li>
</ol>
@endsection
@section('content')
<div class="row clearfix">
    <div class="col-md-12">
        <div class="card">
            <div class="header">
                <h2>
                    MENU SITUACIÓN DEL FELIGRES<small>Haga clic en el botón de 3 puntos de la derecha de este título para obtener ayuda.</small>
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
                <h1 class="card-inside-title">MENU</h1>
                <div class="row clearfix">
                    <div class="col-md-12">
                        <div class="button-demo">
                            @if(session()->exists('PAG_TIPODOCUMENTO'))
                            <a href="{{route('situacion.index')}}" class="btn bg-deep-orange waves-effect">
                                <div><span>GESTIÓN DE SITUACIONES</span><span class="ink animate"></span></div>
                            </a>
                            @endif
                            @if(session()->exists('PAG_ESTADOCIVIL'))
                            <a data-toggle="modal" data-target="#consultar" class="btn bg-deep-orange waves-effect">
                                <div><span>ACTUALIZAR SITUACIÓN/ESTADO DEL FELIGRES</span><span class="ink animate"></span></div>
                            </a>
                            @endif
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
                <h4 class="modal-title" id="defaultModalLabel">SOBRE LA SITUACIÓN</h4>
            </div>
            <div class="modal-body">
                Permite gestionar la situación y estado de los feligreses.
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-link waves-effect" data-dismiss="modal">ACEPTAR</button>
            </div>
        </div>
    </div>
</div>
<!-- Modal Consultar -->
<div class="modal fade" id="consultar" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="defaultModalLabel">GESTIONAR SITUACIÓ/ESTADO DEL FELIGRES</h4>
            </div>
            <div class="modal-body">
                <div class="row clearfix">
                    <form class="form-horizontal" method="POST" action="{{route('situacion.getfeligres')}}" name="form-privilegios" id="form-privilegios">
                        @csrf
                        <div class="col-md-12">
                            <div class="col-sm-8">
                                <div class="form-group">
                                    <div class="form-line">
                                        <input type="text" id="id" class="form-control" placeholder="Escriba la identificación a consultar" name="id"/>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <button type="submit" class="btn bg-orange waves-effect btn-block">CONSULTAR FELIGRES</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-link waves-effect" data-dismiss="modal">CANCELAR</button>
            </div>
        </div>
    </div>
</div>
@endsection