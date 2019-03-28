@extends('layouts.admin')
@section('breadcrumb')
<ol class="breadcrumb breadcrumb-bg-blue-grey" style="margin-bottom: 30px;">
    <li><a href="{{route('inicio')}}">Inicio</a></li>
    <li><a href="{{route('admin.feligresia')}}">Feligresía</a></li>
    <li><a href="{{route('admin.feligresia')}}">Estructura Eclesiástica</a></li>
    <li><a href="{{route('periodo.index')}}">Períodos</a></li>
    <li class="active"><a>Crear Período</a></li>
</ol>
@endsection
@section('content')
<div class="row clearfix">
    <div class="col-md-12">
        <div class="card">
            <div class="header">
                <h2>
                    GESTIÓN DE LOS PERÍODOS - CREAR UN NUEVO PERÍODO<small>Haga clic en el botón de 3 puntos de la derecha de este título para obtener ayuda.</small>
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
                <h1 class="card-inside-title">DATOS DEL PERÍODO</h1>
                <div class="row clearfix">
                    <div class="col-md-12">
                        <form class="form-horizontal" role='form' method="POST" action="{{route('periodo.store')}}">
                            @csrf 
                            <div class="col-md-12">
                                <div class="form-group">
                                    <div class="form-line">
                                        <br/><input class="form-control" type="text" placeholder="Nombre, Identificador o Etiqueta del Período" required="required" name="etiqueta">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="form-line">
                                        <br/><label>Fecha Inicial del Período</label>
                                        <input class="form-control" type="date" placeholder="Fecha Inicial del Período" name="fechainicio">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="form-line">
                                        <br/><label>Fecha Final del Período</label>
                                        <input class="form-control" type="date" placeholder="Fecha Final del Período" name="fechafin">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <br/><br/><a href="{{route('periodo.index')}}" class="btn bg-red waves-effect">Cancelar</a>
                                    <button class="btn bg-indigo waves-effect" type="reset">Limpiar Formulario</button>
                                    <button class="btn bg-green waves-effect" type="submit">Guardar</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Modal -->
<div class="modal fade" id="mdModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content modal-col-green">
            <div class="modal-header">
                <h4 class="modal-title" id="defaultModalLabel">SOBRE LOS PERÍODOS</h4>
            </div>
            <div class="modal-body">
                <strong>Agregue nuevos períodos,  la etiqueta hace referencia al nombre o identificador del período, ejemplo: PERÍODO 2018-2019. </strong> Gestione la información de los períodos eclesiásticos, éstos son los rangos de fecha que cubre por lo general un año de servicio a la iglesia por parte de una junta directiva.
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-link waves-effect" data-dismiss="modal">ACEPTAR</button>
            </div>
        </div>
    </div>
</div>
@endsection
@section('script')
<script>
    $('.select2').select2();
</script>
@endsection