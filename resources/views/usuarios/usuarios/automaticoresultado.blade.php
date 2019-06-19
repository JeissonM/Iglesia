@extends('layouts.admin')
@section('breadcrumb')
<ol class="breadcrumb breadcrumb-bg-blue-grey" style="margin-bottom: 30px;">
    <li><a href="{{route('inicio')}}">Inicio</a></li>
    <li><a href="{{route('admin.usuarios')}}">Usuarios</a></li>
    <li><a href="{{route('usuario.automatico')}}">Crear Usuario (Proceso masivo)</a></li>
    <li class="active"><a>Resultados del proceso</a></li>
</ol>
@endsection
@section('content')
<div class="row clearfix">
    <div class="col-md-12">
        <div class="card">
            <div class="header">
                <h2>
                    USUARIOS DEL SISTEMA - CREAR USUARIO PROCESO MASIVO (RESULTADOS DEL PROCESO)
                </h2>
            </div>
            <div class="body">
                <div class="col-md-12">
                    @component('layouts.errors')
                    @endcomponent
                </div>
                <div class="row clearfix">
                    <div class="col-md-12">
                        <div class="col-md-12" style="margin-top: 40px;">
                            <h4>Proceso finalizado. Los resultados fueron cargados en un archivo que puede descargar desde el siguiente enlace: <a href="{{asset('docs/usuarios/'.$response['archivo'])}}" target="_blank">Descargar Archivo</a></h4>
                        </div>
                        <div class="col-md-12" style="margin-top: 20px; background-color: #000000;">
                            <h4>Resultado Proceso</h4>
                            <br/>
                            @foreach($response['resultado'] as $r)
                            <p>{{$r}}</p>
                            @endforeach
                        </div>
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