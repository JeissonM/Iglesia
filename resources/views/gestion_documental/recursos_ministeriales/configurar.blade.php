@extends('layouts.admin')
@section('breadcrumb')
<ol class="breadcrumb breadcrumb-bg-blue-grey" style="margin-bottom: 30px;">
    <li><a href="{{route('inicio')}}">Inicio</a></li>
    <li><a href="{{route('admin.gestiondocumental')}}">Gestión Documental</a></li>
    <li><a href="{{route('listapredicacion.index')}}">Lista de Predicación</a></li>
    <li class="active"><a>Configurar Lista</a></li>
</ol>
@endsection
@section('content')
<div class="row clearfix">
    <div class="col-md-12">
        <div class="card">
            <div class="header">
                <h2>
                    CREAR LISTA DE PREDICACIÓN<small>Haga clic en el botón de 3 puntos de la derecha de este título para obtener ayuda.</small>
                </h2>
                <ul class="header-dropdown m-r--5">
                    <li class="dropdown">
                        <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                            <i class="material-icons">more_vert</i>
                        </a>
                        <ul class="dropdown-menu pull-right">
                            <li><a href="{{ route('listapredicacion.crear2',$lista->id) }}">Agregar Nuevo Registro</a></li>
                            <li><a onclick="javascript:printDiv('imprimir')">Imprimir Lista</a></li>
                            <li><a data-toggle="modal" data-target="#mdModal">Ayuda</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
            <div class="body" id="imprimir">
                <div class="col-md-12">
                    @component('layouts.errors')
                    @endcomponent
                </div>
                <h3 class="card-inside-title text-center">
                    DISTRITO: {{$distrito->nombre}} - {{$lista->periodoespecifico}}</br>
                    {{$lista->periodo->etiqueta}}
                </h3>
                <div class="row clearfix">
                    <div class="col-md-12">
                        <div class="table-responsive">
                            <table style="font-size: 12px" id="tabla11" class="table table-bordered table-striped table-hover table-responsive table-condensed" width="100%" cellspacing="0">
                                {!!$tabla!!}
                            </table>
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
        <div class="modal-content modal-col-blue">
            <div class="modal-header">
                <h4 class="modal-title" id="defaultModalLabel">SOBRE LAS LISTAS DE PREDICACIÓN</h4>
            </div>
            <div class="modal-body">
                <strong>Configurar lista: </strong>Agregue tantos predicadores y fechas como necesite configurar.
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

    function printDiv(nombreDiv) {
        ocultarColumna();
        var contenido = document.getElementById(nombreDiv).innerHTML;
        var contenidoOriginal = document.body.innerHTML;
        document.body.innerHTML = contenido;
        window.print();
        document.body.innerHTML = contenidoOriginal;
    }

    function ocultarColumna() {
        var index = "{{$index}}";
        $("#tabla11 tbody tr").each(function () {
            $(this).find("td:eq(" + index + ")").remove();
        });
        $("#tabla11 thead tr").each(function () {
            $(this).find("th:eq(" + index + ")").remove();
        });
    }

</script>
@endsection