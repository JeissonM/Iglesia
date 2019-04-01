@extends('layouts.admin')
@section('breadcrumb')
<ol class="breadcrumb breadcrumb-bg-blue-grey" style="margin-bottom: 30px;">
    <li><a href="{{route('inicio')}}">Inicio</a></li>
    <li><a href="{{route('admin.feligresia')}}">Feligresía</a></li>
    <li><a href="{{route('admin.feligresia')}}">Feligresía</a></li>
    <li><a href="{{route('feligres.index')}}">Miembros de Iglesia</a></li>
    <li class="active"><a>Crear Feligrés</a></li>
</ol>
@endsection
@section('content')
<div class="row clearfix">
    <div class="col-md-12">
        <div class="card">
            <div class="header">
                <h2>
                    MIEMBROS DE IGLESIA - CREAR FELIGRÉS<small>Haga clic en el botón de 3 puntos de la derecha de este título para obtener ayuda.</small>
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
                <h1 class="card-inside-title">DATOS DEL MIEMBRO</h1>
                <h4>Los campos con asterísco (*) son obligatorios</h4>
                <div class="row clearfix">
                    <div class="col-md-12">
                        <form class="form-horizontal" role='form' method="POST" action="{{route('feligres.store')}}">
                            @csrf 
                            <div id="wizard_vertical">
                                <h2>Información Personal</h2>
                                <section>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <div class="form-line">
                                                <label class="control-label">Tipo Documento*</label>
                                                <select class="form-control"  style="width: 100%;" required="required" name="tipodocumento_id">
                                                    @foreach($tipodoc as $key=>$value)
                                                    <option value="{{$key}}">{{$value}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="form-line">
                                                <br/><input class="form-control" type="text" placeholder="Lugar de Expedición" name="lugar_expedicion">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="form-line">
                                                <br/><input class="form-control" type="text" placeholder="Primer Nombre*" required="required" name="primer_nombre">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="form-line">
                                                <br/><input class="form-control" type="text" placeholder="Primer Apellido*" required="required" name="primer_apellido">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="form-line">
                                                <label class="control-label">Sexo*</label>
                                                <select class="form-control"  style="width: 100%;" required="required" name="sexo">
                                                    <option value="M">MASCULINO</option>
                                                    <option value="F">FEMENINO</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="form-line">
                                                <label class="control-label">Estado Civil</label>
                                                <select class="form-control"  style="width: 100%;" name="estadocivil_id">
                                                    @foreach($estadosc as $key=>$value)
                                                    <option value="{{$key}}">{{$value}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <div class="form-line">
                                                <br/><input class="form-control" type="text" placeholder="Escriba el número del documento de identidad*" required="required" name="numero_documento">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="form-line">
                                                <br/><label>Fecha de Expedición</label>
                                                <input class="form-control" type="date" placeholder="Fecha de Expedición" name="fecha_expedicion">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="form-line">
                                                <br/><input class="form-control" type="text" placeholder="Segundo Nombre" name="segundo_nombre">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="form-line">
                                                <br/><input class="form-control" type="text" placeholder="Segundo Apellido" name="segundo_apellido">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="form-line">
                                                <label class="control-label">Tipo Sanguíneo y RH</label>
                                                <select class="form-control"  style="width: 100%;" name="rh">
                                                    <option value="A+">A +</option>
                                                    <option value="A-">A -</option>
                                                    <option value="O+">O +</option>
                                                    <option value="O-">O -</option>
                                                    <option value="B-">B -</option>
                                                    <option value="B+">B +</option>
                                                    <option value="AB+">AB +</option>
                                                    <option value="AB-">AB -</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </section>
                                <h2>Información De Procedencia</h2>
                                <section>

                                </section>
                                <h2>Información de Residencia y Ubicación</h2>
                                <section>

                                </section>
                                <h2>Información Familiar</h2>
                                <section>

                                </section>
                                <h2>Información Académica y Profesional</h2>
                                <section>
                                    <p>
                                        Donec mi sapien, hendrerit nec egestas a, rutrum vitae dolor. Nullam venenatis diam ac
                                        ligula elementum pellentesque. In lobortis sollicitudin felis non eleifend. Morbi
                                        tristique tellus est, sed tempor elit. Morbi varius, nulla quis condimentum dictum,
                                        nisi elit condimentum magna, nec venenatis urna quam in nisi. Integer hendrerit sapien
                                        a diam adipiscing consectetur. In euismod augue ullamcorper leo dignissim quis elementum
                                        arcu porta. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vestibulum leo
                                        velit, blandit ac tempor nec, ultrices id diam. Donec metus lacus, rhoncus sagittis
                                        iaculis nec, malesuada a diam. Donec non pulvinar urna. Aliquam id velit lacus.
                                    </p>
                                </section>
                                <h2>Información de Bautismo</h2>
                                <section>
                                    <p>
                                        Morbi ornare tellus at elit ultrices id dignissim lorem elementum. Sed eget nisl at justo
                                        condimentum dapibus. Fusce eros justo, pellentesque non euismod ac, rutrum sed quam.
                                        Ut non mi tortor. Vestibulum eleifend varius ullamcorper. Aliquam erat volutpat.
                                        Donec diam massa, porta vel dictum sit amet, iaculis ac massa. Sed elementum dui
                                        commodo lectus sollicitudin in auctor mauris venenatis.
                                    </p>
                                </section>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <br/><br/><a href="{{route('feligres.index')}}" class="btn bg-red waves-effect">Cancelar</a>
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
        <div class="modal-content modal-col-orange">
            <div class="modal-header">
                <h4 class="modal-title" id="defaultModalLabel">SOBRE LOS MIEMBROS DE IGLESIA</h4>
            </div>
            <div class="modal-body">
                <strong>Agregue nuevos feligreses,</strong> son todos los miembros bautizados y registrados en el libro de secretaría de iglesia.
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-link waves-effect" data-dismiss="modal">ACEPTAR</button>
            </div>
        </div>
    </div>
</div>
@endsection