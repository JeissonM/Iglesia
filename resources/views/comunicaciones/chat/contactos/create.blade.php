@extends('layouts.admin')
@section('breadcrumb')
<ol class="breadcrumb breadcrumb-bg-blue-grey" style="margin-bottom: 30px;">
    <li><a href="{{route('inicio')}}">Inicio</a></li>
    <li><a href="{{route('admin.comunicacion')}}">Comunicaciones</a></li>
    <li class="active"><a href="{{route('contacto.index')}}">Contactos</a></li>
    <li class="active"><a>Agregar Contacto</a></li>
</ol>
@endsection
@section('content')
<div class="row clearfix">
    <div class="col-md-12">
        <div class="card">
            <div class="header">
                <h2>
                    AGREGRAR UN CONTACTO<small>Haga clic en el botón de 3 puntos de la derecha de este título para obtener ayuda.</small>
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
                <h1 class="card-inside-title">DATOS DEL CONTACTO</h1>
                <div class="row clearfix">
                    <div class="col-md-12">
                        <form id="form" class="form-horizontal" role='form' method="POST" action="{{route('contacto.store')}}" enctype= "multipart/form-data">
                            @csrf 
                            <input type="hidden" name="feligres_id" id="feligres_id" />
                            <h4>Seleccione el Contacto y Presione Agregar</h4>
                            <div class="table-responsive">
                                <table id="tabla" class="table table-bordered table-striped table-hover table-responsive table-condensed dataTable js-exportable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>NOMBRE</th>
                                            <th>IGLESIA - DISTRITO - ASOCIACIÓN</th>
                                            <th>CIUDAD</th>
                                            <th>AGREGAR</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($feligres as $i)
                                        <tr>
                                            <td>{{$i->name}}</td>
                                            <td>{{$i->igle."-".$i->dist."-".$i->asoci}}</td>
                                            <td>{{$i->ciu}}</td>
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
                <h4 class="modal-title" id="defaultModalLabel">SOBRE AGREGAR UN CONTACTO</h4>
            </div>
            <div class="modal-body">
                <strong>Detalles: </strong>Debe hacer clic en la opción agregar frente al contacto que desea guardar en su lista.
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
        $("#feligres_id").val(id);
        $("#form").submit();
    }
</script>
@endsection