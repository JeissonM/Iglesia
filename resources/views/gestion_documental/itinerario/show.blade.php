@extends('layouts.admin')
@section('breadcrumb')
<ol class="breadcrumb breadcrumb-bg-blue-grey" style="margin-bottom: 30px;">
    <li><a href="{{route('inicio')}}">Inicio</a></li>
    <li><a href="{{route('admin.gestiondocumental')}}">Gestión Documental</a></li>
    <li><a href="{{route('itinerario.index')}}">Itinerario</a></li>
    <li class="active"><a>Ver Itinerario</a></li>
</ol>
@endsection
@section('content')
<div class="row clearfix">
    <div class="col-md-12">
        <div class="card">
            <div class="header">
                <h2>
                    ITINERARIO - VER ITINERARIO<small>Haga clic en el botón de 3 puntos de la derecha de este título para imprimir el documento.</small>
                </h2>
                <ul class="header-dropdown m-r--5">
                    <li class="dropdown">
                        <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                            <i class="material-icons">more_vert</i>
                        </a>
                        <ul class="dropdown-menu pull-right">
                            <li><a onclick="imprSelec('imprimir')">Imprimir Agenda</a></li>
                            <li><a data-toggle="modal" data-target="#mdModal">Ayuda</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
            <div class="body">
                <div class="row clearfix">
                    <div class="col-md-12">
                        <div class="card" id="imprimir">
                            <div class="body bg-white">
                                <h3 style="text-align: center;">{{$itinerario->iglesia->nombre." - ".$itinerario->iglesia->distrito->nombre}}</h3>
                                <h4 style="text-align: center;">{{$itinerario->periodo->etiqueta}}</h4>
                                <h4 style="margin-top: 30px">{{$itinerario->titulo." | FECHA DEL EVENTO: ".$itinerario->fecha}}</h4>
                                <h4 style="margin-top: 30px">LISTADO DE DETALLES</h4>
                                <ol>
                                    @foreach($detalles as $d)
                                    <li>{{$d->descripcion." - (".$d->horainicial." HASTA: ".$d->horafinal.")"}}</li>
                                    @endforeach
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Modal -->
<div class="modal fade" id="mdModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content modal-col-blue-grey">
            <div class="modal-header">
                <h4 class="modal-title" id="defaultModalLabel">SOBRE LA JUNTA DIRECTIVA - GESTIÓN DE AGENDAS DE REUNIONES</h4>
            </div>
            <div class="modal-body">
                <strong>Detalles: </strong> Administre los eventos, reuniones, etc; de las iglesias para un periodo seleccionado.
                <p>Revise los detalles del evento seleccionado e imprima el documento si así lo desea.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-link waves-effect" data-dismiss="modal">ACEPTAR</button>
            </div>
        </div>
    </div>
</div>
@endsection
@section('script')
<script type="text/javascript">
    $(document).ready(function () {
        //$('#tabla').DataTable();
        $('.select2').select2();
    });

    function imprSelec(div) {
        var ficha = document.getElementById(div);
        var ventimp = window.open(' ', 'evento');
        ventimp.document.write(ficha.innerHTML);
        ventimp.document.close();
        ventimp.print();
        ventimp.close();
    }

</script>
@endsection