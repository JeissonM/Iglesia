@extends('layouts.app')

@section('content')
<div class="card">
    <div class="body">
        <form id="sign_in" class="form-horizontal" method="POST" action="{{ route('login') }}">
            {{ csrf_field() }}
            <div class="msg">Proporcione sus credenciales para ingresar al sistema</div>
            <div class="input-group {{ $errors->has('identificacion') ? ' has-error' : '' }}">
                <span class="input-group-addon">
                    <i class="material-icons">person</i>
                </span>
                <div class="form-line">
                    <input type="text" value="{{ old('identificacion') }}" class="form-control" name="identificacion" placeholder="Identificación" required autofocus>
                </div>
                @if ($errors->has('identificacion'))
                <span class="help-block">
                    <strong>{{ $errors->first('identificacion') }}</strong>
                </span>
                @endif
            </div>
            <div class="input-group {{ $errors->has('password') ? ' has-error' : '' }}">
                <span class="input-group-addon">
                    <i class="material-icons">lock</i>
                </span>
                <div class="form-line">
                    <input type="password" class="form-control" name="password" placeholder="Contraseña" required>
                </div>
                @if ($errors->has('password'))
                <span class="help-block">
                    <strong>{{ $errors->first('password') }}</strong>
                </span>
                @endif
            </div>
            <div class="row">
                <div class="col-xs-6">
                    <button class="btn btn-block bg-pink waves-effect" type="submit">INGRESAR</button>
                </div>
                <div class="col-xs-6">
                    <a href="{{url('/')}}" class="btn btn-block bg-pink waves-effect" >VOLVER</a>
                </div>
            </div>
            <div class="row m-t-15 m-b--20">
                <div class="col-xs-12">
                    <a href="{{ route('password.request') }}">¿Olvidaste la Contraseña?</a>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection