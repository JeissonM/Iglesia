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
                                    @if(session()->exists('PAG_PERIODOS'))
                                    <a href="{{route('periodo.index')}}" class="btn bg-green waves-effect">
                                        <div><span>PERÍODOS ECLESIÁSTICOS</span><span class="ink animate"></span></div>
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
                                    @if(session()->exists('PAG_CARGOS-IGLESIA'))
                                    <a href="{{route('cargogeneral.index')}}" class="btn bg-blue-grey waves-effect">
                                        <div><span>CARGOS DE IGLESIA</span><span class="ink animate"></span></div>
                                    </a>
                                    @endif
                                    @if(session()->exists('PAG_JUNTA-IGLESIA'))
                                    <a href="{{route('junta.index')}}" class="btn bg-blue-grey waves-effect">
                                        <div><span>JUNTAS DE IGLESIA</span><span class="ink animate"></span></div>
                                    </a>
                                    @endif
                                </div>
                            </div>
                            <div role="tabpanel" class="tab-pane animated flipInX" id="feligresia_animation_1">
                                <b>FELIGRESÍA</b>
                                <br/><br/>
                                <div class="button-demo">
                                    @if(session()->exists('PAG_TIPODOCUMENTO'))
                                    <a href="{{route('tipodoc.index')}}" class="btn bg-deep-orange waves-effect">
                                        <div><span>TIPO DE DOCUMENTO</span><span class="ink animate"></span></div>
                                    </a>
                                    @endif
                                    @if(session()->exists('PAG_ESTADOCIVIL'))
                                    <a href="{{route('estadocivil.index')}}" class="btn bg-deep-orange waves-effect">
                                        <div><span>ESTADO CIVIL</span><span class="ink animate"></span></div>
                                    </a>
                                    @endif
                                    @if(session()->exists('PAG_CATEGORIA-LABOR'))
                                    <a href="{{route('categorialabor.index')}}" class="btn bg-deep-orange waves-effect">
                                        <div><span>CATEGORÍA DE LABOR</span><span class="ink animate"></span></div>
                                    </a>
                                    @endif
                                    @if(session()->exists('PAG_LABOR'))
                                    <a href="{{route('labor.index')}}" class="btn bg-deep-orange waves-effect">
                                        <div><span>LABORES</span><span class="ink animate"></span></div>
                                    </a>
                                    @endif
                                    @if(session()->exists('PAG_PASTORES'))
                                    <a href="{{route('pastor.index')}}" class="btn bg-deep-orange waves-effect">
                                        <div><span>PASTORES</span><span class="ink animate"></span></div>
                                    </a>
                                    @endif
                                    @if(session()->exists('PAG_MIEMBROS'))
                                    <a href="{{route('feligres.index')}}" class="btn bg-deep-orange waves-effect">
                                        <div><span>MIEMBROS DE IGLESIA</span><span class="ink animate"></span></div>
                                    </a>
                                    @endif
                                    @if(session()->exists('PAG_EXPERIENCIA-FELIGRES'))
                                    <a data-toggle="modal" data-target="#consultar" class="btn bg-deep-orange waves-effect">
                                        <div><span>EXPERIENCIA</span><span class="ink animate"></span></div>
                                    </a>
                                    @endif
                                    @if(session()->exists('PAG_TRASLADOS'))
                                    <a href="{{route('solicitud.index')}}" class="btn bg-deep-orange waves-effect">
                                        <div><span>TRASLADOS</span><span class="ink animate"></span></div>
                                    </a>
                                    @endif
                                    @if(session()->exists('PAG_DISCIPLINA'))
                                    <a data-toggle="modal" data-target="#consultar2" class="btn bg-deep-orange waves-effect">
                                        <div><span>DISCIPLINA</span><span class="ink animate"></span></div>
                                    </a>
                                    @endif
                                    @if(session()->exists('PAG_SITUACION-FELIGRES'))
                                    <a href="{{route('admin.situacion')}}" class="btn bg-deep-orange waves-effect">
                                        <div><span>SITUACIÓN Y ESTADO DEL FELIGRÉS</span><span class="ink animate"></span></div>
                                    </a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Modal Consultar -->
<div class="modal fade" id="consultar" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="defaultModalLabel">GESTIONAR EXPERIENCIA</h4>
            </div>
            <div class="modal-body">
                <div class="row clearfix">
                    <form class="form-horizontal" method="POST" action="{{route('admin.operaciones')}}" name="form-privilegios" id="form-privilegios">
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
<!-- Modal Consultar2 -->
<div class="modal fade" id="consultar2" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="defaultModalLabel">APLICAR/CONSULTAR DISCIPLINA</h4>
            </div>
            <div class="modal-body">
                <div class="row clearfix">
                    <div class="form-horizontal">
                        <div class="col-md-12">
                            <div class="col-sm-8">
                                <div class="form-group">
                                    <div class="form-line">
                                        <input type="text" id="idc" class="form-control" placeholder="Escriba la identificación a consultar" name="id"/>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <button onclick="enviar()" class="btn bg-orange waves-effect btn-block">CONSULTAR FELIGRES</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-link waves-effect" data-dismiss="modal">CANCELAR</button>
            </div>
        </div>
    </div>
</div>
@endsection
@section('script')
<script type="text/javascript">
    $(document).ready(function () {

    });

    function enviar() {
        location.href = url + "feligresia/disciplina/" + $("#idc").val() + "/inicio";
    }
</script>
@endsection
