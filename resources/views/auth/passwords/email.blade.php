@extends('layouts.app')

@section('content')
<div class="card">
    <div class="body">
        @if (session('status'))
        <div class="alert alert-success" role="alert">
            {{ session('status') }}
        </div>
        @endif
        <form method="POST" class="form-horizontal" action="{{ route('password.email') }}">
            @csrf
            <div class="msg">Escriba el correo electrónico asociado a la cuenta para reestablecer la contraseña</div>
            <div class="input-group">
                <span class="input-group-addon">
                    <i class="material-icons">email</i>
                </span>
                <div class="form-line">
                    <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required>
                </div>
                @if ($errors->has('email'))
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('email') }}</strong>
                </span>
                @endif
            </div>
            <div class="row">
                <div class="col-md-12">
                    <button class="btn btn-block bg-pink waves-effect" type="submit">ENVIAR ENLACE A MI CORREO</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
