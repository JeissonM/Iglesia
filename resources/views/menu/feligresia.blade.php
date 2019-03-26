@extends('layouts.admin')
@section('breadcrumb')
<ol class="breadcrumb breadcrumb-bg-blue-grey" style="margin-bottom: 30px;">
    <li><a href="{{route('inicio')}}">Inicio</a></li>
    <li class="active"><a href="{{route('admin.feligresia')}}">Feligresía</a></li>
</ol>
@endsection
@section('content')
<div class="row clearfix">
    <div class="col-md-12">
        <div class="card">
            <div class="header">
                <h2>
                    MÓDULO FELIGRESÍA<small>GESTIÓN DE LA FELIGRESÍA DE LA IGLESIA Y TODAS LAS CONFIGURACIONES NECESARIAS PARA SU ADMINISTRACIÓN</small>
                </h2>
            </div>
            <div class="body">
                <div class="row clearfix">
                    <div class="col-md-12">
                        <!-- Nav tabs -->
                        <ul class="nav nav-tabs tab-nav-right" role="tablist">
                            <li role="presentation" class="active"><a href="#home_animation_1" data-toggle="tab"><i class="material-icons">location_on</i> DATOS GEOGRÁFICOS</a></li>
                            <li role="presentation"><a href="#profile_animation_1" data-toggle="tab"><i class="material-icons">assignment_returned</i> ESTRUCTURA ECLESIÁSTICA</a></li>
                            <li role="presentation"><a href="#ministerios_animation_1" data-toggle="tab"><i class="material-icons">work</i> MINISTERIOS</a></li>
                            <li role="presentation"><a href="#feligresia_animation_1" data-toggle="tab"><i class="material-icons">view_list</i> FELIGRESÍA</a></li>
                        </ul>

                        <!-- Tab panes -->
                        <div class="tab-content">
                            <div role="tabpanel" class="tab-pane animated flipInX active" id="home_animation_1">
                                <b>DATOS GEOGRÁFICOS</b>
                                <br/><br/>
                                <div class="button-demo">
                                    @if(session()->exists('PAG_PAISES'))
                                    <a href="{{route('pais.index')}}" class="btn bg-indigo waves-effect">
                                        <div><span>PAÍSES</span><span class="ink animate"></span></div>
                                    </a>
                                    @endif
                                    @if(session()->exists('PAG_DEPARTAMENTOS'))
                                    <a href="{{route('estado.index')}}" class="btn bg-indigo waves-effect">
                                        <div><span>ESTADOS</span><span class="ink animate"></span></div>
                                    </a>
                                    @endif
                                    @if(session()->exists('PAG_CIUDADES'))
                                    <a href="{{route('ciudad.index')}}" class="btn bg-indigo waves-effect">
                                        <div><span>CIUDADES</span><span class="ink animate"></span></div>
                                    </a>
                                    @endif
                                </div>
                            </div>
                            <div role="tabpanel" class="tab-pane animated flipInX" id="profile_animation_1">
                                <b>ESTRUCTURA ECLESIÁSTICA</b>
                                <br/><br/>
                                <div class="button-demo">
                                    @if(session()->exists('PAG_ASOCIACION-GENERAL'))
                                    <a href="{{route('iasd.index')}}" class="btn bg-green waves-effect">
                                        <div><span>ASOCIACIÓN GENERAL</span><span class="ink animate"></span></div>
                                    </a>
                                    @endif
                                    @if(session()->exists('PAG_DIVISIONES'))
                                    <a href="{{route('division.index')}}" class="btn bg-green waves-effect">
                                        <div><span>DIVISIONES</span><span class="ink animate"></span></div>
                                    </a>
                                    @endif
                                    @if(session()->exists('PAG_UNIONES'))
                                    <a href="{{route('union.index')}}" class="btn bg-green waves-effect">
                                        <div><span>UNIONES</span><span class="ink animate"></span></div>
                                    </a>
                                    @endif
                                    @if(session()->exists('PAG_ASOCIACIONES'))
                                    <a href="{{route('asociacion.index')}}" class="btn bg-green waves-effect">
                                        <div><span>ASOCIACIONES / MISIONES</span><span class="ink animate"></span></div>
                                    </a>
                                    @endif
                                    @if(session()->exists('PAG_ZONAS'))
                                    <a href="{{route('zona.index')}}" class="btn bg-green waves-effect">
                                        <div><span>ZONAS</span><span class="ink animate"></span></div>
                                    </a>
                                    @endif
                                    @if(session()->exists('PAG_DISTRITOS'))
                                    <a href="{{route('distrito.index')}}" class="btn bg-green waves-effect">
                                        <div><span>DISTRITOS</span><span class="ink animate"></span></div>
                                    </a>
                                    @endif
                                    @if(session()->exists('PAG_IGLESIAS'))
                                    <a href="{{route('iglesia.index')}}" class="btn bg-green waves-effect">
                                        <div><span>IGLESIAS</span><span class="ink animate"></span></div>
                                    </a>
                                    @endif
                                </div>
                            </div>
                            <div role="tabpanel" class="tab-pane animated flipInX" id="ministerios_animation_1">
                                <b>MINISTERIOS</b>
                                <br/><br/>
                                <div class="button-demo">
                                    @if(session()->exists('PAG_TIPOMINISTERIO'))
                                    <a href="{{route('tipoministerio.index')}}" class="btn bg-blue-grey waves-effect">
                                        <div><span>CATEGORÍAS DE MINISTERIOS</span><span class="ink animate"></span></div>
                                    </a>
                                    @endif
                                    @if(session()->exists('PAG_MINISTERIO'))
                                    <a href="{{route('ministerio.index')}}" class="btn bg-blue-grey waves-effect">
                                        <div><span>MINISTERIOS OFICIALES</span><span class="ink animate"></span></div>
                                    </a>
                                    @endif
                                    @if(session()->exists('PAG_MINISTERIO-EXTRA'))
                                    <a href="{{route('ministerioextra.index')}}" class="btn bg-blue-grey waves-effect">
                                        <div><span>MINISTERIOS EXTRA-OFICIALES</span><span class="ink animate"></span></div>
                                    </a>
                                    @endif
                                    @if(session()->exists('PAG_CARGOS-IGELSIA'))
                                    <a href="{{route('pais.index')}}" class="btn bg-blue-grey waves-effect">
                                        <div><span>CARGOS DE IGLESIA</span><span class="ink animate"></span></div>
                                    </a>
                                    @endif
                                    <a href="{{route('pais.index')}}" class="btn bg-blue-grey waves-effect">
                                        <div><span>PERÍODOS ECLESIÁSTICOS</span><span class="ink animate"></span></div>
                                    </a>
                                    <a href="{{route('pais.index')}}" class="btn bg-blue-grey waves-effect">
                                        <div><span>JUNTAS DE IGLESIA</span><span class="ink animate"></span></div>
                                    </a>
                                </div>
                            </div>
                            <div role="tabpanel" class="tab-pane animated flipInX" id="feligresia_animation_1">
                                <b>FELIGRESÍA</b>
                                <br/><br/>
                                <div class="button-demo">
                                    <a href="{{route('pais.index')}}" class="btn bg-deep-orange waves-effect">
                                        <div><span>PASTORES</span><span class="ink animate"></span></div>
                                    </a>
                                    <a href="{{route('pais.index')}}" class="btn bg-deep-orange waves-effect">
                                        <div><span>MIEMBROS DE IGLESIA</span><span class="ink animate"></span></div>
                                    </a>
                                    <a href="{{route('pais.index')}}" class="btn bg-deep-orange waves-effect">
                                        <div><span>CATEGORÍA DE LABOR</span><span class="ink animate"></span></div>
                                    </a>
                                    <a href="{{route('pais.index')}}" class="btn bg-deep-orange waves-effect">
                                        <div><span>LABORES</span><span class="ink animate"></span></div>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection