@extends('layouts.admin')
@section('breadcrumb')
<ol class="breadcrumb breadcrumb-bg-blue-grey" style="margin-bottom: 30px;">
    <li><a href="{{route('inicio')}}">Inicio</a></li>
    <li><a href="{{route('admin.gestiondocumental')}}">Gestión Documental</a></li>
    <li class="active"><a>Menú</a></li>
</ol>
@endsection
@section('content')
<div class="row clearfix">
    <div class="col-md-12">
        <div class="card">
            <div class="header">
                <h2>
                    MENÚ GESTIÓN DOCUMENTAL<small>GESTIÓN DE TODOS LOS PROCESOS DOCUMENTALES DE LA IGLESIA.</small>
                </h2>
            </div>
            <div class="body">
                <div class="col-md-12">
                    @component('layouts.errors')
                    @endcomponent
                </div>
                <h1 class="card-inside-title">MENÚ</h1>
                <div class="button-demo">
                    @if(session()->exists('PAG_ITINERARIO-EVENTOS'))
                    <a href="{{route('itinerario.index')}}" class="btn bg-blue waves-effect">
                        <div><span>ITINERARIO DE CULTO, EVENTOS Y REUNIONES</span><span class="ink animate"></span></div>
                    </a>
                    @endif
                    @if(session()->exists('PAG_LISTA-PREDICACION'))
                    <a href="{{route('listapredicacion.index')}}" class="btn bg-blue waves-effect">
                        <div><span>LISTA DE PREDICACIÓN</span><span class="ink animate"></span></div>
                    </a>
                    @endif
                    @if(session()->exists('PAG_ACTA-GESTION-DOCUMENTAL'))
                    <a href="{{route('junta.indexacta')}}" class="btn bg-blue waves-effect">
                        <div><span>ACTAS DE LAS REUNIONES DE LA JUNTA</span><span class="ink animate"></span></div>
                    </a>
                    @endif
                    @if(session()->exists('PAG_RECURSOS-MINISTERIALES'))
                    <a href="{{route('recursosministeriales.index')}}" class="btn bg-blue waves-effect">
                        <div><span>RECURSOS MINISTERIALES</span><span class="ink animate"></span></div>
                    </a>
                    @endif
                    @if(session()->exists('PAG_EDITORIAL'))
                    <a href="{{route('admin.editorial')}}" class="btn bg-blue waves-effect">
                        <div><span>EDITORIAL</span><span class="ink animate"></span></div>
                    </a>
                    @endif
                    @if(session()->exists('PAG_SERMON'))
                    <a href="{{route('sermon.index')}}" class="btn bg-blue waves-effect">
                        <div><span>SERMONES</span><span class="ink animate"></span></div>
                        @endif
                        @if(session()->exists('PAG_MULTIMEDIA-MINISTERIAL'))
                        <a href="{{route('multimediaministerial.index')}}" class="btn bg-blue waves-effect">
                            <div><span>MULTIMEDIA MINISTERIAL (INFORME DE PROGRAMAS, EVENTOS, ALBUM DE FOTOGRAFÍAS O VÍDEOS, ETC)</span><span class="ink animate"></span></div>
                        </a>
                        @endif
                        @if(session()->exists('PAG_VISUALIZACION-MULTIMEDIA-MINISTERIOS'))
                        <a href="{{route('multimediaministerial.visualizacionindex')}}" class="btn bg-blue waves-effect">
                            <div><span>MULTIMEDIA MINISTERIAL - VISUALIZACIÓN</span><span class="ink animate"></span></div>
                        </a>
                        @endif
                        @if(session()->exists('PAG_RECURSOS-MINISTERIALES-VISUALIZACION'))
                        <a href="{{route('recursosministeriales.visualizacionindex')}}" class="btn bg-blue waves-effect">
                            <div><span>RECURSOS MINISTERIALES - VISUALIZACIÓN</span><span class="ink animate"></span></div>
                        </a>
                        @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
