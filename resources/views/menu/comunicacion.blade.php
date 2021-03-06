@extends('layouts.admin')
@section('breadcrumb')
<ol class="breadcrumb breadcrumb-bg-blue-grey" style="margin-bottom: 30px;">
    <li><a href="{{route('inicio')}}">Inicio</a></li>
    <li><a href="{{route('admin.comunicacion')}}">Comunicación</a></li>
    <li class="active"><a>Menú</a></li>
</ol>
@endsection
@section('content')
<div class="row clearfix">
    <div class="col-md-12">
        <div class="card">
            <div class="header">
                <h2>
                    MENÚ COMUNICACIÓN<small>GESTIÓN DE TODOS LOS PROCESOS COMUNICATIVOS DE LA IGLESIA.</small>
                </h2>
            </div>
            <div class="body">
                <div class="col-md-12">
                    @component('layouts.errors')
                    @endcomponent
                </div>
                <h1 class="card-inside-title">MENÚ</h1>
                <div class="button-demo">
                    @if(session()->exists('PAG_AGENDA-ASOCIACION'))
                    <a href="{{route('agendaasociacion.index')}}" class="btn bg-green waves-effect">
                        <div><span>AGENDA ASOCIACIÓN</span><span class="ink animate"></span></div>
                    </a>
                    @endif
                    @if(session()->exists('PAG_DIRECTORIO-FELIGRES'))
                    <a href="{{route('feligres.directorio')}}"  class="btn bg-green waves-effect">
                        <div><span>DIRECTORIO DE FELIGRESES</span><span class="ink animate"></span></div>
                    </a>
                    @endif
                    @if(session()->exists('PAG_DIRECTORIO-IGLESIAS'))
                    <a href="{{route('iglesia.directorio')}}" class="btn bg-green waves-effect">
                        <div><span>DIRECTORIO DE IGLESIAS</span><span class="ink animate"></span></div>
                    </a>
                    @endif
                    @if(session()->exists('PAG_JARDIN-ORACION'))
                    <a href="{{route('pedidosoracion.index')}}" class="btn bg-green waves-effect">
                        <div><span>JARDÍN DE ORACIÓN</span><span class="ink animate"></span></div>
                    </a>
                    @endif
                    @if(session()->exists('PAG_ANUNCIOS'))
                    <a href="{{route('anuncios.index')}}" class="btn bg-green waves-effect">
                        <div><span>ANUNCIOS GESTIÓN</span><span class="ink animate"></span></div>
                    </a>
                    @endif
                    <a href="{{route('anuncios.visualizar')}}" class="btn bg-green waves-effect">
                        <div><span>VER ANUNCIOS</span><span class="ink animate"></span></div>
                    </a>
                    @if(session()->exists('PAG_IGLESIAMAPA'))
                    <a href="{{route('iglesiamapa.index')}}" class="btn bg-green waves-effect">
                        <div><span>ENCONTRAR UNA IGLESIA - GESTIÓN</span><span class="ink animate"></span></div>
                    </a>
                    @endif
                    @if(session()->exists('PAG_INSTITUCIONAL'))
                    <a href="{{route('admin.institucional')}}" class="btn bg-green waves-effect">
                        <div><span>INSTITUCIONAL</span><span class="ink animate"></span></div>
                    </a>
                    @endif
                    <a href="{{route('directoriocontractual.index')}}" class="btn bg-green waves-effect">
                        <div><span>DIRECTORIO CONTRACTUAL</span><span class="ink animate"></span></div>
                    </a>
                    <a href="{{route('contacto.index')}}" class="btn bg-green waves-effect">
                        <div><span>CHAT</span><span class="ink animate"></span></div>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
