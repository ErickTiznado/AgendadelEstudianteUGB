@extends('layouts.app')

@section('content')
<link rel="stylesheet" href="{{ asset('css\auth.css') }}">

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Registro') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('register') }}">
                        @csrf

                        <!-- Campo Nombre Completo -->
                        <div class="form-group row">
                            <label for="nombre_completo" class="col-md-4 col-form-label text-md-right">{{ __('Nombre Completo') }}</label>

                            <div class="col-md-6">
                                <input id="nombre_completo" type="text" class="form-control @error('nombre_completo') is-invalid @enderror" name="nombre_completo" value="{{ old('nombre_completo') }}" required autocomplete="nombre_completo" autofocus>

                                @error('nombre_completo')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <!-- Campo Código de Estudiante -->
                        <div class="form-group row">
                            <label for="codigo_estudiante" class="col-md-4 col-form-label text-md-right">{{ __('Código de Estudiante') }}</label>

                            <div class="col-md-6">
                                <input id="codigo_estudiante" type="text" class="form-control @error('codigo_estudiante') is-invalid @enderror" name="codigo_estudiante" value="{{ old('codigo_estudiante') }}" required autocomplete="codigo_estudiante">

                                @error('codigo_estudiante')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <!-- Campo Correo Institucional -->
                        <div class="form-group row">
                            <label for="correo_institucional" class="col-md-4 col-form-label text-md-right">{{ __('Correo Institucional') }}</label>

                            <div class="col-md-6">
                                <input id="correo_institucional" type="email" class="form-control @error('correo_institucional') is-invalid @enderror" name="correo_institucional" value="{{ old('correo_institucional') }}" required autocomplete="correo_institucional">

                                @error('correo_institucional')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <!-- Campo Contraseña -->
                        <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Contraseña') }}</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <!-- Campo Confirmar Contraseña -->
                        <div class="form-group row">
                            <label for="password-confirm" class="col-md-4 col-form-label text-md-right">{{ __('Confirmar Contraseña') }}</label>

                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                            </div>
                        </div>

                        <!-- Botón de Registro -->
                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Registrar') }}
                                </button>
                                <div class="mt-2">
                                    <p>Aun no tienes cuenta? <a href="#" class="text-info">{{ __('Has click aqui') }}</a></p>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
