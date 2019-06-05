@extends('layouts.admin')
@section('breadcrumb')
<ol class="breadcrumb breadcrumb-bg-blue-grey" style="margin-bottom: 30px;">
    <li><a href="{{route('inicio')}}">Inicio</a></li>
    <li><a href="{{route('admin.comunicacion')}}">Comunicaciones</a></li>
    <li class="active"><a href="{{route('iglesiamapa.index')}}">Encuentre una Iglesia - Gestión</a></li>
    <li class="active"><a>Crear Mapa</a></li>
</ol>
@endsection
@section('content')
<div class="row clearfix">
    <div class="col-md-12">
        <div class="card">
            <div class="header">
                <h2>
                    ENCUENTRE UNA IGLESIA - GESTIÓN<small>Haga clic en el botón de 3 puntos de la derecha de este título para obtener ayuda.</small>
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
                <h1 class="card-inside-title">DATOS DEL MAPA</h1>
                <div class="row clearfix">
                    <div class="col-md-12">
                        <form id="form" class="form-horizontal" role='form' method="POST" action="{{route('iglesiamapa.store')}}" enctype= "multipart/form-data">
                            @csrf 
                            <input type="hidden" name="iglesia_id" id="iglesia_id" />
                            <div class="col-md-12">
                                <div class="form-group">
                                    <div class="form-line">
                                        <label class="control-label">Teléfono de Contácto (Opcional)</label>
                                        <input type="text" class="form-control" name="telefonocontacto" />     
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <div class="form-line">
                                        <label class="control-label">Código HTML del Mapa (Opcional)</label>
                                        <input type="text" class="form-control" name="mapa" />     
                                    </div>
                                </div>
                            </div>
                            <h4>Seleccione la Iglesia y Presione Agregar</h4>
                            <div class="table-responsive">
                                <table id="tabla" class="table table-bordered table-striped table-hover table-responsive table-condensed dataTable js-exportable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>IGLESIA - DISTRITO - ASOCIACIÓN</th>
                                            <th>DIRECCIÓN</th>
                                            <th>CIUDAD</th>
                                            <th>AGREGAR</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($iglesias as $i)
                                        <tr>
                                            <td>{{$i->nombre." - ".$i->distrito->nombre." - ".$i->distrito->asociacion->nombre}}</td>
                                            <td>{{$i->ubicacion}}</td>
                                            <td>{{$i->ciudad->nombre}}</td>
                                            <td>
                                                <a class="btn bg-indigo waves-effect btn-xs" data-toggle="tooltip" data-placement="top" title="AGREGAR" id="{{$i->id}}" onclick="poner(this.id)"><i class="material-icons">arrow_right</i> AGREGAR</a>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
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
                <h4 class="modal-title" id="defaultModalLabel">SOBRE ENCUENTRE UNA IGLESIA</h4>
            </div>
            <div class="modal-body">
                <strong>Detalles: </strong>Las personas y feligreses deben poder encontrar una iglesia en el sitio web público a partir de una ciudad determinada. En este módulo se debe configurar la ubicación en el mapa y teléfono de contácto de cada iglesia para permitir la busqueda. <br>
                <b>Para agregar un nuevo mapa a una iglesia</b> debe seleccionar una iglesia de la lista, definir un número de teléfono de contácto para las personas en la red y por último debe ir a google maps, verificar que la iglesia que quiere establecer en el mapa exista en google map y tenga su marcador, de no ser así, debe a través de una cuenta de google agregar al servicio de google maps la iglesia y una vez exista la iglesia en el mapa debe seleccionar el marcador y darle a compartir. En el dialogo modal de compartir, debe seleccionar la opción incorporar un mapa y copiar el código html que genera la operación, ese código copiado debe ser pegado en el campo indicado de éste formulario.
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

    function poner(id) {
        $("#iglesia_id").val(id);
        $("#form").submit();
    }
</script>
@endsection