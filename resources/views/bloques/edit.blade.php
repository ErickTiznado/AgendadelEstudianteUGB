@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Editar Bloque</h2>
    <form action="{{ route('bloques.update', $bloque->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="tipo">Tipo</label>
            <input type="text" name="tipo" value="{{ $bloque->tipo }}" class="form-control" required>
        </div>
        <div class="form-group">
    <label for="inicio">Inicio</label>
    <input type="time" name="inicio" value="{{ substr($bloque->inicio, 0, 5) }}" class="form-control" required>
</div>
<div class="form-group">
    <label for="fin">Fin</label>
    <input type="time" name="fin" value="{{ substr($bloque->fin, 0, 5) }}" class="form-control" required>
</div>
        <div class="form-group">
            <label for="dia_semana">Día de la semana</label>
            <input type="text" name="dia_semana" value="{{ $bloque->dia_semana }}" class="form-control" required>
        </div>
        @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
        <div class="form-group">
            <label for="notas">Notas</label>
            <textarea name="notas" class="form-control">{{ $bloque->notas }}</textarea>
        </div>
        <button type="submit" class="btn btn-primary">Actualizar</button>
    </form>
</div>
@endsection
