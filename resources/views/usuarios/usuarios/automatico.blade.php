@extends('layouts.admin')
@section('breadcrumb')
<ol class="breadcrumb breadcrumb-bg-blue-grey" style="margin-bottom: 30px;">
    <li><a href="{{route('inicio')}}">Inicio</a></li>
    <li><a href="{{route('admin.usuarios')}}">Usuarios</a></li>
    <li class="active"><a>Crear Usuario (Proceso masivo)</a></li>
</ol>
@endsection
@section('content')
<div class="row clearfix">
    <div class="col-md-12">
        <div class="card">
            <div class="header">
                <h2>
                    USUARIOS DEL SISTEMA - CREAR USUARIO PROCESO MASIVO
                </h2>
            </div>
            <div class="body">
                <div class="col-md-12">
                    @component('layouts.errors')
                    @endcomponent
                </div>
                <div class="row clearfix">
                    <div class="col-md-12">
                        <h1 class="card-inside-title">SELECCIONE UNA IGLESIA Y SE PROCEDERÁ A GENERAR USUARIOS PARA TODOS LOS MIEMBROS DE LA IGLESIA QUE NO TENGAN USUARIOS DE SISTEMA. LA CONTRASEÑA SERÁ INICIALMENTE 00000000 (8 CEROS) Y EL USUARIO SERÁ LA IDENTIFICACIÓN.</h1>
                        <p><strong>Tenga en cuenta: </strong> Este proceso puede tardar varios minutos, la pagina parecerá no estar haciendo nada. Tenga paciencia y no cierre la página, no retroceda, no actualice la pagina ni realice otra operación mientras el proceso es llevado a cabo. Una vez de clic en el boton, el proceso dara inicio y generará usuarios para todos los miembros de la iglesia indicada.</p>
                        <form class="form-horizontal" method="POST" action="{{route('usuario.automaticostore')}}">
                            @csrf
                            <div class="col-md-6">
                                <div class="form-group">
                                    <div class="form-line">
                                        <label class="control-label">Asociación</label>
                                        <select class="form-control"  style="width: 100%;" id="asociacion_destino" name="asociacion_destino" required="" onchange="getDistritos(this.id, 'distrito_destino', 'iglesia_destino')">
                                            <option value="">-- Seleccione una opción --</option>
                                            @foreach($asociaciones as $key=>$value)
                                            <option value="{{$key}}">{{$value}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <div class="form-line">
                                        <label class="control-label">Distrito</label>
                                        <select class="form-control"  style="width: 100%;" id="distrito_destino" name="distrito_destino" required="" onchange="getIglesias(this.id, 'iglesia_destino')"></select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <div class="form-line">
                                        <label class="control-label">Iglesia/Grupo</label>
                                        <select class="form-control"  style="width: 100%;" id="iglesia_destino" name="iglesia_destino" required=""></select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <div class="form-line">
                                        <label class="control-label">Escoja el rol para los usuarios</label>
                                        <select class="form-control"  style="width: 100%;" name="rol" required="">
                                            <option value="">-- Seleccione una opción --</option>
                                            @foreach($roles as $key=>$value)
                                            <option value="{{$key}}">{{$value}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <br/><br/><a href="{{route('admin.usuarios')}}" class="btn bg-red waves-effect">Cancelar</a>
                                    <button class="btn bg-indigo waves-effect" type="reset">Limpiar Formulario</button>
                                    <button class="btn bg-green waves-effect" type="submit">Procesar</button>
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

    function getDistritos(name, distrito, iglesia) {
        var id = $("#" + name).val();
        $.ajax({
            type: 'GET',
            url: url + "feligresia/asociacion/" + id + "/distritos",
            data: {},
        }).done(function (msg) {
            $('#' + distrito + ' option').each(function () {
                $(this).remove();
            });
            $('#' + iglesia + ' option').each(function () {
                $(this).remove();
            });
            if (msg !== "null") {
                var m = JSON.parse(msg);
                $("#" + distrito).append("<option value=''>-- Seleccione una opción --</option>");
                $.each(m, function (index, item) {
                    $("#" + distrito).append("<option value='" + item.id + "'>" + item.value + "</option>");
                });
            } else {
                notify('Atención', 'La asociación seleccionada no posee información de distritos.', 'error');
            }
        });
    }

    function getIglesias(name, iglesia) {
        var id = $("#" + name).val();
        $.ajax({
            type: 'GET',
            url: url + "feligresia/distrito/" + id + "/iglesias",
            data: {},
        }).done(function (msg) {
            $('#' + iglesia + ' option').each(function () {
                $(this).remove();
            });
            if (msg !== "null") {
                var m = JSON.parse(msg);
                $("#" + iglesia).append("<option value=''>-- Seleccione una opción --</option>");
                $.each(m, function (index, item) {
                    $("#" + iglesia).append("<option value='" + item.id + "'>" + item.value + "</option>");
                });
            } else {
                notify('Atención', 'El distrito seleccionado no posee información de iglesias.', 'error');
            }
        });
    }

</script>
@endsection