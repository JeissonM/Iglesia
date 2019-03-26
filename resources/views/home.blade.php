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
        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
            <div class="info-box bg-purple hover-zoom-effect hover-expand-effect">
                <div class="icon">
                    <a href="{{route('admin.usuarios')}}"><i class="material-icons">person</i></a>
                </div>
                <div class="content">
                    <div class="text">USUARIOS</div>
                    <div class="number">IASD</div>
                </div>
            </div>
        </div>
        @endif
        @if(session()->exists('MOD_FELIGRESIA'))
        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
            <div class="info-box bg-orange hover-zoom-effect hover-expand-effect">
                <div class="icon">
                    <a href="{{route('admin.feligresia')}}"><i class="material-icons">view_list</i></a>
                </div>
                <div class="content">
                    <div class="text">FELIGRESÍA</div>
                    <div class="number">IASD</div>
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
                    <div class="number">
                        IASD
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
