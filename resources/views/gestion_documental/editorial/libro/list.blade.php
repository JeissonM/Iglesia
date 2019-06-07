@extends('layouts.admin')
@section('breadcrumb')
<ol class="breadcrumb breadcrumb-bg-blue-grey" style="margin-bottom: 30px;">
    <li><a href="{{route('inicio')}}">Inicio</a></li>
    <li><a href="{{route('admin.gestiondocumental')}}">Gestión Documental</a></li>
    <li><a href="{{route('admin.editorial')}}">Editorial</a></li>
    <li><a href="{{route('libro.index')}}">Libros</a></li>
</ol>
@endsection
@section('content')
<div class="row clearfix">
    <div class="col-md-12">
        <div class="card">
            <div class="header">
                <h2>
                    LIBROS<small>Haga clic en el botón de 3 puntos de la derecha de este título para agregar un nuevo registro.</small>
                </h2>
                <ul class="header-dropdown m-r--5">
                    <li class="dropdown">
                        <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                            <i class="material-icons">more_vert</i>
                        </a>
                        <ul class="dropdown-menu pull-right">
                            <li><a href="{{ route('libro.create') }}">Agregar Nuevo Libro</a></li>
                            <li><a data-toggle="modal" data-target="#mdModal">Ayuda</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
            <div class="body">
                <div class="row">
                    @foreach($libros as $m)
                    <div class="col-sm-6 col-md-3">
                        <div class="thumbnail">
                            @if($m->imagen == 'no')
                            <img src="{{asset('img/banner01.jpg')}}">
                            @else
                            <img src="{{asset('docs/img_libros/'.$m->imagen)}}">
                            @endif
                            <div class="caption">
                                <h3>{{$m->titulo}}</h3>
                                <p>{{$m->resumen}}</p>
                                <p><b>CATEGORÍA:</b> {{$m->categorialibro->nombre}}</p>
                                @foreach($libros->autores as $a)
                                <p><b>AUTOR:</b> {{$a->autor}}</p>
                                @endforeach
                                <p>
                                    <a href="{{ route('libro.editdoc',$m->id)}}" class="btn bg-blue waves-effect btn-xs" data-toggle="tooltip" data-placement="top" title="Cambiar Documento"><i class="material-icons">library_books</i></a>
                                    <a href="{{ route('libro.editimg',$m->id)}}" class="btn bg-lime waves-effect btn-xs" data-toggle="tooltip" data-placement="top" title="Cambiar Imagen"><i class="material-icons">recent_actors</i></a>
                                    <a href="{{ route('libro.show',$m->id)}}" class="btn bg-green waves-effect btn-xs" data-toggle="tooltip" data-placement="top" title="Ver Libro"><i class="material-icons">remove_red_eye</i></a>
                                    <a href="{{ route('libro.edit',$m->id)}}" class="btn bg-indigo waves-effect btn-xs" data-toggle="tooltip" data-placement="top" title="Editar Libro"><i class="material-icons">mode_edit</i></a>
                                    <a href="{{ route('libro.delete',$m->id)}}" class="btn bg-red waves-effect btn-xs" data-toggle="tooltip" data-placement="top" title="Eliminar Libro"><i class="material-icons">delete</i></a>
                                </p>
                            </div>
                        </div>
                    </div>
                    @endforeach
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
                <h4 class="modal-title" id="defaultModalLabel">SOBRE LOS LIBROS</h4>
            </div>
            <div class="modal-body">
                <strong>Detalles: </strong>Administre los libros.
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
    });
</script>
@endsection                         