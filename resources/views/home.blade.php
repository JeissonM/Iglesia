@extends('layouts.admin')
@section('content')
<div class="col-md-12">
    <div class="alert bg-blue-grey alert-dismissible" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
        Bienvenido <strong>{{Auth::user()->nombres . ' ' . Auth::user()->apellidos}}</strong> al Sitio Oficial de los Adventistas del Séptimo Día en los Distritos de Valledupar. Feliz Día, El Señor te Bendiga en Abundancia!
    </div>
</div>
<div class="col-md-12">
    <div class="row">
        @if(session()->exists('MOD_USUARIOS'))
        <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
            <div class="info-box bg-brown hover-zoom-effect hover-expand-effect">
                <div class="icon">
                    <a href="{{route('admin.usuarios')}}"><i class="material-icons">person</i></a>
                </div>
                <div class="content">
                    <div class="text">ADMINISTRACIÓN DE</div>
                    <div class="number">USUARIOS</div>
                </div>
            </div>
        </div>
        @endif
        @if(session()->exists('MOD_FELIGRESIA'))
        <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
            <div class="info-box bg-orange hover-zoom-effect hover-expand-effect">
                <div class="icon">
                    <a href="{{route('admin.feligresia')}}"><i class="material-icons">view_list</i></a>
                </div>
                <div class="content">
                    <div class="text">GESTIÓN DE</div>
                    <div class="number">FELIGRESÍA</div>
                </div>
            </div>
        </div>
        @endif
        @if(session()->exists('MOD_GESTION-DOCUMENTAL'))
        <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
            <div class="info-box bg-blue hover-zoom-effect hover-expand-effect">
                <div class="icon">
                    <a href="{{route('admin.gestiondocumental')}}"><i class="material-icons">book</i></a>
                </div>
                <div class="content">
                    <div class="text">GESTIÓN</div>
                    <div class="number">DOCUMENTAL</div>
                </div>
            </div>
        </div>
        @endif
        @if(session()->exists('MOD_COMUNICACION'))
        <div class="col-lg-5 col-md-5 col-sm-6 col-xs-12">
            <div class="info-box bg-green hover-zoom-effect hover-expand-effect">
                <div class="icon">
                    <a href="{{route('admin.comunicacion')}}"><i class="material-icons">ring_volume</i></a>
                </div>
                <div class="content">
                    <div class="text">MINISTERIO</div>
                    <div class="number">DE COMUNICACIÓN</div>
                </div>
            </div>
        </div>
        @endif
        @if(session()->exists('MOD_AUDITORIA'))
        <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
            <div class="info-box bg-blue-grey hover-zoom-effect hover-expand-effect">
                <div class="icon">
                    <a href="{{route('admin.auditoria')}}"><i class="material-icons">check_circle</i></a>
                </div>
                <div class="content">
                    <div class="text">AUDITORÍA</div>
                    <div class="number">DEL SISTEMA</div>
                </div>
            </div>
        </div>
        @endif
        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
            <div class="info-box bg-red hover-zoom-effect hover-expand-effect">
                <div class="icon">
                    <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><i class="material-icons">exit_to_app</i></a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        {{ csrf_field() }}
                    </form>
                </div>
                <div class="content">
                    <div class="text">SALIR</div>
                    <div class="number">DEL PANEL</div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
