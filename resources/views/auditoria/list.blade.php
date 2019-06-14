@extends('layouts.admin')
@section('breadcrumb')
<ol class="breadcrumb breadcrumb-bg-blue-grey" style="margin-bottom: 30px;">
    <li><a href="{{route('inicio')}}">Inicio</a></li>
    <li><a href="{{route('admin.auditoria')}}">Auditoría</a></li>
    <li class="active"><a>Auditoría {{$modulo}}</a></li>
</ol>
@endsection
@section('content')
<div class="row clearfix">
    <div class="col-md-12">
        <div class="card">
            <div class="header">
                <h2>
                    AUDITORÍA {{$modulo}}
                </h2>
            </div>
            <div class="body" id="imprimir">
                <div class="row">
                    <div class="col-md-12">
                        <h4>Exportar</h4>
                        <div class="col-md-12">
                            <a class="btn bg-red waves-effect" onclick="printDiv('imprimir')">
                                <div><span>PDF</span><span class="ink animate"></span></div>
                            </a>
                            <a class="btn bg-blue-grey waves-effect" onclick="txt()">
                                <div><span>TXT</span><span class="ink animate"></span></div>
                            </a>
                        </div>
                        <h4>Filtrar Consulta</h4>
                        <div class="col-md-12">
                            <form class="form-horizontal" role='form' method="POST" action="{{route('auditoria.filtro')}}">
                                @csrf 
                                <input type="hidden" name="modulo" value="{{$modulo}}" />
                                <div class="col-md-5">
                                    <div class="form-group">
                                        <div class="form-line">
                                            <label class="control-label">Fecha Inicial</label>
                                            <input type="date" required="" value="{{$f1}}" class="form-control show-tick" name="f1" id="f1" />
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-5">
                                    <div class="form-group">
                                        <div class="form-line">
                                            <label class="control-label">Fecha Final</label>
                                            <input type="date" required="" value="{{$f2}}" class="form-control show-tick" name="f2" id="f2" />
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <button class="btn bg-green btn-lg btn-block waves-effect" type="submit">Consultar</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <h4>Log</h4>
                        <div class="col-md-12">                            
                            <ul class="list-group">
                                @if($data!=null)
                                @if(count($data)>0)
                                @foreach($data as $d)
                                <li class="list-group-item" style="background-color: #747474 !important; color: #FFFFFF; font-weight: bold;">
                                    USUARIO {{$d->usuario}}<br>
                                    OPERACIÓN: {{$d->operacion}}<br>
                                    FECHA: {{$d->created_at}}<br>
                                    DETALLES: {{$d->detalles}}
                                </li>
                                @endforeach
                                @else
                                <li class="list-group-item list-group-bg-red">No hay resultados para el filtro indicado!</li>
                                @endif
                                @else
                                <li class="list-group-item list-group-bg-red">No hay resultados para el filtro indicado!</li>
                                @endif
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('script')
<script type="text/javascript">
    $(document).ready(function () {
    });

    function txt() {
        var f1 = $("#f1").val();
        var f2 = $("#f2").val();
        if (f1.length == 0) {
            f1 = "NO";
            f2 = "NO";
        }
        location.href = url + "auditoria/menu/index/filtro/consultar/{{$modulo}}/" + f1 + "/" + f2 + "/txt";
    }

    function printDiv(nombreDiv) {
        var contenido = document.getElementById(nombreDiv).innerHTML;
        var contenidoOriginal = document.body.innerHTML;
        document.body.innerHTML = contenido;
        window.print();
        document.body.innerHTML = contenidoOriginal;
    }
</script>
@endsection