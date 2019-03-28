@extends('layouts.admin')
@section('breadcrumb')
<ol class="breadcrumb breadcrumb-bg-blue-grey" style="margin-bottom: 30px;">
    <li><a href="{{route('inicio')}}">Inicio</a></li>
    <li><a href="{{route('admin.feligresia')}}">Feligresía</a></li>
    <li><a href="{{route('admin.feligresia')}}">Estructura Eclesiástica</a></li>
    <li><a href="{{route('iglesia.index')}}">Iglesias</a></li>
    <li class="active"><a>Editar Iglesias</a></li>
</ol>
@endsection
@section('content')
<div class="row clearfix">
    <div class="col-md-12">
        <div class="card">
            <div class="header">
                <h2>
                    GESTIÓN DE LAS IGLESIAS - EDITAR UNA IGLESIA<small>Haga clic en el botón de 3 puntos de la derecha de este título para obtener ayuda.</small>
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
                <h1 class="card-inside-title">DATOS DE LA IGLESIA: {{$iglesia->nombre}}</h1>
                <div class="row clearfix">
                    <div class="col-md-12">
                        <form class="form-horizontal" role='form' method="POST" action="{{route('iglesia.update',$iglesia->id)}}">
                            @csrf 
                            <input name="_method" type="hidden" value="PUT" /> 
                            <div class="col-md-6">
                                <div class="form-group">
                                    <div class="form-line">
                                        <br/><input class="form-control" type="text" placeholder="Nombre oficial de la iglesia" required="required" name="nombre" value="{{$iglesia->nombre}}"/>    
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="form-line">
                                        <br/><input class="form-control" type="text" placeholder="Descripción de la iglesia" name="descripcion" value="{{$iglesia->descripcion}}"/>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="form-line">
                                        <label class="control-label">Ciudad de Ubicación</label>
                                        <select class="form-control  select2"  style="width: 100%;" required="required" name="ciudad_id"/>
                                        @foreach($ciudades as $key=>$value)
                                        @if($iglesia->ciudad_id == $key)
                                        <option value="{{$key}}" selected>{{$value}}</option>
                                        @else
                                        <option value="{{$key}}">{{$value}}</option>
                                        @endif
                                        @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="form-line">
                                        <br/><input class="form-control" type="text" placeholder="Dirección de ubicación de la iglesia" name="ubicacion" value="{{$iglesia->ubicacion}}"/>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="form-line">
                                        <br/><input class="form-control" type="email" placeholder="Dirección de correo de la iglesia" name="email" value="{{$iglesia->email}}"/>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <div class="form-line">
                                        <br/><input class="form-control" type="text" placeholder="Sitio web oficial de la iglesia" name="sitioweb" value="{{$iglesia->sitioweb}}"/>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="form-line">
                                        <label class="control-label">Fecha de Fundación</label>
                                        <input type="date" name="fundacion" class="form-control" value="{{$iglesia->fundacion}}"/>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="form-line">
                                        <label class="control-label">Tipo</label>
                                        <select class="form-control"  style="width: 100%;" name="tipo"/>
                                        @if($iglesia->tipo == 'IGLESIA')   
                                        <option value="IGLESIA" selected>IGLESIA</option>
                                        <option value="GRUPO">GRUPO DE IGLESIA</option>
                                        @else
                                        <option value="IGLESIA">IGLESIA</option>
                                        <option value="GRUPO" selected>GRUPO DE IGLESIA</option>
                                        @endif
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="form-line">
                                        <label class="control-label">Estado Actual la Iglesia</label>
                                        <select class="form-control"  style="width: 100%;" name="activa"/> 
                                        @if($iglesia->activa == 1)
                                        <option value="1" selected>ACTIVA</option>    
                                        <option value="0">INACTIVA</option>
                                        @else
                                        <option value="1">ACTIVA</option>    
                                        <option value="0" selected>INACTIVA</option>
                                        @endif
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="form-line">
                                        <label class="control-label">Zona</label>
                                        <select class="form-control  select2"  style="width: 100%;" name="zona_id"/>
                                        <option value=""></option>
                                        @foreach($zonas as $key=>$value)
                                        @if($iglesia->zona_id == $key)
                                        <option value="{{$key}}" selected>{{$value}}</option>
                                        @else
                                        <option value="{{$key}}">{{$value}}</option>
                                        @endif
                                        @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <div class="form-line">
                                        <label class="control-label">Distrito</label>
                                        <select class="form-control  select2"  style="width: 100%;" required="required" name="distrito_id"/>
                                        @foreach($distritos as $key=>$value)
                                        @if($iglesia->distrito_id == $key)
                                        <option value="{{$key}}" selected>{{$value}}</option>
                                        @else
                                        <option value="{{$key}}">{{$value}}</option>
                                        @endif
                                        @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <br/><br/><a href="{{route('iglesia.index')}}" class="btn bg-red waves-effect">Cancelar</a>
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
                <h4 class="modal-title" id="defaultModalLabel">SOBRE LAS IGLESIAS</h4>
            </div>
            <div class="modal-body">
                <strong>Edite los datos de la iglesia.</strong> Las iglesias representan las congregaciones locales de miembros y sus templos. Las iglesias están clasificadas en IGLESIA si es capaz de auto sostenerse en liderazgo, logística, etc. Y en GRUPO que son pequeñas congregaciones asistidas por un distrito y que en materia de sostenibilidad dependen de la asociación/misión a la que pertenece.
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
    $(".chosen-select").chosen({});
</script>
@endsection