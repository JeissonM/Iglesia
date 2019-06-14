@extends('layouts.admin')
@section('breadcrumb')
<ol class="breadcrumb breadcrumb-bg-blue-grey" style="margin-bottom: 30px;">
    <li><a href="{{route('inicio')}}">Inicio</a></li>
    <li><a href="{{route('admin.auditoria')}}">Auditoría</a></li>
    <li class="active"><a>Menú</a></li>
</ol>
@endsection
@section('content')
<div class="row clearfix">
    <div class="col-md-12">
        <div class="card">
            <div class="header">
                <h2>
                    MENÚ AUDITORÍA<small>AUDITORÍA DE TODOS LOS PROCESOS QUE REALIZA LA INSTITUCIÓN</small>
                </h2>
            </div>
            <div class="body">
                <div class="col-md-12">
                    @component('layouts.errors')
                    @endcomponent
                </div>
                <h1 class="card-inside-title">MENÚ</h1>
                <div class="button-demo">
                    <a href="{{route('auditoria.index','USUARIOS')}}" class="btn bg-blue-grey waves-effect">
                        <div><span>AUDITORÍA MÓDULO USUARIOS</span><span class="ink animate"></span></div>
                    </a>
                    <a href="{{route('auditoria.index','FELIGRESIA')}}" class="btn bg-blue-grey waves-effect">
                        <div><span>AUDITORÍA MÓDULO FELIGRESÍA</span><span class="ink animate"></span></div>
                    </a>
                    <a href="{{route('auditoria.index','GESTION DOCUMENTAL')}}" class="btn bg-blue-grey waves-effect">
                        <div><span>AUDITORÍA MÓDULO GESTIÓN DOCUMENTAL</span><span class="ink animate"></span></div>
                    </a>
                    <a href="{{route('auditoria.index','COMUNICACION')}}" class="btn bg-blue-grey waves-effect">
                        <div><span>AUDITORÍA MÓDULO COMUNICACIÓN</span><span class="ink animate"></span></div>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection