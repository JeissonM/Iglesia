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
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
