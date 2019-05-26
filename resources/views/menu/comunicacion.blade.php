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
                    <a disabled="disabled" class="btn bg-blue waves-effect">
                        <div><span>AGENDA ASOCIACIÓN</span><span class="ink animate"></span></div>
                    </a>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection