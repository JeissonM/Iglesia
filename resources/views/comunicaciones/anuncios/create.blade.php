@extends('layouts.admin')
@section('breadcrumb')
<ol class="breadcrumb breadcrumb-bg-blue-grey" style="margin-bottom: 30px;">
    <li><a href="{{route('inicio')}}">Inicio</a></li>
    <li><a href="{{route('admin.comunicacion')}}">Comunicaciones</a></li>
    <li><a href="{{route('anuncios.index')}}">Anuncios</a></li>
    <li class="active"><a>Crear</a></li>
</ol>
@endsection
@section('content')
<div class="row clearfix">
    <div class="col-md-12">
        <div class="card">
            <div class="header">
                <h2>
                    ANUNCIOS - CREAR ANUNCIOS<small>Haga clic en el botón de 3 puntos de la derecha de este título para obtener ayuda.</small>
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
                <h1 class="card-inside-title">DATOS DEL ANUNCIO</h1>
                <div class="row clearfix">
                    <div class="col-md-12">
                        <form class="form-horizontal" role='form' method="POST" action="{{route('anuncios.store')}}" enctype= "multipart/form-data">
                            @csrf 
                            <div class="col-md-4">
                                <div class="form-group">
                                    <div class="form-line">
                                        <label class="control-label">Título</label>
                                        <input type="text" class="form-control" placeholder="Título del anuncio" name="titulo" required=""/>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <div class="form-line">
                                        <label class="control-label">Alcance del Anuncio</label>
                                        <select class="form-control"  style="width: 100%;" onchange="alcance()" id="tipo" name="tipo" required="">
                                            <option value="">-- Seleccione una opción --</option>
                                            <option value="ASOCIACION">ASOCIACIÓN</option>
                                            <option value="DISTRITO">DISTRITO</option>
                                            <option value="LOCAL">IGLESIA LOCAL</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <div class="form-line">
                                        <label class="control-label">Autor</label>
                                        <select class="form-control"  style="width: 100%;" id="feligres_id" name="feligres_id" required="">
                                            <option value="">-- Seleccione una opción --</option>
                                            @foreach($feligreses as $key=>$value)
                                            <option value="{{$key}}">{{$value}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <div class="form-line">
                                        <label>Contenido del Anuncio</label>
                                        <textarea id="tinymce" name="contenido"></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <div class="form-line">
                                        <label class="control-label">Asociación</label>
                                        <select class="form-control"  style="width: 100%;" id="asociacion_id" name="asociacion_id" onchange="getDistritos(this.id, 'distrito_id', 'iglesia_id')">
                                            <option value="">-- Seleccione una opción --</option>
                                            @foreach($asociaciones as $key=>$value)
                                            <option value="{{$key}}">{{$value}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <div class="form-line">
                                        <label class="control-label">Distrito</label>
                                        <select class="form-control"  style="width: 100%;" id="distrito_id" name="distrito_id" onchange="getIglesias(this.id, 'iglesia_id')"></select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <div class="form-line">
                                        <label class="control-label">Iglesia/Grupo</label>
                                        <select class="form-control"  style="width: 100%;" id="iglesia_id" name="iglesia_id"></select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <div class="form-line">
                                        <label class="control-label">Imagen del Anuncio, se recomienda en alta calidad(más de 1080x720 px) (Opcional)</label>
                                        <br/><input class="form-control" type="file" name="imagen">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <br/><br/><a href="{{route('anuncios.index')}}" class="btn bg-red waves-effect">Cancelar</a>
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
                <h4 class="modal-title" id="defaultModalLabel">SOBRE LOS ANUNCIOS</h4>
            </div>
            <div class="modal-body">
                <strong>Detalles: </strong>Administre el boletín de anuncios para cada sábado o semana, cambie los estados o elimine un anuncio cuando no quiera que aparezca en el proyector.
                <br>
                Tenga en cuenta que debe elegir el tipo de anuncio entre LOCAL, DISTRITAL o ASOCIACIÓN dependiendo del alcance que quiera que tenga el anuncio.
                Si el anuncio es LOCAL, debe elegir a que iglesia se aplicará el anuncio, si es DISTRITO debe indicar el distrito al que aplicará el anuncio y si es ASOCIACIÓN, el anuncio aplicará para todas las iglesias de dicha asociación.
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

    $(function () {
        //TinyMCE
        tinymce.init({
            selector: "textarea#tinymce",
            theme: "modern",
            height: 300,
            plugins: [
                'advlist autolink lists link image charmap print preview hr anchor pagebreak',
                'searchreplace wordcount visualblocks visualchars code fullscreen',
                'insertdatetime media nonbreaking save table contextmenu directionality',
                'emoticons template paste textcolor colorpicker textpattern imagetools'
            ],
            toolbar1: 'insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image',
            toolbar2: 'print preview media | forecolor backcolor emoticons',
            image_advtab: true
        });
        tinymce.suffix = ".min";
        tinyMCE.baseURL = '../../../public/js/tinymce';
    });

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

    function alcance() {
        var tipo = $("#tipo").val();
        switch (tipo) {
            case 'LOCAL':
                $("#iglesia_id").attr('required', 'required');
                $("#distrito_id").removeAttr('required');
                $("#asociacion_id").removeAttr('required');
                break;
            case 'DISTRITO':
                $("#distrito_id").attr('required', 'required');
                $("#iglesia_id").removeAttr('required');
                $("#asociacion_id").removeAttr('required');
                break;
            case 'ASOCIACION':
                $("#asociacion_id").attr('required', 'required');
                $("#iglesia_id").removeAttr('required');
                $("#distrito_id").removeAttr('required');
                break;
            default:
                break;
        }
    }

</script>
@endsection