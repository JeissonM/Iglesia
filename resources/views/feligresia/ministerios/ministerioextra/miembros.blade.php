@extends('layouts.admin')
@section('breadcrumb')
<ol class="breadcrumb breadcrumb-bg-blue-grey" style="margin-bottom: 30px;">
    <li><a href="{{route('inicio')}}">Inicio</a></li>
    <li><a href="{{route('admin.feligresia')}}">Feligresía</a></li>
    <li><a href="{{route('admin.feligresia')}}">Ministerios</a></li>
    <li><a href="{{route('ministerioextra.index')}}"> Ministerios Extra-Oficiales</a></li>
    <li class="active"><a>Miembros del Ministerio</a></li>
</ol>
@endsection
@section('content')
<div class="row clearfix">
    <div class="col-md-12">
        <div class="card">
            <div class="header">
                <h2>
                    GESTIÓN DE MINISTERIOS EXTRA-OFICIALES - MIEMBROS
                </h2>
            </div>
            <div class="body">
                <div class="col-md-12">
                    @component('layouts.errors')
                    @endcomponent
                </div>
                <h1 class="card-inside-title">DATOS DEL MINISTERIO</h1>
                <div class="col-md-12">
                    <table class="table table-hover">
                        <tbody>
                            <tr class="read">
                                <td class="contact"><b>MINISTERIO</b></td>
                                <td class="contact"><b>TIPO MINISTERIO</b></td>
                            </tr>
                            <tr class="read">
                                <td class="contact">{{$m->nombre}}</td>
                                <td class="subject">{{$m->tipoministerio->nombre}}</td>
                            </tr>
                            <tr class="read">
                                <td class="contact"><b>DESCRIPCIÓN</b></td>
                                <td class="contact"><b>CREACIÓN</b></td>
                            </tr>
                            <tr class="read">
                                <td class="contact">{{$m->descripcion}}</td>
                                <td class="subject">{{$m->created_at}}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <h1 class="card-inside-title">AGREGAR MIEMBRO</h1>
                <div class="col-md-12">
                    <form class="form-horizontal" method="POST" action="{{route('ministerioextra.miembroscrear')}}">
                        @csrf
                        <input type="hidden" name="ministerioextra_id" value="{{$m->id}}" />
                        <div class="col-md-6">
                            <div class="form-group">
                                <div class="form-line">
                                    <br/><input type="text" class="form-control" placeholder="Escriba la función del miembro" name="funcion" required="required" />
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <div class="form-line">
                                    <br/><input type="text" class="form-control" placeholder="Escriba la identificación del miembro" name="feligres" required="required" />
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <button class="btn bg-green waves-effect" type="submit">Guardar</button>
                            </div>
                        </div>
                    </form>
                </div>
                <h1 class="card-inside-title">LISTA DE MIEMBROS</h1>
                <div class="table-responsive">
                    <table id="tabla" class="table table-bordered table-striped table-hover table-responsive table-condensed dataTable js-exportable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>IDENTIFICACIÓN</th>
                                <th>MIEMBRO</th>
                                <th>CARGO/FUNCIÓN</th>
                                <th>RETIRAR</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(count($m->ministerionooficialmiembros)>0)
                            @foreach($m->ministerionooficialmiembros as $i)
                            <tr>
                                <td>{{$i->feligres->personanatural->persona->numero_documento}}</td>
                                <td>{{$i->feligres->personanatural->primer_nombre." ".$i->feligres->personanatural->segundo_nombre." ".$i->feligres->personanatural->primer_apellido." ".$i->feligres->personanatural->segundo_apellido}}</td>
                                <td>{{$i->funcion}}</td>
                                <td>
                                    <a href="{{ route('ministerioextra.delete2',[$i->ministerioextra_id,$i->id])}}" class="btn bg-red waves-effect btn-xs" data-toggle="tooltip" data-placement="top" title="Eliminar Miembro"><i class="material-icons">delete</i></a>
                                </td>
                            </tr>
                            @endforeach
                            @endif
                        </tbody>
                    </table>
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