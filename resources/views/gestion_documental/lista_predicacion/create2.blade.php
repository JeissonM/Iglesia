@extends('layouts.admin')
@section('breadcrumb')
<ol class="breadcrumb breadcrumb-bg-blue-grey" style="margin-bottom: 30px;">
    <li><a href="{{route('inicio')}}">Inicio</a></li>
    <li><a href="{{route('admin.gestiondocumental')}}">Gestión Documental</a></li>
    <li><a href="{{route('listapredicacion.index')}}">Lista de Predicación</a></li>
    <li><a href="{{route('listapredicacion.edit',$lista->id)}}">Configurar Lista</a></li>
    <li class="active"><a>Agregar Registro</a></li>
</ol>
@endsection
@section('content')
<div class="row clearfix">
    <div class="col-md-12">
        <div class="card">
            <div class="header">
                <h2>
                    CREAR LISTA DE PREDICACIÓN
                </h2>
            </div>
            <div class="body">
                <div class="col-md-12">
                    @component('layouts.errors')
                    @endcomponent
                </div>
                <h1 class="card-inside-title text-center">
                    DISTRITO: {{$distrito->nombre}} - {{$lista->periodoespecifico}}</br>
                    PERÍODO {{$lista->periodo->etiqueta}}
                </h1>
                <div class="row clearfix">
                    <div class="col-md-12">
                        <form class="form-horizontal" role='form' method="POST" action="{{route('listapredicacion.store2')}}">
                            @csrf  
                            <input type="hidden" name="listapredicacion_id" value="{{$lista->id}}" />
                            <div class="col-md-6">
                                <div class="form-group">
                                    <div class="form-line">
                                        <label>Fecha</label>
                                        <input class="form-control" type="date" required="required" name="fecha" id="fecha">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <div class="form-line">
                                        <label>Día de la Semana</label>
                                        <select class="form-control show-tick" name="diasemana" id="diasemana" required="">
                                            <option value="DOMINGO">DOMINGO</option>
                                            <option value="LUNES">LUNES</option>
                                            <option value="MARTES">MARTES</option>
                                            <option value="MIERCOLES">MIERCOLES</option>
                                            <option value="JUEVES">JUEVES</option>
                                            <option value="VIERNES">VIERNES</option>
                                            <option value="SABADO">SABADO</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <h3>PREDICADORES</h3>
                            @foreach($iglesias as $i2)
                            <div class="col-md-6">
                                <div class="form-group">
                                    <div class="form-line">
                                        <label>IGLESIA {{$i2->nombre}}</label>
                                        <input type="hidden" required="required" name="iglesia[]" value="{{$i2->id}}">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <div class="form-line">
                                        <select class="form-control show-tick select2" name="feligres[]" required="">
                                            <option value="SIN">-- SIN PREDICADOR --</option>
                                            @foreach($feligreses as $key=>$value)
                                            <option value="{{$key}}">{{$value}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                            <div class="col-md-12">
                                <div class="form-group">
                                    <br/><br/><a href="{{route('listapredicacion.edit',$lista->id)}}" class="btn bg-red waves-effect">Cancelar</a>
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
@endsection
@section('script')
<script>
    $('.select2').select2();
</script>
@endsection