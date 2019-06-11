@extends('layouts.admin')
@section('breadcrumb')
<ol class="breadcrumb breadcrumb-bg-blue-grey" style="margin-bottom: 30px;">
    <li><a href="{{route('inicio')}}">Inicio</a></li>
    <li><a href="{{route('admin.comunicacion')}}">Comunicación</a></li>
    <li><a href="{{route('admin.institucional')}}">Institucional</a></li>
    <li class="active"><a>Menú</a></li>
</ol>
@endsection
@section('content')
<div class="row clearfix">
    <div class="col-md-12">
        <div class="card">
            <div class="header">
                <h2>
                    MENÚ INSTITUCIONAL<small>Haga clic en el botón de 3 puntos de la derecha de este título para obtener ayuda.</small>
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
                <h1 class="card-inside-title">MENÚ</h1>
                <div class="button-demo">
                    <a href="{{route('mision.index')}}" class="btn bg-green waves-effect">
                        <div><span>MISIÓN</span><span class="ink animate"></span></div>
                    </a>
                    <a href="{{route('vision.index')}}" class="btn bg-green waves-effect">
                        <div><span>VISIÓN</span><span class="ink animate"></span></div>
                    </a>
                    <a href="{{route('valor.index')}}" class="btn bg-green waves-effect">
                        <div><span>VALORES</span><span class="ink animate"></span></div>
                    </a>
                    <a href="{{route('historia.index')}}" class="btn bg-green waves-effect">
                        <div><span>HISTORIA</span><span class="ink animate"></span></div>
                    </a>
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
                <h4 class="modal-title" id="defaultModalLabel">SOBRE INSTITUCIONAL</h4>
            </div>
            <div class="modal-body">
                <strong>Detalles: </strong> Gestión de un pequeño repositorio local donde se guardaran todos los libros que sean subidos.
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-link waves-effect" data-dismiss="modal">ACEPTAR</button>
            </div>
        </div>
    </div>
</div>
@endsection