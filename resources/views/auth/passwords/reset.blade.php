@extends('layouts.app')

@section('content')
<div class="card">
    <div class="body">
        @if (session('status'))
        <div class="alert alert-success" role="alert">
            {{ session('status') }}
        </div>
        @endif
        <form method="POST" class="form-horizontal" action="{{ route('password.update') }}">
            @csrf
            <input type="hidden" name="token" value="{{ $token }}">
            <div class="msg">Escriba el correo electrónico asociado a la cuenta y la nueva contraseña para reestablecer la cuenta de usuario.</div>
            <div class="input-group">
                <span class="input-group-addon">
                    <i class="material-icons">email</i>
                </span>
                <div class="form-line">
                    <input id="email" placeholder="E-mail de la cuenta" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ $email ?? old('email') }}" required autofocus>
                </div>
                @if ($errors->has('email'))
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('email') }}</strong>
                </span>
                @endif
            </div>
            <div class="input-group">
                <span class="input-group-addon">
                    <i class="material-icons">lock_open</i>
                </span>
                <div class="form-line">
                    <input id="password" placeholder="Contraseña nueva" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required>
                </div>
                @if ($errors->has('password'))
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('password') }}</strong>
                </span>
                @endif
            </div>
            <div class="input-group">
                <span class="input-group-addon">
                    <i class="material-icons">lock_open</i>
                </span>
                <div class="form-line">
                    <input id="password-confirm" placeholder="Confirmar contraseña" type="password" class="form-control" name="password_confirmation" required>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <button class="btn btn-block bg-pink waves-effect" type="submit">REESTABLECER CONTRASEÑA</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
