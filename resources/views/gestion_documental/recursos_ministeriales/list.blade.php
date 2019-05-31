@extends('layouts.admin')
@section('breadcrumb')
<ol class="breadcrumb breadcrumb-bg-blue-grey" style="margin-bottom: 30px;">
    <li><a href="{{route('inicio')}}">Inicio</a></li>
    <li><a href="{{route('admin.gestiondocumental')}}">Gestión Documental</a></li>
    <li class="active"><a>Recursos Ministeriales</a></li>
</ol>
@endsection
@section('content')
<div class="row clearfix">
    <div class="col-md-12">
        <div class="card">
            <div class="header">
                <h2>
                    RECURSOS MINISTERIALES<small>Haga clic en el botón de 3 puntos de la derecha de este título para agregar un nuevo registro.</small>
                </h2>
                <ul class="header-dropdown m-r--5">
                    <li class="dropdown">
                        <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                            <i class="material-icons">more_vert</i>
                        </a>
                        <ul class="dropdown-menu pull-right">
                            <li><a data-toggle="modal" data-target="#mdModal2">Agregar Nuevo Recurso</a></li>
                            <li><a data-toggle="modal" data-target="#mdModal">Ayuda</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
            <div class="body">
                <div class="table-responsive">
                    <table id="tabla" class="table table-bordered table-striped table-hover table-responsive table-condensed dataTable js-exportable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>RECURSO</th>
                                <th>DESCRIPCIÓN</th>
                                <th>ÍTEMS</th>
                                <th>ACCIONES</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($recursos as $r)
                            <tr>
                                <td>{{$r->nombre}}</td>
                                <td>{{$r->descripcion}}</td>
                                <td>
                                    @if(count($r->recursosministerialitems)>0)
                                    <ul>
                                        @foreach($r->recursosministerialitems as $i)
                                        <li><a href="{{asset('docs/recursos/'.$i->recurso)}}" target="_blank">{{$i->recurso}}</a></li>
                                        @endforeach
                                    </ul>
                                    @else
                                    ---
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('recursosministeriales.edit',$r->id)}}" class="btn bg-indigo waves-effect btn-xs" data-toggle="tooltip" data-placement="top" title="Editar Documentos"><i class="material-icons">mode_edit</i></a>
                                    <a href="{{ route('recursosministeriales.delete',$r->id)}}" class="btn bg-red waves-effect btn-xs" data-toggle="tooltip" data-placement="top" title="Eliminar Recurso"><i class="material-icons">delete</i></a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Modal -->
<div class="modal fade" id="mdModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content modal-col-blue">
            <div class="modal-header">
                <h4 class="modal-title" id="defaultModalLabel">SOBRE LOS RECURSOS MINISTERIALES</h4>
            </div>
            <div class="modal-body">
                <strong>Detalles: </strong>Cree y administre los recursos ministeriales, todo miembro de junta directiva que tenga un ministerio a cargo podrá colgar recursos y materiales para el trabajo en dicho ministerio. Estos materiales serán visibles y descargables desde la web pública.
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-link waves-effect" data-dismiss="modal">ACEPTAR</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="mdModal2" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content modal-col-blue">
            <div class="modal-header">
                <h4 class="modal-title" id="defaultModalLabel">SELECCIONE PERÍODO</h4>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <div class="form-line">
                        <select class="form-control show-tick select2" name="periodo_id" id="p" required="">
                            @foreach($periodos as $key=>$value)
                            <option value="{{$key}}">{{$value}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-link waves-effect" data-dismiss="modal">CANCELAR</button>
                <button type="button" class="btn btn-link waves-effect" onclick="continuar()">CONTINUAR</button>
            </div>
        </div>
    </div>
</div>
@endsection
@section('script')
<script type="text/javascript">
    $(document).ready(function () {
    });

    function continuar() {
        location.href = url + "gestiondocumental/recursosministeriales/" + $("#p").val() + "/create";
    }
</script>
@endsection